<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use FedaPay\Error\Authentication;
use FedaPay\Error\InvalidRequest;
use FedaPay\Error\ApiConnection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function __construct()
    {
        // Configuration FedaPay
        try {
            FedaPay::setApiVersion('v1');
            FedaPay::setEnvironment(config('services.fedapay.mode', 'sandbox'));
            FedaPay::setApiKey(config('services.fedapay.secret_key'));
            
            Log::info('FedaPay configuré avec succès', [
                'mode' => config('services.fedapay.mode', 'sandbox'),
                'key_defined' => !empty(config('services.fedapay.secret_key')),
                'key_length' => strlen(config('services.fedapay.secret_key') ?? '')
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur configuration FedaPay:', [
                'message' => $e->getMessage()
            ]);
        }
    }




       /**
     * Enregistre une nouvelle réservation et initie le paiement
     */
    public function store(Request $request)
    {
        Log::info('=== NOUVELLE RÉSERVATION ===', [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['_token'])
        ]);

        // Utiliser une transaction de base de données pour garantir la cohérence
        return DB::transaction(function () use ($request) {
            try {
                // Validation des données
                $validatedData = $request->validate([
                    'car_id' => 'required|exists:cars,id',
                    'reservation_start_date' => 'required|date|after_or_equal:today',
                    'reservation_end_date' => 'required|date|after:reservation_start_date',
                    'reservation_start_time' => 'required|date_format:H:i',
                    'with_driver' => 'required|boolean',
                    'client_email' => 'required|email',
                    'client_phone' => 'required|string|min:8|regex:/^(\+[0-9]{1,3}[- ]?)?([0-9]{2,4}[- ]?){2,5}[0-9]{2,4}$/',
                    'client_location' => 'required|string|max:255',      // ← Nouveau champ
                    'deployment_zone' => 'required|string|max:100',   
                    'terms_accepted' => 'required|accepted'
                ]);

                Log::info('✅ Validation réussie', $validatedData);

                $car = Car::findOrFail($validatedData['car_id']);
                
                // Créer les DateTime complets
                $startDateTime = Carbon::parse($validatedData['reservation_start_date'] . ' ' . $validatedData['reservation_start_time']);
                $endDateTime = Carbon::parse($validatedData['reservation_end_date'] . ' ' . $validatedData['reservation_start_time']);

                // ✅ CALCUL SERVEUR AUTORITAIRE DES PRIX AVEC RÉDUCTIONS CORRIGÉES
                $priceCalculation = $this->calculateReservationPrice($car, $startDateTime, $endDateTime, $validatedData['with_driver']);
                
                Log::info('💰 CALCULS SERVEUR AUTORITAIRES (avec réductions):', $priceCalculation);

                // Vérification de disponibilité
                if (!$this->isCarAvailable($car, $startDateTime, $endDateTime)) {
                    Log::warning('⚠️ Conflit de disponibilité détecté');
                    return $this->handleError($request, 'Cette voiture n\'est plus disponible pour cette période.');
                }

                // ✅ CRÉATION DE LA RÉSERVATION AVEC CALCULS EXACTS
                $reservation = $this->createReservation($validatedData, $car, $startDateTime, $endDateTime, $priceCalculation);
                
                Log::info('✅ Réservation créée avec calculs corrects:', [
                    'reservation_id' => $reservation->id,
                    'total_days' => $reservation->total_days,
                    'daily_rate' => $reservation->daily_rate,
                    'subtotal' => $reservation->subtotal,
                    'discount_percentage' => $reservation->discount_percentage,
                    'discount_amount' => $reservation->discount_amount,
                    'final_total' => $reservation->final_total,
                    'fedapay_will_charge' => $reservation->final_total
                ]);


                // ✅ CRÉATION TRANSACTION FEDAPAY AVEC LE BON MONTANT
                $transaction = $this->createFedaPayTransaction($reservation, $request, $car);
                
                $reservation->update(['fedapay_transaction_id' => $transaction->id]);

                $checkoutToken = $transaction->generateToken();
                $checkoutUrl = $checkoutToken->url;

                Log::info('💳 Checkout URL généré avec montant final correct:', [
                    'url' => $checkoutUrl,
                    'amount_to_charge' => $reservation->final_total,
                    'transaction_id' => $transaction->id
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'checkout_url' => $checkoutUrl,
                        'reservation_id' => $reservation->id,
                        'amount' => $reservation->final_total
                    ]);
                }

                return redirect($checkoutUrl);

            } catch (\Exception $e) {
                Log::error('❌ Erreur générale:', [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => basename($e->getFile())
                ]);
                
                return $this->handleError($request, 'Une erreur est survenue lors de la création de la réservation');
            }
        });
    }


     /**
     * ✅ CALCUL SERVEUR AUTORITAIRE DES PRIX AVEC RÉDUCTIONS
     */
    private function calculateReservationPrice(Car $car, Carbon $startDateTime, Carbon $endDateTime, bool $withDriver): array
    {
        // ⭐ CORRECTION MAJEURE : Calcul du nombre de jours inclusif
        $totalDays = $startDateTime->diffInDays($endDateTime);
        
        Log::info('📅 Calcul des jours corrigé:', [
            'start_date' => $startDateTime->toDateString(),
            'end_date' => $endDateTime->toDateString(),
            'diffInDays' => $startDateTime->diffInDays($endDateTime),
            'total_days_calculated' => $totalDays
        ]);
        
        // Déterminer le tarif journalier
        $dailyRate = $withDriver ? 
            ($car->daily_price_with_driver ?? 30000.00) : 
            ($car->daily_price_without_driver ?? 20000.00);
        
        // Calcul du sous-total
        $subtotal = $totalDays * $dailyRate;
        
        // ✅ CALCUL DES RÉDUCTIONS - IDENTIQUE AU MODÈLE
        $discountPercentage = 0;
        if ($totalDays >= 14) {
            $discountPercentage = 20.0;
        } elseif ($totalDays >= 10) {
            $discountPercentage = 18.0;
        } elseif ($totalDays >= 7) {
            $discountPercentage = 15.0;
        }
        
        // ✅ CALCULS PRÉCIS AVEC ARRONDI
        $discountAmount = round($subtotal * ($discountPercentage / 100), 2);
        $finalTotal = $subtotal - $discountAmount;
        
        Log::info('💰 CALCUL PRIX SERVEUR FINAL:', [
            'withDriver' => $withDriver,
            'dailyRate' => $dailyRate,
            'totalDays' => $totalDays,
            'subtotal' => $subtotal,
            'discountPercentage' => $discountPercentage,
            'discountAmount' => $discountAmount,
            'finalTotal' => $finalTotal,
            'test_cas_14_jours' => [
                'should_be_336000_for_30k_daily' => ($totalDays === 14 && $dailyRate == 30000),
                'calculation' => "14 jours × 30000 = 420000, -20% (84000) = 336000"
            ]
        ]);
        
        return [
            'total_days' => $totalDays,
            'daily_rate' => $dailyRate,
            'subtotal' => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'final_total' => $finalTotal,
            'with_driver' => $withDriver
        ];
    }

      /**
     * Vérification de disponibilité
     */
    private function isCarAvailable(Car $car, Carbon $startDateTime, Carbon $endDateTime): bool
    {
        return !$car->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereRaw('? < CONCAT(reservation_end_date, " ", reservation_end_time) AND ? > CONCAT(reservation_start_date, " ", reservation_start_time)', 
                    [$startDateTime->format('Y-m-d H:i:s'), $endDateTime->format('Y-m-d H:i:s')]);
            })
            ->exists();
    }

     /**
     * Création de la réservation avec tous les calculs
     */
    private function createReservation(array $validatedData, Car $car, Carbon $startDateTime, Carbon $endDateTime, array $priceCalculation): Reservation
    {
        $reservation = new Reservation();
        
        // Données de base
        $reservation->user_id = Auth::id();
        $reservation->car_id = $car->id;
        $reservation->reservation_start_date = $startDateTime->toDateString();
        $reservation->reservation_end_date = $endDateTime->toDateString();
        $reservation->reservation_start_time = $startDateTime->toTimeString();
        $reservation->reservation_end_time = $endDateTime->toTimeString(); // ✅ Même heure
        
        // ✅ CALCULS EXACTS AVEC RÉDUCTIONS
        $reservation->total_days = $priceCalculation['total_days'];
        $reservation->daily_rate = $priceCalculation['daily_rate'];
        $reservation->subtotal = $priceCalculation['subtotal'];
        $reservation->discount_percentage = $priceCalculation['discount_percentage'];
        $reservation->discount_amount = $priceCalculation['discount_amount'];
        $reservation->final_total = $priceCalculation['final_total'];
        
        // Autres données
        $reservation->with_driver = $validatedData['with_driver'];
        $reservation->status = 'pending';
        $reservation->payment_status = 'pending';
        $reservation->terms_accepted = true;
        $reservation->client_email = $validatedData['client_email'];
        $reservation->client_phone = $validatedData['client_phone'];
        $reservation->client_location = $validatedData['client_location'];
        $reservation->deployment_zone = $validatedData['deployment_zone'];

        // Sauvegarder sans déclencher les événements automatiques
        $reservation->saveQuietly();

        return $reservation;
    }

       /**  * ✅ CRÉATION TRANSACTION FEDAPAY AVEC MONTANT CORRECT
     */
    private function createFedaPayTransaction(Reservation $reservation, Request $request, Car $car)
    {
        $secretKey = config('services.fedapay.secret_key');
        $mode = config('services.fedapay.mode', 'sandbox');
        
        if (!$secretKey) {
            throw new \Exception('Configuration FedaPay manquante: secret_key non définie');
        }

        try {
            // Configuration de FedaPay
            FedaPay::setApiVersion('v1');
            FedaPay::setEnvironment($mode);
            FedaPay::setApiKey($secretKey);

            // Préparation des données client
            $customerData = [
                'firstname' => Auth::user()->name ?? 'Client',
                'lastname' => 'Rentaly',
                'email' => $request->client_email,
            ];

            // Traitement du numéro de téléphone
            $phoneNumber = $request->client_phone;
            if ($phoneNumber && strlen($phoneNumber) >= 8) {
                $cleanPhone = preg_replace('/[^0-9+]/', '', $phoneNumber);
                
                if (!str_starts_with($cleanPhone, '+')) {
                    if (str_starts_with($cleanPhone, '229')) {
                        $cleanPhone = '+' . $cleanPhone;
                    } else if (strlen($cleanPhone) === 8) {
                        $cleanPhone = '+229' . $cleanPhone;
                    }
                }
                
                $customerData['phone_number'] = [
                    'number' => $cleanPhone,
                    'country' => 'BJ'
                ];
            }

            // ✅ MONTANT CRITIQUE : Final total avec réductions appliquées
            $amountToCharge = (int) round($reservation->final_total);
            
            if ($amountToCharge <= 0) {
                throw new \Exception('Montant de transaction invalide: ' . $amountToCharge);
            }

            // Description détaillée
            $typeText = $reservation->with_driver ? 'avec chauffeur' : 'sans chauffeur';
            $description = "Réservation {$car->getFullName()} ({$typeText}) - {$reservation->total_days} jour(s)";
            
            if ($reservation->discount_percentage > 0) {
                $description .= " - Réduction {$reservation->discount_percentage}% appliquée";
            }
            
            $transactionData = [
                'description' => $description,
                'amount' => $amountToCharge, // ✅ MONTANT FINAL AVEC RÉDUCTION
                'currency' => ['iso' => 'XOF'],
                'customer' => $customerData,
                'callback_url' => route('reservations.payment.callback'),
                'cancel_url' => route('reservations.payment.cancel', $reservation->id),
                'webhook_url' => route('reservations.payment.webhook'),
                'custom_metadata' => [
                    'reservation_id' => $reservation->id,
                    'user_id' => Auth::id(),
                    'car_id' => $car->id,
                    'with_driver' => $reservation->with_driver ? 'true' : 'false',
                    'total_days' => $reservation->total_days,
                    'subtotal' => $reservation->subtotal,
                    'discount_percentage' => $reservation->discount_percentage,
                    'discount_amount' => $reservation->discount_amount,
                    'final_total' => $reservation->final_total,
                    'daily_rate' => $reservation->daily_rate
                ]
            ];

            Log::info('📋 TRANSACTION FEDAPAY - MONTANT FINAL CONFIRMÉ:', [
                'amount_to_charge' => $amountToCharge,
                'breakdown' => [
                    'daily_rate' => $reservation->daily_rate,
                    'total_days' => $reservation->total_days,
                    'subtotal' => $reservation->subtotal,
                    'discount_percentage' => $reservation->discount_percentage,
                    'discount_amount' => $reservation->discount_amount,
                    'final_total' => $reservation->final_total
                ],
                'description' => $description
            ]);

            $transaction = Transaction::create($transactionData);
            
            Log::info('✅ Transaction FedaPay créée avec succès:', [
                'transaction_id' => $transaction->id,
                'amount_charged' => $amountToCharge,
                'status' => $transaction->status ?? 'unknown'
            ]);

            return $transaction;

        } catch (\Exception $e) {
            Log::error('❌ Erreur création transaction FedaPay:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'amount_expected' => $reservation->final_total
            ]);
            throw $e;
        }
    }

      /**
     * Gestion des erreurs
     */
    private function handleError(Request $request, string $message)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }
        
        return redirect()->back()->with('error', $message)->withInput();
    }


    public function verifyPricing(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'car_id' => 'required|exists:cars,id',
                'reservation_start_date' => 'required|date',
                'reservation_end_date' => 'required|date|after:reservation_start_date',
                'reservation_start_time' => 'required|date_format:H:i',
                'with_driver' => 'required|boolean'
            ]);

            $car = Car::findOrFail($validatedData['car_id']);
            
            $startDateTime = Carbon::parse($validatedData['reservation_start_date'] . ' ' . $validatedData['reservation_start_time']);
            $endDateTime = Carbon::parse($validatedData['reservation_end_date'] . ' ' . $validatedData['reservation_start_time']);

            // Calcul serveur autoritaire
            $pricing = $this->calculateReservationPrice($car, $startDateTime, $endDateTime, $validatedData['with_driver']);

            Log::info('💰 Vérification pricing AJAX:', $pricing);

            return response()->json([
                'success' => true,
                'pricing' => $pricing,
                'car_info' => [
                    'name' => $car->getFullName(),
                    'daily_price_without_driver' => $car->daily_price_without_driver,
                    'daily_price_with_driver' => $car->daily_price_with_driver
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Erreur vérification pricing:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification des prix'
            ], 500);
        }
    }

    /**
     * Affiche la liste des réservations de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Réservations actives
        $activeReservations = $user->reservations()
            ->with('car')
            ->where('status', 'active')
            ->where('payment_status', 'paid')
            ->orderBy('reservation_end_date', 'asc')
            ->orderBy('reservation_end_time', 'asc')
            ->get();
        
        // Réservations en attente de paiement
        $pendingReservations = $user->reservations()
            ->with('car')
            ->where('status', 'pending')
            ->where('payment_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Réservations passées/terminées
        $pastReservations = $user->reservations()
            ->with('car')
            ->whereIn('status', ['expired', 'completed'])
            ->orderBy('reservation_end_date', 'desc')
            ->orderBy('reservation_end_time', 'desc')
            ->paginate(10);
        
        return view('reservations.index', compact(
            'activeReservations', 
            'pendingReservations', 
            'pastReservations'
        ));
    }

    /**
     * Affiche les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette réservation.');
        }

        $reservation->load('car');
        
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Annule une réservation
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette réservation.');
        }

        if (!$reservation->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        // 🔥 CORRECTION : Remettre la voiture disponible lors de l'annulation
        if ($reservation->car) {
            $reservation->car->update(['status' => 'available']);
            Log::info('Voiture remise disponible après annulation', [
                'car_id' => $reservation->car_id,
                'reservation_id' => $reservation->id
            ]);
        }

        $reservation->delete();

        return redirect()->route('dashboard')
            ->with('success', 'La réservation a été annulée avec succès.');
    }

    /**
     * Affiche le formulaire de réservation
     */
    public function create(Car $car)
    {
        if (!$car->isAvailable()) {
            return redirect()->route('home')->with('error', 'Cette voiture n\'est plus disponible.');
        }

        // Récupérer les réservations existantes pour le calendrier
        $existingReservations = $car->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->get()
            ->map(function($reservation) {
                return [
                    'start' => $reservation->reservation_start_date,
                    'end' => $reservation->reservation_end_date
                ];
            });

        // Tarifs journaliers
        $dailyRates = [
            'without_driver' => $car->daily_price_without_driver ,
            'with_driver' => $car->daily_price_with_driver 
        ];

        return view('reservations.create', compact('car', 'existingReservations', 'dailyRates'));
    }

    /**
     * Vérifie la disponibilité d'une voiture pour une période donnée
     */
 public function checkAvailability(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'with_driver' => 'required|boolean'
        ]);

        $car = Car::findOrFail($request->car_id);
        
        $startDateTime = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endDateTime = Carbon::parse($request->end_date . ' ' . $request->start_time);

        // Vérifier les conflits
        $conflicts = $car->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereRaw('? < CONCAT(reservation_end_date, " ", reservation_end_time) AND ? > CONCAT(reservation_start_date, " ", reservation_start_time)', [$startDateTime, $endDateTime]);
            })
            ->get(['reservation_start_date', 'reservation_end_date']);

        if ($conflicts->count() > 0) {
            return response()->json([
                'available' => false,
                'conflicts' => $conflicts->map(function($conflict) {
                    return [
                        'start' => Carbon::parse($conflict->reservation_start_date)->format('d/m/Y'),
                        'end' => Carbon::parse($conflict->reservation_end_date)->format('d/m/Y')
                    ];
                })
            ]);
        }

        // 🔥 CORRECTION: Utiliser calculateReservationPrice pour obtenir les bons calculs
        $priceInfo = $car->calculateReservationPrice(
            $startDateTime,
            $endDateTime,
            $request->with_driver
        );

        Log::info('💰 Prix calculé pour vérification disponibilité:', $priceInfo);

        return response()->json([
            'available' => true,
            'price_info' => $priceInfo
        ]);
    }

    /**
     * API pour obtenir le temps restant d'une réservation
     */
    public function getTimeRemaining(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }
        
        $now = Carbon::now();
        $startDateTime = $reservation->getStartDateTime();
        $endDateTime = $reservation->getEndDateTime();
        
        if ($now->greaterThan($endDateTime)) {
            return response()->json([
                'expired' => true,
                'message' => 'Réservation expirée',
                'status' => 'expired'
            ]);
        }
        
        if ($now->lessThan($startDateTime)) {
            $timeToStart = $startDateTime->diff($now);
            return response()->json([
                'expired' => false,
                'status' => 'scheduled',
                'starts_in' => [
                    'days' => $timeToStart->days,
                    'hours' => $timeToStart->h,
                    'minutes' => $timeToStart->i,
                    'seconds' => $timeToStart->s
                ],
                'total_seconds_to_start' => $startDateTime->diffInSeconds($now)
            ]);
        }
        
        // Réservation en cours
        $timeRemaining = $endDateTime->diff($now);
        $totalSeconds = $endDateTime->diffInSeconds($now);
        
        return response()->json([
            'expired' => false,
            'status' => 'active',
            'time_remaining' => [
                'days' => $timeRemaining->days,
                'hours' => $timeRemaining->h,
                'minutes' => $timeRemaining->i,
                'seconds' => $timeRemaining->s
            ],
            'total_seconds' => $totalSeconds
        ]);
    }

    /**
     * Gère l'annulation de paiement
     */
    public function paymentCancel($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        
        if ($reservation && $reservation->user_id === Auth::id()) {
            $reservation->delete();
        }

        return redirect()->route('home')->with('info', 'Paiement annulé. Votre réservation a été supprimée.');
    }

    /**
     * Gère le retour après paiement FedaPay
     */
    public function paymentCallback(Request $request)
    {
        Log::info('PaymentCallback reçu:', $request->all());

        try {
            $transactionId = $request->get('transaction_id') ?? $request->get('id');
            
            if (!$transactionId) {
                Log::error('Transaction ID manquant dans le callback');
                return redirect()->route('dashboard')
                    ->with('error', 'Erreur: ID de transaction manquant.');
            }

            // Configurer FedaPay
            FedaPay::setEnvironment(config('services.fedapay.mode', 'sandbox'));
            FedaPay::setApiKey(config('services.fedapay.secret_key'));
            
            // Récupérer la transaction
            $transaction = Transaction::retrieve($transactionId);
            
            // Trouver la réservation
            $reservation = Reservation::where('fedapay_transaction_id', $transactionId)->first();
            
            if (!$reservation) {
                Log::error('Réservation non trouvée:', ['transaction_id' => $transactionId]);
                return redirect()->route('dashboard')
                    ->with('error', 'Réservation non trouvée.');
            }

            if ($reservation->user_id !== Auth::id()) {
                abort(403, 'Accès non autorisé.');
            }

            // Traiter selon le statut
            switch ($transaction->status) {
                case 'approved':
                    $reservation->update([
                        'status' => 'active',
                        'payment_status' => 'paid',
                        'payment_method' => 'fedapay'
                    ]);
                    $reservation->car->update(['status' => 'reserved']);
                    // Si c'est une extension, mettre à jour la réservation originale
                    if ($reservation->extension_of) {
                        $originalReservation = $this->processExtensionApproval($reservation);
                        
                        Log::info('Extension approuvée via callback:', [
                            'extension_id' => $reservation->id,
                            'original_id' => $reservation->extension_of
                        ]);

                        if ($originalReservation) {
                            return redirect()->route('reservations.show', $originalReservation)
                                ->with('success', 'Extension confirmée ! Votre réservation a été prolongée jusqu\'au ' . 
                                       $originalReservation->getEndDateTime()->format('d/m/Y à H:i'));
                        }
                    } else {
                        // Réservation normale - la voiture est déjà marquée comme reserved
                        Log::info('Paiement approuvé - réservation normale activée:', [
                            'reservation_id' => $reservation->id
                        ]);
                    }

                    return redirect()->route('reservations.show', $reservation)
                        ->with('success', 'Paiement confirmé ! Votre réservation est maintenant active.');

                case 'pending':
                    $reservation->update(['payment_status' => 'pending']);
                    return redirect()->route('dashboard')
                        ->with('info', 'Paiement en cours de traitement.');

                case 'declined':
                case 'canceled':
                case 'failed':
                    // Remettre la voiture disponible seulement si ce n'est pas une extension
                    if (!$reservation->extension_of && $reservation->car) {
                        $reservation->car->update(['status' => 'available']);
                    }
                    $reservation->delete();
                    
                    $messages = [
                        'declined' => 'Paiement refusé.',
                        'canceled' => 'Paiement annulé.',
                        'failed' => 'Paiement échoué.'
                    ];
                    
                    $message = $messages[$transaction->status] ?? 'Paiement non abouti.';
                    
                    return redirect()->route('home')->with('error', $message);

                default:
                    Log::warning('Statut de transaction non géré:', ['status' => $transaction->status]);
                    return redirect()->route('dashboard')
                        ->with('warning', 'Statut de paiement non reconnu: ' . $transaction->status);
            }

        } catch (\Exception $e) {
            Log::error('Erreur dans paymentCallback:', [
                'error' => $e->getMessage()
            ]);

            return redirect()->route('dashboard')
                ->with('error', 'Une erreur est survenue lors du traitement de votre paiement.');
        }
    }

    /**
     * Webhook pour les notifications FedaPay
     */
    public function paymentWebhook(Request $request)
    {
        $event = $request->all();
        Log::info('Webhook FedaPay reçu:', $event);
        
        if ($event['entity']['entity'] === 'transaction') {
            $transaction = $event['entity'];
            $reservation = Reservation::where('fedapay_transaction_id', $transaction['id'])->first();
            
            if ($reservation) {
                switch ($transaction['status']) {
                    case 'approved':
                        $reservation->update([
                            'status' => 'active',
                            'payment_status' => 'paid',
                            'payment_method' => 'fedapay'
                        ]);
                            // ✅ AJOUTER CETTE LIGNE - Marquer la voiture comme réservée via webhook aussi
                        if (!$reservation->extension_of) { // Seulement pour les nouvelles réservations, pas les extensions
                            $reservation->car->update(['status' => 'reserved']);
                        }
                        // Si c'est une extension, mettre à jour la réservation originale
                        if ($reservation->extension_of) {
                            $this->processExtensionApproval($reservation);
                        }
                        
                        Log::info('Webhook - Réservation activée:', [
                            'reservation_id' => $reservation->id
                        ]);
                        break;
                        
                    case 'declined':
                    case 'canceled':
                        // Remettre la voiture disponible seulement si ce n'est pas une extension
                        if (!$reservation->extension_of && $reservation->car) {
                            $reservation->car->update(['status' => 'available']);
                        }
                        $reservation->delete();
                        
                        Log::info('Webhook - Réservation supprimée:', [
                            'reservation_id' => $reservation->id,
                            'status' => $transaction['status'],
                            'was_extension' => !is_null($reservation->extension_of)
                        ]);
                        break;
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Affiche le formulaire de prolongation d'une réservation
     */
    public function showExtendForm(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette réservation.');
        }
        
        if (!$reservation->canBeExtended()) {
            return redirect()->back()
                ->with('error', $reservation->getExtensionErrorMessage());
        }
        
        $reservation->load('car');
        
        // Calculer les options d'extension
        $currentEndDateTime = $reservation->getEndDateTime();
        $extensionOptions = [];
        
        foreach ([1, 2, 3, 7] as $days) {
            $newEndDateTime = $currentEndDateTime->copy()->addDays($days);
            
            // Vérifier disponibilité
            $available = $this->isCarAvailableForExtension($reservation, $currentEndDateTime, $newEndDateTime);
            
            if ($available) {
                $priceCalculation = $reservation->car->calculateReservationPrice(
                    $currentEndDateTime,
                    $newEndDateTime,
                    $reservation->with_driver
                );
                
                $extensionOptions[$days . '_days'] = [
                    'days' => $days,
                    'available' => true,
                    'price' => $priceCalculation['final_total'],
                    'daily_rate' => $priceCalculation['daily_rate'],
                    'discount' => $priceCalculation['discount_percentage'],
                    'new_end_date' => $newEndDateTime,
                    'price_details' => $priceCalculation
                ];
            } else {
                $extensionOptions[$days . '_days'] = [
                    'days' => $days,
                    'available' => false,
                    'price' => 0,
                    'reason' => 'Voiture non disponible pour cette période'
                ];
            }
        }
        
        return view('reservations.extend', compact('reservation', 'extensionOptions'));
    }

    /**
     * Traite la prolongation d'une réservation
     */
    public function extend(Request $request, Reservation $reservation)
    {
        Log::info('Extension demandée:', [
            'reservation_id' => $reservation->id,
            'request_data' => $request->except('_token')
        ]);

        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette réservation.');
        }
        
        if (!$reservation->canBeExtended()) {
            $errorMessage = $reservation->getExtensionErrorMessage();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMessage]);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
        
        $request->validate([
            'extension_days' => 'required|integer|min:1|max:30',
            'client_email' => 'required|email',
            'client_phone' => 'required|string|min:8',
            'terms_accepted' => 'required|accepted'
        ]);
        
        // Calculer les nouvelles dates
        $currentEndDateTime = $reservation->getEndDateTime();
        $newEndDateTime = $currentEndDateTime->copy()->addDays($request->extension_days);
        
        Log::info('Calcul extension:', [
            'current_end' => $currentEndDateTime->toDateTimeString(),
            'new_end' => $newEndDateTime->toDateTimeString(),
            'extension_days' => $request->extension_days
        ]);
        
        // Vérification finale de disponibilité
        if (!$this->isCarAvailableForExtension($reservation, $currentEndDateTime, $newEndDateTime)) {
            $errorMessage = 'La voiture n\'est pas disponible pour cette période d\'extension.';
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMessage]);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
        
        // Calculer le prix de l'extension
        $priceCalculation = $reservation->car->calculateReservationPrice(
            $currentEndDateTime,
            $newEndDateTime,
            $reservation->with_driver
        );
        
        Log::info('Prix extension calculé:', $priceCalculation);
        
        // Créer la réservation d'extension
        $extensionReservation = Reservation::create([
            'user_id' => Auth::id(),
            'car_id' => $reservation->car_id,
            'reservation_start_date' => $currentEndDateTime->toDateString(),
            'reservation_end_date' => $newEndDateTime->toDateString(),
            'reservation_start_time' => $currentEndDateTime->toTimeString(),
            'reservation_end_time' => $newEndDateTime->toTimeString(),
            'total_days' => $priceCalculation['total_days'],
            'daily_rate' => $priceCalculation['daily_rate'],
            'subtotal' => $priceCalculation['subtotal'],
            'discount_percentage' => $priceCalculation['discount_percentage'],
            'discount_amount' => $priceCalculation['discount_amount'],
            'final_total' => $priceCalculation['final_total'],
            'with_driver' => $reservation->with_driver,
            'status' => 'pending',
            'payment_status' => 'pending',
            'terms_accepted' => true,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'extension_of' => $reservation->id, // 🔗 Lien vers la réservation originale
        ]);
        
        Log::info('Extension créée:', [
            'extension_id' => $extensionReservation->id,
            'original_id' => $reservation->id,
            'price' => $extensionReservation->final_total
        ]);
        
        // Initier le paiement FedaPay
        try {
            $transaction = $this->createFedaPayTransactionForExtension($extensionReservation, $request, $reservation);
            
            $extensionReservation->update([
                'fedapay_transaction_id' => $transaction->id
            ]);
            
            $checkoutToken = $transaction->generateToken();
            $checkoutUrl = $checkoutToken->url;
            
            Log::info('Paiement extension initialisé:', [
                'checkout_url' => $checkoutUrl,
                'transaction_id' => $transaction->id
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'checkout_url' => $checkoutUrl,
                    'extension_id' => $extensionReservation->id,
                    'price_details' => $priceCalculation
                ]);
            }
            
            return redirect($checkoutUrl);
            
        } catch (\Exception $e) {
            if (isset($extensionReservation)) {
                $extensionReservation->delete();
            }
            
            Log::error('Erreur extension FedaPay:', [
                'message' => $e->getMessage(),
                'reservation_id' => $reservation->id,
                'line' => $e->getLine()
            ]);
            
            $errorMessage = 'Erreur lors de l\'initiation du paiement de l\'extension.';
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMessage]);
            }
            
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    /**
     * Crée la transaction FedaPay pour l'extension
     */
    private function createFedaPayTransactionForExtension(Reservation $extensionReservation, Request $request, Reservation $originalReservation)
    {
        $secretKey = config('services.fedapay.secret_key');
        if (!$secretKey) {
            throw new \Exception('Configuration FedaPay manquante');
        }
        
        FedaPay::setApiVersion('v1');
        FedaPay::setEnvironment(config('services.fedapay.mode', 'sandbox'));
        FedaPay::setApiKey($secretKey);
        
        // Préparer les données client
        $customerData = [
            'firstname' => Auth::user()->name ?? 'Client',
            'lastname' => 'Extension',
            'email' => $request->client_email,
        ];

        // Ajouter le téléphone s'il est valide
        $phoneNumber = $request->client_phone;
        if ($phoneNumber && strlen($phoneNumber) >= 8) {
            $cleanPhone = preg_replace('/[^0-9+]/', '', $phoneNumber);
            
            if (!str_starts_with($cleanPhone, '+')) {
                if (str_starts_with($cleanPhone, '229')) {
                    $cleanPhone = '+' . $cleanPhone;
                } else if (strlen($cleanPhone) === 8) {
                    $cleanPhone = '+229' . $cleanPhone;
                }
            }
            
            $customerData['phone_number'] = [
                'number' => $cleanPhone,
                'country' => 'BJ'
            ];
        }
        
        $typeText = $originalReservation->with_driver ? 'avec chauffeur' : 'sans chauffeur';
        $description = "Extension {$originalReservation->car->getFullName()} ({$typeText}) - {$extensionReservation->total_days} jour(s)";
        
        return Transaction::create([
            'description' => $description,
            'amount' => (int) round($extensionReservation->final_total),
            'currency' => ['iso' => 'XOF'],
            'customer' => $customerData,
            'callback_url' => route('reservations.payment.callback'),
            'cancel_url' => route('reservations.payment.cancel', $extensionReservation->id),
            'webhook_url' => route('reservations.payment.webhook'),
            'custom_metadata' => [
                'reservation_id' => $extensionReservation->id,
                'extension_of' => $originalReservation->id,
                'user_id' => Auth::id(),
                'car_id' => $originalReservation->car_id,
                'is_extension' => 'true',
                'total_days' => $extensionReservation->total_days,
                'type' => $typeText
            ]
        ]);
    }

    /**
     * Vérifie si la voiture est disponible pour l'extension
     */
    private function isCarAvailableForExtension(Reservation $reservation, Carbon $startDate, Carbon $endDate): bool
    {
        return !$reservation->car->reservations()
            ->where('id', '!=', $reservation->id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereRaw('? < CONCAT(reservation_end_date, " ", reservation_end_time) AND ? > CONCAT(reservation_start_date, " ", reservation_start_time)', [$startDate, $endDate]);
            })
            ->exists();
    }

    /**
     * Traite l'approbation d'une extension (appelée par le webhook et callback)
     */
    private function processExtensionApproval(Reservation $extensionReservation)
    {
        $originalReservation = Reservation::find($extensionReservation->extension_of);
        
        if ($originalReservation) {
            // Mettre à jour la réservation originale
            $newEndDateTime = $extensionReservation->getEndDateTime();
            
            $originalReservation->update([
                'reservation_end_date' => $newEndDateTime->toDateString(),
                'reservation_end_time' => $newEndDateTime->toTimeString(),
                'total_days' => $originalReservation->total_days + $extensionReservation->total_days,
                'final_total' => $originalReservation->final_total + $extensionReservation->final_total
            ]);

            Log::info('Extension appliquée à la réservation originale:', [
                'original_id' => $originalReservation->id,
                'extension_id' => $extensionReservation->id,
                'new_end_date' => $newEndDateTime->toDateTimeString(),
                'new_total_days' => $originalReservation->total_days,
                'new_final_total' => $originalReservation->final_total
            ]);

            return $originalReservation;
        }
        
        return null;
    }
}
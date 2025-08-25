<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminReservationController extends Controller
{
    /**
     * Affiche toutes les réservations avec pagination et filtres
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'car'])
            ->whereNull('extension_of') // Exclure les extensions
            ->latest();

        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par période
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        // Filtrage par chauffeur
        if ($request->filled('with_driver')) {
            $query->where('with_driver', $request->with_driver == '1');
        }

        // Filtrage par dates (nouveau système uniquement)
        if ($request->filled('date_from')) {
            $query->whereDate('reservation_start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('reservation_end_date', '<=', $request->date_to);
        }

        // Recherche par nom d'utilisateur ou immatriculation
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('car', function ($carQuery) use ($search) {
                    $carQuery->where('license_plate', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                });
            });
        }

        $reservations = $query->paginate(15);

        // Statistiques pour la vue
        $stats = [
            'total' => Reservation::whereNull('extension_of')->count(),
            'active' => Reservation::where('status', 'active')
                ->whereNull('extension_of')
                ->count(),
            'completed' => Reservation::where('status', 'completed')
                ->whereNull('extension_of')
                ->count(),
            'cancelled' => Reservation::where('status', 'cancelled')
                ->whereNull('extension_of')
                ->count(),
            'revenue' => Reservation::where('status', '!=', 'cancelled')
                ->whereNull('extension_of')
                ->sum('final_total')
        ];

        // Si des filtres sont appliqués, calculer aussi les stats filtrées
        if ($request->hasAny(['status', 'period', 'with_driver', 'date_from', 'date_to', 'search'])) {
            $filteredQuery = clone $query;
            $filteredStats = [
                'filtered_total' => $filteredQuery->count(),
                'filtered_revenue' => $filteredQuery->where('status', '!=', 'cancelled')
                    ->sum('final_total')
            ];
            
            $stats = array_merge($stats, $filteredStats);
        }

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Affiche les réservations en cours
     */
    public function current()
    {
        $reservations = Reservation::with(['user', 'car', 'extensions'])
            ->where('status', 'active')
            ->whereNull('extension_of') // Exclure les extensions
            ->where(function ($query) {
                // Réservations non expirées (nouveau système uniquement)
                $query->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [now()]);
            })
            ->latest()
            ->paginate(15);

        // Calcul du temps restant pour chaque réservation
        foreach ($reservations as $reservation) {
            $endDateTime = Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time);
            
            // Vérifier s'il y a une extension active
            $lastExtension = $reservation->extensions()
                ->where('payment_status', 'paid')
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($lastExtension) {
                $endDateTime = Carbon::parse($lastExtension->reservation_end_date . ' ' . $lastExtension->reservation_end_time);
            }
            
            $reservation->time_remaining = $endDateTime->diffForHumans(null, true);
            $reservation->real_end_date = $endDateTime;
            $reservation->has_extension = (bool) $lastExtension;
        }

        return view('admin.reservations.current', compact('reservations'));
    }

    /**
     * Affiche les réservations expirées
     */
    public function expired()
    {
        $reservations = Reservation::with(['user', 'car', 'extensions'])
            ->where(function ($query) {
                // Réservations actives expirées (nouveau système uniquement)
                $query->where('status', 'active')
                      ->whereNull('extension_of')
                      ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) <= ?', [now()])
                      // Vérifier qu'il n'y a pas d'extension active qui prolonge la réservation
                      ->whereDoesntHave('extensions', function($extensionQuery) {
                          $extensionQuery->where('payment_status', 'paid')
                                        ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [now()]);
                      });
            })
            ->orWhere(function ($query) {
                // Réservations avec extensions expirées
                $query->where('status', 'active')
                      ->whereNull('extension_of')
                      ->whereHas('extensions', function($extensionQuery) {
                          $extensionQuery->where('payment_status', 'paid');
                      })
                      ->whereRaw('(
                          SELECT MAX(CONCAT(reservation_end_date, " ", reservation_end_time))
                          FROM reservations as extensions 
                          WHERE extensions.extension_of = reservations.id 
                          AND extensions.payment_status = "paid"
                      ) <= ?', [now()]);
            })
            ->orWhere('status', 'completed')
            ->whereNull('extension_of')
            ->latest()
            ->paginate(15);

        // Calcul du temps écoulé depuis expiration
        foreach ($reservations as $reservation) {
            $endDateTime = Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time);
            
            // Vérifier la dernière extension
            $lastExtension = $reservation->extensions()
                ->where('payment_status', 'paid')
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($lastExtension) {
                $endDateTime = Carbon::parse($lastExtension->reservation_end_date . ' ' . $lastExtension->reservation_end_time);
                $reservation->has_extension = true;
            }
            
            if ($reservation->status === 'active') {
                $reservation->expired_since = $endDateTime->diffForHumans();
            }
            $reservation->real_end_date = $endDateTime;
        }

        return view('admin.reservations.expired', compact('reservations'));
    }

    /**
     * Affiche les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'car', 'extensions']);

        // Calcul des informations de temps
        $timeRemaining = null;
        $isExpired = false;
        $realEndDateTime = null;

        if ($reservation->status === 'active') {
            // Date de fin de base
            $realEndDateTime = Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time);
            
            // Vérifier s'il y a une extension active
            $lastExtension = $reservation->extensions()
                ->where('payment_status', 'paid')
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($lastExtension) {
                $realEndDateTime = Carbon::parse($lastExtension->reservation_end_date . ' ' . $lastExtension->reservation_end_time);
            }
            
            $isExpired = $realEndDateTime->isPast();
            
            if (!$isExpired) {
                $timeRemaining = $realEndDateTime->locale('fr')->diffForHumans(null, true);
            }
        }

        // Historique des réservations de ce client
        $userHistory = Reservation::with('car')
            ->where('user_id', $reservation->user_id)
            ->where('id', '!=', $reservation->id)
            ->whereNull('extension_of')
            ->latest()
            ->limit(5)
            ->get();

        // Informations de calcul détaillées
        $calculationDetails = [
            'total_days' => $reservation->total_days,
            'daily_rate' => $reservation->daily_rate,
            'subtotal' => $reservation->subtotal,
            'discount_percentage' => $reservation->discount_percentage,
            'discount_amount' => $reservation->discount_amount,
            'final_total' => $reservation->final_total,
            'with_driver' => $reservation->with_driver,
            'start_datetime' => Carbon::parse($reservation->reservation_start_date . ' ' . $reservation->reservation_start_time),
            'end_datetime' => Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time),
        ];

        // Extensions de la réservation
        $extensions = $reservation->extensions()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservations.show', compact(
            'reservation', 
            'timeRemaining', 
            'isExpired', 
            'userHistory',
            'calculationDetails',
            'extensions',
            'realEndDateTime'
        ));
    }

    /**
     * Remet une voiture en statut disponible après expiration
     */
    public function makeAvailable(Request $request, Reservation $reservation)
    {
        // Vérifier que la réservation est bien expirée
        $endDateTime = Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time);
        
        // Vérifier s'il y a une extension active
        $lastExtension = $reservation->extensions()
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($lastExtension) {
            $endDateTime = Carbon::parse($lastExtension->reservation_end_date . ' ' . $lastExtension->reservation_end_time);
        }
        
        if ($reservation->status === 'active' && $endDateTime->isFuture()) {
            return redirect()->back()->with('error', 'Cette réservation n\'est pas encore expirée.');
        }

        // Vérifier qu'il n'y a pas d'extensions en attente de paiement
        $pendingExtensions = $reservation->extensions()
            ->where('payment_status', 'pending')
            ->exists();
            
        if ($pendingExtensions) {
            return redirect()->back()->with('error', 'Cette réservation a des extensions en attente de paiement.');
        }

        DB::transaction(function () use ($reservation) {
            // Marquer la réservation comme terminée
            $reservation->update(['status' => 'completed']);
            
            // Marquer toutes les extensions comme terminées
            $reservation->extensions()
                       ->where('payment_status', 'paid')
                       ->update(['status' => 'completed']);
            
            // Remettre la voiture en disponibilité
            $reservation->car->update(['status' => 'available']);
        });

        return redirect()->route('admin.reservations.expired')
            ->with('success', 'La voiture a été remise en disponibilité avec succès.');
    }

    /**
     * Annule une réservation (admin)
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        // Vérifier que la réservation peut être annulée
        if (!in_array($reservation->status, ['pending', 'active'])) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        DB::transaction(function () use ($reservation, $request) {
            // Marquer la réservation comme annulée
            $reservation->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->reason,
                'cancelled_at' => now(),
                'cancelled_by' => Auth::id()
            ]);
            
            // Annuler toutes les extensions en attente
            $reservation->extensions()
                       ->where('payment_status', 'pending')
                       ->update(['status' => 'cancelled']);
            
            // Remettre la voiture en disponibilité si elle était réservée pour cette réservation
            if ($reservation->car->status === 'reserved') {
                // Vérifier qu'il n'y a pas d'autres réservations actives pour cette voiture
                $otherActiveReservations = $reservation->car->reservations()
                    ->where('id', '!=', $reservation->id)
                    ->whereIn('status', ['pending', 'active'])
                    ->whereNull('extension_of')
                    ->exists();
                    
                if (!$otherActiveReservations) {
                    $reservation->car->update(['status' => 'available']);
                }
            }
        });

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'La réservation a été annulée avec succès.');
    }

    /**
     * Statistiques détaillées des réservations
     */
    public function stats()
    {
        // Statistiques par mois (12 derniers mois) - Nouveau système uniquement
        $monthlyStats = Reservation::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(final_total) as revenue'),
                DB::raw('AVG(final_total) as avg_revenue'),
                DB::raw('AVG(total_days) as avg_days')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top 10 des voitures les plus réservées
        $topCars = Car::select(
                'cars.*',
                DB::raw('COUNT(reservations.id) as reservations_count'),
                DB::raw('SUM(reservations.final_total) as total_revenue'),
                DB::raw('AVG(reservations.final_total) as avg_revenue'),
                DB::raw('SUM(reservations.total_days) as total_days_rented')
            )
            ->leftJoin('reservations', function($join) {
                $join->on('cars.id', '=', 'reservations.car_id')
                     ->where('reservations.status', '!=', 'cancelled')
                     ->whereNull('reservations.extension_of');
            })
            ->groupBy('cars.id')
            ->orderByDesc('reservations_count')
            ->limit(10)
            ->get();

        // Statistiques par durée de location (nouveau système uniquement)
        $durationStats = Reservation::select(
                DB::raw('CASE 
                    WHEN total_days = 1 THEN "1 jour"
                    WHEN total_days = 2 THEN "2 jours"
                    WHEN total_days = 3 THEN "3 jours"
                    WHEN total_days BETWEEN 4 AND 6 THEN "4-6 jours"
                    WHEN total_days BETWEEN 7 AND 9 THEN "7-9 jours (15% réduction)"
                    WHEN total_days BETWEEN 10 AND 13 THEN "10-13 jours (18% réduction)"
                    WHEN total_days >= 14 THEN "14+ jours (20% réduction)"
                    ELSE "Autre"
                END as duration_display'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(final_total) as avg_amount'),
                DB::raw('SUM(final_total) as total_revenue'),
                DB::raw('AVG(discount_percentage) as avg_discount')
            )
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->whereNotNull('total_days')
            ->groupBy('duration_display')
            ->orderByRaw('MIN(total_days)')
            ->get();

        // Statistiques des réductions appliquées
        $discountStats = Reservation::select(
                'discount_percentage',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(discount_amount) as total_discount'),
                DB::raw('AVG(final_total) as avg_final_total'),
                DB::raw('AVG(total_days) as avg_days')
            )
            ->whereNotNull('discount_percentage')
            ->where('discount_percentage', '>', 0)
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy('discount_percentage')
            ->orderBy('discount_percentage')
            ->get();

        // Répartition chauffeur/sans chauffeur
        $driverStats = Reservation::select(
                'with_driver',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(final_total) as avg_amount'),
                DB::raw('SUM(final_total) as total_revenue'),
                DB::raw('AVG(total_days) as avg_days')
            )
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy('with_driver')
            ->get();

        // Top clients par revenus
        $topClients = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.user_id')
            ->select(
                'users.name',
                'users.email',
                DB::raw('COUNT(reservations.id) as total_reservations'),
                DB::raw('SUM(reservations.final_total) as total_spent'),
                DB::raw('AVG(reservations.final_total) as avg_per_reservation'),
                DB::raw('SUM(reservations.total_days) as total_days_rented')
            )
            ->where('reservations.status', '!=', 'cancelled')
            ->whereNull('reservations.extension_of')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Revenus par mois pour les graphiques
        $revenueData = $monthlyStats->pluck('revenue', 'month');
        $reservationData = $monthlyStats->pluck('total', 'month');

        return view('admin.reservations.stats', compact(
            'monthlyStats',
            'topCars',
            'durationStats',
            'discountStats',
            'driverStats',
            'topClients',
            'revenueData',
            'reservationData'
        ));
    }

    /**
     * Exporter les réservations en CSV
     */
    public function export(Request $request)
    {
        $query = Reservation::with(['user', 'car'])
            ->whereNull('extension_of');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('reservation_start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('reservation_end_date', '<=', $request->date_to);
        }

        $reservations = $query->get();

        $filename = 'reservations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Client',
                'Email',
                'Voiture',
                'Immatriculation',
                'Date début',
                'Heure début',
                'Date fin',
                'Heure fin',
                'Nombre de jours',
                'Avec chauffeur',
                'Taux journalier',
                'Sous-total',
                'Réduction (%)',
                'Montant réduction',
                'Total final',
                'Statut',
                'Date création'
            ]);
            
            // Données
            foreach ($reservations as $reservation) {
                fputcsv($file, [
                    $reservation->id,
                    $reservation->user->name,
                    $reservation->user->email,
                    $reservation->car->name,
                    $reservation->car->license_plate,
                    $reservation->reservation_start_date,
                    $reservation->reservation_start_time,
                    $reservation->reservation_end_date,
                    $reservation->reservation_end_time,
                    $reservation->total_days,
                    $reservation->with_driver ? 'Oui' : 'Non',
                    number_format($reservation->daily_rate, 0, ',', ' ') . ' FCFA',
                    number_format($reservation->subtotal, 0, ',', ' ') . ' FCFA',
                    $reservation->discount_percentage . '%',
                    number_format($reservation->discount_amount, 0, ',', ' ') . ' FCFA',
                    number_format($reservation->final_total, 0, ',', ' ') . ' FCFA',
                    ucfirst($reservation->status),
                    $reservation->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Approuver une réservation en attente
     */
    public function approve(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Cette réservation ne peut pas être approuvée.');
        }

        // Vérifier que la voiture est toujours disponible
        if ($reservation->car->status !== 'available') {
            return redirect()->back()->with('error', 'La voiture n\'est plus disponible.');
        }

        DB::transaction(function () use ($reservation) {
            $reservation->update(['status' => 'active']);
            $reservation->car->update(['status' => 'reserved']);
        });

        return redirect()->back()->with('success', 'Réservation approuvée avec succès.');
    }
}
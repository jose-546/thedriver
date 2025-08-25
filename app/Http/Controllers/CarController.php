<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CarController extends Controller
{
    /**
     * Affiche la liste des voitures disponibles (page d'accueil)
     */
    public function index()
    {
        // Récupérer les 8 voitures disponibles les plus récentes pour la page d'accueil
        $cars = Car::where('status', 'available')
                    ->latest()
                    ->take(10)
                    ->get();

        // Statistiques basiques pour la vue d'accueil
        $stats = [
            'total_available' => Car::where('status', 'available')->count(),
            'recent_cars' => $cars->count(),
        ];

        return view('cars.index', compact('cars', 'stats'));
    }

    // Ajouter cette méthode à votre CarController existant
    public function search(Request $request)
    {
        $query = Car::where('status', 'available');

        // Filtre par nom/modèle (recherche textuelle si fournie)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('model', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par marque (checkbox)
        if ($request->filled('brands') && is_array($request->brands)) {
            $query->whereIn('brand', $request->brands);
        }

        // Filtre par modèle (checkbox)
        if ($request->filled('models') && is_array($request->models)) {
            $query->whereIn('model', $request->models);
        }

        // Filtre par année (checkbox)
        if ($request->filled('years') && is_array($request->years)) {
            $query->whereIn('year', $request->years);
        }

        // Filtre par type de carburant (checkbox)
        if ($request->filled('fuel_types') && is_array($request->fuel_types)) {
            $query->whereIn('fuel_type', $request->fuel_types);
        }

        // Filtre par transmission (checkbox)
        if ($request->filled('transmissions') && is_array($request->transmissions)) {
            $query->whereIn('transmission', $request->transmissions);
        }

        // Filtre par nombre de places (checkbox)
        if ($request->filled('seats') && is_array($request->seats)) {
            $query->whereIn('seats', $request->seats);
        }

        // Filtre par gamme de prix (checkbox)
        if ($request->filled('price_ranges') && is_array($request->price_ranges)) {
            $query->where(function($q) use ($request) {
                foreach ($request->price_ranges as $range) {
                    switch ($range) {
                        case 'budget': // 0-25000 FCFA
                            $q->orWhere('daily_price_without_driver', '<', 25000);
                            break;
                        case 'standard': // 25000-35000 FCFA
                            $q->orWhereBetween('daily_price_without_driver', [25000, 35000]);
                            break;
                        case 'premium': // 35000-50000 FCFA
                            $q->orWhereBetween('daily_price_without_driver', [35000, 50000]);
                            break;
                        case 'luxury': // Plus de 50000 FCFA
                            $q->orWhere('daily_price_without_driver', '>', 50000);
                            break;
                    }
                }
            });
        }

        // Tri des résultats
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('daily_price_without_driver', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('daily_price_without_driver', 'desc');
                    break;
                case 'year_desc':
                    $query->orderBy('year', 'desc');
                    break;
                case 'year_asc':
                    $query->orderBy('year', 'asc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        // Pagination des résultats
        $cars = $query->paginate(12)->withQueryString();

        // Statistiques
        $stats = [
            'total_found' => $query->count(),
            'total_available' => Car::where('status', 'available')->count(),
        ];

        // Options pour les filtres (toutes les valeurs distinctes)
        $filterOptions = [
            'brands' => Car::select('brand')
                ->distinct()
                ->whereNotNull('brand')
                ->where('status', 'available')
                ->orderBy('brand')
                ->pluck('brand'),
                
            'models' => Car::select('model')
                ->distinct()
                ->whereNotNull('model')
                ->where('status', 'available')
                ->orderBy('model')
                ->pluck('model'),
                
            'years' => Car::select('year')
                ->distinct()
                ->whereNotNull('year')
                ->where('status', 'available')
                ->orderBy('year', 'desc')
                ->pluck('year'),
                
            'fuel_types' => Car::select('fuel_type')
                ->distinct()
                ->whereNotNull('fuel_type')
                ->where('status', 'available')
                ->orderBy('fuel_type')
                ->pluck('fuel_type'),
                
            'transmissions' => Car::select('transmission')
                ->distinct()
                ->whereNotNull('transmission')
                ->where('status', 'available')
                ->orderBy('transmission')
                ->pluck('transmission'),
                
            'seats_options' => Car::select('seats')
                ->distinct()
                ->whereNotNull('seats')
                ->where('status', 'available')
                ->orderBy('seats')
                ->pluck('seats'),
                
            'price_ranges' => [
                'budget' => 'Budget (< 25,000 FCFA)',
                'standard' => 'Standard (25,000 - 35,000 FCFA)',
                'premium' => 'Premium (35,000 - 50,000 FCFA)',
                'luxury' => 'Luxe (> 50,000 FCFA)'
            ]
        ];

        return view('cars.search', compact('cars', 'stats', 'filterOptions'));
    }


    /**
     * Affiche les détails d'une voiture
     */
    public function show(Car $car)
    {
        // Vérifier que la voiture est disponible
        if (!$car->isAvailable()) {
            return redirect()->route('home')->with('error', 'Cette voiture n\'est plus disponible.');
        }

        // Informations de tarification (nouveau système)
        $pricingInfo = [
            'daily_price_without_driver' => $car->daily_price_without_driver,
            'daily_price_with_driver' => $car->daily_price_with_driver,
            'discount_7_days' => 15, // 15% pour 7-9 jours
            'discount_10_days' => 18, // 18% pour 10-13 jours
            'discount_14_days' => 20, // 20% pour 14+ jours
        ];

        // Exemples de calculs pour différentes durées
        $pricingExamples = $this->calculatePricingExamples($car);

        // Réservations récentes (pour afficher la popularité)
        $recentReservationsCount = $car->reservations()
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->whereMonth('created_at', now()->month)
            ->count();


        // Voitures similaires (même catégorie, prix similaire)
        $similarCars = Car::where('status', 'available')
            ->where('id', '!=', $car->id)
            ->whereBetween('daily_price_without_driver', [
                $car->daily_price_without_driver * 0.8,
                $car->daily_price_without_driver * 1.2
            ])
            ->limit(4)
            ->get();

        // Si pas assez de voitures similaires, prendre d'autres voitures disponibles
        if ($similarCars->count() < 4) {
            $additionalCars = Car::where('status', 'available')
                ->where('id', '!=', $car->id)
                ->whereNotIn('id', $similarCars->pluck('id'))
                ->limit(4 - $similarCars->count())
                ->get();
            
            $similarCars = $similarCars->merge($additionalCars);
        }

        return view('cars.show', compact(
            'car',
            'pricingInfo',
            'pricingExamples',
            'recentReservationsCount',
            'similarCars'
        ));
    }

    /**
     * Calcule des exemples de prix pour différentes durées
     */
    private function calculatePricingExamples(Car $car): array
    {
        $examples = [];
        $durations = [1, 3, 7, 10, 14, 30]; // jours

        foreach ($durations as $days) {
            foreach ([false, true] as $withDriver) {
                $dailyRate = $withDriver ? $car->daily_price_with_driver : $car->daily_price_without_driver;
                $subtotal = $dailyRate * $days;
                
                // Calcul de la réduction
                $discountPercentage = 0;
                if ($days >= 7 && $days <= 9) {
                    $discountPercentage = 15;
                } elseif ($days >= 10 && $days <= 13) {
                    $discountPercentage = 18;
                } elseif ($days >= 14) {
                    $discountPercentage = 20;
                }
                
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $finalTotal = $subtotal - $discountAmount;
                
                $examples[] = [
                    'days' => $days,
                    'with_driver' => $withDriver,
                    'daily_rate' => $dailyRate,
                    'subtotal' => $subtotal,
                    'discount_percentage' => $discountPercentage,
                    'discount_amount' => $discountAmount,
                    'final_total' => $finalTotal,
                ];
            }
        }

        return $examples;
    }

    /**
     * API pour vérifier la disponibilité d'une voiture
     */
    public function checkAvailability(Request $request, Car $car)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after:start_date',
            'end_time' => 'required|date_format:H:i',
        ]);

        $startDateTime = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endDateTime = Carbon::parse($request->end_date . ' ' . $request->end_time);

        // Vérifier les conflits avec les réservations existantes
        $hasConflict = $car->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->whereNull('extension_of')
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->where(function($q) use ($startDateTime, $endDateTime) {
                    // Nouveau système
                    $q->whereRaw('CONCAT(reservation_start_date, " ", reservation_start_time) < ?', [$endDateTime])
                      ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [$startDateTime]);
                });
            })
            ->exists();

        $available = !$hasConflict && $car->status === 'available';

        // Calculer le prix si disponible
        $pricing = null;
        if ($available) {
            $totalDays = $startDateTime->diffInDays($endDateTime);
            if ($totalDays < 1) $totalDays = 1;

            foreach ([false, true] as $withDriver) {
                $dailyRate = $withDriver ? $car->daily_price_with_driver : $car->daily_price_without_driver;
                $subtotal = $dailyRate * $totalDays;
                
                // Calcul de la réduction
                $discountPercentage = 0;
                if ($totalDays >= 7 && $totalDays <= 9) {
                    $discountPercentage = 15;
                } elseif ($totalDays >= 10 && $totalDays <= 13) {
                    $discountPercentage = 18;
                } elseif ($totalDays >= 14) {
                    $discountPercentage = 20;
                }
                
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $finalTotal = $subtotal - $discountAmount;
                
                $pricing[($withDriver ? 'with_driver' : 'without_driver')] = [
                    'daily_rate' => $dailyRate,
                    'total_days' => $totalDays,
                    'subtotal' => $subtotal,
                    'discount_percentage' => $discountPercentage,
                    'discount_amount' => $discountAmount,
                    'final_total' => $finalTotal,
                ];
            }
        }

        return response()->json([
            'available' => $available,
            'pricing' => $pricing,
            'message' => $available ? 'Voiture disponible' : 'Voiture non disponible pour cette période'
        ]);
    }


}
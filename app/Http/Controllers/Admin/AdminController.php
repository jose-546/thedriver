<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard administrateur - NOUVEAU SYSTÈME AVEC DATES/HEURES PRÉCISES
     */
    public function dashboard()
    {
        // Statistiques générales
        $stats = [
            'total_cars' => Car::count(),
            'available_cars' => Car::where('status', 'available')->count(),
            'reserved_cars' => Car::where('status', 'reserved')->count(),
            'maintenance_cars' => Car::where('status', 'maintenance')->count(),
            'total_users' => User::where('role', 'client')->count(),
            
            // Réservations actives (nouveau système uniquement)
            'current_reservations' => Reservation::where('status', 'active')
                ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [now()])
                ->whereNull('extension_of') // Exclure les extensions
                ->count(),
                
            'total_reservations' => Reservation::whereNull('extension_of')->count(),
            
            // Réservations expirées (nouveau système uniquement)
            'expired_reservations' => Reservation::where('status', 'active')
                ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) <= ?', [now()])
                ->whereNull('extension_of')
                ->count(),
                
            // Revenus mensuels (nouveau système uniquement)
            'monthly_revenue' => Reservation::where('status', '!=', 'cancelled')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereNull('extension_of')
                ->sum('final_total'),
                
            'weekly_reservations' => Reservation::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->whereNull('extension_of')->count(),
        ];

        // Pourcentages d'utilisation
        $stats['utilization_rate'] = $stats['total_cars'] > 0 
            ? round(($stats['reserved_cars'] / $stats['total_cars']) * 100, 1)
            : 0;

        // Statistiques supplémentaires
        $stats = array_merge($stats, $this->getAdditionalStats());

        // Réservations récentes (nouveau système)
        $recentReservations = Reservation::with(['user', 'car'])
            ->whereNull('extension_of')
            ->latest()
            ->limit(5)
            ->get();

        // Voitures récemment ajoutées
        $recentCars = Car::latest()->limit(5)->get();

        // Données pour les graphiques (7 derniers jours)
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyStats[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('d/m'),
                'reservations' => Reservation::whereDate('created_at', $date)
                    ->whereNull('extension_of')
                    ->count(),
                'revenue' => Reservation::whereDate('created_at', $date)
                    ->where('status', '!=', 'cancelled')
                    ->whereNull('extension_of')
                    ->sum('final_total')
            ];
        }

        // Répartition par nombre de jours
        $periodDistribution = $this->getPeriodDistribution();

        // Alertes importantes
        $alerts = $this->getImportantAlerts();

        return view('admin.dashboard', compact(
            'stats', 
            'recentReservations', 
            'recentCars',
            'dailyStats',
            'periodDistribution',
            'alerts'
        ));
    }

    /**
     * Statistiques supplémentaires pour le dashboard
     */
    private function getAdditionalStats()
    {
        $additionalStats = [];

        // Réservations avec/sans chauffeur
        $additionalStats['without_driver_reservations'] = Reservation::where('status', '!=', 'cancelled')
            ->where('with_driver', 0)
            ->whereNull('extension_of')
            ->count();

        $additionalStats['with_driver_reservations'] = Reservation::where('status', '!=', 'cancelled')
            ->where('with_driver', 1)
            ->whereNull('extension_of')
            ->count();

        // Réservations avec réductions (basées sur total_days)
        $additionalStats['discount_15_percent'] = Reservation::where('status', '!=', 'cancelled')
            ->where('discount_percentage', 15)
            ->whereNull('extension_of')
            ->count();

        $additionalStats['discount_18_percent'] = Reservation::where('status', '!=', 'cancelled')
            ->where('discount_percentage', 18)
            ->whereNull('extension_of')
            ->count();

        $additionalStats['discount_20_percent'] = Reservation::where('status', '!=', 'cancelled')
            ->where('discount_percentage', 20)
            ->whereNull('extension_of')
            ->count();

        // Total des réservations avec réductions
        $additionalStats['discounted_reservations'] = Reservation::where('status', '!=', 'cancelled')
            ->where('discount_percentage', '>', 0)
            ->whereNull('extension_of')
            ->count();

        // Total des économies
        $additionalStats['total_savings'] = Reservation::where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->sum('discount_amount') ?? 0;

        // Revenus moyens par jour de location
        $avgDailyRevenue = Reservation::where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->whereMonth('created_at', now()->month)
            ->avg('daily_rate');
        $additionalStats['avg_daily_revenue'] = $avgDailyRevenue ?? 0;

        // Durée moyenne des réservations
        $avgDuration = Reservation::where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->whereMonth('created_at', now()->month)
            ->avg('total_days');
        $additionalStats['avg_reservation_duration'] = round($avgDuration ?? 0, 1);

        return $additionalStats;
    }

    /**
     * Calcule la répartition par période (basée sur total_days)
     */
    private function getPeriodDistribution()
    {
        $reservations = Reservation::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereNull('extension_of')
            ->get(['total_days']);

        $distribution = [
            '1_day' => ['count' => 0, 'label' => '1 jour'],
            '2_days' => ['count' => 0, 'label' => '2 jours'],
            '3_days' => ['count' => 0, 'label' => '3 jours'],
            '4_6_days' => ['count' => 0, 'label' => '4-6 jours'],
            '7_13_days' => ['count' => 0, 'label' => '1-2 semaines'],
            '14_plus_days' => ['count' => 0, 'label' => '2+ semaines']
        ];

        foreach ($reservations as $reservation) {
            $days = $reservation->total_days ?? 1;
            
            if ($days == 1) {
                $distribution['1_day']['count']++;
            } elseif ($days == 2) {
                $distribution['2_days']['count']++;
            } elseif ($days == 3) {
                $distribution['3_days']['count']++;
            } elseif ($days >= 4 && $days <= 6) {
                $distribution['4_6_days']['count']++;
            } elseif ($days >= 7 && $days <= 13) {
                $distribution['7_13_days']['count']++;
            } else {
                $distribution['14_plus_days']['count']++;
            }
        }

        return collect($distribution);
    }

    /**
     * Statistiques détaillées (nouveau système uniquement)
     */
    public function stats()
    {
        // Statistiques par mois (12 derniers mois)
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            
            $reservationsCount = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereNull('extension_of')
                ->count();
                
            $revenue = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', '!=', 'cancelled')
                ->whereNull('extension_of')
                ->sum('final_total');
                
            $monthlyStats[] = (object)[
                'month' => $monthKey,
                'month_name' => $date->format('M Y'),
                'total' => $reservationsCount,
                'revenue' => $revenue
            ];
        }

        // Performance des voitures
        $topCars = Car::select(
                'cars.*',
                DB::raw('COUNT(reservations.id) as reservations_count'),
                DB::raw('SUM(CASE WHEN reservations.status != "cancelled" THEN reservations.final_total ELSE 0 END) as total_revenue'),
                DB::raw('AVG(CASE WHEN reservations.status != "cancelled" THEN reservations.final_total ELSE NULL END) as avg_revenue'),
                DB::raw('SUM(CASE WHEN reservations.status != "cancelled" THEN reservations.total_days ELSE 0 END) as total_days_rented'),
                DB::raw('AVG(CASE WHEN reservations.status != "cancelled" THEN reservations.total_days ELSE NULL END) as avg_rental_days'),
                DB::raw('AVG(CASE WHEN reservations.status != "cancelled" THEN reservations.daily_rate ELSE NULL END) as avg_daily_rate')
            )
            ->leftJoin('reservations', function($join) {
                $join->on('cars.id', '=', 'reservations.car_id')
                     ->whereNull('reservations.extension_of');
            })
            ->groupBy('cars.id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Analyse des clients
        $topClients = User::select(
                'users.*',
                DB::raw('COUNT(reservations.id) as total_reservations'),
                DB::raw('SUM(CASE WHEN reservations.status != "cancelled" THEN reservations.final_total ELSE 0 END) as total_spent'),
                DB::raw('SUM(CASE WHEN reservations.status != "cancelled" THEN reservations.total_days ELSE 0 END) as total_days_rented'),
                DB::raw('AVG(CASE WHEN reservations.status != "cancelled" THEN reservations.final_total ELSE NULL END) as avg_spent_per_reservation'),
                DB::raw('AVG(CASE WHEN reservations.status != "cancelled" THEN reservations.total_days ELSE NULL END) as avg_days_per_reservation'),
                DB::raw('MAX(reservations.created_at) as last_reservation')
            )
            ->where('role', 'client')
            ->leftJoin('reservations', function($join) {
                $join->on('users.id', '=', 'reservations.user_id')
                     ->whereNull('reservations.extension_of');
            })
            ->groupBy('users.id')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        // Statistiques par période (détaillées)
        $periodStats = $this->getDetailedPeriodStats();

        // Statistiques par type de réservation (avec/sans chauffeur)
        $driverStats = Reservation::select(
                DB::raw('CASE WHEN with_driver = 1 THEN "Avec chauffeur" ELSE "Sans chauffeur" END as type'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(final_total) as avg_amount'),
                DB::raw('SUM(final_total) as total_revenue'),
                DB::raw('AVG(total_days) as avg_days'),
                DB::raw('AVG(daily_rate) as avg_daily_rate')
            )
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy('with_driver')
            ->get();

        // Analyse des réductions appliquées
        $discountStats = Reservation::select(
                DB::raw('CASE 
                    WHEN discount_percentage = 0 THEN "Aucune réduction"
                    WHEN discount_percentage = 15 THEN "15% (7-9 jours)"
                    WHEN discount_percentage = 18 THEN "18% (10-13 jours)"
                    WHEN discount_percentage = 20 THEN "20% (14+ jours)"
                    ELSE CONCAT(discount_percentage, "% (autre)")
                END as discount_type'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(discount_amount) as total_discount_amount'),
                DB::raw('AVG(total_days) as avg_days'),
                DB::raw('AVG(final_total) as avg_final_total')
            )
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy('discount_percentage')
            ->orderBy('discount_percentage')
            ->get();

        // Variables pour compatibilité avec les vues
        $revenueData = collect($monthlyStats)->pluck('revenue', 'month');
        $reservationData = collect($monthlyStats)->pluck('total', 'month');

        return view('admin.reservations.stats', compact(
            'monthlyStats',
            'topCars',
            'topClients',
            'periodStats',
            'driverStats',
            'discountStats',
            'revenueData',
            'reservationData'
        ));
    }

    /**
     * Statistiques détaillées par période (basées sur total_days)
     */
    private function getDetailedPeriodStats()
    {
        return Reservation::select(
                DB::raw('CASE 
                    WHEN total_days = 1 THEN "1 jour"
                    WHEN total_days = 2 THEN "2 jours"
                    WHEN total_days = 3 THEN "3 jours"
                    WHEN total_days BETWEEN 4 AND 6 THEN "4-6 jours"
                    WHEN total_days BETWEEN 7 AND 9 THEN "7-9 jours (15% réduction)"
                    WHEN total_days BETWEEN 10 AND 13 THEN "10-13 jours (18% réduction)"
                    WHEN total_days >= 14 THEN "14+ jours (20% réduction)"
                    ELSE "Autre"
                END as period'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(final_total) as avg_amount'),
                DB::raw('SUM(final_total) as total_revenue'),
                DB::raw('AVG(discount_percentage) as avg_discount'),
                DB::raw('SUM(discount_amount) as total_discount_amount'),
                DB::raw('AVG(daily_rate) as avg_daily_rate'),
                DB::raw('SUM(subtotal) as total_subtotal')
            )
            ->where('status', '!=', 'cancelled')
            ->whereNull('extension_of')
            ->groupBy(DB::raw('CASE 
                WHEN total_days = 1 THEN "1 jour"
                WHEN total_days = 2 THEN "2 jours"
                WHEN total_days = 3 THEN "3 jours"
                WHEN total_days BETWEEN 4 AND 6 THEN "4-6 jours"
                WHEN total_days BETWEEN 7 AND 9 THEN "7-9 jours (15% réduction)"
                WHEN total_days BETWEEN 10 AND 13 THEN "10-13 jours (18% réduction)"
                WHEN total_days >= 14 THEN "14+ jours (20% réduction)"
                ELSE "Autre"
            END'))
            ->orderByRaw('MIN(total_days)')
            ->get();
    }

    /**
     * Récupère les alertes importantes pour le dashboard
     */
    private function getImportantAlerts()
    {
        $alerts = [];

        // Réservations expirées (nouveau système uniquement)
        $expiredCount = Reservation::where('status', 'active')
            ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) <= ?', [now()])
            ->whereNull('extension_of')
            ->count();
        
        if ($expiredCount > 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "{$expiredCount} réservation(s) expirée(s) à traiter",
                'link' => route('admin.reservations.expired') ?? '#'
            ];
        }

        // Voitures en maintenance
        $maintenanceCount = Car::where('status', 'maintenance')->count();
        if ($maintenanceCount > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$maintenanceCount} voiture(s) en maintenance",
                'link' => route('admin.cars.index') . '?status=maintenance'
            ];
        }

        // Taux d'utilisation faible
        $totalCars = Car::count();
        $reservedCars = Car::where('status', 'reserved')->count();
        $utilizationRate = $totalCars > 0 ? ($reservedCars / $totalCars) * 100 : 0;
        
        if ($utilizationRate < 30 && $totalCars > 0) {
            $alerts[] = [
                'type' => 'danger',
                'message' => "Taux d'utilisation faible: " . round($utilizationRate, 1) . "%",
                'link' => route('admin.cars.index') ?? '#'
            ];
        }

        // Extensions en attente de paiement
        $pendingExtensionsCount = Reservation::where('status', 'pending')
            ->where('payment_status', 'pending')
            ->whereNotNull('extension_of')
            ->count();
            
        if ($pendingExtensionsCount > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$pendingExtensionsCount} extension(s) en attente de paiement",
                'link' => route('admin.reservations.index') . '?status=pending'
            ];
        }

        // Réservations avec réductions importantes
        $highDiscountCount = Reservation::where('status', 'active')
            ->where('discount_percentage', '>=', 18)
            ->whereNull('extension_of')
            ->count();
            
        if ($highDiscountCount > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$highDiscountCount} réservation(s) avec réduction ≥18%",
                'link' => '#'
            ];
        }

        // Nouveaux utilisateurs cette semaine
        $newUsersCount = User::where('role', 'client')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
            
        if ($newUsersCount > 0) {
            $alerts[] = [
                'type' => 'success',
                'message' => "{$newUsersCount} nouveau(x) client(s) cette semaine",
                'link' => '#'
            ];
        }

        // Revenus du mois (nouveau système)
        $monthlyRevenue = Reservation::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNull('extension_of')
            ->sum('final_total');

        if ($monthlyRevenue > 1000000) { // Plus d'1 million FCFA
            $alerts[] = [
                'type' => 'success',
                'message' => "Excellent mois ! Revenus: " . number_format($monthlyRevenue, 0, ',', ' ') . " FCFA",
                'link' => '#'
            ];
        }

        // Réservations qui démarrent aujourd'hui
        $todayStarting = Reservation::where('status', 'active')
            ->whereDate('reservation_start_date', now()->toDateString())
            ->whereNull('extension_of')
            ->count();
            
        if ($todayStarting > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => "{$todayStarting} réservation(s) démarrent aujourd'hui",
                'link' => '#'
            ];
        }

        // Réservations qui se terminent aujourd'hui
        $todayEnding = Reservation::where('status', 'active')
            ->whereDate('reservation_end_date', now()->toDateString())
            ->whereNull('extension_of')
            ->count();
            
        if ($todayEnding > 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "{$todayEnding} réservation(s) se terminent aujourd'hui",
                'link' => '#'
            ];
        }

        return $alerts;
    }

    /**
     * Marquer les réservations expirées comme terminées
     */
    public function markExpiredReservationsCompleted()
    {
        $expiredReservations = Reservation::where('status', 'active')
            ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) <= ?', [now()])
            ->whereNull('extension_of')
            ->get();

        $updatedCount = 0;
        
        foreach ($expiredReservations as $reservation) {
            $reservation->update(['status' => 'completed']);
            
            // Remettre la voiture disponible si aucune autre réservation active
            $car = $reservation->car;
            $hasOtherActiveReservations = $car->reservations()
                ->where('id', '!=', $reservation->id)
                ->whereIn('status', ['pending', 'active'])
                ->exists();
                
            if (!$hasOtherActiveReservations) {
                $car->update(['status' => 'available']);
            }
            
            $updatedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "{$updatedCount} réservation(s) marquée(s) comme terminée(s)",
            'updated_count' => $updatedCount
        ]);
    }

    /**
     * Obtenir le statut en temps réel du système
     */
    public function getSystemStatus()
    {
        $now = now();
        
        // Réservations qui commencent bientôt (dans les 2 heures)
        $startingSoon = Reservation::where('status', 'active')
            ->whereRaw('CONCAT(reservation_start_date, " ", reservation_start_time) BETWEEN ? AND ?', [
                $now,
                $now->copy()->addHours(2)
            ])
            ->whereNull('extension_of')
            ->with(['user', 'car'])
            ->get();

        // Réservations qui se terminent bientôt (dans les 2 heures)
        $endingSoon = Reservation::where('status', 'active')
            ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) BETWEEN ? AND ?', [
                $now,
                $now->copy()->addHours(2)
            ])
            ->whereNull('extension_of')
            ->with(['user', 'car'])
            ->get();

        // Voitures qui devraient être disponibles mais sont encore réservées
        $shouldBeAvailable = Car::where('status', 'reserved')
            ->whereDoesntHave('reservations', function($query) use ($now) {
                $query->whereIn('status', ['pending', 'active'])
                    ->where(function($q) use ($now) {
                        $q->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [$now]);
                    });
            })
            ->get();

        return response()->json([
            'starting_soon' => $startingSoon,
            'ending_soon' => $endingSoon,
            'should_be_available' => $shouldBeAvailable,
            'timestamp' => $now->toDateTimeString(),
            'current_time' => $now->format('d/m/Y H:i:s')
        ]);
    }

    /**
     * Corriger automatiquement les statuts de voitures
     */
    public function fixCarStatuses()
    {
        $fixed = 0;
        $cars = Car::where('status', 'reserved')->get();
        
        foreach ($cars as $car) {
            $hasActiveReservations = $car->reservations()
                ->whereIn('status', ['pending', 'active'])
                ->whereRaw('CONCAT(reservation_end_date, " ", reservation_end_time) > ?', [now()])
                ->exists();
                
            if (!$hasActiveReservations) {
                $car->update(['status' => 'available']);
                $fixed++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$fixed} voiture(s) remise(s) disponible(s)",
            'fixed_count' => $fixed
        ]);
    }

    /**
     * Aperçu des réservations du jour
     */
    public function todayReservations()
    {
        $today = now()->toDateString();
        
        $startingToday = Reservation::where('status', 'active')
            ->whereDate('reservation_start_date', $today)
            ->whereNull('extension_of')
            ->with(['user', 'car'])
            ->orderBy('reservation_start_time')
            ->get();
            
        $endingToday = Reservation::where('status', 'active')
            ->whereDate('reservation_end_date', $today)
            ->whereNull('extension_of')
            ->with(['user', 'car'])
            ->orderBy('reservation_end_time')
            ->get();
            
        return response()->json([
            'starting_today' => $startingToday,
            'ending_today' => $endingToday,
            'date' => now()->format('d/m/Y')
        ]);
    }
}
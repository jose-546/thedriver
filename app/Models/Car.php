<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'license_plate',
        'image',
        'description',
        'fuel_type',
        'transmission',
        'seats',
        'status',
        'daily_price_without_driver',
        'daily_price_with_driver',
    ];

    protected $casts = [
        'year' => 'integer',
        'seats' => 'integer',
        'daily_price_without_driver' => 'decimal:2',
        'daily_price_with_driver' => 'decimal:2',
    ];

    // ========== MÉTHODES DE PRICING ==========

    /**
     * Obtient le prix journalier selon la présence d'un chauffeur
     */
    public function getDailyPrice($withDriver = false): float
    {
        return $withDriver ? 
            ($this->daily_price_with_driver ?? 30000.00) : 
            ($this->daily_price_without_driver ?? 20000.00);
    }

    /**
     * Calcule le prix total pour un nombre de jours avec réductions
     */
    public function calculateTotalPrice(int $days, bool $withDriver = false): array
    {
        $dailyPrice = $this->getDailyPrice($withDriver);
        $subtotal = $days * $dailyPrice;
        
        $discountPercentage = $this->getDiscountPercentage($days);
        $discountAmount = $subtotal * ($discountPercentage / 100);
        $finalTotal = $subtotal - $discountAmount;
        
        return [
            'daily_price' => $dailyPrice,
            'days' => $days,
            'subtotal' => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'final_total' => $finalTotal
        ];
    }

    /**
     * Calcule le prix d'une réservation basé sur les dates de début et fin
     */
    public function calculateReservationPrice($startDateTime, $endDateTime, $withDriver = false): array
    {
        // ⭐ CALCUL CORRIGÉ : Nombre de jours inclusif
        $startDate = Carbon::parse($startDateTime);
        $endDate = Carbon::parse($endDateTime);
        $totalDays = $startDate->diffInDays($endDate); // ✅ +1 pour inclure le jour de fin
        
        // Déterminer le tarif journalier selon l'option
        $dailyRate = $withDriver ? 
            ($this->daily_price_with_driver ?? 30000.00) : 
            ($this->daily_price_without_driver ?? 20000.00);
        
        // Calculer le sous-total
        $subtotal = $totalDays * $dailyRate;
        
        // Calculer le pourcentage de réduction selon la durée
        $discountPercentage = $this->getDiscountPercentage($totalDays);
        
        // Calculer le montant de la réduction
        $discountAmount = $subtotal * ($discountPercentage / 100);
        
        // Calculer le montant final
        $finalTotal = $subtotal - $discountAmount;
        
        return [
            'total_days' => $totalDays,
            'daily_rate' => $dailyRate,
            'subtotal' => round($subtotal, 2),
            'discount_percentage' => $discountPercentage,
            'discount_amount' => round($discountAmount, 2),
            'final_total' => round($finalTotal, 2),
            'with_driver' => $withDriver
        ];
    }
    /**
     * Calcule le pourcentage de réduction selon le nombre de jours
     */
    private function getDiscountPercentage(int $days): float
    {
        if ($days >= 14) {
            return 20.0; // 20% pour 14 jours et plus
        } elseif ($days >= 10) {
            return 18.0; // 18% pour 10-13 jours
        } elseif ($days >= 7) {
            return 15.0; // 15% pour 7-9 jours
        }
        
        return 0.0; // Pas de réduction pour moins de 7 jours
    }

    /**
     * Obtient les informations de prix pour l'affichage
     */
    public function getPricingInfo(): array
    {
        return [
            'daily_without_driver' => $this->getDailyPrice(false),
            'daily_with_driver' => $this->getDailyPrice(true),
            'discounts' => [
                '7_to_9_days' => 15,
                '10_to_13_days' => 18,
                '14_plus_days' => 20
            ]
        ];
    }

    /**
     * Simule le prix pour différentes durées (pour affichage)
     */
    public function getSimulatedPrices(): array
    {
        $simulations = [];
        $durations = [1, 3, 7, 10, 14, 30]; // Durées en jours
        
        foreach ($durations as $days) {
            $simulations[$days] = [
                'without_driver' => $this->calculateTotalPrice($days, false),
                'with_driver' => $this->calculateTotalPrice($days, true)
            ];
        }
        
        return $simulations;
    }

    // ========== MÉTHODES DE STATUT ==========

    /**
     * Vérifie si la voiture est disponible
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Vérifie si la voiture est réservée
     */
    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    /**
     * Vérifie si la voiture est en maintenance
     */
    public function isInMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    /**
     * Marque la voiture comme réservée
     */
    public function markAsReserved(): void
    {
        $this->update(['status' => 'reserved']);
    }

    /**
     * Marque la voiture comme disponible
     */
    public function markAsAvailable(): void
    {
        $this->update(['status' => 'available']);
    }

    /**
     * Marque la voiture comme en maintenance
     */
    public function markAsInMaintenance(): void
    {
        $this->update(['status' => 'maintenance']);
    }

    // ========== MÉTHODES DE DISPONIBILITÉ ==========

    /**
     * Vérifie si la voiture est disponible entre deux dates/heures
     */
    public function isAvailableBetween($startDateTime, $endDateTime): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        // Convertir en Carbon si nécessaire
        $startDateTime = $startDateTime instanceof Carbon ? $startDateTime : Carbon::parse($startDateTime);
        $endDateTime = $endDateTime instanceof Carbon ? $endDateTime : Carbon::parse($endDateTime);

        return !$this->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->where(function($query) use ($startDateTime, $endDateTime) {
                // Vérifier les conflits avec les nouvelles colonnes
                $query->whereRaw("
                    (CONCAT(reservation_start_date, ' ', reservation_start_time) < ? 
                     AND CONCAT(reservation_end_date, ' ', reservation_end_time) > ?)
                ", [$endDateTime->format('Y-m-d H:i:s'), $startDateTime->format('Y-m-d H:i:s')]);
            })
            ->exists();
    }

    /**
     * Vérifie si la voiture est disponible pour une période donnée
     */
    public function isAvailableForPeriod($startDate, $endDate, $startTime = null): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        // Si pas d'heure spécifiée, utiliser 00:00
        $startTime = $startTime ?? '00:00:00';
        
        $startDateTime = Carbon::parse($startDate . ' ' . $startTime);
        $endDateTime = Carbon::parse($endDate . ' ' . $startTime);

        return $this->isAvailableBetween($startDateTime, $endDateTime);
    }

    /**
     * Obtient les périodes de non-disponibilité
     */
    public function getUnavailablePeriods($startDate = null, $endDate = null): array
    {
        $query = $this->reservations()
            ->whereIn('status', ['pending', 'active'])
            ->orderBy('reservation_start_date')
            ->orderBy('reservation_start_time');

        if ($startDate && $endDate) {
            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('reservation_start_date', [$startDate, $endDate])
                  ->orWhereBetween('reservation_end_date', [$startDate, $endDate])
                  ->orWhere(function($qq) use ($startDate, $endDate) {
                      $qq->where('reservation_start_date', '<=', $startDate)
                         ->where('reservation_end_date', '>=', $endDate);
                  });
            });
        }

        return $query->get(['reservation_start_date', 'reservation_start_time', 'reservation_end_date', 'reservation_end_time'])
            ->map(function($reservation) {
                return [
                    'start' => $reservation->reservation_start_date . ' ' . $reservation->reservation_start_time,
                    'end' => $reservation->reservation_end_date . ' ' . $reservation->reservation_end_time,
                ];
            })->toArray();
    }

    // ========== RELATIONS ==========

    /**
     * Relation avec les réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relation avec la galerie d'images
     */
    public function galleries()
    {
        return $this->hasMany(CarGallery::class)->ordered();
    }

    /**
     * Obtient la réservation active de cette voiture
     */
    public function activeReservation()
    {
        return $this->reservations()
            ->where('status', 'active')
            ->whereRaw("CONCAT(reservation_start_date, ' ', reservation_start_time) <= ?", [now()])
            ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()])
            ->first();
    }

    /**
     * Obtient toutes les réservations actives
     */
    public function activeReservations()
    {
        return $this->reservations()
            ->where('status', 'active')
            ->whereRaw("CONCAT(reservation_start_date, ' ', reservation_start_time) <= ?", [now()])
            ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()]);
    }

    /**
     * Obtient les réservations futures
     */
    public function upcomingReservations()
    {
        return $this->reservations()
            ->where('status', 'active')
            ->whereRaw("CONCAT(reservation_start_date, ' ', reservation_start_time) > ?", [now()])
            ->orderBy('reservation_start_date')
            ->orderBy('reservation_start_time');
    }

    // ========== MÉTHODES D'IMAGES ==========

    /**
     * Obtient l'URL de l'image ou une image par défaut
     */
    public function getImageUrl(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/default-car.jpg');
    }

    /**
     * Obtient toutes les images (principale + galerie)
     */
    public function getAllImages(): array
    {
        $images = [];
        
        if ($this->image) {
            $images[] = [
                'url' => $this->getImageUrl(),
                'alt' => $this->name . ' - Image principale',
                'is_main' => true
            ];
        }
        
        foreach ($this->galleries as $gallery) {
            $images[] = [
                'url' => $gallery->getImageUrl(),
                'alt' => $gallery->alt_text ?: $this->name,
                'is_main' => false
            ];
        }
        
        return $images;
    }

    /**
     * Vérifie si la voiture a une galerie d'images
     */
    public function hasGallery(): bool
    {
        return $this->galleries()->count() > 0;
    }

    // ========== MÉTHODES D'AFFICHAGE ==========

    /**
     * Obtient le nom complet de la voiture
     */
    public function getFullName(): string
    {
        return "{$this->brand} {$this->model} ({$this->year})";
    }

    /**
     * Obtient le statut en français
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'available' => 'Disponible',
            'reserved' => 'Réservée',
            'maintenance' => 'En maintenance',
            default => 'Inconnu'
        };
    }

    /**
     * Obtient la couleur du statut pour l'affichage
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'available' => 'green',
            'reserved' => 'red',
            'maintenance' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Obtient le type de carburant en français
     */
    public function getFuelTypeLabel(): string
    {
        return match($this->fuel_type) {
            'essence' => 'Essence',
            'diesel' => 'Diesel',
            'electrique' => 'Électrique',
            'hybride' => 'Hybride',
            default => 'Non spécifié'
        };
    }

    /**
     * Obtient le type de transmission en français
     */
    public function getTransmissionLabel(): string
    {
        return match($this->transmission) {
            'manuelle' => 'Manuelle',
            'automatique' => 'Automatique',
            default => 'Non spécifié'
        };
    }

    /**
     * Obtient un résumé des caractéristiques
     */
    public function getFeaturesSummary(): array
    {
        return [
            'Carburant' => $this->getFuelTypeLabel(),
            'Transmission' => $this->getTransmissionLabel(),
            'Places' => $this->seats . ' places',
            'Année' => $this->year
        ];
    }

    // ========== SCOPES ==========

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopeInMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeByFuelType($query, $fuelType)
    {
        return $query->where('fuel_type', $fuelType);
    }

    public function scopeByTransmission($query, $transmission)
    {
        return $query->where('transmission', $transmission);
    }

    public function scopeMinSeats($query, $seats)
    {
        return $query->where('seats', '>=', $seats);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', 'like', '%' . $brand . '%');
    }

    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('daily_price_without_driver', '>=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $query->where('daily_price_without_driver', '<=', $maxPrice);
        }
        
        return $query;
    }

    // ========== STATISTIQUES ==========

    /**
     * Obtient le nombre de réservations totales
     */
    public function getTotalReservationsCount(): int
    {
        return $this->reservations()->count();
    }

    /**
     * Obtient le nombre de réservations actives
     */
    public function getActiveReservationsCount(): int
    {
        return $this->activeReservations()->count();
    }

    /**
     * Obtient le chiffre d'affaires total généré par cette voiture
     */
    public function getTotalRevenue(): float
    {
        return $this->reservations()
            ->where('payment_status', 'paid')
            ->sum('final_total');
    }

    /**
     * Obtient les statistiques d'utilisation
     */
    public function getUsageStats(): array
    {
        $totalReservations = $this->getTotalReservationsCount();
        $completedReservations = $this->reservations()->where('status', 'completed')->count();
        $cancelledReservations = $this->reservations()->where('status', 'cancelled')->count();
        $totalRevenue = $this->getTotalRevenue();

        return [
            'total_reservations' => $totalReservations,
            'completed_reservations' => $completedReservations,
            'cancelled_reservations' => $cancelledReservations,
            'completion_rate' => $totalReservations > 0 ? round(($completedReservations / $totalReservations) * 100, 2) : 0,
            'total_revenue' => $totalRevenue
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'reservation_start_date',
        'reservation_end_date', 
        'reservation_start_time',
        'reservation_end_time',
        'total_days',
        'daily_rate',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'final_total',
        'with_driver',
        'status',
        'payment_status',
        'payment_method',
        'fedapay_transaction_id',
        'client_email',
        'client_phone',
        'client_location',        // ← Nouveau champ
        'deployment_zone',
        'contract_pdf_path',
        'terms_accepted',
        'extension_of',
        'one_hour_reminder_sent',
        'one_hour_reminder_sent_at',
        'end_reminder_sent',
        'end_reminder_sent_at',
        'cancellation_reason',
        'cancelled_at',
        'cancelled_by'
    ];

    protected $casts = [
        'reservation_start_date' => 'date',
        'reservation_end_date' => 'date',
        'total_days' => 'integer',
        'daily_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_total' => 'decimal:2',
        'with_driver' => 'boolean',
        'terms_accepted' => 'boolean',
        'one_hour_reminder_sent' => 'boolean',
        'one_hour_reminder_sent_at' => 'datetime',
        'end_reminder_sent' => 'boolean',
        'end_reminder_sent_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // ========== MÉTHODES DE CALCUL ==========

    /**
     * Calcule automatiquement les données de réservation
     * À appeler avant la sauvegarde
     */
    public function calculateReservationData()
    {
        if (!$this->reservation_start_date || !$this->reservation_end_date) {
            Log::warning('Dates de réservation manquantes pour le calcul', [
                'start_date' => $this->reservation_start_date,
                'end_date' => $this->reservation_end_date
            ]);
            return;
        }

        // ⭐ CORRECTION MAJEURE : Calcul du nombre de jours inclusif
        $startDate = Carbon::parse($this->reservation_start_date);
        $endDate = Carbon::parse($this->reservation_end_date);
        $this->total_days = $startDate->diffInDays($endDate); // ✅ +1 pour inclure le jour de fin

        Log::info('📅 Calcul des jours (méthode modèle - CORRIGÉE):', [
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'diffInDays' => $startDate->diffInDays($endDate),
            'total_days' => $this->total_days
        ]);

        // 2. Définir le tarif journalier selon avec/sans chauffeur
        if ($this->car) {
            $this->daily_rate = $this->car->getDailyPrice($this->with_driver);
            Log::info('💰 Tarif journalier depuis la voiture (méthode modèle):', [
                'with_driver' => $this->with_driver,
                'daily_rate' => $this->daily_rate
            ]);
        } else {
            // Valeurs par défaut si pas de voiture associée
            $this->daily_rate = $this->with_driver ? 30000.00 : 20000.00;
            Log::warning('Tarif journalier par défaut utilisé:', [
                'with_driver' => $this->with_driver,
                'daily_rate' => $this->daily_rate
            ]);
        }

        // 3. Calculer le sous-total (avant réduction)
        $this->subtotal = $this->total_days * $this->daily_rate;

        // 4. Calculer la réduction - ✅ CORRECTION DES SEUILS
        $this->discount_percentage = $this->getDiscountPercentage($this->total_days);
        $this->discount_amount = round($this->subtotal * ($this->discount_percentage / 100), 2);

        // 5. Calculer le total final
        $this->final_total = $this->subtotal - $this->discount_amount;

        Log::info('🧮 Calculs complets de réservation (méthode modèle) AVEC RÉDUCTIONS CORRIGÉES:', [
            'source' => 'calculateReservationData()',
            'total_days' => $this->total_days,
            'daily_rate' => $this->daily_rate,
            'subtotal' => $this->subtotal,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'final_total' => $this->final_total,
            'discount_applied' => $this->discount_percentage > 0,
            'test_14_jours_30k' => [
                'should_be_336000' => ($this->total_days === 14 && $this->daily_rate == 30000),
                'calculation_check' => "14j × 30000 - 20% = " . $this->final_total
            ]
        ]);

        // 6. Calculer l'heure de fin (même que l'heure de début)
        if ($this->reservation_start_time) {
            $this->reservation_end_time = $this->reservation_start_time;
        }
    }
    /**
     * Calcule le pourcentage de réduction selon le nombre de jours
     */
    protected function getDiscountPercentage(int $days): float
    {
        if ($days >= 14) {
            Log::info('💳 Réduction 20% appliquée (14+ jours)', ['days' => $days]);
            return 20.0; // ✅ 20% pour 14 jours et plus
        } elseif ($days >= 10) {
            Log::info('💳 Réduction 18% appliquée (10-13 jours)', ['days' => $days]);
            return 18.0; // ✅ 18% pour 10-13 jours
        } elseif ($days >= 7) {
            Log::info('💳 Réduction 15% appliquée (7-9 jours)', ['days' => $days]);
            return 15.0; // ✅ 15% pour 7-9 jours
        }
        
        Log::info('💳 Aucune réduction appliquée', ['days' => $days]);
        return 0.0; // Pas de réduction pour moins de 7 jours
    }

    /**
     * Boot method pour calculer automatiquement les données
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($reservation) {
            // ✅ VÉRIFICATION PLUS PRÉCISE : Ne recalculer QUE si VRAIMENT nécessaire
            $hasAllCalculatedData = !empty($reservation->final_total) && 
                                !empty($reservation->subtotal) && 
                                !empty($reservation->daily_rate) && 
                                $reservation->total_days > 0 &&
                                $reservation->final_total > 0; // Vérifier que le montant est cohérent

            if ($hasAllCalculatedData) {
                Log::info('🔄 Données de réservation complètes trouvées - conservation des calculs existants', [
                    'source' => 'boot_method',
                    'total_days' => $reservation->total_days,
                    'daily_rate' => $reservation->daily_rate,
                    'subtotal' => $reservation->subtotal,
                    'discount_percentage' => $reservation->discount_percentage,
                    'discount_amount' => $reservation->discount_amount,
                    'final_total' => $reservation->final_total,
                    'has_discount' => $reservation->discount_percentage > 0
                ]);
                return; // ✅ NE PAS RECALCULER - Conserver les données précises du contrôleur
            }
            
            // Ne calculer que si VRAIMENT nécessaire (création sans données complètes)
            if (empty($reservation->final_total) || $reservation->final_total <= 0) {
                Log::info('🧮 Calcul automatique nécessaire - données manquantes ou incomplètes');
                $reservation->calculateReservationData();
            }
        });
    }

    // ========== RELATIONS ==========

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function extensions()
    {
        return $this->hasMany(Reservation::class, 'extension_of');
    }
    
    public function originalReservation()
    {
        return $this->belongsTo(Reservation::class, 'extension_of');
    }

    // ========== SCOPES ==========

    public function scopeNeedingOneHourReminder($query)
    {
        return $query->where('status', 'active')
                    ->where('one_hour_reminder_sent', false)
                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()->addHour()])
                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()]);
    }

    public function scopeNeedingEndReminder($query)
    {
        return $query->where('status', 'active')
                    ->where('end_reminder_sent', false)
                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()])
                    ->whereRaw("CONCAT(reservation_start_date, ' ', reservation_start_time) <= ?", [now()]);
    }

    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()])
              ->orWhere('status', 'expired');
        });
    }

    public function scopeNeedingStatusUpdate($query)
    {
        return $query->where('status', 'active')
                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) < ?", [now()->subMinutes(30)]);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ========== MÉTHODES DE VÉRIFICATION D'ÉTAT ==========

    public function isActive(): bool
    {
        $now = now();
        $startDateTime = $this->getStartDateTime();
        $endDateTime = $this->getEndDateTime();
        
        return $this->status === 'active' && 
               $endDateTime > $now && 
               $startDateTime <= $now;
    }

    public function isScheduled(): bool
    {
        $now = now();
        $startDateTime = $this->getStartDateTime();
        
        return $this->status === 'active' && $startDateTime > $now;
    }

    public function isExpired(): bool
    {
        $endDateTime = $this->getEndDateTime();
        return $endDateTime <= now() || $this->status === 'expired';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPaymentPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentCompleted(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled(): bool
    {
        if ($this->isCancelled() || $this->isCompleted()) {
            return false;
        }

        if ($this->isPending()) {
            return true;
        }

        if ($this->isActive()) {
            $startDateTime = $this->getStartDateTime();
            return $startDateTime->diffInHours(now()) > 2;
        }

        return false;
    }

    // ========== MÉTHODES UTILITAIRES DATETIME ==========

    /**
     * Obtient datetime de début
     */
    public function getStartDateTime(): Carbon
    {
        try {
            $dateTimeString = $this->reservation_start_date . ' ' . $this->reservation_start_time;
            return Carbon::parse($dateTimeString);
        } catch (\Exception $e) {
            $date = Carbon::parse($this->reservation_start_date);
            
            if (is_string($this->reservation_start_time)) {
                $timeParts = explode(':', $this->reservation_start_time);
            } else {
                $timeParts = [
                    $this->reservation_start_time->format('H'),
                    $this->reservation_start_time->format('i')
                ];
            }
            
            return $date->setTime($timeParts[0], $timeParts[1], 0);
        }
    }

    /**
     * Obtient datetime de fin
     */
    public function getEndDateTime(): Carbon
    {
        try {
            $dateTimeString = $this->reservation_end_date . ' ' . $this->reservation_end_time;
            return Carbon::parse($dateTimeString);
        } catch (\Exception $e) {
            $date = Carbon::parse($this->reservation_end_date);
            
            if (is_string($this->reservation_end_time)) {
                $timeParts = explode(':', $this->reservation_end_time);
            } else {
                $timeParts = [
                    $this->reservation_end_time->format('H'),
                    $this->reservation_end_time->format('i')
                ];
            }
            
            return $date->setTime($timeParts[0], $timeParts[1], 0);
        }
    }

    /**
     * Obtient la vraie date de fin (en tenant compte des extensions payées)
     */
    public function getRealEndDateTime(): Carbon
    {
        $lastPaidExtension = $this->extensions()
            ->where('payment_status', 'paid')
            ->orderBy('reservation_end_date', 'desc')
            ->orderBy('reservation_end_time', 'desc')
            ->first();

        if ($lastPaidExtension) {
            return $lastPaidExtension->getEndDateTime();
        }

        return $this->getEndDateTime();
    }

    /**
     * Obtient la durée totale en heures
     */
    public function getTotalDurationHours(): int
    {
        return $this->total_days * 24;
    }

    /**
     * Obtient la durée totale avec extensions en heures
     */
    public function getTotalDurationWithExtensions(): int
    {
        $totalDays = $this->total_days;
        
        $paidExtensions = $this->extensions()->where('payment_status', 'paid')->get();
        foreach ($paidExtensions as $extension) {
            $totalDays += $extension->total_days;
        }
        
        return $totalDays * 24;
    }

    /**
     * Obtient le temps restant formaté
     */
    public function getTimeRemaining(): string
    {
        $now = now();
        $endDateTime = $this->getRealEndDateTime();
        
        if ($endDateTime <= $now) {
            return '00h-00m-00s';
        }
        
        $startDateTime = $this->getStartDateTime();
        
        if ($startDateTime > $now) {
            $diff = $startDateTime->diff($now);
            return sprintf(
                '%dj-%02dh-%02dm-%02ds',
                $diff->days,
                $diff->h,
                $diff->i,
                $diff->s
            );
        }
        
        $diff = $endDateTime->diff($now);
        return sprintf(
            '%02dh-%02dm-%02ds',
            $diff->h + ($diff->days * 24),
            $diff->i,
            $diff->s
        );
    }

    /**
     * Obtient le pourcentage de progression
     */
    public function getProgressPercentage(): float
    {
        $now = now();
        $startDateTime = $this->getStartDateTime();
        $endDateTime = $this->getRealEndDateTime();
        
        if ($startDateTime > $now) {
            return 0;
        }
        
        if ($endDateTime <= $now) {
            return 100;
        }
        
        $totalDuration = $startDateTime->diffInSeconds($endDateTime);
        $elapsed = $startDateTime->diffInSeconds($now);
        
        return min(100, max(0, ($elapsed / $totalDuration) * 100));
    }

    /**
     * Obtient le statut détaillé
     */
    public function getDetailedStatus(): array
    {
        $now = now();
        $startDateTime = $this->getStartDateTime();
        $endDateTime = $this->getRealEndDateTime();
        
        if ($endDateTime <= $now) {
            return [
                'status' => 'expired',
                'label' => 'Expiré',
                'color' => 'red',
                'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists()
            ];
        }
        
        if ($startDateTime > $now) {
            return [
                'status' => 'scheduled',
                'label' => 'Programmé', 
                'color' => 'blue',
                'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists()
            ];
        }
        
        $hoursLeft = $now->diffInHours($endDateTime);
        
        if ($hoursLeft < 1) {
            return [
                'status' => 'urgent',
                'label' => 'Urgent',
                'color' => 'red',
                'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists()
            ];
        } elseif ($hoursLeft < 24) {
            return [
                'status' => 'warning',
                'label' => 'Attention',
                'color' => 'orange',
                'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists()
            ];
        } else {
            return [
                'status' => 'active',
                'label' => 'En cours',
                'color' => 'green',
                'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists()
            ];
        }
    }

    // ========== MÉTHODES D'EXTENSION ==========

    /**
     * Vérifie si la réservation peut être prolongée
     */
    public function canBeExtended(): bool
    {
        return $this->isActive() && 
               $this->payment_status === 'paid' && 
               !$this->hasActiveSelfExtension() && 
               $this->getRemainingSeconds() >= 3600; // 1 heure minimum
    }

    /**
     * Vérifie s'il y a une extension active en cours
     */
    public function hasActiveSelfExtension(): bool
    {
        return $this->extensions()
            ->whereIn('status', ['pending', 'active'])
            ->where('payment_status', '!=', 'failed')
            ->exists();
    }

    /**
     * Obtient le message d'erreur pour l'extension
     */
    public function getExtensionErrorMessage(): string
    {
        if (!$this->isActive()) {
            return 'La réservation n\'est pas active';
        }
        
        if ($this->payment_status !== 'paid') {
            return 'Le paiement n\'est pas confirmé';
        }
        
        if ($this->hasActiveSelfExtension()) {
            return 'Une prolongation est déjà en cours';
        }
        
        $remainingSeconds = $this->getRemainingSeconds();
        if ($remainingSeconds < 3600) {
            $remainingMinutes = floor($remainingSeconds / 60);
            $remainingSecondsDisplay = $remainingSeconds % 60;
            return "Prolongation bloquée : il reste {$remainingMinutes}m {$remainingSecondsDisplay}s (minimum requis : 1h)";
        }
        
        return 'Prolongation non disponible';
    }

    /**
     * Obtient le temps restant en secondes
     */
    public function getRemainingSeconds(): int
    {
        return max(0, now()->diffInSeconds($this->getRealEndDateTime()));
    }

    // ========== MÉTHODES DE GESTION D'ÉTAT ==========

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
        if ($this->car) {
            $this->car->update(['status' => 'available']);
        }
    }

    public static function markExpiredReservations()
    {
        $expiredIds = static::where('status', 'active')
                            ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()])
                            ->whereDoesntHave('extensions', function($query) {
                                $query->where('payment_status', 'paid')
                                      ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()]);
                            })
                            ->pluck('id');
        
        if ($expiredIds->isNotEmpty()) {
            static::whereIn('id', $expiredIds)->update(['status' => 'expired']);
            
            $carIds = static::whereIn('id', $expiredIds)->pluck('car_id')->unique();
            Car::whereIn('id', $carIds)->update(['status' => 'available']);
            
            Log::info('Réservations marquées comme expirées', [
                'count' => $expiredIds->count(),
                'reservation_ids' => $expiredIds->toArray()
            ]);
        }
    }

    // ========== SCOPES AVEC EXTENSIONS ==========

    public function scopeWithExtensions($query)
    {
        return $query->with(['extensions' => function($q) {
            $q->orderBy('created_at', 'asc');
        }]);
    }

    public function scopeExpiredWithExtensions($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()])
                          ->whereDoesntHave('extensions', function($extensionQuery) {
                              $extensionQuery->whereIn('status', ['active', 'pending'])
                                            ->where('payment_status', 'paid');
                          });
                    })->orWhere(function ($q) {
                        $q->whereHas('extensions', function($extensionQuery) {
                              $extensionQuery->where('payment_status', 'paid');
                          })
                          ->whereRaw('(
                              SELECT MAX(CONCAT(reservation_end_date, " ", reservation_end_time)) 
                              FROM reservations as extensions 
                              WHERE extensions.extension_of = reservations.id 
                              AND extensions.payment_status = "paid"
                          ) <= ?', [now()]);
                    })->whereNull('extension_of');
    }

    public function scopeNeedingEndReminderWithExtensions($query)
    {
        return $query->where('status', 'active')
                    ->where('end_reminder_sent', false)
                    ->where(function ($q) {
                        $q->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()])
                          ->whereDoesntHave('extensions', function($extensionQuery) {
                              $extensionQuery->where('payment_status', 'paid');
                          });
                    })->orWhere(function ($q) {
                        $q->whereHas('extensions', function($extensionQuery) {
                              $extensionQuery->where('payment_status', 'paid');
                          })
                          ->whereRaw('(
                              SELECT MAX(CONCAT(reservation_end_date, " ", reservation_end_time)) 
                              FROM reservations as extensions 
                              WHERE extensions.extension_of = reservations.id 
                              AND extensions.payment_status = "paid"
                          ) <= ?', [now()]);
                    })
                    ->whereNull('extension_of');
    }

    public function scopeNeedingOneHourReminderWithExtensions($query)
    {
        return $query->where('status', 'active')
                    ->where('one_hour_reminder_sent', false)
                    ->where(function ($q) {
                        $q->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) <= ?", [now()->addHour()])
                          ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()])
                          ->whereDoesntHave('extensions', function($extensionQuery) {
                              $extensionQuery->where('payment_status', 'paid');
                          });
                    })->orWhere(function ($q) {
                        $q->whereHas('extensions', function($extensionQuery) {
                              $extensionQuery->where('payment_status', 'paid');
                          })
                          ->whereRaw('(
                              SELECT MAX(CONCAT(reservation_end_date, " ", reservation_end_time)) 
                              FROM reservations as extensions 
                              WHERE extensions.extension_of = reservations.id 
                              AND extensions.payment_status = "paid"
                          ) <= ? AND (
                              SELECT MAX(CONCAT(reservation_end_date, " ", reservation_end_time)) 
                              FROM reservations as extensions 
                              WHERE extensions.extension_of = reservations.id 
                              AND extensions.payment_status = "paid"
                          ) > ?', [now()->addHour(), now()]);
                    })
                    ->whereNull('extension_of');
    }

    // ========== MÉTHODES D'HISTORIQUE ==========

    /**
     * Obtient l'historique complet de la réservation
     */
    public function getHistory(): array
    {
        $history = [];
        
        $history[] = [
            'type' => 'initial',
            'date' => $this->created_at,
            'start_date' => $this->getStartDateTime(),
            'end_date' => $this->getEndDateTime(),
            'total_days' => $this->total_days,
            'price' => $this->final_total,
            'status' => $this->status,
            'payment_status' => $this->payment_status
        ];
        
        foreach ($this->extensions()->orderBy('created_at', 'asc')->get() as $extension) {
            $history[] = [
                'type' => 'extension',
                'date' => $extension->created_at,
                'start_date' => $extension->getStartDateTime(),
                'end_date' => $extension->getEndDateTime(),
                'total_days' => $extension->total_days,
                'price' => $extension->final_total,
                'status' => $extension->status,
                'payment_status' => $extension->payment_status
            ];
        }
        
        return $history;
    }

    /**
     * Obtient le statut étendu de la réservation
     */
    public function getExtendedStatusAttribute(): string
    {
        $status = $this->getDetailedStatus();
        
        if ($this->extensions()->where('status', 'pending')->exists()) {
            return 'Extension en attente';
        }
        
        if ($this->extensions()->where('status', 'active')->exists()) {
            return $status['label'] . ' (Prolongée)';
        }
        
        return $status['label'];
    }

    /**
     * Obtient les informations complètes de timing avec extensions
     */
    public function getTimingInfo(): array
    {
        $now = now();
        $realEndDate = $this->getRealEndDateTime();
        $totalDurationWithExtensions = $this->getTotalDurationWithExtensions();
        
        return [
            'start_date' => $this->getStartDateTime(),
            'end_date' => $this->getEndDateTime(),
            'real_end_date' => $realEndDate,
            'current_time' => $now,
            'total_duration_hours' => $this->getTotalDurationHours(),
            'total_duration_with_extensions' => $totalDurationWithExtensions,
            'elapsed_hours' => $this->getStartDateTime() <= $now ? $this->getStartDateTime()->diffInHours($now) : 0,
            'remaining_hours' => $realEndDate > $now ? $now->diffInHours($realEndDate) : 0,
            'progress_percentage' => $this->getProgressPercentage(),
            'detailed_status' => $this->getDetailedStatus(),
            'time_remaining_formatted' => $this->getTimeRemaining(),
            'has_extensions' => $this->extensions()->where('payment_status', 'paid')->exists(),
            'extensions_count' => $this->extensions()->where('payment_status', 'paid')->count()
        ];
    }

    // ========== ACCESSEURS POUR COMPATIBILITÉ TEMPORAIRE ==========
    
    /**
     * Accesseur pour obtenir le prix total (compatibilité)
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->final_total;
    }

    /**
     * Accesseur pour obtenir la durée en format texte (compatibilité)
     */
    public function getDurationAttribute(): string
    {
        return $this->total_days . ' jour' . ($this->total_days > 1 ? 's' : '');
    }

    /**
     * Accesseur pour obtenir la date de début (compatibilité)
     */
    public function getStartDateAttribute(): string
    {
        return $this->reservation_start_date->format('Y-m-d');
    }

    /**
     * Accesseur pour obtenir la date de fin (compatibilité)
     */
    public function getEndDateAttribute(): string
    {
        return $this->reservation_end_date->format('Y-m-d');
    }

    /**
     * Accesseur pour obtenir l'heure de début (compatibilité)
     */
    public function getStartTimeAttribute(): string
    {
        return $this->reservation_start_time;
    }

    /**
     * Accesseur pour obtenir l'heure de fin (compatibilité)
     */
    public function getEndTimeAttribute(): string
    {
        return $this->reservation_end_time;
    }


    public function getEndDateTimeAttribute()
{
    try {
        if ($this->reservation_end_time) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $this->reservation_end_time)) {
                return Carbon::parse($this->reservation_end_time);
            } else {
                $time = Carbon::parse($this->reservation_end_time)->format('H:i:s');
                return Carbon::parse($this->reservation_end_date . ' ' . $time);
            }
        } else {
            return Carbon::parse($this->reservation_end_date . ' 23:59:59');
        }
    } catch (\Exception $e) {
        return Carbon::parse($this->reservation_end_date . ' 23:59:59');
    }
}


}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    /**
     * Scope pour les notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope pour les notifications lues
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Marquer la notification comme lue
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Vérifier si la notification est lue
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Créer une notification pour réservation expirée
     */
    public static function createExpiredReservationNotification($reservation)
    {
        return self::create([
            'type' => 'expired_reservation',
            'title' => 'Réservation expirée',
            'message' => "La réservation de la voiture {$reservation->car->name} faite par {$reservation->user->name} vient d'être expirée",
            'data' => [
                'reservation_id' => $reservation->id,
                'user_name' => $reservation->user->name,
                'car_name' => $reservation->car->name,
                'expired_at' => $reservation->getRealEndDate()->toISOString()
            ]
        ]);
    }

    /**
     * Obtenir le nombre de notifications non lues
     */
    public static function getUnreadCount()
    {
        return self::unread()->count();
    }

    /**
     * Obtenir les notifications récentes non lues
     */
    public static function getRecentUnread($limit = 10)
    {
        return self::unread()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public static function markAllAsRead()
    {
        return self::unread()->update(['read_at' => now()]);
    }
}
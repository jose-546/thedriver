<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UpdateReservationStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Activer les réservations qui commencent
        Reservation::where('start_date', '<=', now())
            ->where('status', 'pending')
            ->update(['status' => 'active']);

        // Marquer les voitures comme réservées
        $activeReservations = Reservation::where('status', 'active')
            ->whereHas('car', function($q) {
                $q->where('status', '!=', 'reserved');
            })->with('car')->get();

        foreach ($activeReservations as $reservation) {
            $reservation->car->markAsReserved();
        }

        // Désactiver les réservations terminées
        $expiredReservations = Reservation::where('end_date', '<=', now())
            ->where('status', 'active')
            ->with('car')->get();

        foreach ($expiredReservations as $reservation) {
            $reservation->update(['status' => 'completed']);
            
            // Vérifier s'il n'y a pas d'autres réservations en cours
            $hasActiveReservations = Reservation::where('car_id', $reservation->car_id)
                ->where('status', 'active')
                ->exists();

            if (!$hasActiveReservations) {
                $reservation->car->markAsAvailable();
            }
        }
    }
}
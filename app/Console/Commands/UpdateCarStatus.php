<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Car;
use Carbon\Carbon;

class UpdateCarStatus extends Command
{
    protected $signature = 'cars:update-status';
    protected $description = 'Met à jour le statut des voitures selon les réservations';

    public function handle()
    {
        $now = Carbon::now();
        
        // Marquer les voitures comme réservées si leur réservation commence aujourd'hui
        $startingReservations = Reservation::where('status', 'active')
            ->whereDate('start_date', $now->toDateString())
            ->with('car')
            ->get();
            
        foreach ($startingReservations as $reservation) {
            if ($reservation->car->status !== 'reserved') {
                $reservation->car->markAsReserved();
                $this->info("Voiture {$reservation->car->getFullName()} marquée comme réservée");
            }
        }
        
        // Marquer les voitures comme disponibles si leur réservation se termine aujourd'hui
        $endingReservations = Reservation::where('status', 'active')
            ->whereDate('end_date', $now->toDateString())
            ->with('car')
            ->get();
            
        foreach ($endingReservations as $reservation) {
            // Vérifier qu'il n'y a pas d'autre réservation qui commence
            $hasNextReservation = Reservation::where('car_id', $reservation->car_id)
                ->where('status', 'active')
                ->where('start_date', '<=', $now->addDay())
                ->where('id', '!=', $reservation->id)
                ->exists();
                
            if (!$hasNextReservation) {
                $reservation->car->markAsAvailable();
                $this->info("Voiture {$reservation->car->getFullName()} marquée comme disponible");
            }
            
            // Marquer la réservation comme terminée
            $reservation->update(['status' => 'completed']);
        }
        
        // Marquer les réservations expirées
        $expiredReservations = Reservation::where('status', 'active')
            ->where('end_date', '<', $now)
            ->get();
            
        foreach ($expiredReservations as $reservation) {
            $reservation->markAsExpired();
            $this->info("Réservation {$reservation->id} marquée comme expirée");
        }
        
        $this->info('Mise à jour des statuts terminée');
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\AdminNotification;

class CheckExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reservations:check-expired';

    /**
     * The console command description.
     */
    protected $description = 'Vérifier les réservations expirées et créer des notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VÉRIFICATION DES RÉSERVATIONS EXPIRÉES ===');
        $this->info('Heure actuelle: ' . now()->format('d/m/Y H:i:s'));

        try {
            // Récupérer toutes les réservations actives
            $activeReservations = Reservation::with(['user', 'car', 'extensions'])
                ->where('status', 'active')
                ->whereNull('extension_of')
                ->get();

            $this->info("Nombre de réservations actives trouvées: " . $activeReservations->count());

            $newlyExpired = 0;
            $alreadyExpired = 0;
            $stillActive = 0;

            foreach ($activeReservations as $reservation) {
                $this->info("--- Vérification réservation #{$reservation->id} ---");
                
                try {
                    // Vérifier si la méthode existe
                    if (!method_exists($reservation, 'getRealEndDate')) {
                        $this->error("❌ Méthode getRealEndDate() manquante sur la réservation #{$reservation->id}");
                        continue;
                    }
                    
                    $realEndDate = $reservation->getRealEndDate();
                    $this->info("Date fin réelle: " . $realEndDate->format('d/m/Y H:i:s'));
                    $this->info("Est expirée: " . ($realEndDate->isPast() ? 'OUI' : 'NON'));
                    
                    if ($realEndDate->isPast()) {
                        $minutesAgo = $realEndDate->diffInMinutes(now());
                        $this->info("Expirée depuis: {$minutesAgo} minute(s)");
                        
                        // Vérifier qu'une notification n'existe pas déjà
                        $existingNotification = AdminNotification::where('type', 'expired_reservation')
                            ->where('data->reservation_id', $reservation->id)
                            ->first();

                        if (!$existingNotification) {
                            $this->info("🔔 Création d'une nouvelle notification...");
                            
                            // Vérifier les relations
                            if (!$reservation->user) {
                                $this->error("❌ Utilisateur manquant pour la réservation #{$reservation->id}");
                                continue;
                            }
                            
                            if (!$reservation->car) {
                                $this->error("❌ Voiture manquante pour la réservation #{$reservation->id}");
                                continue;
                            }
                            
                            AdminNotification::createExpiredReservationNotification($reservation);
                            $newlyExpired++;
                            
                            $this->info("✅ Notification créée pour la réservation #{$reservation->id}");
                        } else {
                            $this->info("ℹ️ Notification déjà existante (créée le " . $existingNotification->created_at . ")");
                            $alreadyExpired++;
                        }
                    } else {
                        $this->info("⏳ Réservation encore active");
                        $stillActive++;
                    }
                    
                } catch (\Exception $e) {
                    $this->error("❌ Erreur lors du traitement de la réservation #{$reservation->id}: " . $e->getMessage());
                }
            }

            $this->info("=== RÉSULTATS ===");
            $this->info("✅ Nouvelles notifications créées: {$newlyExpired}");
            $this->info("ℹ️ Déjà notifiées: {$alreadyExpired}");
            $this->info("⏳ Encore actives: {$stillActive}");
            
            // Afficher le total des notifications non lues
            $totalUnread = AdminNotification::getUnreadCount();
            $this->info("📊 Total notifications non lues: {$totalUnread}");
            
        } catch (\Exception $e) {
            $this->error("❌ Erreur générale: " . $e->getMessage());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
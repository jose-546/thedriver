<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Support\Facades\Log;

class SendReservationSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservation;
    public $reminderType;
    public $tries = 3;
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(Reservation $reservation, string $reminderType)
    {
        $this->reservation = $reservation;
        $this->reminderType = $reminderType; // 'one_hour' ou 'end'
    }

    /**
     * Execute the job.
     */
    public function handle(SmsService $smsService): void
    {
        try {
            // Vérifier que la réservation existe toujours et est active
            if (!$this->reservation || $this->reservation->status !== 'active') {
                Log::info('Réservation non active, SMS annulé', [
                    'reservation_id' => $this->reservation->id ?? 'unknown',
                    'reminder_type' => $this->reminderType
                ]);
                return;
            }

            // Vérifier que l'utilisateur a un numéro de téléphone
            $phoneNumber = $this->reservation->user->phone;
            if (!$phoneNumber) {
                Log::warning('Utilisateur sans numéro de téléphone', [
                    'user_id' => $this->reservation->user->id,
                    'reservation_id' => $this->reservation->id
                ]);
                return;
            }

            // Générer le message approprié
            $message = $this->generateMessage($smsService);
            
            // Envoyer le SMS
            $success = $smsService->sendSms($phoneNumber, $message);

            if ($success) {
                // Marquer le rappel comme envoyé dans la base de données
                $this->markReminderAsSent();
                
                Log::info('SMS de rappel envoyé avec succès', [
                    'reservation_id' => $this->reservation->id,
                    'user_id' => $this->reservation->user->id,
                    'reminder_type' => $this->reminderType,
                    'phone' => $phoneNumber
                ]);
            } else {
                throw new Exception('Échec de l\'envoi du SMS');
            }

        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS de rappel', [
                'reservation_id' => $this->reservation->id,
                'reminder_type' => $this->reminderType,
                'error' => $e->getMessage()
            ]);
            
            // Re-lancer l'exception pour que le job soit retenté
            throw $e;
        }
    }

    /**
     * Génère le message approprié selon le type de rappel
     */
    private function generateMessage(SmsService $smsService): string
    {
        switch ($this->reminderType) {
            case 'one_hour':
                return $smsService->generateOneHourReminderMessage($this->reservation);
            case 'end':
                return $smsService->generateEndReminderMessage($this->reservation);
            default:
                throw new Exception('Type de rappel invalide: ' . $this->reminderType);
        }
    }

    /**
     * Marque le rappel comme envoyé
     */
    private function markReminderAsSent(): void
    {
        $field = $this->reminderType === 'one_hour' ? 'one_hour_reminder_sent' : 'end_reminder_sent';
        
        $this->reservation->update([
            $field => true,
            $field . '_at' => now()
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        Log::error('Job SMS échoué définitivement', [
            'reservation_id' => $this->reservation->id,
            'reminder_type' => $this->reminderType,
            'error' => $exception->getMessage()
        ]);
    }
}
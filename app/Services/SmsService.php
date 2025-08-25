<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $client;
    protected $fromNumber;
    protected $sandboxMode;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
        
        $this->fromNumber = config('services.twilio.phone_number');
        $this->sandboxMode = config('services.twilio.sandbox_mode');
    }

    /**
     * Envoie un SMS via Twilio
     */
    public function sendSms(string $to, string $message): bool
    {
        try {
            // Formatage du numéro de téléphone
            $formattedNumber = $this->formatPhoneNumber($to);
            
            if (!$formattedNumber) {
                Log::error('Numéro de téléphone invalide: ' . $to);
                return false;
            }

            // En mode sandbox, préfixer le message
            if ($this->sandboxMode) {
                $message = "[SANDBOX] " . $message;
            }

            $result = $this->client->messages->create(
                $formattedNumber,
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );

            Log::info('SMS envoyé avec succès', [
                'to' => $formattedNumber,
                'sid' => $result->sid,
                'status' => $result->status
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS', [
                'to' => $to,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Formate le numéro de téléphone au format international
     */
    private function formatPhoneNumber(string $phone): ?string
    {
        // Supprime tous les espaces et caractères spéciaux
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Si le numéro commence par 0, on le remplace par +229 (Bénin)
        if (str_starts_with($phone, '0')) {
            $phone = '+229' . substr($phone, 1);
        }
        
        // Si le numéro ne commence pas par +, on ajoute +229
        if (!str_starts_with($phone, '+')) {
            $phone = '+229' . $phone;
        }
        
        // Validation basique du format
        if (strlen($phone) < 10 || strlen($phone) > 15) {
            return null;
        }
        
        return $phone;
    }

    /**
     * Génère le message de rappel 1h avant la fin
     */
    public function generateOneHourReminderMessage($reservation): string
    {
        $carName = $reservation->car->name ?? 'votre véhicule';
        $endTime = $reservation->end_date->format('d/m/Y à H:i');
        
        return "🚗 Rappel TheDriver: Votre réservation pour {$carName} se termine dans 1 heure ({$endTime}). Pensez à prolonger si nécessaire via votre espace client.";
    }

    /**
     * Génère le message de fin de réservation
     */
    public function generateEndReminderMessage($reservation): string
    {
        $carName = $reservation->car->name ?? 'votre véhicule';
        
        return "🚗 TheDriver: Votre réservation pour {$carName} vient de se terminer. Merci de restituer le véhicule. Pour une nouvelle réservation, visitez notre site.";
    }
}
<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Jobs\SendReservationSms;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckReservations extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reservations:check
                            {--dry-run : Affiche les actions sans les exécuter}';

    /**
     * The console command description.
     */
    protected $description = 'Vérifie les réservations et envoie les rappels SMS appropriés';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $isVerbose = $this->output->isVerbose();

        $this->info('🔍 Vérification des réservations en cours...');
        
        if ($isDryRun) {
            $this->warn('⚠️  Mode DRY-RUN activé - Aucun SMS ne sera envoyé');
        }

        $oneHourReminders = 0;
        $endReminders = 0;
        $expiredReservations = 0;

        try {
            $oneHourReminders = $this->checkOneHourReminders($isDryRun, $isVerbose);
            $endReminders = $this->checkEndReminders($isDryRun, $isVerbose);
            $expiredReservations = $this->checkExpiredReservations($isDryRun, $isVerbose);

            $this->displaySummary($oneHourReminders, $endReminders, $expiredReservations);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la vérification: ' . $e->getMessage());
            Log::error('Erreur dans CheckReservations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }

    private function checkOneHourReminders(bool $isDryRun, bool $isVerbose): int
    {
        $oneHourFromNow = Carbon::now()->addHour();
        
        $reservations = Reservation::where('status', 'active')
            ->where('one_hour_reminder_sent', false)
            ->where('end_date', '<=', $oneHourFromNow)
            ->where('end_date', '>', Carbon::now())
            ->with(['user', 'car'])
            ->get();

        if ($isVerbose) {
            $this->line("📱 Rappels 1h avant fin: {$reservations->count()} trouvé(s)");
        }

        foreach ($reservations as $reservation) {
            if ($isVerbose) {
                $this->line("  - Réservation #{$reservation->id} (fin: {$reservation->end_date->format('d/m/Y H:i')})");
            }

            if (!$isDryRun) {
                SendReservationSms::dispatch($reservation, 'one_hour');
            }
        }

        return $reservations->count();
    }

    private function checkEndReminders(bool $isDryRun, bool $isVerbose): int
    {
        $now = Carbon::now();
        
        $reservations = Reservation::where('status', 'active')
            ->where('end_reminder_sent', false)
            ->where('end_date', '<=', $now)
            ->with(['user', 'car'])
            ->get();

        if ($isVerbose) {
            $this->line("🔚 Rappels de fin: {$reservations->count()} trouvé(s)");
        }

        foreach ($reservations as $reservation) {
            if ($isVerbose) {
                $this->line("  - Réservation #{$reservation->id} (fin: {$reservation->end_date->format('d/m/Y H:i')})");
            }

            if (!$isDryRun) {
                SendReservationSms::dispatch($reservation, 'end');
            }
        }

        return $reservations->count();
    }

    private function checkExpiredReservations(bool $isDryRun, bool $isVerbose): int
    {
        $expiredReservations = Reservation::needingStatusUpdate()->get();

        if ($isVerbose) {
            $this->line("⏰ Réservations expirées: {$expiredReservations->count()} trouvée(s)");
        }

        foreach ($expiredReservations as $reservation) {
            if ($isVerbose) {
                $this->line("  - Réservation #{$reservation->id} → statut 'expired'");
            }

            if (!$isDryRun) {
                $reservation->update(['status' => 'expired']);
            }
        }

        return $expiredReservations->count();
    }

    private function displaySummary(int $oneHourReminders, int $endReminders, int $expiredReservations): void
    {
        $this->info('📊 Résumé des actions:');
        $this->table(
            ['Type d\'action', 'Nombre'],
            [
                ['Rappels 1h avant fin', $oneHourReminders],
                ['Rappels de fin', $endReminders],
                ['Réservations expirées', $expiredReservations],
                ['Total actions', $oneHourReminders + $endReminders + $expiredReservations]
            ]
        );

        if ($oneHourReminders + $endReminders + $expiredReservations === 0) {
            $this->comment('✨ Aucune action nécessaire pour le moment.');
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateTestReservations extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reservations:create-test
                            {--one-hour : Crée une réservation se terminant dans 1h}
                            {--ending-now : Crée une réservation se terminant maintenant}
                            {--expired : Crée une réservation expirée}
                            {--all : Crée tous les types de réservations de test}';

    /**
     * The console command description.
     */
    protected $description = 'Crée des réservations de test pour tester le système de rappels SMS';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧪 Création de réservations de test...');

        // Vérifier qu'on a des utilisateurs et des voitures
        if (!$this->checkRequirements()) {
            return Command::FAILURE;
        }

        $created = 0;

        if ($this->option('one-hour') || $this->option('all')) {
            $created += $this->createOneHourReservation();
        }

        if ($this->option('ending-now') || $this->option('all')) {
            $created += $this->createEndingNowReservation();
        }

        if ($this->option('expired') || $this->option('all')) {
            $created += $this->createExpiredReservation();
        }

        if ($created === 0) {
            $this->warn('Aucune réservation créée. Utilisez --one-hour, --ending-now, --expired ou --all');
            return Command::FAILURE;
        }

        $this->info("✅ {$created} réservation(s) de test créée(s) avec succès !");
        $this->comment('💡 Lancez "php artisan reservations:check --dry-run --verbose" pour voir les rappels détectés');

        return Command::SUCCESS;
    }

    /**
     * Vérifie les prérequis
     */
    private function checkRequirements(): bool
    {
        $userCount = User::count();
        $carCount = Car::where('status', 'available')->count();

        if ($userCount === 0) {
            $this->error('❌ Aucun utilisateur trouvé. Créez au moins un utilisateur d\'abord.');
            return false;
        }

        if ($carCount === 0) {
            $this->error('❌ Aucune voiture disponible trouvée. Créez au moins une voiture avec le statut "available".');
            return false;
        }

        return true;
    }

    /**
     * Crée une réservation se terminant dans 1h
     */
    private function createOneHourReservation(): int
    {
        $endDate = Carbon::now()->addMinutes(59); // Dans 59 minutes pour être sûr
        
        $reservation = $this->createReservation($endDate, 'Réservation test - fin dans 1h');
        
        $this->line("🕐 Réservation #{$reservation->id} créée - fin: {$endDate->format('d/m/Y H:i')}");
        
        return 1;
    }

    /**
     * Crée une réservation se terminant maintenant
     */
    private function createEndingNowReservation(): int
    {
        $endDate = Carbon::now()->subMinutes(1); // Il y a 1 minute
        
        $reservation = $this->createReservation($endDate, 'Réservation test - vient de finir');
        
        $this->line("🔚 Réservation #{$reservation->id} créée - fin: {$endDate->format('d/m/Y H:i')}");
        
        return 1;
    }

    /**
     * Crée une réservation expirée
     */
    private function createExpiredReservation(): int
    {
        $endDate = Carbon::now()->subHours(2); // Il y a 2 heures
        
        $reservation = $this->createReservation($endDate, 'Réservation test - expirée');
        
        $this->line("⏰ Réservation #{$reservation->id} créée - fin: {$endDate->format('d/m/Y H:i')}");
        
        return 1;
    }

    /**
     * Crée une réservation avec les paramètres donnés
     */
    private function createReservation(Carbon $endDate, string $notes): Reservation
    {
        $user = User::inRandomOrder()->first();
        $car = Car::where('status', 'available')->inRandomOrder()->first();
        
        $startDate = $endDate->copy()->subDays(1); // 1 jour de location
        
        return Reservation::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'client_email'=>$user->email,
            'client_phone'=>'+22996141780',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_hours' => 24,
            'with_driver' => false,
            'total_price' => 50000, // Prix fictif
            'status' => 'active',
            'payment_status' => 'paid',
            'payment_method' => 'test',
            'notes' => $notes,
            // Les champs de rappel restent à false par défaut
        ]);
    }
}
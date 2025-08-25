<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Champs pour suivre l'envoi des rappels
            $table->boolean('one_hour_reminder_sent')->default(false)->after('status');
            $table->datetime('one_hour_reminder_sent_at')->nullable()->after('one_hour_reminder_sent');
            $table->boolean('end_reminder_sent')->default(false)->after('one_hour_reminder_sent_at');
            $table->datetime('end_reminder_sent_at')->nullable()->after('end_reminder_sent');
            
            // Champs d'annulation
            $table->text('cancellation_reason')->nullable()->after('end_reminder_sent_at');
            $table->datetime('cancelled_at')->nullable()->after('cancellation_reason');
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null')->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by']);
            $table->dropColumn([
                'one_hour_reminder_sent',
                'one_hour_reminder_sent_at',
                'end_reminder_sent',
                'end_reminder_sent_at',
                'cancellation_reason',
                'cancelled_at',
                'cancelled_by'
            ]);
        });
    }
};
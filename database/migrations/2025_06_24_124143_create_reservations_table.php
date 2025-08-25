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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('extension_of')->nullable();
            $table->foreign('extension_of')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->date('reservation_start_date');
            $table->date('reservation_end_date');
            $table->time('reservation_start_time');
            $table->time('reservation_end_time');
            $table->integer('total_days');
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->boolean('with_driver')->default(false);
            $table->decimal('final_total', 10, 2);
            $table->enum('status', ['pending', 'active', 'expired', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('fedapay_transaction_id')->nullable();
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('client_location');
            $table->string('deployment_zone');
            $table->string('contract_pdf_path')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['user_id', 'status']);
            $table->index(['car_id', 'status']);
            $table->index(['status', 'reservation_end_date']);
            $table->index(['reservation_start_date', 'reservation_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('license_plate')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('fuel_type', ['essence', 'diesel', 'electrique', 'hybride']);
            $table->enum('transmission', ['manuelle', 'automatique']);
            $table->integer('seats');
            $table->enum('status', ['available', 'reserved', 'maintenance'])->default('available');
            $table->decimal('daily_price_without_driver', 10, 2);
            $table->decimal('daily_price_with_driver', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
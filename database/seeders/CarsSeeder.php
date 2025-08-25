<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Corolla 2023',
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2023,
                'license_plate' => 'AA-001-BB',
                'description' => 'Voiture économique et fiable, parfaite pour les trajets en ville et les voyages.',
                'fuel_type' => 'essence',
                'transmission' => 'automatique',
                'seats' => 5,
                'status' => 'available',
                'daily_price_without_driver' => 20000,
                'daily_price_with_driver' => 30000,
            ],
            [
                'name' => 'Honda Civic 2022',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2022,
                'license_plate' => 'BB-002-CC',
                'description' => 'Berline moderne avec toutes les commodités pour un voyage confortable.',
                'fuel_type' => 'essence',
                'transmission' => 'manuelle',
                'seats' => 5,
                'status' => 'available',
                'daily_price_without_driver' => 22000,
                'daily_price_with_driver' => 32000,
            ],
            [
                'name' => 'Nissan Pathfinder 2023',
                'brand' => 'Nissan',
                'model' => 'Pathfinder',
                'year' => 2023,
                'license_plate' => 'CC-003-DD',
                'description' => 'SUV spacieux idéal pour les familles et les groupes, avec 7 places.',
                'fuel_type' => 'essence',
                'transmission' => 'automatique',
                'seats' => 7,
                'status' => 'available',
                'daily_price_without_driver' => 25000,
                'daily_price_with_driver' => 35000,
            ],
            [
                'name' => 'Hyundai Elantra 2022',
                'brand' => 'Hyundai',
                'model' => 'Elantra',
                'year' => 2022,
                'license_plate' => 'DD-004-EE',
                'description' => 'Berline élégante avec une consommation réduite et un design moderne.',
                'fuel_type' => 'essence',
                'transmission' => 'automatique',
                'seats' => 5,
                'status' => 'available',
                'daily_price_without_driver' => 30000,
                'daily_price_with_driver' => 40000,
            ],
            [
                'name' => 'Ford Transit 2023',
                'brand' => 'Ford',
                'model' => 'Transit',
                'year' => 2023,
                'license_plate' => 'EE-005-FF',
                'description' => 'Minibus 9 places parfait pour les événements et les déplacements de groupe.',
                'fuel_type' => 'diesel',
                'transmission' => 'manuelle',
                'seats' => 9,
                'status' => 'available',
                'daily_price_without_driver' => 36000,
                'daily_price_with_driver' => 46000,
            ],
            [
                'name' => 'Peugeot 308 2022',
                'brand' => 'Peugeot',
                'model' => '308',
                'year' => 2022,
                'license_plate' => 'FF-006-GG',
                'description' => 'Voiture française compacte, économique et confortable pour la conduite urbaine.',
                'fuel_type' => 'diesel',
                'transmission' => 'manuelle',
                'seats' => 5,
                'status' => 'available',
                'daily_price_without_driver' => 40000,
                'daily_price_with_driver' => 50000,
            ]
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }
    }
}
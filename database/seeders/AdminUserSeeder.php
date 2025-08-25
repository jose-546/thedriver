<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur',
            'username' => 'WiDriveU',
            'email' => 'admin@carrental.com',
            'password' => Hash::make('password123'),
            'phone' => '+229 12 34 56 78',
            'address' => 'Abomey-Calavi, Bénin',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
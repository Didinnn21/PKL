<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kestore.id',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
            'is_admin' => true,
        ]);

        // Buat Member
        User::create([
            'name' => 'Member',
            'email' => 'member@kestore.id',
            'password' => Hash::make('Member123'),
            'role' => 'member',
            'is_admin' => false,
        ]);
    }
}

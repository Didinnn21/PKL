<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Member 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'birth_date' => '1995-05-20',
        ]);

        // Member 2
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '089876543210',
            'address' => 'Jl. Kebon Jeruk No. 12, Bandung',
            'birth_date' => '1998-12-10',
        ]);

        // Buat 10 member acak pakai Factory (Opsional)
        // User::factory(10)->create(['role' => 'member']);
    }
}

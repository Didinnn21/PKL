<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kestore.id',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
            'is_admin' => true,
        ]);

        $this->call([
            AdminUserSeeder::class,
            ProductSeeder::class, // TAMBAHKAN BARIS INI
        ]);
        // Atau jika ingin menggunakan seeder terpisah, uncomment baris berikut:
        // $this->call([
        //     UserSeeder::class,
        // ]);
    }
}

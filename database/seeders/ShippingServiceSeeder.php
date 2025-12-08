<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingService;

class ShippingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'JNE - REG',
                'price' => 15000,
                'etd' => '2-3 Hari',
            ],
            [
                'name' => 'JNE - YES',
                'price' => 25000,
                'etd' => '1 Hari',
            ],
            [
                'name' => 'J&T - EZ',
                'price' => 16000,
                'etd' => '2-4 Hari',
            ],
            [
                'name' => 'SiCepat - REG',
                'price' => 14000,
                'etd' => '2-3 Hari',
            ],
            [
                'name' => 'GoSend - Instant',
                'price' => 30000,
                'etd' => 'Hari ini',
            ],
        ];

        foreach ($services as $service) {
            ShippingService::create($service);
        }
    }
}

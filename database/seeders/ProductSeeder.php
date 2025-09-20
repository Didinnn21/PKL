<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Kestore Hoodie Custom',
            'description' => 'Hoodie custom satuan & lusinan dengan bahan Cotton Fleece 280gsm. Sablon DTF untuk satuan dan Plastisol untuk pesanan minimal 12pcs.',
            'price' => 250000,
            'stock' => 150,
            'image_url' => 'images/product/P-HOODIE.jpg',
        ]);

        Product::create([
            'name' => 'Kestore Crewneck Custom',
            'description' => 'Crewneck custom satuan & lusinan, desain eksklusif untuk mengekspresikan gayamu. Bahan nyaman dan berkualitas tinggi.',
            'price' => 225000,
            'stock' => 200,
            'image_url' => 'images/product/P-CREWNECK.jpg',
        ]);

        Product::create([
            'name' => 'Kestore Kaos Custom',
            'description' => 'Kaos custom satuan & lusinan dengan desain depan dan belakang. Kualitas sablon premium yang awet dan tidak mudah pudar.',
            'price' => 120000,
            'stock' => 500,
            'image_url' => 'images/product/P-KAOS.jpg',
        ]);
    }
}

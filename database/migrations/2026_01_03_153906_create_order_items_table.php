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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Menghubungkan ke tabel orders (Wajib ada)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Menghubungkan ke tabel products (Wajib ada)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2)->default(0); // Harga saat beli

            $table->timestamps();
        });
    }
};

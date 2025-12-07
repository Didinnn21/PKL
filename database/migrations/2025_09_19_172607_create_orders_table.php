<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // UBAH DI SINI: product_id dibuat nullable agar bisa simpan custom order
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('total_price', 15, 2); // Disarankan perbesar presisi harga
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->string('design_file')->nullable();
            $table->text('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

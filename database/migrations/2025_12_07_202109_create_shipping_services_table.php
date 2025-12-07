<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: JNE - REG
            $table->decimal('price', 10, 2); // Contoh: 15000
            $table->string('etd')->nullable(); // Estimasi: 2-3 Hari
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_services');
    }
};

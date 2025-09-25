<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary(); // Nama pengaturannya, e.g., 'store_name'
            $table->text('value')->nullable(); // Nilai pengaturannya
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

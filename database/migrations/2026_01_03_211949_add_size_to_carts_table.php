<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambahkan kolom size pada tabel keranjang
        Schema::table('carts', function (Blueprint $table) {
            $table->string('size')->nullable()->after('quantity');
        });
        // Tambahkan kolom size pada tabel item pesanan (untuk riwayat pesanan)
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('size')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('size');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};

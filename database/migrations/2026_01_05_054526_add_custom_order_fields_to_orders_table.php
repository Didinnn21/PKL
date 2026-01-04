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
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom untuk membedakan katalog vs custom
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->string('order_type')->default('regular')->after('user_id');
            }
            // Menambahkan kolom jenis produk kustom (Hoodie/Kaos)
            if (!Schema::hasColumn('orders', 'product_type')) {
                $table->string('product_type')->nullable()->after('order_type');
            }
            // Menambahkan kolom file desain kustom
            if (!Schema::hasColumn('orders', 'design_file')) {
                $table->string('design_file')->nullable()->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};

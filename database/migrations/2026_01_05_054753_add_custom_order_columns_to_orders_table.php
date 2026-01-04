<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek satu per satu untuk memastikan kolom tidak duplikat saat migrasi
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->string('order_type')->default('regular')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'product_type')) {
                $table->string('product_type')->nullable()->after('order_type');
            }
            if (!Schema::hasColumn('orders', 'size')) {
                $table->text('size')->nullable()->after('product_type');
            }
            if (!Schema::hasColumn('orders', 'design_file')) {
                $table->string('design_file')->nullable()->after('quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_type', 'product_type', 'size', 'design_file']);
        });
    }
};

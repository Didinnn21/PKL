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
            // Tambahkan kolom yang mungkin belum ada
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->string('order_type')->default('regular')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'product_type')) {
                $table->string('product_type')->nullable()->after('order_type');
            }
            if (!Schema::hasColumn('orders', 'size')) {
                $table->text('size')->nullable()->after('product_type');
            }
            if (!Schema::hasColumn('orders', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->integer('shipping_cost')->default(0)->after('total_price');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('email'); // Kolom Alamat
            $table->string('phone')->nullable()->after('address'); // Kolom No HP
            $table->date('birth_date')->nullable()->after('phone'); // Kolom Tanggal Lahir
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'birth_date']);
        });
    }
};

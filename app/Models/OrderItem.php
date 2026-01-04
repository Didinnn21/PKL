<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Jika menggunakan guarded kosong, maka semua kolom bisa diisi.
    // Namun pastikan di database kolom 'size' sudah ada melalui migrasi.
    protected $guarded = [];

    // Relasi: Item ini milik Produk apa?
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Item ini milik Order yang mana?
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

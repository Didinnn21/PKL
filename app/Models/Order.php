<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',   // Digunakan jika pesanan langsung 1 produk
        'quantity',     // Digunakan jika pesanan langsung 1 produk
        'total_price',
        'status',
        'notes',
        'design_file',
        'shipping_address',
        'shipping_service',
        'payment_proof',
        'order_type',    // 'regular' atau 'custom'
        'product_type',  // Untuk pesanan custom (Kaos, Hoodie, dll)
        'size',          // Untuk menyimpan rincian ukuran
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke detail barang (Wajib bernama 'items' agar cocok dengan Controller)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

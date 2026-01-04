<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'product_id',       // Penting untuk Beli Langsung
        'quantity',         // Penting untuk Beli Langsung
        'total_price',
        'status',           // Status 'unpaid' atau 'pending_quote'
        'notes',
        'design_file',
        'shipping_address',
        'shipping_service',
        'shipping_cost',
        'payment_proof',
        'order_type',       // Penting untuk membedakan 'regular' dan 'custom'
        'product_type',
        'size', // Detail ukuran (S, M, L, XL, dll)
    ];

    /**
     * Relasi ke model User
     * Pesanan dimiliki oleh satu pengguna
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Product
     * Digunakan jika pesanan hanya berisi satu produk langsung
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke detail barang (OrderItem)
     * Satu pesanan bisa memiliki banyak item produk
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected $casts = [
        'total_price' => 'integer', // atau 'decimal:2'
        'shipping_cost' => 'integer',
    ];
}

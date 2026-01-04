<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',     // WAJIB: Sesuai dengan logika di CheckoutController
        'product_id',       // Digunakan untuk pesanan langsung (direct checkout)
        'quantity',         // Digunakan untuk pesanan langsung
        'total_price',      // Total akhir (Subtotal + Ongkir)
        'status',           // default: 'unpaid'
        'notes',
        'design_file',
        'shipping_address',
        'shipping_service',
        'shipping_cost',    // WAJIB: Untuk menyimpan biaya ongkir
        'payment_proof',    // Untuk upload bukti transfer
        'order_type',       // 'regular' atau 'custom'
        'product_type',     // Untuk custom order
        'size',             // Detail ukuran (S, M, L, XL, dll)
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
}

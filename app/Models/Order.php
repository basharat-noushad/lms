<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = ['uuid', 'user_id', 'order_number', 'subtotal', 'discount_amount', 'coupon_id', 'coupon_code', 'tax_amount', 'total_amount', 'currency', 'payment_method', 'payment_id', 'payment_status', 'status', 'paid_at', 'refunded_at', 'notes'];
    protected $casts = ['paid_at' => 'datetime', 'refunded_at' => 'datetime', 'subtotal' => 'decimal:2', 'discount_amount' => 'decimal:2', 'tax_amount' => 'decimal:2', 'total_amount' => 'decimal:2'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function($order) {
            $order->uuid = $order->uuid ?? (string) Str::uuid();
            $order->order_number = $order->order_number ?? 'ORD-' . strtoupper(Str::random(10));
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function coupon() { return $this->belongsTo(Coupon::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
}

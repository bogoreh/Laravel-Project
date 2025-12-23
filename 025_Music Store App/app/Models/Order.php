<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {
    protected $fillable = [
        'order_number', 'customer_name', 'customer_email',
        'customer_phone', 'customer_address', 'total_amount', 'status'
    ];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot() {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }
}
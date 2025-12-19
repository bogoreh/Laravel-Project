<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'quantity',
        'average_price',
        'total_investment',
        'current_value',
        'profit_loss',
        'profit_loss_percent'
    ];

    protected $casts = [
        'average_price' => 'decimal:2',
        'total_investment' => 'decimal:2',
        'current_value' => 'decimal:2',
        'profit_loss' => 'decimal:2',
        'profit_loss_percent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
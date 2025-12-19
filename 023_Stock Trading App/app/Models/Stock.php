<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'company_name',
        'current_price',
        'change',
        'change_percent',
        'volume',
        'high',
        'low',
        'open',
        'previous_close'
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'change' => 'decimal:2',
        'change_percent' => 'decimal:2',
        'high' => 'decimal:2',
        'low' => 'decimal:2',
        'open' => 'decimal:2',
        'previous_close' => 'decimal:2',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
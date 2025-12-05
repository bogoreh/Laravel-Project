<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'email',
        'amount',
        'payment_method',
        'is_anonymous',
        'message',
        'status',
        'transaction_id'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'end_date',
        'image',
        'is_active'
    ];

    protected $casts = [
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function getProgressAttribute()
    {
        if ($this->goal_amount == 0) return 0;
        return min(100, ($this->current_amount / $this->goal_amount) * 100);
    }
}
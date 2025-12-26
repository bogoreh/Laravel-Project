<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingData extends Model
{
    protected $fillable = ['content', 'label'];
    
    protected $casts = [
        'label' => 'string',
    ];
    
    public function scopeSpam($query)
    {
        return $query->where('label', 'spam');
    }
    
    public function scopeHam($query)
    {
        return $query->where('label', 'ham');
    }
}
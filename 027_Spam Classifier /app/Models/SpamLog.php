<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpamLog extends Model
{
    protected $fillable = [
        'content', 
        'spam_probability', 
        'is_spam', 
        'source', 
        'features'
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_spam' => 'boolean',
    ];
}
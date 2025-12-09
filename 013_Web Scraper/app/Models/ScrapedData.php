<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'description',
        'data',
        'status',
        'scraped_at'
    ];

    protected $casts = [
        'data' => 'array',
        'scraped_at' => 'datetime'
    ];
}
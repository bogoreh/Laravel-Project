<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'content',
        'color',
        'pinned'
    ];

    protected $casts = [
        'pinned' => 'boolean'
    ];
}
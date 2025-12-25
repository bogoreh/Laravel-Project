<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TweetLog extends Model
{
    protected $fillable = [
        'tweet_id',
        'content',
        'type',
        'response_data',
        'status',
    ];

    protected $casts = [
        'response_data' => 'array',
    ];
}
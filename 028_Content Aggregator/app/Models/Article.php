<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'title',
        'description',
        'content',
        'url',
        'image_url',
        'author',
        'published_at',
        'category'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
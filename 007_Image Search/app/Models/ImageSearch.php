<?php

namespace ImageSearch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageSearch extends Model
{
    use HasFactory;

    protected $table = 'image_search';

    protected $fillable = [
        
    ];

    protected $casts = [
        'send_images_result' => 'json',
        'status_result' => 'json',
        'generate_result' => 'json',
    ];
}

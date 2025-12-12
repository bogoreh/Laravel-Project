<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'album',
        'file_path',
        'cover_image',
        'duration'
    ];
}
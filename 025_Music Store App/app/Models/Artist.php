<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model {
    protected $fillable = ['name', 'genre', 'bio', 'image'];

    public function albums(): HasMany {
        return $this->hasMany(Album::class);
    }
}
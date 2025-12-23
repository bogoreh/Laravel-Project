<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model {
    protected $fillable = [
        'artist_id', 'title', 'price', 'stock_quantity',
        'cover_image', 'genre', 'release_year'
    ];

    public function artist(): BelongsTo {
        return $this->belongsTo(Artist::class);
    }

    public function tracks(): HasMany {
        return $this->hasMany(Track::class);
    }

    public function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute() {
        return '$' . number_format($this->price, 2);
    }

    public function getDurationAttribute() {
        $totalSeconds = $this->tracks->sum('duration');
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        return $minutes . ' minutes';
    }
}
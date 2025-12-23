<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model {
    protected $fillable = ['album_id', 'title', 'duration', 'track_number'];

    public function album(): BelongsTo {
        return $this->belongsTo(Album::class);
    }

    public function getFormattedDurationAttribute() {
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
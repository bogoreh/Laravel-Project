<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    protected $fillable = [
        'title',
        'description',
        'alarm_time',
        'days',
        'video_url',
        'audio_url',
        'is_active',
        'snooze_enabled',
        'snooze_duration'
    ];

    protected $casts = [
        'days' => 'array',
        'is_active' => 'boolean',
        'snooze_enabled' => 'boolean',
        'alarm_time' => 'datetime:H:i'
    ];

    public function logs()
    {
        return $this->hasMany(AlarmLog::class);
    }
}
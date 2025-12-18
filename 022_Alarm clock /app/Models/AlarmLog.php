<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlarmLog extends Model
{
    protected $fillable = [
        'alarm_id',
        'triggered_at',
        'stopped_at',
        'was_snoozed',
        'snooze_count'
    ];

    protected $casts = [
        'triggered_at' => 'datetime',
        'stopped_at' => 'datetime',
        'was_snoozed' => 'boolean'
    ];

    public function alarm()
    {
        return $this->belongsTo(Alarm::class);
    }
}
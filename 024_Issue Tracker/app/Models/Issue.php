<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'type',
        'project_id',
        'assigned_to',
        'reported_by',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'priority' => 'string',
        'status' => 'string',
        'type' => 'string'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'info',
            'high' => 'warning',
            'critical' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'open' => 'danger',
            'in_progress' => 'primary',
            'resolved' => 'success',
            'closed' => 'secondary',
            default => 'light'
        };
    }
}
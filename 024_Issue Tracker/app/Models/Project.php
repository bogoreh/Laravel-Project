<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function openIssues()
    {
        return $this->issues()->whereIn('status', ['open', 'in_progress']);
    }

    public function resolvedIssues()
    {
        return $this->issues()->whereIn('status', ['resolved', 'closed']);
    }
}
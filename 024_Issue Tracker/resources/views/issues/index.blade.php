@extends('layouts.app')

@section('title', 'Issues')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Issues</h1>
        <a href="{{ route('issues.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>New Issue
        </a>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('issues.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="bug" {{ request('type') == 'bug' ? 'selected' : '' }}>Bug</option>
                            <option value="feature" {{ request('type') == 'feature' ? 'selected' : '' }}>Feature</option>
                            <option value="task" {{ request('type') == 'task' ? 'selected' : '' }}>Task</option>
                            <option value="improvement" {{ request('type') == 'improvement' ? 'selected' : '' }}>Improvement</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Issues Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assignee</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($issues as $issue)
                        <tr class="issue-card {{ $issue->type }}">
                            <td>
                                <strong>{{ Str::limit($issue->title, 40) }}</strong><br>
                                <small class="text-muted">#{{ $issue->id }} opened by {{ $issue->reporter->name }}</small>
                            </td>
                            <td>{{ $issue->project->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fas fa-{{ $issue->type == 'bug' ? 'bug' : ($issue->type == 'feature' ? 'star' : 'check-circle') }} me-1"></i>
                                    {{ ucfirst($issue->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-priority-{{ $issue->priority }}">
                                    {{ ucfirst($issue->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge bg-{{ $issue->status_color }}">
                                    {{ str_replace('_', ' ', ucfirst($issue->status)) }}
                                </span>
                            </td>
                            <td>
                                @if($issue->assignee)
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ substr($issue->assignee->name, 0, 1) }}
                                    </div>
                                    <span>{{ $issue->assignee->name }}</span>
                                </div>
                                @else
                                <span class="text-muted">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                @if($issue->due_date)
                                    @if($issue->due_date->isPast())
                                        <span class="text-danger">{{ $issue->due_date->format('M d, Y') }}</span>
                                    @elseif($issue->due_date->isToday())
                                        <span class="text-warning">Today</span>
                                    @else
                                        <span class="text-muted">{{ $issue->due_date->format('M d, Y') }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('issues.show', $issue) }}" class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('issues.edit', $issue) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('issues.destroy', $issue) }}" method="POST" onsubmit="return confirm('Delete this issue?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $issues->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Dashboard</h1>
        <div>
            <a href="{{ route('issues.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>New Issue
            </a>
            <a href="{{ route('projects.create') }}" class="btn btn-success ms-2">
                <i class="fas fa-folder-plus me-1"></i>New Project
            </a>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Projects</h5>
                            <h2 class="mb-0">{{ $totalProjects }}</h2>
                        </div>
                        <i class="fas fa-project-diagram fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Open Issues</h5>
                            <h2 class="mb-0">{{ $openIssues }}</h2>
                        </div>
                        <i class="fas fa-exclamation-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Resolved Issues</h5>
                            <h2 class="mb-0">{{ $resolvedIssues }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">My Assigned</h5>
                            <h2 class="mb-0">{{ $myAssignedIssues }}</h2>
                        </div>
                        <i class="fas fa-user-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Issues -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Issues</h5>
                </div>
                <div class="card-body">
                    @if($recentIssues->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Project</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentIssues as $issue)
                                    <tr onclick="window.location='{{ route('issues.show', $issue) }}'" style="cursor: pointer;">
                                        <td>{{ Str::limit($issue->title, 40) }}</td>
                                        <td>{{ $issue->project->name }}</td>
                                        <td>
                                            <span class="badge bg-priority-{{ $issue->priority }}">{{ ucfirst($issue->priority) }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge bg-{{ $issue->status_color }}">{{ str_replace('_', ' ', ucfirst($issue->status)) }}</span>
                                        </td>
                                        <td>{{ $issue->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('issues.index') }}" class="btn btn-outline-primary">View All Issues</a>
                        </div>
                    @else
                        <p class="text-center text-muted">No issues found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Active Projects</h5>
                </div>
                <div class="card-body">
                    @if($activeProjects->count() > 0)
                        <div class="list-group">
                            @foreach($activeProjects as $project)
                            <a href="{{ route('projects.show', $project) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $project->name }}</h6>
                                    <small class="text-muted">{{ $project->open_issues_count }} open</small>
                                </div>
                                <p class="mb-1 text-muted">{{ Str::limit($project->description, 60) }}</p>
                                <small>Created {{ $project->created_at->diffForHumans() }}</small>
                            </a>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">View All Projects</a>
                        </div>
                    @else
                        <p class="text-center text-muted">No active projects.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
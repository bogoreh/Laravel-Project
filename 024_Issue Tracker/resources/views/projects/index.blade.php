@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Projects</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>New Project
        </a>
    </div>
    
    <div class="row">
        @foreach($projects as $project)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">{{ $project->name }}</h5>
                        <span class="badge bg-{{ $project->status == 'active' ? 'success' : ($project->status == 'on_hold' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                    <p class="card-text text-muted">{{ Str::limit($project->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="badge bg-info me-2">
                                <i class="fas fa-tasks me-1"></i>{{ $project->issues_count }} issues
                            </span>
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $project->open_issues_count }} open
                            </span>
                        </div>
                        <small class="text-muted">By {{ $project->creator->name }}</small>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
</div>
@endsection
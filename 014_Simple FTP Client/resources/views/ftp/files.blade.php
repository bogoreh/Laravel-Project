@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-folder2-open me-2"></i>
                    Files on: {{ $host }}
                </h4>
                <div>
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>Connected
                    </span>
                </div>
            </div>
            <div class="card-body">
                <!-- File Upload Form -->
                <div class="mb-4">
                    <form action="{{ route('ftp.upload') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <input type="hidden" name="path" value="{{ $currentPath }}">
                        <div class="col-md-8">
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-upload me-1"></i> Upload File
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Create Folder Form -->
                <div class="mb-4">
                    <form action="{{ route('ftp.create-folder') }}" method="POST" class="row g-3">
                        @csrf
                        <input type="hidden" name="current_path" value="{{ $currentPath }}">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="folder_name" 
                                   placeholder="New folder name" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-folder-plus me-1"></i> Create Folder
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('ftp.files', ['path' => '/']) }}">
                                <i class="bi bi-house-door"></i> Root
                            </a>
                        </li>
                        @php
                            $pathParts = array_filter(explode('/', $currentPath));
                            $current = '';
                        @endphp
                        @foreach($pathParts as $part)
                            @php $current .= '/' . $part; @endphp
                            <li class="breadcrumb-item">
                                <a href="{{ route('ftp.files', ['path' => $current]) }}">
                                    {{ $part }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </nav>
                
                <!-- Files List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Last Modified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($currentPath !== '/')
                                <tr class="file-list-item">
                                    <td>
                                        <i class="bi bi-folder file-icon text-warning"></i>
                                        <a href="{{ route('ftp.files', ['path' => dirname($currentPath)]) }}">
                                            ..
                                        </a>
                                    </td>
                                    <td><span class="badge bg-secondary">Directory</span></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                            
                            @foreach($files as $file)
                                <tr class="file-list-item">
                                    <td>
                                        @if($file['type'] === 'dir')
                                            <i class="bi bi-folder file-icon text-warning"></i>
                                            <a href="{{ route('ftp.files', ['path' => $file['path']]) }}">
                                                {{ basename($file['path']) }}
                                            </a>
                                        @else
                                            <i class="bi bi-file-earmark file-icon text-primary"></i>
                                            {{ basename($file['path']) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($file['type'] === 'dir')
                                            <span class="badge bg-warning text-dark">Directory</span>
                                        @else
                                            <span class="badge bg-info">File</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($file['type'] === 'file')
                                            {{ round($file['size'] / 1024, 2) }} KB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($file['timestamp']))
                                            {{ date('Y-m-d H:i', $file['timestamp']) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($file['type'] === 'file')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('ftp.download') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="remote_path" value="{{ $file['path'] }}">
                                                    <input type="hidden" name="local_path" value="{{ storage_path('app/downloads/' . basename($file['path'])) }}">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('ftp.delete') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this file?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if(count($files) === 0 && $currentPath === '/')
                        <div class="text-center py-5">
                            <i class="bi bi-folder-x display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">No files or directories found</h4>
                            <p class="text-muted">Upload files or create folders to get started</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
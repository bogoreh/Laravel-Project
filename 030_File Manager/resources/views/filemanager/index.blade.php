@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">File Manager</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('filemanager.index') }}">Root</a></li>
            @if ($currentPath)
                @php
                    $parts = explode('/', $currentPath);
                    $cumulative = '';
                @endphp
                @foreach ($parts as $part)
                    @php $cumulative .= ($cumulative ? '/' : '') . $part; @endphp
                    <li class="breadcrumb-item"><a href="{{ route('filemanager.index', ['path' => $cumulative]) }}">{{ $part }}</a></li>
                @endforeach
            @endif
        </ol>
    </nav>

    <!-- Upload & New Folder Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('filemanager.upload') }}" method="POST" enctype="multipart/form-data" class="d-inline-block me-3">
                @csrf
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <div class="input-group">
                    <input type="file" name="file" class="form-control" required>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>

            <form action="{{ route('filemanager.folder.create') }}" method="POST" class="d-inline-block">
                @csrf
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <div class="input-group">
                    <input type="text" name="folder_name" class="form-control" placeholder="New folder name" required>
                    <button type="submit" class="btn btn-success">Create Folder</button>
                </div>
            </form>
        </div>
    </div>

    <!-- File & Folder Grid -->
    <div class="row">
        @foreach ($directories as $dir)
            <div class="col-md-3 mb-4">
                @include('filemanager._folder_card', ['folder' => basename($dir), 'currentPath' => $currentPath])
            </div>
        @endforeach

        @foreach ($files as $file)
            <div class="col-md-3 mb-4">
                @include('filemanager._file_card', ['file' => basename($file), 'currentPath' => $currentPath])
            </div>
        @endforeach
    </div>
</div>
@endsection
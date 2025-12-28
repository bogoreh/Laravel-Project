<div class="card h-100 shadow-sm">
    <div class="card-body text-center">
        <i class="fas fa-folder fa-3x text-warning mb-3"></i>
        <h6 class="card-title text-truncate" title="{{ $folder }}">{{ $folder }}</h6>

        <div class="mt-3">
            <a href="{{ route('filemanager.index', ['path' => $currentPath ? $currentPath . '/' . $folder : $folder]) }}"
               class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-folder-open"></i> Open
            </a>

            <form action="{{ route('filemanager.delete') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <input type="hidden" name="name" value="{{ $folder }}">
                <input type="hidden" name="type" value="folder">
                <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Delete folder {{ $folder }} and its contents?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
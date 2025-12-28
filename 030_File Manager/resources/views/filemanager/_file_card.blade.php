<div class="card h-100 shadow-sm">
    <div class="card-body text-center">
        <i class="fas fa-file fa-3x text-primary mb-3"></i>
        <h6 class="card-title text-truncate" title="{{ $file }}">{{ $file }}</h6>

        <div class="mt-3">
            <a href="{{ route('filemanager.download', ['file' => $file, 'path' => $currentPath]) }}"
               class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-download"></i> Download
            </a>

            <form action="{{ route('filemanager.delete') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <input type="hidden" name="name" value="{{ $file }}">
                <input type="hidden" name="type" value="file">
                <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Delete {{ $file }}?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
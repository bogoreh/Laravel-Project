@extends('layouts.app')

@section('title', 'Scraping History')

@section('content')
<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Scraping History</h4>
            </div>
            <div class="card-body">
                @if($scrapedData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scrapedData as $data)
                                <tr>
                                    <td>#{{ $data->id }}</td>
                                    <td>{{ Str::limit($data->title, 40) }}</td>
                                    <td class="url-cell" title="{{ $data->url }}">
                                        {{ Str::limit($data->url, 40) }}
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $data->status }}">
                                            <i class="fas fa-{{ $data->status === 'completed' ? 'check-circle' : ($data->status === 'failed' ? 'times-circle' : 'clock') }} me-1"></i>
                                            {{ ucfirst($data->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $data->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('scraper.show', $data->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('scraper.destroy', $data->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
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
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $scrapedData->firstItem() }} to {{ $scrapedData->lastItem() }} of {{ $scrapedData->total() }} results
                        </div>
                        <div>
                            {{ $scrapedData->links() }}
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <form action="{{ route('scraper.clearAll') }}" method="POST" onsubmit="return confirm('This will delete ALL scraped data. Are you sure?')">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Clear All History
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-database fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Scraping History</h4>
                        <p class="text-muted">You haven't scraped any websites yet.</p>
                        <a href="{{ route('scraper.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Start Scraping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
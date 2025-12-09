@extends('layouts.app')

@section('title', 'Scraped Data Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">
                        <i class="fas fa-database me-2"></i>Scraped Data Details
                    </h4>
                    <small class="text-muted">ID: {{ $scrapedData->id }}</small>
                </div>
                <div>
                    <span class="badge status-{{ $scrapedData->status }} status-badge">
                        <i class="fas fa-{{ $scrapedData->status === 'completed' ? 'check-circle' : 'times-circle' }} me-1"></i>
                        {{ ucfirst($scrapedData->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="result-item">
                            <h6><i class="fas fa-heading me-2"></i>Title</h6>
                            <p class="mb-0">{{ $scrapedData->title }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="result-item">
                            <h6><i class="fas fa-link me-2"></i>URL</h6>
                            <p class="mb-0">
                                <a href="{{ $scrapedData->url }}" target="_blank" rel="noopener noreferrer">
                                    {{ $scrapedData->url }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($scrapedData->description)
                <div class="result-item mb-4">
                    <h6><i class="fas fa-quote-left me-2"></i>Meta Description</h6>
                    <p class="mb-0">{{ $scrapedData->description }}</p>
                </div>
                @endif
                
                @if($scrapedData->data)
                <div class="result-item mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0"><i class="fas fa-code me-2"></i>Raw Data</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleContent('rawData')">
                            <i class="fas fa-plus me-1"></i>Show Raw Data
                        </button>
                    </div>
                    <div id="rawData" style="display: none;">
                        <div class="preview-box">
                            <pre>{{ json_encode($scrapedData->data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary mt-2" onclick="copyToClipboard(JSON.stringify({{ json_encode($scrapedData->data) }}, null, 2))">
                            <i class="fas fa-copy me-1"></i>Copy JSON
                        </button>
                    </div>
                </div>
                
                @php
                    $data = $scrapedData->data;
                @endphp
                
                @if(!empty($data['content']))
                <div class="result-item mb-4">
                    <h6><i class="fas fa-file-alt me-2"></i>Extracted Content</h6>
                    <div class="preview-box">
                        @if(!empty($data['content']['summary']))
                            <p>{{ $data['content']['summary'] }}</p>
                        @endif
                    </div>
                    @if(!empty($data['content']['paragraphs']) && count($data['content']['paragraphs']) > 0)
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="toggleContent('allParagraphs')">
                            <i class="fas fa-plus me-1"></i>Show All Paragraphs ({{ count($data['content']['paragraphs']) }})
                        </button>
                        <div id="allParagraphs" style="display: none;" class="mt-2">
                            @foreach($data['content']['paragraphs'] as $index => $paragraph)
                                <div class="mb-2">
                                    <small class="text-muted">#{{ $index + 1 }}</small>
                                    <p class="mb-1">{{ $paragraph }}</p>
                                </div>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif
                
                @if(!empty($data['images']) && count($data['images']) > 0)
                <div class="result-item mb-4">
                    <h6><i class="fas fa-images me-2"></i>Images ({{ count($data['images']) }})</h6>
                    <div class="row">
                        @foreach(array_slice($data['images'], 0, 6) as $index => $image)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <small class="text-muted d-block mb-2">Image #{{ $index + 1 }}</small>
                                        <strong>Source:</strong>
                                        <p class="small text-truncate" title="{{ $image['src'] }}">
                                            {{ Str::limit($image['src'], 40) }}
                                        </p>
                                        <strong>Alt Text:</strong>
                                        <p class="small">{{ $image['alt'] }}</p>
                                        @if($image['width'] || $image['height'])
                                            <div class="small">
                                                <span class="me-2">W: {{ $image['width'] ?: 'auto' }}</span>
                                                <span>H: {{ $image['height'] ?: 'auto' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($data['images']) > 6)
                        <div class="text-center mt-2">
                            <small class="text-muted">Showing 6 of {{ count($data['images']) }} images</small>
                        </div>
                    @endif
                </div>
                @endif
                
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Created: {{ $scrapedData->created_at->format('M d, Y H:i') }}
                        </small>
                        @if($scrapedData->scraped_at)
                            <small class="text-muted ms-3">
                                <i class="fas fa-clock me-1"></i>
                                Scraped: {{ $scrapedData->scraped_at->format('M d, Y H:i') }}
                            </small>
                        @endif
                    </div>
                    <div>
                        <form action="{{ route('scraper.destroy', $scrapedData->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this scraped data?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                        <a href="{{ route('scraper.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Scraping Results')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Scraping Results
                    @if($success)
                        <span class="badge bg-success ms-2">Success</span>
                    @else
                        <span class="badge bg-danger ms-2">Failed</span>
                    @endif
                </h4>
                <div>
                    <a href="{{ route('scraper.create') }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-plus me-1"></i>New Scrape
                    </a>
                    <a href="{{ route('scraper.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-history me-1"></i>History
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($success)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="result-item">
                                <h6><i class="fas fa-link me-2"></i>URL</h6>
                                <p class="mb-0">{{ $data['url'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="result-item">
                                <h6><i class="fas fa-heading me-2"></i>Title</h6>
                                <p class="mb-0">{{ $data['title'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if(!empty($data['meta_description']))
                    <div class="result-item mb-4">
                        <h6><i class="fas fa-quote-left me-2"></i>Meta Description</h6>
                        <p class="mb-0">{{ $data['meta_description'] }}</p>
                    </div>
                    @endif
                    
                    <div class="result-item mb-4">
                        <h6><i class="fas fa-file-alt me-2"></i>Content Summary</h6>
                        <div class="preview-box">
                            <p>{{ $data['content']['summary'] }}</p>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="toggleContent('fullContent')">
                            <i class="fas fa-plus me-1"></i>Show Full Content
                        </button>
                        <div id="fullContent" style="display: none;" class="mt-2">
                            @if(!empty($data['content']['paragraphs']))
                                @foreach($data['content']['paragraphs'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="result-item h-100">
                                <h6><i class="fas fa-images me-2"></i>Images Found ({{ count($data['images']) }})</h6>
                                @if(count($data['images']) > 0)
                                    <div class="preview-box">
                                        @foreach(array_slice($data['images'], 0, 5) as $image)
                                            <div class="mb-2">
                                                <strong>Src:</strong> {{ Str::limit($image['src'], 50) }}<br>
                                                <strong>Alt:</strong> {{ $image['alt'] }}
                                            </div>
                                            @if(!$loop->last)<hr>@endif
                                        @endforeach
                                    </div>
                                    @if(count($data['images']) > 5)
                                        <small class="text-muted">Showing 5 of {{ count($data['images']) }} images</small>
                                    @endif
                                @else
                                    <p class="text-muted mb-0">No images found</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="result-item h-100">
                                <h6><i class="fas fa-link me-2"></i>Links Found ({{ count($data['all_links']) }})</h6>
                                @if(count($data['all_links']) > 0)
                                    <div class="preview-box">
                                        @foreach(array_slice($data['all_links'], 0, 5) as $link)
                                            <div class="mb-2">
                                                <strong>URL:</strong> {{ Str::limit($link['url'], 40) }}<br>
                                                <strong>Text:</strong> {{ Str::limit($link['text'], 30) }}<br>
                                                <span class="badge {{ $link['is_internal'] ? 'bg-info' : 'bg-warning' }}">
                                                    {{ $link['is_internal'] ? 'Internal' : 'External' }}
                                                </span>
                                            </div>
                                            @if(!$loop->last)<hr>@endif
                                        @endforeach
                                    </div>
                                    @if(count($data['all_links']) > 5)
                                        <small class="text-muted">Showing 5 of {{ count($data['all_links']) }} links</small>
                                    @endif
                                @else
                                    <p class="text-muted mb-0">No links found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if(!empty($data['headers']))
                    <div class="result-item mb-4">
                        <h6><i class="fas fa-heading me-2"></i>Headers Structure</h6>
                        <div class="row">
                            @foreach($data['headers'] as $tag => $headers)
                                @if(count($headers) > 0)
                                    <div class="col-md-4 mb-3">
                                        <h6 class="text-muted">{{ strtoupper($tag) }} ({{ count($headers) }})</h6>
                                        <div class="preview-box" style="max-height: 150px;">
                                            @foreach(array_slice($headers, 0, 3) as $header)
                                                <div>{{ $header }}</div>
                                            @endforeach
                                            @if(count($headers) > 3)
                                                <div class="text-muted">... and {{ count($headers) - 3 }} more</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if(!empty($data['custom']))
                    <div class="result-item mb-4">
                        <h6><i class="fas fa-code me-2"></i>Custom Selector Results</h6>
                        <div class="row">
                            @foreach($data['custom'] as $key => $values)
                                @if(count($values) > 0)
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-muted">{{ $key }} ({{ count($values) }})</h6>
                                        <div class="preview-box">
                                            @foreach(array_slice($values, 0, 5) as $value)
                                                <div class="mb-2">{{ $value }}</div>
                                            @endforeach
                                            @if(count($values) > 5)
                                                <div class="text-muted">... and {{ count($values) - 5 }} more</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Success!</strong> Website scraped successfully and saved to database.
                        <a href="{{ route('scraper.show', $scrapedData->id) }}" class="alert-link">
                            View saved data
                        </a>
                    </div>
                    
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Scraping Failed!</strong> {{ $error }}
                    </div>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle fa-4x text-danger mb-3"></i>
                        <h4 class="text-danger">Unable to scrape website</h4>
                        <p class="text-muted">The scraper encountered an error while trying to access the website.</p>
                        <div class="mt-3">
                            <a href="{{ route('scraper.create') }}" class="btn btn-primary me-2">
                                <i class="fas fa-redo me-2"></i>Try Again
                            </a>
                            <a href="{{ route('scraper.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-history me-2"></i>View History
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Scraped at: {{ $scrapedData->created_at->format('Y-m-d H:i:s') }}
                        </small>
                    </div>
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-database me-1"></i>
                            ID: {{ $scrapedData->id }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
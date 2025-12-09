@extends('layouts.app')

@section('title', 'New Web Scrape')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-globe me-2"></i>New Web Scraping Job</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('scraper.scrape') }}" method="POST" id="scrapeForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="url" class="form-label">Website URL *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                            <input type="url" class="form-control" id="url" name="url" 
                                   placeholder="https://example.com" required
                                   value="{{ old('url', 'https://example.com') }}">
                        </div>
                        <div class="form-text">Enter the full URL of the website you want to scrape</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Custom Title (Optional)</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="My Scraped Website" value="{{ old('title') }}">
                        <div class="form-text">Leave empty to use website title</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="custom_selectors" class="form-label">Custom CSS Selectors (Optional)</label>
                        <textarea class="form-control" id="custom_selectors" name="custom_selectors" 
                                  rows="3" placeholder=".article-title, #main-content, .price">{{ old('custom_selectors') }}</textarea>
                        <div class="form-text">Enter CSS selectors separated by commas to extract specific elements</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Please respect website terms of service and robots.txt. 
                        Scraping should be done responsibly and ethically.
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('scraper.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" id="scrapeButton">
                            <i class="fas fa-spider me-2"></i>Start Scraping
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Scraping Examples</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Test Websites:</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="#" onclick="document.getElementById('url').value='https://books.toscrape.com'; return false;">
                                    https://books.toscrape.com
                                </a>
                                <small class="text-muted d-block">Book store demo site</small>
                            </li>
                            <li class="list-group-item">
                                <a href="#" onclick="document.getElementById('url').value='https://quotes.toscrape.com'; return false;">
                                    https://quotes.toscrape.com
                                </a>
                                <small class="text-muted d-block">Quotes demo site</small>
                            </li>
                            <li class="list-group-item">
                                <a href="#" onclick="document.getElementById('url').value='https://httpbin.org/html'; return false;">
                                    https://httpbin.org/html
                                </a>
                                <small class="text-muted d-block">Simple HTML page</small>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Example CSS Selectors:</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <code>.product-title</code> - For product titles
                            </li>
                            <li class="list-group-item">
                                <code>#main-content</code> - For main content div
                            </li>
                            <li class="list-group-item">
                                <code>.price</code> - For price elements
                            </li>
                            <li class="list-group-item">
                                <code>article h2</code> - For article headings
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('scrapeForm').addEventListener('submit', function() {
        const button = document.getElementById('scrapeButton');
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Scraping...';
        button.disabled = true;
    });
</script>
@endpush
@endsection
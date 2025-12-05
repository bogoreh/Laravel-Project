@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Make a Difference Today</h1>
            <p class="lead mb-4">Join thousands of donors supporting causes that matter. Your contribution can change lives.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('donations.create') }}" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-donate me-2"></i> Donate Now
                </a>
                <a href="{{ route('campaigns') }}" class="btn btn-outline-light btn-lg px-4">
                    View Campaigns
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">${{ number_format($totalRaised, 0) }}</div>
                        <p class="text-muted mb-0">Total Raised</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">{{ $totalDonors }}</div>
                        <p class="text-muted mb-0">Donors</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-number">24</div>
                        <p class="text-muted mb-0">Campaigns</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Campaigns -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="text-center fw-bold">Featured Campaigns</h2>
                    <p class="text-center text-muted">Help support these urgent causes</p>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($campaigns as $campaign)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 class="campaign-img" alt="{{ $campaign->title }}">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $campaign->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($campaign->description, 100) }}</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Raised: ${{ number_format($campaign->current_amount, 0) }}</small>
                                    <small>Goal: ${{ number_format($campaign->goal_amount, 0) }}</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $campaign->progress }}%"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i> 
                                    Ends {{ $campaign->end_date->format('M d, Y') }}
                                </small>
                                <a href="{{ route('donations.create', $campaign->id) }}" class="btn btn-primary btn-sm">
                                    Donate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('campaigns') }}" class="btn btn-outline-primary px-4">
                    View All Campaigns
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="text-center fw-bold">How It Works</h2>
                    <p class="text-center text-muted">Simple steps to make an impact</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-search text-white fa-2x"></i>
                        </div>
                    </div>
                    <h4>1. Choose a Cause</h4>
                    <p class="text-muted">Browse campaigns and select one that resonates with you.</p>
                </div>
                
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-donate text-white fa-2x"></i>
                        </div>
                    </div>
                    <h4>2. Make a Donation</h4>
                    <p class="text-muted">Choose your amount and payment method. Every bit helps.</p>
                </div>
                
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-heart text-white fa-2x"></i>
                        </div>
                    </div>
                    <h4>3. See the Impact</h4>
                    <p class="text-muted">Receive updates on how your donation is making a difference.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
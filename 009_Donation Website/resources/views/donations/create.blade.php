@extends('layouts.app')

@section('title', 'Make a Donation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Make a Donation</h4>
                </div>
                
                <div class="card-body">
                    @if($campaign)
                    <div class="alert alert-info">
                        <h5>Donating to: {{ $campaign->title }}</h5>
                        <p class="mb-0">{{ Str::limit($campaign->description, 150) }}</p>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('donations.store') }}">
                        @csrf
                        
                        @if($campaign)
                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                        @endif
                        
                        <!-- Donation Amount -->
                        <div class="mb-4">
                            <h5 class="mb-3">Select Donation Amount</h5>
                            <div class="d-flex flex-wrap justify-content-center mb-3">
                                @foreach($suggestedAmounts as $amount)
                                <button type="button" class="donation-amount-btn" data-amount="{{ $amount }}">
                                    ${{ $amount }}
                                </button>
                                @endforeach
                            </div>
                            
                            <div class="text-center">
                                <div class="form-group w-50 mx-auto">
                                    <label for="customAmount" class="form-label">Or enter custom amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               name="amount" 
                                               id="customAmount" 
                                               class="form-control" 
                                               min="1" 
                                               step="0.01" 
                                               required
                                               value="{{ old('amount', 25) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donor Information -->
                        <div class="mb-4">
                            <h5 class="mb-3">Your Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="donor_name" class="form-label">Full Name *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="donor_name" 
                                           name="donor_name" 
                                           value="{{ old('donor_name') }}" 
                                           required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message (Optional)</label>
                                <textarea class="form-control" 
                                          id="message" 
                                          name="message" 
                                          rows="3" 
                                          placeholder="Add a message to show with your donation">{{ old('message') }}</textarea>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_anonymous" 
                                       id="is_anonymous" 
                                       value="1">
                                <label class="form-check-label" for="is_anonymous">
                                    Donate anonymously
                                </label>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h5 class="mb-3">Payment Method</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="payment_method" 
                                               id="card" 
                                               value="card" 
                                               checked>
                                        <label class="form-check-label" for="card">
                                            <i class="fas fa-credit-card me-1"></i> Credit Card
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="payment_method" 
                                               id="paypal" 
                                               value="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <i class="fab fa-paypal me-1"></i> PayPal
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="payment_method" 
                                               id="bank" 
                                               value="bank">
                                        <label class="form-check-label" for="bank">
                                            <i class="fas fa-university me-1"></i> Bank Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-lock me-2"></i> Complete Donation
                            </button>
                            <p class="text-muted mt-2">
                                <small>Your donation is secure and tax-deductible.</small>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
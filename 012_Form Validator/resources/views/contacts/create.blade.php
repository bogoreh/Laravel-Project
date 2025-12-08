@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="contact-card p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="contact-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h2 class="fw-bold text-primary">Get In Touch</h2>
                <p class="text-muted">We'd love to hear from you. Send us a message!</p>
            </div>

            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                
                <div class="floating-label">
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="John Doe"
                           value="{{ old('name') }}">
                    <label for="name">Full Name *</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="floating-label">
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="john@example.com"
                           value="{{ old('email') }}">
                    <label for="email">Email Address *</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="floating-label">
                    <input type="tel" 
                           name="phone" 
                           id="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           placeholder="(123) 456-7890"
                           value="{{ old('phone') }}">
                    <label for="phone">Phone Number (Optional)</label>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="floating-label">
                    <textarea name="message" 
                              id="message" 
                              class="form-control @error('message') is-invalid @enderror" 
                              rows="5"
                              placeholder="Your message here...">{{ old('message') }}</textarea>
                    <label for="message">Your Message *</label>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i> Send Message
                    </button>
                    
                    <div class="mt-3">
                        <a href="{{ route('contacts.index') }}" class="text-decoration-none">
                            <i class="fas fa-history me-1"></i> View Previous Messages
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
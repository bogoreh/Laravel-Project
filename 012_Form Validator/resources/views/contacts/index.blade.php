@extends('layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="header-gradient mb-5">
            <div class="container text-center">
                <h1 class="display-5 fw-bold">
                    <i class="fas fa-envelope-open-text me-2"></i> Contact Messages
                </h1>
                <p class="lead">All your contact form submissions in one place</p>
                <a href="{{ route('contacts.create') }}" class="btn btn-light btn-lg mt-3">
                    <i class="fas fa-plus me-2"></i> New Message
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="contact-card p-4">
            @if($contacts->count() > 0)
                <div class="message-list">
                    @foreach($contacts as $contact)
                        <div class="message-item p-4 mb-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold text-primary">{{ $contact->name }}</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-info me-2">
                                            <i class="fas fa-envelope me-1"></i> {{ $contact->email }}
                                        </span>
                                        @if($contact->phone)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-phone me-1"></i> {{ $contact->phone }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $contact->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            <p class="mb-0 mt-2">{{ $contact->message }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="contact-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="text-muted">No messages yet</h3>
                    <p class="text-muted">Your contact form submissions will appear here.</p>
                    <a href="{{ route('contacts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Send First Message
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
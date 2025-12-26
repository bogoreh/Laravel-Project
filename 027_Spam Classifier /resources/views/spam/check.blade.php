@extends('layout.app')

@section('title', 'Check for Spam')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-search mr-2"></i>Check Text for Spam
        </h1>
        
        @if(!$modelExists)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Model not trained yet. Please train the model first for accurate predictions.
                            <a href="{{ route('training.index') }}" class="font-medium underline">Go to Training</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{ route('spam.check') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="text" class="block text-gray-700 font-medium mb-2">
                    Enter text to analyze:
                </label>
                <textarea 
                    id="text" 
                    name="text" 
                    rows="6" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your text here...">{{ old('text') }}</textarea>
                @error('text')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    The classifier analyzes keywords, patterns, and other features.
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition">
                    <i class="fas fa-shield-alt mr-2"></i>Check for Spam
                </button>
            </div>
        </form>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-robot text-blue-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">ML Powered</h3>
                    <p class="text-gray-600 text-sm">Uses machine learning algorithms</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-bolt text-green-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Real-time</h3>
                    <p class="text-gray-600 text-sm">Instant spam detection</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Improves Over Time</h3>
                    <p class="text-gray-600 text-sm">Learns from new data</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
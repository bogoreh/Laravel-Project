@extends('layout.app')

@section('title', 'Analysis Result')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <a href="{{ route('spam.check') }}" class="text-blue-500 hover:underline mb-4 inline-block">
            <i class="fas fa-arrow-left mr-1"></i>Back to checker
        </a>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Analysis Result</h1>
        
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-700 mb-2">Analyzed Text:</h2>
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $text }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-6 rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800">Spam Probability</h3>
                    <div class="text-2xl font-bold {{ $result['is_spam'] ? 'text-red-500' : 'text-green-500' }}">
                        {{ number_format($result['probability'] * 100, 1) }}%
                    </div>
                </div>
                
                <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                    <div 
                        class="h-4 rounded-full {{ $result['is_spam'] ? 'bg-red-500' : 'bg-green-500' }}"
                        style="width: {{ $result['probability'] * 100 }}%">
                    </div>
                </div>
                
                <div class="flex justify-between text-sm text-gray-600">
                    <span>0%</span>
                    <span>100%</span>
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Verdict</h3>
                
                @if($result['is_spam'])
                    <div class="flex items-center justify-center p-4 bg-red-50 border border-red-200 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-4"></i>
                        <div>
                            <h4 class="text-xl font-bold text-red-700">SPAM DETECTED</h4>
                            <p class="text-red-600">This text appears to be spam.</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center p-4 bg-green-50 border border-green-200 rounded-lg">
                        <i class="fas fa-check-circle text-green-500 text-3xl mr-4"></i>
                        <div>
                            <h4 class="text-xl font-bold text-green-700">NOT SPAM</h4>
                            <p class="text-green-600">This text appears to be legitimate.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Detected Features</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($result['features'] as $feature => $value)
                    <div class="bg-white border rounded-lg p-4">
                        <div class="text-sm text-gray-600 mb-1 capitalize">{{ str_replace('_', ' ', $feature) }}</div>
                        <div class="font-bold">
                            @if(is_bool($value))
                                {{ $value ? 'Yes' : 'No' }}
                            @elseif(is_float($value))
                                {{ number_format($value * 100, 1) }}%
                            @else
                                {{ $value }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="flex justify-center space-x-4">
            <a href="{{ route('spam.check') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition">
                <i class="fas fa-search mr-2"></i>Check Another Text
            </a>
            <a href="{{ route('training.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-600 transition">
                <i class="fas fa-brain mr-2"></i>Improve Model
            </a>
        </div>
    </div>
</div>
@endsection
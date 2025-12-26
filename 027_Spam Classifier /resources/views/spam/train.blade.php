@extends('layout.app')

@section('title', 'Train Model')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-brain mr-2"></i>Train Spam Classifier Model
        </h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-database text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Training Samples</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Total labeled examples</p>
            </div>
            
            <div class="bg-red-50 p-6 rounded-lg border border-red-100">
                <div class="flex items-center mb-3">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <i class="fas fa-ban text-red-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Spam Samples</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['spam'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Spam labeled examples</p>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                <div class="flex items-center mb-3">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Ham Samples</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['ham'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Legitimate examples</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Add Training Sample</h2>
                
                <form action="{{ route('training.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="content" class="block text-gray-700 font-medium mb-2">
                            Text Content
                        </label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="4" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter sample text...">{{ old('content') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Label</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="label" value="spam" class="mr-2" {{ old('label') == 'spam' ? 'checked' : '' }}>
                                <span class="flex items-center">
                                    <i class="fas fa-ban text-red-500 mr-1"></i>
                                    Spam
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="label" value="ham" class="mr-2" {{ old('label') == 'ham' ? 'checked' : '' }}>
                                <span class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1"></i>
                                    Ham (Not Spam)
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition w-full">
                        <i class="fas fa-plus mr-2"></i>Add Training Sample
                    </button>
                </form>
                
                <div class="mt-8">
                    <form action="{{ route('training.train') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition w-full">
                            <i class="fas fa-cogs mr-2"></i>Train Model Now
                        </button>
                    </form>
                    
                    @if(session('success'))
                        <div class="mt-4 bg-green-50 border-l-4 border-green-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Training Data Samples</h2>
                
                @if($trainingData->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    No training data yet. Add samples to train your model.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        @foreach($trainingData as $sample)
                            <div class="bg-gray-50 p-4 rounded-lg border {{ $sample->label == 'spam' ? 'border-red-200' : 'border-green-200' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $sample->label == 'spam' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ strtoupper($sample->label) }}
                                    </span>
                                    <form action="{{ route('training.destroy', $sample) }}" method="POST" onsubmit="return confirm('Delete this sample?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <p class="text-gray-800 text-sm line-clamp-3">{{ Str::limit($sample->content, 150) }}</p>
                                <div class="text-xs text-gray-500 mt-2">{{ $sample->created_at->format('M d, Y') }}</div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $trainingData->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
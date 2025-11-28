<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-8">
        <!-- Form Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">{{ isset($note) ? 'Edit Note' : 'Create New Note' }}</h2>
            <p class="text-gray-600 mt-2">Capture your thoughts and ideas</p>
        </div>

        <form action="{{ isset($note) ? route('notes.update', $note) : route('notes.store') }}" method="POST">
            @csrf
            @if(isset($note))
                @method('PUT')
            @endif

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $note->title ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Enter note title..."
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea id="content" 
                          name="content" 
                          rows="8"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                          placeholder="Write your note here..."
                          required>{{ old('content', $note->content ?? '') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color Picker -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Note Color</label>
                <div class="flex space-x-3">
                    @php
                        $colors = [
                            '#ffffff' => 'White',
                            '#fef3c7' => 'Yellow',
                            '#d1fae5' => 'Green',
                            '#e0e7ff' => 'Blue',
                            '#f3e8ff' => 'Purple',
                            '#ffe4e6' => 'Pink'
                        ];
                    @endphp
                    @foreach($colors as $value => $label)
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="color" 
                                   value="{{ $value }}"
                                   {{ (old('color', $note->color ?? '#ffffff') == $value) ? 'checked' : '' }}
                                   class="sr-only">
                            <span class="w-8 h-8 rounded-full border-2 border-gray-300 cursor-pointer transition duration-200 hover:scale-110"
                                  style="background-color: {{ $value }}; {{ (old('color', $note->color ?? '#ffffff') == $value) ? 'border-blue-500' : '' }}"></span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Pin Option -->
            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_pinned" 
                           value="1"
                           {{ (old('is_pinned', $note->is_pinned ?? false)) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Pin this note to the top</span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('notes.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    {{ isset($note) ? 'Update Note' : 'Create Note' }}
                </button>
            </div>
        </form>
    </div>
</div>
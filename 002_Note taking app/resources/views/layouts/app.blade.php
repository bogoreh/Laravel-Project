<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-sticky-note text-2xl mr-3"></i>
                    <span class="text-xl font-bold">NoteTaking</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('notes.index') }}" class="hover:text-blue-200 transition duration-200">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-1"></i> New Note
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; 2025 NoteTaking App. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
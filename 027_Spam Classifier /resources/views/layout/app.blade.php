<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spam Classifier - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-blue-500 text-2xl mr-3"></i>
                    <a href="{{ route('spam.check') }}" class="text-xl font-bold text-gray-800">Spam Classifier</a>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('spam.check') }}" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-search mr-1"></i>Check Text
                    </a>
                    <a href="{{ route('training.index') }}" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-brain mr-1"></i>Train Model
                    </a>
                    <a href="{{ route('spam.stats') }}" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-chart-bar mr-1"></i>Statistics
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-8">
        <div class="container mx-auto px-4 py-6 text-center text-gray-600">
            <p>Spam Classifier &copy; {{ date('Y') }} - Simple ML Implementation</p>
        </div>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Aggregator - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }
        .category-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('articles.index') }}" class="text-2xl font-bold">
                    <i class="fas fa-newspaper mr-2"></i>NewsHub
                </a>
                <div class="space-x-4">
                    <a href="{{ route('articles.index') }}" class="hover:text-gray-200">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="#" class="hover:text-gray-200">
                        <i class="fas fa-rss mr-1"></i> Sources
                    </a>
                    <button onclick="fetchArticles()" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Articles
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Content Aggregator. All rights reserved.</p>
            <p class="text-gray-400 text-sm mt-2">Aggregating the best content from across the web</p>
        </div>
    </footer>

    <script>
        function fetchArticles() {
            fetch('/api/fetch-articles', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Articles fetched successfully!');
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                alert('Error fetching articles');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
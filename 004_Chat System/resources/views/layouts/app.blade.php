<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#1f2937',
                            200: '#111827',
                            300: '#0f172a',
                            400: '#0a0f1c',
                            500: '#070b15',
                        },
                        accent: {
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-300 text-gray-100 transition-colors duration-200">
    <nav class="bg-dark-200 border-b border-dark-100 shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-accent-500 to-accent-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-comments text-white text-sm"></i>
                    </div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-accent-500 to-accent-600 bg-clip-text text-transparent">
                        ChatSystem
                    </h1>
                </div>
                @auth
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-dark-100 rounded-full flex items-center justify-center border border-dark-400">
                            <span class="text-sm font-semibold text-accent-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-gray-300">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-dark-100 hover:bg-dark-400 px-4 py-2 rounded-lg transition-all duration-200 border border-dark-400 hover:border-accent-500 text-gray-300 hover:text-white">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="transition-colors duration-200">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
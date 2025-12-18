<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Alarm Clock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                    <i class="fas fa-clock mr-2"></i>Video Alarm
                </a>
                <div class="space-x-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('alarms.index') }}" class="hover:text-blue-200">
                        <i class="fas fa-bell"></i> Alarms
                    </a>
                    <a href="{{ route('notes.index') }}" class="hover:text-blue-200">
                        <i class="fas fa-sticky-note"></i> Notes
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>
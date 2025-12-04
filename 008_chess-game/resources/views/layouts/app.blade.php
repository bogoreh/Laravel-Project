<!DOCTYPE html>
<html lang="en" class="dark-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Game - @yield('title', 'Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/chess.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #334155;
            --bg-hover: #475569;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-purple: #8b5cf6;
            --accent-red: #ef4444;
            --accent-yellow: #f59e0b;
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, #1e1b4b 100%);
            min-height: 100vh;
            padding: 20px 0;
            color: var(--text-primary);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .chess-container {
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            padding: 30px;
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .game-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: var(--accent-blue);
        }

        .card {
            background: var(--bg-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
        }

        .card-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue) 0%, #2563eb 100%);
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        .btn-outline-primary:hover {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .badge {
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 8px 16px;
        }

        .alert {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
        }

        .move-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            transition: background 0.2s;
        }

        .move-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .move-number {
            color: var(--accent-yellow);
            font-weight: 600;
        }

        .text-muted {
            color: #94a3b8 !important;
        }

        .form-control, .form-select {
            background: var(--bg-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
        }

        .form-control:focus, .form-select:focus {
            background: var(--bg-secondary);
            border-color: var(--accent-blue);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-blue);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        .players-info .card:hover {
            border-color: var(--accent-purple);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark rounded mb-4">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('chess.index') }}">
                    <div class="chess-logo me-2">
                        <i class="bi bi-chess-knight fs-3" style="color: var(--accent-purple);"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Laravel Chess</div>
                        <small class="text-muted">Professional Dark Edition</small>
                    </div>
                </a>
                <div class="d-flex align-items-center">
                    <span class="badge bg-gradient me-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="bi bi-stars"></i> Pro Version
                    </span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
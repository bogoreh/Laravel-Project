<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Port Scanner')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .result-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        
        .result-card.open {
            border-left-color: #4ade80;
        }
        
        .result-card.closed {
            border-left-color: #ef4444;
        }
        
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .port-badge {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        
        .status-badge.open {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-badge.closed {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .scan-btn {
            background: linear-gradient(45deg, #4361ee, #3a0ca3);
            border: none;
            transition: all 0.3s ease;
        }
        
        .scan-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .scan-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .loading-spinner {
            display: none;
            color: #4361ee;
        }
        
        .stat-card {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .stat-card.open {
            background-color: rgba(74, 222, 128, 0.1);
            border: 1px solid #4ade80;
        }
        
        .stat-card.total {
            background-color: rgba(67, 97, 238, 0.1);
            border: 1px solid #4361ee;
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .scan-type-tab {
            padding: 0.75rem 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .scan-type-tab.active {
            background-color: #4361ee;
            color: white;
            border-color: #4361ee;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        @yield('content')
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
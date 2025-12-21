<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Issue Tracker - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #17a2b8;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .badge-priority-low { background-color: var(--success-color); }
        .badge-priority-medium { background-color: var(--info-color); }
        .badge-priority-high { background-color: var(--warning-color); }
        .badge-priority-critical { background-color: var(--danger-color); }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            min-height: calc(100vh - 56px);
            padding-top: 20px;
        }
        
        .sidebar a {
            color: #ecf0f1;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .sidebar a:hover {
            background-color: #34495e;
            color: white;
        }
        
        .sidebar a.active {
            background-color: var(--primary-color);
        }
        
        .issue-card {
            border-left: 4px solid;
        }
        
        .issue-card.bug { border-left-color: #e74c3c; }
        .issue-card.feature { border-left-color: #2ecc71; }
        .issue-card.task { border-left-color: #3498db; }
        .issue-card.improvement { border-left-color: #9b59b6; }
        
        .comment-bubble {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 10px 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-bug me-2"></i>Issue Tracker
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            @auth
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                        <i class="fas fa-project-diagram me-2"></i>Projects
                    </a>
                    <a class="nav-link {{ request()->routeIs('issues.*') ? 'active' : '' }}" href="{{ route('issues.index') }}">
                        <i class="fas fa-tasks me-2"></i>Issues
                    </a>
                    <a class="nav-link {{ request()->routeIs('my-issues') ? 'active' : '' }}" href="{{ route('issues.assigned') }}">
                        <i class="fas fa-user-check me-2"></i>My Assigned Issues
                    </a>
                    <a class="nav-link {{ request()->routeIs('reported-issues') ? 'active' : '' }}" href="{{ route('issues.reported') }}">
                        <i class="fas fa-flag me-2"></i>My Reported Issues
                    </a>
                </nav>
            </div>
            @endauth
            
            <main class="@auth col-md-9 col-lg-10 @else col-12 @endauth ms-sm-auto px-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Confirm before delete
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault();
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>
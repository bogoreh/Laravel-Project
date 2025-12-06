<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Budget Tracker')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --income-color: #2ecc71;
            --expense-color: #e74c3c;
            --sidebar-width: 250px;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #3a56d4 100%);
            color: white;
            height: 100vh;
            position: fixed;
            width: var(--sidebar-width);
            padding: 20px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #3a56d4;
        }
        .income {
            color: var(--income-color);
        }
        .expense {
            color: var(--expense-color);
        }
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .badge-income {
            background-color: var(--income-color);
        }
        .badge-expense {
            background-color: var(--expense-color);
        }
        .summary-card {
            border-radius: 15px;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .summary-income {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }
        .summary-expense {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        .summary-balance {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="text-center mb-4">
            <h2><i class="bi bi-wallet2"></i> BudgetTracker</h2>
            <p class="text-light">Manage your finances</p>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" 
               href="{{ route('transactions.index') }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}" 
               href="{{ route('transactions.create') }}">
                <i class="bi bi-plus-circle me-2"></i> Add Transaction
            </a>
        </nav>
        <div class="mt-auto">
            <div class="card bg-dark text-white p-3">
                <small>Track every penny,<br>master your budget</small>
            </div>
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
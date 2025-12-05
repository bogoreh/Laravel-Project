<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Donation Hub') - Giving Made Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2a9d8f;
            --secondary-color: #264653;
            --accent-color: #e9c46a;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            padding-top: 76px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #21867a;
            border-color: #21867a;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #2a9d8f 0%, #264653 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .progress-bar {
            background-color: var(--primary-color);
        }
        
        .donation-amount-btn {
            width: 80px;
            height: 50px;
            margin: 5px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            background: white;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .donation-amount-btn:hover, .donation-amount-btn.active {
            border-color: var(--primary-color);
            background-color: rgba(42, 157, 143, 0.1);
        }
        
        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .campaign-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Donation amount selection
        document.addEventListener('DOMContentLoaded', function() {
            // Amount buttons
            const amountButtons = document.querySelectorAll('.donation-amount-btn');
            const amountInput = document.querySelector('input[name="amount"]');
            
            amountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    amountButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    amountInput.value = this.dataset.amount;
                });
            });
            
            // Custom amount input
            if (amountInput) {
                amountInput.addEventListener('input', function() {
                    amountButtons.forEach(btn => btn.classList.remove('active'));
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
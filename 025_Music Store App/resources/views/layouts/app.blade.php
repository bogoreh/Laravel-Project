<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MusicStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .dark-header { 
            background-color: #1a1a2e;
            border-bottom: 1px solid #2d3748;
        }
        .music-gradient { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
        .dark-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        .album-card { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
        }
        .album-card:hover { 
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #c7d2fe;
        }
        .nav-link { 
            position: relative;
            color: #cbd5e0;
            transition: color 0.2s;
        }
        .nav-link:hover { 
            color: #ffffff;
        }
        .nav-link.active { 
            color: #ffffff;
            font-weight: 600;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            left: 0;
            bottom: -8px;
            border-radius: 2px;
        }
        .cart-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .mobile-menu {
            background-color: #1a1a2e;
            border-top: 1px solid #2d3748;
        }
        .footer-dark {
            background-color: #111827;
            border-top: 1px solid #2d3748;
        }
        .footer-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(26, 26, 46, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }
        .btn-secondary {
            background-color: #374151;
            color: white;
            border: 1px solid #4b5563;
            transition: all 0.3s;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Navigation - Dark Professional Theme -->
    <nav class="dark-header shadow-xl sticky top-0 z-50 glass-effect">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 shadow-lg">
                        <i class="fas fa-music text-white text-lg"></i>
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                            MusicStore
                        </a>
                        <div class="text-xs text-gray-400 font-medium">PREMIUM MUSIC EXPERIENCE</div>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} text-sm font-medium uppercase tracking-wider">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{ route('browse') }}" 
                       class="nav-link {{ request()->routeIs('browse') ? 'active' : '' }} text-sm font-medium uppercase tracking-wider">
                        <i class="fas fa-compact-disc mr-2"></i>Browse
                    </a>
                    <a href="{{ route('artists') }}" 
                       class="nav-link {{ request()->routeIs('artists') ? 'active' : '' }} text-sm font-medium uppercase tracking-wider">
                        <i class="fas fa-users mr-2"></i>Artists
                    </a>
                    
                    <!-- Cart with Badge -->
                    <div class="relative">
                        <a href="{{ route('cart') }}" 
                           class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 transition-all duration-200">
                            <i class="fas fa-shopping-cart text-purple-400"></i>
                            <span class="text-white font-medium">Cart</span>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="cart-badge absolute -top-2 -right-2 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </div>
                    
                    <!-- User Menu (Optional - for future auth) -->
                    <div class="flex items-center space-x-3 pl-4 border-l border-gray-700">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="text-gray-300 text-sm">Guest</span>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button id="menu-btn" class="text-gray-300 hover:text-white focus:outline-none">
                        <div class="w-8 h-8 flex flex-col items-center justify-center space-y-1.5">
                            <span class="block w-6 h-0.5 bg-gray-300"></span>
                            <span class="block w-6 h-0.5 bg-gray-300"></span>
                            <span class="block w-6 h-0.5 bg-gray-300"></span>
                        </div>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden mt-4 hidden mobile-menu rounded-lg p-4 shadow-lg">
                <div class="space-y-3">
                    <a href="{{ route('home') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-home text-purple-400 w-5"></i>
                        <span class="text-gray-200">Home</span>
                    </a>
                    <a href="{{ route('browse') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-compact-disc text-purple-400 w-5"></i>
                        <span class="text-gray-200">Browse Albums</span>
                    </a>
                    <a href="{{ route('artists') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-users text-purple-400 w-5"></i>
                        <span class="text-gray-200">Artists</span>
                    </a>
                    <a href="{{ route('cart') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-shopping-cart text-purple-400 w-5"></i>
                        <span class="text-gray-200">Shopping Cart</span>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge ml-auto rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-gradient-to-r from-red-500/10 to-rose-500/10 border border-red-500/20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer - Dark Professional Theme -->
    <footer class="footer-dark mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-music text-white"></i>
                        </div>
                        <div>
                            <div class="text-xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                                MusicStore
                            </div>
                            <div class="text-xs text-gray-400">Premium Music Experience</div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Your premier destination for high-quality music from artists worldwide. 
                        Discover, listen, and own your favorite albums.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('browse') }}" class="text-gray-400 hover:text-white transition">Browse Albums</a></li>
                        <li><a href="{{ route('artists') }}" class="text-gray-400 hover:text-white transition">Artists</a></li>
                        <li><a href="{{ route('cart') }}" class="text-gray-400 hover:text-white transition">Shopping Cart</a></li>
                    </ul>
                </div>
                
                <!-- Genres -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Genres</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">Pop</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">Rock</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">Hip Hop</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">Jazz</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">Electronic</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-gray-300 text-sm">R&B</span>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Stay Updated</h3>
                    <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest releases.</p>
                    <form class="space-y-3">
                        <input type="email" 
                               placeholder="Your email address" 
                               class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-500">
                        <button type="submit" 
                                class="w-full px-4 py-2 btn-primary rounded-lg font-medium">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 text-sm mb-4 md:mb-0">
                        &copy; {{ date('Y') }} MusicStore. All rights reserved.
                    </div>
                    
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-spotify"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            
            // Toggle hamburger to X animation
            const spans = this.querySelectorAll('span');
            if (menu.classList.contains('hidden')) {
                spans[0].style.transform = 'rotate(0) translateY(0)';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'rotate(0) translateY(0)';
            } else {
                spans[0].style.transform = 'rotate(45deg) translateY(6px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-6px)';
            }
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const menuBtn = document.getElementById('menu-btn');
            
            if (!menu.classList.contains('hidden') && 
                !menu.contains(event.target) && 
                !menuBtn.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
        
        // Add active class to current page link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (currentPath === linkPath || 
                   (currentPath.startsWith(linkPath) && linkPath !== '/')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
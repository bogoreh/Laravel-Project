@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Checkout</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Customer Information Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Customer Information</h2>
            <form method="POST" action="{{ route('order.place') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="customer_name">Full Name</label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="customer_email">Email Address</label>
                    <input type="email" 
                           id="customer_email" 
                           name="customer_email" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="customer_phone">Phone Number</label>
                    <input type="tel" 
                           id="customer_phone" 
                           name="customer_phone" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="customer_address">Shipping Address</label>
                    <textarea id="customer_address" 
                              name="customer_address" 
                              rows="4"
                              required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                
                <button type="submit" 
                        class="music-gradient text-white px-8 py-3 rounded-full font-bold text-lg w-full hover:opacity-90 transition duration-300">
                    Place Order
                </button>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
            
            <div class="space-y-4 mb-6">
                @foreach(session('cart', []) as $item)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ $item['cover_image'] ?: 'https://via.placeholder.com/50x50?text=Album' }}" 
                                 alt="{{ $item['title'] }}"
                                 class="w-12 h-12 object-cover rounded mr-3">
                            <div>
                                <div class="font-medium">{{ $item['title'] }}</div>
                                <div class="text-sm text-gray-600">{{ $item['artist'] }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div>${{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</div>
                            <div class="font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between text-lg mb-2">
                    <span>Subtotal</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg mb-2">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="flex justify-between text-2xl font-bold mt-4 pt-4 border-t border-gray-200">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
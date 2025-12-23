@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="text-center py-12">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-6">
            <i class="fas fa-check text-4xl text-green-600"></i>
        </div>
        
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Order Confirmed!</h1>
        <p class="text-xl text-gray-600 mb-2">Thank you for your purchase</p>
        <p class="text-gray-500 mb-8">Your order number is: <strong>{{ $order->order_number }}</strong></p>
        
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto mb-8">
            <h2 class="text-2xl font-bold mb-6 text-center">Order Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="font-bold text-gray-700 mb-2">Customer Information</h3>
                    <p class="text-gray-600">{{ $order->customer_name }}</p>
                    <p class="text-gray-600">{{ $order->customer_email }}</p>
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                </div>
                
                <div>
                    <h3 class="font-bold text-gray-700 mb-2">Shipping Address</h3>
                    <p class="text-gray-600">{{ $order->customer_address }}</p>
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="font-bold text-gray-700 mb-4">Order Items</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <img src="{{ $item->album->cover_image ?: 'https://via.placeholder.com/50x50?text=Album' }}" 
                                     alt="{{ $item->album->title }}"
                                     class="w-12 h-12 object-cover rounded mr-3">
                                <div>
                                    <div class="font-medium">{{ $item->album->title }}</div>
                                    <div class="text-sm text-gray-600">{{ $item->album->artist->name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold">${{ number_format($item->total_price, 2) }}</div>
                                <div class="text-sm text-gray-600">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="text-right border-t border-gray-200 pt-4">
                <div class="text-2xl font-bold">
                    Total: ${{ number_format($order->total_amount, 2) }}
                </div>
                <div class="text-sm text-gray-500 mt-2">
                    Order Status: 
                    <span class="font-bold {{ $order->status == 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="space-x-4">
            <a href="{{ route('home') }}" 
               class="music-gradient text-white px-6 py-3 rounded-lg font-bold hover:opacity-90 transition duration-300">
                Continue Shopping
            </a>
            <a href="{{ route('browse') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-300 transition duration-300">
                Browse More Albums
            </a>
        </div>
    </div>
@endsection
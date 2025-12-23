@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Shopping Cart</h1>
    
    @if(empty($cart))
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Your cart is empty</h3>
            <p class="text-gray-600 mb-6">Add some albums to get started!</p>
            <a href="{{ route('browse') }}" 
               class="music-gradient text-white px-6 py-3 rounded-lg font-bold hover:opacity-90 transition duration-300">
                Browse Albums
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">Album</th>
                            <th class="px-6 py-4 text-left">Price</th>
                            <th class="px-6 py-4 text-left">Quantity</th>
                            <th class="px-6 py-4 text-left">Total</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $item)
                            @php 
                                $itemTotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemTotal;
                            @endphp
                            <tr class="border-t border-gray-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $item['cover_image'] ?: 'https://via.placeholder.com/80x80?text=Album' }}" 
                                             alt="{{ $item['title'] }}"
                                             class="w-16 h-16 object-cover rounded mr-4">
                                        <div>
                                            <h4 class="font-bold">{{ $item['title'] }}</h4>
                                            <p class="text-gray-600">{{ $item['artist'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">${{ number_format($item['price'], 2) }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('cart.update') }}" class="flex items-center">
                                        @csrf
                                        <input type="number" 
                                               name="quantity[{{ $item['id'] }}]" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1"
                                               class="w-20 px-2 py-1 border border-gray-300 rounded">
                                    </form>
                                </td>
                                <td class="px-6 py-4 font-bold">${{ number_format($itemTotal, 2) }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('cart.remove', $item['id']) }}" 
                                       class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i> Remove
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <a href="{{ route('browse') }}" 
                           class="text-purple-600 hover:text-purple-800 font-medium">
                            <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                        </a>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-2xl font-bold mb-2">Total: ${{ number_format($subtotal, 2) }}</div>
                        <a href="{{ route('checkout') }}" 
                           class="music-gradient text-white px-8 py-3 rounded-full font-bold hover:opacity-90 transition duration-300">
                            Proceed to Checkout <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
<script>
    // Auto-update cart when quantity changes
    document.querySelectorAll('input[name^="quantity"]').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endsection
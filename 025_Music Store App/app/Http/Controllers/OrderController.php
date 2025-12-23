<?php
namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {
    public function cart() {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    public function addToCart(Request $request, $id) {
        $album = Album::findOrFail($id);
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $album->id,
                'title' => $album->title,
                'artist' => $album->artist->name,
                'price' => $album->price,
                'cover_image' => $album->cover_image,
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Album added to cart!');
    }

    public function removeFromCart($id) {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart')->with('success', 'Album removed from cart!');
    }

    public function updateCart(Request $request) {
        $cart = Session::get('cart', []);
        
        foreach ($request->quantity as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
            }
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function checkout() {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        return view('checkout');
    }

    public function placeOrder(Request $request) {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);
        
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);
        
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'album_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity']
            ]);
            
            // Update stock
            $album = Album::find($item['id']);
            $album->stock_quantity -= $item['quantity'];
            $album->save();
        }
        
        Session::forget('cart');
        
        return view('order-confirmation', compact('order'));
    }
}
<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order\Order;
use App\Models\order\OrderItem;
use App\Models\cart\Cart;
use App\Models\cart\CartItem;
use App\Models\product\Product;
use Auth;

class OrderController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->get();
        
        return response()->json($orders);
    }

    public function show($id) {
        $user = Auth::user();
        $order = $user->orders()->with('items.product')->find($id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // Check stock availability
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Not enough stock for product: ' . $item->product->name,
                    'product_id' => $item->product->id,
                    'available_stock' => $item->product->stock
                ], 400);
            }
        }

        // Calculate total
        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // Create order
        $order = $user->orders()->create([
            'total' => $total,
            'status' => 'pending'
        ]);

        // Create order items and update product stock
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);

            // Update product stock
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();
        }

        // Clear the cart
        $cart->items()->delete();

        return response()->json($order->load('items.product'), 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['updateStatus']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // Check stock availability
            foreach ($cart as $item) {
                $product = Product::find($item['product']->id);
                if ($product->stock < $item['quantity']) {
                    return redirect()->route('cart.index')
                        ->with('error', "Product {$product->name} only has {$product->stock} items in stock!");
                }
            }

            // Create order
            $order = Auth::user()->orders()->create([
                'status' => 'pending',
                'total' => array_reduce($cart, function($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0)
            ]);

            // Create order items and decrease stock
            foreach ($cart as $id => $item) {
                $product = Product::find($item['product']->id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);

                $product->decreaseStock($item['quantity']);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }


    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!$order->canBeCancelled()) {
            return redirect()->back()->with('error', 'Order cannot be cancelled at this stage.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            // Restore stock
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order cancelled successfully!');
    }


    public function updateStatus(Order $order, Request $request)
    {
        $this->authorize('updateStatus', $order);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,cancelled',
        ]);

        DB::transaction(function () use ($order, $request) {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            $order->update(['status' => $newStatus]);

            // If changing from shipped to cancelled or vice versa, adjust stock
            if (($oldStatus === 'shipped' && $newStatus === 'cancelled') ||
                ($oldStatus === 'cancelled' && $newStatus === 'shipped')) {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($newStatus === 'cancelled') {
                        $product->stock += $item->quantity;
                    } else {
                        $product->stock -= $item->quantity;
                    }
                    $product->save();
                }
            }
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order status updated!');
    }
}

<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure order belongs to user
        $userOwnsOrder = Order::where('id', $order->id)
                             ->where('user_id', Auth::id())
                             ->exists();

        if (!$userOwnsOrder) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('shop.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure order belongs to user
        $userOwnsOrder = Order::where('id', $order->id)
                             ->where('user_id', Auth::id())
                             ->exists();

        if (!$userOwnsOrder) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini tidak dapat dibatalkan karena sudah diproses.');
        }

        // Restore product stock
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        // Update order status
        $order->update([
            'status' => Order::STATUS_CANCELLED
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function markAsReceived(Order $order)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure order belongs to user
        $userOwnsOrder = Order::where('id', $order->id)
                             ->where('user_id', Auth::id())
                             ->exists();

        if (!$userOwnsOrder) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Check if order can be marked as received
        if (!$order->canBeMarkedAsReceived()) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Status pesanan ini tidak dapat diubah menjadi diterima.');
        }

        // Update order status
        $order->update([
            'status' => Order::STATUS_DELIVERED
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil ditandai sebagai diterima. Terima kasih telah berbelanja!');
    }

    public function receipt(Order $order)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure order belongs to user
        $userOwnsOrder = Order::where('id', $order->id)
                             ->where('user_id', Auth::id())
                             ->exists();

        if (!$userOwnsOrder) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $order->load('orderItems.product', 'user');

        return view('shop.orders.receipt', compact('order'));
    }
}

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
    try {
        // Enhanced logging for production debugging
        \Log::info('Order access attempt', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'user_id' => auth()->id(),
            'order_user_id' => $order->user_id,
            'session_id' => session()->getId(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Check authentication
        if (!auth()->check()) {
            \Log::warning('Unauthenticated order access attempt', [
                'order_number' => $order->order_number,
                'ip_address' => request()->ip()
            ]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check authorization
        if (auth()->id() != $order->user_id) {
            \Log::warning('Unauthorized order access attempt', [
                'order_number' => $order->order_number,
                'attempted_by_user' => auth()->id(),
                'actual_owner' => $order->user_id,
                'ip_address' => request()->ip()
            ]);
            return redirect()->route('shop.orders.index')
                ->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        \Log::info('Order access granted', [
            'order_number' => $order->order_number,
            'user_id' => auth()->id()
        ]);

        return view('shop.orders.show', compact('order'));

    } catch (\Exception $e) {
        \Log::error('Error accessing order', [
            'order_id' => $order->id ?? 'unknown',
            'user_id' => auth()->id() ?? 'unauthenticated',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->route('shop.orders.index')
            ->with('error', 'Terjadi kesalahan saat mengakses pesanan.');
    }
}

    public function cancel(Order $order)
    {
        // Ensure order belongs to user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
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
        // Ensure order belongs to user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
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
        // Ensure order belongs to user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load('orderItems.product', 'user');

        return view('shop.orders.receipt', compact('order'));
    }
}

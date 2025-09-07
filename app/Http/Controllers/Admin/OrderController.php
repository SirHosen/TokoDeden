<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $query = Order::with('user', 'orderItems');

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,rejected',
        ]);

        $previousStatus = $order->status;
        $newStatus = $request->status;

        // Check if the status transition is valid
        if ($newStatus !== $previousStatus && !$order->canTransitionTo($newStatus)) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Status pesanan tidak dapat diubah dari "' . $order->status_name . '" menjadi "' .
                    match($newStatus) {
                        Order::STATUS_PENDING => 'Menunggu Konfirmasi',
                        Order::STATUS_PROCESSING => 'Sedang Diproses',
                        Order::STATUS_SHIPPED => 'Dalam Pengiriman',
                        Order::STATUS_DELIVERED => 'Diterima',
                        Order::STATUS_CANCELLED => 'Dibatalkan',
                        Order::STATUS_REJECTED => 'Ditolak',
                        default => 'Status Tidak Diketahui',
                    } . '".');
        }

        // If rejecting or cancelling an order, restore product stock
        if ($newStatus === Order::STATUS_REJECTED ||
            ($newStatus === Order::STATUS_CANCELLED && $previousStatus !== Order::STATUS_CANCELLED)) {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
        }

        $order->update([
            'status' => $newStatus
        ]);

        $statusMessage = match($newStatus) {
            Order::STATUS_PROCESSING => 'Pesanan telah dikonfirmasi dan sedang diproses!',
            Order::STATUS_SHIPPED => 'Pesanan telah dikirim ke pelanggan!',
            Order::STATUS_DELIVERED => 'Pesanan telah ditandai sebagai diterima!',
            Order::STATUS_CANCELLED => 'Pesanan telah dibatalkan!',
            Order::STATUS_REJECTED => 'Pesanan telah ditolak!',
            default => 'Status pesanan berhasil diperbarui!',
        };

        return redirect()->route('admin.orders.show', $order)
            ->with('success', $statusMessage);
    }

    public function confirmOrder(Order $order)
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status menunggu konfirmasi yang dapat dikonfirmasi.');
        }

        $order->update([
            'status' => Order::STATUS_PROCESSING
        ]);

        // Send notification to customer that order is confirmed (implemented later)

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil dikonfirmasi dan sekarang sedang diproses!');
    }

    public function rejectOrder(Order $order)
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status menunggu konfirmasi yang dapat ditolak.');
        }

        // Restore product stock
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        $order->update([
            'status' => Order::STATUS_REJECTED
        ]);

        // Send notification to customer that order is rejected (implemented later)

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan telah ditolak.');
    }

    public function shipOrder(Order $order)
    {
        if ($order->status !== Order::STATUS_PROCESSING) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status sedang diproses yang dapat dikirim.');
        }

        $order->update([
            'status' => Order::STATUS_SHIPPED
        ]);

        // Send notification to customer that order is shipped (implemented later)

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan telah dikirim dan status berhasil diperbarui.');
    }

    public function cancelOrder(Order $order)
    {
        if (!in_array($order->status, [Order::STATUS_PENDING, Order::STATUS_PROCESSING])) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status menunggu konfirmasi atau sedang diproses yang dapat dibatalkan.');
        }

        // Restore product stock
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED
        ]);

        // Send notification to customer that order is cancelled (implemented later)

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan telah dibatalkan.');
    }

    public function receipt(Order $order)
    {
        $order->load('orderItems.product', 'user');

        return view('shop.orders.receipt', compact('order'));
    }
}

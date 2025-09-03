<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingSetting;
use App\Services\DistanceCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $distanceService;

    public function __construct(DistanceCalculationService $distanceService)
    {
        $this->distanceService = $distanceService;
    }

    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.products.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $user = Auth::user();

        return view('shop.checkout.index', compact('cartItems', 'subtotal', 'user'));
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $shippingSetting = ShippingSetting::first();

        $distance = $this->distanceService->calculateDistance(
            $shippingSetting->store_latitude,
            $shippingSetting->store_longitude,
            $request->latitude,
            $request->longitude
        );

        $shippingCost = 0;
        if ($distance > $shippingSetting->free_shipping_distance) {
            $shippingCost = ($distance - $shippingSetting->free_shipping_distance) * $shippingSetting->cost_per_km;
        }

        return response()->json([
            'distance' => $distance,
            'shipping_cost' => $shippingCost,
            'formatted_shipping_cost' => 'Rp ' . number_format($shippingCost, 0, ',', '.'),
        ]);
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $useDefaultAddress = $request->has('use_default_address');

        $validationRules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'payment_method' => 'required|in:transfer,cod',
            'notes' => 'nullable|string',
        ];

        if (!$useDefaultAddress) {
            $validationRules['address'] = 'required|string';
            $validationRules['city'] = 'nullable|string';
            $validationRules['province'] = 'nullable|string';
            $validationRules['postal_code'] = 'nullable|string';
        } else {
            // If using default address, make sure it exists
            if (!$user->address || !$user->is_default_address) {
                return redirect()->route('cart.index')
                    ->with('error', 'Alamat default tidak ditemukan. Silakan atur alamat default di profil Anda.');
            }
        }

        $request->validate($validationRules);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.products.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            // Check if stock is still available
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok produk {$item->product->name} tidak mencukupi.");
            }

            $subtotal += $item->product->price * $item->quantity;
        }

        // Calculate shipping cost
        $shippingSetting = ShippingSetting::first();
        $distance = $this->distanceService->calculateDistance(
            $shippingSetting->store_latitude,
            $shippingSetting->store_longitude,
            $request->latitude,
            $request->longitude
        );

        $shippingCost = 0;
        if ($distance > $shippingSetting->free_shipping_distance) {
            $shippingCost = ($distance - $shippingSetting->free_shipping_distance) * $shippingSetting->cost_per_km;
        }

        $totalPrice = $subtotal + $shippingCost;

        DB::beginTransaction();

        try {
            // Prepare order data
            $orderData = [
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'shipping_cost' => $shippingCost,
                'distance' => $distance,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'notes' => $request->notes,
            ];

            // Add address information based on whether using default address or not
            if ($request->has('use_default_address') && $user->is_default_address) {
                $orderData['address'] = $user->address;
                $orderData['city'] = $user->city;
                $orderData['province'] = $user->province;
                $orderData['postal_code'] = $user->postal_code;
            } else {
                $orderData['address'] = $request->address;
                $orderData['city'] = $request->city;
                $orderData['province'] = $request->province;
                $orderData['postal_code'] = $request->postal_code;
            }

            // Create order
            $order = Order::create($orderData);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Reduce product stock
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('checkout.index')
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
        }
    }
}

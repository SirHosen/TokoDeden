<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('shop.cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if stock is available
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Check if product already in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            // Update quantity if already in cart
            $newQuantity = $existingCart->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            // Add new item to cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure cart belongs to user
        $userOwnsCart = Cart::where('id', $cart->id)
                           ->where('user_id', Auth::id())
                           ->exists();

        if (!$userOwnsCart) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang Anda');
        }

        // Check stock availability
        if ($cart->product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove(Cart $cart)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ensure cart belongs to user
        $userOwnsCart = Cart::where('id', $cart->id)
                           ->where('user_id', Auth::id())
                           ->exists();

        if (!$userOwnsCart) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang Anda');
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippingSetting = ShippingSetting::first();
        return view('admin.shipping.index', compact('shippingSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'free_shipping_distance' => 'required|numeric|min:0',
            'cost_per_km' => 'required|numeric|min:0',
            'store_latitude' => 'required|numeric',
            'store_longitude' => 'required|numeric',
        ]);

        $shippingSetting = ShippingSetting::first();
        $shippingSetting->update($request->all());

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Pengaturan ongkos kirim berhasil diperbarui!');
    }
}

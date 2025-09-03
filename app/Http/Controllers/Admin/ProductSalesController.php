<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSalesController extends Controller
{
    /**
     * Display a listing of product sales.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Set default date range (last 30 days)
        $endDate = $request->input('end_date')
            ? \Carbon\Carbon::parse($request->input('end_date'))
            : now();

        $startDate = $request->input('start_date')
            ? \Carbon\Carbon::parse($request->input('start_date'))
            : $endDate->copy()->subDays(30);

        // Make sure startDate is before endDate
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // End date should be inclusive of the entire day
        $endDate = $endDate->endOfDay();
        $startDate = $startDate->startOfDay();

        // Get product sales data
        $productSales = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.stock',
            'products.image',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'),
            DB::raw('COUNT(DISTINCT orders.id) as order_count')
        )
        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
            $join->on('order_items.order_id', '=', 'orders.id')
                 ->where('orders.status', Order::STATUS_DELIVERED)
                 ->whereBetween('orders.created_at', [$startDate, $endDate]);
        })
        ->groupBy('products.id', 'products.name', 'products.price', 'products.stock', 'products.image')
        ->orderByRaw('COALESCE(SUM(order_items.quantity), 0) DESC')
        ->paginate(15);

        // Get total products sold
        $totalSold = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', Order::STATUS_DELIVERED)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->sum('quantity');

        // Get total revenue
        $totalRevenue = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', Order::STATUS_DELIVERED)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->sum(DB::raw('order_items.price * order_items.quantity'));

        return view('admin.products.sales', compact(
            'productSales',
            'startDate',
            'endDate',
            'totalSold',
            'totalRevenue'
        ));
    }
}

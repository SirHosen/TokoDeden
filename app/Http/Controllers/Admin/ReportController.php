<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    /**
     * Show the reports dashboard.
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

        // Get orders data for reports
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $totalOrders = $orders->count();
        $totalSales = $orders->sum('total_price');
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Prepare chart data - daily sales over the selected period
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('status', 'completed')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->pluck('total', 'date')
        ->toArray();

        // Create a series with all dates in the range
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate
        );

        $chartLabels = [];
        $chartData = [];

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->format('d M');
            $chartData[] = $dailySales[$dateString] ?? 0;
        }

        // Get product sales data
        $productSales = Product::select(
            'products.id',
            'products.name',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
        )
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->groupBy('products.id', 'products.name')
        ->orderBy('total_revenue', 'desc')
        ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'totalSales',
            'averageOrderValue',
            'chartLabels',
            'chartData',
            'productSales'
        ));
    }

    /**
     * Export reports as PDF.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Get date filter parameters
        $endDate = $request->input('end_date')
            ? \Carbon\Carbon::parse($request->input('end_date'))->endOfDay()
            : now();

        $startDate = $request->input('start_date')
            ? \Carbon\Carbon::parse($request->input('start_date'))->startOfDay()
            : $endDate->copy()->subDays(30)->startOfDay();

        // Get filtered orders
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get product sales data
        $productSales = Product::select(
            'products.id',
            'products.name',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
        )
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->groupBy('products.id', 'products.name')
        ->orderBy('total_revenue', 'desc')
        ->take(10)
        ->get();

        // Prepare summary data
        $totalOrders = $orders->count();
        $totalSales = $orders->sum('total_price');
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Get daily sales data for chart
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('status', 'completed')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Generate PDF with view
        $pdf = \PDF::loadView('admin.reports.pdf', [
            'orders' => $orders,
            'productSales' => $productSales,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'averageOrderValue' => $averageOrderValue,
            'dailySales' => $dailySales
        ]);

        // Set paper to landscape for better readability
        $pdf->setPaper('a4', 'landscape');

        // Stream the PDF with a download filename
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }
}

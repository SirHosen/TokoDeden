<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Export reports as CSV.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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

        // Set CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders-report-' . date('Y-m-d') . '.csv"',
        ];

        // Get filtered orders
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $callback = function() use ($orders, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Add report title and date range
            fputcsv($file, ['Laporan Penjualan TokoDeden']);
            fputcsv($file, ['Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y')]);
            fputcsv($file, []);

            // Add headers
            fputcsv($file, ['ID Pesanan', 'Pelanggan', 'Email', 'Tanggal', 'Status', 'Jumlah Item', 'Total (Rp)']);

            // Add data rows
            foreach ($orders as $order) {
                $itemCount = $order->orderItems->count();

                fputcsv($file, [
                    $order->id,
                    $order->user->name ?? 'N/A',
                    $order->user->email ?? 'N/A',
                    $order->created_at->format('Y-m-d H:i:s'),
                    ucfirst($order->status),
                    $itemCount,
                    number_format($order->total_price, 0, ',', '.')
                ]);
            }

            // Add summary
            fputcsv($file, []);
            fputcsv($file, ['Total Pesanan', $orders->count()]);
            fputcsv($file, ['Total Pendapatan', number_format($orders->sum('total_price'), 0, ',', '.')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

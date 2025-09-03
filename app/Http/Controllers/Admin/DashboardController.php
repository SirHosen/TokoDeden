<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats for admin dashboard
        $totalCustomers = User::where('role_id', 2)->count();
        $totalProducts = Product::count();
        $totalOrders = Order::where('status', Order::STATUS_DELIVERED)->count();
        $totalRevenue = Order::where('status', Order::STATUS_DELIVERED)->sum('total_price');

        // Get monthly revenue data for chart
        $monthlyRevenue = Order::where('status', Order::STATUS_DELIVERED)
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for chart
        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = Carbon::create()->month($i)->format('F');
            $monthRevenue = $monthlyRevenue->firstWhere('month', $i);
            $chartData[] = $monthRevenue ? $monthRevenue->revenue : 0;
        }

        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'chartLabels',
            'chartData',
            'recentOrders'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'sales');

        // Sales Metrics
        $totalRevenue = Order::sum('total');
        $averageOrderValue = Order::count() > 0 ? $totalRevenue / Order::count() : 0;
        $totalOrders = Order::count();
        $totalUnitsSold = OrderItem::sum('quantity');

        // Top products by quantity sold
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_revenue'))
            ->groupBy('product_name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'), DB::raw('SUM(total) as revenue'))
            ->groupBy('status')
            ->get();

        // Customer stats
        $totalCustomers = User::where('role', 'user')->count();
        $topCustomers = Order::select('customer_name', 'customer_email', DB::raw('count(*) as order_count'), DB::raw('SUM(total) as spend'))
            ->groupBy('customer_name', 'customer_email')
            ->orderBy('spend', 'desc')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'type',
            'totalRevenue',
            'averageOrderValue',
            'totalOrders',
            'totalUnitsSold',
            'topProducts',
            'ordersByStatus',
            'totalCustomers',
            'topCustomers'
        ));
    }
}

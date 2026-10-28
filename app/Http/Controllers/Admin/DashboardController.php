<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalProducts = Product::count();

        $recentOrders = Order::with('items')->orderBy('created_at', 'desc')->take(6)->get();

        // Monthly / Sales overview data
        $ordersByStatus = [
            'Pending' => Order::where('status', 'Pending')->count(),
            'Processing' => Order::where('status', 'Processing')->count(),
            'Shipped' => Order::where('status', 'Shipped')->count(),
            'Delivered' => Order::where('status', 'Delivered')->count(),
            'Cancelled' => Order::where('status', 'Cancelled')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'recentOrders',
            'ordersByStatus'
        ));
    }
}

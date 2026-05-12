<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // Stat cards
            'totalRevenue'  => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'totalOrders'   => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'totalProducts' => Product::count(),
            'lowStock'      => Product::where('stock', '<=', 5)->count(),
            'totalUsers'    => User::where('role', 'customer')->count(),

            // Tables
            'products'      => Product::with('category')->latest()->get(),
            'orders'        => Order::with('user')->latest()->take(10)->get(),
            'users'         => User::where('role', 'customer')->latest()->take(10)->get(),
        ]);
    }
}
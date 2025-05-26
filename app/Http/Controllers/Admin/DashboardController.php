<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();

        $latestOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('quantity', '<', 5)
            ->where('active', true)
            ->orderBy('quantity')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalSales' => $totalSales,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'totalProducts' => $totalProducts,
                'totalUsers' => $totalUsers,
            ],
            'latestOrders' => $latestOrders,
            'lowStockProducts' => $lowStockProducts
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,card,online',
            'delivery_method' => 'required|in:pickup,delivery',
            'notes' => 'nullable|string'
        ]);

        $cart = Session::get('cart', [
            'items' => [],
            'total' => 0,
            'total_quantity' => 0
        ]);

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        try {
            DB::beginTransaction();

            $order = new Order([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'payment_method' => $request->payment_method,
                'delivery_method' => $request->delivery_method,
                'notes' => $request->notes,
                'status' => 'pending',
                'total' => $cart['total']
            ]);

            if (Auth::check()) {
                $order->user_id = Auth::id();
            }

            $order->save();

            foreach ($cart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product']['price']
                ]);
            }

            Session::put('cart', [
                'items' => [],
                'total' => 0,
                'total_quantity' => 0
            ]);

            DB::commit();

            return redirect()->route('orders.success', $order->id)->with('success', 'Заказ успешно оформлен');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['general' => 'Произошла ошибка при оформлении заказа: ' . $e->getMessage()]);
        }
    }

    public function success($id)
    {
        $query = Order::with('items.product');

        if (Auth::check()) {
            $query->where(function($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('email', Auth::user()->email);
            });
        }

        $order = $query->findOrFail($id);

        return Inertia::render('Orders/Success', [
            'order' => $order
        ]);
    }

    public function index()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет доступа к этому разделу');
        }

        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет доступа к этому разделу');
        }

        $order = Order::with(['items.product', 'user'])
            ->findOrFail($id);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет доступа к этому разделу');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Статус заказа обновлен');
    }
}

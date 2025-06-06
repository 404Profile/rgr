<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load(['user', 'items.product'])
        ]);
    }

    public function edit(Order $order)
    {
        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order->load(['user', 'items.product'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Заказ успешно обновлен');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Заказ успешно удален');
    }
}

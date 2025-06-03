<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();

        return Inertia::render('Cart', [
            'cart' => $cart
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::with(['category', 'brand'])->findOrFail($request->product_id);

        if (!$product->active) {
            return back()->with('error', 'Этот товар недоступен для заказа.');
        }

        $cart = $this->getCart();

        if (!isset($cart['items'])) {
            $cart['items'] = [];
        }

        $existingItem = collect($cart['items'])->first(function ($item) use ($request) {
            return $item['product']['id'] == $request->product_id;
        });

        if ($existingItem) {
            $this->updateItemQuantity($cart, $request->product_id, $existingItem['quantity'] + $request->quantity);
        } else {
            if (method_exists($product, 'getName')) {
                $product->append('name');
            }

            $cart['items'][] = [
                'id' => uniqid(),
                'product' => $product->toArray(),
                'quantity' => (int)$request->quantity
            ];

            $this->recalculateCart($cart);

            Session::put('cart', $cart);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();

        $this->updateItemQuantity($cart, $request->product_id, $request->quantity);

        return back()->with('success', 'Корзина обновлена');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = $this->getCart();

        if (!isset($cart['items'])) {
            $cart['items'] = [];
            return back()->with('error', 'Товар не найден в корзине');
        }

        $cart['items'] = collect($cart['items'])->filter(function ($item) use ($request) {
            return $item['product']['id'] != $request->product_id;
        })->values()->all();

        $this->recalculateCart($cart);

        Session::put('cart', $cart);

        return back()->with('success', 'Товар удален из корзины');
    }

    public function clear()
    {
        $emptyCart = [
            'items' => [],
            'total' => 0,
            'total_quantity' => 0
        ];

        Session::put('cart', $emptyCart);

        return back()->with('success', 'Корзина очищена');
    }

    private function getCart()
    {
        if (!Session::has('cart')) {
            $emptyCart = [
                'items' => [],
                'total' => 0,
                'total_quantity' => 0
            ];

            Session::put('cart', $emptyCart);
            return $emptyCart;
        }

        $cart = Session::get('cart');

        if (!isset($cart['items'])) {
            $cart['items'] = [];
        }

        if (!isset($cart['total'])) {
            $cart['total'] = 0;
        }

        if (!isset($cart['total_quantity'])) {
            $cart['total_quantity'] = 0;
        }

        return $cart;
    }

    private function updateItemQuantity(&$cart, $productId, $quantity)
    {
        if (!isset($cart['items'])) {
            $cart['items'] = [];
            return;
        }

        $found = false;

        foreach ($cart['items'] as &$item) {
            if ($item['product']['id'] == $productId) {
                $item['quantity'] = (int)$quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product = Product::with(['category', 'brand'])->findOrFail($productId);

            if (method_exists($product, 'getName')) {
                $product->append('name');
            }

            $cart['items'][] = [
                'id' => uniqid(),
                'product' => $product->toArray(),
                'quantity' => (int)$quantity
            ];
        }

        $this->recalculateCart($cart);

        Session::put('cart', $cart);
    }

    private function recalculateCart(&$cart)
    {
        $total = 0;
        $totalQuantity = 0;

        if (!isset($cart['items'])) {
            $cart['items'] = [];
        }

        foreach ($cart['items'] as $item) {
            $total += $item['product']['price'] * $item['quantity'];
            $totalQuantity += $item['quantity'];
        }

        $cart['total'] = $total;
        $cart['total_quantity'] = $totalQuantity;
    }
}

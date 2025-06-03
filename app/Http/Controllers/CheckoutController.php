<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
        }

        return Inertia::render('Checkout', [
            'cart' => $cart,
            'user' => Auth::user(),
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object) []
        ]);
    }

    private function getCart()
    {
        if (!Session::has('cart')) {
            $emptyCart = [
                'items' => [],
                'total' => 0,
                'total_quantity' =>
                    0
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
}

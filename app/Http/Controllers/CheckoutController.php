<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $ongkir = 10000; // Dummy
        $diskon = 0;     // Dummy
        $total = $subtotal + $ongkir - $diskon;

        return view('marketplace.checkout', compact('cartItems', 'subtotal', 'ongkir', 'diskon', 'total'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $total = $subtotal;

        \Illuminate\Support\Facades\Log::info('Cart Index - Perhitungan Harga:', [
            'subtotal' => $subtotal,
            'total' => $total
        ]);

        return view('marketplace.cart', compact('cartItems', 'subtotal', 'total'));
    }

    public function add($id, Request $request)
    {
        $product = Obat::with('kategori')->findOrFail($id);

        // Check if stock is available
        if ($product->stok < 1) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Stok obat habis!'], 422);
            }
            return redirect()->back()->with('error', 'Stok obat habis!');
        }

        $cart = session()->get('cart', []);
        $qty = $request->input('qty', 1);

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['qty'] + $qty;
            if ($newQty > $product->stok) {
                $newQty = $product->stok; // Limit to maximum stock
            }
            $cart[$id]['qty'] = $newQty;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
        } else {
            // Determine fallback premium image
            $imageFallback = str_contains(strtolower($product->kategori->nama_kategori ?? ''), 'vitamin')
                ? '/premium_supplement_bottle.png'
                : '/premium_medicine_box.png';

            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->nama_obat,
                'category' => $product->kategori->nama_kategori ?? 'Obat',
                'price'    => (float) $product->harga_jual,
                'qty'      => $qty,
                'image'    => $product->image ?? $product->gambar ?? $imageFallback,
                'subtotal' => (float) $product->harga_jual * $qty,
            ];
        }

        session()->put('cart', $cart);

        // Kalau request dari AJAX (fetch), kembalikan JSON, tetap di halaman yang sama
        if ($request->wantsJson() || $request->ajax()) {
            $cartCount = count(session()->get('cart', []));
            return response()->json([
                'success'   => true,
                'message'   => 'Obat berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount,
            ]);
        }

        // Fallback kalau JS dimatikan
        return redirect()->route('cart.index')->with('success', 'Obat berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $qty = (int) $request->input('qty', 1);

        if (!$id) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $product = Obat::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                // Limit to maximum stock
                if ($qty > $product->stok) {
                    $qty = $product->stok;
                }
                $cart[$id]['qty'] = $qty;
                $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
            }
            session()->put('cart', $cart);

            // Calculate new totals for AJAX updates
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['qty'];
            }
            $total = $subtotal;

            \Illuminate\Support\Facades\Log::info('Cart Update (AJAX) - Perhitungan Harga:', [
                'subtotal' => $subtotal,
                'total' => $total
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'qty' => $qty,
                    'itemSubtotal' => 'Rp ' . number_format($cart[$id]['subtotal'] ?? 0, 0, ',', '.'),
                    'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                    'total' => 'Rp ' . number_format($total, 0, ',', '.'),
                    'itemCount' => count($cart)
                ]);
            }
        }

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
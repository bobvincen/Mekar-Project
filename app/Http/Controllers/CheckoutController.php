<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = session()->get('cart', []);

        if ($request->has('selected')) {
            $selectedIds = explode(',', $request->query('selected'));
            $filteredCart = [];
            foreach ($cartItems as $id => $item) {
                if (in_array($id, $selectedIds)) {
                    $filteredCart[$id] = $item;
                }
            }
            $cartItems = $filteredCart;
            session()->put('checkout_cart', $cartItems);
        } else {
            $cartItems = session()->get('checkout_cart', $cartItems);
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong atau tidak ada produk yang dipilih.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $ongkir = 0;
        $total = $subtotal;

        \Illuminate\Support\Facades\Log::info('Checkout Index - Perhitungan Harga:', [
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total' => $total
        ]);

        return view('marketplace.checkout', compact('cartItems', 'subtotal', 'ongkir', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'metode' => 'required|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'jarak' => 'nullable|numeric',
            'ongkir' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        $cartItems = session()->get('checkout_cart', session()->get('cart', []));

        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong atau produk belum dipilih.'
            ], 400);
        }

        // Generate Kode Transaksi
        $date = date('Ymd');
        $lastTrx = \App\Models\Transaksi::where('kode_transaksi', 'like', "TRX-{$date}-%")->orderBy('id', 'desc')->first();

        \Illuminate\Support\Facades\Log::info('Checkout Process (Submit) - Perhitungan Harga:', [
            'subtotal' => $validated['subtotal'],
            'ongkir' => $validated['ongkir'],
            'total' => $validated['total']
        ]);
        if ($lastTrx) {
            $lastSequence = intval(substr($lastTrx->kode_transaksi, -4));
            $nextSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextSequence = '0001';
        }
        $kodeTransaksi = "TRX-{$date}-{$nextSequence}";

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Save Transaksi
            $transaksi = \App\Models\Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_transaksi' => now(),
                'total_harga' => $validated['total'],
                'bayar' => 0, // Placeholder
                'kembalian' => 0, // Placeholder
                'nama_pelanggan' => $validated['nama'],
                'whatsapp' => $validated['whatsapp'],
                'alamat' => $validated['alamat'],
                'metode_pengambilan' => $validated['metode'],
                'latitude' => $validated['lat'],
                'longitude' => $validated['lng'],
                'jarak' => $validated['jarak'],
                'ongkir' => $validated['ongkir'],
                'subtotal' => $validated['subtotal'],
                'catatan' => $validated['catatan'],
                'status' => 'Menunggu Konfirmasi',
            ]);

            // Save Detail Transaksi
            foreach ($cartItems as $id => $item) {
                \App\Models\DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $id,
                    'jumlah' => $item['qty'],
                    'harga' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            // Clear session cart
            session()->forget('checkout_cart');
            $mainCart = session()->get('cart', []);
            foreach ($cartItems as $id => $item) {
                unset($mainCart[$id]);
            }
            session()->put('cart', $mainCart);

            // Generate WhatsApp URL
            $adminPhone = '6282240432990';
            
            $message = "Halo Admin Mekar Pharmacy 👋\n\nSaya ingin melakukan pemesanan obat.\n\n";
            $message .= "🧾 *Kode Transaksi:*\n{$kodeTransaksi}\n\n";
            $message .= "📌 *Informasi Pemesan*\n\n";
            $message .= "Nama:\n{$validated['nama']}\n\n";
            $message .= "No WhatsApp:\n{$validated['whatsapp']}\n\n";
            $message .= "🚚 *Metode Pengambilan:*\n{$validated['metode']}\n\n";
            
            if ($validated['metode'] !== 'Ambil di Apotek') {
                $message .= "📍 *Lokasi Pengiriman*\n\n";
                $message .= "Alamat:\n{$validated['alamat']}\n\n";
                if ($validated['jarak']) {
                    $message .= "Jarak:\n" . number_format($validated['jarak'], 2) . " KM\n\n";
                }
                $message .= "Perkiraan Ongkir:\nRp " . number_format($validated['ongkir'], 0, ',', '.') . "\n\n";
                if ($validated['lat'] && $validated['lng']) {
                    $message .= "Link Maps:\nhttps://maps.google.com/?q={$validated['lat']},{$validated['lng']}\n\n";
                }
            } else {
                $message .= "📍 *Lokasi Pengambilan*\n\n";
                $message .= "Alamat:\n(Ambil di Apotek)\n\n";
            }
            
            $message .= "🛒 *Detail Pesanan*\n\n";
            foreach ($cartItems as $item) {
                $sub = $item['price'] * $item['qty'];
                $message .= "- {$item['name']} x{$item['qty']} = Rp " . number_format($sub, 0, ',', '.') . "\n";
            }
            
            $message .= "\n💰 *Ringkasan Pembayaran*\n\n";
            $message .= "Subtotal:\nRp " . number_format($validated['subtotal'], 0, ',', '.') . "\n\n";
            $message .= "Ongkir:\nRp " . number_format($validated['ongkir'], 0, ',', '.') . "\n\n";
            $message .= "*Total:*\n*Rp " . number_format($validated['total'], 0, ',', '.') . "*\n\n";
            
            if (!empty($validated['catatan'])) {
                $message .= "📝 *Catatan:*\n{$validated['catatan']}\n\n";
            }
            $message .= "Mohon konfirmasi pesanan saya.\n\nTerima kasih 🙏";

            $waUrl = "https://wa.me/{$adminPhone}?text=" . urlencode($message);

            return response()->json([
                'success' => true,
                'wa_url' => $waUrl,
                'kode_transaksi' => $kodeTransaksi
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.'
            ], 500);
        }
    }
}

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
            'alamat' => 'nullable|string',
            'metode' => 'required|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'jarak' => 'nullable|numeric',
            'ongkir' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'catatan' => 'nullable|string',
<<<<<<< HEAD
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
=======
<<<<<<< HEAD
=======
        ], [
>>>>>>> 750dc18166dc1dd7544ae9979ab7be5c0c7e637c
            'metode.required' => 'Metode pengambilan wajib dipilih.',
            'ongkir.required' => 'Ongkir wajib diisi.',
            'subtotal.required' => 'Subtotal wajib diisi.',
            'total.required' => 'Total wajib diisi.',
<<<<<<< HEAD
=======
>>>>>>> 7916183 (refactor:checkout)
>>>>>>> 750dc18166dc1dd7544ae9979ab7be5c0c7e637c
        ]);
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus Login untuk melakukan checkout.'
            ], 401);
        }

        $cartItems = session()->get('checkout_cart', session()->get('cart', []));

        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong atau produk belum dipilih.'
            ], 400);
        }

        // Generate Kode Transaksi
        $date = date('Ymd');
        $lastTrx = \App\Models\Transaksi::where('kode_transaksi', 'like', "TRX-{$date}-%")
            ->where('kode_transaksi', 'not like', '%-OFF')
            ->orderBy('id', 'desc')
            ->first();

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
                'user_id' => auth()->id(),
                'tanggal_transaksi' => now(),
                'total_harga' => $validated['total'],
                'bayar' => 0, // Placeholder
                'kembalian' => 0, // Placeholder
<<<<<<< HEAD
                'nama_pelanggan' => $validated['nama'],
                'whatsapp' => $validated['whatsapp'],
<<<<<<< HEAD
                'alamat' => $validated['alamat'] ?? null,
=======
                'alamat' => $validated['alamat'],
=======
                'nama_pelanggan' => $user->name,
                'whatsapp' => $validated['whatsapp'] ?? $user->whatsapp,
                'alamat' => $validated['alamat'] ?? null,
>>>>>>> 7916183 (refactor:checkout)
>>>>>>> 750dc18166dc1dd7544ae9979ab7be5c0c7e637c
                'metode_pengambilan' => $validated['metode'],
                'latitude' => $validated['lat'] ?? null,
                'longitude' => $validated['lng'] ?? null,
                'jarak' => $validated['jarak'] ?? null,
                'ongkir' => $validated['ongkir'],
                'subtotal' => $validated['subtotal'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Menunggu Pembayaran',
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

            // Complete prescription checkout if any in 'siap_checkout' status
            try {
                $resepService = app(\App\Services\ResepDokterService::class);
                $resepService->completeCheckout(auth()->id());
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal memperbarui status resep saat checkout: ' . $e->getMessage());
            }

            // Clear session cart
            session()->forget('checkout_cart');
            $mainCart = session()->get('cart', []);
            foreach ($cartItems as $id => $item) {
                unset($mainCart[$id]);
            }
            session()->put('cart', $mainCart);

            return response()->json([
                'success' => true,
                'kode_transaksi' => $kodeTransaksi,
                'redirect_url' => route('marketplace.invoice', $kodeTransaksi)
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

    /**
     * Show the invoice details to the customer.
     */
    public function showInvoice($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::with(['detailTransaksis.obat'])
            ->where('kode_transaksi', $kode_transaksi)
            ->firstOrFail();

        return view('marketplace.invoice', compact('transaksi'));
    }

    /**
     * Upload proof of transfer.
     */
    public function uploadBukti(Request $request, $kode_transaksi)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'bukti_transfer.required' => 'File bukti transfer wajib diunggah.',
            'bukti_transfer.image' => 'File harus berupa gambar.',
            'bukti_transfer.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_transfer.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $transaksi = \App\Models\Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();

        // Save image to public storage
        $file = $request->file('bukti_transfer');
        $filename = $kode_transaksi . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti-transfer', $filename, 'public');

        // Update database status and path
        $transaksi->update([
            'bukti_transfer' => $path,
            'status' => 'Menunggu Verifikasi',
            'verifikasi_catatan' => null, // reset notes if re-uploaded
        ]);

        // Send WhatsApp notification to Admin via Fonnte API
        $adminPhone = config('services.fonnte.admin_phone', '6282240432990');
        $totalFormatted = 'Rp ' . number_format($transaksi->total_harga, 0, ',', '.');
        
        $message = "Pesanan Baru\n\n";
        $message .= "Invoice :\n{$transaksi->kode_transaksi}\n\n";
        $message .= "Nama :\n{$transaksi->nama_pelanggan}\n\n";
        $message .= "Total :\n{$totalFormatted}\n\n";
        $message .= "Silakan login ke Dashboard Admin untuk melakukan verifikasi pembayaran.";

        \App\Services\FonnteService::send($adminPhone, $message);

        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah! Menunggu verifikasi dari admin.');
    }
}

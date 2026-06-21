<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ─────────────────────────────────────────
    // INDEX — daftar semua transaksi
    // ─────────────────────────────────────────
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'detailTransaksis'])
            ->latest()
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    // ─────────────────────────────────────────
    // CREATE — form transaksi baru
    // ─────────────────────────────────────────
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $obats      = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();

        return view('transaksi.create', compact('pelanggans', 'obats'));
    }

    // ─────────────────────────────────────────
    // STORE — simpan transaksi baru
    // ─────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'          => 'nullable|exists:pelanggans,id',
            'tanggal_transaksi'     => 'required|date',
            'bayar'                 => 'required|numeric|min:0',
            'obat_id'               => 'required|array|min:1',
            'obat_id.*'             => 'required|exists:obats,id',
            'jumlah.*'              => 'required|integer|min:1',
        ], [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'bayar.required'             => 'Jumlah bayar wajib diisi.',
            'bayar.numeric'              => 'Jumlah bayar harus berupa angka.',
            'bayar.min'                  => 'Jumlah bayar minimal 0.',
            'obat_id.required'           => 'Minimal pilih satu obat.',
            'obat_id.min'                => 'Minimal pilih satu obat.',
        ]);

        // Validate stock availability
        foreach ($request->obat_id as $i => $obatId) {
            $obat   = Obat::findOrFail($obatId);
            $jumlah = $request->jumlah[$i];
            if ($jumlah > $obat->stok) {
                return back()->withInput()->withErrors([
                    'jumlah.' . $i => "Stok obat {$obat->nama_obat} tidak mencukupi (Tersedia: {$obat->stok})."
                ]);
            }
        }

        DB::beginTransaction();
        try {
            // Hitung total dari item-item
            $total = 0;
            foreach ($request->obat_id as $i => $obatId) {
                $obat    = Obat::findOrFail($obatId);
                $jumlah  = $request->jumlah[$i];
                $total  += $obat->harga_jual * $jumlah;
            }

            $bayar      = $request->bayar;
            $kembalian  = $bayar - $total;

            // Buat header transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi'    => 'TRX-' . strtoupper(uniqid()),
                'user_id'           => auth()->id(),
                'pelanggan_id'      => $request->pelanggan_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'total_harga'       => $total,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
            ]);

            // Simpan detail + kurangi stok
            foreach ($request->obat_id as $i => $obatId) {
                $obat   = Obat::findOrFail($obatId);
                $jumlah = $request->jumlah[$i];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id'      => $obatId,
                    'jumlah'       => $jumlah,
                    'harga'        => $obat->harga_jual,
                    'subtotal'     => $obat->harga_jual * $jumlah,
                ]);

                // Kurangi stok obat
                $obat->decrement('stok', $jumlah);
            }

            DB::commit();

            return redirect()->route('transaksi.show', $transaksi)
                ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // SHOW — detail satu transaksi
    // ─────────────────────────────────────────
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'detailTransaksis.obat', 'user']);
        return view('transaksi.show', compact('transaksi'));
    }

    // ─────────────────────────────────────────
    // EDIT — form edit transaksi
    // ─────────────────────────────────────────
    public function edit(Transaksi $transaksi)
    {
        $transaksi->load(['detailTransaksis.obat']);
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $obats      = Obat::orderBy('nama_obat')->get();

        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'obats'));
    }

    // ─────────────────────────────────────────
    // UPDATE — perbarui transaksi
    // ─────────────────────────────────────────
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'pelanggan_id'          => 'nullable|exists:pelanggans,id',
            'tanggal_transaksi'     => 'required|date',
            'bayar'                 => 'required|numeric|min:0',
            'obat_id'               => 'required|array|min:1',
            'obat_id.*'             => 'required|exists:obats,id',
            'jumlah.*'              => 'required|integer|min:1',
        ], [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'bayar.required'             => 'Jumlah bayar wajib diisi.',
            'bayar.numeric'              => 'Jumlah bayar harus berupa angka.',
            'bayar.min'                  => 'Jumlah bayar minimal 0.',
            'obat_id.required'           => 'Minimal pilih satu obat.',
            'obat_id.min'                => 'Minimal pilih satu obat.',
        ]);

        // Validate stock availability
        $oldDetails = $transaksi->detailTransaksis->pluck('jumlah', 'obat_id')->toArray();
        foreach ($request->obat_id as $i => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlah = $request->jumlah[$i];
            $oldJumlah = $oldDetails[$obatId] ?? 0;
            if ($jumlah > ($obat->stok + $oldJumlah)) {
                return back()->withInput()->withErrors([
                    'jumlah.' . $i => "Stok obat {$obat->nama_obat} tidak mencukupi (Tersedia: " . ($obat->stok + $oldJumlah) . ")."
                ]);
            }
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok dari detail lama
            foreach ($transaksi->detailTransaksis as $detail) {
                $detail->obat->increment('stok', $detail->jumlah);
            }

            // Hapus detail lama
            $transaksi->detailTransaksis()->delete();

            // Hitung total baru
            $total = 0;
            foreach ($request->obat_id as $i => $obatId) {
                $obat   = Obat::findOrFail($obatId);
                $jumlah = $request->jumlah[$i];
                $total += $obat->harga_jual * $jumlah;
            }

            $bayar     = $request->bayar;
            $kembalian = $bayar - $total;

            // Update header
            $transaksi->update([
                'pelanggan_id'      => $request->pelanggan_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'total_harga'       => $total,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
            ]);

            // Simpan detail baru + kurangi stok
            foreach ($request->obat_id as $i => $obatId) {
                $obat   = Obat::findOrFail($obatId);
                $jumlah = $request->jumlah[$i];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id'      => $obatId,
                    'jumlah'       => $jumlah,
                    'harga'        => $obat->harga_jual,
                    'subtotal'     => $obat->harga_jual * $jumlah,
                ]);

                $obat->decrement('stok', $jumlah);
            }

            DB::commit();

            return redirect()->route('transaksi.show', $transaksi)
                ->with('success', 'Transaksi berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // DESTROY — hapus transaksi
    // ─────────────────────────────────────────
    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok
            foreach ($transaksi->detailTransaksis as $detail) {
                $detail->obat->increment('stok', $detail->jumlah);
            }

            $transaksi->detailTransaksis()->delete();
            $transaksi->delete();

            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi.');
        }
    }

    // ─────────────────────────────────────────
    // AJAX — ambil harga obat
    // ─────────────────────────────────────────
    public function getHargaObat($id)
    {
        $obat = Obat::findOrFail($id);
        return response()->json([
            'harga' => $obat->harga_jual,
            'stok'  => $obat->stok,
        ]);
    }
}
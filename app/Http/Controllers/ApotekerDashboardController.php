<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResepDokter;
use App\Models\Obat;

class ApotekerDashboardController extends Controller
{
    /**
     * Dashboard view for Apoteker.
     */
    public function index()
    {
        // Statistics
        $totalResep = ResepDokter::count();
        $pendingResepCount = ResepDokter::where('status', 'pending')->count();
        $totalObat = Obat::count();
        $lowStockObatCount = Obat::where('stok', '<=', 20)->count();

        // Data lists for quick preview
        $pendingReseps = ResepDokter::where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockObats = Obat::with(['kategori', 'supplier'])
            ->where('stok', '<=', 20)
            ->orderBy('stok')
            ->limit(5)
            ->get();

        return view('apoteker.dashboard', compact(
            'totalResep',
            'pendingResepCount',
            'totalObat',
            'lowStockObatCount',
            'pendingReseps',
            'lowStockObats'
        ));
    }

    /**
     * List all prescriptions.
     */
    public function resepIndex(Request $request)
    {
        $status = $request->get('status');
        $query = ResepDokter::latest();

        if ($status && in_array($status, ['pending', 'disetujui', 'ditolak'])) {
            $query->where('status', $status);
        }

        $reseps = $query->paginate(15);
        return view('apoteker.resep.index', compact('reseps', 'status'));
    }

    /**
     * View detailed prescription.
     */
    public function resepShow($id)
    {
        $resep = ResepDokter::findOrFail($id);
        return view('apoteker.resep.show', compact('resep'));
    }

    /**
     * Verify prescription (approve/reject).
     */
    public function resepVerify(Request $request, $id)
    {
        $resep = ResepDokter::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Tindakan persetujuan wajib dipilih.',
            'status.in' => 'Tindakan persetujuan tidak valid.',
            'catatan_verifikasi.max' => 'Catatan verifikasi maksimal 1000 karakter.',
        ]);

        $resep->update([
            'status' => $request->status,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        $statusText = $request->status === 'disetujui' ? 'disetujui' : 'ditolak';

        return redirect()->route('apoteker.resep.show', $resep->id)
            ->with('success', 'Resep dokter berhasil ' . $statusText);
    }

    /**
     * View medicines list, check stock, filter by low stock, search.
     */
    public function obatIndex(Request $request)
    {
        $search = $request->get('search');
        $stokRendah = $request->get('stok_rendah');

        $query = Obat::with(['kategori', 'supplier']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', '%' . $search . '%')
                  ->orWhere('kode_obat', 'like', '%' . $search . '%');
            });
        }

        if ($stokRendah == '1') {
            $query->where('stok', '<=', 20);
        }

        $obats = $query->orderBy('nama_obat')->paginate(15);

        return view('apoteker.obat.index', compact('obats', 'search', 'stokRendah'));
    }
}

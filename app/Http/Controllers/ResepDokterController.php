<?php

namespace App\Http\Controllers;

use App\Models\ResepDokter;
use App\Models\Obat;
use App\Services\ResepDokterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ResepDokterController extends Controller
{
    protected $resepService;

    public function __construct(ResepDokterService $resepService)
    {
        $this->resepService = $resepService;
    }

    /**
     * View customer upload prescription page.
     */
    public function create()
    {
        return view('marketplace.upload-resep');
    }

    /**
     * Handle customer prescription upload.
     */
    public function store(Request $request)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'foto_resep' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'foto_resep.required' => 'Foto resep wajib diunggah.',
            'foto_resep.image' => 'File harus berupa gambar.',
            'foto_resep.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_resep.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $user = auth()->user();
        
        $resep = $this->resepService->upload(
            $request->file('foto_resep'),
            $request->input('catatan'),
            $user
        );

        return redirect()->route('resep.index')->with(
            'success', 
            'Resep berhasil dikirim. Apoteker kami akan memverifikasi resep Anda terlebih dahulu.'
        );
    }

    /**
     * Display customer's prescription history ("Resep Saya").
     */
    public function index()
    {
        $reseps = ResepDokter::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('marketplace.resep-history', compact('reseps'));
    }

    /**
     * Display customer's detailed prescription & action interface.
     */
    public function show($id)
    {
        $resep = ResepDokter::with(['items.obat', 'items.obatPengganti'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('marketplace.resep-show', compact('resep'));
    }

    /**
     * Customer approves prescription items, loading them to active cart.
     */
    public function approve($id)
    {
        $resep = ResepDokter::where('user_id', auth()->id())->findOrFail($id);

        if ($resep->status !== 'menunggu_persetujuan') {
            return redirect()->back()->with('error', 'Resep ini tidak dalam status menunggu persetujuan.');
        }

        $this->resepService->approve($resep->id);

        return redirect()->route('cart.index')->with(
            'success', 
            'Obat resep berhasil disetujui dan dimasukkan ke keranjang belanja Anda!'
        );
    }

    /**
     * Customer submits revision request.
     */
    public function revise(Request $request, $id)
    {
        $resep = ResepDokter::where('user_id', auth()->id())->findOrFail($id);

        if ($resep->status !== 'menunggu_persetujuan') {
            return redirect()->back()->with('error', 'Resep ini tidak dalam status menunggu persetujuan.');
        }

        $request->validate([
            'catatan_revisi' => 'required|string|max:1000',
        ], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi.',
            'catatan_revisi.max' => 'Catatan revisi maksimal 1000 karakter.',
        ]);

        $this->resepService->requestRevision($resep->id, $request->input('catatan_revisi'));

        return redirect()->route('resep.show', $resep->id)->with(
            'success', 
            'Catatan revisi berhasil dikirim ke Apoteker. Kami akan memproses kembali resep Anda.'
        );
    }

    /**
     * Securely serve prescription image file to authorized users.
     */
    public function showFile($id)
    {
        $resep = ResepDokter::findOrFail($id);
        $user = auth()->user();

        // Security check: Staf (admin/apoteker) OR the owner customer
        if ($user->hasRole(['admin', 'apoteker']) || $user->id === $resep->user_id) {
            
            // Log audit pembacaan resep
            Log::info("Audit Resep: User {$user->name} (ID: {$user->id}) membuka file resep ID: {$resep->id}");

            $localPath = Str::after($resep->foto_resep, 'private/');
            if (!Storage::disk('local')->exists($localPath)) {
                abort(404, 'Berkas resep tidak ditemukan di penyimpanan server.');
            }

            return response()->file(Storage::disk('local')->path($localPath));
        }

        abort(403, 'Anda tidak memiliki akses ke berkas medis resep ini.');
    }

    /**
     * API endpoint to search medicines for processing prescription.
     */
    public function searchObat(Request $request)
    {
        $q = $request->get('q');
        
        $obats = Obat::where('nama_obat', 'like', "%{$q}%")
            ->orWhere('kode_obat', 'like', "%{$q}%")
            ->limit(15)
            ->get()
            ->map(function ($obat) {
                return [
                    'id' => $obat->id,
                    'nama_obat' => $obat->nama_obat,
                    'kode_obat' => $obat->kode_obat,
                    'stok' => $obat->stok,
                    'harga_jual' => (float) $obat->harga_jual,
                    'harga_formatted' => 'Rp ' . number_format($obat->harga_jual, 0, ',', '.'),
                ];
            });

        return response()->json($obats);
    }

    /**
     * Staf (Admin/Apoteker) form to process prescription.
     */
    public function prosesForm($id)
    {
        $resep = ResepDokter::with(['items.obat', 'items.obatPengganti'])->findOrFail($id);
        
        // Transisi status otomatis ke 'sedang_diproses' jika masih 'menunggu_verifikasi'
        if ($resep->status === 'menunggu_verifikasi') {
            $resep->status = 'sedang_diproses';
            $resep->save();
            
            Log::info("Audit Resep: Staf " . auth()->user()->name . " membuka dan memproses resep ID: " . $resep->id . ", status otomatis diubah ke 'sedang_diproses'");
        }

        // Map items to JSON to send to view, avoiding complex inline mapping in Blade
        $selectedObatsJson = json_encode($resep->items->map(function ($item) {
            return [
                'obat_id' => $item->obat_id,
                'nama_obat' => $item->obat->nama_obat ?? 'Obat',
                'kode_obat' => $item->obat->kode_obat ?? '',
                'stok' => $item->obat->stok ?? 0,
                'harga_jual' => (float) ($item->obat->harga_jual ?? 0),
                'harga_formatted' => 'Rp ' . number_format($item->obat->harga_jual ?? 0, 0, ',', '.'),
                'qty' => $item->qty,
                'status' => $item->status,
                'obat_pengganti_id' => $item->obat_pengganti_id,
                'obat_pengganti_nama' => $item->obatPengganti->nama_obat ?? null,
                'catatan' => $item->catatan,
                'penggantiSearch' => '',
                'penggantiResults' => []
            ];
        }));

        return view('admin.resep-dokter.proses', compact('resep', 'selectedObatsJson'));
    }

    /**
     * Submit processed prescription details.
     */
    public function prosesSubmit(Request $request, $id)
    {
        $resep = ResepDokter::findOrFail($id);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:obats,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.status' => 'required|in:tersedia,tidak_tersedia',
            'items.*.obat_pengganti_id' => 'nullable|exists:obats,id',
            'items.*.catatan' => 'nullable|string|max:500',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ], [
            'items.required' => 'Minimal harus memilih satu obat.',
            'items.min' => 'Minimal harus memilih satu obat.',
            'items.*.obat_id.exists' => 'Obat tidak terdaftar di database.',
            'items.*.qty.min' => 'Jumlah obat minimal 1.',
        ]);

        $this->resepService->process(
            $resep->id,
            $request->input('items'),
            $request->input('catatan_verifikasi')
        );

        // Redirect based on user role permission to stay consistent with original pathing
        $routeRedirect = auth()->user()->can('Kelola Pesanan Online') 
            ? 'admin.resep.index' 
            : 'apoteker.resep.index';

        return redirect()->route($routeRedirect)->with(
            'success', 
            'Penawaran obat resep berhasil disimpan dan dikirim ke pelanggan.'
        );
    }

    /**
     * Staf (Admin/Apoteker) rejects prescription.
     */
    public function prosesReject(Request $request, $id)
    {
        $resep = ResepDokter::findOrFail($id);

        $request->validate([
            'catatan_verifikasi' => 'required|string|max:1000',
        ], [
            'catatan_verifikasi.required' => 'Catatan verifikasi penolakan wajib diisi.',
        ]);

        $this->resepService->reject($resep->id, $request->input('catatan_verifikasi'));

        $routeRedirect = auth()->user()->can('Kelola Pesanan Online') 
            ? 'admin.resep.index' 
            : 'apoteker.resep.index';

        return redirect()->route($routeRedirect)->with(
            'success', 
            'Resep dokter berhasil ditolak dan status diperbarui.'
        );
    }
}

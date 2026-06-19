<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with(['kategori', 'supplier'])
            ->latest()
            ->get();

        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('obat.create', compact(
            'kategoris',
            'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|unique:obats,kode_obat',
            'nama_obat' => 'required',
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'stok' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:1',
            'tanggal_kadaluarsa' => 'nullable|date',
            'deskripsi' => 'nullable'
        ], [
            'kode_obat.required' => 'Kode obat wajib diisi.',
            'kode_obat.unique' => 'Kode obat sudah digunakan.',

            'nama_obat.required' => 'Nama obat wajib diisi.',

            'kategori_id.required' => 'Kategori wajib dipilih.',

            'supplier_id.required' => 'Supplier wajib dipilih.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 1.',

            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual minimal 1.',
        ]);

        Obat::create($request->all());

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit(Obat $obat)
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('obat.edit', compact(
            'obat',
            'kategoris',
            'suppliers'
        ));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'stok' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:1',
            'tanggal_kadaluarsa' => 'nullable|date',
            'deskripsi' => 'nullable'
        ], [
            'kode_obat.required' => 'Kode obat wajib diisi.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 1.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual minimal 1.'
        ]);

        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'harga_jual' => $request->harga_jual,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil diubah');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()
            ->route('obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}

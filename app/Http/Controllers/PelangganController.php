<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggan.index', [
            'pelanggan' => $pelanggans
        ]);
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp'          => 'required|string|max:15',
            'alamat'         => 'required|string',
            'role'           => 'required|in:Admin,Kasir,Pelanggan',
        ], [
            'nama_pelanggan.required' => 'Nama pengguna wajib diisi.',
            'no_hp.required'          => 'Nomor handphone wajib diisi.',
            'alamat.required'         => 'Alamat wajib diisi.',
            'role.required'           => 'Role wajib dipilih.',
            'role.in'                 => 'Role yang dipilih tidak valid.',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'role'           => $request->role,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp'          => 'required|string|max:15',
            'alamat'         => 'required|string',
            'role'           => 'required|in:Admin,Kasir,Pelanggan',
        ], [
            'nama_pelanggan.required' => 'Nama pengguna wajib diisi.',
            'no_hp.required'          => 'Nomor handphone wajib diisi.',
            'alamat.required'         => 'Alamat wajib diisi.',
            'role.required'           => 'Role wajib dipilih.',
            'role.in'                 => 'Role yang dipilih tidak valid.',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'role'           => $request->role,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.show', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data pengguna berhasil dihapus!');
    }
}

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
            'role'           => 'required|in:Admin,Kasir,Pelanggan', // << PASTIKAN HURUF BESAR
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'role'           => $request->role, // << KODE INI YANG MENYIMPAN ROLE BARU
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    // 1. FUNGSI UNTUK MENAMPILKAN HALAMAN EDIT (Ini yang hilang)
    public function edit($id)
    {
        // Cari data pelanggan berdasarkan ID, jika tidak ketemu langsung munculkan error 404
        $pelanggan = Pelanggan::findOrFail($id);

        // Buka file edit.blade.php sambil membawa data pelanggan tersebut
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // 2. FUNGSI UNTUK MENYIMPAN PERUBAHAN (Fungsi update Anda yang sudah ada)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp'          => 'required|string|max:15',
            'alamat'         => 'required|string',
            'role'           => 'required|in:Admin,Kasir,Pelanggan',
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

    public function destroy($id)
    {
        // 1. Cari data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // 2. Hapus data dari database
        $pelanggan->delete();

        // 3. Alihkan kembali ke halaman indeks dengan membawa pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data pengguna berhasil dihapus!');
    }
}

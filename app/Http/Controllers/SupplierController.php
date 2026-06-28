<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query->where('nama_supplier', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('telepon', 'like', "%{$search}%")
                         ->orWhere('alamat', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'kontak_pic'    => 'nullable|string|max:255',
            'kota'          => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier ini sudah terdaftar.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'telepon.required'       => 'Telepon wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        $data = $request->all();
        $data['status'] = 'Lengkap';

        Supplier::create($data);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    /**
     * Store a newly created supplier via AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'kontak_pic'    => 'nullable|string|max:255',
            'kota'          => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier ini sudah terdaftar.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        if (!empty($data['alamat']) && !empty($data['telepon']) && !empty($data['email'])) {
            $data['status'] = 'Lengkap';
        } else {
            $data['status'] = 'Belum Lengkap';
        }

        $supplier = Supplier::create($data);

        return response()->json([
            'success' => true,
            'data' => $supplier
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier,' . $supplier->id,
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'kontak_pic'    => 'nullable|string|max:255',
            'kota'          => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier ini sudah terdaftar.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'telepon.required'       => 'Telepon wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        $data = $request->all();
        $data['status'] = 'Lengkap';

        $supplier->update($data);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('name', 'asc')->get();
        return view('payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bank_transfer,qris,e_wallet',
            'name' => 'required|string|max:255',
            'account_number' => 'required_if:type,bank_transfer|required_if:type,e_wallet|nullable|string|max:255',
            'account_owner' => 'required_if:type,bank_transfer|required_if:type,e_wallet|nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ], [
            'type.required' => 'Tipe metode pembayaran wajib dipilih.',
            'name.required' => 'Nama metode pembayaran wajib diisi.',
            'account_number.required_if' => 'Nomor rekening/nomor e-wallet wajib diisi.',
            'account_owner.required_if' => 'Nama pemilik rekening/nama pemilik e-wallet wajib diisi.',
            'image.image' => 'Berkas harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('payment-logos', 'public');
        }

        PaymentMethod::create([
            'type' => $request->type,
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_owner' => $request->account_owner,
            'image_path' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $request->validate([
            'type' => 'required|in:bank_transfer,qris,e_wallet',
            'name' => 'required|string|max:255',
            'account_number' => 'required_if:type,bank_transfer|required_if:type,e_wallet|nullable|string|max:255',
            'account_owner' => 'required_if:type,bank_transfer|required_if:type,e_wallet|nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
        ], [
            'type.required' => 'Tipe metode pembayaran wajib dipilih.',
            'name.required' => 'Nama metode pembayaran wajib diisi.',
            'account_number.required_if' => 'Nomor rekening/nomor e-wallet wajib diisi.',
            'account_owner.required_if' => 'Nama pemilik rekening/nama pemilik e-wallet wajib diisi.',
            'image.image' => 'Berkas harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        ]);

        $imagePath = $paymentMethod->image_path;
        if ($request->hasFile('image')) {
            if ($paymentMethod->image_path) {
                Storage::disk('public')->delete($paymentMethod->image_path);
            }
            $imagePath = $request->file('image')->store('payment-logos', 'public');
        }

        $paymentMethod->update([
            'type' => $request->type,
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_owner' => $request->account_owner,
            'image_path' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        if ($paymentMethod->image_path) {
            Storage::disk('public')->delete($paymentMethod->image_path);
        }
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}

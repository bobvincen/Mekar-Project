<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    /**
     * Display a listing of customer users (role: pelanggan).
     */
    public function index()
    {
        // Query users table, filtering for role: pelanggan
        $customers = User::role('pelanggan')->latest()->get();

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'whatsapp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'whatsapp.min' => 'Nomor WhatsApp minimal 10 digit.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        $customer->phone_verified_at = now();
        $customer->save();

        // Sync with Spatie Permission roles
        $customer->assignRole('pelanggan');

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('customer.index')->with('success', 'Customer berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit($id)
    {
        $customer = User::role('pelanggan')->findOrFail($id);

        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = User::role('pelanggan')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $id],
            'whatsapp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'whatsapp.min' => 'Nomor WhatsApp minimal 10 digit.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customerData = [
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
        ];

        if ($request->filled('password')) {
            $customerData['password'] = Hash::make($request->password);
        }

        $customer->update($customerData);

        return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = User::role('pelanggan')->findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus');
    }
}

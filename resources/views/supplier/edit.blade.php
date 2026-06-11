@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg p-6 md:p-8">

    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('supplier.index') }}" class="p-2.5 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Edit Data Supplier
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Ubah informasi detail untuk supplier "{{ $supplier->nama_supplier }}"
            </p>
        </div>
    </div>

    <!-- Error Alert Block -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-bold text-red-800">Terdapat kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Supplier -->
        <div>
            <label for="nama_supplier" class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Supplier <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="nama_supplier" 
                id="nama_supplier" 
                value="{{ old('nama_supplier', $supplier->nama_supplier) }}" 
                placeholder="Masukkan nama supplier / perusahaan" 
                class="w-full border @error('nama_supplier') border-red-400 focus:ring-red-300 @else border-gray-300 focus:ring-blue-300 @enderror rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150"
                required
            >
            @error('nama_supplier')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Telepon -->
        <div>
            <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                Nomor Telepon <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="telepon" 
                id="telepon" 
                value="{{ old('telepon', $supplier->telepon) }}" 
                placeholder="Masukkan nomor telepon aktif (contoh: 08123456789)" 
                class="w-full border @error('telepon') border-red-400 focus:ring-red-300 @else border-gray-300 focus:ring-blue-300 @enderror rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150"
                required
            >
            @error('telepon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Alamat Email <span class="text-red-500">*</span>
            </label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email', $supplier->email) }}" 
                placeholder="Masukkan alamat email (contoh: supplier@email.com)" 
                class="w-full border @error('email') border-red-400 focus:ring-red-300 @else border-gray-300 focus:ring-blue-300 @enderror rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150"
                required
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea 
                name="alamat" 
                id="alamat" 
                rows="4" 
                placeholder="Masukkan alamat lengkap kantor / gudang supplier" 
                class="w-full border @error('alamat') border-red-400 focus:ring-red-300 @else border-gray-300 focus:ring-blue-300 @enderror rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150"
                required
            >{{ old('alamat', $supplier->alamat) }}</textarea>
            @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <!-- Back Button -->
            <a 
                href="{{ route('supplier.index') }}" 
                class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-center transition-colors duration-150"
            >
                Kembali
            </a>

            <!-- Update Button (blue / primary) -->
            <button 
                type="submit" 
                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-150"
            >
                Update Supplier
            </button>
        </div>

    </form>
</div>
@endsection

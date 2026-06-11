@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="bg-white rounded-3xl shadow-lg p-6 md:p-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">
                Data Supplier
            </h1>
            <p class="text-gray-500 mt-1">
                Kelola informasi supplier dan distributor Mekar Pharmacy
            </p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('supplier.index') }}" method="GET" class="w-full md:w-96">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari supplier..." 
                        class="w-full pl-12 pr-10 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    >
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('supplier.index') }}" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Add Button -->
            <a href="{{ route('supplier.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 font-semibold shadow-md hover:shadow-lg transition-all duration-200 whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Supplier
            </a>
        </div>
    </div>

    <!-- Toast Notification -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                    <th class="py-4 px-6 text-center w-16">No</th>
                    <th class="py-4 px-6">Nama Supplier</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6">Telepon</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="py-4 px-6 text-center font-medium text-gray-500">
                            {{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-4 px-6 font-semibold text-gray-900">
                            {{ $supplier->nama_supplier }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 max-w-xs truncate">
                            {{ $supplier->alamat }}
                        </td>
                        <td class="py-4 px-6 font-mono text-gray-600">
                            {{ $supplier->telepon }}
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            {{ $supplier->email }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex justify-center gap-2">
                                <!-- Edit Button (blue / primary styling style) -->
                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3.5 py-2 rounded-xl flex items-center gap-1 font-medium transition-all duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-500 font-medium bg-gray-50/30">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
                                </svg>
                                @if(request('search'))
                                    <span>Tidak ada supplier yang cocok dengan kata kunci "{{ request('search') }}"</span>
                                @else
                                    <span>Belum ada data supplier. Silakan tambahkan supplier baru.</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($suppliers->hasPages())
        <div class="mt-8">
            {{ $suppliers->links() }}
        </div>
    @endif

</div>
@endsection

@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-2xl font-bold">
                Data Kategori
            </h1>

            <p class="text-gray-500">
                Kelola kategori obat
            </p>

        </div>

        <button
            onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            + Tambah Kategori

        </button>

    </div>

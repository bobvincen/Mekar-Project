@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Kategori
    </h1>

    <form action="{{ route('kategori.update', $kategori->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <input
            type="text"
            name="nama_kategori"
            value="{{ $kategori->nama_kategori }}"
            class="w-full border rounded-xl px-4 py-3 mb-4">

        <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-3 rounded-xl">

            Update

        </button>

    </form>

</div>

@endsection

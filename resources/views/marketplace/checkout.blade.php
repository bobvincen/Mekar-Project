@extends('marketplace.layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@php
    $cartItems = $cartItems ?? [];
    $subtotal  = $subtotal ?? 0;
    $ongkir    = $ongkir ?? 0;
    $diskon    = $diskon ?? 0;
    $total     = $total ?? 0;

    $formatRp = fn(int $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" x-data="checkoutPage()">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-1">
            <a href="/cart" class="text-slate-400 hover:text-blue-600 transition-colors text-sm font-light">Keranjang</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-blue-600 text-sm font-medium">Checkout</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Checkout Pesanan</h1>
        <p class="text-sm text-slate-400 font-light mt-1">Lengkapi data Anda untuk menyelesaikan pemesanan</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- =================== LEFT COLUMN (70%) =================== --}}
        <div class="w-full lg:w-[70%] flex flex-col gap-6">

            {{-- SECTION 1 - INFORMASI PELANGGAN --}}
            <div class="bg-white border border-slate-100 rounded-3xl shadow-md p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-50 pb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Informasi Pemesan
                </h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.nama" placeholder="Masukkan nama lengkap Anda" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all text-slate-800 placeholder-slate-400 bg-slate-50 focus:bg-white" :class="{'border-red-400 ring-1 ring-red-300': errors.nama}">
                        <p x-show="errors.nama" class="text-red-500 text-xs mt-1 font-medium">Nama lengkap wajib diisi</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel" x-model="form.whatsapp" placeholder="Contoh: 081234567890" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all text-slate-800 placeholder-slate-400 bg-slate-50 focus:bg-white" :class="{'border-red-400 ring-1 ring-red-300': errors.whatsapp}">
                        <p x-show="errors.whatsapp" class="text-red-500 text-xs mt-1 font-medium">Nomor WhatsApp wajib diisi</p>
                    </div>
                </div>
            </div>

            {{-- SECTION 4 - METODE PENGAMBILAN --}}
            <div class="bg-white border border-slate-100 rounded-3xl shadow-md p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-50 pb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Metode Pengambilan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <label class="relative flex cursor-pointer rounded-2xl border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200" :class="form.metode === 'Ambil di Apotek' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/30' : 'border-slate-200 hover:border-blue-200'">
                        <input type="radio" x-model="form.metode" name="metode" value="Ambil di Apotek" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-semibold text-slate-900">Ambil di Apotek</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500 font-light">Tidak ada biaya ongkir</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="form.metode === 'Ambil di Apotek' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>

                    <label class="relative flex cursor-pointer rounded-2xl border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200" :class="form.metode === 'Antar ke Alamat' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/30' : 'border-slate-200 hover:border-blue-200'">
                        <input type="radio" x-model="form.metode" name="metode" value="Antar ke Alamat" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-semibold text-slate-900">Antar ke Alamat</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500 font-light">Pilih di peta</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="form.metode === 'Antar ke Alamat' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>

                    <label class="relative flex cursor-pointer rounded-2xl border bg-white p-4 shadow-sm focus:outline-none transition-all duration-200" :class="form.metode === 'Gunakan Lokasi Saya Saat Ini' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/30' : 'border-slate-200 hover:border-blue-200'">
                        <input type="radio" x-model="form.metode" name="metode" value="Gunakan Lokasi Saya Saat Ini" class="sr-only">
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-semibold text-slate-900">Lokasi Saat Ini</span>
                                <span class="mt-1 flex items-center text-xs text-slate-500 font-light">Gunakan GPS</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600" :class="form.metode === 'Gunakan Lokasi Saya Saat Ini' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </label>
                </div>

                <div x-show="form.metode === 'Antar ke Alamat'" x-collapse class="mb-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Lokasi Pengiriman <span class="text-red-500">*</span></label>
                        <p class="text-xs text-slate-500 mb-3 font-light">Geser pin atau klik pada peta untuk menentukan lokasi akurat pengiriman.</p>
                        <div id="map" class="h-64 sm:h-80 w-full rounded-2xl z-0 border border-slate-200 shadow-sm relative z-[1]"></div>
                        <p x-show="errors.location" class="text-red-500 text-xs mt-1.5 font-medium">Lokasi pada peta wajib dipilih</p>
                        
                        <div class="mt-2.5 text-xs font-medium text-slate-500 flex flex-wrap gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100" x-show="form.lat && form.lng">
                            <span>Lat: <span x-text="form.lat" class="text-slate-800"></span></span>
                            <span>Lng: <span x-text="form.lng" class="text-slate-800"></span></span>
                            <span x-show="jarak > 0">Jarak: <span x-text="jarak.toFixed(2) + ' KM'" class="text-blue-600 font-bold"></span></span>
                            <span x-show="jarak > 0">Perkiraan Ongkir: <span x-text="formatRp(ongkir)" class="text-blue-600 font-bold"></span></span>
                        </div>
                    </div>
                </div>

                <div x-show="form.metode === 'Gunakan Lokasi Saya Saat Ini'" x-collapse class="mb-6 space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-700 mb-1.5" x-text="form.lat ? '📍 Lokasi Saat Ini Berhasil Ditemukan' : 'Mencari lokasi...' "></h3>
                        <p x-show="!form.lat" class="text-xs text-slate-500 animate-pulse">Mohon izinkan akses lokasi pada browser Anda.</p>
                        <div class="mt-2.5 text-xs font-medium text-slate-500 flex flex-wrap gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100" x-show="form.lat && form.lng">
                            <span>Lat: <span x-text="form.lat" class="text-slate-800"></span></span>
                            <span>Lng: <span x-text="form.lng" class="text-slate-800"></span></span>
                            <span x-show="jarak > 0">Jarak: <span x-text="jarak.toFixed(2) + ' KM'" class="text-blue-600 font-bold"></span></span>
                            <span x-show="jarak > 0">Perkiraan Ongkir: <span x-text="formatRp(ongkir)" class="text-blue-600 font-bold"></span></span>
                        </div>
                    </div>
                </div>

                <div x-show="form.metode === 'Antar ke Alamat' || form.metode === 'Gunakan Lokasi Saya Saat Ini'" x-collapse class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea x-model="form.alamat" rows="3" placeholder="Masukkan alamat pengiriman secara detail (Jalan, RT/RW, Patokan)" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all text-slate-800 placeholder-slate-400 bg-slate-50 focus:bg-white" :class="{'border-red-400 ring-1 ring-red-300': errors.alamat}"></textarea>
                    <p x-show="errors.alamat" class="text-red-500 text-xs mt-1 font-medium">Alamat lengkap wajib diisi untuk pengiriman</p>
                </div>

                <div class="mt-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan Pesanan (Opsional)</label>
                    <textarea x-model="form.catatan" rows="2" placeholder="Contoh: Titip di pos satpam" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all text-slate-800 placeholder-slate-400 bg-slate-50 focus:bg-white"></textarea>
                </div>
            </div>

            {{-- SECTION 2 - RINGKASAN PESANAN --}}
            <div class="bg-white border border-slate-100 rounded-3xl shadow-md p-6 sm:p-8 mb-4">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-50 pb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    Detail Pesanan
                </h2>

                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex gap-3">
                            <div class="shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-blue-50/30 rounded-xl flex items-center justify-center overflow-hidden border border-slate-100">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900 leading-snug line-clamp-2">{{ $item['name'] }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $formatRp($item['price']) }} &times; {{ $item['qty'] }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0 pt-1">
                            <p class="text-sm font-bold text-slate-900">{{ $formatRp($item['price'] * $item['qty']) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
        {{-- END LEFT COLUMN --}}

        {{-- =================== RIGHT COLUMN (30%) =================== --}}
        <div class="w-full lg:w-[30%] lg:sticky lg:top-24 flex flex-col gap-6">

            {{-- SECTION 3 - RINGKASAN PEMBAYARAN --}}
            <div class="bg-white border border-slate-100 rounded-3xl shadow-md p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5 pb-4 border-b border-slate-50">
                    Ringkasan Pembayaran
                </h3>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 font-light">Subtotal</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $formatRp($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 font-light">Perkiraan Ongkir</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="form.metode === 'Ambil di Apotek' ? 'Rp 0' : formatRp(ongkir)"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 font-light">Diskon</span>
                        <span class="text-sm font-semibold text-red-500">− {{ $formatRp($diskon) }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-900">Total</span>
                        <span class="text-xl font-bold text-blue-600" x-text="formatRp(total)"></span>
                    </div>
                </div>

                {{-- SECTION 5 - TOMBOL KONFIRMASI --}}
                <button
                    @click="submitOrder()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-4 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2 group"
                >
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0c-6.627 0-12 5.373-12 12 0 2.126.553 4.135 1.547 5.904l-1.547 5.666 5.81-1.524c1.728.938 3.69 1.454 5.75 1.454 6.627 0 12-5.373 12-12s-5.373-12-12-12zm0 21.905c-1.848 0-3.615-.477-5.203-1.385l-.373-.213-3.414.896.91-3.327-.234-.383c-1.004-1.64-1.531-3.535-1.531-5.493 0-5.464 4.442-9.905 9.905-9.905 5.464 0 9.906 4.441 9.906 9.905 0 5.463-4.442 9.905-9.905 9.905z"/>
                    </svg>
                    Konfirmasi via WhatsApp
                </button>
            </div>

            {{-- SECURITY BADGES --}}
            <div class="flex items-center justify-center gap-4 border-t border-slate-100 pt-4">
                <div class="flex items-center gap-1 text-slate-400">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    <span class="text-xs font-medium">Pembayaran Aman</span>
                </div>
            </div>

        </div>
        {{-- END RIGHT COLUMN --}}

    </div>

</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function checkoutPage() {
    return {
        form: {
            nama: '',
            whatsapp: '',
            alamat: '',
            lat: '',
            lng: '',
            catatan: '',
            metode: 'Ambil di Apotek'
        },
        errors: {
            nama: false,
            whatsapp: false,
            alamat: false,
            location: false
        },
        map: null,
        marker: null,
        apotekLat: -0.9493, // Koordinat Mekar Pharmacy akurat
        apotekLng: 100.3745, // Koordinat Mekar Pharmacy akurat
        jarak: 0,
        distanceKm: 0,
        total: {{ $total }},

        init() {
            this.total = this.calculateTotal();

            this.$watch('ongkir', () => {
                this.total = this.calculateTotal();
            });

            this.$watch('distanceKm', () => {
                this.total = this.calculateTotal();
            });

            this.$watch('form.metode', (val) => {
                if (val === 'Ambil di Apotek') {
                    this.jarak = 0;
                    this.distanceKm = 0;
                    this.ongkir = 0;
                    this.total = this.calculateTotal();
                } else if (val === 'Antar ke Alamat') {
                    setTimeout(() => {
                        this.initMap();
                    }, 300);
                    if (this.form.lat && this.form.lng) {
                        this.updateLocation(this.form.lat, this.form.lng);
                    }
                } else if (val === 'Gunakan Lokasi Saya Saat Ini') {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.updateLocation(position.coords.latitude, position.coords.longitude);
                            },
                            (error) => {
                                alert("Lokasi tidak dapat diakses. Silakan pilih lokasi secara manual pada peta.");
                                this.form.metode = 'Antar ke Alamat';
                            }
                        );
                    } else {
                        alert("Geolocation tidak didukung oleh browser ini.");
                        this.form.metode = 'Antar ke Alamat';
                    }
                }
            });
        },

        initMap() {
            if (this.map) {
                this.map.invalidateSize();
                return;
            }
            
            // Center to Padang (Mekar Pharmacy)
            let defaultLat = this.apotekLat;
            let defaultLng = this.apotekLng;

            this.map = L.map('map').setView([defaultLat, defaultLng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            // Marker Apotek
            L.marker([this.apotekLat, this.apotekLng], {
                title: "Mekar Pharmacy"
            }).addTo(this.map).bindPopup("<div class='text-center'><b class='text-blue-600 font-bold'>Mekar Pharmacy</b><br/><span class='text-xs text-slate-500'>Lokasi Apotek</span></div>").openPopup();

            // Marker Pembeli
            // Tempatkan sedikit bergeser agar tidak menumpuk dengan marker apotek
            this.marker = L.marker([defaultLat - 0.005, defaultLng + 0.005], {draggable: true}).addTo(this.map);

            this.marker.on('dragend', (e) => {
                let position = this.marker.getLatLng();
                this.updateLocation(position.lat, position.lng);
            });

            this.map.on('click', (e) => {
                this.marker.setLatLng(e.latlng);
                this.updateLocation(e.latlng.lat, e.latlng.lng);
            });
            
            setTimeout(() => { this.map.invalidateSize(); }, 100);
        },

        updateLocation(lat, lng) {
            this.form.lat = lat;
            this.form.lng = lng;
            this.errors.location = false;
            
            // Reverse Geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if(data && data.display_name) {
                        this.form.alamat = data.display_name;
                    }
                }).catch(err => console.error(err));

            // Haversine Distance Calculation
            let distanceKm = this.calculateDistance(this.apotekLat, this.apotekLng, lat, lng);
            this.distanceKm = distanceKm;
            this.jarak = distanceKm;

            // Rumus ongkir dinamis
            let hitungOngkir = 10000 + (distanceKm * 2500);
            let calculatedOngkir = Math.round(hitungOngkir / 500) * 500;
            if (calculatedOngkir < 10000) {
                calculatedOngkir = 10000;
            }
            
            this.ongkir = calculatedOngkir;
            this.total = this.calculateTotal();
        },

        calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius bumi dalam KM
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        },
        cartItems: @json(array_values($cartItems)),
        subtotal: {{ $subtotal }},
        ongkir: {{ $ongkir }},
        diskon: {{ $diskon }},
        adminPhone: '6282240432990',

        calculateTotal() {
            let currentOngkir = this.form.metode === 'Ambil di Apotek' ? 0 : this.ongkir;
            return Math.max(0, this.subtotal + currentOngkir - this.diskon);
        },

        formatRp(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        },

        validate() {
            let valid = true;
            this.errors = { nama: false, whatsapp: false, alamat: false, location: false };

            if (!this.form.nama.trim()) {
                this.errors.nama = true;
                valid = false;
            }
            if (!this.form.whatsapp.trim()) {
                this.errors.whatsapp = true;
                valid = false;
            }
            if (this.form.metode === 'Antar ke Alamat' || this.form.metode === 'Gunakan Lokasi Saya Saat Ini') {
                if (!this.form.alamat.trim()) {
                    this.errors.alamat = true;
                    valid = false;
                }
                if (!this.form.lat || !this.form.lng) {
                    this.errors.location = true;
                    valid = false;
                }
            }

            if(!valid) {
                // Scroll to top
                window.scrollTo({top: 0, behavior: 'smooth'});
            }

            return valid;
        },

        submitOrder() {
            if (!this.validate()) return;

            let currentOngkir = this.form.metode === 'Ambil di Apotek' ? 0 : this.ongkir;
            let total = this.calculateTotal();

            let message = `Halo Admin Mekar Pharmacy 👋\n\nSaya ingin melakukan pemesanan obat.\n\n`;
            message += `📌 *Informasi Pemesan*\n\n`;
            message += `Nama:\n${this.form.nama}\n\n`;
            message += `No WhatsApp:\n${this.form.whatsapp}\n\n`;
            
            message += `🚚 *Metode Pengambilan:*\n${this.form.metode}\n\n`;

            if (this.form.metode === 'Gunakan Lokasi Saya Saat Ini') {
                message += `📍 *Lokasi Pelanggan (GPS)*\n\n`;
                message += `Alamat:\n${this.form.alamat}\n\n`;
                message += `Jarak:\n${this.jarak.toFixed(2)} KM\n\n`;
                message += `Perkiraan Ongkir:\n${this.formatRp(currentOngkir)}\n\n`;
                message += `Koordinat:\n${this.form.lat}, ${this.form.lng}\n\n`;
                message += `Link Maps:\nhttps://maps.google.com/?q=${this.form.lat},${this.form.lng}\n\n`;
            } else if (this.form.metode === 'Antar ke Alamat') {
                message += `📍 *Lokasi Pengiriman*\n\n`;
                message += `Alamat:\n${this.form.alamat}\n\n`;
                message += `Jarak:\n${this.jarak.toFixed(2)} KM\n\n`;
                message += `Perkiraan Ongkir:\n${this.formatRp(currentOngkir)}\n\n`;
                message += `Koordinat:\n${this.form.lat}, ${this.form.lng}\n\n`;
                message += `Link Maps:\nhttps://maps.google.com/?q=${this.form.lat},${this.form.lng}\n\n`;
            } else {
                message += `📍 *Lokasi Pengambilan*\n\n`;
                message += `Alamat:\n(Ambil di Apotek)\n\n`;
            }
            message += `🛒 *Detail Pesanan*\n\n`;

            this.cartItems.forEach(item => {
                message += `- ${item.name} x${item.qty} = ${this.formatRp(item.price * item.qty)}\n`;
            });

            message += `\n💰 *Ringkasan Pembayaran*\n\n`;
            message += `Subtotal:\n${this.formatRp(this.subtotal)}\n\n`;
            message += `Ongkir:\n${this.formatRp(currentOngkir)}\n\n`;
            
            if(this.diskon > 0) {
                message += `Diskon:\n- ${this.formatRp(this.diskon)}\n\n`;
            }

            message += `*Total:*\n*${this.formatRp(total)}*\n\n`;

            if (this.form.catatan.trim()) {
                message += `📝 *Catatan:*\n${this.form.catatan}\n\n`;
            }

            message += `Mohon konfirmasi pesanan saya.\n\nTerima kasih 🙏`;

            let url = `https://wa.me/${this.adminPhone}?text=${encodeURIComponent(message)}`;
            
            // Redirect to whatsapp
            window.location.href = url;
        }
    }
}
</script>
@endpush

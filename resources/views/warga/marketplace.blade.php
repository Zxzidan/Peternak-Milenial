{{--
    DOKUMENTASI KODE TAMPILAN: MARKETPLACE PRODUK TERNAK BAGI WARGA
    File: resources/views/warga/marketplace.blade.php
    Deskripsi: Antarmuka katalog belanja produk komoditas peternakan Jawa Timur untuk masyarakat umum.
               Mendukung pencarian kata kunci, filter kategori komoditas, filter asal kabupaten/kota,
               inspeksi sertifikasi ASUH & NKV, dan pemesanan online langsung ke peternak.
--}}

@extends('layouts.app')

@section('title', 'Katalog Belanja Ternak Warga — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-2 pb-10">

    <!-- 1. HEADER PENCARIAN & IDENTITAS PASAR -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Marketplace Produk Peternakan Jawa Timur
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                Belanja susu segar, telur asin asap masir, daging sapi higienis berstandar NKV, dan olahan ternak langsung dari peternak binaan dengan jaminan kualitas dinas.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Standar Mutu ASUH</span>
            </span>
            <a href="{{ route('pesanan') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl bg-primary-700 hover:bg-primary-800 text-white transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <span>Pesanan Saya</span>
            </a>
        </div>
    </div>

    <!-- 2. FORM FILTER & PENCARIAN WARGA -->
    <form method="GET" action="{{ route('marketplace') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Bar -->
            <div class="sm:col-span-6 relative">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari susu pasteurisasi, telur bebek, daging sapi..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 transition"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>

            <!-- Filter Kategori -->
            <div class="sm:col-span-3">
                <select name="category" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Wilayah Asal -->
            <div class="sm:col-span-3">
                <select name="region" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white transition">
                    <option value="">Semua Wilayah Jatim</option>
                    @foreach($regions ?? [] as $reg)
                        <option value="{{ $reg->code }}" {{ request('region') === $reg->code ? 'selected' : '' }}>
                            {{ $reg->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-1 text-xs">
            <span class="text-slate-500">
                Menampilkan produk terkurasi bebas bahan berbahaya dan berizin edar.
            </span>
            <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-xl transition shadow-2xs">
                Terapkan Filter
            </button>
        </div>
    </form>

    <!-- 3. GRID KATALOG PRODUK UNTUK WARGA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($products ?? [] as $p)
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-2xs hover:shadow-md hover:border-primary-400 transition flex flex-col justify-between group">
            <div>
                <!-- Gambar Produk & Badges -->
                <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                    @if($p->image_path)
                        <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">
                            Foto Produk Ternak
                        </div>
                    @endif

                    <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-1 z-10 pointer-events-none">
                        <span class="bg-black/60 backdrop-blur-xs text-white text-[10px] font-semibold px-2 py-0.5 rounded-md border border-white/20">
                            📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $p->region?->name ?? 'Jatim') }}
                        </span>
                        @if($p->is_verified)
                            <span class="bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Terverifikasi
                            </span>
                        @endif
                    </div>

                    <div class="absolute bottom-2.5 left-2.5 z-10 pointer-events-none">
                        <span class="bg-primary-900/80 backdrop-blur-xs text-white text-[10px] font-medium px-2 py-0.5 rounded-md">
                            {{ $p->category?->name ?? 'Produk Ternak' }}
                        </span>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="p-4">
                    <h3 class="font-bold text-slate-900 text-sm group-hover:text-primary-700 transition line-clamp-2" title="{{ $p->name }}">
                        {{ $p->name }}
                    </h3>

                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                        {{ $p->description }}
                    </p>

                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Peternak: <strong class="text-slate-700">{{ $p->seller?->name ?? 'Peternak Lokal' }}</strong></span>
                        <span>Stok: <strong class="text-slate-800">{{ $p->stock }} {{ $p->unit }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Baris Harga & Aksi Beli -->
            <div class="p-4 pt-0">
                <div class="flex items-center justify-between gap-2 pt-3 border-t border-slate-100">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Harga / {{ $p->unit }}</span>
                        <span class="font-extrabold text-primary-700 text-base tabular-nums">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Tombol Beli / Checkout -->
                    <button
                        type="button"
                        onclick="openBuyModal({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->price }}, '{{ $p->unit }}', {{ $p->stock }})"
                        class="px-3.5 py-2 bg-primary-700 hover:bg-primary-800 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer"
                    >
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
            <p class="text-sm font-semibold text-slate-700">Tidak ada produk yang cocok dengan pencarian.</p>
            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau reset filter kategori.</p>
        </div>
        @endforelse
    </div>

</div>

<!-- SCRIPT UNTUK MODAL CHECKOUT PRODUK WARGA -->
<script>
function openBuyModal(productId, productName, price, unit, stock) {
    if (typeof window.showCheckoutDialog === 'function') {
        window.showCheckoutDialog({ productId, productName, price, unit, stock });
    } else {
        window.location.href = "{{ route('marketplace') }}";
    }
}
</script>
@endsection


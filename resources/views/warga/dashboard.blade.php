{{--
    DOKUMENTASI KODE TAMPILAN: DASHBOARD WARGA / MASYARAKAT UMUM
    File: resources/views/warga/dashboard.blade.php
    Deskripsi: Tampilan Beranda Warga yang berfokus pada portal belanja pangan asal hewan (Shopee-Style),
               metrik pesanan berjalan, rekomendasi produk peternak terverifikasi, dan pantauan harga pasar.
--}}

@extends('layouts.app')

@section('title', 'Portal Warga & Belanja Ternak — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-8 pt-2 pb-8">

    <!-- 1. HERO PROMO BANNER (SHOPPER STYLE) -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-amber-600 to-emerald-700 text-white shadow-md p-6 sm:p-8">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 mb-2">
                    Portal Belanja Ternak Jatim
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-white leading-tight">
                    Selamat Datang, {{ auth()->user()->name ?? 'Warga Jawa Timur' }}!
                </h2>
                <p class="text-xs sm:text-sm text-orange-50/90 mt-1.5 leading-relaxed">
                    Beli langsung produk susu segar pasteurisasi, telur bebek berminyak masir, daging wagyu higienis, dan madu murni dari peternak milenial binaan Dinas Peternakan Provinsi Jawa Timur.
                </p>
                <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/20 text-xs">
                    <div class="flex items-center gap-1.5 font-semibold">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Standar Mutu ASUH</span>
                    </div>
                    <div class="flex items-center gap-1.5 font-semibold">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Rantai Dingin (Cold Chain)</span>
                    </div>
                    <div class="flex items-center gap-1.5 font-semibold">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Langsung dari Peternak</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row md:flex-col gap-2.5 shrink-0">
                <a href="{{ route('marketplace') }}" class="px-5 py-3 bg-white text-orange-700 font-bold rounded-xl text-xs hover:bg-orange-50 shadow-xs transition text-center">
                    Mulai Belanja Sekarang
                </a>
                <a href="{{ route('pesanan') }}" class="px-5 py-3 bg-white/20 text-white font-semibold rounded-xl text-xs hover:bg-white/30 border border-white/30 transition text-center">
                    Pantau Pesanan Saya
                </a>
            </div>
        </div>
    </div>

    <!-- 2. KARTU METRIK FOKUS WARGA -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6">
        <!-- Produk Tersedia -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Produk Tersedia</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $activeProductCount ?? 10 }}</h3>
                <span class="text-xs text-slate-500 mt-1 block">Produk Terverifikasi Dinas</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
        </div>

        <!-- Pesanan Berjalan Warga -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Pesanan Saya</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $umumMetrics['myOrdersCount'] ?? 6 }}</h3>
                <span class="text-xs text-slate-500 mt-1 block">Transaksi Aktif &amp; Riwayat</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
        </div>

        <!-- Komoditas Terbuka -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Komoditas Ternak</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $commodityCount ?? 6 }}</h3>
                <span class="text-xs text-slate-500 mt-1 block">Susu, Daging, Telur &amp; Pakan</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 3. REKOMENDASI PRODUK PILIHAN UNTUK WARGA -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 lg:p-7 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div>
                <h3 class="text-base font-semibold text-slate-900">Rekomendasi Produk Segar Hari Ini</h3>
                <p class="text-xs text-slate-500">Hasil panen langsung dari peternakan terverifikasi di Jawa Timur</p>
            </div>
            <a href="{{ route('marketplace') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                Lihat Semua Katalog &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($buyerFeaturedProducts ?? [] as $fp)
            <div class="border border-slate-200 rounded-2xl p-3 sm:p-3.5 flex flex-col justify-between hover:border-orange-300 shadow-2xs hover:shadow-xs transition group bg-white">
                <div>
                    <!-- Foto Produk Nyata -->
                    <div class="relative h-44 w-full rounded-xl overflow-hidden bg-slate-100 mb-3.5">
                        @if($fp->image_path)
                            <img src="{{ asset('storage/' . $fp->image_path) }}" alt="{{ $fp->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20 pointer-events-none"></div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                                <span class="text-xs">Foto Produk</span>
                            </div>
                        @endif

                        <!-- Badges Overlay -->
                        <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-1.5 z-10 pointer-events-none">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-white bg-black/60 backdrop-blur-xs px-2.5 py-1 rounded-lg border border-white/20 shadow-xs">
                                📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $fp->region?->name ?? 'Jatim') }}
                            </span>
                            @if($fp->is_verified)
                                <span class="bg-emerald-600/95 backdrop-blur-xs text-white border border-emerald-400/40 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Terverifikasi Dinas
                                </span>
                            @endif
                        </div>

                        <div class="absolute bottom-2.5 left-2.5 z-10 pointer-events-none">
                            <span class="text-[10px] font-semibold text-white/95 bg-black/50 backdrop-blur-xs px-2 py-0.5 rounded-md border border-white/10">
                                {{ $fp->category?->name ?? 'Komoditas' }}
                            </span>
                        </div>
                    </div>

                    <h4 class="font-bold text-slate-900 text-sm group-hover:text-orange-600 transition line-clamp-1" title="{{ $fp->name }}">{{ $fp->name }}</h4>

                    @if($fp->seller)
                    <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500">
                        <span class="font-medium text-slate-700 truncate">Peternak: {{ $fp->seller->name }}</span>
                    </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Harga</span>
                        <span class="font-bold text-orange-600 text-sm tabular-nums">Rp {{ number_format($fp->price, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('marketplace') }}" class="px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl text-xs transition shadow-2xs">
                        Beli Sekarang
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada produk untuk ditampilkan.</div>
            @endforelse
        </div>
    </div>

    <!-- 4. PANTAUAN PESANAN TERAKHIR SAYA (WARGA) -->
    @if(isset($buyerOrders) && $buyerOrders->isNotEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 lg:p-7 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <div>
                <h3 class="text-base font-semibold text-slate-900">Pesanan Terakhir Saya</h3>
                <p class="text-xs text-slate-500">Pantau proses pengemasan dan posisi kurir pendingin</p>
            </div>
            <a href="{{ route('pesanan') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                Lihat Semua Pesanan &rarr;
            </a>
        </div>
        <div class="space-y-2.5">
            @foreach($buyerOrders as $bo)
            @php
                $boBadge = match($bo->status) {
                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'confirmed', 'processing' => 'bg-sky-50 text-sky-700 border-sky-200',
                    'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                };
            @endphp
            <div class="p-3.5 bg-white rounded-xl border border-slate-200 hover:border-slate-300 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div>
                    <div class="font-semibold text-slate-900 flex items-center gap-2">
                        <span class="font-mono text-xs font-bold text-slate-700">{{ $bo->order_code }}</span>
                        <span class="text-slate-300">&middot;</span>
                        <span>{{ $bo->items->first()?->product?->name }}</span>
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        {{ $bo->created_at->format('d M Y, H:i') }} WIB &middot; Total: <strong class="text-slate-800 tabular-nums">Rp {{ number_format($bo->total_amount, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $boBadge }}">
                        {{ $bo->status_label }}
                    </span>
                    <a href="{{ route('pesanan') }}#order-{{ $bo->id }}" class="text-xs font-semibold text-primary-700 hover:text-primary-800 transition">
                        Lacak Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection


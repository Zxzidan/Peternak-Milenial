@extends('layouts.app')

@section('title', 'Dashboard Peternakan Provinsi Jawa Timur — Peternak Milenial')

@section('content')
<div class="space-y-8 lg:space-y-10">
    <!-- Header Dashboard: Bersih, Lega & Ringkas -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    {{ auth()->check() ? auth()->user()->role_label : 'Dinas Peternakan Provinsi Jawa Timur' }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Dashboard Pengelola — Dinas Peternakan Jatim
                @elseif(auth()->check() && auth()->user()->isUmum())
                    Portal Pasar &amp; Informasi Peternakan Jatim
                @else
                    Peternakan Provinsi Jawa Timur
                @endif
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 rounded-xl px-3.5 py-2 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>38 Kab/Kota Terpadu</span>
            </span>

            @if(auth()->check() && auth()->user()->isAdmin())
            <a
                href="{{ route('darurat') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold {{ $activeEmergencyCount > 0 ? 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }} border rounded-xl px-4 py-2 transition shadow-2xs"
            >
                <svg class="w-3.5 h-3.5 {{ $activeEmergencyCount > 0 ? 'text-rose-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>Siaga Darurat ({{ $activeEmergencyCount }})</span>
            </a>
            @elseif(!auth()->check() || !auth()->user()->isUmum())
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl px-4 py-2 transition shadow-xs"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>Lapor Darurat</span>
            </button>
            @endif
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isUmum())
    <!-- TAMPILAN KHUSUS MASYARAKAT: FOKUS MARKETPLACE & TRANSAKSI (SHOPEE STYLE) -->
    <div class="space-y-8">
        <!-- Hero Promo Banner Shopper -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-amber-600 to-emerald-700 text-white shadow-md p-6 sm:p-8">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 mb-2">
                        🛒 Portal Belanja Ternak Jatim
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-xs sm:text-sm text-orange-50/90 mt-1.5 leading-relaxed">
                        Beli langsung produk susu segar, daging higienis, telur bernutrisi, dan madu murni dari peternak lokal Jawa Timur dengan jaminan standar mutu Dinas Peternakan.
                    </p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/20 text-xs">
                        <div class="flex items-center gap-1.5">
                            <span>🚚</span>
                            <span class="font-semibold">Bebas Ongkir Jatim</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span>🛡️</span>
                            <span class="font-semibold">Higienis &amp; Halal</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span>💎</span>
                            <span class="font-semibold">Harga Peternak</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row md:flex-col gap-2.5 shrink-0">
                    <a href="{{ route('marketplace') }}" class="px-5 py-3 bg-white text-orange-700 font-bold rounded-xl text-xs hover:bg-orange-50 shadow-xs transition text-center">
                        Mulai Belanja Sekarang →
                    </a>
                    <a href="{{ url('/marketplace#pesanan') }}" class="px-5 py-3 bg-white/20 text-white font-semibold rounded-xl text-xs hover:bg-white/30 border border-white/30 transition text-center">
                        Pantau Pesanan Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- 3 Kartu Fokus Belanja -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Produk Tersedia</span>
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ $activeProductCount }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Produk Terverifikasi Dinas</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl">
                    🛍️
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Pesanan Saya</span>
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ $umumMetrics['myOrdersCount'] }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Transaksi Aktif / Berjalan</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                    📦
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Komoditas Unggulan</span>
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ $commodityCount }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Sektor Pangan &amp; Peternakan</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                    🥩
                </div>
            </div>
        </div>

        <!-- Rekomendasi Produk Pilihan Hari Ini (Katalog Cepat) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 lg:p-7 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Rekomendasi Produk Pilihan Hari Ini</h3>
                    <p class="text-xs text-slate-500">Produk peternakan terverifikasi langsung dari kelompok peternak Jawa Timur</p>
                </div>
                <a href="{{ route('marketplace') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                    Buka Marketplace Lengkap →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($buyerFeaturedProducts as $fp)
                @php
                    $pEmoji = match(true) {
                        str_contains(strtolower($fp->category?->name ?? ''), 'susu') => '🥛',
                        str_contains(strtolower($fp->category?->name ?? ''), 'daging') => '🥩',
                        str_contains(strtolower($fp->category?->name ?? ''), 'pakan') => '🌾',
                        str_contains(strtolower($fp->category?->name ?? ''), 'bibit') => '🐂',
                        default => '📦'
                    };
                @endphp
                <div class="border border-slate-200 rounded-2xl p-4 flex flex-col justify-between hover:border-orange-300 shadow-2xs hover:shadow-xs transition group">
                    <div>
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $fp->region?->name ?? 'Jatim') }}
                            </span>
                            <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                ✓ Verified
                            </span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl mb-2">
                            {{ $pEmoji }}
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-orange-600 transition line-clamp-1">{{ $fp->name }}</h4>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $fp->description }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Harga</span>
                            <span class="font-extrabold text-orange-600 text-sm">Rp {{ number_format($fp->price, 0, ',', '.') }}</span>
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

        <!-- Pantauan Pesanan Terakhir Saya -->
        @if($buyerOrders->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 lg:p-7 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Pesanan Terakhir Saya</h3>
                    <p class="text-xs text-slate-500">Pantau transaksi belanja terkini</p>
                </div>
                <a href="{{ url('/marketplace#pesanan') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                    Lihat Semua Pesanan →
                </a>
            </div>
            <div class="space-y-3">
                @foreach($buyerOrders as $bo)
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div>
                        <div class="font-extrabold text-slate-900">{{ $bo->order_code }} • {{ $bo->items->first()?->product?->name }}</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">
                            {{ $bo->created_at->format('d M Y, H:i') }} WIB • Total: <strong>Rp {{ number_format($bo->total_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $bo->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($bo->status) }}
                        </span>
                        <a href="{{ url('/marketplace#pesanan') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                            Lacak Status →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- 1. Statistik Utama: 3 Card Lega, Bersih, & Minimalis -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        <!-- Card 1: Pengguna Terdaftar -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs hover:border-slate-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna Terdaftar</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900" id="total-user-count">{{ $displayUserCount ?? $displayPeternakCount }}</h3>
                <span class="text-sm font-semibold text-slate-500">User</span>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 font-medium">
                Pelaku Usaha Ternak
            </div>
        </div>

        <!-- Card 2: Produktivitas Hasil -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs hover:border-slate-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Produktivitas Hasil</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">{{ $displayDailyProduction }}</h3>
                <span class="text-sm font-semibold text-slate-500">Ton / Hari</span>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 font-medium">
                Estimasi Harian
            </div>
        </div>

        <!-- Card 3: Struktur Komoditas -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs hover:border-slate-300 transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Struktur Komoditas</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">{{ $commodityCount }}</h3>
                <span class="text-sm font-semibold text-slate-500">Sektor</span>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 font-medium">
                Komoditas Unggulan Jatim
            </div>
        </div>
    </div>

    <!-- Section Utama: MASP -->
    <div id="masp" class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs">
        <!-- MASP Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934a1.12 1.12 0 0 1-1.006 0L9.503 3.314a1.12 1.12 0 0 0-1.006 0L3.622 5.75A1.125 1.125 0 0 0 3 6.757v12.423c0 .836.88 1.38 1.628 1.006l3.869-1.934a1.12 1.12 0 0 1 1.006 0l4.994 2.497a1.12 1.12 0 0 0 1.006 0Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Peta Sentra Peternakan (MASP)</h2>
                    <p class="text-xs text-slate-500">Sebaran kawasan sentra produksi peternakan Jawa Timur</p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <span id="masp-active-badge" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 bg-slate-100 rounded-lg px-3 py-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span id="masp-active-text">Seluruh Jawa Timur</span>
                </span>
                <a
                    id="masp-external-link"
                    href="https://www.google.com/maps/search/?api=1&query=Jawa+Timur"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 border border-blue-200/80 rounded-lg px-3 py-1.5 transition"
                >
                    <span>Buka Maps</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>

        @if($sentras->isEmpty())
        <div class="py-12 px-4 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
            <h3 class="text-sm font-semibold text-slate-700">Belum ada sentra terdaftar</h3>
        </div>
        @else
        <!-- Filter Sentra Bersih & Ringkas -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-4 text-xs">
            <button
                type="button"
                onclick="selectSentra('semua', this)"
                class="masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white shadow-xs transition"
            >
                Semua Jatim
            </button>
            @foreach($sentras as $s)
            <button
                type="button"
                onclick="selectSentra('{{ $s->id }}', this)"
                class="masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
            >
                {{ str_replace(['Kabupaten ', 'Kota '], '', $s->region?->name ?? $s->name) }}
            </button>
            @endforeach
        </div>

        <!-- Google Maps Embed Canvas -->
        <div class="relative w-full h-80 sm:h-96 md:h-[400px] rounded-xl overflow-hidden border border-slate-200 bg-slate-100 shadow-inner">
            <iframe
                id="masp-map-frame"
                title="Peta Google Maps Sentra Peternakan Jawa Timur"
                class="w-full h-full border-0"
                src="https://maps.google.com/maps?q=Jawa+Timur,+Indonesia&t=&z=8&ie=UTF8&iwloc=&output=embed"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
        @endif
    </div>
   
    <!-- 2. Visualisasi Grafik: 2 Kolom Bersih & Lega -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Chart 1: Distribusi Populasi Ternak -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs">
            <div class="pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-900">
                    Distribusi Populasi Ternak
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Komposisi populasi hewan ternak</p>
            </div>

            @if(empty($chartPopulasi['data']))
            <div class="min-h-[290px] flex flex-col items-center justify-center text-center p-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <h4 class="text-xs sm:text-sm font-semibold text-slate-600">Belum ada data populasi</h4>
            </div>
            @else
            <div id="chart-distribusi-ternak" class="w-full min-h-[290px]"></div>
            @endif
        </div>

        <!-- Chart 2: Volume Produksi Komoditas -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs">
            <div class="pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-900">
                    Produksi Komoditas Utama
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Volume produksi harian per komoditas</p>
            </div>

            @if(empty($chartProduksi['data']))
            <div class="min-h-[290px] flex flex-col items-center justify-center text-center p-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <h4 class="text-xs sm:text-sm font-semibold text-slate-600">Belum ada data produksi</h4>
            </div>
            @else
            <div id="chart-produksi-komoditas" class="w-full min-h-[290px]"></div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection


@push('scripts')
@php
    $sentraMap = [
        'semua' => [
            'kota' => 'Provinsi Jawa Timur',
            'peternak' => 'Pusat Distribusi Data Peternak Jawa Timur',
            'detail' => 'Kawasan Pemetaan Sentra Peternakan Terdaftar',
            'query' => 'Jawa Timur, Indonesia',
            'zoom' => 8,
            'badge' => 'Seluruh Jawa Timur'
        ]
    ];
    foreach($sentras as $s) {
        $sentraMap[$s->id] = [
            'kota' => $s->region?->name ?? $s->name,
            'peternak' => $s->name,
            'detail' => ($s->commodity?->name ?? 'Sentra') . ' • Kapasitas: ' . number_format($s->capacity ?? 0, 0, ',', '.') . ' Ekor • ' . number_format($s->farmer_count ?? 0, 0, ',', '.') . ' Peternak',
            'query' => ($s->latitude && $s->longitude) ? ($s->latitude . ',' . $s->longitude) : ($s->name . ', ' . ($s->region?->name ?? 'Jawa Timur')),
            'zoom' => 14,
            'badge' => ($s->region?->name ?? $s->name) . ': ' . ($s->commodity?->name ?? $s->name)
        ];
    }
@endphp

<script>
/**
 * Dashboard Peternakan Jawa Timur — Engine Visualisasi Dinamis Database
 * Menggunakan ApexCharts dengan palet warna resmi dan adaptasi dark-mode otomatis.
 */
let distChartInstance = null;
let prodChartInstance = null;

function updateMaspInfo(infoText) {
    const badgeText = document.getElementById('masp-active-text');
    if (badgeText) {
        badgeText.textContent = infoText;
    }
}

const sentraDatabase = @json($sentraMap);
const chartPopulasiCategories = @json($chartPopulasi['categories'] ?? []);
const chartPopulasiData = @json($chartPopulasi['data'] ?? []);
const chartProduksiCategories = @json($chartProduksi['categories'] ?? []);
const chartProduksiData = @json($chartProduksi['data'] ?? []);

function selectSentra(key, buttonElement) {
    const data = sentraDatabase[key];
    if (!data) return;

    // Arahkan iframe Google Maps langsung ke kota dan titik peternak
    const iframe = document.getElementById('masp-map-frame');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(data.query)}&t=&z=${data.zoom}&ie=UTF8&iwloc=&output=embed`;
    }

    updateMaspInfo(data.badge);

    const kotaElem = document.getElementById('masp-target-kota');
    if (kotaElem) kotaElem.textContent = data.kota;

    const peternakElem = document.getElementById('masp-target-peternak');
    if (peternakElem) peternakElem.textContent = data.peternak;

    const detailElem = document.getElementById('masp-target-detail');
    if (detailElem) detailElem.textContent = data.detail;

    const extLink = document.getElementById('masp-external-link');
    if (extLink) {
        extLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.query)}`;
    }

    const targetLink = document.getElementById('masp-target-link');
    if (targetLink) {
        targetLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.query)}`;
    }

    if (buttonElement) {
        document.querySelectorAll('.masp-filter-btn').forEach(btn => {
            btn.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition';
        });
        buttonElement.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-primary-600 text-white shadow-xs transition';
    }
}

function setMaspLocation(locationQuery, zoomLevel, label, buttonElement) {
    const iframe = document.getElementById('masp-map-frame');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(locationQuery)}&t=&z=${zoomLevel}&ie=UTF8&iwloc=&output=embed`;
    }

    updateMaspInfo(label);

    const extLink = document.getElementById('masp-external-link');
    if (extLink) {
        extLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(locationQuery)}`;
    }

    if (buttonElement) {
        document.querySelectorAll('.masp-filter-btn').forEach(btn => {
            btn.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition';
        });
        buttonElement.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-primary-600 text-white shadow-xs transition';
    }
}

function initCharts() {
    if (typeof ApexCharts === 'undefined') {
        return;
    }

    const textColor = '#475569';
    const gridColor = '#f1f5f9';

    // 1. Chart Distribusi Populasi Ternak di Jawa Timur (Horizontal Bar)
    const distElem = document.querySelector('#chart-distribusi-ternak');
    if (distElem && chartPopulasiData.length > 0) {
        const distOptions = {
            series: [{
                name: 'Populasi Ternak',
                data: chartPopulasiData
            }],
            chart: {
                type: 'bar',
                height: 290,
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    barHeight: '52%',
                    distributed: true
                }
            },
            colors: ['#013A85', '#009FD2', '#209527', '#FBBB03', '#8b5cf6'],
            dataLabels: {
                enabled: true,
                formatter: (val) => `${val.toLocaleString('id-ID')} Ekor`,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    colors: ['#0f172a']
                },
                offsetX: 8
            },
            legend: { show: false },
            xaxis: {
                categories: chartPopulasiCategories,
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: (val) => `${val.toLocaleString('id-ID')}`
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px', fontWeight: 500 }
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
                xaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: (val) => `${val.toLocaleString('id-ID')} Ekor`
                }
            }
        };

        if (distChartInstance) {
            distChartInstance.destroy();
        }
        distElem.innerHTML = '';
        distChartInstance = new ApexCharts(distElem, distOptions);
        distChartInstance.render();
    }

    // 2. Chart Produksi Komoditas Utama Jawa Timur (Column Bar)
    const prodElem = document.querySelector('#chart-produksi-komoditas');
    if (prodElem && chartProduksiData.length > 0) {
        const prodOptions = {
            series: [{
                name: 'Volume Produksi',
                data: chartProduksiData
            }],
            chart: {
                type: 'bar',
                height: 290,
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            colors: ['#FBBB03', '#009FD2', '#209527', '#013A85'],
            dataLabels: {
                enabled: true,
                formatter: (val) => `${val.toLocaleString('id-ID')}`,
                offsetY: -20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    colors: [textColor]
                }
            },
            legend: { show: false },
            xaxis: {
                categories: chartProduksiCategories,
                labels: {
                    style: { colors: textColor, fontSize: '11px', fontWeight: 500 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: (val) => `${val.toLocaleString('id-ID')}`
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: (val) => `${val.toLocaleString('id-ID')}`
                }
            }
        };

        if (prodChartInstance) {
            prodChartInstance.destroy();
        }
        prodElem.innerHTML = '';
        prodChartInstance = new ApexCharts(prodElem, prodOptions);
        prodChartInstance.render();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initCharts();
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Dashboard Peternakan Provinsi Jawa Timur — Peternak Milenial')

@section('content')
<div class="space-y-8 lg:space-y-10">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Dashboard Pengelola
                @elseif(auth()->check() && auth()->user()->isUmum())
                    Portal Peternakan Jatim
                @else
                    Peternakan Jawa Timur
                @endif
            </h1>
            <p class="text-sm text-slate-400 mt-1.5">
                {{ auth()->check() ? auth()->user()->role_label : 'Dinas Peternakan Provinsi Jawa Timur' }}
            </p>
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
                    <a href="{{ route('pesanan') }}" class="px-5 py-3 bg-white/20 text-white font-semibold rounded-xl text-xs hover:bg-white/30 border border-white/30 transition text-center">
                        Pantau Pesanan Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- 3 Kartu Fokus Belanja -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6">
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Produk Tersedia</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $activeProductCount }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Produk Terverifikasi Dinas</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl">
                    🛍️
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Pesanan Saya</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $umumMetrics['myOrdersCount'] }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Transaksi Aktif / Berjalan</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                    📦
                </div>
            </div>

            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Komoditas Unggulan</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $commodityCount }}</h3>
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
                <a href="{{ route('pesanan') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700">
                    Lihat Semua Pesanan →
                </a>
            </div>
            <div class="space-y-2.5">
                @foreach($buyerOrders as $bo)
                @php
                    $boStatusBadge = match($bo->status) {
                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200/70',
                        'confirmed', 'processing' => 'bg-sky-50 text-sky-700 border-sky-200/70',
                        'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200/70',
                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200/70',
                        'cancelled' => 'bg-slate-100 text-slate-600 border-slate-200',
                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                    };
                    $boStatusLabel = match($bo->status) {
                        'pending' => 'Menunggu',
                        'confirmed', 'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($bo->status)
                    };
                @endphp
                <div class="p-3.5 bg-white rounded-xl border border-slate-200 hover:border-slate-300 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div>
                        <div class="font-semibold text-slate-900 flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700">{{ $bo->order_code }}</span>
                            <span class="text-slate-300">·</span>
                            <span>{{ $bo->items->first()?->product?->name }}</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-1">
                            {{ $bo->created_at->format('d M Y, H:i') }} WIB · Total: <strong class="text-slate-800 tabular-nums">Rp {{ number_format($bo->total_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $boStatusBadge }}">
                            {{ $boStatusLabel }}
                        </span>
                        <a href="{{ route('pesanan') }}#order-{{ $bo->id }}" class="text-xs font-semibold text-primary-700 hover:text-primary-800 transition inline-flex items-center gap-1">
                            <span>Lacak Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- 1. Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Card 1: Pengguna Terdaftar -->
        <div class="bg-white border-l-4 border-l-blue-500 border border-slate-200/80 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Pengguna Terdaftar</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-slate-900 leading-none" id="total-user-count">{{ $displayUserCount ?? $displayPeternakCount }}</span>
                <span class="text-sm text-slate-500 mb-0.5">pengguna</span>
            </div>
            <p class="text-xs text-slate-400 mt-2">Pelaku Usaha Ternak terdaftar</p>
        </div>

        <!-- Card 2: Produktivitas Hasil -->
        <div class="bg-white border-l-4 border-l-emerald-500 border border-slate-200/80 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Produktivitas Hasil</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-slate-900 leading-none">{{ $displayDailyProduction }}</span>
                <span class="text-sm text-slate-500 mb-0.5">ton/hari</span>
            </div>
            <p class="text-xs text-slate-400 mt-2">Estimasi produksi harian</p>
        </div>

        <!-- Card 3: Struktur Komoditas -->
        <div class="bg-white border-l-4 border-l-amber-400 border border-slate-200/80 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Struktur Komoditas</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-slate-900 leading-none">{{ $commodityCount }}</span>
                <span class="text-sm text-slate-500 mb-0.5">sektor</span>
            </div>
            <p class="text-xs text-slate-400 mt-2">Komoditas unggulan Jawa Timur</p>
        </div>
    </div>

    <!-- Section Utama: MASP -->
    <div id="masp" class="bg-white border border-slate-200/90 rounded-2xl p-6 lg:p-7 shadow-xs">
        <!-- MASP Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Peta Sentra Peternakan (MASP)</h2>
                <p class="text-xs text-slate-400 mt-0.5">Sebaran kawasan sentra produksi &amp; perbibitan ternak Jawa Timur</p>
            </div>

            <span id="masp-active-badge" class="hidden">
                <span id="masp-active-text">Seluruh Jawa Timur</span>
            </span>
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('api.sentra-peternakan') }}"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition shrink-0"
                    title="Buka data JSON API resmi Sentra Peternakan Jatim"
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>API Sentra Jatim</span>
                </a>
                <a
                    id="masp-external-link"
                    href="https://www.google.com/maps/search/?api=1&query=Jawa+Timur"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1 text-xs text-slate-400 hover:text-slate-600 transition shrink-0"
                >
                    <span>Buka Maps</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>



        @php
            $displayItems = $sentraData['items'] ?? [];
        @endphp

        <!-- Filter Sentra Bersih & Ringkas -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-4 text-xs">
            <button
                type="button"
                onclick="selectSentra('semua', this)"
                class="masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white shadow-xs transition"
            >
                Semua Jatim (Provinsi)
            </button>
            @foreach($displayItems as $s)
            <button
                type="button"
                onclick="selectSentra('{{ $s['key'] }}', this)"
                class="masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
            >
                {{ str_replace(['Kabupaten ', 'Kota '], '', $s['kabupaten']) }}
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

        <!-- Detail Panel Kawasan Sentra -->
        <div class="mt-4 rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span id="masp-detail-status" class="text-[11px] font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-md">
                            Peringkat 1 Nasional Populasi &amp; Produksi Ternak
                        </span>
                    </div>
                    <h3 id="masp-detail-title" class="text-base font-bold text-slate-800">
                        Kawasan Agribisnis Peternakan Terpadu Jawa Timur
                    </h3>
                    <p id="masp-detail-kawasan" class="text-xs text-slate-500 mt-1">38 Kabupaten/Kota Terpadu • Provinsi Jawa Timur</p>
                </div>
                <a
                    id="masp-detail-link"
                    href="https://www.google.com/maps/search/?api=1&query=Jawa+Timur"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700 shrink-0"
                >
                    <span>Buka di Maps</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>


            <!-- 4 Parameter Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-slate-200 border-b border-slate-200">
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Komoditas</p>
                    <span id="masp-detail-komoditas" class="text-sm font-bold text-slate-800 line-clamp-1">Multi-Komoditas</span>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Populasi</p>
                    <span id="masp-detail-populasi" class="text-sm font-bold text-blue-700">573,05 Juta Ekor</span>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Kelompok</p>
                    <span id="masp-detail-kelompok" class="text-sm font-bold text-slate-800">1.200+ Kelompok</span>
                </div>
                <div class="px-5 py-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Produksi/Hari</p>
                    <span id="masp-detail-produksi" class="text-sm font-bold text-emerald-700">8.348 Ton</span>
                </div>
            </div>

            <div class="px-5 py-4 flex flex-wrap items-start justify-between gap-2">
                <p id="masp-detail-deskripsi" class="text-xs text-slate-500 leading-relaxed max-w-2xl">
                    Pusat lumbung ternak nasional penyumbang lebih dari 52% sapi perah, 28% sapi potong, dan 30% telur ayam ras di Indonesia dengan tata kelola berbasis digital Satu Data Jatim.
                </p>
                <span class="text-xs text-slate-400 shrink-0">Sumber: disnak.jatimprov.go.id</span>
            </div>
        </div>
    </div>
   
    <!-- 2. Visualisasi Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Chart 1: Distribusi Populasi Ternak -->
        <div class="bg-white border border-slate-200/80 rounded-xl shadow-xs flex flex-col">
            <div class="px-5 pt-5 pb-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Distribusi Populasi Ternak</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Komposisi populasi hewan ternak resmi Jawa Timur</p>
                </div>
                <a href="{{ route('api.statistik-peternakan') }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition shrink-0" title="Buka data JSON API resmi Satu Data Jatim">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>API Disnak Jatim</span>
                </a>
            </div>

            <div class="p-5 flex-1">
                @if(empty($chartPopulasi['data']))
                <div class="min-h-[260px] flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data populasi
                </div>
                @else
                <div id="chart-distribusi-ternak" class="w-full min-h-[260px]"></div>
                @endif
            </div>

            <div class="px-5 pb-4 flex items-center justify-between text-[11px] text-slate-400">
                <span>Sumber: Disnak Jatim &amp; BPS (ST2023)</span>
                <span class="font-medium text-slate-500">Satuan: Juta Ekor</span>
            </div>
        </div>

        <!-- Chart 2: Produksi Komoditas Utama -->
        <div class="bg-white border border-slate-200/80 rounded-xl shadow-xs flex flex-col">
            <div class="px-5 pt-5 pb-4 border-b border-slate-100 flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Produksi Komoditas Utama</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Volume produksi harian komoditas unggulan Jawa Timur</p>
                </div>
                
            </div>

            <div class="p-5 flex-1">
                @if(empty($chartProduksi['data']))
                <div class="min-h-[260px] flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data produksi
                </div>
                @else
                <div id="chart-produksi-komoditas" class="w-full min-h-[260px]"></div>
                @endif
            </div>

            <div class="px-5 pb-4 flex items-center justify-between text-[11px] text-slate-400">
                <span>Sumber: Statistik Peternakan Jawa Timur</span>
                <span class="font-medium text-slate-500">Satuan: Ton / Hari</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection


@push('scripts')
@php
    $sentraMap = [
        'semua' => [
            'id' => 'semua',
            'key' => 'semua',
            'name' => 'Kawasan Agribisnis Peternakan Terpadu Jawa Timur',
            'kawasan' => '38 Kabupaten/Kota Terpadu',
            'kabupaten' => 'Provinsi Jawa Timur',
            'komoditas' => 'Multi-Komoditas Strategis',
            'komoditas_icon' => '🏛️',
            'populasi' => '573,05 Juta Ekor',
            'kelompok' => '1.200+ Kelompok Ternak',
            'produksi' => '8.348 Ton / Hari',
            'status' => 'Peringkat 1 Nasional Populasi & Produksi Ternak',
            'deskripsi' => 'Pusat lumbung ternak nasional penyumbang lebih dari 52% sapi perah, 28% sapi potong, dan 30% telur ayam ras di Indonesia dengan tata kelola berbasis digital Satu Data Jatim.',
            'query' => 'Jawa Timur, Indonesia',
            'zoom' => 8,
            'badge' => 'Seluruh Jawa Timur'
        ]
    ];
    foreach(($sentraData['items'] ?? []) as $item) {
        $sentraMap[$item['key']] = [
            'id' => $item['id'],
            'key' => $item['key'],
            'name' => $item['name'],
            'kawasan' => $item['kawasan'],
            'kabupaten' => $item['kabupaten'],
            'komoditas' => $item['komoditas'],
            'komoditas_icon' => $item['komoditas_icon'],
            'populasi' => $item['populasi_formatted'],
            'kelompok' => $item['kelompok_binaan'],
            'produksi' => $item['produksi_harian'],
            'status' => $item['status_unggulan'],
            'deskripsi' => $item['deskripsi'],
            'query' => $item['maps_query'],
            'zoom' => $item['zoom'] ?? 13,
            'badge' => $item['kabupaten'] . ': ' . $item['komoditas']
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
const chartPopulasiRaw = @json($chartPopulasi['raw_data'] ?? []);
const chartPopulasiLabels = @json($chartPopulasi['formatted_labels'] ?? []);
const chartPopulasiSentra = @json($chartPopulasi['sentra_info'] ?? []);

const chartProduksiCategories = @json($chartProduksi['categories'] ?? []);
const chartProduksiData = @json($chartProduksi['data'] ?? []);
const chartProduksiLabels = @json($chartProduksi['formatted_labels'] ?? []);
const chartProduksiNotes = @json($chartProduksi['notes'] ?? []);

function selectSentra(key, buttonElement) {
    const data = sentraDatabase[key];
    if (!data) return;

    // Arahkan iframe Google Maps langsung ke koordinat akurat
    const iframe = document.getElementById('masp-map-frame');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(data.query)}&t=&z=${data.zoom}&ie=UTF8&iwloc=&output=embed`;
    }

    updateMaspInfo(data.badge);

    // Update panel detail informasi kawasan sentra Disnak Jatim
    const titleElem = document.getElementById('masp-detail-title');
    if (titleElem) titleElem.textContent = data.name;

    const statusElem = document.getElementById('masp-detail-status');
    if (statusElem) statusElem.textContent = data.status;

    const kawasanElem = document.getElementById('masp-detail-kawasan');
    if (kawasanElem) kawasanElem.textContent = `${data.kawasan} • ${data.kabupaten}`;

    const komoditasElem = document.getElementById('masp-detail-komoditas');
    if (komoditasElem) komoditasElem.textContent = data.komoditas;

    const populasiElem = document.getElementById('masp-detail-populasi');
    if (populasiElem) populasiElem.textContent = data.populasi;

    const kelompokElem = document.getElementById('masp-detail-kelompok');
    if (kelompokElem) kelompokElem.textContent = data.kelompok;

    const produksiElem = document.getElementById('masp-detail-produksi');
    if (produksiElem) produksiElem.textContent = data.produksi;

    const deskripsiElem = document.getElementById('masp-detail-deskripsi');
    if (deskripsiElem) deskripsiElem.textContent = data.deskripsi;

    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.query)}`;
    const extLink = document.getElementById('masp-external-link');
    if (extLink) extLink.href = mapsUrl;

    const detailLink = document.getElementById('masp-detail-link');
    if (detailLink) detailLink.href = mapsUrl;

    // Active button styling
    if (buttonElement) {
        document.querySelectorAll('.masp-filter-btn').forEach(btn => {
            btn.className = 'masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition';
        });
        buttonElement.className = 'masp-filter-btn shrink-0 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white shadow-xs transition';
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

    // 1. Chart Distribusi Populasi Ternak di Jawa Timur (Horizontal Bar - Sumber Valid Disnak Jatim & BPS)
    const distElem = document.querySelector('#chart-distribusi-ternak');
    if (distElem && chartPopulasiData.length > 0) {
        const distOptions = {
            series: [{
                name: 'Populasi Ternak Jatim',
                data: chartPopulasiData
            }],
            chart: {
                type: 'bar',
                height: 310,
                fontFamily: 'Poppins, sans-serif',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    barHeight: '56%',
                    distributed: true
                }
            },
            colors: ['#0284c7', '#06b6d4', '#10b981', '#f59e0b', '#2563eb', '#8b5cf6'],
            dataLabels: {
                enabled: true,
                formatter: (val, opts) => {
                    const idx = opts.dataPointIndex;
                    if (chartPopulasiLabels && chartPopulasiLabels[idx]) {
                        return chartPopulasiLabels[idx];
                    }
                    return `${val.toLocaleString('id-ID')} Jt Ekor`;
                },
                style: {
                    fontSize: '11px',
                    fontFamily: 'Poppins, sans-serif',
                    fontWeight: 600,
                    colors: ['#0f172a']
                },
                offsetX: 10
            },
            legend: { show: false },
            xaxis: {
                categories: chartPopulasiCategories,
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: (val) => `${val.toLocaleString('id-ID')} Jt`
                },
                title: {
                    text: 'Populasi (Juta Ekor)',
                    style: { color: textColor, fontSize: '10px', fontWeight: 500 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px', fontWeight: 600 }
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
                    formatter: (val, opts) => {
                        const idx = opts.dataPointIndex;
                        const cat = chartPopulasiCategories[idx] || '';
                        const raw = (chartPopulasiRaw && chartPopulasiRaw[idx]) ? chartPopulasiRaw[idx].toLocaleString('id-ID') : '';
                        const sentra = (chartPopulasiSentra && chartPopulasiSentra[cat]) ? ` • ${chartPopulasiSentra[cat]}` : '';
                        return `${raw} Ekor (${val.toLocaleString('id-ID')} Juta)${sentra}`;
                    }
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

    // 2. Chart Produksi Komoditas Utama Jawa Timur (Column Bar - Sumber Valid Disnak Jatim & BPS)
    const prodElem = document.querySelector('#chart-produksi-komoditas');
    if (prodElem && chartProduksiData.length > 0) {
        const prodOptions = {
            series: [{
                name: 'Volume Produksi Harian',
                data: chartProduksiData
            }],
            chart: {
                type: 'bar',
                height: 310,
                fontFamily: 'Poppins, sans-serif',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '42%',
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            colors: ['#f59e0b', '#06b6d4', '#10b981', '#2563eb'],
            dataLabels: {
                enabled: true,
                formatter: (val, opts) => {
                    const idx = opts.dataPointIndex;
                    if (chartProduksiLabels && chartProduksiLabels[idx]) {
                        return chartProduksiLabels[idx];
                    }
                    return `${val.toLocaleString('id-ID')} Ton`;
                },
                offsetY: -20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Poppins, sans-serif',
                    fontWeight: 600,
                    colors: [textColor]
                }
            },
            legend: { show: false },
            xaxis: {
                categories: chartProduksiCategories,
                labels: {
                    style: { colors: textColor, fontSize: '11px', fontWeight: 600 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: textColor, fontSize: '11px' },
                    formatter: (val) => `${val.toLocaleString('id-ID')} T`
                },
                title: {
                    text: 'Estimasi Ton / Hari',
                    style: { color: textColor, fontSize: '10px', fontWeight: 500 }
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: (val, opts) => {
                        const cat = chartProduksiCategories[opts.dataPointIndex];
                        if (chartProduksiNotes && chartProduksiNotes[cat]) {
                            return `${val.toLocaleString('id-ID')} Ton/hari • ${chartProduksiNotes[cat]}`;
                        }
                        return `${val.toLocaleString('id-ID')} Ton / hari`;
                    }
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

// Konsumsi Live API Data Peternakan Resmi Jawa Timur
function fetchJatimApiData() {
    fetch("{{ route('api.statistik-peternakan') }}")
        .then(response => response.json())
        .then(res => {
            if (res && res.status === 'success') {
                console.log('✓ Terhubung API Resmi Peternakan Jawa Timur:', res.source.institution);
            }
        })
        .catch(err => {
            console.warn('API Jatim fetch info:', err);
        });
}

// Konsumsi Live API Sentra Peternakan Resmi Jawa Timur (MASP)
function fetchSentraApiData() {
    fetch("{{ route('api.sentra-peternakan') }}")
        .then(response => response.json())
        .then(res => {
            if (res && res.status === 'success') {
                console.log('✓ Terhubung API Resmi Sentra Peternakan Jatim (MASP):', res.total_sentra, 'Kawasan');
            }
        })
        .catch(err => {
            console.warn('API Sentra Peternakan fetch info:', err);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    initCharts();
    fetchJatimApiData();
    fetchSentraApiData();
});
</script>
@endpush

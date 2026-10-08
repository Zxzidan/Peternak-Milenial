@extends('layouts.app')

@section('title', 'Marketplace Peternak Milenial — Pasar Ternak Digital Jawa Timur')

@section('content')
@php
    $defaultTab = 'katalog';
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            $defaultTab = 'verifikasi';
        } elseif (auth()->user()->isPeternak()) {
            $defaultTab = 'kelola';
        }
    }
    $activeTab = request('tab', $defaultTab);
    if ($activeTab === 'toko') {
        $activeTab = 'kelola';
    }
    if (auth()->check() && auth()->user()->isPeternak()) {
        $activeTab = 'kelola';
    }
    if (!in_array($activeTab, ['katalog', 'verifikasi', 'kelola'])) {
        $activeTab = 'katalog';
    }

    $unverifiedCount = $unverifiedCount ?? $myProducts->where('is_verified', false)->count();
    $verifiedCount = $verifiedCount ?? $myProducts->where('is_verified', true)->count();
    $totalAllProducts = $totalAllProducts ?? $myProducts->count();
@endphp

<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 mb-2 sm:mb-2.5 flex-wrap">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <span class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 text-xs font-medium px-2 py-0.5 rounded">
                        Bidang Pascapanen &amp; Pemasaran
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        · Disnak Jatim
                    </span>
                @else
                    <span class="bg-orange-50 text-orange-700 dark:bg-orange-950/60 dark:text-orange-300 text-xs font-medium px-2 py-0.5 rounded">
                        Pasar Digital Peternak Milenial Jatim
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        · Bebas Ongkir Subsidi Jatim
                    </span>
                @endif
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Verifikasi Produk Peternak
                @elseif($activeTab === 'kelola')
                    Kelola Produk Peternakan
                @else
                    Marketplace Peternak Milenial
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed max-w-2xl">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Kurasi dan persetujuan mutu komoditas peternak sebelum dipublikasikan ke katalog.
                @elseif($activeTab === 'kelola')
                    Manajemen produk hasil ternak dan pantauan status verifikasi dinas.
                @else
                    Belanja susu, daging segar, pakan, dan telur langsung dari peternak binaan Jawa Timur.
                @endif
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if(auth()->check() && auth()->user()->isAdmin())
                @if($unverifiedCount > 0)
                    <a
                        href="{{ route('marketplace', ['verifikasi' => 'pending']) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800 transition"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{{ $unverifiedCount }} Menunggu</span>
                    </a>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Semua Terverifikasi</span>
                    </span>
                @endif

                <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                    {{ $totalAllProducts }} Produk
                </span>
            @elseif(auth()->check() && auth()->user()->isPeternak())
                <button
                    type="button"
                    onclick="toggleTambahProdukForm()"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    <span>Unggah Produk Baru</span>
                </button>
                <span class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-lg bg-primary-50 text-primary-800 dark:bg-primary-950/60 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                    <span>Produk Saya ({{ $myProducts->count() }})</span>
                </span>
                <a
                    href="{{ route('pesanan') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 rounded-lg transition"
                >
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    <span>Riwayat Pesanan Masuk</span>
                </a>
            @else
                <span class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                    {{ $products->count() }} Komoditas Tersedia
                </span>
                <a
                    href="{{ route('pesanan') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 rounded-lg transition"
                >
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    <span>Pesanan Saya</span>
                </a>
            @endif
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- ============================================== -->
    <!-- TAB: VERIFIKASI PRODUK (ADMIN DINAS ONLY)      -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- 3 KPI Cards Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Menunggu Verifikasi</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $unverifiedCount }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Perlu ditinjau petugas</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Terverifikasi &amp; Tayang</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $verifiedCount }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Aktif di katalog publik</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-primary-600 dark:text-primary-400 font-medium">Total Produk Peternak</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalAllProducts }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Semua komoditas terdaftar</p>
            </div>
        </div>

        <!-- Filter Sub-status & Pencarian untuk Admin -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                <a
                    href="{{ route('marketplace') }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ !request()->filled('verifikasi') ? 'bg-primary-700 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Semua ({{ $totalAllProducts }})
                </a>
                <a
                    href="{{ route('marketplace', ['verifikasi' => 'pending']) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ request('verifikasi') === 'pending' ? 'bg-amber-600 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Menunggu ({{ $unverifiedCount }})
                </a>
                <a
                    href="{{ route('marketplace', ['verifikasi' => 'verified']) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ request('verifikasi') === 'verified' ? 'bg-emerald-600 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Terverifikasi ({{ $verifiedCount }})
                </a>
            </div>

            <form action="{{ route('marketplace') }}" method="GET" class="flex items-center gap-2">
                @if(request()->filled('verifikasi'))
                    <input type="hidden" name="verifikasi" value="{{ request('verifikasi') }}">
                @endif
                <div class="relative w-full sm:w-56">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari produk / peternak..."
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg pl-8 pr-3 py-1.5 text-gray-900 dark:text-white focus:bg-white"
                    >
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                @if(request()->filled('q'))
                    <a href="{{ route('marketplace', request()->only('verifikasi')) }}" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel Verifikasi Produk -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Verifikasi Produk Peternak</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tinjau mutu dan validasi komoditas peternak.</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    {{ $myProducts->count() }} Produk
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-750 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Kategori &amp; Wilayah</th>
                            <th class="px-4 py-3">Peternak Pengunggah</th>
                            <th class="px-4 py-3">Harga &amp; Stok</th>
                            <th class="px-4 py-3">Status Verifikasi</th>
                            <th class="px-4 py-3 text-right">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($myProducts as $prod)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750/50 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $prod->name }}</div>
                                <div class="text-[11px] text-gray-400 line-clamp-1 max-w-xs">{{ $prod->description }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div>{{ $prod->category?->name ?? 'Komoditas' }}</div>
                                <div class="text-[11px] text-gray-400">📍 {{ $prod->region?->name ?? 'Jawa Timur' }}</div>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">
                                👨‍🌾 {{ $prod->seller?->name ?? 'Peternak Binaan' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                <div class="text-[11px] text-gray-400">Stok: {{ $prod->stock }} {{ $prod->unit }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if ($prod->is_verified)
                                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                        ✓ Terverifikasi / Dipublikasikan
                                    </span>
                                @else
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800">
                                        Menunggu Verifikasi Admin
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-1.5">
                                @if(! $prod->is_verified)
                                    <form action="{{ route('marketplace.products.verify', $prod) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="tab" value="verifikasi">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2.5 py-1 rounded-lg transition shadow-xs">
                                            Setujui &amp; Publikasi
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('marketplace.products.destroy', $prod) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk {{ $prod->name }} dari database?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="tab" value="verifikasi">
                                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 dark:bg-rose-950/50 dark:border-rose-800 dark:text-rose-300 text-[10px] font-semibold px-2 py-1 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="max-w-xs mx-auto text-gray-400 dark:text-gray-500">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Tidak ada produk dalam daftar ini.</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Semua produk baru yang diunggah peternak akan muncul di sini untuk ditinjau.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif($activeTab === 'kelola' && auth()->check() && auth()->user()->isPeternak())
    <!-- ============================================== -->
    <!-- TAB: KELOLA PRODUK SAYA (PETERNAK ONLY)        -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- Form Tambah Produk (Collapsible untuk Peternak) -->
        <div id="form-tambah-produk" class="hidden bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Unggah Komoditas Peternakan Baru</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Produk akan diverifikasi oleh Admin Dinas sebelum status tervalidasi dan tayang ke publik.</p>
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('form-tambah-produk').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs px-2 py-1 rounded-md"
                >
                    ✕ Batal
                </button>
            </div>

            <form action="{{ route('marketplace.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                @csrf
                <input type="hidden" name="tab" value="kelola">

                <!-- Upload Foto Produk Baru -->
                <div class="md:col-span-2 p-3 bg-gray-50 dark:bg-gray-750 rounded-xl border border-gray-200 dark:border-gray-700">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">Foto Produk Peternakan</label>
                    <div class="flex items-center gap-4">
                        <div id="preview-box-tambah" class="w-20 h-20 rounded-xl bg-white dark:bg-gray-700 border border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="img-preview-tambah" class="hidden w-full h-full object-cover" src="" alt="Preview Foto">
                            <div id="placeholder-preview-tambah" class="text-center text-gray-400 p-2">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                <span class="text-[9px] block mt-0.5">Pilih Foto</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input
                                type="file"
                                name="image"
                                accept="image/png,image/jpeg,image/webp"
                                onchange="previewImage(this, 'img-preview-tambah', 'placeholder-preview-tambah')"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-950/60 dark:file:text-primary-300 cursor-pointer"
                            >
                            <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, atau WebP (Maksimum 5MB). Foto asli komoditas akan ditampilkan di etalase kartu produk.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Susu Kambing Etawa Segar (1L)" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                    <select name="product_category_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Sentra Asal <span class="text-rose-500">*</span></label>
                    <select name="region_id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                        @foreach ($regions as $reg)
                            <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Satuan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" required min="100" placeholder="Contoh: 25000" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Stok <span class="text-rose-500">*</span></label>
                    <input type="number" name="stock" required min="1" placeholder="Contoh: 50" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan Produk <span class="text-rose-500">*</span></label>
                    <input type="text" name="unit" required placeholder="Contoh: Botol / Kg / Liter / Ekor" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan Produk &amp; Standar Mutu</label>
                    <textarea name="description" rows="2" placeholder="Informasi higienis, pakan ternak alami, sertifikasi NKV / Halal..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
                </div>
                <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                    <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-bold px-5 py-2.5 rounded-lg shadow-xs transition">
                        Ajukan Produk ke Dinas
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Produk Peternakan: Tampilan Kotak-Kotak (Grid Kartu) -->
        <div id="toko" class="space-y-4">
            <div class="p-4 sm:p-5 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Produk Peternakan Saya</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Status verifikasi produk yang Anda ajukan. Produk yang disetujui akan tayang di marketplace publik.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Total: {{ $myProducts->count() }} Produk
                    </span>
                    <button
                        type="button"
                        onclick="toggleTambahProdukForm()"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3 py-1.5 rounded-lg transition shadow-xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        <span>Tambah Produk</span>
                    </button>
                </div>
            </div>

            <!-- Grid Kotak-Kotak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($myProducts as $prod)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 shadow-xs hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                    <!-- Area Kotak Foto & Badge Status -->
                    <div>
                        <div class="relative h-48 w-full bg-gray-100 dark:bg-gray-750 overflow-hidden">
                            @if($prod->image_path)
                                <img
                                    src="{{ asset('storage/' . $prod->image_path) }}"
                                    alt="{{ $prod->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                                <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-black/20"></div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-linear-to-br from-slate-100 to-slate-200 dark:from-gray-750 dark:to-gray-800 text-gray-400 p-4">
                                    <div class="w-14 h-14 rounded-2xl bg-white/80 dark:bg-gray-700/80 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-primary-600 dark:text-primary-300 mb-2 shadow-xs">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400">Belum ada foto produk</span>
                                </div>
                            @endif

                            <!-- Overlay Badges -->
                            <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-1.5 z-10">
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-white bg-black/60 backdrop-blur-xs px-2.5 py-1 rounded-lg border border-white/20">
                                    📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $prod->region?->name ?? 'Jatim') }}
                                </span>

                                @if ($prod->is_verified)
                                    <span class="bg-emerald-600/95 backdrop-blur-xs text-white border border-emerald-400/40 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-xs">
                                        ✓ Terverifikasi / Dipublikasikan
                                    </span>
                                @else
                                    <span class="bg-amber-500/95 backdrop-blur-xs text-white border border-amber-400/40 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        Menunggu Verifikasi Admin
                                    </span>
                                @endif
                            </div>

                            <!-- Bottom Left Category Pill -->
                            <div class="absolute bottom-2.5 left-2.5 z-10">
                                <span class="inline-flex items-center text-[10px] font-semibold text-white bg-primary-700/85 backdrop-blur-xs px-2 py-0.5 rounded">
                                    {{ $prod->category?->name ?? 'Komoditas' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body (Informasi Produk) -->
                        <div class="p-4 space-y-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1 leading-snug group-hover:text-primary-700 dark:group-hover:text-primary-400 transition" title="{{ $prod->name }}">
                                {{ $prod->name }}
                            </h3>

                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed min-h-[32px]">
                                {{ $prod->description ?? 'Belum ada keterangan produk.' }}
                            </p>

                            <!-- Kotak Detail Harga & Stok -->
                            <div class="grid grid-cols-2 gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-gray-750 border border-gray-100 dark:border-gray-700/60 text-xs">
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-medium">Harga Penjualan</span>
                                    <span class="font-bold text-primary-700 dark:text-primary-400 text-sm">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-gray-400">/ {{ $prod->unit }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-medium">Ketersediaan Stok</span>
                                    <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $prod->stock }}</span>
                                    <span class="text-[10px] text-gray-500 dark:text-gray-400"> {{ $prod->unit }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-4 pt-0">
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center gap-2">
                            <button
                                type="button"
                                onclick="openEditProductModal({{ $prod->id }})"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 border border-primary-200 dark:border-primary-800 transition"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                </svg>
                                <span>Edit Produk</span>
                            </button>

                            <form action="{{ route('marketplace.products.destroy', $prod) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk {{ $prod->name }} dari daftar?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tab" value="kelola">
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center p-2 text-xs font-semibold rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/50 dark:text-rose-300 border border-rose-200 dark:border-rose-800 transition"
                                    title="Hapus Produk"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Edit Produk {{ $prod->id }} -->
                    <div id="edit-modal-{{ $prod->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs p-4 overflow-y-auto">
                        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 text-xs">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Informasi &amp; Foto Produk</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui rincian, foto, harga, atau ketersediaan stok produk.</p>
                                </div>
                                <button
                                    type="button"
                                    onclick="closeEditProductModal({{ $prod->id }})"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-sm font-bold p-1 rounded-md"
                                >
                                    ✕
                                </button>
                            </div>

                            <form action="{{ route('marketplace.products.update', $prod) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tab" value="kelola">

                                <!-- Upload / Ganti Foto Produk -->
                                <div class="p-3 bg-gray-50 dark:bg-gray-750 rounded-xl border border-gray-200 dark:border-gray-700">
                                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-2">Foto Produk</label>
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 overflow-hidden shrink-0 flex items-center justify-center">
                                            <img
                                                id="edit-img-preview-{{ $prod->id }}"
                                                src="{{ $prod->image_path ? asset('storage/' . $prod->image_path) : '' }}"
                                                alt="{{ $prod->name }}"
                                                class="w-full h-full object-cover {{ $prod->image_path ? '' : 'hidden' }}"
                                            >
                                            <div id="edit-icon-placeholder-{{ $prod->id }}" class="{{ $prod->image_path ? 'hidden' : '' }} text-center text-gray-400 p-2">
                                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                <span class="text-[9px] block mt-0.5">Pilih Foto</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input
                                                type="file"
                                                name="image"
                                                accept="image/png,image/jpeg,image/webp"
                                                onchange="previewImage(this, 'edit-img-preview-{{ $prod->id }}', 'edit-icon-placeholder-{{ $prod->id }}')"
                                                class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-950/60 dark:file:text-primary-300 cursor-pointer"
                                            >
                                            <p class="text-[11px] text-gray-400 mt-1">Unggah file baru untuk mengganti foto produk (JPG, PNG, WebP maks 5MB).</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Inputs -->
                                <div>
                                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" required value="{{ $prod->name }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                                        <select name="product_category_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $prod->product_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Sentra Asal <span class="text-rose-500">*</span></label>
                                        <select name="region_id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                            @foreach ($regions as $reg)
                                                <option value="{{ $reg->id }}" {{ $prod->region_id == $reg->id ? 'selected' : '' }}>{{ $reg->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Satuan (Rp) <span class="text-rose-500">*</span></label>
                                        <input type="number" name="price" required min="100" value="{{ (int) $prod->price }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Stok <span class="text-rose-500">*</span></label>
                                        <input type="number" name="stock" required min="0" value="{{ $prod->stock }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan Produk <span class="text-rose-500">*</span></label>
                                        <input type="text" name="unit" required value="{{ $prod->unit }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan Produk &amp; Standar Mutu</label>
                                    <textarea name="description" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">{{ $prod->description }}</textarea>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <button
                                        type="button"
                                        onclick="closeEditProductModal({{ $prod->id }})"
                                        class="px-4 py-2 text-xs font-medium text-gray-600 hover:text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-lg transition"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        type="submit"
                                        class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-xs transition"
                                    >
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 px-4 text-center bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada produk yang Anda daftarkan di database.</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Mulai jual komoditas hasil peternakan Anda dengan mengunggah foto dan detail produk.</p>
                    <button type="button" onclick="toggleTambahProdukForm()" class="inline-block mt-3 px-3.5 py-1.5 bg-primary-700 text-white rounded-lg text-xs font-semibold hover:bg-primary-800 transition">
                        + Unggah Produk Pertama
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @else
    <!-- ============================================== -->
    <!-- TAB: KATALOG PRODUK (PUBLIK / PEMBELI)         -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- Search & Filter Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 shadow-xs space-y-4">
            <!-- Filter Kategori Cepat -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                <a
                    href="{{ route('marketplace', array_merge(request()->except('kategori'), ['tab' => 'katalog'])) }}"
                    class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($selectedCategory) ? 'bg-primary-700 text-white shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300' }}"
                >
                    Semua Produk
                </a>
                @foreach ($categories as $cat)
                    <a
                        href="{{ route('marketplace', array_merge(request()->query(), ['kategori' => $cat->slug, 'tab' => 'katalog'])) }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition {{ $selectedCategory == $cat->slug ? 'bg-primary-700 text-white shadow-xs font-semibold' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300' }}"
                    >
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Form Pencarian & Filter Wilayah -->
            <form action="{{ route('marketplace') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <input type="hidden" name="tab" value="katalog">
                @if(!empty($selectedCategory))
                    <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                @endif

                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <input
                        type="text"
                        name="q"
                        value="{{ $searchQuery }}"
                        placeholder="Cari susu sapi pasteurisasi, daging segar, silase pakan..."
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg pl-10 pr-4 py-2 text-gray-900 dark:text-white focus:bg-white transition"
                    >
                </div>

                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                    <select
                        name="wilayah"
                        onchange="this.form.submit()"
                        class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-2 px-3 text-gray-800 dark:text-gray-200 transition"
                    >
                        <option value="">Semua Wilayah Sentra Jatim</option>
                        @foreach ($regions as $reg)
                            <option value="{{ $reg->id }}" {{ $selectedRegion == $reg->id ? 'selected' : '' }}>
                                {{ str_replace(['Kabupaten ', 'Kota '], '', $reg->name) }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-2 px-3 text-gray-800 dark:text-gray-200 transition"
                    >
                        <option value="terbaru" {{ $selectedSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ $selectedSort == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="termahal" {{ $selectedSort == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>

                    <button
                        type="submit"
                        class="bg-primary-700 hover:bg-primary-800 text-white font-semibold text-xs px-4 py-2 rounded-lg shadow-xs transition shrink-0"
                    >
                        Cari
                    </button>

                    @if(!empty($searchQuery) || !empty($selectedCategory) || !empty($selectedRegion) || !empty($selectedSort))
                    <a
                        href="{{ route('marketplace', ['tab' => 'katalog']) }}"
                        class="text-xs text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white px-2 py-1 shrink-0"
                    >
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Grid Katalog Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
            @forelse ($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 shadow-xs hover:shadow-sm transition-all flex flex-col justify-between overflow-hidden">
                <!-- Visual Header -->
                <div>
                    <div class="relative h-40 bg-gray-50 dark:bg-gray-750 p-3.5 flex flex-col justify-between">
                        <div class="flex items-center justify-between z-10">
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-700 dark:text-gray-300 bg-white/90 dark:bg-gray-800/90 px-2 py-0.5 rounded shadow-2xs border border-gray-200/80 dark:border-gray-700">
                                📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $product->region?->name ?? 'Jatim') }}
                            </span>
                            @if($product->is_verified)
                                <span class="inline-flex items-center text-[10px] font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 px-2 py-0.5 rounded">
                                    ✓ Disnak Verified
                                </span>
                            @else
                                <span class="inline-flex items-center text-[10px] font-semibold text-amber-700 bg-amber-50 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800 px-2 py-0.5 rounded">
                                    Menunggu Verifikasi
                                </span>
                            @endif
                        </div>

                        <!-- Emblem Center or Product Image -->
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-black/20"></div>
                        @else
                            <div class="flex items-center justify-center my-auto">
                                <div class="w-14 h-14 rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-primary-700 dark:text-primary-300 shadow-xs">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400">
                            <span class="bg-white/80 dark:bg-gray-800/80 px-1.5 py-0.5 rounded font-medium">
                                {{ $product->category?->name ?? 'Komoditas' }}
                            </span>
                            <span class="bg-white/80 dark:bg-gray-800/80 px-1.5 py-0.5 rounded">
                                Stok: <strong class="text-gray-900 dark:text-white">{{ $product->stock }}</strong> {{ $product->unit }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 leading-snug">
                            {{ $product->name }}
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>

                        <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700/60 flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <span class="text-gray-400">👨‍🌾</span>
                            <span class="truncate font-medium">{{ $product->seller?->name ?? 'Peternak Binaan' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer (Price & Action) -->
                <div class="p-4 pt-0">
                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-end justify-between gap-2">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Peternak</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-base font-bold text-primary-700 dark:text-primary-400 tabular-nums">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-gray-400">/ {{ $product->unit }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                @if(!$product->is_verified)
                                <form action="{{ route('marketplace.products.verify', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="tab" value="katalog">
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                                        Setujui
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('marketplace.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="tab" value="katalog">
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 transition" title="Hapus Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            @else
                                <button
                                    type="button"
                                    onclick="openBuyModal('{{ $product->id }}')"
                                    class="inline-flex items-center px-3.5 py-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-lg transition shadow-xs"
                                >
                                    Beli Sekarang
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Checkout Transaksi -->
                <div id="buy-modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-xs p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 text-xs">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Checkout Transaksi Belanja</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pasar Peternak Milenial Jawa Timur</p>
                            </div>
                            <button
                                type="button"
                                onclick="closeBuyModal('{{ $product->id }}')"
                                class="text-gray-400 hover:text-gray-600 text-sm font-bold p-1"
                            >
                                ✕
                            </button>
                        </div>

                        <!-- Product Summary -->
                        <div class="p-3 bg-gray-50 dark:bg-gray-750 rounded-lg border border-gray-200 dark:border-gray-700 mb-4 flex items-center justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $product->name }}</h4>
                                <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Penjual: {{ $product->seller?->name ?? 'Peternak Binaan' }} • {{ $product->region?->name ?? 'Jatim' }}</div>
                                <div class="font-semibold text-primary-700 dark:text-primary-400 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit }}</div>
                            </div>
                        </div>

                        <form action="{{ route('marketplace.products.buy', $product) }}" method="POST" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Jumlah Pembelian (Tersedia: {{ $product->stock }} {{ $product->unit }}) <span class="text-rose-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-700">
                                        <button
                                            type="button"
                                            onclick="decrementQty('{{ $product->id }}', {{ $product->price }})"
                                            class="px-2.5 py-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-200 font-bold"
                                        >
                                            -
                                        </button>
                                        <input
                                            type="number"
                                            id="qty-input-{{ $product->id }}"
                                            name="quantity"
                                            required
                                            min="1"
                                            max="{{ $product->stock }}"
                                            value="1"
                                            onchange="calculateTotal('{{ $product->id }}', {{ $product->price }})"
                                            class="w-14 text-center border-0 bg-transparent text-xs font-bold text-gray-900 dark:text-white focus:ring-0 p-1"
                                        >
                                        <button
                                            type="button"
                                            onclick="incrementQty('{{ $product->id }}', {{ $product->stock }}, {{ $product->price }})"
                                            class="px-2.5 py-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-200 font-bold"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <span class="text-gray-500">{{ $product->unit }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penerima <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        name="buyer_name"
                                        required
                                        value="{{ auth()->user()?->name ?? '' }}"
                                        placeholder="Nama lengkap Anda"
                                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"
                                    >
                                </div>
                                <div>
                                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        name="buyer_phone"
                                        required
                                        value="{{ auth()->user()?->phone_number ?? '' }}"
                                        placeholder="08123456789"
                                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Pengiriman di Jawa Timur <span class="text-rose-500">*</span></label>
                                <textarea
                                    name="shipping_address"
                                    required
                                    rows="2"
                                    placeholder="Jalan, No. Rumah, RT/RW, Desa, Kecamatan, Kabupaten/Kota"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"
                                >{{ auth()->user() && auth()->user()->desa ? auth()->user()->desa . ', Kec. ' . auth()->user()->kecamatan . ', ' . auth()->user()->kabupaten : '' }}</textarea>
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 cursor-pointer">
                                        <input type="radio" name="payment_method" value="QRIS Instan" checked class="text-primary-700">
                                        <span>QRIS Instan</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 cursor-pointer">
                                        <input type="radio" name="payment_method" value="Virtual Account Bank" class="text-primary-700">
                                        <span>VA Bank Jatim / BCA</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 cursor-pointer">
                                        <input type="radio" name="payment_method" value="COD Bayar di Tempat" class="text-primary-700">
                                        <span>COD (Bayar di Tempat)</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 cursor-pointer">
                                        <input type="radio" name="payment_method" value="Escrow Bersama Disnak" class="text-primary-700">
                                        <span>Escrow Disnak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-3 bg-gray-50 dark:bg-gray-750 rounded-lg border border-gray-200 dark:border-gray-700 space-y-1">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Subtotal Produk:</span>
                                    <span id="modal-subtotal-{{ $product->id }}" class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Ongkos Kirim (Jatim):</span>
                                    <span class="font-semibold text-emerald-600">Bebas Ongkir (Subsidi Jatim)</span>
                                </div>
                                <div class="pt-1.5 border-t border-gray-200 dark:border-gray-700 flex justify-between items-baseline font-bold">
                                    <span class="text-gray-900 dark:text-white">Total Tagihan:</span>
                                    <span id="modal-total-{{ $product->id }}" class="text-sm font-bold text-primary-700 dark:text-primary-400">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-2">
                                <button
                                    type="button"
                                    onclick="closeBuyModal('{{ $product->id }}')"
                                    class="px-3.5 py-2 text-xs font-medium text-gray-600 hover:text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-lg transition"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-xs transition"
                                >
                                    Konfirmasi &amp; Beli
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 px-4 text-center bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 mx-auto rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Tidak ada produk ditemukan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Coba sesuaikan kata kunci pencarian atau pilih filter wilayah dan kategori komoditas lainnya.</p>
                <a href="{{ route('marketplace', ['tab' => 'katalog']) }}" class="inline-block mt-3 px-3.5 py-1.5 bg-primary-700 text-white rounded-lg text-xs font-semibold">
                    Lihat Semua Produk
                </a>
            </div>
            @endforelse
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
function toggleTambahProdukForm() {
    const el = document.getElementById('form-tambah-produk');
    if (el) {
        el.classList.toggle('hidden');
        if (!el.classList.contains('hidden')) {
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
}

function openEditProductModal(productId) {
    const modal = document.getElementById(`edit-modal-${productId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeEditProductModal(productId) {
    const modal = document.getElementById(`edit-modal-${productId}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function previewImage(input, previewImgId, placeholderId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById(previewImgId);
            const placeholder = document.getElementById(placeholderId);
            if (previewImg) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
            }
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    }
}

function openBuyModal(productId) {
    const modal = document.getElementById(`buy-modal-${productId}`);
    if (modal) modal.classList.remove('hidden');
}

function closeBuyModal(productId) {
    const modal = document.getElementById(`buy-modal-${productId}`);
    if (modal) modal.classList.add('hidden');
}

function incrementQty(productId, maxStock, unitPrice) {
    const input = document.getElementById(`qty-input-${productId}`);
    if (!input) return;
    let val = parseInt(input.value) || 1;
    if (val < maxStock) {
        val++;
        input.value = val;
        calculateTotal(productId, unitPrice);
    }
}

function decrementQty(productId, unitPrice) {
    const input = document.getElementById(`qty-input-${productId}`);
    if (!input) return;
    let val = parseInt(input.value) || 1;
    if (val > 1) {
        val--;
        input.value = val;
        calculateTotal(productId, unitPrice);
    }
}

function calculateTotal(productId, unitPrice) {
    const input = document.getElementById(`qty-input-${productId}`);
    if (!input) return;
    const qty = Math.max(1, parseInt(input.value) || 1);
    const subtotal = qty * unitPrice;

    const formatted = `Rp ${subtotal.toLocaleString('id-ID')}`;
    const subElem = document.getElementById(`modal-subtotal-${productId}`);
    const totElem = document.getElementById(`modal-total-${productId}`);

    if (subElem) subElem.textContent = formatted;
    if (totElem) totElem.textContent = formatted;
}
</script>
@endpush

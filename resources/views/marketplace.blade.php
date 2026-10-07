@extends('layouts.app')

@section('title', 'Marketplace Peternak Milenial — Pasar Ternak Digital Jawa Timur')

@section('content')
<div class="space-y-6">
    <!-- Shopee-Style Hero Promotional Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-amber-600 to-emerald-700 text-white shadow-md p-6 sm:p-8">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-48 h-48 bg-amber-400/20 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-xs text-white border border-white/30">
                        🛒 Pasar Digital Peternak Milenial Jatim
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/30 text-emerald-100 border border-emerald-400/30">
                        ✓ 100% Terverifikasi Dinas Peternakan
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-tight">
                    Belanja Produk Peternakan Langsung dari Peternak Lokal
                </h1>
                <p class="text-xs sm:text-sm text-orange-50/90 mt-2 leading-relaxed">
                    Dapatkan susu murni, daging segar higienis, telur bernutrisi, madu asli, dan pakan ternak berkualitas binaan Dinas Peternakan Jawa Timur tanpa perantara.
                </p>

                <!-- 3 Value Pillars ala Shopee -->
                <div class="grid grid-cols-3 gap-3 mt-5 pt-4 border-t border-white/20 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                            🚚
                        </div>
                        <div>
                            <div class="font-bold text-[11px] sm:text-xs">Bebas Ongkir</div>
                            <div class="text-[10px] text-orange-100/80 hidden sm:block">Subsidi Wilayah Jatim</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                            🛡️
                        </div>
                        <div>
                            <div class="font-bold text-[11px] sm:text-xs">Segar &amp; Higienis</div>
                            <div class="text-[10px] text-orange-100/80 hidden sm:block">Standar NKV &amp; Halal</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                            💎
                        </div>
                        <div>
                            <div class="font-bold text-[11px] sm:text-xs">Harga Peternak</div>
                            <div class="text-[10px] text-orange-100/80 hidden sm:block">Transparan &amp; Adil</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Header -->
            <div class="flex flex-col sm:flex-row md:flex-col gap-2.5 shrink-0">
                @if(auth()->check() && (auth()->user()->isPeternak() || auth()->user()->isAdmin()))
                <button
                    type="button"
                    onclick="document.getElementById('form-tambah-produk').classList.toggle('hidden')"
                    class="inline-flex items-center justify-center gap-2 text-xs font-bold text-orange-700 bg-white hover:bg-orange-50 px-4 py-2.5 rounded-xl shadow-xs transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>+ Unggah Produk Ternak</span>
                </button>
                @endif
                <a
                    href="{{ route('pesanan') }}"
                    class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-white bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-xs px-4 py-2.5 rounded-xl transition shadow-xs"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                    <span>{{ auth()->check() && auth()->user()->isUmum() ? 'Pantau Pesanan Saya' : 'Daftar Transaksi' }}</span>
                    @if(isset($orderCounts) && $orderCounts['processing'] > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-300 animate-ping"></span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Form Tambah Produk (Collapsible untuk Peternak & Admin) -->
    @if(auth()->check() && (auth()->user()->isPeternak() || auth()->user()->isAdmin()))
    <div id="form-tambah-produk" class="hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Unggah Produk Peternakan Baru</h3>
                <p class="text-xs text-slate-500">Produk akan masuk ke sistem katalog dan ditinjau oleh Admin Dinas sebelum status terverifikasi.</p>
            </div>
            <button
                type="button"
                onclick="document.getElementById('form-tambah-produk').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600 text-xs px-2 py-1 rounded-md"
            >
                ✕ Batal
            </button>
        </div>

        <form action="{{ route('marketplace.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-slate-700 mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Susu Kambing Etawa Segar (1L)" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label class="block font-medium text-slate-700 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                <select name="product_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-slate-700 mb-1">Wilayah Sentra Asal <span class="text-rose-500">*</span></label>
                <select name="region_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
                    @foreach ($regions as $reg)
                        <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-slate-700 mb-1">Harga Satuan (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="price" required min="100" placeholder="Contoh: 25000" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label class="block font-medium text-slate-700 mb-1">Jumlah Stok <span class="text-rose-500">*</span></label>
                <input type="number" name="stock" required min="1" placeholder="Contoh: 50" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label class="block font-medium text-slate-700 mb-1">Satuan Produk <span class="text-rose-500">*</span></label>
                <input type="text" name="unit" required placeholder="Contoh: Botol / Kg / Liter / Ekor" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="md:col-span-2">
                <label class="block font-medium text-slate-700 mb-1">Keterangan Produk &amp; Standar Mutu</label>
                <textarea name="description" rows="2" placeholder="Informasi higienis, pakan ternak alami, sertifikasi Halal / NKV, atau petunjuk penyimpanan dingin..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:ring-2 focus:ring-orange-500"></textarea>
            </div>
            <div class="md:col-span-2 flex justify-end gap-2 pt-2">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-xs transition">
                    Simpan &amp; Publikasikan Produk
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Shopee Filter & Search Engine -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs space-y-4">
        <!-- Quick Category Icons / Pills (Shopee Style) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs no-scrollbar">
            <a
                href="{{ route('marketplace') }}"
                class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ empty($selectedCategory) ? 'bg-orange-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
            >
                <span>🏷️</span>
                <span>Semua Produk</span>
            </a>
            @foreach ($categories as $cat)
                @php
                    $icon = match(true) {
                        str_contains(strtolower($cat->name), 'susu') => '🥛',
                        str_contains(strtolower($cat->name), 'daging') => '🥩',
                        str_contains(strtolower($cat->name), 'pakan') => '🌾',
                        str_contains(strtolower($cat->name), 'bibit') => '🐂',
                        str_contains(strtolower($cat->name), 'telur') => '🥚',
                        str_contains(strtolower($cat->name), 'madu') => '🍯',
                        default => '📦'
                    };
                @endphp
                <a
                    href="{{ route('marketplace', array_merge(request()->query(), ['kategori' => $cat->slug])) }}"
                    class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-medium transition {{ $selectedCategory == $cat->slug ? 'bg-orange-600 text-white shadow-xs font-semibold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                >
                    <span>{{ $icon }}</span>
                    <span>{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>

        <!-- Search Bar & Filters Form -->
        <form action="{{ route('marketplace') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
            @if(!empty($selectedCategory))
                <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
            @endif

            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                <input
                    type="text"
                    name="q"
                    value="{{ $searchQuery }}"
                    placeholder="Cari susu pasteurisasi, daging wagyu, silase pakan..."
                    class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-10 pr-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                >
            </div>

            <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                <select
                    name="wilayah"
                    onchange="this.form.submit()"
                    class="bg-slate-50 border border-slate-200 text-xs rounded-xl py-2.5 px-3 text-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
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
                    class="bg-slate-50 border border-slate-200 text-xs rounded-xl py-2.5 px-3 text-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                >
                    <option value="terbaru" {{ $selectedSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ $selectedSort == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ $selectedSort == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>

                <button
                    type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition shrink-0"
                >
                    Cari Produk
                </button>

                @if(!empty($searchQuery) || !empty($selectedCategory) || !empty($selectedRegion) || !empty($selectedSort))
                <a
                    href="{{ route('marketplace') }}"
                    class="text-xs text-slate-500 hover:text-slate-800 px-2 py-2 shrink-0"
                    title="Reset Filter"
                >
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Product Grid (Shopee Card Layout) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-extrabold text-slate-900 tracking-tight">
                Katalog Produk Peternakan ({{ $products->count() }})
            </h2>
            <span class="text-xs text-slate-500">
                Langsung dari Peternak Binaan Jatim
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse ($products as $product)
            @php
                $catEmoji = match(true) {
                    str_contains(strtolower($product->category?->name ?? ''), 'susu') => '🥛',
                    str_contains(strtolower($product->category?->name ?? ''), 'daging') => '🥩',
                    str_contains(strtolower($product->category?->name ?? ''), 'pakan') => '🌾',
                    str_contains(strtolower($product->category?->name ?? ''), 'bibit') => '🐂',
                    str_contains(strtolower($product->category?->name ?? ''), 'telur') => '🥚',
                    default => '📦'
                };
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-orange-300 shadow-xs hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                <!-- Visual Header Mockup -->
                <div>
                    <div class="relative h-44 bg-gradient-to-br from-slate-100 to-amber-50/60 p-4 flex flex-col justify-between overflow-hidden">
                        <div class="flex items-center justify-between z-10">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-700 bg-white/90 backdrop-blur-xs px-2.5 py-1 rounded-full shadow-2xs border border-slate-200/60">
                                📍 {{ str_replace(['Kabupaten ', 'Kota '], '', $product->region?->name ?? 'Jatim') }}
                            </span>
                            @if($product->is_verified)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                    ✓ Disnak Verified
                                </span>
                            @else
                                <span class="inline-flex items-center text-[10px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                    Menunggu Verifikasi
                                </span>
                            @endif
                        </div>

                        <!-- Product Icon Emblem -->
                        <div class="flex items-center justify-center my-auto transform group-hover:scale-110 transition-transform duration-300">
                            <div class="w-20 h-20 rounded-2xl bg-white shadow-xs border border-slate-100 flex items-center justify-center text-4xl">
                                {{ $catEmoji }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between z-10 text-[11px] text-slate-500">
                            <span class="font-medium bg-white/80 px-2 py-0.5 rounded-md">
                                {{ $product->category?->name ?? 'Ternak' }}
                            </span>
                            <span class="font-medium text-slate-600 bg-white/80 px-2 py-0.5 rounded-md">
                                Stok: <strong class="text-slate-900">{{ $product->stock }}</strong> {{ $product->unit }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 sm:p-5">
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-snug">
                            {{ $product->name }}
                        </h3>

                        <!-- Rating & Sales ala Shopee -->
                        <div class="flex items-center gap-1.5 mt-2 text-xs">
                            <div class="flex items-center text-amber-400">
                                ★★★★★
                            </div>
                            <span class="text-[11px] font-semibold text-slate-700">5.0</span>
                            <span class="text-[11px] text-slate-400">• Terjual 100+</span>
                        </div>

                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>

                        <!-- Seller Info -->
                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-600">
                            <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-700 font-bold flex items-center justify-center text-[10px] shrink-0">
                                👨‍🌾
                            </div>
                            <span class="truncate font-medium">{{ $product->seller?->name ?? 'Peternak Binaan' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer (Price & Action) -->
                <div class="p-4 sm:p-5 pt-0">
                    <div class="pt-3 border-t border-slate-100 flex items-end justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-medium text-slate-400 block">Harga Peternak</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-base sm:text-lg font-extrabold text-orange-600 tabular-nums">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-medium text-slate-400">/ {{ $product->unit }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                @if(!$product->is_verified)
                                <form action="{{ route('marketplace.products.verify', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                                        Verifikasi
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('marketplace.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }} dari marketplace?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            @else
                                <!-- Button Beli Sekarang ala Shopee -->
                                <button
                                    type="button"
                                    onclick="openBuyModal('{{ $product->id }}')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl transition shadow-xs hover:shadow"
                                >
                                    <span>Beli Sekarang</span>
                                </button>

                                @if(auth()->check() && auth()->id() === $product->user_id)
                                <form action="{{ route('marketplace.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }} milik Anda?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Hapus Produk Saya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Checkout Shopee Interaktif -->
                <div id="buy-modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
                    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl border border-slate-200">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">🛍️</span>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Checkout Transaksi Belanja</h3>
                                    <p class="text-xs text-slate-500">Pasar Peternak Milenial Jawa Timur</p>
                                </div>
                            </div>
                            <button
                                type="button"
                                onclick="closeBuyModal('{{ $product->id }}')"
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold transition"
                            >
                                ✕
                            </button>
                        </div>

                        <!-- Product Summary Card -->
                        <div class="p-3.5 bg-orange-50/60 rounded-xl border border-orange-100 mb-4 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white border border-orange-200 flex items-center justify-center text-2xl shrink-0">
                                    {{ $catEmoji }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $product->name }}</h4>
                                    <div class="text-[11px] text-slate-500 mt-0.5">Penjual: {{ $product->seller?->name ?? 'Peternak Binaan' }} • {{ $product->region?->name ?? 'Jatim' }}</div>
                                    <div class="font-extrabold text-orange-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit }}</div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('marketplace.products.buy', $product) }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            
                            <!-- Counter Kuantitas Interaktif -->
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">
                                    Jumlah Pembelian (Tersedia: {{ $product->stock }} {{ $product->unit }}) <span class="text-rose-500">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                                        <button
                                            type="button"
                                            onclick="decrementQty('{{ $product->id }}', {{ $product->price }})"
                                            class="px-3 py-2 text-slate-600 hover:bg-slate-200 font-bold transition"
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
                                            class="w-16 text-center border-0 bg-transparent text-xs font-bold text-slate-900 focus:ring-0 p-2"
                                        >
                                        <button
                                            type="button"
                                            onclick="incrementQty('{{ $product->id }}', {{ $product->stock }}, {{ $product->price }})"
                                            class="px-3 py-2 text-slate-600 hover:bg-slate-200 font-bold transition"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <span class="text-slate-500">{{ $product->unit }}</span>
                                </div>
                            </div>

                            <!-- Form Penerima -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Nama Penerima <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        name="buyer_name"
                                        required
                                        value="{{ auth()->user()?->name ?? '' }}"
                                        placeholder="Nama lengkap Anda"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-orange-500"
                                    >
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        name="buyer_phone"
                                        required
                                        value="{{ auth()->user()?->phone_number ?? '' }}"
                                        placeholder="Contoh: 08123456789"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-orange-500"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Alamat Pengiriman di Jawa Timur <span class="text-rose-500">*</span></label>
                                <textarea
                                    name="shipping_address"
                                    required
                                    rows="2"
                                    placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-orange-500"
                                >{{ auth()->user() && auth()->user()->desa ? auth()->user()->desa . ', Kec. ' . auth()->user()->kecamatan . ', ' . auth()->user()->kabupaten : '' }}</textarea>
                            </div>

                            <!-- Pilihan Metode Pembayaran ala Shopee -->
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1.5">Metode Pembayaran</label>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:border-orange-300">
                                        <input type="radio" name="payment_method" value="QRIS Instan" checked class="text-orange-600 focus:ring-orange-500">
                                        <span>📲 QRIS Instan</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:border-orange-300">
                                        <input type="radio" name="payment_method" value="Virtual Account Bank" class="text-orange-600 focus:ring-orange-500">
                                        <span>🏦 VA Bank Jatim / BCA</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:border-orange-300">
                                        <input type="radio" name="payment_method" value="COD Bayar di Tempat" class="text-orange-600 focus:ring-orange-500">
                                        <span>💵 COD (Bayar di Tempat)</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:border-orange-300">
                                        <input type="radio" name="payment_method" value="Escrow Bersama Disnak" class="text-orange-600 focus:ring-orange-500">
                                        <span>🛡️ Rekening Escrow Disnak</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Catatan Pesanan (Opsional)</label>
                                <input
                                    type="text"
                                    name="notes"
                                    placeholder="Contoh: Kemas dengan ice gel dingin / kirim sebelum siang"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-orange-500"
                                >
                            </div>

                            <!-- Ringkasan Tagihan Real-time -->
                            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 text-xs">
                                <div class="flex justify-between text-slate-600">
                                    <span>Subtotal Produk:</span>
                                    <span id="modal-subtotal-{{ $product->id }}" class="font-semibold text-slate-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-slate-600">
                                    <span>Ongkos Kirim (Jatim):</span>
                                    <span class="font-semibold text-emerald-600">GRATIS (Subsidi Disnak)</span>
                                </div>
                                <div class="pt-2 border-t border-slate-200 flex justify-between items-baseline font-extrabold">
                                    <span class="text-slate-900">Total Pembayaran:</span>
                                    <span id="modal-total-{{ $product->id }}" class="text-base text-orange-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2.5 pt-2">
                                <button
                                    type="button"
                                    onclick="closeBuyModal('{{ $product->id }}')"
                                    class="px-4 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-5 py-2.5 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl shadow-xs transition"
                                >
                                    Konfirmasi &amp; Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 px-4 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-orange-50 border border-orange-100 flex items-center justify-center text-3xl mb-3 shadow-2xs">
                    🛒
                </div>
                <h3 class="text-sm font-bold text-slate-800">Tidak ada produk ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Coba sesuaikan kata kunci pencarian atau pilih filter wilayah dan kategori komoditas lainnya.
                </p>
                <a href="{{ route('marketplace') }}" class="inline-block mt-4 px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-semibold">
                    Lihat Semua Produk
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Section Manajemen Produk (Khusus Admin & Peternak) -->
    @if(auth()->check() && (auth()->user()->isPeternak() || auth()->user()->isAdmin()))
    <div id="toko" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="pb-3 border-b border-slate-100 mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">
                    {{ auth()->user()->isAdmin() ? 'Manajemen & Verifikasi Produk Peternak (Database)' : 'Daftar Produk Peternakan Saya (Database)' }}
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ auth()->user()->isAdmin() ? 'Daftar seluruh produk peternakan yang masuk dari peternak dan status verifikasi Dinas.' : 'Status verifikasi produk yang Anda ajukan. Produk yang disetujui akan tayang di marketplace publik.' }}
                </p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
                Total: {{ $myProducts->count() }} Produk
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-600">
                <thead class="text-[11px] text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-3.5 py-2.5">Nama Produk</th>
                        <th scope="col" class="px-3.5 py-2.5">Kategori / Wilayah</th>
                        @if(auth()->user()->isAdmin())
                        <th scope="col" class="px-3.5 py-2.5">Peternak</th>
                        @endif
                        <th scope="col" class="px-3.5 py-2.5">Harga &amp; Stok</th>
                        <th scope="col" class="px-3.5 py-2.5">Status Verifikasi</th>
                        <th scope="col" class="px-3.5 py-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($myProducts as $prod)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-3.5 py-2.5 font-bold text-slate-900">{{ $prod->name }}</td>
                        <td class="px-3.5 py-2.5">
                            <div>{{ $prod->category?->name ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400">{{ $prod->region?->name ?? 'Jawa Timur' }}</div>
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-3.5 py-2.5 font-medium text-slate-800">
                            {{ $prod->seller?->name ?? 'Peternak' }}
                        </td>
                        @endif
                        <td class="px-3.5 py-2.5">
                            <span class="font-semibold text-slate-900">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                            <div class="text-[10px] text-slate-500">Stok: {{ $prod->stock }} {{ $prod->unit }}</div>
                        </td>
                        <td class="px-3.5 py-2.5">
                            @if ($prod->is_verified)
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                    ✓ Terverifikasi / Dipublikasikan
                                </span>
                            @else
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                    Menunggu Verifikasi Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-3.5 py-2.5 text-right space-x-1">
                            @if(auth()->user()->isAdmin() && ! $prod->is_verified)
                                <form action="{{ route('marketplace.products.verify', $prod) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2.5 py-1 rounded-lg transition shadow-xs">
                                        Setujui &amp; Publikasi
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('marketplace.products.destroy', $prod) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini dari database?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-[10px] font-semibold px-2 py-1 rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="px-3.5 py-6 text-center text-slate-400">
                            {{ auth()->user()->isAdmin() ? 'Belum ada produk yang diunggah oleh peternak di database.' : 'Belum ada produk yang Anda daftarkan di database.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
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

@extends('layouts.app')

@section('title', 'Pesanan Saya — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-4 sm:space-y-5">
    <!-- Breadcrumb & Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/80">
        <div>
            <nav class="flex items-center gap-1.5 text-[11px] sm:text-xs text-slate-500 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition">Dashboard</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('marketplace') }}" class="hover:text-slate-900 transition">Marketplace</a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 font-semibold">
                    {{ auth()->check() && auth()->user()->isPeternak() ? 'Pesanan Masuk' : 'Pesanan Saya' }}
                </span>
            </nav>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                @if(auth()->check() && auth()->user()->isPeternak())
                    Pesanan Masuk dari Masyarakat
                @elseif(auth()->check() && auth()->user()->isUmum())
                    Pesanan Saya
                @else
                    Semua Transaksi Pesanan
                @endif
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                @if(auth()->check() && auth()->user()->isPeternak())
                    Kelola alur pemrosesan pesanan dan pantau seluruh transaksi pembelian komoditas ternak yang masuk dari masyarakat.
                @elseif(auth()->check() && auth()->user()->isUmum())
                    Pantau status pengiriman, rincian biaya, dan riwayat belanja produk peternakan Anda secara real-time.
                @else
                    Kelola alur pemrosesan pesanan dan pantau seluruh transaksi langsung dari masyarakat pembeli.
                @endif
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if(auth()->check() && auth()->user()->isPeternak())
                <a
                    href="{{ route('marketplace') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200/80 px-3 py-1.5 rounded-lg transition shadow-2xs"
                >
                    <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <span>Kelola Produk Peternakan</span>
                </a>
            @else
                <a
                    href="{{ route('marketplace') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200/80 px-3 py-1.5 rounded-lg transition shadow-2xs"
                >
                    <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Belanja Produk Ternak</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Quick Metrics Overview -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5">
        <div class="p-3 sm:p-3.5 bg-white rounded-xl border border-slate-200/90 shadow-2xs">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">
                {{ auth()->check() && auth()->user()->isPeternak() ? 'Total Pesanan Masuk' : 'Total Pesanan' }}
            </span>
            <div class="mt-1 flex items-baseline justify-between">
                <span class="text-lg sm:text-xl font-bold text-slate-900 tabular-nums">{{ $orderCounts['all'] }}</span>
                <span class="text-[11px] text-slate-400">
                    {{ auth()->check() && auth()->user()->isPeternak() ? 'Dari masyarakat' : 'Semua riwayat' }}
                </span>
            </div>
        </div>

        <div class="p-3 sm:p-3.5 bg-white rounded-xl border border-slate-200/90 shadow-2xs">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">
                {{ auth()->check() && auth()->user()->isPeternak() ? 'Perlu Diproses' : 'Sedang Diproses' }}
            </span>
            <div class="mt-1 flex items-baseline justify-between">
                <span class="text-lg sm:text-xl font-bold text-sky-700 tabular-nums">{{ $orderCounts['processing'] + $orderCounts['pending'] }}</span>
                <span class="text-[11px] text-sky-600 font-medium">Pengemasan</span>
            </div>
        </div>

        <div class="p-3 sm:p-3.5 bg-white rounded-xl border border-slate-200/90 shadow-2xs">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Dalam Pengiriman</span>
            <div class="mt-1 flex items-baseline justify-between">
                <span class="text-lg sm:text-xl font-bold text-indigo-700 tabular-nums">{{ $orderCounts['shipped'] }}</span>
                <span class="text-[11px] text-indigo-600 font-medium">Kurir dingin</span>
            </div>
        </div>

        <div class="p-3 sm:p-3.5 bg-white rounded-xl border border-slate-200/90 shadow-2xs">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">
                {{ auth()->check() && auth()->user()->isPeternak() ? 'Selesai Terkirim' : 'Selesai Diterima' }}
            </span>
            <div class="mt-1 flex items-baseline justify-between">
                <span class="text-lg sm:text-xl font-bold text-emerald-700 tabular-nums">{{ $orderCounts['completed'] }}</span>
                <span class="text-[11px] text-emerald-600 font-medium">Transaksi tuntas</span>
            </div>
        </div>
    </div>

    <!-- Main Orders Container -->
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Filter Tabs & Search Bar -->
        <div class="px-3.5 py-2.5 sm:px-4 sm:py-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
            <!-- Filter Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 text-xs no-scrollbar">
                <button
                    type="button"
                    onclick="filterOrders('all', this)"
                    class="order-tab-btn active px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-white transition shrink-0 flex items-center gap-1.5 shadow-2xs"
                >
                    <span>Semua</span>
                    <span class="px-1.5 py-0.2 rounded bg-white/20 text-[10px] tabular-nums">{{ $orderCounts['all'] }}</span>
                </button>
                <button
                    type="button"
                    onclick="filterOrders('pending', this)"
                    class="order-tab-btn px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0 flex items-center gap-1.5"
                >
                    <span>Menunggu</span>
                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] tabular-nums">{{ $orderCounts['pending'] }}</span>
                </button>
                <button
                    type="button"
                    onclick="filterOrders('processing', this)"
                    class="order-tab-btn px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0 flex items-center gap-1.5"
                >
                    <span>Diproses</span>
                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] tabular-nums">{{ $orderCounts['processing'] }}</span>
                </button>
                <button
                    type="button"
                    onclick="filterOrders('shipped', this)"
                    class="order-tab-btn px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0 flex items-center gap-1.5"
                >
                    <span>Dikirim</span>
                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] tabular-nums">{{ $orderCounts['shipped'] }}</span>
                </button>
                <button
                    type="button"
                    onclick="filterOrders('completed', this)"
                    class="order-tab-btn px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0 flex items-center gap-1.5"
                >
                    <span>Selesai</span>
                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] tabular-nums">{{ $orderCounts['completed'] }}</span>
                </button>
                <button
                    type="button"
                    onclick="filterOrders('cancelled', this)"
                    class="order-tab-btn px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0 flex items-center gap-1.5"
                >
                    <span>Dibatalkan</span>
                    <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] tabular-nums">{{ $orderCounts['cancelled'] }}</span>
                </button>
            </div>

            <!-- Quick Search Input -->
            <form action="{{ route('pesanan') }}" method="GET" class="relative w-full sm:w-56 md:w-64">
                <input
                    type="text"
                    name="q"
                    value="{{ $searchQuery ?? '' }}"
                    placeholder="Cari nomor pesanan / produk..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-7 pr-3 py-1.5 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-500 transition"
                >
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </form>
        </div>

        <!-- Orders List Body -->
        <div class="p-4 sm:p-5">
            @if($orders->isEmpty())
                @if(!auth()->check())
                <!-- Guest View: Prompt to Login -->
                <div class="py-12 px-4 text-center max-w-md mx-auto">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Masuk untuk Memantau Pesanan</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-5">
                        Silakan masuk ke akun Anda untuk melihat riwayat belanja, melacak status pengiriman, dan rincian transaksi produk peternakan.
                    </p>
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                            Masuk ke Akun
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
                @else
                <!-- Authenticated Empty State -->
                <div class="py-12 px-4 text-center max-w-md mx-auto">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">
                        {{ auth()->check() && auth()->user()->isPeternak() ? 'Belum Ada Pesanan Masuk' : 'Belum Ada Riwayat Pesanan' }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 mb-4">
                        @if(auth()->check() && auth()->user()->isPeternak())
                            Pesanan komoditas hasil ternak yang dibeli oleh masyarakat akan masuk dan dapat Anda proses di sini.
                        @elseif(auth()->check() && auth()->user()->isUmum())
                            Pesanan produk peternakan yang Anda beli langsung dari peternak Jawa Timur akan tercatat dan dapat dipantau di sini.
                        @else
                            Belum ada transaksi pesanan yang masuk ke akun Anda saat ini.
                        @endif
                    </p>
                    <a href="{{ route('marketplace') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold rounded-lg transition">
                        <span>{{ auth()->check() && auth()->user()->isPeternak() ? 'Kelola Produk Peternakan' : 'Jelajahi Katalog Marketplace' }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
                @endif
            @else
                <!-- Compact Order List -->
                <div class="space-y-2.5">
                    @foreach ($orders as $order)
                    @php
                        $firstItem = $order->items->first();
                        $totalItemCount = $order->items->sum('quantity');
                        $itemVarietyCount = $order->items->count();
                    @endphp
                    <div
                        class="order-card group bg-white border border-slate-200/90 hover:border-slate-300 rounded-xl p-3 sm:p-3.5 transition-all duration-150 hover:shadow-xs cursor-pointer flex flex-col gap-2.5"
                        data-status="{{ $order->status }}"
                        data-order-code="{{ $order->order_code }}"
                        onclick="openOrderDetail('{{ $order->order_code }}')"
                        role="button"
                        tabindex="0"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { openOrderDetail('{{ $order->order_code }}'); event.preventDefault(); }"
                        aria-label="Lihat rincian pesanan nomor {{ $order->order_code }}"
                    >
                        <!-- Top Meta Row: Status Badge, Order ID, Date, Seller Name -->
                        <div class="flex items-center justify-between gap-2.5 flex-wrap">
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- Status Badge: Refined, non-jarring tonal pill -->
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold border {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>

                                <span class="font-mono text-xs font-bold text-slate-900 tracking-tight">
                                    {{ $order->order_code }}
                                </span>

                                <span class="text-slate-300 text-xs hidden sm:inline">·</span>

                                <span class="text-[11px] sm:text-xs text-slate-500">
                                    {{ $order->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </div>

                            <div class="text-[11px] font-medium">
                                @if(auth()->check() && auth()->user()->isPeternak())
                                    <span class="inline-flex items-center gap-1.5 text-slate-800 font-semibold bg-emerald-50 text-emerald-900 px-2.5 py-1 rounded-md border border-emerald-200/80">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        <span>Pemesan: <strong class="text-slate-900 font-bold">{{ $order->buyer?->name ?? 'Masyarakat Pembeli' }}</strong></span>
                                        <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-1.5 py-0.2 rounded">Masyarakat</span>
                                        @if($order->buyer_phone)
                                            <span class="text-emerald-700 bg-white px-1.5 py-0.2 rounded border border-emerald-200/80 font-mono text-[10px]">📱 {{ $order->buyer_phone }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-slate-500">
                                        {{ $firstItem?->seller?->name ?? 'Peternak Binaan Jatim' }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Middle Content Row: Product Thumbnail, Summary & Total Price -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pt-2 border-t border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                <!-- Thumbnail Preview -->
                                <div class="w-11 h-11 rounded-lg bg-slate-50 border border-slate-200/80 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if($firstItem?->product?->image_path)
                                        <img src="{{ asset('storage/' . $firstItem->product->image_path) }}" alt="{{ $firstItem->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Info & Summary -->
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs sm:text-[13px] font-semibold text-slate-900 truncate">
                                        @if($itemVarietyCount === 1)
                                            {{ $firstItem?->product?->name ?? 'Produk Peternakan' }}
                                        @else
                                            {{ $firstItem?->product?->name ?? 'Produk Peternakan' }}
                                            <span class="font-normal text-slate-500 text-xs">+ {{ $itemVarietyCount - 1 }} produk lainnya</span>
                                        @endif
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        {{ $totalItemCount }} produk · <span class="font-medium text-slate-700 tabular-nums">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </p>
                                    @if(auth()->check() && auth()->user()->isPeternak() && $order->shipping_address)
                                        <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1 truncate">
                                            <span class="text-slate-400">📍 Kirim:</span>
                                            <span class="text-slate-700 font-medium truncate">{{ $order->shipping_address }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Total Payment Box -->
                            <div class="sm:text-right shrink-0">
                                <span class="text-[10px] text-slate-400 block font-medium">
                                    {{ auth()->check() && auth()->user()->isPeternak() ? 'Nilai Pesanan' : 'Total Pembayaran' }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 tabular-nums">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Bottom Action Row: "Lihat Detail →" & Contextual Action Buttons -->
                        <div class="flex items-center justify-between gap-3 pt-1.5 border-t border-slate-100/80 text-xs">
                            <div class="inline-flex items-center gap-1.5 text-primary-700 group-hover:text-primary-800 font-semibold transition">
                                <span>Lihat Detail</span>
                                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>

                            <!-- Direct Status Action Buttons -->
                            <div class="flex items-center gap-1.5" onclick="event.stopPropagation()">
                                @if(auth()->check() && auth()->user()->isPeternak())
                                    @if($order->status === 'pending')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2.5 py-1 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-lg transition shadow-2xs">
                                                Proses &amp; Kemas
                                            </button>
                                        </form>
                                    @elseif($order->status === 'confirmed' || $order->status === 'processing')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="shipped">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition shadow-2xs">
                                                Kirim Pesanan
                                            </button>
                                        </form>
                                    @elseif($order->status === 'shipped')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi bahwa pesanan nomor {{ $order->order_code }} sudah sampai ke pembeli?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition shadow-2xs">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @elseif($order->status === 'completed')
                                        <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-md">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            Pesanan Selesai
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium">Dibatalkan</span>
                                    @endif

                                    @if(!in_array($order->status, ['completed', 'cancelled']))
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan nomor {{ $order->order_code }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition">
                                                Batal
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                        <!-- Konfirmasi Pesanan Diterima (Untuk Pembeli Masyarakat) -->
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi bahwa pesanan nomor {{ $order->order_code }} sudah Anda terima dengan baik?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition shadow-2xs">
                                                Pesanan Diterima
                                            </button>
                                        </form>

                                        <!-- Batalkan Pesanan (Jika belum dikirim/selesai) -->
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan nomor {{ $order->order_code }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg transition">
                                                Batal
                                            </button>
                                        </form>
                                    @elseif($order->status === 'completed')
                                        <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-md">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            Pesanan Selesai
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium">Dibatalkan</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Pre-Rendered Full Detail Data for this Order -->
                    <div id="order-detail-data-{{ $order->order_code }}" class="hidden">
                        <div class="space-y-3.5">
                            <!-- Status Header & Timeline Card -->
                            <div class="p-3.5 rounded-xl border border-slate-200/90 bg-slate-50/70">
                                <div class="flex items-center justify-between gap-3 mb-1.5">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status Pesanan</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold border {{ $order->status_badge_class }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed mb-3">
                                    {{ $order->status_description }}
                                </p>

                                @if($order->status !== 'cancelled')
                                <!-- Minimalist 5-Step Order Stepper -->
                                <div class="pt-2.5 border-t border-slate-200/70">
                                    @php
                                        $currStep = $order->status_step_index;
                                        $steps = [
                                            1 => 'Dipesan',
                                            2 => 'Terbayar',
                                            3 => 'Dikemas',
                                            4 => 'Dikirim',
                                            5 => 'Selesai',
                                        ];
                                    @endphp
                                    <div class="grid grid-cols-5 gap-1 text-center">
                                        @foreach($steps as $sIdx => $sLabel)
                                        @php
                                            $isDone = $sIdx <= $currStep;
                                            $isCurrent = $sIdx === $currStep;
                                        @endphp
                                        <div class="flex flex-col items-center">
                                            <!-- Step Dot / Icon -->
                                            <div class="w-5.5 h-5.5 rounded-full flex items-center justify-center text-[10px] font-bold mb-1 transition {{ $isDone ? ($order->status === 'completed' ? 'bg-emerald-600 text-white' : 'bg-primary-700 text-white') : 'bg-slate-200 text-slate-500' }}">
                                                @if($isDone && $sIdx < $currStep)
                                                    ✓
                                                @else
                                                    {{ $sIdx }}
                                                @endif
                                            </div>
                                            <!-- Step Label -->
                                            <span class="text-[10px] font-medium leading-tight {{ $isCurrent ? 'text-slate-900 font-bold' : ($isDone ? 'text-slate-700' : 'text-slate-400') }}">
                                                {{ $sLabel }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-200/80 text-rose-700 text-xs">
                                    Pesanan ini telah dibatalkan. Tidak ada penagihan atau proses pengiriman lanjutan untuk transaksi ini.
                                </div>
                                @endif
                            </div>

                            <!-- Produk yang Dipesan (Line Items) -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">
                                        Produk yang Dipesan ({{ $order->items->count() }})
                                    </h4>
                                    <span class="text-[10px] text-slate-500 font-medium">
                                        {{ $order->items->sum('quantity') }} total item
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    @foreach($order->items as $item)
                                    <div class="p-3 rounded-xl border border-slate-200/90 bg-white flex items-start justify-between gap-2.5">
                                        <div class="flex items-start gap-2.5 min-w-0">
                                            <div class="w-11 h-11 rounded-lg bg-slate-100 border border-slate-200/80 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($item->product?->image_path)
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <h5 class="text-xs font-bold text-slate-900 leading-snug">
                                                    {{ $item->product?->name ?? 'Produk Peternakan' }}
                                                </h5>
                                                <div class="flex items-center gap-1.5 mt-0.5 text-[11px] text-slate-500 flex-wrap">
                                                    <span>{{ $item->quantity }} {{ $item->product?->unit ?? 'unit' }}</span>
                                                    <span>×</span>
                                                    <span class="tabular-nums">Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</span>
                                                    @if($item->product?->category)
                                                        <span class="px-1.5 py-0.2 bg-slate-100 rounded text-[10px] text-slate-600 font-medium">
                                                            {{ $item->product->category->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-slate-400 mt-0.5">
                                                    @if(auth()->check() && auth()->user()->isPeternak())
                                                        <span class="text-emerald-700 font-medium">✓ Produk dari Peternakan Anda</span>
                                                    @else
                                                        Peternak: {{ $item->seller?->name ?? 'Mitra Binaan Jatim' }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right shrink-0">
                                            <span class="text-xs font-bold text-slate-900 tabular-nums">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Informasi Pengiriman & Penerima -->
                            <div class="p-3.5 rounded-xl border border-slate-200/90 bg-white">
                                <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider mb-2.5">
                                    Informasi Penerima &amp; Alamat
                                </h4>
                                <div class="space-y-2 text-xs text-slate-600">
                                    <div class="flex items-start justify-between gap-2.5">
                                        <span class="text-slate-400 w-24 shrink-0">Penerima</span>
                                        <span class="font-semibold text-slate-900 text-right flex-1">
                                            {{ $order->buyer?->name ?? 'Pembeli Umum' }}
                                        </span>
                                    </div>

                                    <div class="flex items-start justify-between gap-2.5">
                                        <span class="text-slate-400 w-24 shrink-0">No. HP</span>
                                        <span class="font-mono text-slate-800 text-right flex-1">
                                            {{ $order->buyer_phone ?: ($order->buyer?->phone_number ?: '-') }}
                                        </span>
                                    </div>

                                    <div class="flex items-start justify-between gap-2.5">
                                        <span class="text-slate-400 w-24 shrink-0">Alamat Kirim</span>
                                        <span class="text-slate-800 text-right flex-1 leading-relaxed">
                                            {{ $order->shipping_address }}
                                        </span>
                                    </div>

                                    @if($order->clean_notes)
                                    <div class="flex items-start justify-between gap-2.5 pt-1.5 border-t border-slate-100">
                                        <span class="text-slate-400 w-24 shrink-0">Catatan</span>
                                        <span class="text-slate-700 italic text-right flex-1">
                                            "{{ $order->clean_notes }}"
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Rincian Biaya & Pembayaran -->
                            <div class="p-3.5 rounded-xl border border-slate-200/90 bg-white">
                                <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider mb-2">
                                    Rincian Pembayaran
                                </h4>
                                <div class="space-y-1.5 text-xs">
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Subtotal Produk</span>
                                        <span class="font-medium text-slate-900 tabular-nums">
                                            Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Ongkos Kirim (Logistik Jatim)</span>
                                        <span class="text-emerald-600 font-medium">
                                            Gratis
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Biaya Layanan &amp; Penanganan</span>
                                        <span class="text-emerald-600 font-medium">
                                            Gratis
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Metode Pembayaran</span>
                                        <span class="font-medium text-slate-800">
                                            {{ $order->parsed_payment_method }}
                                        </span>
                                    </div>

                                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between">
                                        <div>
                                            <span class="text-xs font-bold text-slate-900 block">Total Pembayaran</span>
                                            <span class="text-[10px] text-slate-400">Termasuk PPN &amp; subsidi logistik</span>
                                        </div>
                                        <span class="text-sm sm:text-base font-bold text-slate-900 tabular-nums">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pihak Terkait & Verifikasi -->
                            <div class="p-3 rounded-xl border border-slate-200/90 bg-slate-50/50 flex items-center justify-between gap-3 text-xs">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">
                                        {{ auth()->check() && auth()->user()->isPeternak() ? 'Masyarakat Pembeli' : 'Penjual / Peternak Binaan' }}
                                    </span>
                                    <span class="font-bold text-slate-900 text-xs">
                                        {{ auth()->check() && auth()->user()->isPeternak() ? ($order->buyer?->name ?? 'Masyarakat Pembeli') : ($firstItem?->seller?->name ?? 'Peternak Milenial Jatim') }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 block">
                                        {{ auth()->check() && auth()->user()->isPeternak() ? ($order->buyer_phone ?: ($order->buyer?->phone_number ?: 'Jawa Timur')) : ($firstItem?->product?->region?->name ?? 'Jawa Timur') }}
                                    </span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold shrink-0">
                                    {{ auth()->check() && auth()->user()->isPeternak() ? '👤 Pemesan Terdaftar' : '✓ Binaan Resmi' }}
                                </span>
                            </div>

                            <!-- Drawer Contextual Action Buttons in Source -->
                            <div class="pt-1.5 border-t border-slate-200 flex flex-col sm:flex-row items-center gap-2">
                                @if(auth()->check() && auth()->user()->isPeternak())
                                    @if($order->status === 'pending')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition shadow-xs flex items-center justify-center gap-1.5">
                                                <span>Proses &amp; Kemas Pesanan</span>
                                            </button>
                                        </form>
                                    @elseif($order->status === 'confirmed' || $order->status === 'processing')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="shipped">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition shadow-xs flex items-center justify-center gap-1.5">
                                                <span>Kirim Pesanan ke Kurir</span>
                                            </button>
                                        </form>
                                    @elseif($order->status === 'shipped')
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:flex-1" onsubmit="return confirm('Konfirmasi bahwa pesanan sudah sampai ke pembeli?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-xs flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                <span>Konfirmasi Pesanan Telah Diterima</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(!in_array($order->status, ['completed', 'cancelled']))
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full sm:w-auto px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                        <!-- Konfirmasi Pesanan Diterima Form -->
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:flex-1" onsubmit="return confirm('Konfirmasi bahwa pesanan ini sudah Anda terima dengan baik?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-xs flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                <span>Konfirmasi Pesanan Diterima</span>
                                            </button>
                                        </form>

                                        <!-- Batalkan Pesanan Form -->
                                        <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <input type="hidden" name="from" value="pesanan">
                                            <button type="submit" class="w-full sm:w-auto px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <button
                                    type="button"
                                    onclick="printOrderInvoice('{{ $order->order_code }}')"
                                    class="w-full sm:w-auto px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-medium rounded-lg transition flex items-center justify-center gap-1.5"
                                >
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-3.279 2.135-6.079 5.28-6.079s5.52 2.8 5.28 6.079M6.75 6.75h10.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 002.25 10.5v6.75A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                    <span>Cetak Bukti Transaksi</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Slide-Over Drawer: Detail Pesanan Lengkap -->
    <div id="order-drawer-backdrop" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden transition-opacity duration-200" onclick="closeOrderDetail()" aria-hidden="true"></div>

    <aside
        id="order-drawer"
        class="fixed inset-y-0 right-0 z-50 w-full sm:max-w-md md:max-w-lg bg-white shadow-2xl border-l border-slate-200 flex flex-col transform translate-x-full transition-transform duration-300 ease-out"
        role="dialog"
        aria-modal="true"
        aria-labelledby="drawer-title"
    >
        <!-- Drawer Header -->
        <div class="px-4.5 py-3 border-b border-slate-200 flex items-center justify-between gap-3 bg-white sticky top-0 z-10">
            <div>
                <h3 id="drawer-title" class="text-sm font-bold text-slate-900">
                    Detail Pesanan
                </h3>
                <div class="flex items-center gap-2 mt-0.5">
                    <span id="drawer-order-code" class="font-mono text-xs font-semibold text-slate-700"></span>
                    <button
                        type="button"
                        id="drawer-copy-btn"
                        onclick="copyCurrentOrderCode(this)"
                        class="text-[11px] font-semibold text-primary-700 hover:text-primary-800 transition inline-flex items-center gap-1"
                        title="Salin nomor pesanan"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                        <span id="drawer-copy-label">Salin</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="button"
                    onclick="closeOrderDetail()"
                    class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition"
                    aria-label="Tutup detail pesanan"
                >
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Drawer Scrollable Body Content -->
        <div id="drawer-body-content" class="p-4 sm:p-4.5 overflow-y-auto flex-1 custom-scrollbar">
            <!-- Content dynamically injected from selected order template -->
        </div>

        <!-- Drawer Footer -->
        <div class="px-4.5 py-2.5 border-t border-slate-100 bg-slate-50 flex items-center justify-between text-xs">
            <span class="text-slate-400 text-[10px]">Tekan <kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 text-slate-600 font-mono text-[10px]">ESC</kbd> untuk menutup</span>
            <button
                type="button"
                onclick="closeOrderDetail()"
                class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-medium rounded-lg transition"
            >
                Tutup
            </button>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
<script>
let currentActiveOrderCode = null;

function openOrderDetail(orderCode) {
    const sourceEl = document.getElementById(`order-detail-data-${orderCode}`);
    const drawerEl = document.getElementById('order-drawer');
    const backdropEl = document.getElementById('order-drawer-backdrop');
    const bodyContentEl = document.getElementById('drawer-body-content');
    const codeEl = document.getElementById('drawer-order-code');

    if (!sourceEl || !drawerEl || !backdropEl || !bodyContentEl) {
        console.warn(`Order data not found for code: ${orderCode}`);
        return;
    }

    currentActiveOrderCode = orderCode;
    bodyContentEl.innerHTML = sourceEl.innerHTML;
    if (codeEl) codeEl.textContent = orderCode;

    // Reset copy button state
    const copyLabel = document.getElementById('drawer-copy-label');
    if (copyLabel) copyLabel.textContent = 'Salin';

    // Show backdrop
    backdropEl.classList.remove('hidden');

    // Slide drawer in
    drawerEl.classList.remove('translate-x-full');
    drawerEl.classList.add('translate-x-0');

    // Prevent background scrolling
    document.body.classList.add('overflow-hidden');

    // Update URL hash without jumping
    try {
        if (history.replaceState) {
            history.replaceState(null, null, `#order-${encodeURIComponent(orderCode)}`);
        }
    } catch (e) {}
}

function closeOrderDetail() {
    const drawerEl = document.getElementById('order-drawer');
    const backdropEl = document.getElementById('order-drawer-backdrop');

    if (drawerEl) {
        drawerEl.classList.remove('translate-x-0');
        drawerEl.classList.add('translate-x-full');
    }

    if (backdropEl) {
        backdropEl.classList.add('hidden');
    }

    document.body.classList.remove('overflow-hidden');
    currentActiveOrderCode = null;

    try {
        if (history.replaceState) {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }
    } catch (e) {}
}

function copyCurrentOrderCode(btnElem) {
    if (!currentActiveOrderCode) return;

    const codeToCopy = currentActiveOrderCode;
    const labelElem = document.getElementById('drawer-copy-label');

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(codeToCopy).then(() => {
            if (labelElem) labelElem.textContent = 'Tersalin!';
            setTimeout(() => {
                if (labelElem) labelElem.textContent = 'Salin';
            }, 2000);
        }).catch(() => {
            fallbackCopy(codeToCopy, labelElem);
        });
    } else {
        fallbackCopy(codeToCopy, labelElem);
    }
}

function fallbackCopy(text, labelElem) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    try {
        document.execCommand('copy');
        if (labelElem) labelElem.textContent = 'Tersalin!';
        setTimeout(() => {
            if (labelElem) labelElem.textContent = 'Salin';
        }, 2000);
    } catch (err) {}
    document.body.removeChild(tempInput);
}

function printOrderInvoice(orderCode) {
    if (orderCode && orderCode !== currentActiveOrderCode) {
        openOrderDetail(orderCode);
    }
    setTimeout(() => {
        window.print();
    }, 250);
}

function filterOrders(status, buttonElem) {
    // Toggle active tab style with clean slate-900 / neutral design
    document.querySelectorAll('.order-tab-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-slate-900', 'text-white', 'font-semibold');
        btn.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100', 'font-medium');
        const badge = btn.querySelector('span:last-child');
        if (badge) {
            badge.classList.remove('bg-white/20', 'text-white');
            badge.classList.add('bg-slate-100', 'text-slate-600');
        }
    });

    buttonElem.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100', 'font-medium');
    buttonElem.classList.add('active', 'bg-slate-900', 'text-white', 'font-semibold');
    const activeBadge = buttonElem.querySelector('span:last-child');
    if (activeBadge) {
        activeBadge.classList.remove('bg-slate-100', 'text-slate-600');
        activeBadge.classList.add('bg-white/20', 'text-white');
    }

    const cards = document.querySelectorAll('.order-card');
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        if (status === 'all') {
            card.style.display = '';
        } else if (status === 'processing') {
            card.style.display = (cardStatus === 'processing' || cardStatus === 'confirmed') ? '' : 'none';
        } else {
            card.style.display = (cardStatus === status) ? '' : 'none';
        }
    });
}

// Global Keyboard & Auto-Open Init
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const drawerEl = document.getElementById('order-drawer');
        if (drawerEl && !drawerEl.classList.contains('translate-x-full')) {
            closeOrderDetail();
        }
    }
});

// Auto-open specific order if requested via URL hash or param
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash || '';
    const urlParams = new URLSearchParams(window.location.search);
    const orderParam = urlParams.get('order');

    let targetOrder = null;

    if (orderParam) {
        targetOrder = orderParam;
    } else if (hash.includes('#order-')) {
        targetOrder = decodeURIComponent(hash.replace('#order-', ''));
    }

    if (targetOrder) {
        setTimeout(() => {
            openOrderDetail(targetOrder);
        }, 150);
    }
});
</script>
@endpush

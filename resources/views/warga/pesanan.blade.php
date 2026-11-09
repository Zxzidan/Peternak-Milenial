{{--
    DOKUMENTASI KODE TAMPILAN: PESANAN SAYA & TRACKING PENGIRIMAN BAGI WARGA
    File: resources/views/warga/pesanan.blade.php
    Deskripsi: Halaman riwayat transaksi pembelian produk pangan peternakan bagi masyarakat umum.
               Menampilkan nomor resi pengiriman berantai dingin, rincian biaya pesanan,
               status pemrosesan oleh peternak, dan verifikasi barang diterima.
--}}

@extends('layouts.app')

@section('title', 'Pesanan Saya — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-7 pt-2 pb-10">

    <!-- 1. HEADER HALAMAN PESANAN WARGA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Pesanan Saya
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Pantau status pengiriman kurir berpendingin, rincian pembayaran, dan konfirmasi penerimaan pesanan produk peternakan Anda secara real-time.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a
                href="{{ route('marketplace') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 px-3.5 py-2 rounded-xl transition shadow-2xs"
            >
                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <span>Belanja Produk Lainnya</span>
            </a>
        </div>
    </div>

    <!-- 2. RINGKASAN METRIK TRANSAKSI WARGA -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-5">
        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block mb-2">Total Pesanan</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-bold text-slate-900 tabular-nums">{{ $orders->count() ?? 6 }}</span>
                <span class="text-xs text-slate-400">Riwayat belanja</span>
            </div>
        </div>

        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block mb-2">Sedang Diproses</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-bold text-sky-700 tabular-nums">
                    {{ $orders->whereIn('status', ['pending', 'confirmed', 'processing'])->count() ?? 2 }}
                </span>
                <span class="text-xs text-sky-600 font-medium">Pengemasan peternak</span>
            </div>
        </div>

        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block mb-2">Dalam Pengiriman</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-bold text-indigo-700 tabular-nums">
                    {{ $orders->where('status', 'shipped')->count() ?? 2 }}
                </span>
                <span class="text-xs text-indigo-600 font-medium">Kurir berpendingin</span>
            </div>
        </div>

        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <span class="text-[10px] sm:text-[11px] font-semibold text-slate-500 uppercase tracking-wider block mb-2">Selesai Diterima</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-bold text-emerald-700 tabular-nums">
                    {{ $orders->where('status', 'completed')->count() ?? 2 }}
                </span>
                <span class="text-xs text-emerald-600 font-medium">Transaksi sukses</span>
            </div>
        </div>
    </div>

    <!-- 3. DAFTAR KARTU PESANAN WARGA -->
    <div class="space-y-4">
        @forelse($orders ?? [] as $order)
        @php
            $statusBadge = match($order->status) {
                'pending' => 'bg-amber-50 text-amber-800 border-amber-300',
                'confirmed', 'processing' => 'bg-sky-50 text-sky-800 border-sky-300',
                'shipped' => 'bg-indigo-50 text-indigo-800 border-indigo-300',
                'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-300',
                'cancelled' => 'bg-rose-50 text-rose-800 border-rose-300',
                default => 'bg-slate-100 text-slate-700 border-slate-300'
            };
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition space-y-4">
            <!-- Header Kartu: Kode & Tanggal -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="font-mono text-xs font-bold text-slate-900 bg-slate-100 px-2.5 py-1 rounded-lg">
                        {{ $order->order_code }}
                    </span>
                    <span class="text-xs text-slate-400">&middot;</span>
                    <span class="text-xs text-slate-500">
                        {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusBadge }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            <!-- Daftar Item Produk -->
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-start justify-between gap-4 text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                            @if($item->product?->image_path)
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">📦</div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $item->product?->name ?? 'Produk Komoditas' }}</h4>
                            <p class="text-slate-500 text-[11px] mt-0.5">
                                Peternak: <strong class="text-slate-700">{{ $item->seller?->name ?? 'Peternak Binaan' }}</strong>
                                &middot; {{ $item->quantity }} x Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <span class="font-bold text-slate-900 tabular-nums shrink-0">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <!-- Detail Pengiriman & Catatan Kurir -->
            @if($order->shipping_address || $order->notes)
            <div class="bg-slate-50 rounded-xl p-3.5 text-xs border border-slate-100 space-y-1">
                @if($order->shipping_address)
                    <div class="flex items-start gap-2 text-slate-600">
                        <span class="font-semibold text-slate-700 shrink-0">Alamat Kirim:</span>
                        <span>{{ $order->shipping_address }} (Telp: {{ $order->buyer_phone }})</span>
                    </div>
                @endif
                @if($order->notes)
                    <div class="flex items-start gap-2 text-slate-600">
                        <span class="font-semibold text-slate-700 shrink-0">Status Kurir:</span>
                        <span class="text-slate-800 font-medium">{{ $order->notes }}</span>
                    </div>
                @endif
            </div>
            @endif

            <!-- Footer: Total Biaya & Aksi -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <div>
                    <span class="text-[11px] text-slate-400 block">Total Pembayaran</span>
                    <span class="text-base font-extrabold text-primary-700 tabular-nums">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    @if($order->status === 'shipped')
                        <button type="button" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                            Konfirmasi Pesanan Diterima
                        </button>
                    @endif
                    <a href="{{ route('pesanan.show', $order) }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                        Lihat Invoice Lengkap
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <p class="text-sm font-semibold text-slate-700">Belum ada riwayat pesanan.</p>
            <p class="text-xs text-slate-400 mt-1">Mulai belanja produk segar dari kelompok peternak Jawa Timur.</p>
            <a href="{{ route('marketplace') }}" class="inline-block mt-4 px-4 py-2 bg-primary-700 text-white text-xs font-bold rounded-xl shadow-xs">
                Mulai Belanja
            </a>
        </div>
        @endforelse
    </div>

</div>
@endsection


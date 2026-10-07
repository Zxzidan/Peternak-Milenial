@extends('layouts.app')

@section('title', 'Harga Komoditas & Sentra Produksi — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = $activeTab ?? request('tab', 'tren');
    if (!in_array($activeTab, ['tren', 'sentra', 'unggulan'])) {
        $activeTab = 'tren';
    }
@endphp

<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 mb-2 sm:mb-2.5">
                <span class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 text-xs font-medium px-2 py-0.5 rounded">
                    Bidang Pascapanen &amp; Pemasaran
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    · Disnak Jatim
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                @if($activeTab === 'tren')
                    Tren Harga Komoditas
                @elseif($activeTab === 'sentra')
                    Sentra Produksi Ternak
                @elseif($activeTab === 'unggulan')
                    Komoditas Unggulan
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed max-w-2xl">
                @if($activeTab === 'tren')
                    Acuan harga pasar harian tingkat peternak dan konsumen Jawa Timur.
                @elseif($activeTab === 'sentra')
                    Pemetaan wilayah sentra produksi dan populasi ternak daerah.
                @elseif($activeTab === 'unggulan')
                    Daftar komoditas ternak prioritas dan potensi strategis daerah.
                @endif
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if(auth()->check() && auth()->user()->isAdmin() && $activeTab === 'tren')
            <button
                type="button"
                onclick="document.getElementById('form-input-harga').classList.toggle('hidden')"
                class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
            >
                + Perbarui Harga
            </button>
            @endif

            <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-0.5 text-xs shadow-2xs">
                <a
                    href="{{ url('/harga-komoditas?tab=tren') }}"
                    class="px-3 py-1.5 rounded-md font-medium transition {{ $activeTab === 'tren' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Tren Harga
                </a>
                <a
                    href="{{ url('/harga-komoditas?tab=sentra') }}"
                    class="px-3 py-1.5 rounded-md font-medium transition {{ $activeTab === 'sentra' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Sentra Produksi ({{ $productionCenters->count() }})
                </a>
                <a
                    href="{{ url('/harga-komoditas?tab=unggulan') }}"
                    class="px-3 py-1.5 rounded-md font-medium transition {{ $activeTab === 'unggulan' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Unggulan ({{ $commodities->count() }})
                </a>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Form Input Harga (Collapsible) -->
    <div id="form-input-harga" class="hidden bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Perbarui Harga Pasar Harian</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Data harga tersimpan dan memperbarui acuan peternak se-Jawa Timur.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-input-harga').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">
                Batal
            </button>
        </div>

        <form action="{{ route('harga-komoditas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten/Kota <span class="text-rose-500">*</span></label>
                <select name="region_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    @foreach ($regions as $reg)
                        <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Komoditas Ternak <span class="text-rose-500">*</span></label>
                <select name="commodity_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    @foreach ($commodities as $com)
                        <option value="{{ $com->id }}">{{ $com->name }} ({{ $com->unit }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Peternak (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="farmer_price" required min="100" placeholder="7450" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Konsumen (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" name="consumer_price" required min="100" placeholder="9500" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-4 flex justify-end gap-2 pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Simpan Harga
                </button>
            </div>
        </form>
    </div>
    @endif

    @if($activeTab === 'tren')
    <!-- ============================================== -->
    <!-- TAB 1: TREN HARGA PASAR                        -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- 3 KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-primary-600 dark:text-primary-400 font-medium">Komoditas Terpantau</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $commodities->count() }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Daging, telur, susu, pakan</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Kondisi Pasar</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $commodityPrices->where('status', 'stabil')->count() }} Stabil</div>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ $commodityPrices->where('status', 'naik')->count() }} Naik &bull; {{ $commodityPrices->where('status', 'turun')->count() }} Turun</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Wilayah Sentra</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $regions->count() }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Pasar induk &amp; KUD se-Jatim</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <form action="{{ route('harga-komoditas') }}" method="GET" class="bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <input type="hidden" name="tab" value="tren">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Filter Data:</span>
                <select name="wilayah" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2.5 text-gray-900 dark:text-white">
                    <option value="">Semua Wilayah</option>
                    @foreach ($regions as $reg)
                        <option value="{{ $reg->id }}" {{ $selectedRegion == $reg->id ? 'selected' : '' }}>{{ $reg->name }}</option>
                    @endforeach
                </select>
                <select name="komoditas" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2.5 text-gray-900 dark:text-white">
                    <option value="">Semua Komoditas</option>
                    @foreach ($commodities as $com)
                        <option value="{{ $com->id }}" {{ $selectedCommodity == $com->id ? 'selected' : '' }}>{{ $com->name }}</option>
                    @endforeach
                </select>
                @if ($selectedRegion || $selectedCommodity)
                    <a href="{{ url('/harga-komoditas?tab=tren') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
                @endif
            </div>
            <div class="text-xs text-gray-400">Pembaruan: Hari Ini &bull; KUD &amp; Pasar Induk Jatim</div>
        </form>

        <!-- Tabel Harga Komoditas -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Pantauan Harga Pasar</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tersedia {{ $commodityPrices->count() }} data acuan harga pasar hari ini.</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    {{ $commodityPrices->count() }} Data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-750 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">Komoditas</th>
                            <th class="px-4 py-3">Wilayah</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3">Harga Peternak</th>
                            <th class="px-4 py-3">Harga Konsumen</th>
                            <th class="px-4 py-3">Tren Perubahan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <th class="px-4 py-3 text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($commodityPrices as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750/50 transition">
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $item->commodity?->name ?? 'Komoditas' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $item->region?->name ?? 'Jawa Timur' }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $item->commodity?->unit ?? 'Satuan' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white tabular-nums">
                                Rp {{ number_format($item->farmer_price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 tabular-nums">
                                Rp {{ number_format($item->consumer_price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->status === 'naik')
                                    <span class="text-rose-600 dark:text-rose-400 font-semibold inline-flex items-center gap-0.5">
                                        &uarr; +{{ $item->price_change_percentage }}%
                                    </span>
                                @elseif ($item->status === 'turun')
                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold inline-flex items-center gap-0.5">
                                        &darr; {{ $item->price_change_percentage }}%
                                    </span>
                                @else
                                    <span class="text-gray-400 font-medium">Stabil (0.0%)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($item->recorded_date)->format('d M Y') }}</td>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('harga-komoditas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data harga {{ $item->commodity?->name }} ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-700 text-xs font-semibold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->check() && auth()->user()->isAdmin() ? 8 : 7 }}" class="px-4 py-12 text-center text-gray-400">
                                Belum ada data harga komoditas yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif($activeTab === 'sentra')
    <!-- ============================================== -->
    <!-- TAB 2: PETA SENTRA PRODUKSI                    -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- 3 KPI Cards Sentra -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-primary-600 dark:text-primary-400 font-medium">Sentra Produksi</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $productionCenters->count() }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Wilayah sentra aktif di Jawa Timur</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Total Populasi Ternak</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($productionCenters->sum('livestock_population'), 0, ',', '.') }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Ekor ternak terdata</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Estimasi Produksi Harian</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($productionCenters->sum('daily_production'), 0, ',', '.') }}</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Ton / hari</p>
            </div>
        </div>

        <!-- Grid Sentra Produksi -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-xs">
            <div class="pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Sentra Produksi Peternakan Jawa Timur</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pusat populasi dan produktivitas hasil ternak terdata.</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300">
                    {{ $productionCenters->count() }} Sentra Terdata
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                @forelse ($productionCenters as $center)
                <div class="p-4 bg-gray-50 dark:bg-gray-750/50 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between hover:border-gray-300 transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-semibold text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 px-2 py-0.5 rounded">
                                {{ $center->region?->name ?? 'Wilayah Sentra' }}
                            </span>
                            <span class="text-[10px] text-gray-400">{{ $center->commodity?->name ?? 'Komoditas' }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $center->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $center->details }}</p>

                        <div class="mt-3.5 pt-3 border-t border-gray-200/60 dark:border-gray-700 space-y-1.5 text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Populasi Ternak:</span>
                                <strong class="text-gray-900 dark:text-white">{{ number_format($center->livestock_population, 0, ',', '.') }} Ekor</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Produksi Harian:</span>
                                <strong class="text-gray-900 dark:text-white">{{ number_format($center->daily_production, 0, ',', '.') }} Ton/Hari</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Peternak Terdata:</span>
                                <strong class="text-gray-900 dark:text-white">{{ number_format($center->farmer_count, 0, ',', '.') }} Orang</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-gray-400 text-xs">
                    Belum ada data sentra produksi peternakan.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @elseif($activeTab === 'unggulan')
    <!-- ============================================== -->
    <!-- TAB 3: KOMODITAS UNGGULAN                      -->
    <!-- ============================================== -->
    <div class="space-y-6">
        <!-- 3 KPI Cards Unggulan -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-primary-600 dark:text-primary-400 font-medium">Komoditas Prioritas</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $commodities->count() }} Komoditas</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Sektor utama ketahanan pangan Jatim</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Status Ketersediaan</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Aman</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Stok surplus untuk konsumsi regional</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Cakupan Sentra</span>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">38 Wilayah</div>
                <p class="text-[11px] text-gray-400 mt-0.5">Kabupaten &amp; Kota di Jawa Timur</p>
            </div>
        </div>

        <!-- Grid Komoditas Unggulan -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-xs">
            <div class="pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Komoditas Unggulan Jawa Timur</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Komoditas ternak dengan produktivitas dan nilai ekonomi strategis.</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                    {{ $commodities->count() }} Komoditas
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                @forelse ($commodities as $com)
                @php
                    $latestPrice = $commodityPrices->where('commodity_id', $com->id)->first();
                    $centersCount = $productionCenters->where('commodity_id', $com->id)->count();
                @endphp
                <div class="p-4 bg-gray-50 dark:bg-gray-750/50 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between hover:border-gray-300 transition">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 px-2 py-0.5 rounded">
                                Prioritas Jatim
                            </span>
                            <span class="text-[10px] text-gray-400">Satuan: {{ $com->unit }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $com->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                            {{ $com->description ?? 'Komoditas ternak binaan unggulan Jawa Timur dengan standar mutu terjamin.' }}
                        </p>

                        <div class="mt-3.5 pt-3 border-t border-gray-200/60 dark:border-gray-700 space-y-1.5 text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Harga Peternak:</span>
                                <strong class="text-gray-900 dark:text-white tabular-nums">
                                    {{ $latestPrice ? 'Rp ' . number_format($latestPrice->farmer_price, 0, ',', '.') : 'Rp -' }}
                                </strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Harga Pasar/Konsumen:</span>
                                <strong class="text-gray-900 dark:text-white tabular-nums">
                                    {{ $latestPrice ? 'Rp ' . number_format($latestPrice->consumer_price, 0, ',', '.') : 'Rp -' }}
                                </strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Sentra Utama:</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $centersCount }} Sentra Terdata</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-gray-400 text-xs">
                    Belum ada data komoditas unggulan.
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

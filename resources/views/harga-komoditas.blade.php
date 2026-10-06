@extends('layouts.app')

@section('title', 'Harga Komoditas & Sentra Produksi — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang PPHP
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Harga Komoditas &amp; Sentra Produksi
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Acuan harga pasar harian dan pemetaan wilayah sentra ternak 38 Kabupaten/Kota Jawa Timur.
        </p>
    </div>
    @if(auth()->check() && auth()->user()->isAdmin())
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-input-harga').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
        >
            + Perbarui Harga Pasar
        </button>
    </div>
    @endif
</div>

@if(auth()->check() && auth()->user()->isAdmin())
<!-- Form Input Harga (Collapsible & Persistent to Database) -->
<div id="form-input-harga" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pembaruan Harga Pasar Harian (Database)</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Data harga tersimpan otomatis dan memperbarui acuan peternak di seluruh Jawa Timur.</p>
        </div>
        <button type="button" onclick="document.getElementById('form-input-harga').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">
            Batal
        </button>
    </div>

    <form action="{{ route('harga-komoditas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
        @csrf
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Kabupaten/Kota <span class="text-red-500">*</span></label>
            <select name="region_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($regions as $reg)
                    <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Komoditas Ternak <span class="text-red-500">*</span></label>
            <select name="commodity_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($commodities as $com)
                    <option value="{{ $com->id }}">{{ $com->name }} ({{ $com->unit }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Tingkat Peternak (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="farmer_price" required min="100" placeholder="7450" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Konsumen / Pasar (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="consumer_price" required min="100" placeholder="9500" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-4 flex justify-end gap-2 pt-1">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                Simpan Harga ke Database
            </button>
        </div>
    </form>
</div>
@endif

<!-- Filter Bar -->
<form action="{{ route('harga-komoditas') }}" method="GET" class="mb-4 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
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
            <a href="{{ route('harga-komoditas') }}" class="text-xs text-red-600 hover:underline">Reset</a>
        @endif
    </div>
    <div class="text-xs text-gray-400">Pembaruan: Hari Ini &bull; KUD &amp; Pasar Induk Jatim</div>
</form>

<!-- Tabel Harga Komoditas Hari Ini (From Database) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                Daftar Harga Komoditas di Database
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tersedia {{ $commodityPrices->count() }} data pantauan harga pasar.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
            <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                <tr>
                    <th class="px-3.5 py-2.5">Komoditas</th>
                    <th class="px-3.5 py-2.5">Wilayah</th>
                    <th class="px-3.5 py-2.5">Satuan</th>
                    <th class="px-3.5 py-2.5">Harga Peternak</th>
                    <th class="px-3.5 py-2.5">Harga Konsumen</th>
                    <th class="px-3.5 py-2.5">Trend &bull; Perubahan</th>
                    <th class="px-3.5 py-2.5">Tanggal</th>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <th class="px-3.5 py-2.5 text-right">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($commodityPrices as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                    <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">{{ $item->commodity?->name ?? 'Komoditas' }}</td>
                    <td class="px-3.5 py-2.5 text-gray-600 dark:text-gray-300">{{ $item->region?->name ?? 'Jawa Timur' }}</td>
                    <td class="px-3.5 py-2.5 text-gray-400">{{ $item->commodity?->unit ?? 'Satuan' }}</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white tabular-nums">
                        Rp {{ number_format($item->farmer_price, 0, ',', '.') }}
                    </td>
                    <td class="px-3.5 py-2.5 tabular-nums">
                        Rp {{ number_format($item->consumer_price, 0, ',', '.') }}
                    </td>
                    <td class="px-3.5 py-2.5">
                        @if ($item->status === 'naik')
                            <span class="text-red-600 dark:text-red-400 font-semibold inline-flex items-center gap-0.5">
                                &uarr; +{{ $item->price_change_percentage }}%
                            </span>
                        @elseif ($item->status === 'turun')
                            <span class="text-green-600 dark:text-green-400 font-semibold inline-flex items-center gap-0.5">
                                &darr; {{ $item->price_change_percentage }}%
                            </span>
                        @else
                            <span class="text-gray-400 font-medium">Stabil (0.0%)</span>
                        @endif
                    </td>
                    <td class="px-3.5 py-2.5 text-gray-400">{{ \Carbon\Carbon::parse($item->recorded_date)->format('d M Y') }}</td>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <td class="px-3.5 py-2.5 text-right">
                        <form action="{{ route('harga-komoditas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data harga {{ $item->commodity?->name }} ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-3.5 py-6 text-center text-gray-400 text-xs">Belum ada data harga komoditas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Section 2: Pemetaan Sentra Produksi Ternak (From Database) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Sentra Produksi Peternakan Jawa Timur</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pusat populasi dan produktivitas hasil ternak terdata di database.</p>
        </div>
        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-50 text-primary-700">Terdata: {{ $productionCenters->count() }} Sentra</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-xs">
        @forelse ($productionCenters as $center)
        <div class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-semibold text-primary-700 bg-blue-50 px-2 py-0.5 rounded">
                        {{ $center->region?->name ?? 'Wilayah Sentra' }}
                    </span>
                    <span class="text-[10px] text-gray-400">{{ $center->commodity?->name ?? 'Komoditas' }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $center->name }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $center->details }}</p>

                <div class="mt-3 space-y-1 text-gray-600 dark:text-gray-300">
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
        <div class="col-span-full py-6 text-center text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
            Belum ada data sentra produksi.
        </div>
        @endforelse
    </div>
</div>
@endsection

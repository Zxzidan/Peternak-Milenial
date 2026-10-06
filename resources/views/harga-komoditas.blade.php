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
            Harga Komoditas & Sentra Produksi
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Acuan harga pasar harian dan pemetaan wilayah sentra ternak 38 Kabupaten/Kota Jawa Timur.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-input-harga').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition"
        >
            + Perbarui Harga
        </button>
    </div>
</div>

<!-- Form Input Harga (Collapsible) -->
<div id="form-input-harga" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pembaruan Harga Pasar</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Khusus petugas pasar dan penyuluh dinas kabupaten/kota.</p>
        </div>
        <button onclick="document.getElementById('form-input-harga').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
    </div>

    <form onsubmit="event.preventDefault(); alert('Data harga berhasil disimpan!'); document.getElementById('form-input-harga').classList.add('hidden');" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah</label>
            <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option>Kab. Pasuruan</option>
                <option>Kab. Malang</option>
                <option>Kota Batu</option>
                <option>Kab. Blitar</option>
                <option>Kab. Lumajang</option>
                <option>Kota Surabaya</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Komoditas</label>
            <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option>Susu Sapi Segar</option>
                <option>Daging Sapi Murni</option>
                <option>Daging Ayam Ras</option>
                <option>Telur Ayam Ras</option>
                <option>Jagung Pakan Pipil</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Peternak (Rp)</label>
            <input type="number" required placeholder="7450" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Konsumen (Rp)</label>
            <input type="number" required placeholder="9500" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-4 flex justify-end gap-2 pt-1">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-medium px-4 py-2 rounded-lg">
                Simpan Harga
            </button>
        </div>
    </form>
</div>

<!-- Tabel Harga Komoditas Hari Ini -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                Daftar Harga Rata-rata Jawa Timur
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pembaruan: 06:00 WIB · 38 Kab/Kota</p>
        </div>
        <div class="text-xs text-gray-400">
            Acuan: KUD & Pasar Induk
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
            <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                <tr>
                    <th class="px-3.5 py-2.5">Komoditas</th>
                    <th class="px-3.5 py-2.5">Satuan</th>
                    <th class="px-3.5 py-2.5">Harga Peternak</th>
                    <th class="px-3.5 py-2.5">Harga Konsumen</th>
                    <th class="px-3.5 py-2.5">Perubahan (7 Hari)</th>
                    <th class="px-3.5 py-2.5">Sentra Produksi</th>
                    <th class="px-3.5 py-2.5">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr>
                    <td class="px-3.5 py-3 font-semibold text-gray-900 dark:text-white">Susu Sapi Segar</td>
                    <td class="px-3.5 py-3">Liter</td>
                    <td class="px-3.5 py-3 font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 7.450</td>
                    <td class="px-3.5 py-3 tabular-nums">Rp 9.500</td>
                    <td class="px-3.5 py-3 text-green-700 dark:text-green-400 font-semibold inline-flex items-center gap-0.5">↑ +Rp 250 (+3.4%)</td>
                    <td class="px-3.5 py-3">Pasuruan & Malang</td>
                    <td class="px-3.5 py-3"><span class="bg-green-50 text-green-700 dark:bg-green-950/60 dark:text-green-300 text-[10px] font-medium px-2 py-0.5 rounded">Stabil</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-3 font-semibold text-gray-900 dark:text-white">Daging Sapi Murni</td>
                    <td class="px-3.5 py-3">Kilogram</td>
                    <td class="px-3.5 py-3 font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 128.500</td>
                    <td class="px-3.5 py-3 tabular-nums">Rp 135.000</td>
                    <td class="px-3.5 py-3 text-gray-400">Rp 0 (0.0%)</td>
                    <td class="px-3.5 py-3">Tuban & Lamongan</td>
                    <td class="px-3.5 py-3"><span class="bg-green-50 text-green-700 dark:bg-green-950/60 dark:text-green-300 text-[10px] font-medium px-2 py-0.5 rounded">Stabil</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-3 font-semibold text-gray-900 dark:text-white">Daging Ayam Ras</td>
                    <td class="px-3.5 py-3">Kilogram</td>
                    <td class="px-3.5 py-3 font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 23.200</td>
                    <td class="px-3.5 py-3 tabular-nums">Rp 34.000</td>
                    <td class="px-3.5 py-3 text-red-600 font-medium">↓ -Rp 600 (-2.5%)</td>
                    <td class="px-3.5 py-3">Blitar & Jombang</td>
                    <td class="px-3.5 py-3"><span class="bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 text-[10px] font-medium px-2 py-0.5 rounded">Fluktuatif</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-3 font-semibold text-gray-900 dark:text-white">Telur Ayam Ras</td>
                    <td class="px-3.5 py-3">Kilogram</td>
                    <td class="px-3.5 py-3 font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 24.800</td>
                    <td class="px-3.5 py-3 tabular-nums">Rp 26.800</td>
                    <td class="px-3.5 py-3 text-green-700 dark:text-green-400 font-semibold inline-flex items-center gap-0.5">↑ +Rp 400 (+1.6%)</td>
                    <td class="px-3.5 py-3">Blitar & Kediri</td>
                    <td class="px-3.5 py-3"><span class="bg-green-50 text-green-700 dark:bg-green-950/60 dark:text-green-300 text-[10px] font-medium px-2 py-0.5 rounded">Stabil</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-3 font-semibold text-gray-900 dark:text-white">Jagung Pakan Pipil</td>
                    <td class="px-3.5 py-3">Kilogram</td>
                    <td class="px-3.5 py-3 font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 4.900</td>
                    <td class="px-3.5 py-3 tabular-nums">Rp 5.200</td>
                    <td class="px-3.5 py-3 text-gray-400">Rp 0 (0.0%)</td>
                    <td class="px-3.5 py-3">Bojonegoro & Tuban</td>
                    <td class="px-3.5 py-3"><span class="bg-green-50 text-green-700 dark:bg-green-950/60 dark:text-green-300 text-[10px] font-medium px-2 py-0.5 rounded">Stabil</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Section: Peta Sentra Produksi -->
<div id="peta" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
            Peta Geospasial Sentra Produksi Peternakan
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebaran populasi dan balai pembibitan ternak Jawa Timur.</p>
    </div>

    <!-- Peta Visual Minimal -->
    <div class="relative w-full h-72 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-700 p-4 flex items-center justify-center overflow-hidden">
        <svg class="w-full h-full max-h-64 opacity-80" viewBox="0 0 900 450" fill="none">
            <!-- East Java Outline -->
            <path d="M120,240 C180,210 260,200 340,190 C390,170 450,150 510,170 C580,180 620,210 680,230 C760,240 820,260 860,290 C840,330 780,360 700,380 C600,400 500,410 400,400 C280,390 180,350 120,240 Z" fill="currentColor" class="text-gray-200 dark:text-gray-800" stroke="currentColor" stroke-width="1.5"/>
            <!-- Madura Island -->
            <path d="M520,130 C600,120 700,130 760,150 C750,180 670,185 580,175 C520,165 500,145 520,130 Z" fill="currentColor" class="text-gray-200 dark:text-gray-800" stroke="currentColor" stroke-width="1.5"/>
            
            <!-- Markers -->
            <g class="cursor-pointer" onclick="alert('Sentra Pasuruan: Populasi Sapi Perah 92.400 Ekor')">
                <circle cx="480" cy="270" r="8" class="fill-primary-600 stroke-white dark:stroke-gray-900" stroke-width="2"/>
                <text x="480" y="292" font-size="11" fill="currentColor" text-anchor="middle" font-weight="600" class="text-gray-800 dark:text-gray-200">Pasuruan (Susu)</text>
            </g>

            <g class="cursor-pointer" onclick="alert('Sentra Blitar: Suplai Telur 70% Jatim')">
                <circle cx="410" cy="320" r="7" class="fill-gray-700 dark:fill-gray-300 stroke-white dark:stroke-gray-900" stroke-width="2"/>
                <text x="410" y="340" font-size="11" fill="currentColor" text-anchor="middle" font-weight="600" class="text-gray-800 dark:text-gray-200">Blitar (Telur)</text>
            </g>

            <g class="cursor-pointer" onclick="alert('Sentra Lumajang: Kambing Senduro')">
                <circle cx="580" cy="330" r="7" class="fill-gray-700 dark:fill-gray-300 stroke-white dark:stroke-gray-900" stroke-width="2"/>
                <text x="580" y="350" font-size="11" fill="currentColor" text-anchor="middle" font-weight="600" class="text-gray-800 dark:text-gray-200">Lumajang (Senduro)</text>
            </g>

            <g class="cursor-pointer" onclick="alert('Sentra Madura: Sapi Madura Murni')">
                <circle cx="640" cy="150" r="7" class="fill-gray-700 dark:fill-gray-300 stroke-white dark:stroke-gray-900" stroke-width="2"/>
                <text x="640" y="170" font-size="11" fill="currentColor" text-anchor="middle" font-weight="600" class="text-gray-800 dark:text-gray-200">Madura (Sapi Potong)</text>
            </g>
        </svg>

        <div id="unggulan" class="absolute top-3 left-3 bg-white/95 dark:bg-gray-800/95 p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 text-xs shadow-xs">
            <span class="font-bold text-gray-900 dark:text-white block mb-1">Sentra Unggulan:</span>
            <div class="space-y-0.5 text-gray-600 dark:text-gray-300 text-[11px]">
                <div>• Sapi Perah: Pasuruan & Malang</div>
                <div>• Telur Unggas: Blitar & Kediri</div>
                <div>• Kambing Senduro: Lumajang</div>
                <div>• Sapi Potong: Madura & Lamongan</div>
            </div>
        </div>
    </div>
</div>
@endsection

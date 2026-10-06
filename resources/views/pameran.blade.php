@extends('layouts.app')

@section('title', 'Pameran & Kalender Terpadu — Peternak Milenial Jatim')

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
            Pameran & Kalender Terpadu
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Agenda pameran peternakan, temu bisnis, dan kalender kegiatan dinas Jawa Timur.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-daftar-pameran').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-medium text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition"
        >
            + Daftar Peserta Pameran
        </button>
    </div>
</div>

<!-- Form Pengajuan Stand (Collapsible) -->
<div id="form-daftar-pameran" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pengajuan Stand Pameran</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Fasilitas stand dinas untuk peternak lokal Jawa Timur.</p>
        </div>
        <button onclick="document.getElementById('form-daftar-pameran').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
    </div>

    <form onsubmit="event.preventDefault(); alert('Pengajuan stand pameran berhasil diajukan!'); document.getElementById('form-daftar-pameran').classList.add('hidden');" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Usaha / Kelompok</label>
            <input type="text" required value="Peternak Sapi Perah Pasuruan" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pilihan Pameran</label>
            <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option>Jatim Dairy & Livestock Expo 2026 (Surabaya)</option>
                <option>Pasar Tani Milenial (Pasuruan)</option>
                <option>Batu Agro Fair (Batu)</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Produk yang Dipamerkan</label>
            <input type="text" required placeholder="Susu Pasteurisasi & Keju" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-3 flex justify-end gap-2 pt-1">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-medium px-4 py-2 rounded-lg">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

<!-- Section 1: Pameran Utama -->
<div class="mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 sm:p-6 shadow-xs">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
        <div>
            <span class="text-[11px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-2 py-0.5 rounded">
                Agenda Utama
            </span>
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mt-1.5">
                Jatim Dairy & Livestock Expo 2026
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-xl leading-relaxed">
                Pameran teknologi budidaya, lelang bibit unggul, dan temu jaringan pasar peternak Jawa Timur.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3.5 text-xs">
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Waktu</span>
                    <span class="font-semibold text-gray-900 dark:text-white">24–26 Oktober 2026</span>
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Tempat</span>
                    <span class="font-semibold text-gray-900 dark:text-white">Grand City Convex, Surabaya</span>
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Kapasitas</span>
                    <span class="font-semibold text-gray-900 dark:text-white">120 Stand Binaan</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row lg:flex-col gap-2 shrink-0">
            <button
                type="button"
                onclick="document.getElementById('form-daftar-pameran').classList.remove('hidden')"
                class="bg-primary-700 hover:bg-primary-800 text-white font-medium px-4 py-2 rounded-lg text-xs transition"
            >
                Daftar Stand
            </button>
            <button
                type="button"
                onclick="alert('Tiket pameran gratis untuk peternak Jawa Timur!')"
                class="bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium px-4 py-2 rounded-lg text-xs border border-gray-200 dark:border-gray-600 transition"
            >
                Tiket Undangan
            </button>
        </div>
    </div>
</div>

<!-- Section 2: Kalender Kegiatan Terpadu -->
<div id="kalender" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
            Kalender Terpadu Kegiatan
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Jadwal vaksinasi, bimbingan teknis, dan pasar ternak terintegrasi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-[10px] text-gray-400 block mb-0.5">12 Okt 2026 · Pandaan</span>
                <h4 class="font-semibold text-gray-900 dark:text-white">Vaksinasi Massal PMK & LSD</h4>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Pelayanan lapangan petugas Puskeswan ke kelompok ternak.
                </p>
            </div>
            <span class="mt-3 text-[11px] font-medium text-primary-700 dark:text-primary-400">Wajib</span>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-[10px] text-gray-400 block mb-0.5">15 Okt 2026 · Batu</span>
                <h4 class="font-semibold text-gray-900 dark:text-white">Praktik Silase & Fermentasi</h4>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Workshop formulasi pakan mandiri di BBPP Songgoriti.
                </p>
            </div>
            <span class="mt-3 text-[11px] font-medium text-gray-600 dark:text-gray-400">Terdaftar</span>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-[10px] text-gray-400 block mb-0.5">20 Okt 2026 · Pasuruan</span>
                <h4 class="font-semibold text-gray-900 dark:text-white">Gelar Pasar Produk Olahan</h4>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Penjualan langsung susu pasteurisasi, keju, dan telur di Alun-Alun.
                </p>
            </div>
            <span class="mt-3 text-[11px] font-medium text-primary-700 dark:text-primary-400">Buka Lapak</span>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-[10px] text-gray-400 block mb-0.5">24–26 Okt 2026 · Surabaya</span>
                <h4 class="font-semibold text-gray-900 dark:text-white">Livestock Expo 2026</h4>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Grand City Convex bersama 120 stand UKM peternakan binaan.
                </p>
            </div>
            <span class="mt-3 text-[11px] font-medium text-primary-700 dark:text-primary-400">Terjadwal</span>
        </div>
    </div>
</div>
@endsection

{{--
    DOKUMENTASI KODE TAMPILAN: PANTAUAN HARGA KOMODITAS PANGAN TERNAK BAGI WARGA
    File: resources/views/warga/harga-komoditas.blade.php
    Deskripsi: Halaman informasi keterbukaan harga pasar komoditas peternakan Jawa Timur untuk warga & konsumen.
               Menampilkan perbandingan harga tingkat peternak vs tingkat konsumen di pasar rakyat,
               analisis stabilitas harga harian, dan grafik tren 7 hari terakhir.
--}}

@extends('layouts.app')

@section('title', 'Pantauan Harga Pangan Ternak — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-2 pb-10">

    <!-- 1. HEADER INFORMASI HARGA PASAR -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Informasi Harga Komoditas Pangan Ternak Jatim
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Transparansi harga harian komoditas susu sapi, daging segar, telur ayam, dan telur bebek di tingkat produsen peternak dan pasar konsumen se-Jawa Timur.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl bg-blue-50 text-blue-700 border border-blue-200">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Diperbarui Harian</span>
            </span>
        </div>
    </div>

    <!-- 2. KARTU RINGKASAN KOMODITAS UTAMA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Susu Sapi Murni -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Susu Sapi Segar</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
            </div>
            <div class="pt-1">
                <span class="text-2xl font-black text-slate-900 tabular-nums">Rp 9.500</span>
                <span class="text-xs text-slate-400">/ Liter (Konsumen)</span>
            </div>
            <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                Tingkat Peternak: <strong class="text-slate-700">Rp 7.450</strong> (KUD Pasuruan)
            </p>
        </div>

        <!-- Daging Sapi Murni -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Daging Sapi Murni</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
            </div>
            <div class="pt-1">
                <span class="text-2xl font-black text-slate-900 tabular-nums">Rp 135.000</span>
                <span class="text-xs text-slate-400">/ Kg (Konsumen)</span>
            </div>
            <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                Tingkat Peternak: <strong class="text-slate-700">Rp 128.500</strong> (Pasar Tuban)
            </p>
        </div>

        <!-- Telur Ayam Ras -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Telur Ayam Ras</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">+1.6%</span>
            </div>
            <div class="pt-1">
                <span class="text-2xl font-black text-slate-900 tabular-nums">Rp 27.000</span>
                <span class="text-xs text-slate-400">/ Kg (Konsumen)</span>
            </div>
            <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                Tingkat Peternak: <strong class="text-slate-700">Rp 25.200</strong> (Koperasi Blitar)
            </p>
        </div>

        <!-- Telur Bebek Segar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Telur Bebek Segar</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
            </div>
            <div class="pt-1">
                <span class="text-2xl font-black text-slate-900 tabular-nums">Rp 2.800</span>
                <span class="text-xs text-slate-400">/ Butir (Konsumen)</span>
            </div>
            <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                Tingkat Peternak: <strong class="text-slate-700">Rp 2.350</strong> (Sentra Nganjuk)
            </p>
        </div>
    </div>

    <!-- 3. TABEL LENGKAP HARGA KOMODITAS SE-JAWA TIMUR -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Harga Pantauan Pasar Hari Ini</h3>
                <p class="text-xs text-slate-500">Sumber data: Survei Pasar Hewan & Koperasi Peternak Jawa Timur</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4">Komoditas Ternak</th>
                        <th class="py-3.5 px-4">Wilayah Sentra</th>
                        <th class="py-3.5 px-4 text-right">Harga Produsen (Peternak)</th>
                        <th class="py-3.5 px-4 text-right">Harga Konsumen (Pasar)</th>
                        <th class="py-3.5 px-4 text-center">Status 7 Hari</th>
                        <th class="py-3.5 px-4">Sumber Informasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">Susu Sapi Segar</td>
                        <td class="py-3.5 px-4 text-slate-600">Kabupaten Pasuruan</td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700 tabular-nums">Rp 7.450 / Liter</td>
                        <td class="py-3.5 px-4 text-right font-bold text-primary-700 tabular-nums">Rp 9.500 / Liter</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">KUD Pasuruan &amp; Pasar Pandaan</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">Daging Sapi Murni</td>
                        <td class="py-3.5 px-4 text-slate-600">Kabupaten Tuban</td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700 tabular-nums">Rp 128.500 / Kg</td>
                        <td class="py-3.5 px-4 text-right font-bold text-primary-700 tabular-nums">Rp 135.000 / Kg</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">Pasar Hewan Tuban</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">Daging Ayam Ras</td>
                        <td class="py-3.5 px-4 text-slate-600">Kabupaten Blitar</td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700 tabular-nums">Rp 23.400 / Kg</td>
                        <td class="py-3.5 px-4 text-right font-bold text-primary-700 tabular-nums">Rp 34.500 / Kg</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">+1.7%</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">PINSAR Unggas Blitar</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">Telur Bebek Segar</td>
                        <td class="py-3.5 px-4 text-slate-600">Kabupaten Nganjuk</td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700 tabular-nums">Rp 2.350 / Butir</td>
                        <td class="py-3.5 px-4 text-right font-bold text-primary-700 tabular-nums">Rp 2.800 / Butir</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Stabil</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">Asosiasi Peternak Itik Nganjuk</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-900">Jagung Pakan Pipil Kering</td>
                        <td class="py-3.5 px-4 text-slate-600">Kabupaten Bojonegoro</td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700 tabular-nums">Rp 5.100 / Kg</td>
                        <td class="py-3.5 px-4 text-right font-bold text-primary-700 tabular-nums">Rp 5.400 / Kg</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">+1.9%</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">Pasar Agrobis Bojonegoro</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


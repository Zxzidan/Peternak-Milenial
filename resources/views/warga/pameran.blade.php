{{--
    DOKUMENTASI KODE TAMPILAN: PAMERAN & AGENDA EXPO PETERNAKAN BAGI PENGUNJUNG WARGA
    File: resources/views/warga/pameran.blade.php
    Deskripsi: Halaman direktori pameran, festival produk olahan pangan asal hewan, lelang bibit ternak,
               dan temu bisnis peternakan Jawa Timur yang terbuka untuk dikunjungi oleh masyarakat umum.
--}}

@extends('layouts.app')

@section('title', 'Agenda Pameran & Expo Peternakan — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-2 pb-10">

    <!-- 1. HEADER PAMERAN & FESTIVAL WARGA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Agenda Expo &amp; Festival Peternakan Jawa Timur
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Kunjungi pameran teknologi budidaya, gelar produk olahan susu dan daging berkualitas, serta lelang bibit unggul binaan Dinas Peternakan Provinsi Jawa Timur.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl bg-primary-50 text-primary-700 border border-primary-200">
                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <span>Terbuka untuk Umum</span>
            </span>
        </div>
    </div>

    <!-- 2. DAFTAR PAMERAN UTAMA -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($exhibitions ?? [] as $expo)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 mb-2">
                            Pameran Resmi Provinsi
                        </span>
                        <h3 class="text-base font-bold text-slate-900">{{ $expo->title }}</h3>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-bold text-slate-700 block">Kapasitas Stand</span>
                        <span class="text-xs text-primary-700 font-extrabold">{{ $expo->registered_stands_count }} / {{ $expo->stand_capacity }} Stand</span>
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $expo->description }}
                </p>

                <!-- Info Waktu & Lokasi Pengunjung -->
                <div class="bg-slate-50 rounded-xl p-3.5 space-y-2 text-xs border border-slate-100">
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($expo->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($expo->end_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span class="font-semibold">{{ $expo->location }}</span>
                    </div>
                </div>

                <!-- Fasilitas untuk Pengunjung Warga -->
                @if($expo->facilities)
                <div class="pt-2 text-xs text-slate-500">
                    <strong class="text-slate-700 block mb-1">Fasilitas &amp; Aktivitas:</strong>
                    <span>{{ $expo->facilities }}</span>
                </div>
                @endif
            </div>

            <!-- Footer Pameran -->
            <div class="p-6 pt-0">
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-emerald-700 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Gratis Tiket Masuk Pengunjung
                    </span>
                    <a href="{{ route('pameran') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition">
                        Detail Pameran &rarr;
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-6 text-xs text-slate-400">
            Belum ada agenda pameran aktif saat ini.
        </div>
        @endforelse
    </div>

</div>
@endsection


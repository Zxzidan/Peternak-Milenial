@extends('layouts.app')

@section('title', 'Layanan Darurat Kesejahteraan Hewan — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-red-50 text-red-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-red-950/50 dark:text-red-300">
                Bidang Kesmavet
            </span>
            <span class="text-xs text-gray-400">Siaga 24 Jam</span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Pelaporan Darurat & Kesejahteraan Hewan
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Saluran tanggap darurat wabah ternak, bencana alam, dan kecelakaan kandang.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            data-modal-target="emergency-modal"
            data-modal-toggle="emergency-modal"
            class="inline-flex items-center text-xs sm:text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-3.5 py-2 rounded-lg transition"
        >
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            Buat Laporan Darurat
        </button>
    </div>
</div>

<!-- Laporan Aktif Section -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                Laporan Aktif #EM-2026-081
            </h2>
            <span class="bg-amber-50 text-amber-700 text-[11px] font-medium px-2 py-0.5 rounded dark:bg-amber-950/60 dark:text-amber-300">
                Menuju Lokasi
            </span>
        </div>
        <a href="tel:08001347625" class="text-xs font-medium text-red-600 dark:text-red-400 hover:underline inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
            Hubungi Petugas Lapangan
        </a>
    </div>

    <!-- Stepper Timeline -->
    <div class="py-4">
        <div class="grid grid-cols-4 gap-2 text-center text-xs">
            <div>
                <div class="h-1 bg-primary-600 rounded-full mb-2"></div>
                <span class="font-semibold text-gray-900 dark:text-white block">1. Diterima</span>
                <span class="text-[10px] text-gray-400">08:14 WIB</span>
            </div>
            <div>
                <div class="h-1 bg-primary-600 rounded-full mb-2"></div>
                <span class="font-semibold text-gray-900 dark:text-white block">2. Diverifikasi</span>
                <span class="text-[10px] text-gray-400">08:22 WIB</span>
            </div>
            <div>
                <div class="h-1 bg-amber-500 rounded-full mb-2"></div>
                <span class="font-semibold text-amber-700 dark:text-amber-400 block">3. Ditangani</span>
                <span class="text-[10px] text-gray-400">drh. Ratna OTW</span>
            </div>
            <div>
                <div class="h-1 bg-gray-200 dark:bg-gray-700 rounded-full mb-2"></div>
                <span class="text-gray-400 block">4. Selesai</span>
                <span class="text-[10px] text-gray-400">Berita Acara</span>
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg text-xs">
        <span class="font-semibold text-gray-900 dark:text-white block mb-0.5">Catatan Petugas (drh. Ratna Kusuma):</span>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
            Membawa antipiretik dan desinfektan. Peternak telah mengisolasi 4 ekor ternak terdampak di kandang belakang.
        </p>
    </div>
</div>

<!-- SOP Mitigasi Bencana Section -->
<div id="panduan" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
            Buku Saku Mitigasi Bencana & SOP Kesmavet
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
            Panduan resmi evakuasi dan pencegahan wabah bersama BPBD Jawa Timur.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        <!-- SOP 1 -->
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-gray-900 dark:text-white block">Erupsi Gunung Berapi</span>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Lindungi pakan hijauan dari abu silika. Gunakan pakan silase kedap udara dan bilas ternak dengan air bersih.
                </p>
            </div>
            <button
                type="button"
                onclick="alert('Membuka SOP Erupsi...')"
                class="mt-3 text-left font-medium text-primary-700 dark:text-primary-400 hover:underline"
            >
                Baca SOP →
            </button>
        </div>

        <!-- SOP 2 -->
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-gray-900 dark:text-white block">Banjir & Longsor</span>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Lepaskan ikatan tali kandang dan arahkan kelompok ternak ke rute posko dataran tinggi yang telah ditentukan.
                </p>
            </div>
            <button
                type="button"
                onclick="alert('Membuka Peta Rute Evakuasi...')"
                class="mt-3 text-left font-medium text-primary-700 dark:text-primary-400 hover:underline"
            >
                Peta Evakuasi →
            </button>
        </div>

        <!-- SOP 3 -->
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-gray-900 dark:text-white block">Biosekuriti Kandang</span>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Sediakan bak celup kaki berdesinfektan di pintu kandang dan batasi akses pedagang luar saat siaga wabah.
                </p>
            </div>
            <button
                type="button"
                onclick="alert('Membuka Panduan Biosekuriti...')"
                class="mt-3 text-left font-medium text-primary-700 dark:text-primary-400 hover:underline"
            >
                Panduan Kandang →
            </button>
        </div>
    </div>
</div>
@endsection

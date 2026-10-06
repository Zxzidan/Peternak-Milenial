@extends('layouts.app')

@section('title', 'Dashboard Peternakan Provinsi Jawa Timur — Peternak Milenial')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex flex-wrap items-center gap-2.5 mb-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                    Dinas Peternakan Provinsi Jawa Timur
                </span>
                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">· Publikasi Data & Layanan Terpadu</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                Peternakan Provinsi Jawa Timur
            </h1>

        </div>

        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
            <span class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-3.5 py-2 shadow-xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Data Terpadu 38 Kab/Kota</span>
            </span>
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-semibold rounded-lg text-xs sm:text-sm px-3.5 sm:px-4 py-2 shadow-xs transition"
            >
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Siaga Darurat Ternak
            </button>
        </div>
    </div>

    <!-- 1. Statistik Utama Dashboard (KPI Section - Terhubung Database) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- KPI 1: Total Peternak di Jawa Timur -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Pelaku Usaha Ternak</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
            </div>
            <div class="mt-3.5 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $displayPeternakCount }}</h3>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Peternak</span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Data Terdata di Sentra Jatim</p>
        </div>

        <!-- KPI 2: Rata-rata Produksi Hasil Ternak -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Produktivitas Hasil</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <polyline stroke-linecap="round" stroke-linejoin="round" points="22 7 13.5 15.5 8.5 10.5 2 17" />
                        <polyline stroke-linecap="round" stroke-linejoin="round" points="16 7 22 7 22 13" />
                    </svg>
                </div>
            </div>
            <div class="mt-3.5 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $displayDailyProduction }}</h3>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Ton / Hari</span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Rata-rata Produksi Harian</p>
        </div>

        <!-- KPI 3: Jenis/Tipe Peternak -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Struktur Komoditas</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11V9a4 4 0 0 0-8 0v2m-6 3a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v3zm0 0v5m14-5v5M9 21v-3m6 3v-3" />
                    </svg>
                </div>
            </div>
            <div class="mt-3.5 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $commodityCount }} Sektor</h3>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Komoditas</span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Komoditas Unggulan Provinsi</p>
        </div>

        <!-- KPI 4: Siaga Darurat & Layanan Terpadu -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">Siaga Darurat Kesmavet</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-950/60 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3.5 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-red-600 dark:text-red-400">{{ $activeEmergencyCount }}</h3>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Kasus Aktif</span>
            </div>
            <a href="{{ route('darurat') }}" class="text-[11px] text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium hover:underline mt-1 inline-block">
                Pantau Laporan Darurat &rarr;
            </a>
        </div>
    </div>

   <!-- Section Utama: MASP -->
    <div id="masp" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs transition">
        <!-- MASP Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center">
                    <!-- Clean Map Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934a1.12 1.12 0 0 1-1.006 0L9.503 3.314a1.12 1.12 0 0 0-1.006 0L3.622 5.75A1.125 1.125 0 0 0 3 6.757v12.423c0 .836.88 1.38 1.628 1.006l3.869-1.934a1.12 1.12 0 0 1 1.006 0l4.994 2.497a1.12 1.12 0 0 0 1.006 0Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">MASP</h2>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Peta geospasial Google Maps sentra peternakan Jawa Timur</p>
                </div>
            </div>

            <!-- Active Point Tag & Link External -->
            <div class="flex items-center gap-2">
                <div id="masp-active-badge" class="inline-flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 rounded-lg px-2.5 py-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span id="masp-active-text">Seluruh Jawa Timur (38 Kab/Kota)</span>
                </div>
                <a
                    id="masp-external-link"
                    href="https://www.google.com/maps/search/?api=1&query=Jawa+Timur"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hidden sm:inline-flex items-center gap-1 text-xs font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 px-2.5 py-1 rounded-lg border border-primary-200 dark:border-primary-800 hover:bg-primary-50 dark:hover:bg-primary-950/40 transition"
                    title="Buka di Google Maps"
                >
                    <span>Buka Maps</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Quick Filter / Sentra Buttons Bar -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 mb-3 text-xs">
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 shrink-0 mr-1">Pilih Sentra:</span>
            <button
                type="button"
                onclick="selectSentra('semua', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-primary-600 text-white shadow-xs transition"
            >
                Semua Jatim
            </button>
            <button
                type="button"
                onclick="selectSentra('pasuruan', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Pasuruan (Susu Sapi Perah)
            </button>
            <button
                type="button"
                onclick="selectSentra('malang', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Malang (Sapi Perah & Pakan)
            </button>
            <button
                type="button"
                onclick="selectSentra('blitar', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Blitar (Ayam & Telur)
            </button>
            <button
                type="button"
                onclick="selectSentra('tuban', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Tuban (Sapi Potong PO)
            </button>
            <button
                type="button"
                onclick="selectSentra('lumajang', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Lumajang (Kambing Senduro)
            </button>
            <button
                type="button"
                onclick="selectSentra('bojonegoro', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Bojonegoro (Sapi Potong)
            </button>
            <button
                type="button"
                onclick="selectSentra('madura', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Madura (Sapi Madura Murni)
            </button>
            <button
                type="button"
                onclick="selectSentra('banyuwangi', this)"
                class="masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
            >
                Banyuwangi (Ruminansia Timur)
            </button>
        </div>

       

        <!-- Google Maps Embed Canvas -->
        <div class="relative w-full h-72 sm:h-80 md:h-96 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 shadow-inner">
            <iframe
                id="masp-map-frame"
                title="Peta Google Maps Sentra Peternakan Jawa Timur"
                class="w-full h-full border-0"
                src="https://maps.google.com/maps?q=Jawa+Timur,+Indonesia&t=&z=8&ie=UTF8&iwloc=&output=embed"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
   
    <!-- 2. Insight Section: 2 Visualisasi Esensial & Bermakna -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Chart 1: Distribusi Populasi Ternak di Jawa Timur -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4 gap-2">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                    Distribusi Populasi Berdasarkan Jenis Ternak
                </h3>
                <span class="inline-flex items-center text-[11px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">
                    BPS & Disnak Jatim
                </span>
            </div>

            <!-- ApexChart Container -->
            <div id="chart-distribusi-ternak" class="w-full min-h-[300px]"></div>
        </div>

        <!-- Chart 2: Volume Produksi Komoditas Ternak Utama -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-4 gap-2">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                    Volume Produksi Komoditas Ternak Utama
                </h3>
                <span class="inline-flex items-center text-[11px] font-medium bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 px-2 py-0.5 rounded border border-emerald-200 dark:border-emerald-800">
                    Capaian Tahunan
                </span>
            </div>

            <!-- ApexChart Container -->
            <div id="chart-produksi-komoditas" class="w-full min-h-[300px]"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/**
 * Dashboard Peternakan Jawa Timur — Engine Visualisasi
 * Menggunakan ApexCharts dengan palet warna resmi dan adaptasi dark-mode otomatis.
 */
let distChartInstance = null;
let prodChartInstance = null;

function updateMaspInfo(infoText) {
    const badgeText = document.getElementById('masp-active-text');
    if (badgeText) {
        badgeText.textContent = infoText;
    }
}

const sentraDatabase = {
    'semua': {
        kota: 'Provinsi Jawa Timur',
        peternak: 'Pusat Distribusi Data Peternak Jawa Timur (38 Kab/Kota)',
        detail: 'Ruminansia, Unggas, & Aneka Ternak • 1.248.560 Pelaku Usaha Ternak Terdata',
        query: 'Jawa Timur, Indonesia',
        zoom: 8,
        badge: 'Seluruh Jawa Timur (38 Kab/Kota)'
    },
    'pasuruan': {
        kota: 'Kab. Pasuruan (Kec. Tutur / Nongkojajar)',
        peternak: 'KUD Setia Kawan Nongkojajar & Sentra Sapi Perah',
        detail: 'Sapi Perah Friesian Holstein (FH) • 92.400 Ekor • 120 Ton Susu Segar/Hari',
        query: 'KUD Setia Kawan Nongkojajar Pasuruan',
        zoom: 15,
        badge: 'Pasuruan: Sentra Sapi Perah FH'
    },
    'malang': {
        kota: 'Kab. Malang (Kec. Pujon & Ngantang)',
        peternak: 'Koperasi Susu SAE Pujon & Peternak Sapi Perah',
        detail: 'Sapi Perah & Pakan Silase Hijauan • 78.200 Ekor • 105 Ton Susu/Hari',
        query: 'Koperasi Susu SAE Pujon Malang',
        zoom: 15,
        badge: 'Malang: Sentra Sapi Perah & Pakan'
    },
    'blitar': {
        kota: 'Kab. Blitar (Kec. Ponggok & Srengat)',
        peternak: 'Sentra Peternakan Ayam Petelur Ponggok & Koperasi Unggas Blitar',
        detail: 'Ayam Ras Petelur (Layer) • 16,5 Juta Ekor • Pasok 30% Kebutuhan Telur Nasional',
        query: 'Sentra Peternakan Ayam Ponggok Blitar',
        zoom: 15,
        badge: 'Blitar: Sentra Telur & Unggas'
    },
    'tuban': {
        kota: 'Kab. Tuban (Kec. Kerek & Bancar)',
        peternak: 'Kelompok Peternak Sapi Potong PO & Pasar Hewan Tuban',
        detail: 'Sapi Potong Peranakan Ongole (PO) • 345.000 Ekor Sapi Potong',
        query: 'Pasar Hewan Tuban',
        zoom: 15,
        badge: 'Tuban: Lumbung Sapi Potong PO'
    },
    'lumajang': {
        kota: 'Kab. Lumajang (Kec. Senduro)',
        peternak: 'Kelompok Peternak Kambing Senduro & Balai Pembibitan Plasma Nutfah',
        detail: 'Kambing Senduro Unggul (Plasma Nutfah Nasional) • 48.200 Ekor',
        query: 'Sentra Kambing Senduro Lumajang',
        zoom: 15,
        badge: 'Lumajang: Plasma Nutfah Kambing'
    },
    'bojonegoro': {
        kota: 'Kab. Bojonegoro (Kec. Tambakrejo & Dander)',
        peternak: 'Kelompok Tani Ternak Sapi Lembu Setia & Sentra Limbah Jagung',
        detail: 'Sapi Potong & Pakan Hijauan Jagung • 220.000 Ekor',
        query: 'Sentra Peternakan Sapi Bojonegoro',
        zoom: 15,
        badge: 'Bojonegoro: Sentra Sapi Potong'
    },
    'madura': {
        kota: 'Kab. Pamekasan, Madura (Kec. Galis)',
        peternak: 'Sentra Pemuliaan Sapi Madura & Pasar Hewan Keppo Galis',
        detail: 'Sapi Madura Murni (Plasma Nutfah Karapan & Pedaging) • 580.000 Ekor se-Madura',
        query: 'Pasar Hewan Keppo Pamekasan',
        zoom: 15,
        badge: 'Madura: Sentra Sapi Madura'
    },
    'banyuwangi': {
        kota: 'Kab. Banyuwangi (Kec. Wongsorejo)',
        peternak: 'Sentra Kawasan Peternakan Rakyat Sapi Potong Wongsorejo',
        detail: 'Sapi Potong & Ruminansia Integrasi Perkebunan • 160.000 Ekor',
        query: 'Sentra Peternakan Sapi Wongsorejo Banyuwangi',
        zoom: 14,
        badge: 'Banyuwangi: Kawasan Ruminansia'
    }
};

function selectSentra(key, buttonElement) {
    const data = sentraDatabase[key];
    if (!data) return;

    // Arahkan iframe Google Maps langsung ke kota dan titik peternak
    const iframe = document.getElementById('masp-map-frame');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(data.query)}&t=&z=${data.zoom}&ie=UTF8&iwloc=&output=embed`;
    }

    updateMaspInfo(data.badge);

    const kotaElem = document.getElementById('masp-target-kota');
    if (kotaElem) kotaElem.textContent = data.kota;

    const peternakElem = document.getElementById('masp-target-peternak');
    if (peternakElem) peternakElem.textContent = data.peternak;

    const detailElem = document.getElementById('masp-target-detail');
    if (detailElem) detailElem.textContent = data.detail;

    const extLink = document.getElementById('masp-external-link');
    if (extLink) {
        extLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.query)}`;
    }

    const targetLink = document.getElementById('masp-target-link');
    if (targetLink) {
        targetLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.query)}`;
    }

    if (buttonElement) {
        document.querySelectorAll('.masp-filter-btn').forEach(btn => {
            btn.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition';
        });
        buttonElement.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-primary-600 text-white shadow-xs transition';
    }
}

function setMaspLocation(locationQuery, zoomLevel, label, buttonElement) {
    const iframe = document.getElementById('masp-map-frame');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(locationQuery)}&t=&z=${zoomLevel}&ie=UTF8&iwloc=&output=embed`;
    }

    updateMaspInfo(label);

    const extLink = document.getElementById('masp-external-link');
    if (extLink) {
        extLink.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(locationQuery)}`;
    }

    if (buttonElement) {
        document.querySelectorAll('.masp-filter-btn').forEach(btn => {
            btn.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition';
        });
        buttonElement.className = 'masp-filter-btn shrink-0 px-2.5 py-1 rounded-lg text-xs font-medium bg-primary-600 text-white shadow-xs transition';
    }
}

function initCharts() {
    if (typeof ApexCharts === 'undefined') {
        console.warn('ApexCharts belum siap.');
        return;
    }

    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9ca3af' : '#475569';
    const gridColor = isDarkMode ? '#374151' : '#f1f5f9';

    // 1. Chart Distribusi Populasi Ternak di Jawa Timur (Horizontal Bar)
    const distOptions = {
        series: [{
            name: 'Populasi Ternak',
            data: [74.2, 52.8, 4.92, 4.35, 0.31]
        }],
        chart: {
            type: 'bar',
            height: 290,
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
                barHeight: '52%',
                distributed: true
            }
        },
        colors: ['#013A85', '#009FD2', '#209527', '#FBBB03', '#8b5cf6'],
        dataLabels: {
            enabled: true,
            formatter: (val) => `${val} Jt Ekor`,
            style: {
                fontSize: '11px',
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                colors: [isDarkMode ? '#ffffff' : '#0f172a']
            },
            offsetX: 8
        },
        legend: { show: false },
        xaxis: {
            categories: ['Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Sapi Potong', 'Kambing & Domba', 'Sapi Perah'],
            labels: {
                style: { colors: textColor, fontSize: '11px' },
                formatter: (val) => `${val} Jt`
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: { colors: textColor, fontSize: '11px', fontWeight: 500 }
            }
        },
        grid: {
            borderColor: gridColor,
            strokeDashArray: 4,
            xaxis: { lines: { show: true } }
        },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            y: {
                formatter: (val) => `${val.toLocaleString('id-ID')} Juta Ekor`
            }
        }
    };

    const distElem = document.querySelector('#chart-distribusi-ternak');
    if (distElem) {
        if (distChartInstance) {
            distChartInstance.destroy();
        }
        distElem.innerHTML = '';
        distChartInstance = new ApexCharts(distElem, distOptions);
        distChartInstance.render();
    }

    // 2. Chart Produksi Komoditas Utama Jawa Timur (Column Bar)
    const prodOptions = {
        series: [{
            name: 'Volume Produksi',
            data: [568, 534, 442, 115]
        }],
        chart: {
            type: 'bar',
            height: 290,
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '45%',
                distributed: true,
                dataLabels: { position: 'top' }
            }
        },
        colors: ['#FBBB03', '#009FD2', '#209527', '#013A85'],
        dataLabels: {
            enabled: true,
            formatter: (val) => `${val} Rb Ton`,
            offsetY: -20,
            style: {
                fontSize: '11px',
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                colors: [textColor]
            }
        },
        legend: { show: false },
        xaxis: {
            categories: ['Telur Ayam Ras', 'Susu Sapi Segar', 'Daging Ayam', 'Daging Sapi'],
            labels: {
                style: { colors: textColor, fontSize: '11px', fontWeight: 500 }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: { colors: textColor, fontSize: '11px' },
                formatter: (val) => `${val} Rb`
            }
        },
        grid: {
            borderColor: gridColor,
            strokeDashArray: 4
        },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            y: {
                formatter: (val) => `${val.toLocaleString('id-ID')} Ribu Ton / Tahun`
            }
        }
    };

    const prodElem = document.querySelector('#chart-produksi-komoditas');
    if (prodElem) {
        if (prodChartInstance) {
            prodChartInstance.destroy();
        }
        prodElem.innerHTML = '';
        prodChartInstance = new ApexCharts(prodElem, prodOptions);
        prodChartInstance.render();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initCharts();

    // Re-render ApexCharts saat tema gelap/terang diubah
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        setTimeout(initCharts, 200);
    });
});
</script>
@endpush

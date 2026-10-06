@extends('layouts.app')

@section('title', 'Pelatihan & Bimbingan Teknis — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang Pembibitan & Produksi
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Pelatihan & Bimbingan Teknis
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Program peningkatan kapasitas peternak bersama BBPP Batu dan akademisi peternakan Jawa Timur.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="#sertifikat" class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition">
            Sertifikat Saya
        </a>
    </div>
</div>

<!-- Tabs Nav -->
<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-xs font-medium text-gray-500 dark:text-gray-400 gap-4">
        <li>
            <a href="#jadwal" class="inline-block py-2.5 text-primary-700 border-b-2 border-primary-700 font-semibold dark:text-primary-400 dark:border-primary-400">
                Jadwal Bimtek
            </a>
        </li>
        <li>
            <a href="#modul" class="inline-block py-2.5 hover:text-gray-900 dark:hover:text-white">
                Modul & Video
            </a>
        </li>
        <li>
            <a href="#sertifikat" class="inline-block py-2.5 hover:text-gray-900 dark:hover:text-white">
                Sertifikat Digital
            </a>
        </li>
    </ul>
</div>

<!-- Section 1: Jadwal Bimtek -->
<div id="jadwal" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 flex flex-col justify-between shadow-xs">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded dark:bg-green-950/60 dark:text-green-300">
                        Terbuka
                    </span>
                    <span class="text-[11px] text-gray-400">Sisa 14 Kuota</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Formulasi Pakan Ransum & Silase
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Efisiensi biaya pakan mandiri dengan limbah pertanian lokal dan probiotik.
                </p>

                <div class="mt-3.5 space-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Waktu:</span> 12–14 Okt 2026
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Lokasi:</span> BBPP Songgoriti, Batu
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Pengajar:</span> Dr. Ir. Hendro Wibowo
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
                <span class="font-semibold text-cyan-700 dark:text-cyan-400">Gratis (APBD)</span>
                <button
                    type="button"
                    onclick="alert('Pendaftaran Bimtek Silase berhasil dikirim!')"
                    class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white rounded-md transition"
                >
                    Daftar
                </button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 flex flex-col justify-between shadow-xs">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded dark:bg-green-950/60 dark:text-green-300">
                        Terbuka
                    </span>
                    <span class="text-[11px] text-gray-400">Sisa 22 Kuota</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Biosekuriti & Pencegahan Penyakit
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    SOP sterilisasi kandang, deteksi dini PMK/LSD, dan manajemen sanitasi.
                </p>

                <div class="mt-3.5 space-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Waktu:</span> 19–20 Okt 2026
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Lokasi:</span> Puskeswan Pandaan
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Pengajar:</span> drh. Nur Cahyo, M.Vet
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
                <span class="font-medium text-primary-700 dark:text-primary-400">Gratis (APBD)</span>
                <button
                    type="button"
                    onclick="alert('Pendaftaran Bimtek Biosekuriti berhasil!')"
                    class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white rounded-md transition"
                >
                    Daftar
                </button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 flex flex-col justify-between shadow-xs">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">
                        Webinar
                    </span>
                    <span class="text-[11px] text-gray-400">Kuota 250</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Pemasaran Digital & KUR Peternakan
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Branding produk olahan, akses permodalan KUR, dan integrasi pasar digital.
                </p>

                <div class="mt-3.5 space-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Waktu:</span> 28 Okt 2026 (13:00)
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Media:</span> Zoom Webinar Disnak
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Pemateri:</span> OJK Jatim & Praktisi
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
                <span class="font-medium text-primary-700 dark:text-primary-400">Daring</span>
                <button
                    type="button"
                    onclick="alert('Link Zoom Webinar telah dikirim ke WhatsApp Anda!')"
                    class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white rounded-md transition"
                >
                    Daftar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: Modul & Video -->
<div id="modul" class="mb-6 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
            Modul & Video Praktik
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Materi resmi dinas dapat diakses dan diunduh secara bebas.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
            <div>
                <span class="font-bold text-gray-900 dark:text-white block">SOP Budidaya Sapi Perah Berkelanjutan</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">Fakultas Peternakan UB · PDF · 4.8 MB</span>
            </div>
            <button onclick="alert('Mengunduh SOP...')" class="font-medium text-primary-700 dark:text-primary-400 hover:underline">Unduh</button>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
            <div>
                <span class="font-bold text-gray-900 dark:text-white block">Teknologi Silase & Hay Ternak</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">BBPP Batu · PDF · 3.1 MB</span>
            </div>
            <button onclick="alert('Mengunduh Modul...')" class="font-medium text-primary-700 dark:text-primary-400 hover:underline">Unduh</button>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
            <div>
                <span class="font-bold text-gray-900 dark:text-white block">Video Pemerahan Higienis Menekan TPC</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">Durasi 18 Menit · 720p MP4</span>
            </div>
            <button onclick="alert('Memutar Video...')" class="font-medium text-primary-700 dark:text-primary-400 hover:underline">Tonton</button>
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
            <div>
                <span class="font-bold text-gray-900 dark:text-white block">Video Sanitasi & Biosekuriti Mandiri</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">Durasi 14 Menit · 720p MP4</span>
            </div>
            <button onclick="alert('Memutar Video...')" class="font-medium text-primary-700 dark:text-primary-400 hover:underline">Tonton</button>
        </div>
    </div>
</div>

<!-- Section 3: Sertifikat Digital -->
<div id="sertifikat" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
            Sertifikat Digital Saya
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Verifikasi tanda tangan elektronik Dinas Peternakan Jawa Timur.</p>
    </div>

    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200/80 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-1.5 py-0.2 rounded">
                    Terverifikasi
                </span>
                <span class="text-gray-400 text-[11px]">SK: DISNAK-JATIM/2026/CERT-891</span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                Sertifikasi Peternak Sapi Perah Higienis
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mt-0.5">
                Penerima: Slamet Rahardjo (JTM-PAS-0024) · Diterbitkan 15 Agustus 2026
            </p>
        </div>

        <button
            type="button"
            onclick="alert('Mengunduh Sertifikat PDF...')"
            class="px-3.5 py-2 bg-primary-700 hover:bg-primary-800 text-white rounded-md shrink-0 transition"
        >
            Unduh PDF
        </button>
    </div>
</div>
@endsection

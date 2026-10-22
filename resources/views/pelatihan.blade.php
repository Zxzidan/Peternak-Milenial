@extends('layouts.app')

@section('title', 'Pembelajaran & Bimbingan Teknis — Peternak Milenial Jatim')

@section('content')
@php
    $currentUser = auth()->user();
    $activeTab = request('tab', 'pembelajaran');
    if ($activeTab === 'modul') {
        $activeTab = 'pembelajaran';
    } elseif ($activeTab === 'jadwal' && !request()->has('view_offline')) {
        $activeTab = 'zoom';
    } elseif (in_array($activeTab, ['bimtek_offline', 'jadwal_offline', 'offline', 'tatap_muka'])) {
        $activeTab = 'bimtek_offline';
    }
    if (!in_array($activeTab, ['pembelajaran', 'zoom', 'bimtek_offline', 'kuis', 'sertifikat'])) {
        $activeTab = 'pembelajaran';
    }

    $selectedTopic = request('topic', 'all');
    $searchQuery = request('search', '');

    // Current hour greeting
    $hour = (int) date('H');
    $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    $watchProgressPct = $totalMaterialsCount > 0 ? (int) round(($watchedCount / $totalMaterialsCount) * 100) : 0;
@endphp

<div class="space-y-6 sm:space-y-7 pt-1 sm:pt-2">

    <!-- Notification Alerts -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs sm:text-sm flex items-center justify-between shadow-2xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold ml-2">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-900 dark:text-red-200 text-xs sm:text-sm flex items-center justify-between shadow-2xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold ml-2">&times;</button>
    </div>
    @endif

    <!-- 1. Search Bar & Filter Controls -->
    <form method="GET" action="{{ route('pelatihan') }}" class="w-full flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
        <input type="hidden" name="tab" value="{{ $activeTab }}">

        <!-- Search Input Field -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
            <input
                type="text"
                name="search"
                value="{{ $searchQuery }}"
                placeholder="Cari modul video, materi pakan, atau narasumber..."
                class="w-full h-11 pl-10 pr-4 bg-white dark:bg-gray-800 border border-gray-200/90 dark:border-gray-700 rounded-xl text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-600/30 focus:border-primary-600 shadow-2xs transition"
            />
        </div>

        <!-- Topic Filter & Search Actions -->
        <div class="flex items-center gap-2 shrink-0">
            <div class="relative">
                <select
                    name="topic"
                    onchange="this.form.submit()"
                    class="appearance-none h-11 bg-white dark:bg-gray-800 border border-gray-200/90 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs font-medium rounded-xl pl-3.5 pr-8 focus:outline-none focus:ring-2 focus:ring-primary-600/30 focus:border-primary-600 shadow-2xs transition cursor-pointer"
                >
                    <option value="all" {{ $selectedTopic === 'all' ? 'selected' : '' }}>Semua Topik Modul</option>
                    <option value="Manajemen Pakan" {{ $selectedTopic === 'Manajemen Pakan' ? 'selected' : '' }}>Manajemen Pakan</option>
                    <option value="Produksi & Mutu Susu" {{ $selectedTopic === 'Produksi & Mutu Susu' ? 'selected' : '' }}>Produksi & Mutu Susu</option>
                    <option value="Kesehatan Ternak" {{ $selectedTopic === 'Kesehatan Ternak' ? 'selected' : '' }}>Kesehatan Ternak</option>
                    <option value="Bibit & Budidaya" {{ $selectedTopic === 'Bibit & Budidaya' ? 'selected' : '' }}>Bibit & Budidaya</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </div>
            </div>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-1.5 h-11 px-4 sm:px-5 bg-primary-700 hover:bg-primary-800 text-white rounded-xl text-xs font-semibold shadow-2xs hover:shadow-xs transition cursor-pointer shrink-0"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                <span>Cari</span>
            </button>

            @if($searchQuery || $selectedTopic !== 'all')
            <a
                href="{{ route('pelatihan', ['tab' => $activeTab]) }}"
                class="inline-flex items-center justify-center h-11 px-3.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-750 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-medium transition shrink-0"
            >
                Reset
            </a>
            @endif
        </div>
    </form>

    <!-- 2. Hero Indigo Gradient Banner (Ottertag Inspired) with Quick Actions -->
    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#4F46E5] via-[#7C3AED] to-[#9333EA] p-5 sm:p-8 text-white shadow-md">
        <!-- Sparkle & Glow Decorative Elements -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-16 text-white/30 hidden sm:block">
            <svg class="w-10 h-10 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/></svg>
        </div>
        <div class="absolute bottom-6 right-48 text-white/20 hidden sm:block">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z"/></svg>
        </div>

        <div class="relative z-10 max-w-2xl space-y-3">
           
            <h1 class="text-xl sm:text-3xl font-extrabold tracking-tight leading-snug">
                @if($activeTab === 'pembelajaran')
                    Video &amp; Modul Pembelajaran Mandiri
                @elseif($activeTab === 'zoom')
                    Jadwal Pembelajaran &amp; Kelas Zoom Interaktif
                @elseif($activeTab === 'bimtek_offline')
                    Bimbingan Teknis (Bimtek) Tatap Muka Lapangan
                @elseif($activeTab === 'kuis')
                    Bank Soal &amp; Kuis Evaluasi Pembelajaran
                @elseif($activeTab === 'sertifikat')
                    Sertifikat Digital &amp; Verifikasi E-Signature
                @endif
            </h1>
            @if($currentUser && $currentUser->isAdmin())
            <p class="text-xs sm:text-sm text-indigo-100 leading-relaxed max-w-xl">
                @if($activeTab === 'pembelajaran')
                    Kelola kurikulum video pembelajaran, jadwalkan Bimtek daring via Zoom beserta dokumen materi, susun butir bank soal evaluasi kuis, dan pantau kelulusan kompetensi peternak milenial.
                @elseif($activeTab === 'zoom')
                    Kelola jadwal bimbingan teknis interaktif tatap maya melalui Zoom Meeting bersama instruktur ahli BBPP Batu dan bagikan dokumen silabus resmi.
                @elseif($activeTab === 'bimtek_offline')
                    Kelola program Bimbingan Teknis (Bimtek) tatap muka lapangan, pantau nomor registrasi peserta, dan verifikasi dokumen persyaratan resmi peternak milenial.
                @elseif($activeTab === 'kuis')
                    Kelola bank soal evaluasi pemahaman modul. Tambahkan butir pertanyaan pilihan ganda (A, B, C, D) dan pantau capaian nilai kompetensi peternak.
                @elseif($activeTab === 'sertifikat')
                    Terbitkan e-sertifikat kompetensi resmi ber-barcode dengan tanda tangan digital dan sistem verifikasi otomatis Dinas Peternakan Jawa Timur.
                @endif
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-2.5">
                @if($activeTab === 'pembelajaran')
                <button
                    type="button"
                    onclick="document.getElementById('modal-upload-materi-admin').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Unggah Video &amp; Dokumen</span>
                </button>
                @elseif($activeTab === 'zoom')
                <button
                    type="button"
                    onclick="document.getElementById('modal-jadwalkan-zoom-admin').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                    <span>Jadwalkan Sesi Zoom Baru</span>
                </button>
                @elseif($activeTab === 'bimtek_offline')
                <button
                    type="button"
                    onclick="document.getElementById('modal-jadwalkan-bimtek-offline-admin').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Jadwalkan Bimtek Offline Baru</span>
                </button>
                @elseif($activeTab === 'kuis')
                <button
                    type="button"
                    onclick="document.getElementById('modal-buat-soal-admin').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 011.13-1.897L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                    <span>Tambah Butir Soal Baru</span>
                </button>
                @elseif($activeTab === 'sertifikat')
                <button
                    type="button"
                    onclick="openCreateCertificateModal()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Buat Sertifikat Baru</span>
                </button>
                @endif
            </div>
            @else
            <p class="text-xs sm:text-sm text-indigo-100 leading-relaxed max-w-xl">
                @if($activeTab === 'pembelajaran')
                    Akses video pembelajaran resmi, unduh dokumen panduan SOP standar BBPP Batu &amp; Fapet UB, kerjakan soal kuis pemahaman, dan ikuti kelas daring interaktif via Zoom.
                @elseif($activeTab === 'zoom')
                    Ikuti bimbingan teknis daring interaktif tatap maya bersama instruktur ahli BBPP Batu dan narasumber perbankan/industri peternakan.
                @elseif($activeTab === 'bimtek_offline')
                    Daftar program bimbingan teknis tatap muka lapangan di Balai Besar Pelatihan Peternakan (BBPP) dan Puskeswan Jawa Timur dengan mengunggah dokumen persyaratan resmi untuk dicatat nomor registrasinya.
                @elseif($activeTab === 'kuis')
                    Kerjakan butir soal pilihan ganda evaluasi setelah menyimak modul pembelajaran untuk menguji kesiapan dan pemahaman SOP peternakan Anda.
                @elseif($activeTab === 'sertifikat')
                    Unduh e-sertifikat kelulusan digital resmi ber-barcode hasil keikutsertaan pelatihan dan bimbingan teknis Dinas Peternakan Jawa Timur.
                @endif
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-2.5">
                @if($activeTab === 'pembelajaran')
                <a
                    href="#section-modul-video"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                    <span>Lanjutkan Menonton Modul</span>
                </a>
                <a
                    href="{{ route('pelatihan', ['tab' => 'zoom']) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/20 border border-white/30 text-white font-semibold text-xs hover:bg-white/30 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span>Lihat Jadwal Zoom ({{ $upcomingZoomCount }})</span>
                </a>
                @elseif($activeTab === 'zoom')
                <a
                    href="#section-zoom"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                    <span>Lihat Sesi Zoom Terbuka</span>
                </a>
                @elseif($activeTab === 'bimtek_offline')
                <a
                    href="#section-bimtek-offline"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span>Lihat Jadwal Bimtek Lapangan ({{ $upcomingOfflineCount }})</span>
                </a>
                @elseif($activeTab === 'kuis')
                <a
                    href="#section-kuis"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mulai Kuis Evaluasi</span>
                </a>
                @elseif($activeTab === 'sertifikat')
                <a
                    href="#section-sertifikat"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-xs hover:bg-indigo-50 transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                    <span>Cek Sertifikat Kelulusan</span>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if(!($currentUser && $currentUser->isAdmin()))
    <!-- 3. Current Section Breadcrumb Header (Navigation Managed Exclusively via Sidebar) -->
    <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800 pb-2">
        <div class="flex items-center gap-2 text-xs sm:text-sm">
            <span class="font-medium text-gray-500 dark:text-gray-400">Pelatihan &amp; Bimbingan Teknis</span>
            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="font-bold text-gray-900 dark:text-white">
                @if($activeTab === 'pembelajaran')
                    Video Pembelajaran
                @elseif($activeTab === 'zoom')
                    Jadwal Kelas Zoom
                @elseif($activeTab === 'bimtek_offline')
                    Bimtek Offline
                @elseif($activeTab === 'kuis')
                    Soal Evaluasi
                @elseif($activeTab === 'sertifikat')
                    Sertifikat Digital
                @endif
            </span>
        </div>
    </div>
    @endif

    <!-- 4. Main Content Area -->
    <div class="w-full space-y-7 {{ $currentUser && $currentUser->isAdmin() ? 'pt-8 sm:pt-10' : '' }}">

            @if($activeTab === 'pembelajaran')
            <!-- ========================================== -->
            <!-- TAB 1: MODUL & VIDEO PEMBELAJARAN (OTTERTAG) -->
            <!-- ========================================== -->
            <div id="section-modul-video" class="space-y-6">

                <!-- Section Title & Category Filter Badges -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            Video Pembelajaran Mandiri (Continue Watching)
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Tonton rekaman materi teknis budidaya, nutrisi pakan, dan SOP peternakan dari Dinas Peternakan Jawa Timur.
                        </p>
                    </div>

                    @if($currentUser && $currentUser->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('modal-upload-materi-admin').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold shadow-2xs transition shrink-0 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Tambah Modul Video</span>
                    </button>
                    @endif
                </div>

                <!-- Video Cards Grid (3 Columns on md/lg) -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
                    @forelse($materials as $material)
                    @php
                        $prog = $userProgress->get($material->id);
                        $isWatched = $prog ? $prog->is_watched : false;
                        $pct = $isWatched ? 100 : ($prog ? $prog->watch_percentage : 0);
                        $hasQuiz = $material->quiz !== null;
                        $quizPassed = $hasQuiz && $quizAttempts->where('learning_quiz_id', $material->quiz->id)->where('passed', true)->isNotEmpty();
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                        <!-- Thumbnail & Video Badge -->
                        <div class="relative aspect-video w-full bg-gray-900 overflow-hidden">
                            <img
                                src="{{ $material->thumbnail_url }}"
                                alt="{{ $material->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            <!-- Play Overlay Button -->
                            <button
                                type="button"
                                onclick="openVideoPlayerModal({{ json_encode($material) }}, '{{ $material->video_embed_url }}')"
                                class="absolute inset-0 flex items-center justify-center group-hover:opacity-100 transition-opacity cursor-pointer"
                                title="Putar Video Pembelajaran"
                            >
                                <div class="w-11 h-11 rounded-full bg-white/90 text-primary-700 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </button>

                            <!-- Category / Topic Badge -->
                            <div class="absolute top-2.5 left-2.5">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide bg-indigo-600/90 text-white backdrop-blur-xs">
                                    {{ $material->topic ?? 'PETERNAKAN' }}
                                </span>
                            </div>

                            <!-- Duration & Level Badge -->
                            <div class="absolute bottom-2.5 right-2.5 flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-black/70 text-white backdrop-blur-xs flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $material->duration ?? '20 Menit' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 sm:p-4.5 flex-1 flex flex-col justify-between space-y-3">
                            <div class="space-y-1.5">
                                <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white line-clamp-2 leading-snug group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">
                                    {{ $material->title }}
                                </h3>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ $material->description ?? 'Modul pembelajaran standar peningkatan kompetensi peternak milenial Jawa Timur.' }}
                                </p>
                            </div>

                            <!-- Progress Bar / Admin Publish Metric -->
                            @if($currentUser && $currentUser->isAdmin())
                            <div class="space-y-1 pt-1 border-t border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center justify-between text-[10px] text-gray-500 font-medium">
                                    <span>Status Modul</span>
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Diterbitkan Dinas
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-[10px] text-gray-400">
                                    <span>Total Tayang: {{ $material->views_count }}x tonton</span>
                                    <span>{{ $hasQuiz ? ($material->quiz->questions->count() . ' Butir Soal') : 'Belum Ada Kuis' }}</span>
                                </div>
                            </div>
                            @else
                            <div class="space-y-1 pt-1 border-t border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center justify-between text-[10px] text-gray-500 font-medium">
                                    <span>Progres Belajar</span>
                                    <span class="{{ $isWatched ? 'text-emerald-600 font-bold' : 'text-gray-500' }}">
                                        {{ $isWatched ? '100% Selesai' : $pct . '% Ditonton' }}
                                    </span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div
                                        class="h-full rounded-full transition-all duration-500 {{ $isWatched ? 'bg-emerald-500' : 'bg-primary-600' }}"
                                        style="width: {{ max(6, $pct) }}%"
                                    ></div>
                                </div>
                            </div>
                            @endif

                            <!-- Instructor Info -->
                            <div class="flex items-center justify-between pt-1">
                                <div class="flex items-center gap-2 min-w-0">
                                    <img
                                        src="{{ asset('img/dokter.png') }}"
                                        alt="{{ $material->instructor_name }}"
                                        class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-gray-600 shrink-0"
                                    />
                                    <div class="min-w-0 truncate">
                                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 block truncate">
                                            {{ $material->instructor_name ?? 'Dr. Ir. Budi Santoso' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 block truncate">
                                            {{ $material->author_institution }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($currentUser && $currentUser->isPeternak() && $isWatched && $quizPassed)
                            <div class="px-2.5 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-[11px] text-emerald-800 dark:text-emerald-300 flex items-center justify-between font-semibold">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Modul &amp; Evaluasi Selesai</span>
                                </span>
                                <span class="text-emerald-700 dark:text-emerald-400 font-bold text-[10px]">
                                    Lulus Pemahaman
                                </span>
                            </div>
                            @endif

                            <!-- Action Buttons: Admin Management vs Peternak Learner -->
                            <div class="pt-2 flex items-center gap-1.5 border-t border-gray-100 dark:border-gray-700">
                                @if($currentUser && $currentUser->isAdmin())
                                <!-- Admin Action: Pratinjau Video (Bukan Mengerjakan) -->
                                <button
                                    type="button"
                                    onclick="openVideoPlayerModal({{ json_encode($material) }}, '{{ $material->video_embed_url }}')"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-indigo-50 dark:bg-indigo-950/60 hover:bg-indigo-100 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-semibold transition cursor-pointer"
                                    title="Pratinjau Video Modul"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>Pratinjau</span>
                                </button>

                                <a
                                    href="{{ route('pelatihan.document.download', ['type' => 'material', 'id' => $material->id]) }}"
                                    class="inline-flex items-center justify-center px-2 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-medium transition"
                                    title="Unduh Dokumen PDF Modul"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                </a>

                                @if($hasQuiz)
                                <button
                                    type="button"
                                    onclick="openAdminAddQuestionModal({{ $material->quiz->id }})"
                                    class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-purple-50 dark:bg-purple-950/60 hover:bg-purple-100 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 rounded-lg text-xs font-semibold transition cursor-pointer"
                                    title="Tambah Butir Soal ke Kuis Modul Ini"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    <span>Soal</span>
                                </button>
                                @else
                                <button
                                    type="button"
                                    onclick="openAdminCreateQuizModal({{ $material->id }}, '{{ addslashes($material->title) }}')"
                                    class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-semibold transition cursor-pointer shadow-2xs"
                                    title="Buat Kuis Evaluasi untuk Modul Ini"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    <span>Kuis</span>
                                </button>
                                @endif

                                <form action="{{ route('pelatihan.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Hapus modul {{ $material->title }}?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition cursor-pointer" title="Hapus Modul">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                                @else
                                <!-- Peternak Action: Tonton Video & Kerjakan Kuis -->
                                <button
                                    type="button"
                                    onclick="openVideoPlayerModal({{ json_encode($material) }}, '{{ $material->video_embed_url }}')"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-primary-700 hover:bg-primary-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer shadow-2xs"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                    <span>Tonton</span>
                                </button>

                                <a
                                    href="{{ route('pelatihan.document.download', ['type' => 'material', 'id' => $material->id]) }}"
                                    class="inline-flex items-center justify-center px-2 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-medium transition"
                                    title="Unduh Dokumen PDF Modul"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                </a>

                                @if($hasQuiz)
                                <button
                                    type="button"
                                    onclick="openQuizRunnerModal({{ json_encode($material->quiz) }}, {{ json_encode($material->quiz->questions) }})"
                                    class="inline-flex items-center justify-center px-2.5 py-1.5 bg-purple-50 dark:bg-purple-950/60 hover:bg-purple-100 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 rounded-lg text-xs font-semibold transition cursor-pointer"
                                    title="Kerjakan Soal Kuis"
                                >
                                    Kuis
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum ada modul pembelajaran yang sesuai</h4>
                        <p class="text-xs text-gray-400 mt-1">Coba reset filter topik atau kata kunci pencarian Anda.</p>
                    </div>
                    @endforelse
                </div>

            </div>

            @elseif($activeTab === 'zoom')
            <!-- ========================================== -->
            <!-- TAB 2: JADWAL PEMBELAJARAN SECARA ZOOM -->
            <!-- ========================================== -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        @if(!($currentUser && $currentUser->isAdmin()))
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300 text-[11px] font-bold">
                                Kelas Daring Interaktif
                            </span>
                            <span class="text-xs text-gray-500">Live Zoom Meetings</span>
                        </div>
                        @endif
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            Jadwal Pembelajaran &amp; Kelas Zoom Interaktif
                        </h2>
                        <p class="text-xs text-gray-500">
                            Ikuti webinar interaktif tatap maya bersama instruktur ahli BBPP Batu dan narasumber perbankan/industri susu.
                        </p>
                    </div>

                    @if($currentUser && $currentUser->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('modal-jadwalkan-zoom-admin').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold shadow-2xs transition shrink-0 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Jadwalkan Sesi Zoom Baru</span>
                    </button>
                    @endif
                </div>

                <!-- Zoom Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                    @forelse($zoomTrainings as $zt)
                    @php
                        $isRegistered = in_array($zt->id, $myRegisteredTrainingIds);
                        $status = $zt->zoom_status;
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <!-- Status & Date -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                    @if($status === 'ongoing')
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                        LIVE HARI INI
                                    </span>
                                    @elseif($status === 'upcoming')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                        AKAN DATANG
                                    </span>
                                    @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        SELESAI
                                    </span>
                                    @endif
                                </div>

                                <span class="text-xs font-semibold text-gray-500">
                                    {{ $zt->start_date ? $zt->start_date->format('d M Y') : 'Terjadwal' }}
                                </span>
                            </div>

                            <!-- Title & Description -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-snug">
                                    {{ $zt->title }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $zt->description }}
                                </p>
                            </div>

                            <!-- Instructor & Time -->
                            <div class="bg-gray-50 dark:bg-gray-750 p-3 rounded-xl space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $zt->instructor }}</span>
                                    <span class="text-gray-400 text-[11px]">({{ $zt->instructor_title ?? 'Narasumber' }})</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 text-[11px]">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $zt->time_info ?? '13:00 - 16:30 WIB' }}</span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span>Sisa Kuota: {{ $zt->remaining_quota }} peserta</span>
                                </div>
                            </div>

                            <!-- Zoom Credentials Box -->
                            <div class="p-3 bg-blue-50/70 dark:bg-blue-950/40 rounded-xl border border-blue-200/80 dark:border-blue-900/60 space-y-1.5 text-xs text-blue-950 dark:text-blue-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-blue-800 dark:text-blue-300">Tautan Resmi Zoom Meeting:</span>
                                    <span class="text-[10px] text-blue-600 dark:text-blue-400">Ruang Kelas Disnak Jatim</span>
                                </div>
                                <div class="flex items-center justify-between font-mono text-[11px] bg-white dark:bg-gray-800 p-2 rounded-lg border border-blue-100 dark:border-blue-800">
                                    <span>Meeting ID: <strong>{{ $zt->zoom_meeting_id ?? '883 9218 2019' }}</strong></span>
                                    <span>Passcode: <strong>{{ $zt->zoom_passcode ?? 'JATIM2026' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center gap-2">
                            <!-- Direct Join Zoom Link -->
                            @if(!empty($zt->zoom_link))
                            <a
                                href="{{ $zt->zoom_link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-xs"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                                <span>Gabung Zoom</span>
                            </a>
                            @endif

                            <!-- Unduh Silabus / Dokumen PDF -->
                            <a
                                href="{{ route('pelatihan.document.download', ['type' => 'zoom', 'id' => $zt->id]) }}"
                                class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold text-gray-700 transition"
                                title="Unduh Silabus &amp; Slide Materi"
                            >
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                <span>Materi (PDF)</span>
                            </a>

                            <!-- Daftar Pelatihan jika belum terdaftar -->
                            @if($currentUser && $currentUser->isPeternak())
                                @if(!$isRegistered)
                                <form action="{{ route('pelatihan.register', $zt) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tab" value="zoom">
                                    <button
                                        type="submit"
                                        class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition cursor-pointer"
                                    >
                                        Daftar Sesi
                                    </button>
                                </form>
                                @else
                                <span class="px-2.5 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-xs font-bold">
                                    Terdaftar &check;
                                </span>
                                @endif
                            @endif

                            @if($currentUser && $currentUser->isAdmin())
                            <form action="{{ route('pelatihan.destroy', $zt) }}" method="POST" onsubmit="return confirm('Hapus sesi Zoom ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tab" value="zoom">
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Hapus Sesi Zoom">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum ada sesi pembelajaran Zoom mendatang</h4>
                        <p class="text-xs text-gray-400 mt-1">Admin dinas akan memperbarui jadwal Bimtek daring secara berkala.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @elseif($activeTab === 'bimtek_offline')
            <!-- ======================================================== -->
            <!-- TAB: BIMTEK (BIMBINGAN TEKNIS) TATAP MUKA LAPANGAN / OFFLINE -->
            <!-- ======================================================== -->
            <div id="section-bimtek-offline" class="space-y-6">

                <!-- Header Title & Action Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        @if(!($currentUser && $currentUser->isAdmin()))
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 text-[11px] font-extrabold uppercase tracking-wide">
                                Tatap Muka Lapangan
                            </span>
                            <span class="text-xs text-gray-500">BBPP Batu &amp; Sentra Peternakan Jatim</span>
                        </div>
                        @endif
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            Jadwal Bimbingan Teknis (Bimtek) Offline &amp; Praktik Lapangan
                        </h2>
                        <p class="text-xs text-gray-500">
                            Pelatihan langsung di sentra peternakan, Balai Pelatihan (BBPP), dan Puskeswan Jawa Timur dengan fasilitas praktik komprehensif.
                        </p>
                    </div>

                    @if($currentUser && $currentUser->isAdmin())
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            onclick="document.getElementById('modal-jadwalkan-bimtek-offline-admin').classList.remove('hidden')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-2xs transition shrink-0 cursor-pointer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            <span>Jadwalkan Bimtek Offline</span>
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Callout Banner: Persyaratan Dokumen & Pencatatan Nomor Registrasi -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-green-50 dark:from-emerald-950/40 dark:via-gray-800 dark:to-emerald-950/30 border border-emerald-200/90 dark:border-emerald-800/60 shadow-2xs">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xs sm:text-sm font-bold text-emerald-950 dark:text-emerald-100 flex items-center gap-2">
                                    <span>Alur Pendaftaran Bimtek (Bimbingan Teknis) Tatap Muka</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-200 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-200 uppercase">SOP Dinas</span>
                                </h4>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300/90 leading-relaxed max-w-3xl">
                                    Namun, jika memilih Bimtek (Bimbingan Teknis), peternak <strong>harus mendaftar dan mengunggah dokumen persyaratan</strong> terlebih dahulu (scan KTP / Surat Keterangan Usaha Peternakan / Rekomendasi Kelompok Ternak) untuk <strong>dicatat nomor registrasinya</strong> oleh sistem aplikasi Dinas Peternakan Provinsi Jawa Timur.
                                </p>
                            </div>
                        </div>

                        @if($currentUser && $currentUser->isPeternak() && $myRegistrations->where('training.is_online', false)->isNotEmpty())
                        <div class="shrink-0 bg-white dark:bg-gray-800 py-2 px-3.5 rounded-xl border border-emerald-200 dark:border-emerald-700 shadow-2xs">
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 block font-medium">Bimtek Anda Ikuti:</span>
                            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 font-mono">
                                {{ $myRegistrations->where('training.is_online', false)->count() }} Program Terdaftar
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Registration Success Ticket Card (Flash session) -->
                @if(session('registered_ticket'))
                @php $tkt = session('registered_ticket'); @endphp
                <div class="p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-emerald-500 shadow-md space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">&check;</span>
                            <div>
                                <h3 class="text-sm font-extrabold text-emerald-800 dark:text-emerald-300">Nomor Registrasi Resmi Diterbitkan &amp; Dicatat Sistem!</h3>
                                <p class="text-[11px] text-gray-500">Pendaftaran Anda telah tersimpan lengkap dengan berkas dokumen persyaratan.</p>
                            </div>
                        </div>
                        <span class="text-xs font-mono px-3 py-1 bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-200 font-bold rounded-lg border border-emerald-300 dark:border-emerald-700">
                            {{ $tkt['registration_code'] ?? 'REG-BMTK' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs bg-gray-50 dark:bg-gray-750 p-3.5 rounded-xl">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Nomor Registrasi</span>
                            <strong class="font-mono text-emerald-700 dark:text-emerald-400 text-sm">{{ $tkt['registration_code'] }}</strong>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 block">Program Bimtek</span>
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $tkt['training_title'] }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 block">Lokasi Tatap Muka</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $tkt['location'] }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 block">Dokumen Persyaratan</span>
                            <span class="font-medium text-emerald-700 dark:text-emerald-400 truncate block">{{ $tkt['document_name'] ?? 'Dokumen Terlampir' }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Bimtek Offline Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                    @forelse($offlineTrainings as $ot)
                    @php
                        $myReg = $myRegistrations->firstWhere('training_id', $ot->id);
                        $isRegistered = ($myReg !== null);
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border-2 {{ $isRegistered ? 'border-emerald-400/80 dark:border-emerald-700 shadow-sm' : 'border-gray-200/90 dark:border-gray-700 shadow-2xs' }} p-5 hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <!-- Status Badges & Schedule -->
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                        TATAP MUKA LAPANGAN
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $ot->cost_type === 'gratis_apbd' ? 'Gratis APBD' : 'Mandiri' }}
                                    </span>
                                </div>

                                <span class="text-xs font-semibold text-gray-500">
                                    {{ $ot->start_date ? $ot->start_date->format('d M Y') : 'Terjadwal' }}
                                    @if($ot->end_date && $ot->end_date != $ot->start_date)
                                        s/d {{ $ot->end_date->format('d M Y') }}
                                    @endif
                                </span>
                            </div>

                            <!-- Title & Description -->
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-snug">
                                    {{ $ot->title }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $ot->description }}
                                </p>
                            </div>

                            <!-- Location, Instructor & Quota Box -->
                            <div class="bg-gray-50 dark:bg-gray-750 p-3 rounded-xl space-y-2 text-xs">
                                <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 font-semibold">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    <span class="truncate">{{ $ot->location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    <span class="font-medium">{{ $ot->instructor }}</span>
                                    <span class="text-gray-400 text-[11px]">({{ $ot->instructor_title ?? 'Widyaiswara Ahli' }})</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400 pt-1 border-t border-gray-200/60 dark:border-gray-700">
                                    <span>Jam: {{ $ot->time_info ?? '08:00 - 15:00 WIB' }}</span>
                                    <span class="font-bold text-emerald-700 dark:text-emerald-400">Sisa Kuota: {{ $ot->remaining_quota }} peserta</span>
                                </div>
                            </div>

                            <!-- Peternak Registration Status Box -->
                            @if($isRegistered && $myReg)
                            <div class="p-3 bg-emerald-50 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800 space-y-1.5 text-xs text-emerald-950 dark:text-emerald-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-emerald-900 dark:text-emerald-200 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Nomor Registrasi Terdaftar:
                                    </span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-200 text-emerald-900 font-extrabold text-[10px] uppercase">
                                        {{ $myReg->status === 'confirmed' ? 'Diverifikasi' : $myReg->status }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-2 rounded-lg border border-emerald-100 dark:border-emerald-800">
                                    <span class="font-mono text-emerald-800 dark:text-emerald-300 font-extrabold text-xs tracking-wider">
                                        {{ $myReg->registration_code }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">
                                        {{ $myReg->registered_at ? $myReg->registered_at->format('d/m/Y H:i') : '' }}
                                    </span>
                                </div>
                                @if($myReg->requirement_document_name)
                                <div class="flex items-center justify-between text-[11px] text-gray-600 dark:text-gray-300 pt-1">
                                    <span class="truncate max-w-[200px]">Dokumen: {{ $myReg->requirement_document_name }}</span>
                                    <a href="{{ route('pelatihan.registration.document', $myReg) }}" class="text-emerald-700 dark:text-emerald-400 font-bold hover:underline">Unduh Berkas</a>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center gap-2">
                            <!-- Unduh Silabus Panduan Lapangan (jika ada) -->
                            <a
                                href="{{ route('pelatihan.document.download', ['type' => 'zoom', 'id' => $ot->id]) }}"
                                class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold text-gray-700 transition"
                                title="Unduh Silabus &amp; Panduan Praktik Lapangan"
                            >
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                <span>Silabus (PDF)</span>
                            </a>

                            <!-- Tombol Pendaftaran Peternak dengan Upload Persyaratan -->
                            @if($currentUser && $currentUser->isPeternak())
                                @if(!$isRegistered)
                                <button
                                    type="button"
                                    onclick="openRegisterBimtekOfflineModal({{ json_encode($ot) }})"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    <span>Daftar &amp; Unggah Persyaratan</span>
                                </button>
                                @else
                                <button
                                    type="button"
                                    onclick="openTicketModal({{ json_encode($myReg) }}, {{ json_encode($ot) }})"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-200 rounded-xl text-xs font-bold transition cursor-pointer"
                                >
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                                    <span>Lihat Tiket &amp; Dokumen</span>
                                </button>
                                @endif
                            @endif

                            <!-- Admin Controls -->
                            @if($currentUser && $currentUser->isAdmin())
                            <button
                                type="button"
                                onclick="openAdminTrainingParticipantsModal({{ $ot->id }}, '{{ addslashes($ot->title) }}')"
                                class="inline-flex items-center gap-1 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-xl text-xs font-semibold transition cursor-pointer"
                                title="Lihat Peserta &amp; Berkas Persyaratan"
                            >
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                <span>Peserta ({{ $ot->registrations_count }})</span>
                            </button>

                            <form action="{{ route('pelatihan.destroy', $ot) }}" method="POST" onsubmit="return confirm('Hapus program Bimtek {{ $ot->title }}?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tab" value="bimtek_offline">
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Hapus Bimtek">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum ada jadwal Bimtek tatap muka lapangan</h4>
                        <p class="text-xs text-gray-400 mt-1">Admin dinas akan memperbarui agenda bimbingan teknis secara berkala.</p>
                    </div>
                    @endforelse
                </div>

            </div>

            @elseif($activeTab === 'kuis')
            <!-- ========================================== -->
            <!-- TAB 3: KUIS & PENGERJAAN SOAL-SOAL EVALUASI -->
            <!-- ========================================== -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        @if(!($currentUser && $currentUser->isAdmin()))
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300 text-[11px] font-bold">
                                Evaluasi Mandiri
                            </span>
                            <span class="text-xs text-gray-500">Passing Grade: 70%</span>
                        </div>
                        @endif
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            {{ $currentUser && $currentUser->isAdmin() ? 'Bank Soal & Kuis Evaluasi Pembelajaran' : 'Kuis & Soal Uji Pemahaman Materi Peternak' }}
                        </h2>
                        <p class="text-xs text-gray-500">
                            {{ $currentUser && $currentUser->isAdmin()
                                ? 'Kelola bank soal evaluasi pemahaman modul. Tambahkan butir pertanyaan pilihan ganda (A, B, C, D) dan pantau capaian nilai peternak.'
                                : 'Kerjakan soal-soal pilihan ganda setelah menonton video pembelajaran untuk menguji kesiapan dan pemahaman SOP peternakan.' }}
                        </p>
                    </div>

                    @if($currentUser && $currentUser->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('modal-buat-soal-admin').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white text-xs font-semibold shadow-2xs transition shrink-0 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Tambah Butir Soal Baru</span>
                    </button>
                    @endif
                </div>

                <!-- Quiz List Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                    @forelse($quizzes as $quiz)
                    @php
                        $userAttempt = $quizAttempts->where('learning_quiz_id', $quiz->id)->sortByDesc('score')->first();
                        $qCount = $quiz->questions->count();
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300 uppercase">
                                    {{ $quiz->learningMaterial?->topic ?? 'MODUL TERNAK' }}
                                </span>

                                @if($currentUser && $currentUser->isAdmin())
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-700 bg-purple-100 dark:bg-purple-950 dark:text-purple-300 px-2.5 py-0.5 rounded-full">
                                    Bank Soal ({{ $qCount }} Butir)
                                </span>
                                @elseif($userAttempt)
                                    @if($userAttempt->passed)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-700 bg-emerald-100 dark:bg-emerald-950/80 dark:text-emerald-300 px-2.5 py-0.5 rounded-full">
                                        &check; LULUS (Skor: {{ $userAttempt->score }})
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full">
                                        Perlu Mengulang (Skor: {{ $userAttempt->score }})
                                    </span>
                                    @endif
                                @else
                                <span class="text-[11px] text-gray-400">Belum Dikerjakan</span>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-snug">
                                    {{ $quiz->title }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $quiz->description ?? 'Evaluasi komprehensif butir-butir soal teknis modul pembelajaran peternakan.' }}
                                </p>
                            </div>

                            <!-- Quiz Metrics -->
                            <div class="grid grid-cols-3 gap-2 p-2.5 bg-gray-50 dark:bg-gray-750 rounded-xl text-center text-xs">
                                <div>
                                    <span class="text-[10px] text-gray-400 block">Jumlah Soal</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $qCount }} Butir</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block">Batas Nilai</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $quiz->passing_score }}%</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block">Waktu Ujian</span>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $quiz->time_limit_minutes ?? 15 }} Mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end gap-2">
                            <div class="flex items-center gap-2">
                                @if($currentUser && $currentUser->isAdmin())
                                <button
                                    type="button"
                                    onclick="openAdminQuizResultsModal({{ json_encode($quiz) }}, {{ json_encode($quiz->attempts) }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 text-xs font-semibold transition cursor-pointer"
                                    title="Lihat Peternak yang Sudah Mengerjakan &amp; Nilai Kuis"
                                >
                                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Hasil Nilai ({{ $quiz->attempts->count() }})</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="openAdminManageQuestionsModal({{ json_encode($quiz) }}, {{ json_encode($quiz->questions) }})"
                                    class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold transition cursor-pointer"
                                    title="Lihat &amp; Kelola Butir Soal"
                                >
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                    <span>Kelola ({{ $qCount }})</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="openAdminAddQuestionModal({{ $quiz->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-purple-700 hover:bg-purple-800 text-white text-xs font-bold transition shadow-xs cursor-pointer"
                                    title="Tambah Butir Soal ke Kuis Ini"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    <span>Butir Soal</span>
                                </button>
                                @else
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openQuizRunnerModal({{ json_encode($quiz) }}, {{ json_encode($quiz->questions) }})"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl {{ $userAttempt && $userAttempt->passed ? 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200' : 'bg-purple-700 hover:bg-purple-800 text-white' }} text-xs font-bold transition shadow-xs cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 011.13-1.897L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                        <span>{{ $userAttempt ? 'Ulangi Kuis' : 'Kerjakan Soal' }}</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum ada kuis yang tersedia</h4>
                        <p class="text-xs text-gray-400 mt-1">Admin dinas akan menambahkan butir-butir evaluasi kuis untuk setiap modul.</p>
                    </div>
                    @endforelse
                </div>

            </div>

            @elseif($activeTab === 'sertifikat')
            <!-- ========================================== -->
            <!-- TAB 4: SERTIFIKAT DIGITAL RESMI DINAS -->
            <!-- ========================================== -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        @if(!($currentUser && $currentUser->isAdmin()))
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 text-[11px] font-bold">
                                Terverifikasi E-Signature
                            </span>
                            <span class="text-xs text-gray-500">Dinas Peternakan Provinsi Jawa Timur</span>
                        </div>
                        @endif
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            {{ $currentUser && $currentUser->isAdmin() ? 'Manajemen E-Sertifikat Pelatihan' : 'Sertifikat Kompetensi Digital Saya' }}
                        </h2>
                        <p class="text-xs text-gray-500">
                            {{ $currentUser && $currentUser->isAdmin() ? 'Terbitkan dan kelola e-sertifikat resmi berbasis nama program pelatihan untuk peternak milenial.' : 'Bukti kelulusan dan kompetensi resmi dari keikutsertaan program Bimtek peternak milenial.' }}
                        </p>
                    </div>

                    @if($currentUser && $currentUser->isAdmin())
                    <button
                        type="button"
                        onclick="openCreateCertificateModal()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-2xs transition shrink-0 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Buat Sertifikat Baru</span>
                    </button>
                    @else
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold border border-emerald-200 dark:border-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>E-Sertifikasi Berbasis Pelatihan</span>
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Training Certificate Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @forelse($certificateTrainings as $training)
                    @php
                        $userCert = $currentUser ? $training->certificates->firstWhere('user_id', $currentUser->id) : null;
                        $isRegisteredBimtek = $currentUser ? in_array($training->id, $myRegisteredTrainingIds) : false;
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border-2 {{ $training->has_certificate ? 'border-emerald-500/40 hover:border-emerald-500/70' : 'border-gray-200 dark:border-gray-700' }} p-5 shadow-xs transition hover:shadow-md flex flex-col justify-between relative overflow-hidden group">
                        <!-- Decorative subtle background emblem -->
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 {{ $training->has_certificate ? 'bg-emerald-50 dark:bg-emerald-950/20' : 'bg-gray-50 dark:bg-gray-800' }} rounded-full opacity-60 pointer-events-none group-hover:scale-110 transition"></div>

                        <div class="space-y-3 relative z-10">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                @if($training->has_certificate)
                                    @if($currentUser && $currentUser->isAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-extrabold border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        E-Sertifikat Aktif
                                    </span>
                                    @elseif($userCert)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-extrabold border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        E-Sertifikat Siap Unduh
                                    </span>
                                    @elseif($isRegisteredBimtek)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-extrabold border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Peserta Bimtek Terdaftar
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-[10px] font-bold border border-amber-200 dark:border-amber-800">
                                        Khusus Peserta Bimtek
                                    </span>
                                    @endif
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold border border-gray-200 dark:border-gray-600">
                                    Belum Ada E-Sertifikat
                                </span>
                                @endif

                                @if($currentUser && $currentUser->isAdmin())
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-100 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-200 font-bold">
                                        {{ $training->certificates->count() }} Peternak Mengunduh
                                    </span>
                                @elseif($userCert)
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-100 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-200 font-bold">
                                        No: {{ $userCert->certificate_number }}
                                    </span>
                                @elseif($isRegisteredBimtek)
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-100 text-emerald-900 dark:bg-emerald-900 dark:text-emerald-200 font-bold">
                                        No. Otomatis Saat Unduh
                                    </span>
                                @else
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        Wajib Terdaftar Bimtek
                                    </span>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white leading-snug group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition">
                                    {{ $training->has_certificate && $training->certificate_title ? $training->certificate_title : $training->title }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ $training->description ?? 'Program sertifikasi kompetensi peternak milenial oleh Dinas Peternakan Provinsi Jawa Timur.' }}
                                </p>
                            </div>

                            <div class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700/80 pt-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-[11px]">Program Pelatihan:</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-[11px] truncate max-w-[200px]">{{ $training->title }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-[11px]">Instruktur / Pemateri:</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-[11px]">{{ $training->instructor ?? 'Dinas Peternakan Jatim' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-[11px]">Metode Bimtek:</span>
                                    <span class="font-medium text-[11px] {{ $training->is_online ? 'text-indigo-600 dark:text-indigo-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                        {{ $training->is_online ? 'Daring via Zoom' : 'Tatap Muka Lapangan' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-[11px]">Status Penerbitan:</span>
                                    <span class="font-bold text-[11px] {{ $training->has_certificate ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400' }} flex items-center gap-1">
                                        {{ $training->has_certificate ? '✓ Terverifikasi Resmi Disnak Jatim' : 'Belum Dibuatkan Sertifikat' }}
                                    </span>
                                </div>
                            </div>

                            @if($currentUser && $currentUser->isAdmin() && $training->certificates->count() > 0)
                            <div class="mt-2 pt-2 border-t border-dashed border-gray-200 dark:border-gray-700">
                                <details class="text-[11px] text-gray-500">
                                    <summary class="cursor-pointer font-medium text-emerald-700 dark:text-emerald-400 hover:underline">
                                        Daftar {{ $training->certificates->count() }} Penerima E-Sertifikat
                                    </summary>
                                    <ul class="mt-2 space-y-1 pl-2 max-h-28 overflow-y-auto">
                                        @foreach($training->certificates as $cert)
                                        <li class="flex items-center justify-between text-[10px] text-gray-600 dark:text-gray-300 py-0.5 border-b border-gray-50 dark:border-gray-800">
                                            <span>{{ $cert->recipient_name }}</span>
                                            <span class="font-mono text-emerald-700 dark:text-emerald-400 font-semibold">{{ $cert->certificate_number }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </details>
                            </div>
                            @endif
                        </div>

                        <!-- Card Action Footer -->
                        <div class="pt-4 mt-3 border-t border-gray-100 dark:border-gray-700/80 relative z-10 flex items-center justify-between gap-3">
                            @if($currentUser && $currentUser->isAdmin())
                                {{-- ADMIN ACTIONS: MEMBUAT & MENGELOLA SERTIFIKAT (BUKAN MENDOWNLOAD) --}}
                                @if($training->has_certificate)
                                <span class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold">
                                    E-Sertifikat Aktif
                                </span>
                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('pelatihan.certificates.preview', $training) }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold shadow-2xs transition"
                                    >
                                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Pratinjau Format</span>
                                    </a>
                                    <form action="{{ route('pelatihan.certificates.template.destroy', $training) }}" method="POST" onsubmit="return confirm('Nonaktifkan e-sertifikat untuk pelatihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="tab" value="sertifikat">
                                        <button type="submit" class="inline-flex items-center px-2.5 py-2 rounded-xl text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/40 text-xs font-semibold transition cursor-pointer">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-[11px] text-gray-400">
                                    Belum diterbitkan
                                </span>
                                <button
                                    type="button"
                                    onclick="openCreateCertificateModal({{ $training->id }}, '{{ addslashes($training->title) }}')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    <span>Buat Sertifikat</span>
                                </button>
                                @endif
                            @else
                                {{-- PESERTA ACTIONS: MENDOWNLOAD SERTIFIKAT --}}
                                @if($userCert || $isRegisteredBimtek)
                                <span class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold">
                                    {{ $userCert ? 'Telah Diterbitkan' : 'Siap Diunduh Peserta' }}
                                </span>

                                <a
                                    href="{{ route('pelatihan.certificates.download', $training) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-xs hover:shadow transition shrink-0"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.5V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                    <span>Download Sertifikat</span>
                                </a>
                                @else
                                <span class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold">
                                    Khusus Peserta Bimtek
                                </span>

                                <a
                                    href="{{ route('pelatihan', ['tab' => $training->is_online ? 'zoom' : 'bimtek_offline']) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 dark:hover:bg-indigo-900/60 font-semibold text-xs transition shrink-0"
                                >
                                    <span>Ikuti Bimtek Dulu &rarr;</span>
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.496m5.007 0a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H9.496a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum ada sertifikat digital yang diterbitkan</h4>
                        <p class="text-xs text-gray-400 mt-1">Sertifikat diterbitkan resmi oleh Dinas Peternakan Jatim untuk peserta yang mengikuti Bimtek Online (Zoom) maupun Tatap Muka Lapangan (Offline).</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL 1: VIDEO PLAYER MODAL & RINGKASAN MATERI                 -->
<!-- ============================================================== -->
<div id="modal-video-player" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] flex flex-col">
        <!-- Modal Video Header -->
        <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span id="vp-topic" class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                    TOPIC
                </span>
                <h3 id="vp-title" class="text-sm sm:text-base font-bold text-gray-900 dark:text-white mt-1">
                    Judul Video Pembelajaran
                </h3>
            </div>
            <button
                type="button"
                onclick="closeVideoPlayerModal()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold p-1"
            >
                &times;
            </button>
        </div>

        <!-- Video Player Iframe Container (Responsive 16:9) -->
        <div class="relative aspect-video w-full bg-black">
            <iframe
                id="vp-iframe"
                src=""
                class="w-full h-full"
                title="Video Pembelajaran"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>

        <!-- Details & Actions -->
        <div class="p-4 sm:p-5 overflow-y-auto space-y-3.5 flex-1">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700 pb-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('img/dokter.png') }}" alt="Instructor" class="w-8 h-8 rounded-full border border-gray-200"/>
                    <div>
                        <span id="vp-instructor" class="text-xs font-bold text-gray-800 dark:text-gray-200 block">Nama Instruktur</span>
                        <span id="vp-institution" class="text-[11px] text-gray-400 block">Dinas Peternakan Jatim</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Download Attached Document -->
                    <a
                        id="vp-doc-btn"
                        href="#"
                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-semibold transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        <span>Unduh Dokumen SOP (PDF)</span>
                    </a>

                    <!-- Mark Progress (Peternak Only) -->
                    @if($currentUser && $currentUser->isAdmin())
                    <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-xl text-xs font-semibold border border-indigo-200 dark:border-indigo-800">
                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Pratinjau Pengelola Dinas</span>
                    </span>
                    @else
                    <form id="vp-progress-form" method="POST" action="" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer"
                        >
                            &check; Tandai Selesai Menonton
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Deskripsi &amp; Poin Pembelajaran</h4>
                <p id="vp-description" class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Deskripsi materi video...
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 2: QUIZ RUNNER INTERAKTIF (MENGERJAKAN SOAL-SOAL)        -->
<!-- ============================================================== -->
<div id="modal-quiz-runner" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] flex flex-col">
        <!-- Header Kuis -->
        <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-purple-50/50 dark:bg-purple-950/30">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-purple-200 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    KUIS EVALUASI PEMBELAJARAN
                </span>
                <h3 id="qr-title" class="text-sm sm:text-base font-bold text-gray-900 dark:text-white mt-1">
                    Judul Kuis
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-quiz-runner').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold p-1 cursor-pointer"
            >
                &times;
            </button>
        </div>

        <!-- Result Card (shown after submission) -->
        <div id="qr-result-box" class="hidden p-5 bg-white dark:bg-gray-800 text-center space-y-3 border-b border-gray-100 dark:border-gray-700">
            <div id="qr-result-icon" class="w-14 h-14 rounded-full mx-auto flex items-center justify-center text-2xl font-bold"></div>
            <div>
                <h4 id="qr-result-heading" class="text-base font-extrabold">Hasil Kuis Anda</h4>
                <p id="qr-result-message" class="text-xs text-gray-500 mt-0.5"></p>
            </div>
            <div class="inline-flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/60 rounded-xl text-xs">
                <span>Skor: <strong id="qr-result-score" class="text-sm">0</strong>/100</span>
                <span>&bull;</span>
                <span>Benar: <strong id="qr-result-correct">0</strong> dari <span id="qr-result-total">0</span> soal</span>
            </div>
            <div class="pt-2 text-[11px] text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700/80">
                <span>Soal kuis merupakan evaluasi mandiri pemahaman materi. E-Sertifikat resmi diterbitkan khusus bagi peserta yang mengikuti Bimbingan Teknis (Bimtek Online via Zoom maupun Tatap Muka Lapangan).</span>
            </div>
        </div>

        <!-- Quiz Form Body -->
        <form id="qr-form" method="POST" action="" class="p-4 sm:p-6 overflow-y-auto space-y-5 flex-1">
            @csrf
            <div id="qr-questions-container" class="space-y-6">
                <!-- Dynamically rendered questions with option A, B, C, D -->
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <span class="text-[11px] text-gray-400">Pilih salah satu jawaban yang paling tepat.</span>
                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md transition cursor-pointer"
                >
                    Kirim Jawaban &amp; Lihat Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 3: ADMIN UPLOAD MODUL & DOKUMEN VIDEO BARU               -->
<!-- ============================================================== -->
@if($currentUser && $currentUser->isAdmin())
<div id="modal-upload-materi-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-primary-100 text-primary-800">
                    ADMIN LMS STUDIO
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Unggah Video Pembelajaran &amp; Dokumen SOP
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-upload-materi-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <form action="{{ route('pelatihan.materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs">
            @csrf
            <input type="hidden" name="tab" value="pembelajaran">
            <input type="hidden" name="category" value="video_praktik">

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Video / Modul <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="cth: Teknik Pengolahan Silase Berkualitas Tinggi" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Topik Pembelajaran <span class="text-red-500">*</span></label>
                    <select name="topic" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                        <option value="Manajemen Pakan">Manajemen Pakan</option>
                        <option value="Produksi & Mutu Susu">Produksi & Mutu Susu</option>
                        <option value="Kesehatan Ternak">Kesehatan Ternak</option>
                        <option value="Bibit & Budidaya">Bibit & Budidaya</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tingkat Kesulitan</label>
                    <select name="level" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                        <option value="Dasar">Dasar (Pemula)</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Lanjutan">Lanjutan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Instruktur / Pemateri <span class="text-red-500">*</span></label>
                    <input type="text" name="instructor_name" required value="Dr. Ir. Budi Santoso, M.Sc" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Instansi / Asal Lembaga <span class="text-red-500">*</span></label>
                    <input type="text" name="author_institution" required value="BBPP Batu & Disnak Jatim" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tautan Video (YouTube / Link Video) <span class="text-red-500">*</span></label>
                    <input type="text" name="video_url" required value="https://www.youtube.com/watch?v=dQw4w9WgXcQ" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Durasi Video</label>
                    <input type="text" name="duration" value="22 Menit" placeholder="cth: 25 Menit" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Unggah Dokumen Materi / SOP (PDF / DOCX)</label>
                <input type="file" name="document_file" accept=".pdf,.doc,.docx" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2 text-xs text-gray-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700">
                <span class="text-[10px] text-gray-400 mt-0.5 block">File dokumen yang dapat diunduh langsung oleh peternak setelah menonton.</span>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Ringkasan &amp; Deskripsi Materi</label>
                <textarea name="description" rows="3" placeholder="Jelaskan ringkasan materi, capaian pembelajaran, dan SOP terkait..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-upload-materi-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer">
                    Simpan &amp; Publikasikan Modul
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 4: ADMIN JADWALKAN PEMBELAJARAN ZOOM                     -->
<!-- ============================================================== -->
<div id="modal-jadwalkan-zoom-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-blue-100 text-blue-800">
                    LIVE ZOOM WEBINAR
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Jadwalkan Sesi Pembelajaran Zoom Baru
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-jadwalkan-zoom-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <form action="{{ route('pelatihan.zoom.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Sesi Bimtek Zoom <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="cth: Live Zoom: Formulasi Pakan Konsentrat Rendah Emisi" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Narasumber / Instruktur <span class="text-red-500">*</span></label>
                    <input type="text" name="instructor" required value="Prof. Dr. Ir. Hendrawan, MS" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Jabatan / Lembaga</label>
                    <input type="text" name="instructor_title" value="Guru Besar Nutrisi Ternak Fapet UB" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" required value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" required value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="text" name="time_info" required value="09:00 - 12:00 WIB" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tautan / Link Zoom Meeting <span class="text-red-500">*</span></label>
                <input type="url" name="zoom_link" required value="https://zoom.us/j/99120485123?pwd=pakanmilenial" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Meeting ID</label>
                    <input type="text" name="zoom_meeting_id" value="991 2048 5123" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Passcode</label>
                    <input type="text" name="zoom_passcode" value="PAKAN2026" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kuota Peserta</label>
                    <input type="number" name="quota" min="10" value="250" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Unggah Dokumen Silabus / Materi Zoom (PDF)</label>
                <input type="file" name="document_upload" accept=".pdf,.doc,.docx" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2 text-xs text-gray-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Agenda Bimtek</label>
                <textarea name="description" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">Teknik penyusunan ransum pakan sapi perah berbasis limbah pertanian lokal Jawa Timur untuk menekan emisi gas metana.</textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-jadwalkan-zoom-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-blue-700 hover:bg-blue-800 transition shadow-xs cursor-pointer">
                    Terbitkan Jadwal Zoom
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 5: ADMIN TAMBAH BUTIR SOAL KUIS                          -->
<!-- ============================================================== -->
<div id="modal-buat-soal-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                    BANK SOAL EVALUASI
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Tambah Butir Soal Pilihan Ganda (A, B, C, D)
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-buat-soal-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <form id="form-tambah-soal" method="POST" action="" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Kuis Modul <span class="text-red-500">*</span></label>
                <select id="select-target-quiz" required onchange="updateQuizActionUrl(this.value)" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                    @foreach($quizzes as $qz)
                        <option value="{{ $qz->id }}" data-action="{{ route('pelatihan.quiz.question.store', $qz) }}">
                            {{ $qz->title }} (Modul: {{ $qz->learningMaterial?->title }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pertanyaan Soal <span class="text-red-500">*</span></label>
                <textarea name="question" required rows="2.5" placeholder="Tuliskan butir pertanyaan di sini..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilihan A <span class="text-red-500">*</span></label>
                    <input type="text" name="option_a" required placeholder="Opsi A" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilihan B <span class="text-red-500">*</span></label>
                    <input type="text" name="option_b" required placeholder="Opsi B" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilihan C <span class="text-red-500">*</span></label>
                    <input type="text" name="option_c" required placeholder="Opsi C" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilihan D <span class="text-red-500">*</span></label>
                    <input type="text" name="option_d" required placeholder="Opsi D" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kunci Jawaban Benar <span class="text-red-500">*</span></label>
                    <select name="correct_answer" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white font-bold text-emerald-700">
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Penjelasan / Pembahasan Kunci Jawaban</label>
                    <input type="text" name="explanation" placeholder="Alasan mengapa jawaban ini benar..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-buat-soal-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-purple-700 hover:bg-purple-800 transition shadow-xs cursor-pointer">
                    Simpan Butir Soal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 6: ADMIN BUAT KUIS BARU UNTUK MODUL                      -->
<!-- ============================================================== -->
<div id="modal-buat-kuis-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                    BANK EVALUASI
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Buat Kuis Baru untuk Modul Video
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-buat-kuis-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <form id="form-buat-kuis" method="POST" action="" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Kuis Evaluasi <span class="text-red-500">*</span></label>
                <input type="text" id="bk-title" name="title" required placeholder="cth: Evaluasi Pemahaman Nutrisi Pakan" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Passing Grade (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="passing_score" min="50" max="100" value="70" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Batas Waktu (Menit)</label>
                    <input type="number" name="time_limit_minutes" min="1" max="120" value="15" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi / Petunjuk Pengerjaan</label>
                <textarea id="bk-description" name="description" rows="2.5" placeholder="Instruksi pengerjaan bagi peternak..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-buat-kuis-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-purple-700 hover:bg-purple-800 transition shadow-xs cursor-pointer">
                    Terbitkan Kuis
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADMIN BUAT / TERBITKAN E-SERTIFIKAT PELATIHAN            -->
<!-- ============================================================== -->
<div id="modal-buat-sertifikat-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                    E-SERTIFIKASI DINAS
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Buat E-Sertifikat Pelatihan Baru
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-buat-sertifikat-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
            Sertifikat dibuat berbasis nama program pelatihan. Setelah diterbitkan, seluruh peserta dapat langsung mengunduh sertifikat resmi dengan nomor sertifikat otomatis yang berbeda.
        </p>

        <form method="POST" action="{{ route('pelatihan.certificates.issue') }}" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="tab" value="sertifikat">

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Program Pelatihan <span class="text-red-500">*</span></label>
                <select name="training_id" id="modal-cert-training-id" required onchange="handleTrainingSelectChange(this)" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white font-medium">
                    <option value="">-- Pilih Program Pelatihan --</option>
                    @foreach($trainings as $t)
                        <option value="{{ $t->id }}" data-title="{{ $t->title }}">
                            {{ $t->title }} {{ $t->has_certificate ? '✓ (Sudah Ada Sertifikat)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Sertifikasi / Kompetensi</label>
                <input type="text" name="title" id="modal-cert-title" placeholder="cth: Sertifikasi Kompetensi Peternak Sapi Perah Higienis" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                <span class="text-[11px] text-gray-400 mt-1 block">Jika dikosongkan, otomatis menggunakan format: Sertifikasi Kompetensi: [Nama Pelatihan].</span>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-buat-sertifikat-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-xs cursor-pointer">
                    Terbitkan E-Sertifikat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 7: ADMIN KELOLA DAFTAR BUTIR SOAL KUIS                  -->
<!-- ============================================================== -->
<div id="modal-kelola-soal-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-3xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] flex flex-col">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4 shrink-0">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                    BANK SOAL KUIS
                </span>
                <h3 id="ks-title" class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Kelola Butir Soal Evaluasi
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-kelola-soal-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <div class="flex items-center justify-between py-2 px-3 bg-purple-50 dark:bg-purple-950/40 rounded-xl mb-4 shrink-0 text-xs">
            <span class="text-purple-900 dark:text-purple-300 font-medium">Daftar Pertanyaan Pilihan Ganda</span>
            <button
                type="button"
                onclick="switchToCreateQuestionFromManage()"
                class="px-3 py-1.5 rounded-lg bg-purple-700 hover:bg-purple-800 text-white font-bold text-[11px] shadow-2xs transition cursor-pointer"
            >
                + Tambah Soal Baru
            </button>
        </div>

        <div id="ks-questions-list" class="space-y-4 overflow-y-auto flex-1 pr-1">
            <!-- Dynamically populated questions with delete action -->
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end shrink-0">
            <button
                type="button"
                onclick="document.getElementById('modal-kelola-soal-admin').classList.add('hidden')"
                class="px-5 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer"
            >
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 8: ADMIN LIHAT HASIL EVALUASI & NILAI KUIS PETERNAK     -->
<!-- ============================================================== -->
<div id="modal-hasil-kuis-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-3xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4 shrink-0">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                    HASIL EVALUASI &amp; NILAI KUIS
                </span>
                <h3 id="hr-quiz-title" class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Judul Kuis
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Batas Minimum Kelulusan: <span id="hr-quiz-passing" class="font-bold text-emerald-600">70%</span> &bull; Total Mengerjakan: <span id="hr-quiz-count" class="font-bold text-gray-800 dark:text-gray-200">0</span> Peternak
                </p>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-hasil-kuis-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <!-- Table Container -->
        <div class="overflow-y-auto flex-1 border border-gray-100 dark:border-gray-700 rounded-2xl">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-750 border-b border-gray-100 dark:border-gray-700 sticky top-0">
                    <tr>
                        <th class="px-4 py-3">Nama Peternak</th>
                        <th class="px-4 py-3 text-center">Skor</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Waktu Pengerjaan</th>
                    </tr>
                </thead>
                <tbody id="hr-attempts-list" class="divide-y divide-gray-100 dark:divide-gray-700">
                    <!-- Dynamically populated via JS -->
                </tbody>
            </table>
        </div>

        <!-- Modal Footer -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end shrink-0 mt-4">
            <button
                type="button"
                onclick="document.getElementById('modal-hasil-kuis-admin').classList.add('hidden')"
                class="px-5 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer"
            >
                Tutup
            </button>
        </div>
    </div>
</div>
@endif
<!-- ============================================================== -->
<!-- MODAL: DAFTAR BIMTEK OFFLINE & UNGGAH DOKUMEN PERSYARATAN     -->
<!-- ============================================================== -->
<div id="modal-daftar-bimtek-offline" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                    BIMTEK TATAP MUKA
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Pendaftaran &amp; Unggah Dokumen Persyaratan
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-daftar-bimtek-offline').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <!-- Info Alur Persyaratan Sesuai Ketentuan User -->
        <div class="p-3 bg-emerald-50 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-900 dark:text-emerald-200 mb-4 flex items-start gap-2.5">
            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            <p class="leading-relaxed">
                Namun, jika memilih Bimtek (Bimbingan Teknis), peternak harus mendaftar dan <strong>mengunggah dokumen persyaratan terlebih dahulu</strong> untuk dicatat nomor registrasinya oleh sistem aplikasi Dinas Peternakan Jawa Timur.
            </p>
        </div>

        <form id="form-daftar-bimtek-offline" action="" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs">
            @csrf
            <input type="hidden" name="tab" value="bimtek_offline">

            <!-- Program Info Card -->
            <div class="p-3 bg-gray-50 dark:bg-gray-750 rounded-xl space-y-1">
                <span class="text-[10px] text-gray-400 block font-medium">Program Bimtek yang Dipilih:</span>
                <h4 id="md-offline-title" class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">Judul Pelatihan</h4>
                <div class="flex items-center gap-2 text-gray-500 text-[11px] pt-1">
                    <span id="md-offline-location" class="text-emerald-700 dark:text-emerald-400 font-semibold truncate">Lokasi</span>
                    <span>&bull;</span>
                    <span id="md-offline-date">Jadwal</span>
                </div>
            </div>

            <!-- Peternak Data -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Peternak</label>
                    <input type="text" readonly value="{{ $currentUser ? $currentUser->name : '' }}" class="w-full bg-gray-100 dark:bg-gray-700/80 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-700 dark:text-gray-300 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" required value="{{ $currentUser?->profile?->nik ?? '' }}" placeholder="cth: 3514081203760001" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">No. WhatsApp / Telepon Aktif <span class="text-red-500">*</span></label>
                    <input type="text" name="phone_number" required value="{{ $currentUser?->phone_number ?? '' }}" placeholder="cth: 081234567890" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Usaha / Kelompok Ternak</label>
                    <input type="text" name="farm_name" value="{{ $currentUser?->profile?->farm_name ?? '' }}" placeholder="cth: Kelompok Tani Ternak Sumber Rejeki" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <!-- Upload Dokumen Persyaratan (Wajib) -->
            <div class="p-3.5 bg-amber-50/80 dark:bg-amber-950/30 rounded-xl border border-amber-300 dark:border-amber-800 space-y-1.5">
                <label class="block font-bold text-amber-900 dark:text-amber-200 text-xs">
                    Unggah Dokumen Persyaratan <span class="text-red-600">*</span>
                </label>
                <input
                    type="file"
                    name="requirement_document"
                    required
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    class="w-full bg-white dark:bg-gray-800 border border-amber-300 dark:border-amber-700 rounded-xl p-2 text-xs text-gray-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 cursor-pointer"
                />
                <span class="text-[10px] text-amber-800 dark:text-amber-300 block">
                    Format berkas: PDF, JPG, PNG, atau DOCX (Maksimal 10 MB). Berupa scan/foto KTP, Surat Keterangan Usaha Peternakan dari Desa/Kelurahan, atau Surat Rekomendasi Kelompok Ternak.
                </span>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan / Komoditas Ternak</label>
                <textarea name="notes" rows="2" placeholder="Tuliskan komoditas ternak Anda (cth: Sapi Perah 10 Ekor, Kambing PE) atau harapan keikutsertaan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-daftar-bimtek-offline').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-xs cursor-pointer">
                    Daftar &amp; Catat Nomor Registrasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: TIKET & BUKTI REGISTRASI BIMTEK PETERNAK               -->
<!-- ============================================================== -->
<div id="modal-tiket-bimtek-peternak" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                    BUKTI PENDAFTARAN RESMI
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Tiket Pendaftaran Bimtek Lapangan
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-tiket-bimtek-peternak').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <div class="p-4 bg-emerald-50/80 dark:bg-emerald-950/40 rounded-2xl border-2 border-dashed border-emerald-400 dark:border-emerald-700 space-y-3.5">
            <div class="flex items-center justify-between pb-2 border-b border-emerald-200/80 dark:border-emerald-800">
                <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">Nomor Registrasi Sistem:</span>
                <span id="tk-regcode" class="font-mono text-sm font-extrabold text-emerald-700 dark:text-emerald-300 px-2.5 py-0.5 bg-white dark:bg-gray-800 rounded-lg border border-emerald-200">
                    REG-BMTK-XXXX-XXXX
                </span>
            </div>

            <div class="space-y-2 text-xs">
                <div>
                    <span class="text-[10px] text-gray-500 block">Program Bimbingan Teknis</span>
                    <strong id="tk-title" class="text-gray-900 dark:text-white text-sm">Judul Pelatihan</strong>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <div>
                        <span class="text-[10px] text-gray-500 block">Lokasi Tatap Muka</span>
                        <span id="tk-location" class="font-medium text-gray-800 dark:text-gray-200">Lokasi</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 block">Waktu &amp; Tanggal</span>
                        <span id="tk-schedule" class="font-medium text-gray-800 dark:text-gray-200">Tanggal</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <div>
                        <span class="text-[10px] text-gray-500 block">Nama Peserta</span>
                        <span id="tk-user" class="font-medium text-gray-800 dark:text-gray-200">{{ $currentUser ? $currentUser->name : '' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 block">Status Registrasi</span>
                        <span id="tk-status" class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200 text-emerald-900 uppercase">Diverifikasi</span>
                    </div>
                </div>
            </div>

            <div id="tk-doc-section" class="pt-2 border-t border-emerald-200 dark:border-emerald-800 flex items-center justify-between text-xs">
                <span class="text-gray-500 text-[11px]">Dokumen Persyaratan:</span>
                <a id="tk-doc-link" href="#" class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-400 font-bold hover:underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    <span id="tk-doc-name">Unduh Berkas</span>
                </a>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 mt-4">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 inline-flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.673-2.062-1.258-2.914m13.076 2.914c.24-1.076.673-2.062 1.258-2.914M9 19.5h6m-9-3h12a2.25 2.25 0 002.25-2.25v-3.75a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25v3.75A2.25 2.25 0 006 16.5z"/></svg>
                <span>Cetak Bukti</span>
            </button>
            <button type="button" onclick="document.getElementById('modal-tiket-bimtek-peternak').classList.add('hidden')" class="px-5 py-2 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

@if($currentUser && $currentUser->isAdmin())
<!-- ============================================================== -->
<!-- MODAL: ADMIN JADWALKAN PROGRAM BIMTEK OFFLINE                 -->
<!-- ============================================================== -->
<div id="modal-jadwalkan-bimtek-offline-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                    BIMTEK LAPANGAN DINAS
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Jadwalkan Program Bimtek Offline Baru
                </h3>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-jadwalkan-bimtek-offline-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <form action="{{ route('pelatihan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs">
            @csrf
            <input type="hidden" name="tab" value="bimtek_offline">
            <input type="hidden" name="is_online" value="0">

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Program Bimtek <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="cth: Bimbingan Teknis Praktik Formulasi Pakan Silase & Pemanfaatan Limbah" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Instruktur / Pemateri Utama <span class="text-red-500">*</span></label>
                    <input type="text" name="instructor" required value="Dr. Ir. Hendro Wibowo" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Jabatan / Asal Lembaga</label>
                    <input type="text" name="instructor_title" value="Widyaiswara Ahli Utama BBPP Batu" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Lokasi Tatap Muka Lapangan <span class="text-red-500">*</span></label>
                <input type="text" name="location" required value="BBPP Songgoriti, Batu" placeholder="cth: Balai Besar Pelatihan Peternakan (BBPP) Songgoriti, Batu" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" required value="{{ date('Y-m-d', strtotime('+5 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" required value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Waktu Pelaksanaan</label>
                    <input type="text" name="time_info" value="08:00 - 15:00 WIB" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kuota Peserta <span class="text-red-500">*</span></label>
                    <input type="number" name="quota" min="5" value="30" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tipe Pembiayaan <span class="text-red-500">*</span></label>
                    <select name="cost_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">
                        <option value="gratis_apbd">Gratis (APBD Dinas Peternakan Jatim)</option>
                        <option value="mandiri">Mandiri (Swadaya Peserta)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Unggah Silabus / Panduan Praktik Lapangan (PDF/DOCX)</label>
                <input type="file" name="document_upload" accept=".pdf,.doc,.docx" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2 text-xs text-gray-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 cursor-pointer">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Kurikulum Praktik Lapangan</label>
                <textarea name="description" rows="3" required placeholder="Jelaskan silabus praktik, fasilitas kandang/laboratorium, dan target capaian pelatihan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white">Bimbingan teknis praktik intensif langsung di lapangan mengenai manajemen sanitasi kandang, formulasi konsentrat mandiri, dan pengawetan hijauan berkualitas.</textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-jadwalkan-bimtek-offline-admin').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-xs cursor-pointer">
                    Terbitkan Jadwal Bimtek Lapangan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADMIN LIHAT DAFTAR PESERTA & DOKUMEN PERSYARATAN BIMTEK -->
<!-- ============================================================== -->
<div id="modal-peserta-bimtek-admin" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-4xl w-full p-5 sm:p-6 shadow-2xl border border-gray-100 dark:border-gray-700 max-h-[92vh] flex flex-col">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4 shrink-0">
            <div>
                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                    VERIFIKASI PERSYARATAN PESERTA
                </span>
                <h3 id="adm-part-title" class="text-base font-bold text-gray-900 dark:text-white mt-1">
                    Daftar Peserta Bimtek &amp; Berkas Persyaratan
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Periksa keabsahan berkas persyaratan yang diunggah peternak dan perbarui status registrasi.
                </p>
            </div>
            <button
                type="button"
                onclick="document.getElementById('modal-peserta-bimtek-admin').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold cursor-pointer"
            >
                &times;
            </button>
        </div>

        <div class="overflow-y-auto flex-1 border border-gray-100 dark:border-gray-700 rounded-2xl">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-750 border-b border-gray-100 dark:border-gray-700 sticky top-0">
                    <tr>
                        <th class="px-3.5 py-3">Nama Peternak &amp; Usaha</th>
                        <th class="px-3 py-3 text-center">Nomor Registrasi</th>
                        <th class="px-3 py-3 text-center">Dokumen Persyaratan</th>
                        <th class="px-3 py-3 text-center">Status</th>
                        <th class="px-3 py-3 text-right">Aksi Status</th>
                    </tr>
                </thead>
                <tbody id="adm-part-tbody" class="divide-y divide-gray-100 dark:divide-gray-700">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end shrink-0 mt-4">
            <button
                type="button"
                onclick="document.getElementById('modal-peserta-bimtek-admin').classList.add('hidden')"
                class="px-5 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 cursor-pointer"
            >
                Tutup
            </button>
        </div>
    </div>
</div>
@endif

<!-- JAVASCRIPT LOGIC FOR INTERACTIVE MODALS -->
<script>
    let currentManagingQuizId = null;

    function openAdminCreateQuizModal(materialId, materialTitle) {
        document.getElementById('form-buat-kuis').action = '/pelatihan/materials/' + materialId + '/quiz';
        document.getElementById('bk-title').value = 'Evaluasi Pemahaman: ' + materialTitle;
        document.getElementById('bk-description').value = 'Uji pemahaman butir-butir SOP materi ' + materialTitle + '.';
        document.getElementById('modal-buat-kuis-admin').classList.remove('hidden');
    }

    function openAdminAddQuestionModal(quizId) {
        const select = document.getElementById('select-target-quiz');
        if (select) {
            select.value = quizId;
            updateQuizActionUrl(quizId);
        }
        document.getElementById('modal-buat-soal-admin').classList.remove('hidden');
    }

    function openAdminManageQuestionsModal(quiz, questions) {
        currentManagingQuizId = quiz.id;
        document.getElementById('ks-title').innerText = quiz.title;
        const list = document.getElementById('ks-questions-list');
        list.innerHTML = '';

        if (!questions || questions.length === 0) {
            list.innerHTML = '<div class="text-center py-8 text-gray-400 text-xs">Belum ada butir pertanyaan untuk kuis ini. Silakan klik tombol "+ Tambah Soal Baru".</div>';
            document.getElementById('modal-kelola-soal-admin').classList.remove('hidden');
            return;
        }

        const token = '{{ csrf_token() }}';

        questions.forEach((q, idx) => {
            const card = document.createElement('div');
            card.className = 'p-3.5 bg-gray-50 dark:bg-gray-750 border border-gray-200/80 dark:border-gray-700 rounded-2xl space-y-2.5 text-xs';

            const opts = [
                { key: 'a', text: q.option_a },
                { key: 'b', text: q.option_b },
                { key: 'c', text: q.option_c },
                { key: 'd', text: q.option_d }
            ];

            let optHtml = '';
            opts.forEach(o => {
                const isCorrect = (o.key === q.correct_answer);
                optHtml += `
                    <div class="px-2.5 py-1.5 rounded-lg border text-xs flex items-center justify-between ${isCorrect ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-400 text-emerald-900 dark:text-emerald-200 font-bold' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300'}">
                        <span><strong>${o.key.toUpperCase()}.</strong> ${o.text}</span>
                        ${isCorrect ? '<span class="text-[10px] bg-emerald-600 text-white px-1.5 py-0.2 rounded font-bold">&check; KUNCI</span>' : ''}
                    </div>
                `;
            });

            card.innerHTML = `
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-start gap-2">
                        <span class="w-5 h-5 rounded-full bg-purple-200 text-purple-900 font-bold text-[11px] flex items-center justify-center shrink-0">
                            ${idx + 1}
                        </span>
                        <p class="font-bold text-gray-900 dark:text-white leading-snug">
                            ${q.question}
                        </p>
                    </div>

                    <form action="/pelatihan/quiz/questions/${q.id}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')" class="inline shrink-0">
                        <input type="hidden" name="_token" value="${token}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition cursor-pointer" title="Hapus Butir Soal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 pl-7">
                    ${optHtml}
                </div>

                ${q.explanation ? `<div class="pl-7 text-[11px] text-gray-500 italic">Pembahasan: ${q.explanation}</div>` : ''}
            `;

            list.appendChild(card);
        });

        document.getElementById('modal-kelola-soal-admin').classList.remove('hidden');
    }

    function openAdminQuizResultsModal(quiz, attempts) {
        document.getElementById('hr-quiz-title').innerText = quiz.title;
        document.getElementById('hr-quiz-passing').innerText = (quiz.passing_score || 70) + '%';
        document.getElementById('hr-quiz-count').innerText = (attempts && attempts.length) ? attempts.length : 0;

        const list = document.getElementById('hr-attempts-list');
        list.innerHTML = '';

        if (!attempts || attempts.length === 0) {
            list.innerHTML = `
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-xs">
                        Belum ada peternak yang mengerjakan kuis evaluasi ini.
                    </td>
                </tr>
            `;
            document.getElementById('modal-hasil-kuis-admin').classList.remove('hidden');
            return;
        }

        attempts.forEach(att => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition';

            const peternakName = att.user ? att.user.name : 'Peternak';
            const isPassed = Boolean(att.passed);
            const score = att.score;

            let formattedTime = '-';
            if (att.completed_at) {
                const d = new Date(att.completed_at);
                if (!isNaN(d.getTime())) {
                    const day = String(d.getDate()).padStart(2, '0');
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    const month = months[d.getMonth()];
                    const year = d.getFullYear();
                    const hours = String(d.getHours()).padStart(2, '0');
                    const minutes = String(d.getMinutes()).padStart(2, '0');
                    formattedTime = `${day} ${month} ${year} ${hours}:${minutes}`;
                }
            }

            tr.innerHTML = `
                <td class="px-4 py-3.5 font-semibold text-gray-900 dark:text-white">
                    ${peternakName}
                </td>
                <td class="px-4 py-3.5 text-center font-bold ${isPassed ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'}">
                    ${score} / 100
                </td>
                <td class="px-4 py-3.5 text-center">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold ${isPassed ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-950/60 dark:text-red-300'}">
                        ${isPassed ? 'LULUS' : 'MENGULANG'}
                    </span>
                </td>
                <td class="px-4 py-3.5 text-right text-gray-400">
                    ${formattedTime}
                </td>
            `;

            list.appendChild(tr);
        });

        document.getElementById('modal-hasil-kuis-admin').classList.remove('hidden');
    }

    function switchToCreateQuestionFromManage() {
        document.getElementById('modal-kelola-soal-admin').classList.add('hidden');
        if (currentManagingQuizId) {
            openAdminAddQuestionModal(currentManagingQuizId);
        } else {
            document.getElementById('modal-buat-soal-admin').classList.remove('hidden');
        }
    }

    function openVideoPlayerModal(material, embedUrl) {
        document.getElementById('vp-topic').innerText = (material.topic || 'PETERNAKAN').toUpperCase();
        document.getElementById('vp-title').innerText = material.title;
        document.getElementById('vp-instructor').innerText = material.instructor_name || 'Instruktur Ahli Disnak';
        document.getElementById('vp-institution').innerText = material.author_institution || 'Dinas Peternakan Jatim';
        document.getElementById('vp-description').innerText = material.description || 'Modul video resmi dinas peternakan.';

        // Set document download link
        document.getElementById('vp-doc-btn').href = '/pelatihan/dokumen/material/' + material.id;

        // Set progress tracking form action
        const progressForm = document.getElementById('vp-progress-form');
        if (progressForm) {
            progressForm.action = '/pelatihan/materi/' + material.id + '/progress';
        }

        // Load iframe video
        const iframe = document.getElementById('vp-iframe');
        iframe.src = embedUrl || 'https://www.youtube.com/embed/dQw4w9WgXcQ';

        document.getElementById('modal-video-player').classList.remove('hidden');
    }

    function closeVideoPlayerModal() {
        const iframe = document.getElementById('vp-iframe');
        iframe.src = '';
        document.getElementById('modal-video-player').classList.add('hidden');
    }

    function openQuizRunnerModal(quiz, questions) {
        document.getElementById('qr-title').innerText = quiz.title;
        document.getElementById('qr-form').action = '/pelatihan/kuis/' + quiz.id + '/submit';

        // Reset result box
        const resultBox = document.getElementById('qr-result-box');
        resultBox.classList.add('hidden');

        const container = document.getElementById('qr-questions-container');
        container.innerHTML = '';

        if (!questions || questions.length === 0) {
            container.innerHTML = '<div class="text-center py-6 text-gray-400 text-xs">Belum ada butir pertanyaan untuk kuis ini.</div>';
            document.getElementById('modal-quiz-runner').classList.remove('hidden');
            return;
        }

        questions.forEach((q, idx) => {
            const card = document.createElement('div');
            card.className = 'p-4 rounded-2xl bg-gray-50 dark:bg-gray-750 border border-gray-200/80 dark:border-gray-700 space-y-3';

            card.innerHTML = `
                <div class="flex items-start gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-purple-200 text-purple-900 font-bold text-xs flex items-center justify-center shrink-0">
                        ${idx + 1}
                    </span>
                    <p class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white leading-snug">
                        ${q.question}
                    </p>
                </div>

                <div class="space-y-2 pl-8">
                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 cursor-pointer hover:border-purple-400 transition">
                        <input type="radio" name="answers[${q.id}]" value="a" required class="w-4 h-4 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700 dark:text-gray-200"><strong>A.</strong> ${q.option_a}</span>
                    </label>
                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 cursor-pointer hover:border-purple-400 transition">
                        <input type="radio" name="answers[${q.id}]" value="b" class="w-4 h-4 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700 dark:text-gray-200"><strong>B.</strong> ${q.option_b}</span>
                    </label>
                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 cursor-pointer hover:border-purple-400 transition">
                        <input type="radio" name="answers[${q.id}]" value="c" class="w-4 h-4 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700 dark:text-gray-200"><strong>C.</strong> ${q.option_c}</span>
                    </label>
                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 cursor-pointer hover:border-purple-400 transition">
                        <input type="radio" name="answers[${q.id}]" value="d" class="w-4 h-4 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-700 dark:text-gray-200"><strong>D.</strong> ${q.option_d}</span>
                    </label>
                </div>
            `;
            container.appendChild(card);
        });

        // Set quiz AJAX submission handler
        const form = document.getElementById('qr-form');
        form.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const resultBox = document.getElementById('qr-result-box');
                    const iconBox = document.getElementById('qr-result-icon');
                    const heading = document.getElementById('qr-result-heading');
                    const msg = document.getElementById('qr-result-message');

                    document.getElementById('qr-result-score').innerText = data.score;
                    document.getElementById('qr-result-correct').innerText = data.correct_count;
                    document.getElementById('qr-result-total').innerText = data.total_questions;

                    if (data.passed) {
                        iconBox.className = 'w-14 h-14 rounded-full mx-auto flex items-center justify-center text-2xl font-bold bg-emerald-100 text-emerald-800';
                        iconBox.innerHTML = '&check;';
                        heading.className = 'text-base font-extrabold text-emerald-800';
                        heading.innerText = 'SELAMAT! ANDA LULUS EVALUASI PEMAHAMAN';
                        msg.innerText = `Skor Anda ${data.score}/100 melampaui batas minimum kelulusan (${data.passing_score}%). Pemahaman Anda sangat baik terhadap modul ini!`;
                    } else {
                        iconBox.className = 'w-14 h-14 rounded-full mx-auto flex items-center justify-center text-2xl font-bold bg-amber-100 text-amber-800';
                        iconBox.innerHTML = '!';
                        heading.className = 'text-base font-extrabold text-amber-800';
                        heading.innerText = 'BELUM LULUS (PERLU MENGULANG)';
                        msg.innerText = `Skor Anda belum mencapai batas ${data.passing_score}%. Silakan tonton kembali video pembelajaran dan ulangi kuis.`;
                    }

                    resultBox.classList.remove('hidden');
                    resultBox.scrollIntoView({ behavior: 'smooth' });

                    // Highlight review answers
                    if (data.question_results) {
                        for (const qId in data.question_results) {
                            const res = data.question_results[qId];
                            const cardInputs = document.querySelectorAll(`input[name="answers[${qId}]"]`);
                            cardInputs.forEach(input => {
                                const parent = input.closest('label');
                                if (input.value === res.correct_answer) {
                                    parent.classList.add('bg-emerald-50', 'border-emerald-500', 'text-emerald-900', 'font-bold');
                                } else if (input.value === res.user_answer && !res.is_correct) {
                                    parent.classList.add('bg-red-50', 'border-red-400', 'text-red-800');
                                }
                            });
                        }
                    }
                }
            })
            .catch(err => {
                form.submit(); // fallback to normal form post
            });
        };

        document.getElementById('modal-quiz-runner').classList.remove('hidden');
    }

    function updateQuizActionUrl(quizId) {
        const select = document.getElementById('select-target-quiz');
        const selectedOption = select.options[select.selectedIndex];
        const actionUrl = selectedOption.getAttribute('data-action');
        document.getElementById('form-tambah-soal').action = actionUrl;
    }

    // Certificate Modal Helpers
    function openCreateCertificateModal(trainingId = null, trainingTitle = '') {
        const modal = document.getElementById('modal-buat-sertifikat-admin');
        if (!modal) return;
        const select = document.getElementById('modal-cert-training-id');
        const titleInput = document.getElementById('modal-cert-title');
        if (trainingId && select) {
            select.value = trainingId;
            if (titleInput && trainingTitle) {
                titleInput.value = 'Sertifikasi Kompetensi: ' + trainingTitle;
            }
        }
        modal.classList.remove('hidden');
    }

    function handleTrainingSelectChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        const trainingTitle = selectedOption.getAttribute('data-title');
        const titleInput = document.getElementById('modal-cert-title');
        if (trainingTitle && titleInput && !titleInput.value) {
            titleInput.value = 'Sertifikasi Kompetensi: ' + trainingTitle;
        }
    }

    // Bimtek Offline Modal Helpers
    function openRegisterBimtekOfflineModal(training) {
        if (!training) return;
        const form = document.getElementById('form-daftar-bimtek-offline');
        if (form) {
            form.action = '/pelatihan/' + training.id + '/daftar-offline';
        }
        const titleEl = document.getElementById('md-offline-title');
        if (titleEl) titleEl.innerText = training.title;

        const locEl = document.getElementById('md-offline-location');
        if (locEl) locEl.innerText = training.location || 'Sentra Peternakan Jatim';

        const dateEl = document.getElementById('md-offline-date');
        if (dateEl) {
            const startDate = training.start_date ? training.start_date.substring(0, 10) : 'Jadwal Ditentukan';
            const endDate = (training.end_date && training.end_date !== training.start_date) ? ' s/d ' + training.end_date.substring(0, 10) : '';
            dateEl.innerText = startDate + endDate;
        }

        const modal = document.getElementById('modal-daftar-bimtek-offline');
        if (modal) modal.classList.remove('hidden');
    }

    function openTicketModal(registration, training) {
        if (!registration || !training) return;

        const regCodeEl = document.getElementById('tk-regcode');
        if (regCodeEl) regCodeEl.innerText = registration.registration_code || 'REG-BMTK';

        const titleEl = document.getElementById('tk-title');
        if (titleEl) titleEl.innerText = training.title || 'Bimbingan Teknis';

        const locEl = document.getElementById('tk-location');
        if (locEl) locEl.innerText = training.location || 'Sentra Peternakan';

        const schedEl = document.getElementById('tk-schedule');
        if (schedEl) {
            const startDate = training.start_date ? training.start_date.substring(0, 10) : '-';
            const endDate = (training.end_date && training.end_date !== training.start_date) ? ' s/d ' + training.end_date.substring(0, 10) : '';
            schedEl.innerText = startDate + endDate;
        }

        const statusEl = document.getElementById('tk-status');
        if (statusEl) {
            const isConfirmed = registration.status === 'confirmed';
            statusEl.innerText = isConfirmed ? 'Diverifikasi' : (registration.status || 'Terdaftar');
            statusEl.className = 'px-2 py-0.5 rounded text-[10px] font-bold ' + (isConfirmed ? 'bg-emerald-200 text-emerald-900' : 'bg-amber-100 text-amber-900') + ' uppercase';
        }

        const docSection = document.getElementById('tk-doc-section');
        const docLink = document.getElementById('tk-doc-link');
        const docName = document.getElementById('tk-doc-name');

        if (registration.requirement_document_path || registration.requirement_document_name) {
            if (docSection) docSection.classList.remove('hidden');
            if (docLink) docLink.href = '/pelatihan/registrations/' + registration.id + '/dokumen';
            if (docName) docName.innerText = registration.requirement_document_name || 'Unduh Berkas Persyaratan';
        } else {
            if (docSection) docSection.classList.add('hidden');
        }

        const modal = document.getElementById('modal-tiket-bimtek-peternak');
        if (modal) modal.classList.remove('hidden');
    }

    @if($currentUser && $currentUser->isAdmin())
    const bimtekRegistrationsData = @json($allRegistrations);

    function openAdminTrainingParticipantsModal(trainingId, trainingTitle) {
        const titleEl = document.getElementById('adm-part-title');
        if (titleEl) titleEl.innerText = 'Daftar Peserta Bimtek: ' + trainingTitle;

        const tbody = document.getElementById('adm-part-tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        const participants = (bimtekRegistrationsData || []).filter(r => r.training_id == trainingId);

        if (!participants || participants.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-xs">
                        Belum ada peternak yang mendaftar pada program bimbingan teknis ini.
                    </td>
                </tr>
            `;
            document.getElementById('modal-peserta-bimtek-admin').classList.remove('hidden');
            return;
        }

        const token = '{{ csrf_token() }}';

        participants.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition';

            const peternakName = r.user ? r.user.name : 'Peternak';
            const nikText = r.nik ? `NIK: ${r.nik}` : (r.user && r.user.email ? r.user.email : '-');
            const farmText = r.farm_name ? ` &bull; ${r.farm_name}` : '';
            const regCode = r.registration_code || '-';

            let docHtml = '<span class="text-gray-400 italic">Tidak ada berkas</span>';
            if (r.requirement_document_path) {
                const docName = r.requirement_document_name || 'Unduh Berkas';
                docHtml = `
                    <a href="/pelatihan/registrations/${r.id}/dokumen" class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-400 font-bold hover:underline" title="Unduh Berkas Persyaratan">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        <span class="truncate max-w-[140px]">${docName}</span>
                    </a>
                `;
            }

            const isConfirmed = (r.status === 'confirmed');
            const statusBadge = `
                <span class="px-2 py-0.5 rounded text-[10px] font-bold ${isConfirmed ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300'} uppercase">
                    ${isConfirmed ? 'Diverifikasi' : r.status}
                </span>
            `;

            const actionHtml = `
                <form action="/pelatihan/registrations/${r.id}/status" method="POST" class="inline-flex items-center gap-1.5 justify-end">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="tab" value="bimtek_offline">
                    <select name="status" onchange="this.form.submit()" class="bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-[11px] p-1 text-gray-800 dark:text-gray-200 cursor-pointer">
                        <option value="pending" ${r.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="confirmed" ${r.status === 'confirmed' ? 'selected' : ''}>Verifikasi (Terima)</option>
                        <option value="attended" ${r.status === 'attended' ? 'selected' : ''}>Hadir Lapangan</option>
                        <option value="cancelled" ${r.status === 'cancelled' ? 'selected' : ''}>Tolak / Batal</option>
                    </select>
                </form>
            `;

            tr.innerHTML = `
                <td class="px-3.5 py-3 font-medium text-gray-900 dark:text-white">
                    <div>${peternakName}</div>
                    <div class="text-[11px] text-gray-400 font-normal">${nikText}${farmText}</div>
                </td>
                <td class="px-3.5 py-3 text-center font-mono font-bold text-emerald-700 dark:text-emerald-400">
                    ${regCode}
                </td>
                <td class="px-3.5 py-3 text-center">
                    ${docHtml}
                </td>
                <td class="px-3.5 py-3 text-center">
                    ${statusBadge}
                </td>
                <td class="px-3.5 py-3 text-right">
                    ${actionHtml}
                </td>
            `;

            tbody.appendChild(tr);
        });

        document.getElementById('modal-peserta-bimtek-admin').classList.remove('hidden');
    }
    @endif

    // Initialize select action on load
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('select-target-quiz');
        if (select) {
            updateQuizActionUrl(select.value);
        }
    });
</script>
@endsection

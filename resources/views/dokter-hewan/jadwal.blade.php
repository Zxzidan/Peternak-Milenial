@extends('layouts.app')

@section('title', 'Manajemen Jadwal & Kuota Konsultasi — Dokter Hewan Puskeswan Jatim')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                Jadwal & Kuota Layanan Konsultasi
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Atur jam kerja, batasi kuota layanan konsultasi per jam untuk mencegah penumpukan, dan kelola konfirmasi janji temu peternak.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <button
                type="button"
                onclick="document.getElementById('modal-generate-slots').classList.remove('hidden')"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 rounded-xl transition-all shadow-2xs"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Generate Slot Harian</span>
            </button>

            <button
                type="button"
                onclick="document.getElementById('modal-tambah-slot').classList.remove('hidden')"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl transition-all shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Slot Jam Baru</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div class="p-4 text-xs sm:text-sm text-emerald-800 bg-emerald-50 dark:bg-emerald-950/50 dark:text-emerald-300 rounded-xl border border-emerald-200 dark:border-emerald-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 text-xs sm:text-sm text-rose-800 bg-rose-50 dark:bg-rose-950/50 dark:text-rose-300 rounded-xl border border-rose-200 dark:border-rose-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 font-bold">&times;</button>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 text-xs sm:text-sm text-amber-800 bg-amber-50 dark:bg-amber-950/50 dark:text-amber-300 rounded-xl border border-amber-200 dark:border-amber-800">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Ringkasan Statistik Kuota Hari Ini -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- 1. Total Slot Hari Ini -->
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Slot Jadwal Hari Ini</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mt-2 block tracking-tight">
                {{ $stats['total_slots_today'] }}
            </span>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Sesi jam konsultasi aktif
            </p>
        </div>

        <!-- 2. Kuota Layanan Hari Ini -->
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-emerald-200/80 dark:border-emerald-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-800 dark:text-emerald-400">Total Kuota Hari Ini</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-emerald-700 dark:text-emerald-400 mt-2 block tracking-tight">
                {{ $stats['total_quota_today'] }}
            </span>
            <p class="text-[11px] text-emerald-700/80 dark:text-emerald-400/80 mt-1">
                Kapasitas konsultasi dibuka
            </p>
        </div>

        <!-- 3. Pasien Terdaftar Hari Ini -->
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-amber-200/80 dark:border-amber-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-800 dark:text-amber-400">Pasien Terdaftar</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-amber-700 dark:text-amber-400 mt-2 block tracking-tight">
                {{ $stats['booked_today'] }}
            </span>
            <p class="text-[11px] text-amber-700/80 dark:text-amber-400/80 mt-1">
                Booking konsultasi hari ini
            </p>
        </div>

        <!-- 4. Konsultasi Selesai -->
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-purple-200/80 dark:border-purple-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-purple-800 dark:text-purple-400">Total Selesai Ditangani</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/80 text-purple-600 dark:text-purple-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-purple-700 dark:text-purple-400 mt-2 block tracking-tight">
                {{ $stats['completed_count'] }}
            </span>
            <p class="text-[11px] text-purple-700/80 dark:text-purple-400/80 mt-1">
                Rekam medis & resep tersimpan
            </p>
        </div>
    </div>

    <!-- Navigation Tabs / Navbar -->
    <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700/80 pb-3 overflow-x-auto text-xs [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <a
            href="{{ route('dokter-hewan.jadwal.index', ['tab' => 'slot']) }}"
            id="tab-btn-slot"
            onclick="switchScheduleTab('slot'); return false;"
            class="tab-nav-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold transition shrink-0 {{ $activeTab === 'slot' ? 'bg-primary-700 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-750 border border-gray-200 dark:border-gray-700' }}"
        >
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span>Daftar Slot Jam Layanan</span>
            <span id="tab-badge-slot" class="tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold {{ $activeTab === 'slot' ? 'bg-white/20 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                {{ $schedules->total() }}
            </span>
        </a>

        <a
            href="{{ route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis']) }}"
            id="tab-btn-rekam-medis"
            onclick="switchScheduleTab('rekam_medis'); return false;"
            class="tab-nav-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold transition shrink-0 {{ $activeTab === 'rekam_medis' ? 'bg-primary-700 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-750 border border-gray-200 dark:border-gray-700' }}"
        >
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
            <span>Riwayat Pemeriksaan & Rekam Medis</span>
            <span id="tab-badge-rekam-medis" class="tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold {{ $activeTab === 'rekam_medis' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300' }}">
                {{ $completedConsultations->total() }}
            </span>
        </a>
    </div>

    <!-- TAB PANE 1: Daftar Slot Jam & Kuota Layanan Dokter -->
    <div id="tab-pane-slot" class="{{ $activeTab === 'slot' ? '' : 'hidden' }}">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 shadow-2xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Daftar Slot Jam Layanan & Kuota Dokter</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Peternak hanya dapat mendaftar pada slot dengan status <strong class="text-emerald-700">Buka</strong> dan kuota yang masih tersedia.
                    </p>
                </div>

                <!-- Filter Tanggal Slot -->
                <form method="GET" action="{{ route('dokter-hewan.jadwal.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="tab" value="slot">
                    <input
                        type="date"
                        name="filter_date"
                        value="{{ request('filter_date', '') }}"
                        class="px-2.5 py-1.5 text-xs bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white"
                    >
                    <button
                        type="submit"
                        class="px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 rounded-lg transition-colors"
                    >
                        Filter
                    </button>
                    @if(request('filter_date'))
                        <a href="{{ route('dokter-hewan.jadwal.index', ['tab' => 'slot']) }}" class="text-xs text-gray-400 hover:text-gray-600">Reset</a>
                    @endif
                </form>
            </div>

        <div class="overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <table class="w-full text-xs text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-50/75 dark:bg-gray-700/50 text-[11px] font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700 text-center">
                    <tr>
                        <th class="px-4 py-3 text-center">Tanggal Layanan</th>
                        <th class="px-4 py-3 text-center">Jam Konsultasi</th>
                        <th class="px-4 py-3 text-center">Kuota Maksimal</th>
                        <th class="px-4 py-3 text-center">Terisi</th>
                        <th class="px-4 py-3 text-center">Sisa Kuota</th>
                        <th class="px-4 py-3 text-center">Status Layanan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-750 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-center font-medium text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d M Y') }}
                            @if($schedule->date === now()->toDateString())
                                <span class="ms-1.5 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-100 dark:bg-emerald-950/60 rounded">Hari Ini</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center font-semibold text-gray-800 dark:text-gray-200">
                            {{ $schedule->time_slot_label }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center font-bold text-gray-700 dark:text-gray-300">
                            {{ $schedule->quota }} Pasien
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @php
                                $activeSlotPatientsCount = $schedule->consultations->whereIn('status', ['menunggu_konfirmasi', 'dikonfirmasi'])->count();
                            @endphp
                            @if($activeSlotPatientsCount > 0)
                                <button
                                    type="button"
                                    onclick="openSlotPatientsModal({{ $schedule->id }})"
                                    title="Klik untuk melihat antrean pasien aktif"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 hover:bg-blue-200 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200 dark:hover:bg-blue-800 transition-all cursor-pointer shadow-2xs"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                    <span>{{ $activeSlotPatientsCount }} Antrean</span>
                                </button>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                    0 Antrean
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if($schedule->is_full)
                                <span class="px-2 py-0.5 text-[11px] font-bold text-rose-700 bg-rose-100 dark:bg-rose-950/60 dark:text-rose-300 rounded-md">
                                    Penuh (0)
                                </span>
                            @else
                                <span class="px-2 py-0.5 text-[11px] font-bold text-emerald-700 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-md">
                                    Tersedia {{ $schedule->remaining_quota }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <form action="{{ route('dokter-hewan.jadwal.toggle', $schedule) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    title="Klik untuk mengubah status Buka / Tutup"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold transition-all {{ $schedule->status === 'buka' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300' }}"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full {{ $schedule->status === 'buka' ? 'bg-emerald-600' : 'bg-gray-400' }}"></span>
                                    <span>{{ $schedule->status === 'buka' ? 'Buka Layanan' : 'Ditutup' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="inline-flex items-center justify-center gap-1.5">
                                <button
                                    type="button"
                                    onclick="openSlotPatientsModal({{ $schedule->id }})"
                                    class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:hover:bg-emerald-900/60 rounded-lg border border-emerald-200 dark:border-emerald-800 transition-all cursor-pointer shadow-2xs"
                                    title="Lihat antrean pasien aktif pada slot jam ini"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <span>Pasien ({{ $activeSlotPatientsCount }})</span>
                                </button>

                                <button
                                    type="button"
                                    onclick="openEditSlotModal({{ $schedule->id }}, '{{ $schedule->date instanceof \Carbon\CarbonInterface ? $schedule->date->toDateString() : substr((string)$schedule->date, 0, 10) }}', '{{ substr((string)$schedule->start_time, 0, 5) }}', '{{ substr((string)$schedule->end_time, 0, 5) }}', {{ $schedule->quota }}, '{{ addslashes($schedule->notes ?? '') }}')"
                                    class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 rounded-lg border border-primary-200 dark:border-primary-800 transition-all cursor-pointer shadow-2xs"
                                    title="Edit slot konsultasi"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('dokter-hewan.jadwal.destroy', $schedule) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Hapus slot jam konsultasi ini? Pendaftaran yang sudah masuk juga akan dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 dark:text-rose-300 dark:hover:bg-rose-900/60 rounded-lg border border-rose-200 dark:border-rose-800 transition-all cursor-pointer shadow-2xs"
                                        title="Hapus slot jam konsultasi"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                            <div class="max-w-xs mx-auto">
                                <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada slot jam konsultasi</p>
                                <p class="text-xs text-gray-400 mt-1">Gunakan tombol <strong>Generate Slot Harian</strong> atau <strong>Tambah Slot Jam Baru</strong> untuk mulai mengatur kuota layanan Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
        <div class="p-3 border-t border-gray-100 dark:border-gray-700">
            {{ $schedules->links() }}
        </div>
        @endif
        </div>
    </div>

    <!-- TAB PANE 2: Riwayat Pemeriksaan & Rekam Medis -->
    <div id="tab-pane-rekam-medis" class="{{ $activeTab === 'rekam_medis' ? '' : 'hidden' }}">
        <div id="section-rekam-medis" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 shadow-2xs overflow-hidden">
            <!-- Section Header -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/70 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-2xs border border-emerald-200/60 dark:border-emerald-800/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white leading-snug">
                                Riwayat Pemeriksaan & Rekam Medis Pasien
                            </h2>
                            <span class="text-[11px] px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                {{ $completedConsultations->total() }} Selesai
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Arsip berkas rekam medis, diagnosa klinis, dan resep terapi yang telah selesai ditangani oleh dokter hewan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filter Bar: Tanggal Kalender, Kata Kunci & Quick Chips -->
            <div class="p-3.5 sm:p-4 bg-gray-50/75 dark:bg-gray-750/40 border-b border-gray-100 dark:border-gray-700/80">
                <form method="GET" action="{{ route('dokter-hewan.jadwal.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <input type="hidden" name="tab" value="rekam_medis">
                    @if(request('filter_date'))
                        <input type="hidden" name="filter_date" value="{{ request('filter_date') }}">
                    @endif
                    <div class="flex flex-wrap items-center gap-2.5 flex-1">
                        <!-- Date Picker Filter -->
                        <div class="relative inline-flex items-center">
                            <input
                                type="date"
                                name="filter_rm_date"
                                value="{{ $filterRmDate }}"
                                class="ps-9 pe-3 py-1.5 text-xs font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 cursor-pointer shadow-2xs hover:border-gray-400 dark:hover:border-gray-500 transition"
                                title="Filter berdasarkan tanggal pemeriksaan"
                            >
                            <div class="absolute inset-y-0 start-0 flex items-center ps-2.5 pointer-events-none text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                        </div>

                        <!-- Search Input Filter -->
                        <div class="relative flex-1 min-w-[200px] max-w-sm">
                            <input
                                type="text"
                                name="search_rm"
                                value="{{ $searchRm }}"
                                placeholder="Cari peternak, e-tag, atau diagnosa..."
                                class="w-full ps-9 pe-3 py-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 shadow-2xs transition"
                            >
                            <div class="absolute inset-y-0 start-0 flex items-center ps-2.5 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                            </div>
                        </div>

                        <!-- Tombol Filter -->
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl transition shadow-2xs cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/></svg>
                            <span>Filter</span>
                        </button>

                        @if(!empty($filterRmDate) || !empty($searchRm))
                            <a
                                href="{{ route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis']) }}"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/50 dark:text-rose-300 rounded-xl border border-rose-200 dark:border-rose-800 transition cursor-pointer"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Reset Filter</span>
                            </a>
                        @endif
                    </div>

                    <!-- Quick Date Chips -->
                    @if(isset($availableRmDates) && count($availableRmDates) > 0)
                        <div class="hidden sm:flex items-center gap-1.5 flex-wrap">
                            <span class="text-[11px] text-gray-400 font-medium">Tersedia:</span>
                            @foreach(collect($availableRmDates)->take(3) as $chip)
                                <a
                                    href="{{ route('dokter-hewan.jadwal.index', array_merge(request()->query(), ['tab' => 'rekam_medis', 'filter_rm_date' => $chip['iso']])) }}"
                                    class="px-2.5 py-1 text-[11px] font-semibold {{ $filterRmDate === $chip['iso'] ? 'bg-primary-700 text-white' : 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 border border-gray-200 dark:border-gray-700' }} rounded-lg transition"
                                >
                                    {{ $chip['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

        <!-- Cards Container (Rekam Medis) -->
        <div class="p-4 sm:p-5 sm:p-6 bg-gray-50/50 dark:bg-gray-900/40">
            @if($completedConsultations->isEmpty())
                <div class="py-12 px-4 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/80 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-3 shadow-2xs">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">
                        @if(!empty($filterRmDate) || !empty($searchRm))
                            Tidak ada riwayat rekam medis yang sesuai filter
                        @else
                            Belum ada riwayat rekam medis pemeriksaan
                        @endif
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto">
                        @if(!empty($filterRmDate) || !empty($searchRm))
                            Silakan ubah tanggal kalender atau kata kunci pencarian Anda untuk melihat arsip rekam medis lainnya.
                        @else
                            Setelah Anda menyelesaikan konsultasi pasien dan mengisi catatan pemeriksaan & resep, berkas rekam medis resmi otomatis terarsip rapi di sini.
                        @endif
                    </p>
                    @if(!empty($filterRmDate) || !empty($searchRm))
                        <div class="mt-3">
                            <a href="{{ route('dokter-hewan.jadwal.index') }}#section-rekam-medis" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 rounded-lg transition">
                                <span>Tampilkan Semua Riwayat</span>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:gap-5">
                    @foreach($completedConsultations as $record)
                        @php
                            $isOnline = in_array(strtolower($record->consultation_type ?? ''), ['online', 'telemedisin', 'konsultasi_online'])
                                || ($record->schedule?->service_type === 'online');
                            $recordDateObj = (in_array($record->status, ['selesai', 'answered', 'closed']) && $record->updated_at)
                                ? $record->updated_at->timezone('Asia/Jakarta')
                                : ($record->schedule
                                    ? \Carbon\Carbon::parse($record->schedule->date)
                                    : ($record->consultation_date ? \Carbon\Carbon::parse($record->consultation_date) : $record->updated_at));
                            $dateFormatted = $recordDateObj->translatedFormat('l, d F Y');
                            $timeFormatted = $record->time_formatted;
                            $userPhone = $record->user?->phone_number ?? $record->user?->peternakProfile?->phone ?? '';
                            $cleanPhone = preg_replace('/[^0-9]/', '', $userPhone);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            } elseif (str_starts_with($cleanPhone, '8')) {
                                $cleanPhone = '62' . $cleanPhone;
                            }
                            $peternakName = $record->user?->name ?? 'Peternak';
                            $livestockInfo = $record->livestock ? (' untuk ' . $record->livestock->name . ' - ' . $record->livestock->type) : '';
                            $waMessage = urlencode("Halo Bapak/Ibu {$peternakName}, berikut adalah laporan kesehatan dan instruksi penanganan lanjutan{$livestockInfo} dari dokter hewan dinas.");
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group relative">
                            <div class="space-y-4">
                                <!-- Card Top Bar: No Booking, Ternak, & Status -->
                                <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-700/60 flex-wrap">
                                    <div class="flex items-center gap-2 min-w-0 flex-1 flex-wrap">
                                        <span class="inline-flex items-center gap-1.5 font-mono font-bold text-xs text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/80 dark:border-primary-800/60 px-2.5 py-1 rounded-lg shrink-0">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>{{ $record->booking_code ?? ('#CONS-' . $record->id) }}</span>
                                        </span>

                                        @if($record->livestock)
                                            <span class="inline-flex items-center gap-1.5 font-mono font-bold text-xs text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-2.5 py-1 rounded-lg shrink-0">
                                                <span>ETAG: {{ $record->livestock->tag_number ?? ($record->livestock->e_tag_number ?? '-') }}</span>
                                            </span>
                                            <span class="font-sans font-semibold text-xs text-gray-700 dark:text-gray-300">
                                                ({{ $record->livestock->name ?? ($record->livestock->breed ?? 'Ternak') }})
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        @if($isOnline)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Online</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300 border border-purple-300 dark:border-purple-800">
                                                <span>Offline</span>
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Selesai Ditangani</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Peternak & Jadwal Section -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 bg-gray-50/80 dark:bg-gray-750/50 rounded-xl border border-gray-100 dark:border-gray-700/60 text-xs">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-emerald-500 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-xs">
                                            {{ strtoupper(substr($peternakName, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white text-sm">{{ $peternakName }}</div>
                                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-[11px] mt-0.5">
                                                @if($userPhone)
                                                    <span class="font-mono">📞 {{ $userPhone }}</span>
                                                    <span>•</span>
                                                @endif
                                                <span>{{ $record->user?->peternakProfile?->address ?? 'Peternak Jawa Timur' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1.5 text-gray-600 dark:text-gray-300 font-medium whitespace-nowrap shrink-0">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $dateFormatted }} • {{ $timeFormatted }}</span>
                                    </div>
                                </div>

                                <!-- Keluhan & Diagnosa Medis -->
                                <div class="space-y-3 text-xs">
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Keluhan Peternak:</span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white leading-normal mt-0.5">
                                            {{ $record->subject }}
                                        </h4>
                                        @if($record->complaint_details)
                                            <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 leading-relaxed">
                                                {{ $record->complaint_details }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Diagnosis & Resep Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                        <div class="p-3.5 bg-blue-50/70 dark:bg-blue-950/40 rounded-xl border border-blue-100 dark:border-blue-900/50 text-xs">
                                            <span class="font-bold text-primary-700 dark:text-primary-300 block mb-1">
                                                Hasil Evaluasi & Diagnosa Medis:
                                            </span>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                                {{ $record->doctor_notes ?: 'Pemeriksaan telemedisin selesai dilakukan. Kondisi ternak dalam evaluasi berkala.' }}
                                            </p>
                                        </div>

                                        <div class="p-3.5 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-xl border border-emerald-100 dark:border-emerald-900/50 text-xs">
                                            <span class="font-bold text-emerald-800 dark:text-emerald-300 block mb-1">
                                                Resep Obat & Terapi Pengobatan:
                                            </span>
                                            <p class="text-emerald-950 dark:text-emerald-200 font-semibold leading-relaxed whitespace-pre-line">
                                                {{ $record->prescription ?: ($record->recommendations ?: 'Tidak ada resep obat khusus. Rekomendasi perawatan terlampir pada dokumen laporan kesehatan.') }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($record->hypothesis || $record->follow_up_instructions || $record->requires_visit)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1 text-xs">
                                            @if($record->hypothesis)
                                                <div class="p-3 bg-amber-50/70 dark:bg-amber-950/30 rounded-xl border border-amber-200/80 dark:border-amber-900/40">
                                                    <div class="flex items-center justify-between gap-1 mb-1">
                                                        <span class="font-bold text-amber-900 dark:text-amber-300">Dugaan Masalah / Kondisi:</span>
                                                        @if($record->urgency_level)
                                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $record->urgency_badge_classes }}">
                                                                Urgensi: {{ $record->urgency_label }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-amber-950 dark:text-amber-200 leading-relaxed">{{ $record->hypothesis }}</p>
                                                </div>
                                            @endif

                                            @if($record->follow_up_instructions)
                                                <div class="p-3 bg-indigo-50/70 dark:bg-indigo-950/30 rounded-xl border border-indigo-200/80 dark:border-indigo-900/40">
                                                    <span class="font-bold text-indigo-900 dark:text-indigo-300 block mb-1">Instruksi Tindak Lanjut:</span>
                                                    <p class="text-indigo-950 dark:text-indigo-200 leading-relaxed">{{ $record->follow_up_instructions }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        @if($record->requires_visit)
                                            <div class="p-2.5 bg-rose-50 dark:bg-rose-950/40 rounded-xl border border-rose-200 dark:border-rose-900/60 flex items-center gap-2 text-xs text-rose-800 dark:text-rose-300 font-semibold">
                                                <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                </svg>
                                                <span>Kasus ini memerlukan Kunjungan Langsung ke Lokasi Peternakan oleh tim veteriner lapangan.</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="mt-5 pt-3.5 border-t border-gray-100 dark:border-gray-700/60 flex flex-wrap items-center justify-between gap-2.5">
                                <div class="text-[11px] text-gray-400 font-mono">
                                    Dicatat: {{ $record->updated_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }} WIB
                                </div>

                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- Buka Lembar Klinis Lengkap -->
                                    <a
                                        href="{{ route('dokter-hewan.konsultasi.show', $record) }}"
                                        class="inline-flex items-center justify-center gap-1.5 h-8 px-3 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 rounded-xl border border-primary-200 dark:border-primary-800 transition cursor-pointer shadow-2xs"
                                        title="Buka Lembar Pemeriksaan Klinis & Tanggapan Resmi Lengkap"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span>Detail Klinis</span>
                                    </a>

                                    <!-- Diagnosis Terkunci (Permanen) -->
                                    <span
                                        class="inline-flex items-center justify-center gap-1.5 h-8 px-3 text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-750 rounded-xl border border-gray-200 dark:border-gray-700 select-none cursor-default"
                                        title="Hasil evaluasi medis dan resep obat telah selesai dan terkunci permanen"
                                    >
                                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                        <span>Diagnosis Terkunci</span>
                                    </span>

                                    <!-- WhatsApp Peternak -->
                                    @if($cleanPhone)
                                        <a
                                            href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center gap-1.5 h-8 px-3 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:hover:bg-emerald-900/60 rounded-xl border border-emerald-200 dark:border-emerald-800 transition cursor-pointer shadow-2xs"
                                            title="Kirim pesan WhatsApp ke peternak"
                                        >
                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" /></svg>
                                            <span>WhatsApp</span>
                                        </a>
                                    @endif

                                    <!-- Download Laporan Kesehatan PDF -->
                                    <a
                                        href="{{ route('konsultasi.rekam-medis.download', ['type' => 'consultation', 'id' => $record->id]) }}"
                                        target="_blank"
                                        class="inline-flex items-center justify-center gap-1.5 h-8 px-3 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl transition shadow-xs hover:shadow-sm cursor-pointer"
                                        title="Unduh berkas laporan kesehatan resmi format PDF"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        <span>Download PDF</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($completedConsultations->hasPages())
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $completedConsultations->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

    <!-- Modals Daftar Pasien Terdaftar Per Slot Jadwal -->
    @foreach($schedules as $schedule)
    @php
        $activePatients = $schedule->consultations->whereIn('status', ['menunggu_konfirmasi', 'dikonfirmasi']);
    @endphp
    <div id="modal-pasien-slot-{{ $schedule->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-6xl w-full p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-start justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                <div class="space-y-1">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white leading-snug flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                        <span>Daftar Pasien Menunggu Pemeriksaan</span>
                    </h3>
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 flex-wrap leading-normal">
                        <span>Jadwal: <strong class="text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}</strong> (Pukul <strong>{{ $schedule->time_slot_label }}</strong>)</span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>Kuota: <strong class="text-gray-800 dark:text-gray-200">{{ $schedule->quota }} Pasien</strong></span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>Antrean Aktif: <strong class="text-emerald-700 dark:text-emerald-400">{{ $activePatients->count() }} Pasien</strong></span>
                    </div>
                </div>
                <button
                    type="button"
                    onclick="closeSlotPatientsModal({{ $schedule->id }})"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer shrink-0"
                >
                    ✕
                </button>
            </div>

            <!-- Modal Body (Scrollable Table) -->
            <div class="overflow-y-auto py-4 flex-1">
                @if($activePatients->isEmpty())
                    <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700/60 flex items-center justify-center text-gray-400 dark:text-gray-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada pasien aktif yang menunggu pemeriksaan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            Pasien yang telah selesai diperiksa otomatis dipindahkan ke bagian <strong>Riwayat Rekam Medis</strong> di bawah.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        <table class="w-full text-xs text-gray-700 dark:text-gray-300 text-left">
                            <thead class="bg-gray-50/90 dark:bg-gray-700/60 text-[11px] font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-3 py-2.5 text-center w-8">No</th>
                                    <th class="px-3 py-2.5 text-left">Kode & Peternak</th>
                                    <th class="px-3 py-2.5 text-left">Keluhan</th>
                                    <th class="px-3 py-2.5 text-center">Metode</th>
                                    <th class="px-3 py-2.5 text-center">Status</th>
                                    <th class="px-3 py-2.5 text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 bg-white dark:bg-gray-800">
                                @foreach($activePatients as $index => $booking)
                                    @php
                                        $isOnline = in_array(strtolower($booking->consultation_type ?? ''), ['online', 'telemedisin', 'konsultasi_online'])
                                            || ($schedule->service_type === 'online');
                                        $userPhone = $booking->user?->phone_number ?? $booking->user?->peternakProfile?->phone ?? '';
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $userPhone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        } elseif (str_starts_with($cleanPhone, '8')) {
                                            $cleanPhone = '62' . $cleanPhone;
                                        }
                                        $vetName = $currentVet->user?->name ?? $currentVet->name ?? auth()->user()->name ?? 'Dokter Hewan Puskeswan';
                                        $peternakName = $booking->user?->name ?? 'Peternak';
                                        $waMessage = urlencode("Halo Bapak/Ibu {$peternakName}, saya {$vetName} dari Dinas Peternakan Jawa Timur. Saya menghubungi Anda untuk sesi konsultasi online terkait keluhan: " . ($booking->subject ?? 'Pemeriksaan Kesehatan') . ". Apakah Anda saat ini siap berkonsultasi?");
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-750 transition-colors">
                                        <td class="px-3 py-2.5 text-center font-medium text-gray-500 dark:text-gray-400">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-3 py-2.5 whitespace-nowrap">
                                            <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                {{ $booking->booking_code ?? ('#CONS-' . $booking->id) }}
                                            </span>
                                            <div class="font-bold text-gray-900 dark:text-white mt-0.5">{{ $peternakName }}</div>
                                            @if($userPhone)
                                                <div class="text-[11px] text-gray-400 font-mono">📞 {{ $userPhone }}</div>
                                            @endif
                                            @if($booking->livestock)
                                                <div class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium">🐾 {{ $booking->livestock->name }} ({{ $booking->livestock->type }})</div>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 max-w-[160px]">
                                            <div class="font-semibold text-gray-900 dark:text-white truncate" title="{{ $booking->subject }}">
                                                {{ $booking->subject }}
                                            </div>
                                            @if($booking->complaint_details)
                                                <div class="text-[11px] text-gray-500 dark:text-gray-400 truncate" title="{{ $booking->complaint_details }}">
                                                    {{ $booking->complaint_details }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                            @if($isOnline)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800" title="Konsultasi Online">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    <span class="sr-only">Konsultasi </span><span>Online</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300 border border-purple-300 dark:border-purple-800" title="Konsultasi Offline">
                                                    <span class="sr-only">Konsultasi </span><span>Offline</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                            @if($booking->status === 'menunggu_konfirmasi')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-amber-800 bg-amber-100 dark:bg-amber-950/70 dark:text-amber-300 rounded">Menunggu</span>
                                            @elseif($booking->status === 'dikonfirmasi')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-blue-800 bg-blue-100 dark:bg-blue-950/70 dark:text-blue-300 rounded">Dikonfirmasi</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                            <div class="inline-flex items-center justify-center gap-1.5 flex-nowrap">
                                                @if($isOnline && $cleanPhone)
                                                    <a
                                                        href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:hover:bg-emerald-900/60 rounded-lg border border-emerald-200 dark:border-emerald-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                        title="Arahkan ke WhatsApp peternak"
                                                    >
                                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" /></svg>
                                                        <span class="sr-only">Arahkan ke </span><span>WhatsApp</span>
                                                    </a>
                                                @endif

                                                @if($booking->status === 'menunggu_konfirmasi')
                                                    <form action="{{ route('dokter-hewan.jadwal.booking.status', $booking) }}" method="POST" class="inline-flex m-0 p-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="dikonfirmasi">
                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/60 dark:text-blue-300 dark:hover:bg-blue-900/60 rounded-lg border border-blue-200 dark:border-blue-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                            title="Konfirmasi jadwal booking"
                                                        >
                                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                                            <span>Konfirmasi</span>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a
                                                    href="{{ route('dokter-hewan.konsultasi.show', $booking) }}"
                                                    class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 rounded-lg border border-primary-200 dark:border-primary-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                    title="Buka Formulir Tanggapan & Rekomendasi Profesional Dokter"
                                                >
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    <span>Tanggapi</span>
                                                </a>

                                                <form action="{{ route('dokter-hewan.jadwal.booking.status', $booking) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Tandai sesi konsultasi {{ addslashes($booking->booking_code ?? 'ini') }} atas nama {{ addslashes($booking->user?->name ?? 'Peternak') }} sudah selesai?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:hover:bg-emerald-900/60 rounded-lg border border-emerald-200 dark:border-emerald-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                        title="Selesaikan sesi konsultasi"
                                                    >
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                                        <span>Selesai</span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('dokter-hewan.jadwal.booking.status', $booking) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Batalkan jadwal konsultasi peternak ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="dibatalkan">
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 dark:text-amber-300 dark:hover:bg-amber-900/60 rounded-lg border border-amber-200 dark:border-amber-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                        title="Batalkan reservasi"
                                                    >
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                                        <span>Batal</span>
                                                    </button>
                                                </form>

                                                <!-- Tombol Hapus Booking -->
                                                <form action="{{ route('dokter-hewan.jadwal.booking.destroy', $booking) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Hapus data booking {{ addslashes($booking->booking_code ?? 'ini') }} atas nama {{ addslashes($booking->user?->name ?? 'Peternak') }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        title="Hapus data booking ini"
                                                        class="inline-flex items-center justify-center gap-1 h-7 px-2.5 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 dark:text-rose-300 dark:hover:bg-rose-900/60 rounded-lg border border-rose-200 dark:border-rose-800 transition-all cursor-pointer shadow-2xs whitespace-nowrap"
                                                    >
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button
                    type="button"
                    onclick="closeSlotPatientsModal({{ $schedule->id }})"
                    class="px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-xl transition cursor-pointer"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endforeach

</div>

<!-- MODAL 1: Tambah Slot Jam Baru -->
<div id="modal-tambah-slot" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative">
        <button type="button" onclick="document.getElementById('modal-tambah-slot').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
            &times;
        </button>

        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>Tambah Slot Jam Layanan Konsultasi</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Tetapkan jam konsultasi dan batas kuota pasien yang dapat mendaftar.
        </p>

        <form action="{{ route('dokter-hewan.jadwal.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Layanan</label>
                <input
                    type="date"
                    name="date"
                    value="{{ now()->toDateString() }}"
                    min="{{ now()->toDateString() }}"
                    required
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Mulai</label>
                    <input
                        type="time"
                        name="start_time"
                        value="08:00"
                        required
                        class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                    >
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Selesai</label>
                    <input
                        type="time"
                        name="end_time"
                        value="09:00"
                        required
                        class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Kuota Pasien / Sesi</label>
                <input
                    type="number"
                    name="quota"
                    value="5"
                    min="1"
                    max="50"
                    required
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white font-bold"
                >
                <span class="text-[10px] text-gray-400">Maksimum pendaftar per jam</span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan (Opsional)</label>
                <input
                    type="text"
                    name="notes"
                    placeholder="Contoh: Khusus hewan ternak ruminansia sapi/kambing"
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button
                    type="button"
                    onclick="document.getElementById('modal-tambah-slot').classList.add('hidden')"
                    class="px-3.5 py-2 text-xs font-medium text-gray-600 hover:text-gray-800"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl shadow-sm transition-colors"
                >
                    Simpan Slot Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Generate Slot Harian Otomatis -->
<div id="modal-generate-slots" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative">
        <button type="button" onclick="document.getElementById('modal-generate-slots').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
            &times;
        </button>

        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Generate Slot Harian Otomatis</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Sistem akan secara otomatis membuat slot per 1 jam mulai pukul <strong>08:00 WIB hingga 15:00 WIB</strong> untuk tanggal yang dipilih.
        </p>

        <form action="{{ route('dokter-hewan.jadwal.generate') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                <input
                    type="date"
                    name="date"
                    value="{{ now()->toDateString() }}"
                    min="{{ now()->toDateString() }}"
                    required
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Kuota Default Setiap Jam</label>
                <input
                    type="number"
                    name="default_quota"
                    value="5"
                    min="1"
                    max="50"
                    required
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white font-bold"
                >
                <span class="text-[10px] text-gray-400">Contoh: 5 pendaftar per jam</span>
            </div>



            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button
                    type="button"
                    onclick="document.getElementById('modal-generate-slots').classList.add('hidden')"
                    class="px-3.5 py-2 text-xs font-medium text-gray-600 hover:text-gray-800"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl shadow-sm transition-colors"
                >
                    Generate Jadwal Harian
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: Edit Slot Konsultasi -->
<div id="modal-edit-kuota" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative">
        <button type="button" onclick="document.getElementById('modal-edit-kuota').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl font-bold">
            &times;
        </button>

        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span>Edit Slot Konsultasi</span>
        </h3>
        <p id="edit-slot-desc" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Tanggal: -
        </p>

        <form id="form-edit-kuota" action="" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <!-- Jam Konsultasi (Mulai & Selesai) -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Mulai</label>
                    <input
                        type="time"
                        id="edit-slot-start-time"
                        name="start_time"
                        required
                        class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                    >
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Selesai</label>
                    <input
                        type="time"
                        id="edit-slot-end-time"
                        name="end_time"
                        required
                        class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jumlah Kuota</label>
                <input
                    type="number"
                    id="edit-slot-quota"
                    name="quota"
                    value="5"
                    min="1"
                    max="50"
                    required
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white font-bold"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan Khusus</label>
                <input
                    type="text"
                    id="edit-slot-notes"
                    name="notes"
                    placeholder="Opsional"
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button
                    type="button"
                    onclick="document.getElementById('modal-edit-kuota').classList.add('hidden')"
                    class="px-3.5 py-2 text-xs font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl shadow-sm transition-colors"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function switchScheduleTab(tab) {
    const paneSlot = document.getElementById('tab-pane-slot');
    const paneRm = document.getElementById('tab-pane-rekam-medis');
    const btnSlot = document.getElementById('tab-btn-slot');
    const btnRm = document.getElementById('tab-btn-rekam-medis');
    const badgeSlot = document.getElementById('tab-badge-slot');
    const badgeRm = document.getElementById('tab-badge-rekam-medis');

    const activeClasses = 'tab-nav-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold transition shrink-0 bg-primary-700 text-white shadow-xs';
    const inactiveClasses = 'tab-nav-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold transition shrink-0 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-750 border border-gray-200 dark:border-gray-700';

    if (tab === 'rekam_medis') {
        if (paneSlot) paneSlot.classList.add('hidden');
        if (paneRm) paneRm.classList.remove('hidden');

        if (btnSlot) btnSlot.className = inactiveClasses;
        if (btnRm) btnRm.className = activeClasses;

        if (badgeSlot) badgeSlot.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
        if (badgeRm) badgeRm.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold bg-white/20 text-white';
    } else {
        if (paneRm) paneRm.classList.add('hidden');
        if (paneSlot) paneSlot.classList.remove('hidden');

        if (btnRm) btnRm.className = inactiveClasses;
        if (btnSlot) btnSlot.className = activeClasses;

        if (badgeRm) badgeRm.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300';
        if (badgeSlot) badgeSlot.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-bold bg-white/20 text-white';
    }

    try {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url.toString());
    } catch (e) {
        // Fallback for older browsers
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam === 'rekam_medis' || window.location.hash === '#section-rekam-medis') {
        switchScheduleTab('rekam_medis');
    } else if (tabParam === 'slot') {
        switchScheduleTab('slot');
    }
});

function openSlotPatientsModal(scheduleId) {
    const modal = document.getElementById('modal-pasien-slot-' + scheduleId);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeSlotPatientsModal(scheduleId) {
    const modal = document.getElementById('modal-pasien-slot-' + scheduleId);
    if (modal) {
        modal.classList.add('hidden');
    }
}

function openEditSlotModal(scheduleId, date, startTime, endTime, quota, notes = '') {
    const modal = document.getElementById('modal-edit-kuota');
    const form = document.getElementById('form-edit-kuota');
    form.action = '/dokter-hewan/jadwal/' + scheduleId;
    document.getElementById('edit-slot-desc').innerText = 'Tanggal: ' + date;
    document.getElementById('edit-slot-start-time').value = startTime || '08:00';
    document.getElementById('edit-slot-end-time').value = endTime || '09:00';
    document.getElementById('edit-slot-quota').value = quota;
    document.getElementById('edit-slot-notes').value = notes || '';
    modal.classList.remove('hidden');
}

function openEditQuotaModal(scheduleId, date, timeLabel, quota, serviceType = '', notes = '', startTime = '', endTime = '') {
    openEditSlotModal(scheduleId, date, startTime, endTime, quota, notes);
}
</script>
@endsection

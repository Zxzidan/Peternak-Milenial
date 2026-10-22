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

    <!-- Section 1: Daftar Slot Jam & Kuota Layanan Dokter -->
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

            <!-- Filter Tanggal -->
            <form method="GET" action="{{ route('dokter-hewan.jadwal.index') }}" class="flex items-center gap-2">
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
                    <a href="{{ route('dokter-hewan.jadwal.index') }}" class="text-xs text-gray-400 hover:text-gray-600">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
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
                            @if($schedule->booked_count > 0)
                                <button
                                    type="button"
                                    onclick="openSlotPatientsModal({{ $schedule->id }})"
                                    title="Klik untuk melihat pasien pendaftar"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 hover:bg-blue-200 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200 dark:hover:bg-blue-800 transition-all cursor-pointer shadow-2xs"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                    <span>{{ $schedule->booked_count }} Pasien</span>
                                </button>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                    0
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
                        <td class="px-4 py-3 whitespace-nowrap text-center space-x-1">
                            <button
                                type="button"
                                onclick="openSlotPatientsModal({{ $schedule->id }})"
                                class="px-2.5 py-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-lg border border-emerald-200 dark:border-emerald-800 transition-colors inline-flex items-center gap-1 cursor-pointer"
                                title="Lihat daftar pasien yang mendaftar pada slot jam ini"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                <span>Pasien ({{ $schedule->booked_count }})</span>
                            </button>

                            <button
                                type="button"
                                onclick="openEditQuotaModal({{ $schedule->id }}, '{{ $schedule->date }}', '{{ $schedule->time_slot_label }}', {{ $schedule->quota }}, '{{ $schedule->service_type }}', '{{ addslashes($schedule->notes ?? '') }}')"
                                class="px-2.5 py-1 text-[11px] font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 rounded-lg border border-primary-200 transition-colors cursor-pointer"
                            >
                                Edit Kuota
                            </button>

                            <form action="{{ route('dokter-hewan.jadwal.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Hapus slot jam konsultasi ini? Pendaftaran yang sudah masuk juga akan dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="px-2.5 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg border border-rose-200 transition-colors cursor-pointer"
                                >
                                    Hapus
                                </button>
                            </form>
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

    <!-- Modals Daftar Pasien Terdaftar Per Slot Jadwal -->
    @foreach($schedules as $schedule)
    <div id="modal-pasien-slot-{{ $schedule->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-start justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                <div class="space-y-1">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white leading-snug">
                        Daftar Pasien Peternak Terdaftar
                    </h3>
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 flex-wrap leading-normal">
                        <span>Jadwal: <strong class="text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}</strong> (Pukul <strong>{{ $schedule->time_slot_label }}</strong>)</span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>Kuota: <strong class="text-gray-800 dark:text-gray-200">{{ $schedule->quota }} Pasien</strong></span>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <span>Terisi: <strong class="text-gray-800 dark:text-gray-200">{{ $schedule->booked_count }} Pasien</strong></span>
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

            <!-- Modal Body (Scrollable) -->
            <div class="overflow-y-auto py-4 space-y-3.5 flex-1 pr-1">
                @if($schedule->consultations->isEmpty())
                    <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada pasien yang mendaftar</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            Slot jam layanan ini masih memiliki sisa kuota {{ $schedule->remaining_quota }} pasien. Pendaftaran peternak akan langsung tercatat di sini.
                        </p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($schedule->consultations as $booking)
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
                                $livestockInfo = $booking->livestock ? ($booking->livestock->name . ' - ' . $booking->livestock->type) : 'Hewan Ternak';
                                $waMessage = urlencode("Halo Bapak/Ibu {$peternakName}, saya {$vetName} dari Dinas Peternakan Jawa Timur. Saya menghubungi Anda untuk sesi konsultasi online terkait {$livestockInfo} dengan keluhan: " . ($booking->subject ?? 'Pemeriksaan Kesehatan') . ". Apakah Anda saat ini siap berkonsultasi?");
                            @endphp
                            <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-750 hover:border-primary-300 dark:hover:border-primary-600 transition-all">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Info Pasien & Ternak -->
                                    <div class="space-y-2 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-mono text-xs font-bold px-2 py-0.5 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                {{ $booking->booking_code ?? ('#CONS-' . $booking->id) }}
                                            </span>

                                            <!-- Badge Metode Online / Offline -->
                                            @if($isOnline)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    <span>Konsultasi Online</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300 border border-purple-300 dark:border-purple-800">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                    <span>Konsultasi Offline (Puskeswan)</span>
                                                </span>
                                            @endif

                                            <!-- Badge Status -->
                                            @if($booking->status === 'menunggu_konfirmasi')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-amber-800 bg-amber-100 dark:bg-amber-950/70 dark:text-amber-300 rounded">Menunggu Konfirmasi</span>
                                            @elseif($booking->status === 'dikonfirmasi')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-blue-800 bg-blue-100 dark:bg-blue-950/70 dark:text-blue-300 rounded">Dikonfirmasi</span>
                                            @elseif($booking->status === 'selesai')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-emerald-100 dark:bg-emerald-950/70 dark:text-emerald-300 rounded">Selesai</span>
                                            @elseif($booking->status === 'dibatalkan')
                                                <span class="px-2 py-0.5 text-[10px] font-bold text-rose-800 bg-rose-100 dark:bg-rose-950/70 dark:text-rose-300 rounded">Dibatalkan</span>
                                            @endif
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs">
                                            <div>
                                                <span class="text-gray-400 block text-[11px]">Nama Peternak:</span>
                                                <strong class="text-gray-900 dark:text-white text-[13px]">{{ $booking->user?->name ?? 'Peternak' }}</strong>
                                                <span class="text-gray-500 block text-[11px]">{{ $booking->user?->peternakProfile?->farm_name ?? ($booking->user?->alamat ?? 'Peternakan Rakyat') }}</span>
                                                <span class="text-gray-600 dark:text-gray-300 block text-[11px] font-mono mt-0.5">📞 {{ $userPhone ?: 'Tidak ada no. telp' }}</span>
                                            </div>

                                            <div>
                                                <span class="text-gray-400 block text-[11px]">Hewan Ternak:</span>
                                                @if($booking->livestock)
                                                    <strong class="text-gray-900 dark:text-white text-[13px]">{{ $booking->livestock->name }}</strong>
                                                    <span class="text-gray-500 block text-[11px] font-mono">{{ $booking->livestock->tag_number }} ({{ $booking->livestock->type }})</span>
                                                @else
                                                    <span class="text-gray-500 italic">Umum / Tidak Ditautkan</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="pt-2 border-t border-gray-100 dark:border-gray-700/60 text-xs">
                                            <span class="text-gray-400 block text-[11px] font-semibold">Topik & Keluhan:</span>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $booking->subject }}</p>
                                            @if($booking->complaint_details)
                                                <p class="text-gray-600 dark:text-gray-300 mt-0.5 leading-relaxed">{{ $booking->complaint_details }}</p>
                                            @endif
                                        </div>

                                        @if($booking->doctor_notes)
                                            <div class="mt-2 p-2.5 bg-emerald-50 dark:bg-emerald-950/40 rounded-lg text-xs text-emerald-900 dark:text-emerald-200 border border-emerald-200/60">
                                                <strong>Catatan Dokter:</strong> {{ $booking->doctor_notes }}
                                                @if($booking->prescription)
                                                    <br><strong>Resep Obat:</strong> {{ $booking->prescription }}
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Kolom Aksi Dokter & Tombol WA -->
                                    <div class="flex flex-col md:items-end gap-2.5 shrink-0 pt-2 md:pt-0">
                                        @if($isOnline)
                                            @if($cleanPhone)
                                                <a
                                                    href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs hover:shadow transition-all hover:scale-[1.02] cursor-pointer"
                                                    title="Mulai sesi konsultasi online melalui WhatsApp peternak"
                                                >
                                                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" /></svg>
                                                    <span>Arahkan ke WhatsApp</span>
                                                </a>
                                            @else
                                                <span class="text-[11px] text-amber-600 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-lg border border-amber-200">
                                                    No. WA belum tersedia
                                                </span>
                                            @endif
                                        @endif

                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($booking->status === 'menunggu_konfirmasi')
                                                <form action="{{ route('dokter-hewan.jadwal.booking.status', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="dikonfirmasi">
                                                    <button
                                                        type="submit"
                                                        class="px-2.5 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-2xs transition-colors cursor-pointer"
                                                    >
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($booking->status, ['menunggu_konfirmasi', 'dikonfirmasi']))
                                                <button
                                                    type="button"
                                                    onclick="closeSlotPatientsModal({{ $schedule->id }}); openCompleteConsultationModal({{ $booking->id }}, '{{ $booking->booking_code }}', '{{ addslashes($booking->user?->name ?? 'Peternak') }}', '{{ addslashes($booking->subject) }}', '{{ addslashes($booking->doctor_notes ?? '') }}', '{{ addslashes($booking->prescription ?? '') }}')"
                                                    class="px-2.5 py-1.5 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg shadow-2xs transition-colors cursor-pointer"
                                                >
                                                    Selesai & Catat
                                                </button>

                                                <form action="{{ route('dokter-hewan.jadwal.booking.status', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan jadwal konsultasi peternak ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="dibatalkan">
                                                    <button
                                                        type="submit"
                                                        class="px-2 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg border border-rose-200 transition-colors cursor-pointer"
                                                    >
                                                        Batal
                                                    </button>
                                                </form>
                                            @elseif($booking->status === 'selesai')
                                                <button
                                                    type="button"
                                                    onclick="closeSlotPatientsModal({{ $schedule->id }}); openCompleteConsultationModal({{ $booking->id }}, '{{ $booking->booking_code }}', '{{ addslashes($booking->user?->name ?? 'Peternak') }}', '{{ addslashes($booking->subject) }}', '{{ addslashes($booking->doctor_notes ?? '') }}', '{{ addslashes($booking->prescription ?? '') }}')"
                                                    class="px-2.5 py-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 rounded-lg border border-primary-200 transition-colors cursor-pointer"
                                                >
                                                    Edit Diagnosis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

            <div class="grid grid-cols-2 gap-3">
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
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tipe Layanan</label>
                    <select
                        name="service_type"
                        class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                    >
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
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

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tipe Layanan</label>
                <select
                    name="service_type"
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
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

<!-- MODAL 3: Edit Kuota Slot -->
<div id="modal-edit-kuota" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative">
        <button type="button" onclick="document.getElementById('modal-edit-kuota').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
            &times;
        </button>

        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span>Ubah Kuota Slot Layanan</span>
        </h3>
        <p id="edit-slot-desc" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Slot: 08:00 - 09:00 WIB
        </p>

        <form id="form-edit-kuota" action="" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jumlah Kuota Maksimal</label>
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
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tipe Layanan</label>
                <select
                    id="edit-slot-service-type"
                    name="service_type"
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                >
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
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
                    class="px-3.5 py-2 text-xs font-medium text-gray-600 hover:text-gray-800"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl shadow-sm transition-colors"
                >
                    Perbarui Kuota
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 4: Selesaikan Konsultasi & Catat Diagnosis / Resep -->
<div id="modal-selesaikan-konsultasi" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative">
        <button type="button" onclick="document.getElementById('modal-selesaikan-konsultasi').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
            &times;
        </button>

        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Rekam Medis & Diagnosis Konsultasi</span>
        </h3>
        <p id="selesai-patient-info" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Pasien Peternak
        </p>

        <form id="form-selesaikan-konsultasi" action="" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="selesai">

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan Pemeriksaan & Diagnosis Dokter</label>
                <textarea
                    id="selesai-doctor-notes"
                    name="doctor_notes"
                    rows="3"
                    placeholder="Tuliskan hasil evaluasi klinis hewan ternak..."
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                ></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Resep Obat / Instruksi Tindakan</label>
                <textarea
                    id="selesai-prescription"
                    name="prescription"
                    rows="2"
                    placeholder="Contoh: Beri Aftovaxpur 2ml IM + antipiretik bila demam..."
                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white"
                ></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button
                    type="button"
                    onclick="document.getElementById('modal-selesaikan-konsultasi').classList.add('hidden')"
                    class="px-3.5 py-2 text-xs font-medium text-gray-600 hover:text-gray-800"
                >
                    Tutup
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm transition-colors"
                >
                    Simpan Hasil Konsultasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

function openEditQuotaModal(scheduleId, date, timeLabel, quota, serviceType, notes) {
    const modal = document.getElementById('modal-edit-kuota');
    const form = document.getElementById('form-edit-kuota');
    form.action = '/dokter-hewan/jadwal/' + scheduleId;
    document.getElementById('edit-slot-desc').innerText = 'Tanggal: ' + date + ' | Jam: ' + timeLabel;
    document.getElementById('edit-slot-quota').value = quota;
    document.getElementById('edit-slot-service-type').value = (serviceType === 'tatap_muka' || serviceType === 'offline' || serviceType === 'kunjungan') ? 'offline' : 'online';
    document.getElementById('edit-slot-notes').value = notes || '';
    modal.classList.remove('hidden');
}

function openCompleteConsultationModal(consultationId, bookingCode, peternakName, subject, notes, prescription) {
    const modal = document.getElementById('modal-selesaikan-konsultasi');
    const form = document.getElementById('form-selesaikan-konsultasi');
    form.action = '/dokter-hewan/jadwal/bookings/' + consultationId + '/status';
    document.getElementById('selesai-patient-info').innerText = (bookingCode || '#CONS-' + consultationId) + ' — ' + peternakName + ' (' + subject + ')';
    document.getElementById('selesai-doctor-notes').value = notes || '';
    document.getElementById('selesai-prescription').value = prescription || '';
    modal.classList.remove('hidden');
}
</script>
@endsection

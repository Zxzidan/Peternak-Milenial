@extends('layouts.app')

@section('title', 'Kesehatan Hewan & Konsultasi — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = $activeTab ?? request('tab', 'dokter');
    if (!in_array($activeTab, ['dokter', 'rekam_medis', 'penyakit', 'balasan_dokter'])) {
        $activeTab = 'dokter';
    }
@endphp

<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <!-- Top Row: Department Info, Title, Subtitle & Action Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                    @if(auth()->check() && auth()->user()->isAdmin())
                        Daftar Dokter Hewan Dinas
                    @elseif($activeTab === 'dokter')
                        Konsultasi Dokter Hewan
                    @elseif($activeTab === 'rekam_medis')
                        Rekam Medis &amp; Riwayat Kesehatan Hewan
                    @elseif($activeTab === 'balasan_dokter')
                        Balasan &amp; Rekomendasi Dokter Hewan
                    @elseif($activeTab === 'penyakit')
                        Pedoman Penyakit Hewan
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
                    @if(auth()->check() && auth()->user()->isAdmin())
                        Manajemen dan direktori resmi dokter hewan Puskeswan Dinas Peternakan Jawa Timur untuk penugasan dan pelayanan peternak.
                    @elseif($activeTab === 'dokter')
                        Layanan telemedisin veteriner langsung bersama dokter hewan resmi Dinas Peternakan Jawa Timur.
                    @elseif($activeTab === 'rekam_medis')
                        Tabel riwayat laporan kesehatan hewan dan hasil balasan dari dokter hewan dinas.
                    @elseif($activeTab === 'balasan_dokter')
                        Daftar lengkap analisis klinis, rekomendasi tindakan medis, resep obat, instruksi pemantauan, dan agenda kunjungan dari Dokter Hewan Dinas untuk ternak Anda.
                    @elseif($activeTab === 'penyakit')
                        Basis data pengenalan gejala klinis dan pedoman penanganan dini penyakit hewan menular.
                    @endif
                </p>
            </div>

            <!-- Action Buttons for Active Tab -->
            <div class="flex items-center gap-2 shrink-0 self-start md:self-center">
                @if($activeTab === 'dokter')
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('modal-tambah-dokter').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Tambah Dokter Hewan</span>
                    </button>
                    @endif
                @elseif($activeTab === 'rekam_medis')
                    {{-- Sederhana dan ringkas: tanpa tombol/elemen berlebihan --}}
                @elseif($activeTab === 'balasan_dokter')
                    <a
                        href="{{ route('kesehatan-hewan.create') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Buat Laporan Baru</span>
                    </a>
                    <a
                        href="{{ url('/konsultasi?tab=dokter') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                        <span>Konsultasi Online</span>
                    </a>
                @elseif($activeTab === 'penyakit')
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('form-tambah-penyakit').classList.toggle('hidden')"
                        class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                    >
                        + Tambah Data Penyakit
                    </button>
                    @endif
                @endif
            </div>
        </div>

        <!-- Horizontal Tab Navigation Bar -->
        <div class="flex items-center gap-2 border-t border-gray-100 dark:border-gray-800 pt-3.5 overflow-x-auto text-xs">
            <a
                href="{{ url('/konsultasi?tab=dokter') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $activeTab === 'dokter' ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                <span>Dokter Hewan &amp; Konsultasi</span>
            </a>

            <a
                href="{{ url('/konsultasi?tab=rekam_medis') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $activeTab === 'rekam_medis' ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                <span>Rekam Medis</span>
            </a>

            @if(!auth()->check() || auth()->user()->isPeternak())
            <a
                href="{{ url('/konsultasi?tab=balasan_dokter') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $activeTab === 'balasan_dokter' ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518z"/></svg>
                <span>Balasan Dokter</span>
                @if(isset($doctorResponseCount) && $doctorResponseCount > 0)
                <span class="px-1.5 py-0.2 text-[10px] font-bold rounded-full {{ $activeTab === 'balasan_dokter' ? 'bg-white text-primary-700' : 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200' }}">
                    {{ $doctorResponseCount }}
                </span>
                @endif
            </a>
            @endif

            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDokterHewan()))
            <a
                href="{{ url('/konsultasi?tab=penyakit') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $activeTab === 'penyakit' ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                <span>Pedoman Penyakit</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Alert / Flash Message -->
    @if(session('success'))
    <div class="p-3 text-xs text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 dark:hover:text-white">✕</button>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 1: KONSULTASI / DAFTAR DOKTER HEWAN                  --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'dokter')
    <!-- Direktori Dokter Hewan Jaga Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span>Dokter Hewan Jaga &amp; Telemedisin</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                    {{ $veterinarians->count() }} Terdaftar
                </span>
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Manajemen direktori resmi dokter hewan Puskeswan Dinas Peternakan Jawa Timur yang bertugas melayani peternak milenial.
                @else
                    Konsultasikan keluhan kesehatan ternak Anda langsung kepada dokter hewan resmi Dinas Peternakan Jawa Timur.
                @endif
            </p>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
        <button
            type="button"
            onclick="document.getElementById('modal-tambah-dokter').classList.remove('hidden')"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs self-start sm:self-auto shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>Tambah Dokter Hewan</span>
        </button>
        @endif
    </div>

    <!-- Kotak-Kotak Dokter Hewan (Grid of Veterinarian Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @forelse($veterinarians as $vet)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group relative">
            <div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="relative shrink-0">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-sm flex items-center justify-center shadow-xs">
                                {{ $vet->initials }}
                            </div>
                            @if($vet->status === 'online')
                                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-white dark:border-gray-800 animate-pulse" title="Online"></span>
                            @elseif($vet->status === 'praktik_lapangan')
                                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-amber-500 border-2 border-white dark:border-gray-800" title="Praktik Lapangan"></span>
                            @elseif($vet->status === 'siaga')
                                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-blue-500 border-2 border-white dark:border-gray-800" title="Siaga Panggilan"></span>
                            @else
                                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-gray-400 border-2 border-white dark:border-gray-800" title="Sedang Istirahat"></span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white truncate">
                                {{ $vet->name }}
                            </h3>
                            <span class="inline-block text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/50 px-2 py-0.5 rounded mt-0.5 truncate max-w-full">
                                {{ $vet->specialization }}
                            </span>
                        </div>
                    </div>

                    <div class="shrink-0">
                        @if($vet->status === 'online')
                            <span class="inline-flex items-center gap-1.5 text-[10px] sm:text-[11px] font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Online
                            </span>
                        @elseif($vet->status === 'praktik_lapangan')
                            <span class="inline-flex items-center gap-1.5 text-[10px] sm:text-[11px] font-semibold text-amber-700 bg-amber-50 dark:bg-amber-950/60 dark:text-amber-300 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Praktik
                            </span>
                        @elseif($vet->status === 'siaga')
                            <span class="inline-flex items-center gap-1.5 text-[10px] sm:text-[11px] font-semibold text-blue-700 bg-blue-50 dark:bg-blue-950/60 dark:text-blue-300 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Siaga
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-[10px] sm:text-[11px] font-semibold text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Istirahat
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 space-y-2 text-xs text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700/60 pt-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span class="truncate font-medium text-gray-700 dark:text-gray-200">{{ $vet->puskeswan }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-gray-500 dark:text-gray-400">{{ $vet->consultation_hours ?? '08.00 - 16.00 WIB' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-700/60">
                @if(auth()->check() && auth()->user()->isAdmin())
                <!-- Action Khusus Admin: Edit & Hapus (Tanpa Tombol WhatsApp / Konsultasi) -->
                <div class="flex items-center justify-end gap-2">
                    <button
                        type="button"
                        onclick="openEditVetModal({{ json_encode($vet) }})"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-700 dark:hover:text-primary-400 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600 transition shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        <span>Edit</span>
                    </button>
                    <form
                        action="{{ route('konsultasi.veterinarians.destroy', $vet) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $vet->name }} dari daftar dokter hewan?')"
                        class="inline"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/50 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800/60 transition shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
                @else
                <!-- Action Peternak: WhatsApp & Konsultasi Telemedisin Langsung -->
                <div class="flex items-center gap-2">
                    @php
                        $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $vet->phone_number));
                        $waMsg = urlencode("Halo {$vet->name}, saya peternak milenial Jawa Timur ingin berkonsultasi mengenai kesehatan ternak.");
                    @endphp
                    <a
                        href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800/60 py-2 px-3 rounded-lg transition shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>WhatsApp</span>
                    </a>
                    <button
                        type="button"
                        onclick="openBookingScheduleModal({{ $vet->id }}, '{{ addslashes($vet->name) }}', '{{ addslashes($vet->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 py-2 px-3 rounded-lg transition shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>Atur Jadwal</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-6">
            <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada data dokter hewan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                Admin dapat menambahkan dokter hewan bertugas untuk melayani peternak melalui tombol tambah di atas.
            </p>
        </div>
        @endforelse
    </div>

    @if(!auth()->check() || !auth()->user()->isAdmin())
    <!-- Jadwal Janji Temu Konsultasi Medis Saya (Khusus Peternak) -->
    <div id="sesi-konsultasi" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2 mb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-primary-800 bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 rounded">
                        Janji Temu Medis
                    </span>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                        Jadwal Konsultasi Dokter Hewan Saya
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Daftar reservasi sesi konsultasi kesehatan hewan Anda bersama dokter hewan Puskeswan dengan sistem kuota terkelola.
                </p>
            </div>

            @if(count($veterinarians) > 0)
            <button
                type="button"
                onclick="openBookingScheduleModal({{ $veterinarians->first()->id }}, '{{ addslashes($veterinarians->first()->name) }}', '{{ addslashes($veterinarians->first()->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-2xs transition"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>+ Atur Jadwal Baru</span>
            </button>
            @endif
        </div>

        @if(isset($myBookings) && $myBookings->count() > 0)
        <div class="space-y-3">
            @foreach($myBookings as $booking)
            <div class="p-3.5 sm:p-4 rounded-xl border border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-750/30 flex flex-col md:flex-row md:items-center justify-between gap-3.5">
                <div class="flex-1 space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-mono text-xs font-bold text-primary-700 dark:text-primary-300">
                            {{ $booking->booking_code ?? ('#CONS-' . $booking->id) }}
                        </span>
                        <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($booking->consultation_date ?? $booking->created_at)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="text-xs px-2 py-0.5 rounded-md bg-gray-200/80 dark:bg-gray-700 font-semibold text-gray-700 dark:text-gray-300">
                            {{ $booking->consultation_time ?? ($booking->schedule?->time_slot_label ?? 'Waktu Belum Diatur') }}
                        </span>

                        @if($booking->status === 'menunggu_konfirmasi')
                            <span class="px-2 py-0.5 text-[10px] font-bold text-amber-800 bg-amber-100 dark:bg-amber-950/70 dark:text-amber-300 rounded-full">
                                Menunggu Konfirmasi Dokter
                            </span>
                        @elseif($booking->status === 'dikonfirmasi')
                            <span class="px-2 py-0.5 text-[10px] font-bold text-blue-800 bg-blue-100 dark:bg-blue-950/70 dark:text-blue-300 rounded-full">
                                Jadwal Dikonfirmasi
                            </span>
                        @elseif($booking->status === 'selesai')
                            <span class="px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-emerald-100 dark:bg-emerald-950/70 dark:text-emerald-300 rounded-full">
                                Selesai Ditangani
                            </span>
                        @elseif($booking->status === 'dibatalkan')
                            <span class="px-2 py-0.5 text-[10px] font-bold text-rose-800 bg-rose-100 dark:bg-rose-950/70 dark:text-rose-300 rounded-full">
                                Dibatalkan
                            </span>
                        @endif
                    </div>

                    <div class="text-xs text-gray-700 dark:text-gray-300 flex flex-wrap items-center gap-x-3 gap-y-1">
                        <div>
                            <span class="text-gray-500">Dokter:</span>
                            <strong class="text-gray-900 dark:text-white">{{ $booking->veterinarian?->name ?? 'Dokter Hewan Dinas' }}</strong>
                            <span class="text-[11px] text-gray-500">({{ $booking->veterinarian?->puskeswan ?? 'Puskeswan Dinas' }})</span>
                        </div>
                        @if($booking->livestock)
                        <div>
                            <span class="text-gray-500">Ternak:</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $booking->livestock->name }}</span>
                            <span class="text-[10px] font-mono text-primary-600 bg-primary-50 dark:bg-primary-950 px-1.5 py-0.5 rounded">{{ $booking->livestock->tag_number }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        <span class="font-medium text-gray-900 dark:text-gray-100">Keluhan:</span> {{ $booking->subject }}
                        @if($booking->complaint_details)
                            <span class="text-gray-500 italic block mt-0.5">&ldquo;{{ $booking->complaint_details }}&rdquo;</span>
                        @endif
                    </div>

                    @if($booking->doctor_notes || $booking->prescription)
                    <div class="mt-2 p-2.5 rounded-lg bg-emerald-50/80 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 text-xs text-emerald-900 dark:text-emerald-200 space-y-1">
                        @if($booking->doctor_notes)
                            <div><strong>Hasil Pemeriksaan / Diagnosis:</strong> {{ $booking->doctor_notes }}</div>
                        @endif
                        @if($booking->prescription)
                            <div><strong>Resep / Anjuran Pengobatan:</strong> {{ $booking->prescription }}</div>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if(in_array($booking->status, ['menunggu_konfirmasi', 'dikonfirmasi']))
                    <form action="{{ route('konsultasi.cancel', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal konsultasi ini? Kuota dokter akan dikembalikan.')">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="px-3 py-1.5 text-xs font-semibold text-rose-700 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 border border-rose-200 dark:border-rose-800 rounded-lg transition"
                        >
                            Batalkan Jadwal
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State: Belum Ada Janji Temu -->
        <div class="py-8 px-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 flex items-center justify-center text-primary-700 dark:text-primary-300 mb-3 shadow-2xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada sesi konsultasi aktif</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto mb-3">
                Sebelum berkonsultasi dengan dokter hewan, peternak wajib mengatur jadwal terlebih dahulu dan memilih slot jam dengan kuota layanan yang masih tersedia.
            </p>
            @if(count($veterinarians) > 0)
            <button
                type="button"
                onclick="openBookingScheduleModal({{ $veterinarians->first()->id }}, '{{ addslashes($veterinarians->first()->name) }}', '{{ addslashes($veterinarians->first()->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-sm transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Atur Jadwal Konsultasi Sekarang</span>
            </button>
            @endif
        </div>
        @endif
    </div>
    @endif

    <!-- Ringkasan Rekam Medis Terkini (Khusus Peternak) -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Rekam Medis Terkini Ternak</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan pemeriksaan dan tindakan medis terbaru kawanan ternak.</p>
            </div>
            <a href="{{ url('/konsultasi?tab=rekam_medis') }}" class="text-xs font-semibold text-primary-700 hover:text-primary-800 dark:text-primary-400 flex items-center gap-1">
                <span>Lihat Semua</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="space-y-3">
            @forelse ($healthRecords->take(3) as $record)
            <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-bold text-primary-700 bg-blue-50 px-2 py-0.5 rounded">
                            E-Tag: {{ $record->livestock?->tag_number ?? $record->livestock?->e_tag_number ?? 'JTM-001' }} ({{ $record->livestock?->breed ?? $record->livestock?->name ?? 'Ternak' }})
                        </span>
                        <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded capitalize">
                            {{ str_replace('_', ' ', $record->record_type) }}
                        </span>
                        <span class="text-gray-400 text-[11px]">{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $record->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-0.5">
                        <strong>Tindakan:</strong> {{ $record->treatment ?? 'Pemberian vitamin dan pemantauan' }} &bull;
                        <strong>Pemeriksa:</strong> {{ $record->veterinarian?->name ?? 'Dokter Hewan Dinas' }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                Belum ada data rekam medis kesehatan ternak tersimpan di database.
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- ======================================================== --}}
    {{-- TAB 2: REKAM MEDIS / RIWAYAT KESEHATAN HEWAN             --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'rekam_medis')
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-750 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 font-bold tracking-wider w-1/4 min-w-[160px]">
                            Tanggal Pelaporan
                        </th>
                        <th scope="col" class="px-5 py-3.5 font-bold tracking-wider w-1/3 min-w-[220px]">
                            Gejala
                        </th>
                        <th scope="col" class="px-5 py-3.5 font-bold tracking-wider w-5/12 min-w-[260px]">
                            Hasil Balasan Dokter
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($healthReports as $report)
                    @php
                        $doctorResponses = $report->responses->filter(fn($resp) => $resp->isFromDoctor());
                        $hasVisitResult = $report->latestVisit && ($report->latestVisit->examination_notes || $report->latestVisit->post_visit_recommendations);
                    @endphp
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                        <td class="px-5 py-4 align-top whitespace-nowrap text-gray-900 dark:text-white font-medium">
                            <span class="block text-xs sm:text-sm font-semibold">
                                {{ $report->created_at->translatedFormat('d F Y') }}
                            </span>
                            <span class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5 block">
                                {{ $report->created_at->format('H:i') }} WIB
                            </span>
                        </td>
                        <td class="px-5 py-4 align-top">
                            <p class="text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line">
                                {{ $report->symptoms }}
                            </p>
                        </td>
                        <td class="px-5 py-4 align-top">
                            @if($doctorResponses->isNotEmpty() || $hasVisitResult)
                                <div class="space-y-3">
                                    @foreach($doctorResponses as $response)
                                        <div class="space-y-1.5 {{ !$loop->first ? 'pt-3 border-t border-gray-100 dark:border-gray-700/60' : '' }}">
                                            <p class="text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line">
                                                {{ $response->message }}
                                            </p>
                                            @if($response->recommendations)
                                                <div class="mt-1.5 text-xs text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-2.5">
                                                    <span class="font-bold block mb-0.5">Solusi &amp; Rekomendasi:</span>
                                                    <span class="whitespace-pre-line leading-relaxed">{{ $response->recommendations }}</span>
                                                </div>
                                            @endif
                                            @if($response->follow_up_instructions)
                                                <div class="mt-1.5 text-xs text-blue-800 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 rounded-lg p-2.5">
                                                    <span class="font-bold block mb-0.5">Instruksi Lanjutan:</span>
                                                    <span class="whitespace-pre-line leading-relaxed">{{ $response->follow_up_instructions }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($hasVisitResult && $doctorResponses->isEmpty())
                                        <div class="space-y-1.5">
                                            @if($report->latestVisit->examination_notes)
                                                <p class="text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line">{{ $report->latestVisit->examination_notes }}</p>
                                            @endif
                                            @if($report->latestVisit->post_visit_recommendations)
                                                <div class="mt-1.5 text-xs text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-2.5">
                                                    <span class="font-bold block mb-0.5">Solusi &amp; Rekomendasi:</span>
                                                    <span class="whitespace-pre-line leading-relaxed">{{ $report->latestVisit->post_visit_recommendations }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum ada balasan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="max-w-sm mx-auto space-y-2">
                                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum Ada Riwayat Laporan</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Riwayat laporan kesehatan hewan yang Anda ajukan akan ditampilkan di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 3: PEDOMAN PENYAKIT HEWAN MENULAR                     --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'penyakit')
    <!-- Executive KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- KPI 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Katalog Penyakit Terdata</span>
                <span class="p-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    {{ $diseases->count() }} Penyakit
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Pedoman Standar Veteriner Jatim
            </p>
        </div>

        <!-- KPI 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Prioritas Kewaspadaan</span>
                <span class="p-1 rounded-md bg-red-50 dark:bg-red-950/60 text-red-700 dark:text-red-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    PMK &amp; LSD
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Penyakit Hewan Menular Strategis
            </p>
        </div>

        <!-- KPI 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Posko Siaga Darurat</span>
                <span class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    Siaga 24 Jam
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Layanan Reaksi Cepat Tanggap
            </p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Form Tambah Penyakit (Admin Only - Collapsible) -->
    <div id="form-tambah-penyakit" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tambah Data Penyakit Hewan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Pedoman diagnosis klinis dan SOP penanganan veteriner.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-tambah-penyakit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('konsultasi.diseases.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penyakit <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Bovine Ephemeral Fever (BEF)" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori / Vektor <span class="text-red-500">*</span></label>
                <input type="text" name="category" required placeholder="Contoh: Penyakit Menular / Vektor Serangga" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-2">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Gejala Klinis <span class="text-red-500">*</span></label>
                <textarea name="symptoms" rows="2" required placeholder="Demam tinggi, tremor otot, kepincangan, air liur berlebih..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Langkah Pencegahan &amp; Biosekuriti</label>
                <textarea name="prevention_steps" rows="2" placeholder="Vaksinasi berkala, pengendalian vektor serangga, sanitasi kandang..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pertolongan Pertama / Pengobatan</label>
                <textarea name="treatment_first_aid" rows="2" placeholder="Isolasi ternak, pemberian antipiretik, vitamin B kompleks..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="md:col-span-2 flex justify-end gap-2 pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2 px-4 rounded-lg shadow-xs transition">
                    Simpan Informasi Penyakit
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Katalog Pedoman Penyakit Hewan Menular -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Pedoman &amp; Basis Data Penyakit Hewan Menular</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pedoman diagnosis dini veteriner Jawa Timur.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                {{ $diseases->count() }} Penyakit
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            @forelse ($diseases as $disease)
            <div class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm">
                            {{ $disease->name }}
                        </h3>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-primary-700 dark:bg-blue-950/60 dark:text-primary-300">
                                {{ $disease->category }}
                            </span>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <form action="{{ route('konsultasi.diseases.destroy', $disease) }}" method="POST" onsubmit="return confirm('Hapus info penyakit {{ $disease->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 p-0.5 transition" title="Hapus Penyakit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2 mt-2.5">
                        <div class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                            <span class="font-bold text-gray-900 dark:text-white block mb-0.5">Gejala Klinis:</span>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $disease->symptoms }}</p>
                        </div>

                        @if($disease->prevention_steps)
                        <div class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                            <span class="font-bold text-gray-900 dark:text-white block mb-0.5">Pencegahan:</span>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $disease->prevention_steps }}</p>
                        </div>
                        @endif

                        @if($disease->treatment_first_aid)
                        <div class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                            <span class="font-bold text-gray-900 dark:text-white block mb-0.5">Pertolongan Pertama:</span>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $disease->treatment_first_aid }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-6 text-gray-400">Belum ada pedoman penyakit tersimpan.</div>
            @endforelse
        </div>
    </div>

    <!-- Banner Pelaporan Kasus Kesehatan Ternak -->
    <div class="p-4 sm:p-5 rounded-xl border border-primary-200 dark:border-primary-900/60 bg-primary-50/70 dark:bg-primary-950/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary-100 dark:bg-primary-900/60 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-bold text-primary-900 dark:text-primary-200">Ternak Mengalami Gejala Sakit atau Penyakit Menular?</h4>
                <p class="text-xs text-primary-700 dark:text-primary-400 mt-0.5 leading-relaxed">
                    Segera lakukan karantina mandiri dan kirim laporan pemeriksaan klinis langsung ke Dokter Hewan Dinas Jawa Timur.
                </p>
            </div>
        </div>
        <a href="{{ route('kesehatan-hewan.create') }}" class="inline-flex items-center justify-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-4 py-2 rounded-lg transition shadow-xs shrink-0">
            Lapor Kesehatan Ternak &rarr;
        </a>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 4: BALASAN & REKOMENDASI DOKTER HEWAN (ROLE PETERNAK) --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'balasan_dokter')
    <div class="space-y-6">

        <!-- Executive KPI / Stat Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-4">
            <!-- KPI 1: Total Balasan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-700 p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Tanggapan Dokter</span>
                    <span class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518z"/></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $doctorResponseCount ?? 0 }}
                    </span>
                    <span class="text-[11px] text-emerald-600 font-medium">Balasan</span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                    Dokter Hewan Puskeswan Jatim
                </p>
            </div>

            <!-- KPI 2: Resep & Arahan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-700 p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Resep &amp; Tindakan Medis</span>
                    <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-bold text-blue-700 dark:text-blue-400">
                        {{ $activePrescriptionsCount ?? 0 }}
                    </span>
                    <span class="text-[11px] text-blue-600 font-medium">Petunjuk</span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                    Instruksi isolasi &amp; terapi obat
                </p>
            </div>

            <!-- KPI 3: Kunjungan Lapangan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-700 p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kunjungan ke Kandang</span>
                    <span class="p-1.5 rounded-lg bg-orange-50 dark:bg-orange-950/60 text-orange-700 dark:text-orange-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25V3.75a1.5 1.5 0 00-1.5-1.5h-9a1.5 1.5 0 00-1.5 1.5v15"/></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-bold text-orange-700 dark:text-orange-400">
                        {{ $activeVisitsCount ?? 0 }}
                    </span>
                    <span class="text-[11px] text-orange-600 font-medium">Agenda</span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                    Inspeksi klinis langsung dokter
                </p>
            </div>

            <!-- KPI 4: Selesai Ditangani -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-700 p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kasus Selesai</span>
                    <span class="p-1.5 rounded-lg bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-bold text-teal-700 dark:text-teal-400">
                        {{ $resolvedReportsCount ?? 0 }}
                    </span>
                    <span class="text-[11px] text-teal-600 font-medium">Tuntas</span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                    Ternak telah pulih / tertangani
                </p>
            </div>
        </div>

        <!-- Banner Info Terpadu -->
        <div class="bg-gradient-to-r from-emerald-900 via-primary-900 to-teal-900 rounded-2xl p-4 sm:p-5 text-white shadow-xs relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/10 text-emerald-300 text-[11px] font-medium backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Pusat Layanan Tanggapan Medis Veteriner</span>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold tracking-tight text-white">
                        Seluruh Hasil Analisis &amp; Arahan Dokter Resmi Terangkum di Sini
                    </h2>
                    <p class="text-xs text-gray-200 max-w-2xl leading-relaxed">
                        Halaman ini menghimpun rekaman resmi balasan, diagnosis klinis, tindakan cepat, resep obat, instruksi pemantauan harian, serta kepastian jadwal inspeksi kandang langsung dari Dokter Hewan Dinas Jawa Timur untuk kawanan ternak Anda.
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a
                        href="{{ route('kesehatan-hewan.create') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-950 bg-white hover:bg-emerald-50 px-3.5 py-2.5 rounded-xl transition shadow-xs cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Lapor Kasus Ternak Sakit</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Tab Pills (Semua, Laporan Medis, Konsultasi Online, Kunjungan) -->
        <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3 text-xs">
            <button
                type="button"
                onclick="filterDoctorResponses('all')"
                id="filter-btn-all"
                class="filter-response-btn active-filter px-3.5 py-1.5 rounded-lg font-semibold bg-primary-700 text-white shadow-2xs transition"
            >
                Semua Tanggapan ({{ ($healthReports ? $healthReports->count() : 0) + ($consultationsWithReplies ? $consultationsWithReplies->count() : 0) }})
            </button>
            <button
                type="button"
                onclick="filterDoctorResponses('laporan')"
                id="filter-btn-laporan"
                class="filter-response-btn px-3.5 py-1.5 rounded-lg font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
            >
                Laporan Medis Ternak ({{ $healthReports ? $healthReports->count() : 0 }})
            </button>
            <button
                type="button"
                onclick="filterDoctorResponses('konsultasi')"
                id="filter-btn-konsultasi"
                class="filter-response-btn px-3.5 py-1.5 rounded-lg font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
            >
                Konsultasi Telemedisin ({{ $consultationsWithReplies ? $consultationsWithReplies->count() : 0 }})
            </button>
            @if(isset($activeVisitsCount) && $activeVisitsCount > 0)
            <button
                type="button"
                onclick="filterDoctorResponses('kunjungan')"
                id="filter-btn-kunjungan"
                class="filter-response-btn px-3.5 py-1.5 rounded-lg font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
            >
                Kunjungan Lapangan ({{ $activeVisitsCount }})
            </button>
            @endif
        </div>

        <!-- Daftar Konten Balasan Dokter -->
        <div class="space-y-5" id="container-balasan-dokter">

            {{-- 1. LOOP DAFTAR TANGGAPAN LAPORAN KESEHATAN HEWAN --}}
            @forelse($healthReports as $report)
            <div class="item-balasan-card card-laporan-medis {{ $report->visits->isNotEmpty() ? 'card-kunjungan-lapangan' : '' }} bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-2xs hover:shadow-md transition-all space-y-4">
                
                <!-- Header Kartu: Nomor Laporan, Urgensi, Status & Tanggal -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-primary-50 text-primary-800 dark:bg-primary-950/70 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800/60">
                            <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span>{{ $report->report_number }}</span>
                        </span>

                        <!-- Badge Urgensi -->
                        @if($report->urgency === 'kritis')
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-800 dark:bg-red-950/70 dark:text-red-300 border border-red-200 flex items-center gap-1 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                <span>Urgensi Kritis</span>
                            </span>
                        @elseif($report->urgency === 'tinggi')
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-orange-100 text-orange-800 dark:bg-orange-950/70 dark:text-orange-300 border border-orange-200">
                                Urgensi Tinggi
                            </span>
                        @elseif($report->urgency === 'sedang')
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/70 dark:text-amber-300 border border-amber-200">
                                Urgensi Sedang
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200">
                                Urgensi Rendah
                            </span>
                        @endif

                        <!-- Badge Status Penanganan -->
                        @if($report->status === 'selesai')
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                ✓ Selesai Ditangani
                            </span>
                        @elseif($report->status === 'sudah_dijawab')
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-950/60 dark:text-indigo-300">
                                Sudah Dijawab Dokter
                            </span>
                        @elseif(in_array($report->status, ['kunjungan_terjadwal', 'menunggu_kunjungan']))
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-orange-100 text-orange-800 dark:bg-orange-950/60 dark:text-orange-300">
                                Kunjungan Lapangan Terjadwal
                            </span>
                        @elseif($report->status === 'sedang_ditangani')
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300">
                                Sedang Ditangani Dokter
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">
                                Menunggu Telaah Dokter
                            </span>
                        @endif
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Dilaporkan: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Info Ternak & Ringkasan Keluhan Gejala Awal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 p-3.5 rounded-xl bg-gray-50/80 dark:bg-gray-750/40 border border-gray-100 dark:border-gray-700/60 text-xs">
                    <div>
                        <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block">Komoditas / Jenis Ternak:</span>
                        <span class="font-bold text-gray-900 dark:text-white mt-0.5 block">
                            {{ $report->livestock_type }}
                            <span class="font-normal text-gray-500">({{ $report->affected_count }} ekor terdampak)</span>
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block">Lokasi Peternakan:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200 mt-0.5 block">
                            {{ $report->farm_name ?? 'Peternakan Anda' }} &bull; {{ $report->kabupaten }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block">Gejala Klinis Dilaporkan:</span>
                        <span class="text-gray-700 dark:text-gray-300 italic mt-0.5 block line-clamp-2" title="{{ $report->symptoms }}">
                            "{{ $report->symptoms }}"
                        </span>
                    </div>
                </div>

                <!-- KOTAK BALASAN RESMI DARI DOKTER HEWAN -->
                @php
                    $doctorResponses = $report->responses->filter(fn($resp) => $resp->isFromDoctor());
                @endphp

                @if($doctorResponses->isNotEmpty())
                <div class="space-y-4 pt-1">
                    @foreach($doctorResponses as $response)
                    <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/90 dark:border-emerald-800/60 space-y-3.5">
                        
                        <!-- Baris Profil Dokter & Waktu Respons -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-emerald-100 dark:border-emerald-800/40">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                    {{ strtoupper(substr($response->user->name ?? 'DH', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <h3 class="font-bold text-sm text-gray-900 dark:text-white">
                                            {{ $response->user->name }}
                                        </h3>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                            Dokter Hewan Dinas
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                                        Puskeswan Dinas Peternakan Provinsi Jawa Timur
                                    </p>
                                </div>
                            </div>
                            <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-medium">
                                Tanggapan Resmi Dikirim: {{ $response->created_at->format('d M Y, H:i') }} WIB
                            </div>
                        </div>

                        <!-- Pesan Ulasan Utama Dokter -->
                        <div class="text-xs sm:text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line">
                            {{ $response->message }}
                        </div>

                        <!-- 1. DUGAAN DIAGNOSIS / ANALISIS AWAL DOKTER -->
                        @if($response->hypothesis)
                        <div class="p-3.5 rounded-xl bg-amber-50/90 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/60 space-y-1">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-amber-900 dark:text-amber-300">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                <span>Analisis Klinis &amp; Dugaan Awal Penyakit:</span>
                            </div>
                            <p class="text-xs text-amber-900 dark:text-amber-200 font-medium pl-5.5 leading-relaxed">
                                {{ $response->hypothesis }}
                            </p>
                            <span class="text-[10px] text-amber-700/80 dark:text-amber-400/80 pl-5.5 block">
                                *Catatan Resmi: Dugaan klinis awal dokter berdasarkan telaah gejala klinis yang Anda laporkan.
                            </span>
                        </div>
                        @endif

                        <!-- 2. REKOMENDASI PENANGANAN CEPAT & RESEP / OBAT -->
                        @if($response->recommendations)
                        <div class="p-3.5 rounded-xl bg-white dark:bg-gray-800 border border-emerald-300 dark:border-emerald-700/80 shadow-2xs space-y-1.5">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-800 dark:text-emerald-300">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Rekomendasi Penanganan &amp; Tindakan yang Wajib Dilakukan Peternak:</span>
                            </div>
                            <div class="text-xs text-gray-800 dark:text-gray-200 pl-5.5 whitespace-pre-line font-medium leading-relaxed">
                                {{ $response->recommendations }}
                            </div>
                        </div>
                        @endif

                        <!-- 3. INSTRUKSI PEMANTAUAN LANJUTAN -->
                        @if($response->follow_up_instructions)
                        <div class="p-3.5 rounded-xl bg-blue-50/80 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/60 space-y-1">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-blue-900 dark:text-blue-300">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span>Instruksi Pemantauan Kondisi Hewan:</span>
                            </div>
                            <p class="text-xs text-blue-800 dark:text-blue-200 pl-5.5 whitespace-pre-line leading-relaxed">
                                {{ $response->follow_up_instructions }}
                            </p>
                        </div>
                        @endif

                    </div>
                    @endforeach
                </div>
                @else
                <!-- Laporan Menunggu Respons Dokter -->
                <div class="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/20 border border-dashed border-amber-300 dark:border-amber-800/60 text-xs flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-amber-900 dark:text-amber-200 block">Laporan Anda Telah Masuk ke Dokter Hewan Jaga</span>
                            <span class="text-amber-700 dark:text-amber-400 text-[11px]">Tim veteriner Puskeswan wilayah sedang menganalisis gejala klinis ternak Anda. Hasil analisis akan muncul di sini.</span>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-amber-800 dark:text-amber-300 px-2 py-1 rounded bg-amber-100 dark:bg-amber-900/60 shrink-0">Antrean Verifikasi</span>
                </div>
                @endif

                <!-- 4. STATUS & AGENDA KUNJUNGAN LAPANGAN (JIKA ADA KUNJUNGAN) -->
                @if($report->latestVisit)
                <div class="p-4 rounded-xl bg-orange-50/70 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-800/60 space-y-2.5 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-orange-200/60 dark:border-orange-800/40 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="p-1 rounded-md bg-orange-100 text-orange-700 dark:bg-orange-900/60 dark:text-orange-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25V3.75a1.5 1.5 0 00-1.5-1.5h-9a1.5 1.5 0 00-1.5 1.5v15"/></svg>
                            </span>
                            <span class="font-bold text-orange-900 dark:text-orange-200">Agenda Kunjungan Lapangan Dokter ke Kandang Anda</span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $report->latestVisit->status === 'terjadwal' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : 'bg-orange-100 text-orange-800' }}">
                            {{ $report->latestVisit->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Jadwal yang Disepakati / Diusulkan:</span>
                            <span class="font-bold text-gray-900 dark:text-white mt-0.5 block">
                                {{ $report->latestVisit->proposed_date ? $report->latestVisit->proposed_date->format('d F Y, H:i') . ' WIB' : 'Menunggu penjadwalan' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 block">Maksud / Alasan Kunjungan:</span>
                            <span class="text-gray-800 dark:text-gray-200 mt-0.5 block">
                                {{ $report->latestVisit->visit_reason ?? 'Pemeriksaan fisik langsung dan injeksi terapi veteriner.' }}
                            </span>
                        </div>
                    </div>

                    @if($report->latestVisit->examination_notes)
                    <div class="mt-2 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 space-y-1">
                        <span class="font-bold text-gray-900 dark:text-white text-[11px] block">Hasil Pemeriksaan Klinis Pasca Kunjungan:</span>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $report->latestVisit->examination_notes }}</p>
                        @if($report->latestVisit->post_visit_recommendations)
                        <span class="font-bold text-emerald-800 dark:text-emerald-400 text-[11px] block mt-2">Rekomendasi Lanjutan:</span>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $report->latestVisit->post_visit_recommendations }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                <!-- Baris Tombol Aksi Bawah -->
                <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700 text-xs">
                    <span class="text-gray-400 text-[11px]">
                        Petugas Penugasan: <strong class="text-gray-700 dark:text-gray-300">{{ $report->assignedVeterinarian?->name ?? 'Dokter Hewan Jaga Puskeswan' }}</strong>
                    </span>
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('kesehatan-hewan.show', $report) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 transition shadow-2xs"
                        >
                            <span>Lihat Detail &amp; Balas Dokter</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
            @empty
            @endforelse

            {{-- 2. LOOP DAFTAR CATATAN RESEP & SARAN DARI SESI KONSULTASI ONLINE --}}
            @if(isset($consultationsWithReplies) && $consultationsWithReplies->isNotEmpty())
            @foreach($consultationsWithReplies as $c)
            <div class="item-balasan-card card-konsultasi-online bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-2xs hover:shadow-md transition-all space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300 border border-blue-200/60">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                            <span>Konsultasi Telemedisin #{{ $c->booking_code ?? 'KNS-'.$c->id }}</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                            {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                        </span>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Jadwal: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $c->consultation_date ?? $c->created_at->format('d M Y') }} &bull; {{ $c->consultation_time ?? '08:00 - 16:00 WIB' }}</span>
                    </div>
                </div>

                <!-- Dokter & Topik -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 text-xs">
                    <div>
                        <span class="text-[11px] font-medium text-gray-500 block">Dokter Hewan Konsultan:</span>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white mt-0.5">
                            {{ $c->veterinarian?->name ?? 'Dokter Hewan Dinas' }}
                        </h4>
                        <span class="text-gray-500 text-[11px]">{{ $c->veterinarian?->puskeswan ?? 'Puskeswan Dinas Peternakan Jatim' }}</span>
                    </div>
                    <div class="sm:max-w-md">
                        <span class="text-[11px] font-medium text-gray-500 block">Subjek / Topik Konsultasi:</span>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 mt-0.5">{{ $c->subject }}</p>
                        @if($c->complaint_details)
                        <p class="text-gray-600 dark:text-gray-400 mt-0.5 italic">"{{ $c->complaint_details }}"</p>
                        @endif
                    </div>
                </div>

                <!-- Catatan & Resep Obat dari Dokter -->
                <div class="space-y-3 pt-1">
                    @if($c->doctor_notes)
                    <div class="p-3.5 rounded-xl bg-amber-50/80 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/60 text-xs space-y-1">
                        <div class="flex items-center gap-1.5 font-bold text-amber-900 dark:text-amber-300">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            <span>Catatan &amp; Diagnosis Dokter Hewan:</span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-200 pl-5.5 leading-relaxed">{{ $c->doctor_notes }}</p>
                    </div>
                    @endif

                    @if($c->prescription)
                    <div class="p-3.5 rounded-xl bg-emerald-50/80 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/60 text-xs space-y-1">
                        <div class="flex items-center gap-1.5 font-bold text-emerald-900 dark:text-emerald-300">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Resep / Rekomendasi Terapi Medis:</span>
                        </div>
                        <p class="text-emerald-950 dark:text-emerald-200 pl-5.5 font-medium leading-relaxed whitespace-pre-line">{{ $c->prescription }}</p>
                    </div>
                    @endif

                    @php
                        $latestDoctorMsg = $c->messages->filter(fn($m) => $m->sender?->isDokterHewan() || $m->sender?->isAdmin())->last();
                    @endphp
                    @if($latestDoctorMsg)
                    <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-700 text-xs space-y-1">
                        <div class="flex items-center justify-between text-[11px] text-gray-500">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Pesan Balasan Terakhir di Chat Konsultasi:</span>
                            <span>{{ $latestDoctorMsg->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-200 italic">"{{ $latestDoctorMsg->message }}"</p>
                    </div>
                    @endif
                </div>

                <div class="flex items-center justify-end pt-3 border-t border-gray-100 dark:border-gray-700">
                    <a
                        href="{{ url('/konsultasi?tab=dokter') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg font-semibold text-xs text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 transition"
                    >
                        <span>Buka Ruang Konsultasi &amp; Chat</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

            </div>
            @endforeach
            @endif

            {{-- 3. EMPTY STATE JIKA BELUM ADA BALASAN DOKTER SAMA SEKALI --}}
            @if((!$healthReports || $healthReports->isEmpty()) && (!isset($consultationsWithReplies) || $consultationsWithReplies->isEmpty()))
            <div class="text-center py-12 px-4 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518z"/>
                    </svg>
                </div>
                <div class="max-w-md mx-auto">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        Belum Ada Balasan Dokter untuk Ternak Anda
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
                        Jika ternak Anda mengalami gejala sakit, penurunan produksi susu, lesu, atau nafsu makan turun, segera buat laporan pemeriksaan agar dokter hewan Puskeswan dapat segera memberikan diagnosis, resep tindakan, atau menjadwalkan kunjungan lapangan.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <a
                        href="{{ route('kesehatan-hewan.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl transition shadow-xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Buat Laporan Kesehatan Baru</span>
                    </a>
                    <a
                        href="{{ url('/konsultasi?tab=dokter') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 rounded-xl transition shadow-2xs"
                    >
                        <span>Atur Jadwal Konsultasi Dokter</span>
                    </a>
                </div>
            </div>
            @endif

        </div>

    </div>

    <script>
        function filterDoctorResponses(category) {
            const allButtons = document.querySelectorAll('.filter-response-btn');
            allButtons.forEach(btn => {
                btn.classList.remove('active-filter', 'bg-primary-700', 'text-white', 'shadow-2xs');
                btn.classList.add('text-gray-600', 'dark:text-gray-400');
            });

            const activeBtn = document.getElementById('filter-btn-' + category);
            if (activeBtn) {
                activeBtn.classList.add('active-filter', 'bg-primary-700', 'text-white', 'shadow-2xs');
                activeBtn.classList.remove('text-gray-600', 'dark:text-gray-400');
            }

            const cards = document.querySelectorAll('.item-balasan-card');
            cards.forEach(card => {
                if (category === 'all') {
                    card.style.display = 'block';
                } else if (category === 'laporan') {
                    card.style.display = card.classList.contains('card-laporan-medis') ? 'block' : 'none';
                } else if (category === 'konsultasi') {
                    card.style.display = card.classList.contains('card-konsultasi-online') ? 'block' : 'none';
                } else if (category === 'kunjungan') {
                    card.style.display = card.classList.contains('card-kunjungan-lapangan') ? 'block' : 'none';
                }
            });
        }
    </script>
    @endif

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Modal Tambah Dokter Hewan (Admin) -->
    <div id="modal-tambah-dokter" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Dokter Hewan Baru</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftarkan dokter hewan resmi untuk pelayanan telemedisin peternak.</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-tambah-dokter').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>

            <form action="{{ route('konsultasi.veterinarians.store') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: drh. Rahmat Hidayat, M.Si" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Spesialisasi / Keahlian <span class="text-red-500">*</span></label>
                        <input type="text" name="specialization" required placeholder="Contoh: Spesialis Ruminansia Besar & Bedah" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Tugas / Puskeswan <span class="text-red-500">*</span></label>
                        <input type="text" name="puskeswan" required placeholder="Contoh: Puskeswan Pandaan, Kab. Pasuruan" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor STRV / SIP</label>
                        <input type="text" name="strv_number" placeholder="Contoh: STRV-35.14.2025.099" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="phone_number" required placeholder="Contoh: 081234567890" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Dinas</label>
                        <input type="email" name="email" placeholder="Contoh: rahmat@disnak.jatimprov.go.id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan Konsultasi</label>
                        <input type="text" name="consultation_hours" value="08.00 - 16.00 WIB" placeholder="Contoh: 08.00 - 16.00 WIB" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="online">Online (Siaga Telemedisin)</option>
                            <option value="praktik_lapangan">Praktik Lapangan</option>
                            <option value="siaga">Siaga Panggilan Darurat</option>
                            <option value="offline">Sedang Istirahat</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" onclick="document.getElementById('modal-tambah-dokter').classList.add('hidden')" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs">
                        + Daftarkan Dokter Hewan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Dokter Hewan (Admin) -->
    <div id="modal-edit-dokter" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Data Dokter Hewan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi tugas atau status ketersediaan dokter hewan.</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-edit-dokter').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>

            <form id="form-edit-vet" method="POST" class="mt-4 space-y-3.5 text-xs">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-vet-name" name="name" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Spesialisasi / Keahlian <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-vet-specialization" name="specialization" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Tugas / Puskeswan <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-vet-puskeswan" name="puskeswan" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor STRV / SIP</label>
                        <input type="text" id="edit-vet-strv" name="strv_number" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-vet-phone" name="phone_number" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Dinas</label>
                        <input type="email" id="edit-vet-email" name="email" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan Konsultasi</label>
                        <input type="text" id="edit-vet-hours" name="consultation_hours" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select id="edit-vet-status" name="status" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="online">Online (Siaga Telemedisin)</option>
                            <option value="praktik_lapangan">Praktik Lapangan</option>
                            <option value="siaga">Siaga Panggilan Darurat</option>
                            <option value="offline">Sedang Istirahat</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" onclick="document.getElementById('modal-edit-dokter').classList.add('hidden')" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditVetModal(vet) {
            document.getElementById('form-edit-vet').action = "{{ url('/konsultasi/veterinarians') }}/" + vet.id;
            document.getElementById('edit-vet-name').value = vet.name || '';
            document.getElementById('edit-vet-specialization').value = vet.specialization || '';
            document.getElementById('edit-vet-puskeswan').value = vet.puskeswan || '';
            document.getElementById('edit-vet-strv').value = vet.strv_number || '';
            document.getElementById('edit-vet-phone').value = vet.phone_number || '';
            document.getElementById('edit-vet-email').value = vet.email || '';
            document.getElementById('edit-vet-hours').value = vet.consultation_hours || '08.00 - 16.00 WIB';
            document.getElementById('edit-vet-status').value = vet.status || 'online';
            document.getElementById('modal-edit-dokter').classList.remove('hidden');
        }
    </script>
    @endif

    <!-- MODAL ATUR JADWAL KONSULTASI MEDIS DOKTER HEWAN (Khusus Peternak) -->
    <div id="modal-atur-jadwal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 max-h-[92vh] overflow-y-auto relative">
            <button type="button" onclick="document.getElementById('modal-atur-jadwal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl font-bold">
                &times;
            </button>

            <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-700">
                <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Atur Jadwal Konsultasi Dokter Hewan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pilih jam konsultasi sesuai kuota layanan dokter yang tersedia.</p>
                </div>
            </div>

            <form action="{{ route('konsultasi.book') }}" method="POST" class="mt-4 space-y-3.5 text-xs">
                @csrf

                <!-- Pilih Dokter Hewan -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Dokter Hewan Bertugas <span class="text-red-500">*</span></label>
                    <select
                        id="booking-vet-select"
                        name="veterinarian_id"
                        required
                        onchange="loadDoctorAvailableSlots()"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white font-medium"
                    >
                        @foreach($veterinarians as $v)
                            <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->puskeswan ?? 'Puskeswan Jatim' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Tanggal Janji Temu -->
                    <div>
                        <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Konsultasi <span class="text-red-500">*</span></label>
                        <input
                            type="date"
                            id="booking-date"
                            name="consultation_date"
                            value="{{ now()->toDateString() }}"
                            min="{{ now()->toDateString() }}"
                            required
                            onchange="loadDoctorAvailableSlots()"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"
                        >
                    </div>

                    <!-- Tipe Layanan -->
                    <div>
                        <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Metode Konsultasi <span class="text-red-500">*</span></label>
                        <select
                            name="consultation_type"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"
                        >
                            <option value="online">Konsultasi Telemedisin (Online)</option>
                            <option value="tatap_muka">Tatap Muka di Puskeswan</option>
                            <option value="kunjungan">Permohonan Kunjungan Kandang</option>
                        </select>
                    </div>
                </div>

                <!-- Slot Jam Layanan & Kuota Dokter -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block font-semibold text-gray-700 dark:text-gray-300">
                            Pilih Jam Konsultasi &amp; Kuota <span class="text-red-500">*</span>
                        </label>
                        <span id="slot-loading-indicator" class="text-[11px] text-primary-600 font-medium hidden">
                            Memeriksa kuota...
                        </span>
                    </div>
                    <select
                        id="booking-schedule-select"
                        name="consultation_schedule_id"
                        required
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white font-semibold"
                    >
                        <option value="">-- Pilih Jam & Kuota Tersedia --</option>
                    </select>
                    <p id="slot-helper-text" class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                        Setiap jam memiliki batas kuota pasien. Jika kuota penuh, silakan pilih jam atau hari lain.
                    </p>
                </div>

                <!-- Pilih Ternak (Opsional) -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Hewan Ternak (E-Tag)</label>
                    <select
                        name="livestock_id"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"
                    >
                        <option value="">Umum / Tidak Ditautkan ke E-Tag Khusus</option>
                        @foreach($livestocks as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->name }} — {{ $animal->tag_number }} ({{ $animal->type }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Keluhan / Topik -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Topik / Masalah Kesehatan Utama <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="subject"
                        required
                        placeholder="Contoh: Sapi perah lesu, suhu tinggi, nafsu makan turun"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"
                    >
                </div>

                <!-- Deskripsi Gejala Klinis -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Rincian Gejala &amp; Kondisi Ternak <span class="text-red-500">*</span></label>
                    <textarea
                        name="complaint_details"
                        rows="3"
                        required
                        placeholder="Jelaskan sejak kapan gejala muncul, suhu tubuh jika diukur, kondisi mata, mulut, feses, dan langkah awal yang sudah diberikan..."
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button
                        type="button"
                        onclick="document.getElementById('modal-atur-jadwal').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-sm"
                    >
                        Kunci Kuota &amp; Jadwalkan Konsultasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openBookingScheduleModal(vetId, vetName, vetPuskeswan) {
        const modal = document.getElementById('modal-atur-jadwal');
        const vetSelect = document.getElementById('booking-vet-select');
        if (vetSelect && vetId) {
            vetSelect.value = vetId;
        }
        modal.classList.remove('hidden');
        loadDoctorAvailableSlots(true);
    }

    function selectBookingDate(newDate) {
        const dateInput = document.getElementById('booking-date');
        if (dateInput) {
            dateInput.value = newDate;
            loadDoctorAvailableSlots(false);
        }
    }

    function loadDoctorAvailableSlots(autoSwitchIfEmpty = false) {
        const vetSelect = document.getElementById('booking-vet-select');
        const dateInput = document.getElementById('booking-date');
        const slotSelect = document.getElementById('booking-schedule-select');
        const loadingIndicator = document.getElementById('slot-loading-indicator');
        const helperText = document.getElementById('slot-helper-text');

        if (!vetSelect || !dateInput || !slotSelect) return;

        const vetId = vetSelect.value;
        const date = dateInput.value;

        if (!vetId || !date) {
            slotSelect.innerHTML = '<option value="">-- Pilih Dokter dan Tanggal terlebih dahulu --</option>';
            return;
        }

        loadingIndicator.classList.remove('hidden');
        slotSelect.disabled = true;

        fetch(`/konsultasi/veterinarians/${vetId}/slots?date=${date}`)
            .then(res => res.json())
            .then(data => {
                loadingIndicator.classList.add('hidden');
                slotSelect.disabled = false;
                slotSelect.innerHTML = '';

                if (!data.slots || data.slots.length === 0) {
                    slotSelect.innerHTML = '<option value="">(Tidak ada slot jam layanan dibuka pada tanggal ini)</option>';

                    if (data.available_dates && data.available_dates.length > 0) {
                        if (autoSwitchIfEmpty && !data.available_dates.includes(date)) {
                            dateInput.value = data.available_dates[0];
                            loadDoctorAvailableSlots(false);
                            return;
                        }

                        let dateButtons = data.available_dates.map(d => {
                            const parts = d.split('-');
                            const formatted = parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : d;
                            return `<button type="button" onclick="selectBookingDate('${d}')" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-primary-700 bg-primary-100 hover:bg-primary-200 dark:bg-primary-950 dark:text-primary-300 rounded-lg border border-primary-300 transition my-0.5">${formatted}</button>`;
                        }).join(' ');

                        helperText.innerHTML = `Dokter belum membuka layanan pada tanggal yang dipilih.<br><span class="font-bold text-gray-700 dark:text-gray-200">Pilih tanggal dokter yang tersedia:</span><div class="mt-1 flex flex-wrap gap-1">${dateButtons}</div>`;
                        helperText.className = 'text-[11px] text-amber-700 dark:text-amber-300 mt-1.5';
                    } else {
                        helperText.innerText = 'Dokter ini belum membuka slot jam layanan. Silakan pilih dokter hewan lain.';
                        helperText.className = 'text-[11px] text-amber-600 font-medium mt-1';
                    }
                    return;
                }

                helperText.innerText = 'Setiap jam memiliki batas kuota pasien. Silakan pilih jam dengan kuota tersedia.';
                helperText.className = 'text-[11px] text-gray-500 dark:text-gray-400 mt-1';

                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.innerText = '-- Pilih Jam Konsultasi Tersedia --';
                slotSelect.appendChild(defaultOpt);

                let availableCount = 0;
                data.slots.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot.id;
                    if (slot.is_full) {
                        opt.disabled = true;
                        opt.innerText = `${slot.time_label} — [KUOTA PENUH (${slot.booked_count}/${slot.quota})]`;
                    } else {
                        availableCount++;
                        opt.innerText = `${slot.time_label} — Tersedia Kuota: ${slot.remaining_quota} Pasien`;
                    }
                    slotSelect.appendChild(opt);
                });

                if (availableCount === 0) {
                    helperText.innerText = 'Semua slot jam layanan pada tanggal ini sudah penuh. Silakan pilih tanggal lain.';
                    helperText.className = 'text-[11px] text-rose-600 font-medium mt-1';
                }
            })
            .catch(err => {
                loadingIndicator.classList.add('hidden');
                slotSelect.disabled = false;
                slotSelect.innerHTML = '<option value="">Gagal memuat jadwal. Coba lagi nanti.</option>';
            });
    }
    </script>
</div>
@endsection

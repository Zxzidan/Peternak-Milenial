@extends('layouts.app')

@section('title', 'Kesehatan Hewan & Konsultasi — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = $activeTab ?? request('tab', 'dokter');
    if (!in_array($activeTab, ['dokter', 'rekam_medis', 'penyakit'])) {
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
                        Rekam Medis &amp; E-Tag Ternak
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
                        Buku riwayat kesehatan digital, pencatatan vaksinasi, dan identifikasi barcode E-Tag ternak.
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
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <button
                        type="button"
                        onclick="document.getElementById('form-rekam-medis').classList.toggle('hidden')"
                        class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                    >
                        + Catat Rekam Medis
                    </button>
                    @endif
                    <button
                        type="button"
                        onclick="document.getElementById('form-etag').classList.toggle('hidden')"
                        class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition shadow-2xs"
                    >
                        + E-Tag Baru
                    </button>
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
    {{-- TAB 2: REKAM MEDIS & E-TAG TERNAK                        --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'rekam_medis')
    <!-- Header Rekam Medis & E-Tag Ternak -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Rekam Medis &amp; E-Tag Ternak</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pencatatan riwayat kesehatan ternak dan identitas barcode e-tag.</p>
        </div>
        <div class="flex items-center gap-2">
            @if(auth()->check() && auth()->user()->isAdmin())
            <button
                type="button"
                onclick="document.getElementById('form-rekam-medis').classList.toggle('hidden'); document.getElementById('form-rekam-medis').scrollIntoView({behavior: 'smooth'})"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3 py-2 rounded-lg transition shadow-xs"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Catat Rekam Medis</span>
            </button>
            @endif
            <button
                type="button"
                onclick="document.getElementById('form-etag').classList.toggle('hidden'); document.getElementById('form-etag').scrollIntoView({behavior: 'smooth'})"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 dark:text-emerald-300 bg-white dark:bg-gray-800 hover:bg-emerald-50 dark:hover:bg-gray-700 border border-emerald-300 dark:border-emerald-800 px-3 py-2 rounded-lg transition shadow-2xs"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Daftarkan E-Tag Ternak</span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Utama Rekam Medis & Ternak -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- KPI 1: Populasi Ternak -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs hover:border-primary-300 dark:hover:border-primary-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Populasi Ternak Ber-ETag</span>
                <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386l5.411-3.18a2.25 2.25 0 00.916-1.542l.564-6.48a2.25 2.25 0 00-.659-1.591L12.5 3.659A2.25 2.25 0 0010.909 3h-1.34z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline gap-2">
                <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $livestocks->count() }} Ekor
                </span>
                <span class="text-[11px] font-medium text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 px-2 py-0.5 rounded-full">
                    Terdata Dinas
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                <span>{{ $livestocks->where('gender', 'betina')->count() }} Betina</span>
                <span>•</span>
                <span>{{ $livestocks->where('gender', 'jantan')->count() }} Jantan</span>
            </p>
        </div>

        <!-- KPI 2: Total Riwayat Tindakan -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs hover:border-emerald-300 dark:hover:border-emerald-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Riwayat Tindakan Medis</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" /></svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline gap-2">
                <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $healthRecords->count() }} Tindakan
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                {{ $healthRecords->where('record_type', 'vaksinasi')->count() }} Vaksinasi • {{ $healthRecords->where('record_type', 'pengobatan')->count() }} Pengobatan • {{ $healthRecords->where('record_type', 'inseminasi_buatan')->count() }} IB
            </p>
        </div>

        <!-- KPI 3: Kondisi Kawanan Ternak -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs hover:border-teal-300 dark:hover:border-teal-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Kondisi Kawanan Ternak</span>
                <span class="p-1.5 rounded-lg bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline gap-2">
                <span class="text-xl sm:text-2xl font-bold text-emerald-700 dark:text-emerald-400">
                    {{ $livestocks->where('health_status', 'sehat')->count() }} Sehat
                </span>
                @if($livestocks->where('health_status', '!=', 'sehat')->count() > 0)
                <span class="text-xs font-semibold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded-full">
                    {{ $livestocks->where('health_status', '!=', 'sehat')->count() }} Dalam Perawatan
                </span>
                @endif
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                {{ $livestocks->where('health_status', '!=', 'sehat')->count() > 0 ? 'Ternak dalam masa pengawasan & pemulihan kandang' : 'Semua ternak terpantau bugar dan sehat' }}
            </p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Form Catat Rekam Medis (Admin / Dokter Dinas Only - Collapsible) -->
    <div id="form-rekam-medis" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>Formulir Catat Rekam Medis</span>
                    <span class="text-[10px] font-semibold bg-primary-100 text-primary-800 dark:bg-primary-950 dark:text-primary-300 px-2 py-0.5 rounded">Petugas Medis Disnak</span>
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Pencatatan riwayat tindakan medis, vaksinasi berkala, atau inseminasi buatan.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-rekam-medis').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-semibold">Tutup ✕</button>
        </div>

        <form action="{{ route('konsultasi.health-record.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Ternak (E-Tag) <span class="text-red-500">*</span></label>
                <select name="livestock_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                    @foreach ($livestocks as $ls)
                        <option value="{{ $ls->id }}">{{ $ls->tag_number ?? $ls->e_tag_number }} — {{ $ls->name ?? $ls->breed }} ({{ ucfirst($ls->gender) }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kategori Tindakan <span class="text-red-500">*</span></label>
                <select name="record_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white font-medium">
                    <option value="vaksinasi">Vaksinasi (PMK, LSD, Anthrax)</option>
                    <option value="pengobatan">Pengobatan &amp; Terapi</option>
                    <option value="inseminasi_buatan">Inseminasi Buatan (IB)</option>
                    <option value="pemeriksaan">Pemeriksaan Rutin</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="date" name="record_date" required value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Tindakan / Diagnosa Utama <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Pemeriksaan Lesu & Demam Pasca Laktasi / PMK Booster 2" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Detail Diagnosis Klinis</label>
                <input type="text" name="diagnosis" placeholder="Contoh: Kelelahan produksi laktasi dan radang ringan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tindakan / Resep Obat &amp; Dosis</label>
                <input type="text" name="treatment" placeholder="Contoh: Antipiretik + Vitamin B kompleks 10ml IM..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Anjuran &amp; Petunjuk untuk Peternak di Kandang</label>
                <input type="text" name="notes" placeholder="Contoh: Berikan pakan hijauan segar & air bersih secukupnya. Pantau suhu badan selama 3 hari." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3 flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('form-rekam-medis').classList.add('hidden')" class="px-3.5 py-2 rounded-lg text-xs text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Simpan ke Rekam Medis Ternak
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Form Registrasi E-Tag Baru (Collapsible) -->
    <div id="form-etag" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>Pendaftaran E-Tag Ternak Baru</span>
                    <span class="text-[10px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 px-2 py-0.5 rounded">Identitas Resmi Dinas</span>
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan kode anting barcode telinga untuk mencatat identitas ternak.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-semibold">Tutup ✕</button>
        </div>

        <form action="{{ route('konsultasi.livestock.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Anting E-Tag <span class="text-red-500">*</span></label>
                <input type="text" name="tag_number" required placeholder="Contoh: JTM-PAS-0045" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white uppercase font-mono font-bold">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Jenis Ternak <span class="text-red-500">*</span></label>
                <select name="livestock_type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                    <option value="sapi_perah">Sapi Perah (FH)</option>
                    <option value="sapi_potong">Sapi Potong (Limousin/Simental/PO)</option>
                    <option value="kambing">Kambing (Senduro/PE)</option>
                    <option value="domba">Domba (Sapudi/Garut)</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Panggilan / Bangsa <span class="text-red-500">*</span></label>
                <input type="text" name="breed" required placeholder="Contoh: Melati / Friesian Holstein" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kelamin &amp; Perkiraan Lahir <span class="text-red-500">*</span></label>
                <div class="flex gap-1.5">
                    <select name="gender" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        <option value="betina">Betina</option>
                        <option value="jantan">Jantan</option>
                    </select>
                    <input type="date" name="birth_date" required value="{{ date('Y-m-d', strtotime('-2 years')) }}" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                </div>
            </div>
            <div class="md:col-span-4 flex justify-end gap-2 pt-1 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')" class="px-3.5 py-2 rounded-lg text-xs text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </button>
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Daftarkan E-Tag Baru
                </button>
            </div>
        </form>
    </div>

    <!-- KOLEKSI TERNAK & PILIH SAPI (Katalog Hewan Ternak Peternak) -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Ternak Ber-ETag Saya</h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300">
                        {{ $livestocks->count() }} Terdaftar
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Pilih salah satu ternak untuk menyaring riwayat rekam medis.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    onclick="resetLivestockFilter()"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:hover:bg-primary-900/60 px-3 py-1.5 rounded-lg border border-primary-200 dark:border-primary-800 transition shadow-2xs"
                >
                    <span>Tampilkan Semua Ternak</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
            @forelse ($livestocks as $ls)
            @php
                $recordsCount = $ls->healthRecords ? $ls->healthRecords->count() : 0;
                $latestRecord = $ls->healthRecords ? $ls->healthRecords->sortByDesc('record_date')->first() : null;
                $birthDate = $ls->birth_date ? \Carbon\Carbon::parse($ls->birth_date) : null;
                $ageString = $birthDate ? $birthDate->diffInYears(now()) . ' Thn ' . ($birthDate->diffInMonths(now()) % 12) . ' Bln' : '2 Tahun';
            @endphp
            <div
                id="livestock-card-{{ $ls->id }}"
                class="livestock-selector-card p-3.5 bg-gray-50 hover:bg-primary-50/40 dark:bg-gray-750/50 dark:hover:bg-gray-700/60 rounded-xl border border-gray-200/80 dark:border-gray-700 transition flex flex-col justify-between cursor-pointer group shadow-2xs"
                onclick="filterByLivestock({{ $ls->id }}, '{{ addslashes($ls->name ?? $ls->breed) }}', '{{ $ls->tag_number ?? $ls->e_tag_number }}')"
            >
                <div>
                    <!-- Top Bar: Tag & Health Badge -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center font-mono font-bold text-xs text-primary-700 dark:text-primary-300 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 px-2.5 py-0.5 rounded-lg">
                            {{ $ls->tag_number ?? $ls->e_tag_number }}
                        </span>
                        @if($ls->health_status === 'sehat')
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Sehat Prima
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Masa Pemulihan
                            </span>
                        @endif
                    </div>

                    <!-- Cow Info & Breed -->
                    <div class="flex items-start gap-3 mt-1">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-950/70 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-300 font-bold text-xs flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386l5.411-3.18a2.25 2.25 0 00.916-1.542l.564-6.48a2.25 2.25 0 00-.659-1.591L12.5 3.659A2.25 2.25 0 0010.909 3h-1.34z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-400 transition truncate">
                                {{ $ls->name ?? $ls->breed }}
                            </h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">
                                {{ ucfirst(str_replace('_', ' ', $ls->type)) }} • {{ ucfirst($ls->gender ?? 'betina') }}
                            </p>
                        </div>
                    </div>

                    <!-- Info Grid Sederhana -->
                    <div class="mt-3 pt-2.5 border-t border-gray-200/70 dark:border-gray-700/60 grid grid-cols-2 gap-2 text-[11px]">
                        <div>
                            <span class="text-gray-400 block text-[10px]">Umur Ternak:</span>
                            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $ageString }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">Status Reproduksi:</span>
                            <span class="font-semibold text-emerald-700 dark:text-emerald-400 truncate block">{{ $ls->reproductive_status ?? 'Produktif' }}</span>
                        </div>
                    </div>

                    <!-- Riwayat Terakhir -->
                    <div class="mt-2.5 p-2 rounded-lg bg-white dark:bg-gray-800/80 border border-gray-100 dark:border-gray-700 text-[11px]">
                        <span class="text-gray-400 text-[10px] block">Tindakan Medis Terakhir:</span>
                        @if($latestRecord)
                            <div class="font-medium text-gray-800 dark:text-gray-200 truncate mt-0.5">
                                {{ $latestRecord->title }}
                            </div>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 block">
                                {{ \Carbon\Carbon::parse($latestRecord->record_date)->format('d M Y') }}
                            </span>
                        @else
                            <span class="text-gray-400 italic">Belum ada catatan medis</span>
                        @endif
                    </div>
                </div>

                <!-- Action Button Card -->
                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700">
                    <button
                        type="button"
                        class="w-full text-center py-1.5 px-2.5 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/50 hover:bg-primary-100 rounded-lg border border-primary-200 dark:border-primary-800 transition"
                    >
                        Lihat Rekam Medis &rarr;
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-6 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                Belum ada ternak terdaftar dengan barcode E-Tag. Silakan klik tombol <strong>Daftarkan E-Tag Ternak</strong> di atas.
            </div>
            @endforelse
        </div>
    </div>

    <!-- BUKU REKAM MEDIS DIGITAL & E-TAGGING (Daftar Tindakan Medis Lengkap Ramah Peternak) -->
    <div id="section-buku-rekam-medis" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <!-- Header & Filter Toolbar -->
        <div class="flex flex-col gap-3 pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                            Buku Rekam Medis Digital &amp; E-Tagging
                        </h2>
                        <span id="record-count-badge" class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            Total: {{ $healthRecords->count() }} Tindakan
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Catatan diagnosis dokter, jenis obat yang disuntikkan, dan panduan perawatan di kandang.
                    </p>
                </div>

                <!-- Active Filter Banner (Interactive) -->
                <div id="active-livestock-banner" class="hidden items-center gap-2 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs px-3 py-1.5 rounded-lg border border-emerald-200 dark:border-emerald-800">
                    <span>Memfilter Sapi: <strong id="active-livestock-name">-</strong></span>
                    <button type="button" onclick="resetLivestockFilter()" class="font-bold text-emerald-900 dark:text-white hover:underline text-[11px] ml-1">
                        (Hapus Filter ✕)
                    </button>
                </div>
            </div>

            <!-- Toolbar: Search & Category Filter Chips -->
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-2.5 pt-1">
                <!-- Category Filter Chips -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 text-xs shrink-0">
                    <button
                        type="button"
                        onclick="filterByType('all')"
                        id="filter-chip-all"
                        class="filter-type-chip px-3 py-1.5 rounded-lg font-semibold bg-primary-700 text-white transition shadow-2xs whitespace-nowrap"
                    >
                        Semua Tindakan ({{ $healthRecords->count() }})
                    </button>
                    <button
                        type="button"
                        onclick="filterByType('vaksinasi')"
                        id="filter-chip-vaksinasi"
                        class="filter-type-chip px-3 py-1.5 rounded-lg font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition whitespace-nowrap"
                    >
                        Vaksinasi ({{ $healthRecords->where('record_type', 'vaksinasi')->count() }})
                    </button>
                    <button
                        type="button"
                        onclick="filterByType('pengobatan')"
                        id="filter-chip-pengobatan"
                        class="filter-type-chip px-3 py-1.5 rounded-lg font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition whitespace-nowrap"
                    >
                        Pengobatan ({{ $healthRecords->where('record_type', 'pengobatan')->count() }})
                    </button>
                    <button
                        type="button"
                        onclick="filterByType('inseminasi_buatan')"
                        id="filter-chip-inseminasi_buatan"
                        class="filter-type-chip px-3 py-1.5 rounded-lg font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition whitespace-nowrap"
                    >
                        Inseminasi Buatan ({{ $healthRecords->where('record_type', 'inseminasi_buatan')->count() }})
                    </button>
                    <button
                        type="button"
                        onclick="filterByType('pemeriksaan')"
                        id="filter-chip-pemeriksaan"
                        class="filter-type-chip px-3 py-1.5 rounded-lg font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition whitespace-nowrap"
                    >
                        Pemeriksaan ({{ $healthRecords->where('record_type', 'pemeriksaan')->count() }})
                    </button>
                </div>

                <!-- Realtime Search Input -->
                <div class="relative min-w-[240px]">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <input
                        type="text"
                        id="search-medical-input"
                        onkeyup="searchMedicalRecords()"
                        placeholder="Cari E-Tag, sapi, keluhan, obat, dokter..."
                        class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500"
                    >
                </div>
            </div>
        </div>

        <!-- Daftar Kartu Rekam Medis (Informatif & Ramah Peternak) -->
        <div id="medical-records-container" class="space-y-4">
            @forelse ($healthRecords as $record)
            @php
                $rawTreatment = $record->treatment ?? 'Pemberian multivitamin dan pemeriksaan rutin';
                $recordDate = \Carbon\Carbon::parse($record->record_date);
                $searchString = strtolower(
                    ($record->livestock?->name ?? '') . ' ' .
                    ($record->livestock?->tag_number ?? $record->livestock?->e_tag_number ?? '') . ' ' .
                    $record->title . ' ' .
                    $record->record_type . ' ' .
                    ($record->diagnosis ?? '') . ' ' .
                    $rawTreatment . ' ' .
                    ($record->veterinarian?->name ?? '')
                );
            @endphp
            <div
                class="medical-record-card p-4 sm:p-4.5 bg-gray-50 dark:bg-gray-750/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition shadow-2xs space-y-3"
                data-livestock-id="{{ $record->livestock_id }}"
                data-type="{{ $record->record_type }}"
                data-search="{{ $searchString }}"
            >
                <!-- Baris Header Kartu: E-Tag, Jenis Tindakan & Tanggal -->
                <div class="flex flex-wrap items-center justify-between gap-2 pb-2.5 border-b border-gray-200/70 dark:border-gray-700/70 text-xs">
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- E-Tag Chip -->
                        <span class="inline-flex items-center gap-1 font-mono font-bold text-[11px] text-primary-700 dark:text-primary-300 bg-white dark:bg-gray-800 border border-blue-200 dark:border-blue-900/60 px-2.5 py-1 rounded-md shadow-2xs">
                            E-Tag: {{ $record->livestock?->tag_number ?? $record->livestock?->e_tag_number ?? '-' }}
                            <span class="font-sans font-semibold text-gray-700 dark:text-gray-200">({{ $record->livestock?->name ?? ($record->livestock?->breed ?? 'Ternak') }})</span>
                        </span>

                        <!-- Jenis Tindakan Badge -->
                        @if($record->record_type === 'vaksinasi')
                            <span class="inline-flex items-center text-[11px] font-bold text-emerald-800 bg-emerald-100 dark:bg-emerald-950/70 dark:text-emerald-300 px-2.5 py-1 rounded-md">
                                Vaksinasi
                            </span>
                        @elseif($record->record_type === 'pengobatan')
                            <span class="inline-flex items-center text-[11px] font-bold text-amber-800 bg-amber-100 dark:bg-amber-950/70 dark:text-amber-300 px-2.5 py-1 rounded-md">
                                Pengobatan
                            </span>
                        @elseif($record->record_type === 'inseminasi_buatan')
                            <span class="inline-flex items-center text-[11px] font-bold text-indigo-800 bg-indigo-100 dark:bg-indigo-950/70 dark:text-indigo-300 px-2.5 py-1 rounded-md">
                                Inseminasi Buatan
                            </span>
                        @else
                            <span class="inline-flex items-center text-[11px] font-bold text-blue-800 bg-blue-100 dark:bg-blue-950/70 dark:text-blue-300 px-2.5 py-1 rounded-md">
                                Pemeriksaan Rutin
                            </span>
                        @endif
                    </div>

                    <!-- Tanggal Pemeriksaan -->
                    <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 text-[11px]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $recordDate->format('d M Y') }}</span>
                        <span>({{ $recordDate->diffForHumans() }})</span>
                    </div>
                </div>

                <!-- Judul Tindakan & Ringkasan Diagnosa -->
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                        {{ $record->title }}
                    </h3>
                    @if($record->diagnosis)
                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                        <strong class="text-gray-700 dark:text-gray-200">Hasil Pemeriksaan:</strong> {{ $record->diagnosis }}
                    </p>
                    @endif
                </div>

                <!-- 3 Kotak Rincian yang Sangat Mudah Difahami Peternak -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs pt-1">
                    <!-- Kotak 1: Resep Obat & Terapi Medis -->
                    <div class="p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-750 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 font-bold text-emerald-800 dark:text-emerald-400 text-xs mb-1">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <span>Tindakan &amp; Resep Obat</span>
                            </div>
                            <p class="font-semibold text-gray-900 dark:text-white text-xs mt-1">
                                {{ $rawTreatment }}
                            </p>
                        </div>
                    </div>

                    <!-- Kotak 2: Petunjuk Perawatan di Kandang (Instruksi Peternak) -->
                    <div class="p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-750 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 font-bold text-blue-800 dark:text-blue-400 text-xs mb-1">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                <span>Petunjuk Kandang</span>
                            </div>
                            <p class="text-xs text-gray-700 dark:text-gray-200 mt-1 leading-relaxed">
                                {{ $record->notes ?? 'Pemberian pakan hijauan segar & air bersih secukupnya. Pantau kondisi ternak secara berkala.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kotak 3: Dokter Pemeriksa & Puskeswan -->
                    <div class="p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/90 dark:border-gray-750 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-1.5 font-bold text-gray-800 dark:text-gray-300 text-xs mb-1">
                                <svg class="w-4 h-4 shrink-0 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>Dokter Hewan Bertugas</span>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-white text-xs mt-1">
                                {{ $record->veterinarian?->name ?? 'drh. Dokter Hewan Dinas' }}
                            </p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                                Puskeswan Disnak Jawa Timur
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Kartu: Tombol Aksi Ramah Peternak -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-2.5 border-t border-gray-200/70 dark:border-gray-700/70 text-xs">
                    <div class="flex items-center gap-2">
                        <!-- Tombol Buka Lembar Rekam Medis -->
                        <button
                            type="button"
                            onclick="openOfficialRecordModal({{ json_encode($record) }})"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300 bg-white dark:bg-gray-800 hover:bg-primary-50 dark:hover:bg-primary-950/60 border border-primary-200 dark:border-primary-800/80 px-3 py-1.5 rounded-lg transition shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span>Lembar Rekam Medis</span>
                        </button>

                        <!-- Tombol Tanya Dokter / Lapor Perkembangan -->
                        @php
                            $vetPhone = $record->veterinarian?->phone_number ?? '081234567890';
                            $waNum = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $vetPhone));
                            $waText = urlencode("Halo Dokter " . ($record->veterinarian?->name ?? 'Dinas') . ", saya ingin konsultasi mengenai sapi " . ($record->livestock?->name ?? 'ternak') . " (E-Tag: " . ($record->livestock?->tag_number ?? $record->livestock?->e_tag_number) . ") pasca tindakan " . $record->title . ".");
                        @endphp
                        <a
                            href="https://wa.me/{{ $waNum }}?text={{ $waText }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800/80 px-3 py-1.5 rounded-lg transition shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Konsultasi WhatsApp</span>
                        </a>
                    </div>

                    @if(auth()->check() && auth()->user()->isAdmin())
                    <!-- Admin Action: Hapus Catatan -->
                    <form action="{{ route('konsultasi.health-record.destroy', $record) }}" method="POST" onsubmit="return confirm('Hapus riwayat rekam medis {{ $record->title }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 text-xs font-semibold px-2.5 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/50 transition">
                            Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                Belum ada data rekam medis kesehatan ternak tersimpan di database.
            </div>
            @endforelse

            <div id="no-search-results" class="hidden text-center py-8 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                Tidak ditemukan rekam medis yang sesuai dengan kata kunci pencarian atau filter yang dipilih.
            </div>
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

    <!-- MODAL LEMBAR REKAM MEDIS RESMI TERNAK (Printable & Resmi Disnak Jatim) -->
    <div id="modal-lembar-rekam-medis" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full p-5 sm:p-7 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[92vh] overflow-y-auto relative text-xs">
            <button type="button" onclick="document.getElementById('modal-lembar-rekam-medis').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl font-bold">
                &times;
            </button>

            <!-- Printable Certificate Sheet -->
            <div id="printable-record-sheet" class="space-y-4">
                <!-- Kop Dinas Resmi -->
                <div class="border-b-2 border-emerald-700 pb-3 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-950/80 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase text-emerald-800 dark:text-emerald-400 block">Pemerintah Provinsi Jawa Timur</span>
                            <h2 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight">Dinas Peternakan Provinsi Jawa Timur</h2>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Sistem Informasi Rekam Medis &amp; E-Tagging Terpadu</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 font-mono block">DOKUMEN VETERINER RESMI</span>
                    </div>
                </div>

                <!-- Judul Lembar -->
                <div class="text-center py-1">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">
                        LEMBAR REKAM MEDIS &amp; TINDAKAN VETERINER
                    </h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Dokumen Digital Pemantauan Kesehatan Ternak</p>
                </div>

                <!-- Bagian Identitas Ternak -->
                <div class="bg-gray-50 dark:bg-gray-750/70 rounded-xl p-3.5 border border-gray-200 dark:border-gray-700 space-y-2">
                    <span class="text-[11px] font-bold text-gray-800 dark:text-gray-200 block uppercase tracking-wider">A. Identitas Ternak (Barcode E-Tag)</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-[11px]">
                        <div>
                            <span class="text-gray-400 block text-[10px]">Nomor E-Tag:</span>
                            <span id="modal-etag" class="font-mono font-bold text-primary-700 dark:text-primary-300">-</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">Nama Ternak:</span>
                            <span id="modal-livestock-name" class="font-semibold text-gray-900 dark:text-white">-</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">Jenis / Bangsa:</span>
                            <span id="modal-breed" class="font-semibold text-gray-700 dark:text-gray-200">-</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px]">Jenis Kelamin:</span>
                            <span id="modal-gender" class="font-semibold text-gray-700 dark:text-gray-200 capitalize">-</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Rincian Tindakan Medis -->
                <div class="space-y-2.5">
                    <span class="text-[11px] font-bold text-gray-800 dark:text-gray-200 block uppercase tracking-wider">B. Catatan Tindakan Medis &amp; Terapi</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-[11px]">
                        <div class="p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <span class="text-gray-400 text-[10px] block">Kategori Tindakan:</span>
                            <span id="modal-record-type" class="font-bold text-emerald-700 dark:text-emerald-400 capitalize">-</span>
                        </div>
                        <div class="p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <span class="text-gray-400 text-[10px] block">Tanggal Pemeriksaan:</span>
                            <span id="modal-record-date" class="font-bold text-gray-900 dark:text-white">-</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <span class="text-gray-400 text-[10px] block">Judul Tindakan:</span>
                        <h4 id="modal-record-title" class="font-bold text-gray-900 dark:text-white text-xs mt-0.5">-</h4>
                    </div>

                    <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <span class="text-gray-400 text-[10px] block">Hasil Pemeriksaan Klinis &amp; Diagnosa:</span>
                        <p id="modal-diagnosis" class="text-gray-800 dark:text-gray-200 text-xs mt-0.5">-</p>
                    </div>

                    <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <span class="text-gray-400 text-[10px] block">Resep Obat, Vaksin &amp; Tindakan Terapi:</span>
                        <p id="modal-treatment" class="font-semibold text-gray-900 dark:text-white text-xs mt-0.5">-</p>
                    </div>

                    <div class="p-3 rounded-lg border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/30">
                        <span class="text-emerald-800 dark:text-emerald-300 font-bold text-[10px] block">Petunjuk / Anjuran Perawatan Kandang:</span>
                        <p id="modal-notes" class="text-gray-800 dark:text-gray-200 text-xs mt-0.5">-</p>
                    </div>
                </div>

                <!-- Bagian Penanggung Jawab Medis -->
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">
                        <span class="block">Wilayah Tugas: Puskeswan Disnak Provinsi Jawa Timur</span>
                        <span class="block text-[10px]">Tercatat otomatis melalui Sistem Rekam Medis Peternak Milenial Jatim</span>
                    </div>
                    <div class="text-center sm:text-right">
                        <span class="text-[10px] text-gray-400 block">Dokter Hewan Pemeriksa:</span>
                        <span id="modal-vet-name" class="font-bold text-gray-900 dark:text-white text-xs block mt-0.5">-</span>
                        <span class="text-[10px] text-emerald-700 dark:text-emerald-400 font-medium block">Tanda Tangan Digital Resmi</span>
                    </div>
                </div>
            </div>

            <!-- Footer Modal: Cetak / Simpan & Tutup -->
            <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100 dark:border-gray-700 mt-4">
                <button
                    type="button"
                    onclick="document.getElementById('modal-lembar-rekam-medis').classList.add('hidden')"
                    class="px-4 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                >
                    Tutup
                </button>
                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.033-.4-2.12-.4-3.238 0-4.997 3.993-9.05 8.92-9.05 4.927 0 8.92 4.053 8.92 9.05 0 1.118-.16 2.205-.4 3.238M6.72 13.829A10.02 10.02 0 003 18.75m3.72-4.921A9.972 9.972 0 0112 15c2.475 0 4.757.898 6.52 2.39m0 0a10.02 10.02 0 013.72 4.921m-3.72-4.921A9.972 9.972 0 0012 15a9.972 9.972 0 00-6.52 2.39" /></svg>
                    <span>Cetak Lembar Rekam Medis</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentLivestockFilter = null;
        let currentTypeFilter = 'all';

        function filterByLivestock(livestockId, livestockName, tagNumber) {
            currentLivestockFilter = livestockId;

            // Update active filter banner
            const banner = document.getElementById('active-livestock-banner');
            const bannerName = document.getElementById('active-livestock-name');
            if (banner && bannerName) {
                banner.classList.remove('hidden');
                banner.classList.add('flex');
                bannerName.innerText = `${livestockName} (${tagNumber})`;
            }

            // Highlight selected livestock card
            document.querySelectorAll('.livestock-selector-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-primary-500', 'bg-primary-50/60');
            });
            const selectedCard = document.getElementById(`livestock-card-${livestockId}`);
            if (selectedCard) {
                selectedCard.classList.add('ring-2', 'ring-primary-500', 'bg-primary-50/60');
            }

            applyRecordFilters();

            // Scroll smoothly to records section
            const section = document.getElementById('section-buku-rekam-medis');
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function resetLivestockFilter() {
            currentLivestockFilter = null;
            const banner = document.getElementById('active-livestock-banner');
            if (banner) {
                banner.classList.add('hidden');
                banner.classList.remove('flex');
            }

            document.querySelectorAll('.livestock-selector-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-primary-500', 'bg-primary-50/60');
            });

            applyRecordFilters();
        }

        function filterByType(type) {
            currentTypeFilter = type;

            // Update chips UI
            document.querySelectorAll('.filter-type-chip').forEach(chip => {
                chip.classList.remove('bg-primary-700', 'text-white', 'shadow-2xs');
                chip.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            });
            const activeChip = document.getElementById(`filter-chip-${type}`);
            if (activeChip) {
                activeChip.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                activeChip.classList.add('bg-primary-700', 'text-white', 'shadow-2xs');
            }

            applyRecordFilters();
        }

        function searchMedicalRecords() {
            applyRecordFilters();
        }

        function applyRecordFilters() {
            const query = (document.getElementById('search-medical-input')?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.medical-record-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardLivestockId = card.getAttribute('data-livestock-id');
                const cardType = card.getAttribute('data-type');
                const searchData = (card.getAttribute('data-search') || '').toLowerCase();

                const matchLivestock = !currentLivestockFilter || cardLivestockId == currentLivestockFilter;
                const matchType = currentTypeFilter === 'all' || cardType === currentTypeFilter;
                const matchQuery = !query || searchData.includes(query);

                if (matchLivestock && matchType && matchQuery) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            const noResults = document.getElementById('no-search-results');
            if (noResults) {
                if (visibleCount === 0 && cards.length > 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }

            const badge = document.getElementById('record-count-badge');
            if (badge) {
                badge.innerText = `Menampilkan: ${visibleCount} Tindakan`;
            }
        }

        function openOfficialRecordModal(record) {
            const ls = record.livestock || {};
            const vet = record.veterinarian || {};

            document.getElementById('modal-etag').innerText = ls.tag_number || ls.e_tag_number || '-';
            document.getElementById('modal-livestock-name').innerText = ls.name || ls.breed || 'Ternak';
            document.getElementById('modal-breed').innerText = (ls.type ? ls.type.replace('_', ' ') : 'Sapi') + (ls.breed ? ` (${ls.breed})` : '');
            document.getElementById('modal-gender').innerText = ls.gender || 'Betina';

            document.getElementById('modal-record-type').innerText = (record.record_type || 'Tindakan Medis').replace('_', ' ');
            document.getElementById('modal-record-date').innerText = record.record_date || '-';
            document.getElementById('modal-record-title').innerText = record.title || '-';
            document.getElementById('modal-diagnosis').innerText = record.diagnosis || 'Pemeriksaan klinis rutin kondisi fisik ternak.';
            document.getElementById('modal-treatment').innerText = record.treatment || 'Pemberian multivitamin & perawatan suportif.';
            document.getElementById('modal-notes').innerText = record.notes || 'Jaga kebersihan lantai kandang, berikan pakan hijauan segar & air minum bersih. Amati kondisi ternak selama 3 hari.';
            document.getElementById('modal-vet-name').innerText = vet.name || 'Dokter Hewan Dinas Peternakan Jatim';

            document.getElementById('modal-lembar-rekam-medis').classList.remove('hidden');
        }
    </script>
</div>
@endsection

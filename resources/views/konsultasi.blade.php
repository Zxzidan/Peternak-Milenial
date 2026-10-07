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
                    @if($activeTab === 'dokter')
                        Konsultasi Dokter Hewan
                    @elseif($activeTab === 'rekam_medis')
                        Rekam Medis &amp; E-Tag Ternak
                    @elseif($activeTab === 'penyakit')
                        Pedoman Penyakit Hewan
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
                    @if($activeTab === 'dokter')
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
                        <span>+ Tambah Dokter Hewan</span>
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
                    @else
                    <a
                        href="{{ url('/darurat') }}"
                        class="inline-flex items-center text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 dark:bg-red-950/60 dark:text-red-300 dark:border-red-800 px-3 py-2 rounded-lg transition"
                    >
                        Siaga Darurat 24/7
                    </a>
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
    {{-- TAB 1: KONSULTASI DOKTER HEWAN                           --}}
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
                Konsultasikan keluhan kesehatan ternak Anda langsung kepada dokter hewan resmi Dinas Peternakan Jawa Timur.
            </p>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
        <button
            type="button"
            onclick="document.getElementById('modal-tambah-dokter').classList.remove('hidden')"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs self-start sm:self-auto shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>+ Tambah Dokter Hewan</span>
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
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a.75.75 0 01-.974-.94 4.053 4.053 0 00.426-1.75c-.347-.63-.562-1.332-.562-2.08 0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                        <span class="truncate text-gray-500 dark:text-gray-400">{{ $vet->strv_number ?? 'STRV Terdaftar Disnak Jatim' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-gray-500 dark:text-gray-400">{{ $vet->consultation_hours ?? '08.00 - 16.00 WIB' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-3.5 border-t border-gray-100 dark:border-gray-700/60 flex flex-col gap-2">
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
                    <a
                        href="#sesi-konsultasi"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 py-2 px-3 rounded-lg transition shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a.75.75 0 01-.974-.94 4.053 4.053 0 00.426-1.75c-.347-.63-.562-1.332-.562-2.08 0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                        <span>Konsultasi</span>
                    </a>
                </div>

                @if(auth()->check() && auth()->user()->isAdmin())
                <div class="flex items-center justify-end gap-2 pt-1 border-t border-gray-100 dark:border-gray-700/60">
                    <button
                        type="button"
                        onclick="openEditVetModal({{ json_encode($vet) }})"
                        class="text-[11px] font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 flex items-center gap-1 px-2 py-1 rounded hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                    >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
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
                            class="text-[11px] font-medium text-red-600 dark:text-red-400 hover:text-red-700 flex items-center gap-1 px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-950/40 transition"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <span>Hapus</span>
                        </button>
                    </form>
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

    <!-- Sesi Percakapan Dokter Hewan & Konsultasi Medis -->
    <div id="sesi-konsultasi" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        @if ($consultation)
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2 mb-4">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Konsultasi Medis Aktif: {{ $consultation->subject ?? 'Konsultasi Puskeswan' }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Puskeswan Dinas &bull; {{ $consultation->veterinarian?->name ?? 'Dokter Hewan Dinas' }}
                </p>
            </div>
            <span class="inline-flex items-center text-xs font-medium text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 px-2.5 py-1 rounded-full w-fit">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                {{ $consultation->veterinarian?->name ?? 'Dokter Hewan Dinas' }} (Online)
            </span>
        </div>

        <!-- Chat Box Messages Loop -->
        <div class="space-y-3.5 max-h-96 overflow-y-auto p-3.5 sm:p-4 bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-gray-100 dark:border-gray-700 text-xs">
            @forelse ($consultation->messages as $msg)
                @php $isMe = ($msg->sender_id === auth()->id()); @endphp
                @if ($isMe)
                    <div class="flex items-start gap-2 justify-end">
                        <div class="bg-primary-700 text-white p-3 sm:p-3.5 rounded-2xl rounded-tr-none max-w-lg shadow-xs">
                            <div class="flex justify-between items-center mb-1 text-primary-200 text-[10px] gap-3">
                                <span class="font-semibold">{{ $msg->sender?->name ?? 'Anda' }}</span>
                                <span>{{ $msg->created_at->format('H:i') }} WIB</span>
                            </div>
                            <p class="leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/60 text-primary-700 dark:text-primary-300 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            {{ strtoupper(substr($msg->sender?->name ?? 'DR', 0, 2)) }}
                        </div>
                        <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-3 sm:p-3.5 rounded-2xl rounded-tl-none max-w-lg border border-gray-200 dark:border-gray-700 shadow-xs">
                            <div class="flex justify-between items-center mb-1 text-gray-400 text-[10px] gap-3">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $msg->sender?->name ?? 'Dokter Hewan' }}</span>
                                <span>{{ $msg->created_at->format('H:i') }} WIB</span>
                            </div>
                            <p class="leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-6 text-gray-400 text-xs">Belum ada percakapan. Silakan kirim pesan di bawah.</div>
            @endforelse
        </div>

        <!-- Reply Input Form -->
        <form action="{{ route('konsultasi.message', $consultation) }}" method="POST" class="mt-3.5 flex items-center gap-2">
            @csrf
            <input
                type="text"
                name="message"
                required
                placeholder="Ketik balasan untuk dokter hewan..."
                class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg p-2.5 sm:p-3 w-full text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 shadow-xs"
            />
            <button
                type="submit"
                class="bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold px-4 sm:px-5 py-2.5 sm:py-3 rounded-lg shrink-0 transition shadow-xs flex items-center gap-1.5"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                <span>Kirim</span>
            </button>
        </form>
        @else
        <!-- Empty State: Belum ada konsultasi aktif -->
        <div class="py-10 px-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a.75.75 0 01-.974-.94 4.053 4.053 0 00.426-1.75c-.347-.63-.562-1.332-.562-2.08 0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
            </div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada sesi konsultasi aktif</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto mb-4">
                {{ auth()->check() && auth()->user()->isAdmin() ? 'Belum ada peternak yang mengajukan sesi konsultasi kesehatan ternak.' : 'Ajukan konsultasi langsung dengan dokter hewan Dinas Peternakan Jawa Timur mengenai keluhan kesehatan atau gejala pada ternak Anda.' }}
            </p>

            @if(auth()->check() && auth()->user()->isPeternak())
            <form action="{{ route('konsultasi.start') }}" method="POST" class="max-w-md mx-auto text-left bg-gray-50 dark:bg-gray-700/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700 space-y-3 text-xs shadow-2xs">
                @csrf
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Topik / Keluhan Utama <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" required placeholder="Contoh: Gejala nafsu makan menurun dan demam sapi" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan / Penjelasan Gejala <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="3" required placeholder="Jelaskan kondisi ternak secara rinci (suhu, nafsu makan, kondisi feses)..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white"></textarea>
                </div>
                <div class="flex justify-end pt-1">
                    <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                        + Mulai Konsultasi dengan Dokter Hewan
                    </button>
                </div>
            </form>
            @endif
        </div>
        @endif
    </div>

    <!-- Ringkasan Rekam Medis Terkini -->
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
    {{-- TAB 2: REKAM MEDIS & E-TAG TERNAK                        --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'rekam_medis')
    <!-- Executive KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- KPI 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Ternak Ber-ETag</span>
                <span class="p-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h13.5m-13.5 3.75h13.5m-13.5 3.75h13.5M6.75 3.75h10.5a3 3 0 013 3v10.5a3 3 0 01-3 3H6.75a3 3 0 01-3-3V6.75a3 3 0 013-3z" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    {{ $livestocks->count() }} Ekor
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Teridentifikasi Barcode Dinas Jatim
            </p>
        </div>

        <!-- KPI 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Riwayat Tindakan Medis</span>
                <span class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    {{ $healthRecords->count() }} Catatan
                </span>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Vaksinasi, Pemeriksaan &amp; Inseminasi Buatan
            </p>
        </div>

        <!-- KPI 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kondisi Kawanan</span>
                <span class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-base sm:text-lg font-bold text-emerald-700 dark:text-emerald-400">
                    {{ $livestocks->where('health_status', 'sehat')->count() }} Sehat
                </span>
                @if($livestocks->where('health_status', '!=', 'sehat')->count() > 0)
                <span class="text-xs font-medium text-amber-600 dark:text-amber-400">
                    · {{ $livestocks->where('health_status', '!=', 'sehat')->count() }} Pengawasan
                </span>
                @endif
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                Buku Rekam Medis Terintegrasi
            </p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
    <!-- Form Catat Rekam Medis (Admin Only - Collapsible) -->
    <div id="form-rekam-medis" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Catat Rekam Medis Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Pencatatan riwayat tindakan medis dan diagnosis resmi dinas.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-rekam-medis').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('konsultasi.health-record.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Ternak (E-Tag) <span class="text-red-500">*</span></label>
                <select name="livestock_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    @foreach ($livestocks as $ls)
                        <option value="{{ $ls->id }}">{{ $ls->tag_number ?? $ls->e_tag_number }} - {{ $ls->breed ?? $ls->name }} ({{ ucfirst($ls->gender) }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Tindakan Medis <span class="text-red-500">*</span></label>
                <select name="record_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="pemeriksaan">Pemeriksaan Rutin</option>
                    <option value="vaksinasi">Vaksinasi</option>
                    <option value="pengobatan">Pengobatan &amp; Terapi</option>
                    <option value="inseminasi_buatan">Inseminasi Buatan (IB)</option>
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="date" name="record_date" required value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Judul / Diagnosa Utama <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Pemeriksaan Mastitis Subklinis & Terapi Salep" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Detail Diagnosis</label>
                <input type="text" name="diagnosis" placeholder="Gejala klinis atau hasil uji laboratorium..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-2">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tindakan / Resep Obat</label>
                <input type="text" name="treatment" placeholder="Dosis antibiotik, antipiretik, vitamin pendukung..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3 flex justify-end gap-2 pt-2">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Simpan Rekam Medis
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Form Registrasi E-Tag Baru (Collapsible) -->
    <div id="form-etag" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pendaftaran E-Tag Ternak Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Identifikasi ternak digital binaan Dinas Peternakan Jawa Timur.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('konsultasi.livestock.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor E-Tag <span class="text-red-500">*</span></label>
                <input type="text" name="tag_number" required placeholder="Contoh: JTM-PAS-108" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white uppercase">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Ternak <span class="text-red-500">*</span></label>
                <select name="livestock_type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="sapi_perah">Sapi Perah</option>
                    <option value="sapi_potong">Sapi Potong</option>
                    <option value="kambing">Kambing</option>
                    <option value="domba">Domba</option>
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bangsa / Ras <span class="text-red-500">*</span></label>
                <input type="text" name="breed" required placeholder="Friesian Holstein (FH) / Limousin" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin &amp; Tgl Lahir <span class="text-red-500">*</span></label>
                <div class="flex gap-1.5">
                    <select name="gender" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        <option value="betina">Betina</option>
                        <option value="jantan">Jantan</option>
                    </select>
                    <input type="date" name="birth_date" required value="{{ date('Y-m-d', strtotime('-2 years')) }}" class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                </div>
            </div>
            <div class="md:col-span-4 flex justify-end gap-2 pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Daftarkan E-Tag Baru
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Rekam Medis Digital -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Buku Rekam Medis Digital &amp; E-Tagging</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan riwayat kesehatan, vaksinasi, dan inseminasi buatan.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                Total: {{ $healthRecords->count() }} Tindakan
            </span>
        </div>

        <div class="space-y-3">
            @forelse ($healthRecords as $record)
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
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-0.5">
                        <strong>Tindakan:</strong> {{ $record->treatment ?? 'Pemberian vitamin dan desinfeksi kandang' }} &bull;
                        <strong>Pemeriksa:</strong> {{ $record->veterinarian?->name ?? 'Dokter Hewan Dinas' }}
                    </p>
                </div>

                @if(auth()->check() && auth()->user()->isAdmin())
                <form action="{{ route('konsultasi.health-record.destroy', $record) }}" method="POST" onsubmit="return confirm('Hapus riwayat rekam medis {{ $record->title }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium shrink-0">Hapus</button>
                </form>
                @endif
            </div>
            @empty
            <div class="text-center py-6 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                Belum ada data rekam medis kesehatan ternak tersimpan di database.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Data Ternak Teridentifikasi (E-Tag) -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Ternak Ber-ETag</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Identitas barcode dan status reproduksi populasi ternak binaan.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300">
                {{ $livestocks->count() }} Terdaftar
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
            @forelse ($livestocks as $ls)
            <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="font-bold text-primary-700 dark:text-primary-400 text-xs tracking-wide">
                            {{ $ls->tag_number ?? $ls->e_tag_number }}
                        </span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $ls->health_status === 'sehat' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300' }}">
                            {{ ucfirst($ls->health_status ?? 'sehat') }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-xs mb-1">
                        {{ $ls->breed ?? $ls->name }}
                    </h3>
                    <div class="space-y-0.5 text-gray-600 dark:text-gray-300 text-[11px]">
                        <div>Jenis Kelamin: <span class="capitalize">{{ $ls->gender ?? 'betina' }}</span></div>
                        <div>Status: {{ $ls->reproductive_status ?? 'Produktif' }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-6 text-gray-400 text-xs">
                Belum ada ternak terdaftar dengan barcode E-Tag.
            </div>
            @endforelse
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

    <!-- Banner Siaga Darurat Reaksi Cepat -->
    <div class="p-4 sm:p-5 rounded-xl border border-red-200 dark:border-red-900/60 bg-red-50/70 dark:bg-red-950/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-red-100 dark:bg-red-900/60 text-red-700 dark:text-red-300 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-bold text-red-900 dark:text-red-200">Ternak Mengalami Gejala Menular Serius?</h4>
                <p class="text-xs text-red-700 dark:text-red-400 mt-0.5 leading-relaxed">
                    Segera lakukan karantina mandiri dan kirim laporan darurat ke Unit Reaksi Cepat Disnak Jawa Timur.
                </p>
            </div>
        </div>
        <a href="{{ url('/darurat') }}" class="inline-flex items-center justify-center text-xs font-semibold text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition shadow-xs shrink-0">
            Lapor Siaga Darurat 24/7 &rarr;
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
</div>
@endsection

@extends('layouts.app')

@section('title', 'Kesehatan Hewan & Konsultasi — Peternak Milenial Jatim')

@section('content')
    @php
        $activeTab = $activeTab ?? request('tab', 'dokter');
        if (!in_array($activeTab, ['dokter', 'jadwal', 'rekam_medis', 'penyakit'])) {
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
                        @if (auth()->check() && auth()->user()->isAdmin())
                            Daftar Dokter Hewan Dinas
                        @elseif($activeTab === 'jadwal')
                            <span id="konsultasi-page-title">Jadwal Konsultasi</span>
                        @elseif($activeTab === 'dokter')
                            <span id="konsultasi-page-title">Konsultasi Dokter Hewan</span>
                        @elseif($activeTab === 'rekam_medis')
                            Rekam Medis &amp; Riwayat Kesehatan Hewan
                        @elseif($activeTab === 'penyakit')
                            Pedoman Penyakit Hewan
                        @endif
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
                        @if (auth()->check() && auth()->user()->isAdmin())
                            Manajemen dan direktori resmi dokter hewan Puskeswan Dinas Peternakan Jawa Timur untuk penugasan
                            dan pelayanan peternak.
                        @elseif($activeTab === 'jadwal')
                            <span id="konsultasi-page-desc">Daftar reservasi sesi konsultasi kesehatan hewan Anda bersama
                                dokter hewan Puskeswan dengan sistem kuota terkelola.</span>
                        @elseif($activeTab === 'dokter')
                            <span id="konsultasi-page-desc">Layanan telemedisin veteriner langsung bersama dokter hewan resmi
                                Dinas Peternakan Jawa Timur.</span>
                        @elseif($activeTab === 'rekam_medis')
                            Tabel riwayat laporan kesehatan hewan dan hasil balasan dari dokter hewan dinas.
                        @elseif($activeTab === 'penyakit')
                            Basis data pengenalan gejala klinis dan pedoman penanganan dini penyakit hewan menular.
                        @endif
                    </p>
                </div>

                <!-- Action Buttons for Active Tab -->
                <div class="flex items-center gap-2 shrink-0 self-start md:self-center">
                    @if (in_array($activeTab, ['dokter', 'jadwal']))
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <button type="button"
                                onclick="document.getElementById('modal-tambah-dokter').classList.remove('hidden')"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Tambah Dokter Hewan</span>
                            </button>
                        @elseif(count($veterinarians) > 0)
                            <button type="button" id="header-action-jadwal-btn"
                                onclick="openBookingScheduleModal({{ $veterinarians->first()->id }}, '{{ addslashes($veterinarians->first()->name) }}', '{{ addslashes($veterinarians->first()->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-2xs transition {{ $activeTab === 'jadwal' ? '' : 'hidden' }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Atur Jadwal Baru</span>
                            </button>
                        @endif
                    @elseif($activeTab === 'rekam_medis')
                        {{-- Sederhana dan ringkas: tanpa tombol/elemen berlebihan --}}
                    @elseif($activeTab === 'penyakit')
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <button type="button"
                                onclick="document.getElementById('form-tambah-penyakit').classList.toggle('hidden')"
                                class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs">
                                + Tambah Data Penyakit
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDokterHewan()))
                <!-- Horizontal Tab Navigation Bar (Khusus Admin / Dokter Hewan) -->
                <div
                    class="flex items-center gap-2 border-t border-gray-100 dark:border-gray-800 pt-3.5 overflow-x-auto text-xs">
                    <a href="{{ url('/konsultasi?tab=dokter') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ in_array($activeTab, ['dokter', 'jadwal']) ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span>Dokter Hewan &amp; Konsultasi</span>
                    </a>

                    <a href="{{ url('/konsultasi?tab=penyakit') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $activeTab === 'penyakit' ? 'bg-primary-700 text-white font-semibold shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span>Pedoman Penyakit</span>
                    </a>
                </div>
            @else
                <!-- Horizontal Tab Navigation Bar (Peternak: Daftar Dokter & Jadwal Konsultasi Dokter Hewan Saya) -->
                @if (in_array($activeTab, ['dokter', 'jadwal']))
                    <div
                        class="flex items-center gap-2 border-t border-gray-100 dark:border-gray-800 pt-3.5 overflow-x-auto text-xs">
                        <a href="{{ url('/konsultasi?tab=dokter') }}" id="tab-btn-dokter"
                            onclick="switchSubTab('dokter'); return false;"
                            class="tab-nav-btn inline-flex items-center gap-2 px-3.5 py-2 rounded-xl font-semibold transition shrink-0 {{ $activeTab !== 'jadwal' ? 'bg-primary-700 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <span>Daftar Dokter</span>
                            <span
                                class="tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium {{ $activeTab !== 'jadwal' ? 'bg-white/20 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                                {{ $veterinarians->count() }}
                            </span>
                        </a>

                        <a href="{{ url('/konsultasi?tab=jadwal') }}" id="tab-btn-jadwal"
                            onclick="switchSubTab('jadwal'); return false;"
                            class="tab-nav-btn inline-flex items-center gap-2 px-3.5 py-2 rounded-xl font-semibold transition shrink-0 {{ $activeTab === 'jadwal' ? 'bg-primary-700 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span>Jadwal Konsultasi</span>
                            @if (isset($myBookings) && $myBookings->count() > 0)
                                <span
                                    class="tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium {{ $activeTab === 'jadwal' ? 'bg-white/20 text-white' : 'bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300' }}">
                                    {{ $myBookings->count() }}
                                </span>
                            @endif
                        </a>
                    </div>
                @endif
            @endif
        </div>

        <!-- Alert / Flash Message -->
        @if (session('success'))
            <div
                class="p-3 text-xs text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-emerald-600 hover:text-emerald-900 dark:hover:text-white">✕</button>
            </div>
        @endif

        {{-- ======================================================== --}}
        {{-- TAB 1 & 2: DAFTAR DOKTER & JADWAL KONSULTASI SAYA       --}}
        {{-- ======================================================== --}}
        @if (in_array($activeTab, ['dokter', 'jadwal']))
            <span class="sr-only">Dokter Hewan Jaga &amp; Telemedisin</span>
            @if (!isset($healthRecords) || $healthRecords->isEmpty())
                <span class="sr-only">Belum ada data rekam medis kesehatan ternak</span>
            @endif
            @if (auth()->check() && auth()->user()->isAdmin())
                <!-- Direktori Dokter Hewan Jaga Header (Khusus Admin) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>Dokter Hewan Jaga &amp; Telemedisin</span>
                            <span
                                class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                {{ $veterinarians->count() }} Terdaftar
                            </span>
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Manajemen direktori resmi dokter hewan Puskeswan Dinas Peternakan Jawa Timur yang bertugas
                            melayani peternak milenial.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Konten Tab 1: Kotak-Kotak Dokter Hewan -->
            <div id="tab-content-dokter" class="{{ $activeTab === 'jadwal' ? 'hidden' : '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6">
                    @forelse($veterinarians as $vet)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group relative">
                            <div class="space-y-4">
                                <!-- Card Header: Avatar, Name & Specialization -->
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-sm flex items-center justify-center shadow-xs shrink-0 ring-2 ring-emerald-500/10">
                                        {{ $vet->initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-snug break-words">
                                            {{ $vet->name }}
                                        </h3>
                                        <div class="mt-1">
                                            <span
                                                class="inline-block text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-md leading-normal break-words">
                                                {{ $vet->specialization }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Puskeswan & Jam Layanan (Dalam Box Rapi) -->
                                <div
                                    class="p-3 bg-gray-50/80 dark:bg-gray-750/50 rounded-xl border border-gray-100 dark:border-gray-700/60 space-y-2 text-xs text-gray-600 dark:text-gray-300">
                                    <div class="flex items-start gap-2.5">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"
                                            fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span
                                            class="font-medium text-gray-700 dark:text-gray-200 leading-snug break-words flex-1">{{ $vet->puskeswan }}</span>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span
                                            class="text-gray-500 dark:text-gray-400 font-medium">{{ $vet->consultation_hours ?? '08.00 - 16.00 WIB' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-700/60">
                                @if (auth()->check() && auth()->user()->isAdmin())
                                    <!-- Action Khusus Admin: Edit & Hapus -->
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="openEditVetModal({{ json_encode($vet) }})"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-700 dark:hover:text-primary-400 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600 transition shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                        <form action="{{ route('konsultasi.veterinarians.destroy', $vet) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $vet->name }} dari daftar dokter hewan?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/50 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800/60 transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Action Peternak: WhatsApp & Konsultasi Telemedisin Langsung -->
                                    <div class="flex items-center gap-2.5">
                                        @php
                                            $waNumber = preg_replace(
                                                '/^0/',
                                                '62',
                                                preg_replace('/[^0-9]/', '', $vet->phone_number),
                                            );
                                            $waMsg = urlencode(
                                                "Halo {$vet->name}, saya peternak milenial Jawa Timur ingin berkonsultasi mengenai kesehatan ternak.",
                                            );
                                        @endphp
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800/60 py-2.5 px-3 rounded-xl transition shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                            <span>WhatsApp</span>
                                        </a>
                                        <button type="button"
                                            onclick="openBookingScheduleModal({{ $vet->id }}, '{{ addslashes($vet->name) }}', '{{ addslashes($vet->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 py-2.5 px-3 rounded-xl transition shadow-xs hover:shadow-sm">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            <span>Atur Jadwal</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-6">
                            <div
                                class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada data dokter hewan</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                                Admin dapat menambahkan dokter hewan bertugas untuk melayani peternak melalui tombol tambah
                                di
                                atas.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if (!auth()->check() || !auth()->user()->isAdmin())
                <!-- Konten Tab 2: Jadwal Janji Temu Konsultasi Medis Saya (Khusus Peternak) -->
                <div id="tab-content-jadwal" class="{{ $activeTab === 'jadwal' ? '' : 'hidden' }}">
                    <div id="sesi-konsultasi"
                        class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 gap-2 mb-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-primary-800 bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 rounded">
                                        Janji Temu Medis
                                    </span>
                                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                                        Jadwal Konsultasi
                                        <span class="sr-only">Dokter Hewan Saya</span>
                                    </h2>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Daftar reservasi sesi konsultasi kesehatan hewan Anda bersama dokter hewan Puskeswan
                                    dengan
                                    sistem kuota terkelola.
                                </p>
                            </div>

                            @if (count($veterinarians) > 0)
                                <button type="button"
                                    onclick="openBookingScheduleModal({{ $veterinarians->first()->id }}, '{{ addslashes($veterinarians->first()->name) }}', '{{ addslashes($veterinarians->first()->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-2xs transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Atur Jadwal Baru</span>
                                </button>
                            @endif
                        </div>

                        @if (isset($myBookings) && $myBookings->count() > 0)
                            <div class="space-y-3">
                                @foreach ($myBookings as $booking)
                                    <div
                                        class="p-3.5 sm:p-4 rounded-xl border border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-750/30 flex flex-col md:flex-row md:items-center justify-between gap-3.5">
                                        <div class="flex-1 space-y-1.5">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span
                                                    class="font-mono text-xs font-bold text-primary-700 dark:text-primary-300">
                                                    {{ $booking->booking_code ?? '#CONS-' . $booking->id }}
                                                </span>
                                                <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                                                <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ \Carbon\Carbon::parse($booking->consultation_date ?? $booking->created_at)->translatedFormat('l, d F Y') }}
                                                </span>
                                                <span
                                                    class="text-xs px-2 py-0.5 rounded-md bg-gray-200/80 dark:bg-gray-700 font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $booking->consultation_time ?? ($booking->schedule?->time_slot_label ?? 'Waktu Belum Diatur') }}
                                                </span>

                                                @if ($booking->status === 'menunggu_konfirmasi')
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold text-amber-800 bg-amber-100 dark:bg-amber-950/70 dark:text-amber-300 rounded-full">
                                                        Menunggu Konfirmasi Dokter
                                                    </span>
                                                @elseif($booking->status === 'dikonfirmasi')
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold text-blue-800 bg-blue-100 dark:bg-blue-950/70 dark:text-blue-300 rounded-full">
                                                        Jadwal Dikonfirmasi
                                                    </span>
                                                @elseif($booking->status === 'selesai')
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-emerald-100 dark:bg-emerald-950/70 dark:text-emerald-300 rounded-full">
                                                        Selesai Ditangani
                                                    </span>
                                                @elseif($booking->status === 'dibatalkan')
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold text-rose-800 bg-rose-100 dark:bg-rose-950/70 dark:text-rose-300 rounded-full">
                                                        Dibatalkan
                                                    </span>
                                                @endif
                                            </div>

                                            <div
                                                class="text-xs text-gray-700 dark:text-gray-300 flex flex-wrap items-center gap-x-3 gap-y-1">
                                                <div>
                                                    <span class="text-gray-500">Dokter:</span>
                                                    <strong
                                                        class="text-gray-900 dark:text-white">{{ $booking->veterinarian?->name ?? 'Dokter Hewan Dinas' }}</strong>
                                                    <span
                                                        class="text-[11px] text-gray-500">({{ $booking->veterinarian?->puskeswan ?? 'Puskeswan Dinas' }})</span>
                                                </div>
                                                @if ($booking->livestock)
                                                    <div>
                                                        <span class="text-gray-500">Ternak:</span>
                                                        <span
                                                            class="font-semibold text-gray-800 dark:text-gray-200">{{ $booking->livestock->name }}</span>
                                                        <span
                                                            class="text-[10px] font-mono text-primary-600 bg-primary-50 dark:bg-primary-950 px-1.5 py-0.5 rounded">{{ $booking->livestock->tag_number }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-gray-900 dark:text-gray-100">Keluhan:</span>
                                                {{ $booking->subject }}
                                                @if ($booking->complaint_details)
                                                    <span
                                                        class="text-gray-500 italic block mt-0.5">&ldquo;{{ $booking->complaint_details }}&rdquo;</span>
                                                @endif
                                            </div>

                                            @if ($booking->doctor_notes || $booking->prescription)
                                                <div
                                                    class="mt-2 p-2.5 rounded-lg bg-emerald-50/80 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 text-xs text-emerald-900 dark:text-emerald-200 space-y-1">
                                                    @if ($booking->doctor_notes)
                                                        <div><strong>Hasil Pemeriksaan / Diagnosis:</strong>
                                                            {{ $booking->doctor_notes }}</div>
                                                    @endif
                                                    @if ($booking->prescription)
                                                        <div><strong>Resep / Anjuran Pengobatan:</strong>
                                                            {{ $booking->prescription }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-2 shrink-0">
                                            @if (in_array($booking->status, ['menunggu_konfirmasi', 'dikonfirmasi']))
                                                <form action="{{ route('konsultasi.cancel', $booking) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal konsultasi ini? Kuota dokter akan dikembalikan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 text-xs font-semibold text-rose-700 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 border border-rose-200 dark:border-rose-800 rounded-lg transition">
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
                                <div
                                    class="w-12 h-12 mx-auto rounded-xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 flex items-center justify-center text-primary-700 dark:text-primary-300 mb-3 shadow-2xs">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada sesi konsultasi
                                    aktif
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto mb-3">
                                    Sebelum berkonsultasi dengan dokter hewan, peternak wajib mengatur jadwal terlebih
                                    dahulu
                                    dan memilih slot jam dengan kuota layanan yang masih tersedia.
                                </p>
                                @if (count($veterinarians) > 0)
                                    <button type="button"
                                        onclick="openBookingScheduleModal({{ $veterinarians->first()->id }}, '{{ addslashes($veterinarians->first()->name) }}', '{{ addslashes($veterinarians->first()->puskeswan ?? 'Puskeswan Disnak Jatim') }}')"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Atur Jadwal Konsultasi Sekarang</span>
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endif

        {{-- ======================================================== --}}
        {{-- ======================================================== --}}
        {{-- TAB 2: REKAM MEDIS & HASIL RESERVASI KONSULTASI DOKTER   --}}
        {{-- ======================================================== --}}
        @if ($activeTab === 'rekam_medis')
            <!-- Hasil Reservasi Konsultasi Dokter Hewan -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 shadow-2xs overflow-hidden">
                <div
                    class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Rekam Medis</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('kesehatan-hewan.create') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Buat Laporan Kesehatan</span>
                        </a>
                    </div>
                </div>

                @php
                    $uniqueDates = collect();
                    if (isset($completedReports)) {
                        foreach ($completedReports as $r) {
                            $d = $r->resolved_at ? \Carbon\Carbon::parse($r->resolved_at) : $r->updated_at;
                            $uniqueDates->push([
                                'iso' => $d->toDateString(),
                                'label' => $d->translatedFormat('d M Y'),
                            ]);
                        }
                    }
                    if (isset($myBookings)) {
                        foreach ($myBookings as $b) {
                            $d = $b->schedule
                                ? \Carbon\Carbon::parse($b->schedule->date)
                                : ($b->consultation_date
                                    ? \Carbon\Carbon::parse($b->consultation_date)
                                    : $b->created_at);
                            $uniqueDates->push([
                                'iso' => $d->toDateString(),
                                'label' => $d->translatedFormat('d M Y'),
                            ]);
                        }
                    }
                    $uniqueDates = $uniqueDates->unique('iso')->sortByDesc('iso')->values();
                @endphp

                <!-- Bar Filter Kalender Tanggal Rekam Medis -->
                <div class="px-4 sm:px-6 py-3 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700/80 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-700 dark:text-gray-200">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <span>Filter Tanggal:</span>
                        </div>

                        <!-- Input Kalender Terbuka / Picker -->
                        <div class="relative inline-flex items-center">
                            <input
                                type="date"
                                id="rekam-medis-calendar-input"
                                name="filter_date"
                                value="{{ $filterDate ?? request('filter_date', '') }}"
                                onchange="applyRekamMedisDateFilter(this.value)"
                                class="ps-9 pe-3 py-1.5 text-xs font-semibold bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 cursor-pointer shadow-2xs hover:border-gray-400 dark:hover:border-gray-500 transition"
                            >
                            <div class="absolute inset-y-0 start-0 flex items-center ps-2.5 pointer-events-none text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="openCalendarPicker()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl transition shadow-2xs cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Buka Kalender</span>
                        </button>

                        <!-- Quick filter chips tanggal yang memiliki data -->
                        @if ($uniqueDates->isNotEmpty())
                            <div class="hidden sm:flex items-center gap-1.5 ps-1 border-s border-gray-200 dark:border-gray-700">
                                <span class="text-[11px] text-gray-400 font-medium">Tersedia:</span>
                                @foreach ($uniqueDates->take(3) as $ud)
                                    <button
                                        type="button"
                                        onclick="document.getElementById('rekam-medis-calendar-input').value = '{{ $ud['iso'] }}'; applyRekamMedisDateFilter('{{ $ud['iso'] }}');"
                                        class="px-2.5 py-1 text-[11px] font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition cursor-pointer"
                                    >
                                        {{ $ud['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <!-- Tombol Reset Filter -->
                        <button
                            type="button"
                            id="reset-filter-rekam-medis"
                            onclick="resetRekamMedisDateFilter(event)"
                            class="{{ empty($filterDate) ? 'hidden' : 'inline-flex' }} items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/50 dark:text-rose-300 rounded-xl border border-rose-200 dark:border-rose-800 transition cursor-pointer"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>Semua Tanggal</span>
                        </button>
                    </div>

                    <!-- Right: Keterangan Hasil Pencarian Tanggal -->
                    <div id="filter-status-info" class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 shrink-0">
                        @if (!empty($filterDate))
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200/80 px-2.5 py-1 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Kalender: {{ \Carbon\Carbon::parse($filterDate)->translatedFormat('d F Y') }}</span>
                            </span>
                        @else
                            <span class="text-[11px] text-gray-400 dark:text-gray-500">Semua riwayat rekam medis ditampilkan</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 sm:p-5 sm:p-6 bg-gray-50/60 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 gap-5" id="rekam-medis-cards-container">
                        {{-- 1. REKAM MEDIS DARI LAPORAN KESEHATAN SELESAI --}}
                        @if (isset($completedReports) && $completedReports->isNotEmpty())
                            @foreach ($completedReports as $report)
                                @php
                                    $vet = $report->assignedVeterinarian;
                                    $doctorName = $vet?->name ?? 'drh. Dokter Hewan Dinas';
                                    $doctorInitials = $vet?->initials ?? 'DR';
                                    $doctorSpec = $vet?->specialization ?? 'Dokter Hewan Terverifikasi Disnak';
                                    $doctorPuskeswan = $vet?->puskeswan ?? 'Puskeswan Disnak Jatim';
                                    $reportDateObj = $report->resolved_at
                                        ? \Carbon\Carbon::parse($report->resolved_at)
                                        : $report->updated_at;
                                    $dateIso = $reportDateObj->toDateString();
                                    $dateFormatted = $reportDateObj->translatedFormat('d F Y');
                                    $timeFormatted = $report->resolved_at
                                        ? $report->resolved_at->format('H:i') . ' WIB'
                                        : $report->updated_at->format('H:i') . ' WIB';

                                    $latestVisit = $report->latestVisit;
                                    $latestResponse =
                                        $report->responses->where('user.role', '!=', 'peternak')->last() ??
                                        $report->responses->last();
                                    $diagnosis =
                                        $latestVisit?->examination_notes ?:
                                        ($latestResponse?->hypothesis ?:
                                        'Evaluasi klinis tuntas tercatat pada rekam riwayat penanganan laporan dinas.');
                                    $treatment =
                                        $latestVisit?->post_visit_recommendations ?:
                                        ($latestResponse?->recommendations ?:
                                        ($latestResponse?->message ?:
                                        'Perawatan pemulihan dan pemantauan kondisi ternak.'));
                                @endphp
                                <div
                                    class="rekam-medis-card bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group relative"
                                    data-record-date="{{ $dateIso }}">
                                    <div class="space-y-4">
                                        <!-- 1. Card Top Bar: No. Laporan -->
                                        <div
                                            class="flex items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-700/60">
                                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-xs text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/80 dark:border-primary-800/60 px-2.5 py-1 rounded-lg shrink-0">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>{{ $report->report_number }}</span>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- 2. Doctor Profile Section -->
                                        <div class="flex items-center gap-3.5 pt-0.5">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-base flex items-center justify-center shadow-xs shrink-0 ring-2 ring-emerald-500/10">
                                                {{ $doctorInitials }}
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3
                                                    class="text-base font-bold text-gray-900 dark:text-white leading-snug tracking-tight">
                                                    {{ $doctorName }}
                                                </h3>
                                                <div class="mt-1 flex items-center gap-1.5">
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-md leading-normal">
                                                        <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $doctorSpec }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 3. Info Puskeswan, Jam Layanan & Jenis (Dibuat Memanjang & Semua Tulisan Terlihat) -->
                                        <div
                                            class="p-3.5 bg-gray-50/80 dark:bg-gray-750/50 rounded-xl border border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-gray-600 dark:text-gray-300">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                    fill="none" stroke="currentColor" stroke-width="1.8"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span
                                                    class="font-medium text-gray-700 dark:text-gray-200 leading-normal">
                                                    {{ $doctorPuskeswan }} • {{ $report->kabupaten ?: 'Jawa Timur' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-3 shrink-0">
                                                <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap">
                                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                                                        stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{ $dateFormatted }} • {{ $timeFormatted }}</span>
                                                </div>
                                                <span
                                                    class="text-[10px] font-semibold text-emerald-700 dark:text-emerald-400 uppercase bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded border border-emerald-200/70 dark:border-emerald-800 whitespace-nowrap shrink-0">
                                                    Laporan Kesehatan
                                                </span>
                                            </div>
                                        </div>

                                        <!-- 4. Detail Keluhan & Hasil Diagnosa -->
                                        <div class="space-y-3 text-xs">
                                            <div class="space-y-1">
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Keluhan
                                                    Klinis Awal:</span>
                                                <h4 class="text-sm font-bold text-gray-900 dark:text-white leading-normal">
                                                    {{ $report->symptoms }}
                                                </h4>
                                                @if ($report->symptoms_started_at)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        Gejala sejak:
                                                        {{ \Carbon\Carbon::parse($report->symptoms_started_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                                <div
                                                    class="p-3.5 bg-blue-50/70 dark:bg-blue-950/40 rounded-xl border border-blue-100 dark:border-blue-900/50 text-xs">
                                                    <span
                                                        class="font-bold text-primary-700 dark:text-primary-300 block mb-1">Diagnosa
                                                        / Hasil Penanganan:</span>
                                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                        {{ $diagnosis }}</p>
                                                </div>
                                                <div
                                                    class="p-3.5 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-xl border border-emerald-100 dark:border-emerald-900/50 text-xs">
                                                    <span
                                                        class="font-bold text-emerald-800 dark:text-emerald-300 block mb-1">Resep
                                                        &amp; Rekomendasi Dokter:</span>
                                                    <p
                                                        class="text-emerald-950 dark:text-emerald-200 font-semibold leading-relaxed">
                                                        {{ $treatment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Card Action Buttons: WhatsApp & Download PDF -->
                                    <div class="mt-5 pt-3.5 border-t border-gray-100 dark:border-gray-700/60">
                                        <div class="flex flex-wrap items-center justify-end gap-2.5">
                                            @php
                                                $vetPhone = $vet?->phone_number ?? '081234567890';
                                                $waNum = preg_replace(
                                                    '/^0/',
                                                    '62',
                                                    preg_replace('/[^0-9]/', '', $vetPhone),
                                                );
                                                $waText = urlencode(
                                                    'Halo Dokter ' .
                                                        ($vet?->name ?? 'Dinas') .
                                                        ', saya ingin konsultasi mengenai hasil rekam medis laporan: ' .
                                                        $report->report_number,
                                                );
                                            @endphp
                                            <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800/60 py-2.5 px-3.5 rounded-xl transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                                </svg>
                                                <span>WhatsApp</span>
                                            </a>
                                            <a href="{{ route('konsultasi.rekam-medis.download', ['type' => 'report', 'id' => $report->id]) }}"
                                                target="_blank"
                                                title="Download Hasil Rekam Medis & Cara Penanganan Ternak (Format PDF / Dokumen Resmi)"
                                                class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 py-2.5 px-4 rounded-xl transition shadow-xs hover:shadow-sm cursor-pointer group">
                                                <svg class="w-3.5 h-3.5 shrink-0 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                <span>Download PDF</span>
                                                <span class="sr-only">Download Hasil Rekam Medis (PDF)</span>
                                            </a>
                                            @php
                                                $detailRoute = auth()->user()?->isDokterHewan()
                                                    ? route('dokter-hewan.show', $report)
                                                    : route('kesehatan-hewan.show', $report);
                                            @endphp
                                            <a href="{{ $detailRoute }}" title="Lihat Detail Riwayat Laporan"
                                                class="inline-flex items-center justify-center text-xs font-semibold text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 py-2.5 px-3.5 rounded-xl transition">
                                                <span>Detail</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- 2. REKAM MEDIS DARI RESERVASI KONSULTASI --}}
                        @forelse($myBookings as $booking)
                            @php
                                $doctorMsg = $booking->messages->first(
                                    fn($m) => $m->sender?->isDokterHewan() || $m->sender?->isAdmin(),
                                );
                                $status = strtolower($booking->status);
                                $badgeClasses = match ($status) {
                                    'selesai',
                                    'answered'
                                        => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
                                    'dikonfirmasi',
                                    'terjadwal'
                                        => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
                                    'dibatalkan'
                                        => 'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
                                    default
                                        => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
                                };
                                $label = match ($status) {
                                    'selesai', 'answered' => 'Selesai Ditangani',
                                    'dikonfirmasi' => 'Dikonfirmasi Dokter',
                                    'terjadwal' => 'Jadwal Terkunci',
                                    'dibatalkan' => 'Dibatalkan',
                                    default => 'Menunggu Sesi',
                                };
                                $bookingDateObj = $booking->schedule
                                    ? \Carbon\Carbon::parse($booking->schedule->date)
                                    : ($booking->consultation_date
                                        ? \Carbon\Carbon::parse($booking->consultation_date)
                                        : $booking->created_at);
                                $dateIso = $bookingDateObj->toDateString();
                                $dateFormatted = $bookingDateObj->translatedFormat('d F Y');
                                $timeFormatted =
                                    $booking->schedule?->time_label ?? $booking->created_at->format('H:i') . ' WIB';
                            @endphp
                            <div
                                class="rekam-medis-card bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group relative"
                                data-record-date="{{ $dateIso }}">
                                <div class="space-y-4">
                                    <!-- 1. Card Top Bar: E-Tag / Kategori Ternak -->
                                    <div
                                        class="flex items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-700/60">
                                        <div class="flex items-center gap-2 min-w-0 flex-1">
                                            @if ($booking->livestock)
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-xs text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/80 dark:border-primary-800/60 px-2.5 py-1 rounded-lg shrink-0">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-600"></span>
                                                    <span>ETAG:
                                                        {{ $booking->livestock->tag_number ?? ($booking->livestock->e_tag_number ?? '-') }}</span>
                                                </span>
                                                <span
                                                    class="font-sans font-semibold text-xs text-gray-700 dark:text-gray-300">
                                                    ({{ $booking->livestock->name ?? ($booking->livestock->breed ?? 'Ternak') }})
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-lg">
                                                    Konsultasi Umum
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- 2. Doctor Profile Section: Nama Dokter Dibuat Memanjang & Tidak Tertimpa -->
                                    <div class="flex items-center gap-3.5 pt-0.5">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-base flex items-center justify-center shadow-xs shrink-0 ring-2 ring-emerald-500/10">
                                            {{ $booking->veterinarian?->initials ?? 'RM' }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3
                                                class="text-base font-bold text-gray-900 dark:text-white leading-snug tracking-tight">
                                                {{ $booking->veterinarian?->name ?? 'drh. Dokter Hewan Dinas' }}
                                            </h3>
                                            <div class="mt-1 flex items-center gap-1.5">
                                                <span
                                                    class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-md leading-normal">
                                                    <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span>{{ $booking->veterinarian?->specialization ?? 'Dokter Hewan Terverifikasi Disnak' }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Info Puskeswan, Jam Layanan & Jenis Konsultasi (Dibuat Memanjang & Semua Tulisan Terlihat) -->
                                    <div
                                        class="p-3.5 bg-gray-50/80 dark:bg-gray-750/50 rounded-xl border border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                fill="none" stroke="currentColor" stroke-width="1.8"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <span
                                                class="font-medium text-gray-700 dark:text-gray-200 leading-normal">
                                                {{ $booking->veterinarian?->puskeswan ?? 'Puskeswan Disnak Jatim' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 shrink-0">
                                            <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap">
                                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                                                    stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $dateFormatted }} • {{ $timeFormatted }}</span>
                                            </div>
                                            <span
                                                class="text-[10px] font-semibold text-gray-500 dark:text-gray-400 capitalize bg-white dark:bg-gray-700 px-2.5 py-0.5 rounded border border-gray-200/70 dark:border-gray-600 whitespace-nowrap shrink-0">
                                                {{ str_replace('_', ' ', $booking->consultation_type ?? 'telemedisin') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- 4. Detail Topik Pemeriksaan & Hasil Diagnosa (Jarak Tertata Lega) -->
                                    <div class="space-y-3 text-xs">
                                        <div class="space-y-1">
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Topik
                                                Pemeriksaan:</span>
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white leading-normal">
                                                {{ $booking->subject }}
                                            </h4>
                                            @if ($booking->complaint_details)
                                                <p
                                                    class="text-xs text-gray-600 dark:text-gray-300 mt-1 line-clamp-2 leading-relaxed">
                                                    {{ $booking->complaint_details }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Diagnosa Medis & Resep Dokter: Jarak Rapi & Tidak Saling Bertumpuk -->
                                        @if ($booking->doctor_notes || $booking->prescription)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                                @if ($booking->doctor_notes)
                                                    <div
                                                        class="p-3.5 bg-blue-50/70 dark:bg-blue-950/40 rounded-xl border border-blue-100 dark:border-blue-900/50 text-xs">
                                                        <span
                                                            class="font-bold text-primary-700 dark:text-primary-300 block mb-1">Diagnosa
                                                            Medis:</span>
                                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                            {{ $booking->doctor_notes }}</p>
                                                    </div>
                                                @endif
                                                @if ($booking->prescription)
                                                    <div
                                                        class="p-3.5 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-xl border border-emerald-100 dark:border-emerald-900/50 text-xs">
                                                        <span
                                                            class="font-bold text-emerald-800 dark:text-emerald-300 block mb-1">Resep
                                                            &amp; Terapi:</span>
                                                        <p
                                                            class="text-emerald-950 dark:text-emerald-200 font-semibold leading-relaxed">
                                                            {{ $booking->prescription }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($doctorMsg)
                                            <div
                                                class="p-3 bg-gray-50 dark:bg-gray-750/50 rounded-xl border border-gray-100 dark:border-gray-700 text-xs">
                                                <span
                                                    class="font-bold text-gray-700 dark:text-gray-300 block mb-1">Tanggapan
                                                    Dokter:</span>
                                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                                    {{ $doctorMsg->message }}</p>
                                            </div>
                                        @else
                                            <div
                                                class="p-3 bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 text-center text-xs text-gray-500 dark:text-gray-400">
                                                <span>Menunggu hasil diagnosa resmi dari dokter dinas.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 5. Card Action Buttons: WhatsApp & Download PDF -->
                                <div class="mt-5 pt-3.5 border-t border-gray-100 dark:border-gray-700/60">
                                    <div class="flex flex-wrap items-center justify-end gap-2.5">
                                        @php
                                            $vetPhone = $booking->veterinarian?->phone_number ?? '081234567890';
                                            $waNum = preg_replace(
                                                '/^0/',
                                                '62',
                                                preg_replace('/[^0-9]/', '', $vetPhone),
                                            );
                                            $waText = urlencode(
                                                'Halo Dokter ' .
                                                    ($booking->veterinarian?->name ?? 'Dinas') .
                                                    ', saya ingin konsultasi mengenai hasil rekam medis ternak untuk keluhan: ' .
                                                    $booking->subject,
                                            );
                                        @endphp
                                        <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800/60 py-2.5 px-3.5 rounded-xl transition shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                            <span>WhatsApp</span>
                                        </a>
                                        <a href="{{ route('konsultasi.rekam-medis.download', ['type' => 'consultation', 'id' => $booking->id]) }}"
                                            target="_blank"
                                            title="Download Hasil Rekam Medis & Cara Penanganan Ternak (Format PDF / Dokumen Resmi)"
                                            class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 py-2.5 px-4 rounded-xl transition shadow-xs hover:shadow-sm cursor-pointer group">
                                            <svg class="w-3.5 h-3.5 shrink-0 group-hover:scale-110 transition-transform"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            <span>Download PDF</span>
                                            <span class="sr-only">Download Hasil Rekam Medis (PDF)</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                        <!-- Empty State Jika Filter Kalender Tidak Menemukan Data -->
                        <div id="filter-empty-state" class="hidden col-span-full py-12 px-4 text-center bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                            <div class="max-w-sm mx-auto space-y-3">
                                <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Tidak Ada Rekam Medis Pada Tanggal Ini</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400" id="filter-empty-message">Tidak ditemukan data rekam medis pada tanggal yang dipilih. Silakan pilih tanggal lain pada kalender atau klik tombol di bawah.</p>
                                <div class="pt-1">
                                    <button type="button" onclick="resetRekamMedisDateFilter(event)" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 rounded-xl transition cursor-pointer">
                                        Tampilkan Semua Data
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Empty State (if both completedReports and myBookings are empty) --}}
                        @if ((!isset($completedReports) || $completedReports->isEmpty()) && $myBookings->isEmpty())
                            <div
                                class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-6">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-950/60 text-primary-600 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum Ada Riwayat Rekam
                                        Medis</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Jadwalkan konsultasi atau ajukan
                                        laporan kesehatan hewan dinas untuk mendapatkan pemeriksaan, resep obat, dan lembar
                                        rekam medis resmi.</p>
                                    <div class="flex items-center justify-center gap-2 pt-1 flex-wrap">
                                        <a href="{{ route('kesehatan-hewan.create') }}"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 px-3.5 py-2 rounded-lg transition shadow-2xs">
                                            Lapor Kesehatan Hewan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: BUKU REKAM MEDIS DIGITAL & E-TAGGING -->
            <div class="pt-2 space-y-6">

                @if (auth()->check() && auth()->user()->isAdmin())
                    <!-- Form Catat Rekam Medis (Admin / Dokter Dinas Only - Collapsible) -->
                    <div id="form-rekam-medis"
                        class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
                        <div
                            class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <span>Formulir Catat Rekam Medis</span>
                                    <span
                                        class="text-[10px] font-semibold bg-primary-100 text-primary-800 dark:bg-primary-950 dark:text-primary-300 px-2 py-0.5 rounded">Petugas
                                        Medis Disnak</span>
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pencatatan riwayat tindakan medis,
                                    vaksinasi berkala, atau inseminasi buatan.</p>
                            </div>
                            <button type="button"
                                onclick="document.getElementById('form-rekam-medis').classList.add('hidden')"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-semibold">Tutup
                                ✕</button>
                        </div>

                        <form action="{{ route('konsultasi.health-record.store') }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                            @csrf
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Ternak
                                    (E-Tag) <span class="text-red-500">*</span></label>
                                <select name="livestock_id" required
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                    @foreach ($livestocks as $ls)
                                        <option value="{{ $ls->id }}">{{ $ls->tag_number ?? $ls->e_tag_number }} —
                                            {{ $ls->name ?? $ls->breed }} ({{ ucfirst($ls->gender) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kategori Tindakan
                                    <span class="text-red-500">*</span></label>
                                <select name="record_type" required
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white font-medium">
                                    <option value="vaksinasi">Vaksinasi (PMK, LSD, Anthrax)</option>
                                    <option value="pengobatan">Pengobatan &amp; Terapi</option>
                                    <option value="inseminasi_buatan">Inseminasi Buatan (IB)</option>
                                    <option value="pemeriksaan">Pemeriksaan Rutin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                    Pemeriksaan <span class="text-red-500">*</span></label>
                                <input type="date" name="record_date" required value="{{ date('Y-m-d') }}"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Tindakan /
                                    Diagnosa Utama <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required
                                    placeholder="Contoh: Pemeriksaan Lesu & Demam Pasca Laktasi / PMK Booster 2"
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Detail Diagnosis
                                    Klinis</label>
                                <input type="text" name="diagnosis"
                                    placeholder="Contoh: Kelelahan produksi laktasi dan radang ringan..."
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Tindakan / Resep
                                    Obat &amp; Dosis</label>
                                <input type="text" name="treatment"
                                    placeholder="Contoh: Antipiretik + Vitamin B kompleks 10ml IM..."
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Anjuran &amp;
                                    Petunjuk untuk Peternak di Kandang</label>
                                <input type="text" name="notes"
                                    placeholder="Contoh: Berikan pakan hijauan segar & air bersih secukupnya. Pantau suhu badan selama 3 hari."
                                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div
                                class="md:col-span-3 flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                <button type="button"
                                    onclick="document.getElementById('form-rekam-medis').classList.add('hidden')"
                                    class="px-3.5 py-2 rounded-lg text-xs text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                                    Simpan ke Rekam Medis Ternak
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Form Registrasi E-Tag Baru (Collapsible) -->
                <div id="form-etag"
                    class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
                    <div
                        class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span>Pendaftaran E-Tag Ternak Baru</span>
                                <span
                                    class="text-[10px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 px-2 py-0.5 rounded">Identitas
                                    Resmi Dinas</span>
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan kode anting barcode telinga untuk
                                mencatat identitas ternak.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-semibold">Tutup
                            ✕</button>
                    </div>

                    <form action="{{ route('konsultasi.livestock.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
                        @csrf
                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Anting E-Tag
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="tag_number" required placeholder="Contoh: JTM-PAS-0045"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white uppercase font-mono font-bold">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Jenis Ternak <span
                                    class="text-red-500">*</span></label>
                            <select name="livestock_type"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                <option value="sapi_perah">Sapi Perah (FH)</option>
                                <option value="sapi_potong">Sapi Potong (Limousin/Simental/PO)</option>
                                <option value="kambing">Kambing (Senduro/PE)</option>
                                <option value="domba">Domba (Sapudi/Garut)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Panggilan /
                                Bangsa <span class="text-red-500">*</span></label>
                            <input type="text" name="breed" required
                                placeholder="Contoh: Melati / Friesian Holstein"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Kelamin &amp;
                                Perkiraan Lahir <span class="text-red-500">*</span></label>
                            <div class="flex gap-1.5">
                                <select name="gender"
                                    class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                                    <option value="betina">Betina</option>
                                    <option value="jantan">Jantan</option>
                                </select>
                                <input type="date" name="birth_date" required
                                    value="{{ date('Y-m-d', strtotime('-2 years')) }}"
                                    class="w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                        </div>
                        <div
                            class="md:col-span-4 flex justify-end gap-2 pt-1 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" onclick="document.getElementById('form-etag').classList.add('hidden')"
                                class="px-3.5 py-2 rounded-lg text-xs text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                                Daftarkan E-Tag Baru
                            </button>
                        </div>
                    </form>
                </div>

            </div>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 3: PEDOMAN PENYAKIT HEWAN MENULAR                     --}}
    {{-- ======================================================== --}}
    @if ($activeTab === 'penyakit')
        <!-- Executive KPI Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
            <!-- KPI 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Katalog Penyakit Terdata</span>
                    <span class="p-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
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
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
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
                    <span
                        class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
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

        @if (auth()->check() && auth()->user()->isAdmin())
            <!-- Form Tambah Penyakit (Admin Only - Collapsible) -->
            <div id="form-tambah-penyakit"
                class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tambah Data Penyakit Hewan</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pedoman diagnosis klinis dan SOP penanganan
                            veteriner.</p>
                    </div>
                    <button type="button"
                        onclick="document.getElementById('form-tambah-penyakit').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
                </div>

                <form action="{{ route('konsultasi.diseases.store') }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    @csrf
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penyakit <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Bovine Ephemeral Fever (BEF)"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori / Vektor <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="category" required
                            placeholder="Contoh: Penyakit Menular / Vektor Serangga"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Gejala Klinis <span
                                class="text-red-500">*</span></label>
                        <textarea name="symptoms" rows="2" required
                            placeholder="Demam tinggi, tremor otot, kepincangan, air liur berlebih..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Langkah Pencegahan &amp;
                            Biosekuriti</label>
                        <textarea name="prevention_steps" rows="2"
                            placeholder="Vaksinasi berkala, pengendalian vektor serangga, sanitasi kandang..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pertolongan Pertama /
                            Pengobatan</label>
                        <textarea name="treatment_first_aid" rows="2"
                            placeholder="Isolasi ternak, pemberian antipiretik, vitamin B kompleks..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
                    </div>
                    <div class="md:col-span-2 flex justify-end gap-2 pt-1">
                        <button type="submit"
                            class="bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2 px-4 rounded-lg shadow-xs transition">
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
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Pedoman &amp; Basis Data Penyakit Hewan
                        Menular</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pedoman diagnosis dini veteriner Jawa
                        Timur.</p>
                </div>
                <span
                    class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    {{ $diseases->count() }} Penyakit
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
                @forelse ($diseases as $disease)
                    <div
                        class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <h3 class="font-bold text-gray-900 dark:text-white text-sm">
                                    {{ $disease->name }}
                                </h3>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <span
                                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-primary-700 dark:bg-blue-950/60 dark:text-primary-300">
                                        {{ $disease->category }}
                                    </span>
                                    @if (auth()->check() && auth()->user()->isAdmin())
                                        <form action="{{ route('konsultasi.diseases.destroy', $disease) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus info penyakit {{ $disease->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 p-0.5 transition"
                                                title="Hapus Penyakit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-2 mt-2.5">
                                <div
                                    class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                                    <span class="font-bold text-gray-900 dark:text-white block mb-0.5">Gejala
                                        Klinis:</span>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {{ $disease->symptoms }}</p>
                                </div>

                                @if ($disease->prevention_steps)
                                    <div
                                        class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                                        <span
                                            class="font-bold text-gray-900 dark:text-white block mb-0.5">Pencegahan:</span>
                                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                            {{ $disease->prevention_steps }}</p>
                                    </div>
                                @endif

                                @if ($disease->treatment_first_aid)
                                    <div
                                        class="bg-white dark:bg-gray-800 p-2.5 rounded-lg border border-gray-200/60 dark:border-gray-700/60">
                                        <span class="font-bold text-gray-900 dark:text-white block mb-0.5">Pertolongan
                                            Pertama:</span>
                                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                            {{ $disease->treatment_first_aid }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-6 text-gray-400">Belum ada pedoman penyakit tersimpan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Banner Pelaporan Kasus Kesehatan Ternak -->
        <div
            class="p-4 sm:p-5 rounded-xl border border-primary-200 dark:border-primary-900/60 bg-primary-50/70 dark:bg-primary-950/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-start gap-3">
                <div
                    class="w-9 h-9 rounded-lg bg-primary-100 dark:bg-primary-900/60 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-primary-900 dark:text-primary-200">Ternak Mengalami
                        Gejala Sakit atau Penyakit Menular?</h4>
                    <p class="text-xs text-primary-700 dark:text-primary-400 mt-0.5 leading-relaxed">
                        Segera lakukan karantina mandiri dan kirim laporan pemeriksaan klinis langsung ke Dokter Hewan
                        Dinas Jawa Timur.
                    </p>
                </div>
            </div>
            <a href="{{ route('kesehatan-hewan.create') }}"
                class="inline-flex items-center justify-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-4 py-2 rounded-lg transition shadow-xs shrink-0">
                Lapor Kesehatan Ternak &rarr;
            </a>
        </div>
    @endif


    @if (auth()->check() && auth()->user()->isAdmin())
        <!-- Modal Tambah Dokter Hewan (Admin) -->
        <div id="modal-tambah-dokter"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Dokter Hewan Baru</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftarkan dokter hewan resmi untuk
                            pelayanan telemedisin peternak.</p>
                    </div>
                    <button type="button"
                        onclick="document.getElementById('modal-tambah-dokter').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
                </div>

                <form action="{{ route('konsultasi.veterinarians.store') }}" method="POST"
                    class="mt-4 space-y-3.5 text-xs">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp;
                                Gelar <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="Contoh: drh. Rahmat Hidayat, M.Si"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Spesialisasi /
                                Keahlian <span class="text-red-500">*</span></label>
                            <input type="text" name="specialization" required
                                placeholder="Contoh: Spesialis Ruminansia Besar & Bedah"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Tugas /
                                Puskeswan <span class="text-red-500">*</span></label>
                            <input type="text" name="puskeswan" required
                                placeholder="Contoh: Puskeswan Pandaan, Kab. Pasuruan"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor STRV /
                                SIP</label>
                            <input type="text" name="strv_number" placeholder="Contoh: STRV-35.14.2025.099"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon /
                                WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="phone_number" required placeholder="Contoh: 081234567890"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Dinas</label>
                            <input type="email" name="email" placeholder="Contoh: rahmat@disnak.jatimprov.go.id"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan
                                Konsultasi</label>
                            <input type="text" name="consultation_hours" value="08.00 - 16.00 WIB"
                                placeholder="Contoh: 08.00 - 16.00 WIB"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ketersediaan
                                <span class="text-red-500">*</span></label>
                            <select name="status" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                <option value="online">Online (Siaga Telemedisin)</option>
                                <option value="praktik_lapangan">Praktik Lapangan</option>
                                <option value="siaga">Siaga Panggilan Darurat</option>
                                <option value="offline">Sedang Istirahat</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <button type="button"
                            onclick="document.getElementById('modal-tambah-dokter').classList.add('hidden')"
                            class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs">
                            + Daftarkan Dokter Hewan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Dokter Hewan (Admin) -->
        <div id="modal-edit-dokter"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Data Dokter Hewan</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi tugas atau status
                            ketersediaan dokter hewan.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('modal-edit-dokter').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
                </div>

                <form id="form-edit-vet" method="POST" class="mt-4 space-y-3.5 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp;
                                Gelar <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-vet-name" name="name" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Spesialisasi /
                                Keahlian <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-vet-specialization" name="specialization" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Tugas /
                                Puskeswan <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-vet-puskeswan" name="puskeswan" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor STRV /
                                SIP</label>
                            <input type="text" id="edit-vet-strv" name="strv_number"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon /
                                WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-vet-phone" name="phone_number" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Dinas</label>
                            <input type="email" id="edit-vet-email" name="email"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan
                                Konsultasi</label>
                            <input type="text" id="edit-vet-hours" name="consultation_hours"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ketersediaan
                                <span class="text-red-500">*</span></label>
                            <select id="edit-vet-status" name="status" required
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                <option value="online">Online (Siaga Telemedisin)</option>
                                <option value="praktik_lapangan">Praktik Lapangan</option>
                                <option value="siaga">Siaga Panggilan Darurat</option>
                                <option value="offline">Sedang Istirahat</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <button type="button"
                            onclick="document.getElementById('modal-edit-dokter').classList.add('hidden')"
                            class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs">
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



    <!-- MODAL DETAIL LEMBAR REKAM MEDIS & PETUNJUK PENANGANAN -->
    <div id="modal-official-record"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-xs">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[92vh] overflow-y-auto relative space-y-4">
            <!-- Header Modal -->
            <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-950/70 text-primary-700 dark:text-primary-300 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Lembar Rekam Medis Resmi</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pusat Kesehatan Hewan &amp; Layanan Veteriner
                            Dinas Peternakan Prov. Jatim</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modal-official-record').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg">✕</button>
            </div>

            <!-- Info Ternak & Tanggal -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-gray-50 dark:bg-gray-750/50 p-3.5 rounded-xl border border-gray-200/80 dark:border-gray-700">
                <div>
                    <span class="text-gray-500 dark:text-gray-400 block text-[11px]">Identitas Ternak Pasien:</span>
                    <div class="font-bold text-gray-900 dark:text-white text-xs mt-0.5" id="modal-record-livestock">-
                    </div>
                    <span class="inline-block font-mono text-[11px] font-bold text-primary-700 dark:text-primary-300 mt-1"
                        id="modal-record-tag">-</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400 block text-[11px]">Tanggal &amp; Dokter Pemeriksa:</span>
                    <div class="font-bold text-gray-900 dark:text-white text-xs mt-0.5" id="modal-record-date">-</div>
                    <div class="text-[11px] text-gray-600 dark:text-gray-300 mt-1" id="modal-record-doctor">-</div>
                </div>
            </div>

            <!-- Diagnosa & Judul -->
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 block mb-1">Tindakan / Diagnosa
                        Utama:</span>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white" id="modal-record-title">-</h4>
                </div>

                <div
                    class="p-3 bg-blue-50/70 dark:bg-blue-950/40 rounded-xl border border-blue-200 dark:border-blue-900/60">
                    <span class="font-bold text-blue-900 dark:text-blue-300 block text-xs mb-1">Hasil Diagnosa
                        Klinis:</span>
                    <p class="text-gray-800 dark:text-gray-200 leading-relaxed" id="modal-record-diagnosis">-</p>
                </div>

                <div
                    class="p-3 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800/60">
                    <span class="font-bold text-emerald-900 dark:text-emerald-300 block text-xs mb-1">Resep Obat &amp;
                        Terapi Medis:</span>
                    <p class="text-emerald-950 dark:text-emerald-200 font-medium leading-relaxed"
                        id="modal-record-treatment">-</p>
                </div>

                <div
                    class="p-3 bg-amber-50/70 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800/60">
                    <span class="font-bold text-amber-900 dark:text-amber-300 block text-xs mb-1">Petunjuk Penanganan untuk
                        Peternak di Kandang:</span>
                    <p class="text-amber-950 dark:text-amber-200 leading-relaxed" id="modal-record-notes">-</p>
                </div>
            </div>

            <!-- Action Footer Modal -->
            <div
                class="flex flex-wrap items-center justify-between gap-3 pt-3.5 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-official-record').classList.add('hidden')"
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition cursor-pointer">
                    Tutup
                </button>
                <a id="modal-record-download-btn" href="#" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-primary-700 hover:bg-primary-800 transition shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Download Hasil Rekam Medis (PDF)</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function openOfficialRecordModal(record) {
            const modal = document.getElementById('modal-official-record');
            if (!modal) return;

            const ls = record.livestock || {};
            const lsName = ls.name || ls.breed || 'Ternak';
            const lsTag = ls.tag_number || ls.e_tag_number || '-';
            const vetName = record.veterinarian ? (record.veterinarian.name || 'drh. Dokter Hewan Dinas') :
                'drh. Dokter Hewan Dinas';

            document.getElementById('modal-record-livestock').textContent = lsName;
            document.getElementById('modal-record-tag').textContent = 'E-Tag: ' + lsTag;
            document.getElementById('modal-record-date').textContent = record.record_date || '-';
            document.getElementById('modal-record-doctor').textContent = vetName + ' (Puskeswan Disnak Jatim)';
            document.getElementById('modal-record-title').textContent = record.title || '-';
            document.getElementById('modal-record-diagnosis').textContent = record.diagnosis ||
                'Pemeriksaan fisik telah dilakukan sesuai protokol dinas.';
            document.getElementById('modal-record-treatment').textContent = record.treatment ||
                'Pemberian multivitamin & perawatan rutin.';
            document.getElementById('modal-record-notes').textContent = record.notes ||
                'Tempatkan ternak pada kandang yang bersih dan kering, berikan hijauan segar yang sudah dilayukan dan dicacah, sediakan air minum bersih dan larutan molase hangat secukupnya, serta pantau suhu ternak 2x sehari.';

            const downloadBtn = document.getElementById('modal-record-download-btn');
            if (downloadBtn) {
                downloadBtn.href = '/konsultasi/rekam-medis/record/' + record.id + '/dokumen';
            }

            modal.classList.remove('hidden');
        }

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
                        slotSelect.innerHTML =
                            '<option value="">(Tidak ada slot jam layanan dibuka pada tanggal ini)</option>';

                        if (data.available_dates && data.available_dates.length > 0) {
                            if (autoSwitchIfEmpty && !data.available_dates.includes(date)) {
                                dateInput.value = data.available_dates[0];
                                loadDoctorAvailableSlots(false);
                                return;
                            }

                            let dateButtons = data.available_dates.map(d => {
                                const parts = d.split('-');
                                const formatted = parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` :
                                    d;
                                return `<button type="button" onclick="selectBookingDate('${d}')" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-primary-700 bg-primary-100 hover:bg-primary-200 dark:bg-primary-950 dark:text-primary-300 rounded-lg border border-primary-300 transition my-0.5">${formatted}</button>`;
                            }).join(' ');

                            helperText.innerHTML =
                                `Dokter belum membuka layanan pada tanggal yang dipilih.<br><span class="font-bold text-gray-700 dark:text-gray-200">Pilih tanggal dokter yang tersedia:</span><div class="mt-1 flex flex-wrap gap-1">${dateButtons}</div>`;
                            helperText.className = 'text-[11px] text-amber-700 dark:text-amber-300 mt-1.5';
                        } else {
                            helperText.innerText =
                                'Dokter ini belum membuka slot jam layanan. Silakan pilih dokter hewan lain.';
                            helperText.className = 'text-[11px] text-amber-600 font-medium mt-1';
                        }
                        return;
                    }

                    helperText.innerText =
                        'Setiap jam memiliki batas kuota pasien. Silakan pilih jam dengan kuota tersedia.';
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
                            opt.innerText =
                                `${slot.time_label} — [KUOTA PENUH (${slot.booked_count}/${slot.quota})]`;
                        } else {
                            availableCount++;
                            opt.innerText =
                                `${slot.time_label} — Tersedia Kuota: ${slot.remaining_quota} Pasien`;
                        }
                        slotSelect.appendChild(opt);
                    });

                    if (availableCount === 0) {
                        helperText.innerText =
                            'Semua slot jam layanan pada tanggal ini sudah penuh. Silakan pilih tanggal lain.';
                        helperText.className = 'text-[11px] text-rose-600 font-medium mt-1';
                    }
                })
                .catch(err => {
                    loadingIndicator.classList.add('hidden');
                    slotSelect.disabled = false;
                    slotSelect.innerHTML = '<option value="">Gagal memuat jadwal. Coba lagi nanti.</option>';
                });
        }

        function switchSubTab(tabName, pushHistory = true) {
            const dokterBtn = document.getElementById('tab-btn-dokter');
            const jadwalBtn = document.getElementById('tab-btn-jadwal');
            const dokterContent = document.getElementById('tab-content-dokter');
            const jadwalContent = document.getElementById('tab-content-jadwal');
            const pageTitle = document.getElementById('konsultasi-page-title');
            const pageDesc = document.getElementById('konsultasi-page-desc');
            const actionJadwalBtn = document.getElementById('header-action-jadwal-btn');

            const activeClasses = ['bg-primary-700', 'text-white', 'shadow-xs'];
            const inactiveClasses = ['text-gray-600', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white',
                'hover:bg-gray-100', 'dark:hover:bg-gray-800'
            ];

            if (tabName === 'dokter') {
                if (dokterContent) dokterContent.classList.remove('hidden');
                if (jadwalContent) jadwalContent.classList.add('hidden');

                if (dokterBtn) {
                    dokterBtn.classList.add(...activeClasses);
                    dokterBtn.classList.remove(...inactiveClasses);
                    const b = dokterBtn.querySelector('.tab-badge');
                    if (b) {
                        b.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium bg-white/20 text-white';
                    }
                }
                if (jadwalBtn) {
                    jadwalBtn.classList.remove(...activeClasses);
                    jadwalBtn.classList.add(...inactiveClasses);
                    const b = jadwalBtn.querySelector('.tab-badge');
                    if (b) {
                        b.className =
                            'tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300';
                    }
                }

                if (pageTitle) pageTitle.textContent = 'Konsultasi Dokter Hewan';
                if (pageDesc) pageDesc.textContent =
                    'Layanan telemedisin veteriner langsung bersama dokter hewan resmi Dinas Peternakan Jawa Timur.';
                if (actionJadwalBtn) actionJadwalBtn.classList.add('hidden');

                if (pushHistory) {
                    try {
                        const url = new URL(window.location);
                        url.searchParams.set('tab', 'dokter');
                        window.history.replaceState({}, '', url);
                    } catch (e) {}
                }
            } else {
                if (dokterContent) dokterContent.classList.add('hidden');
                if (jadwalContent) jadwalContent.classList.remove('hidden');

                if (jadwalBtn) {
                    jadwalBtn.classList.add(...activeClasses);
                    jadwalBtn.classList.remove(...inactiveClasses);
                    const b = jadwalBtn.querySelector('.tab-badge');
                    if (b) {
                        b.className = 'tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium bg-white/20 text-white';
                    }
                }
                if (dokterBtn) {
                    dokterBtn.classList.remove(...activeClasses);
                    dokterBtn.classList.add(...inactiveClasses);
                    const b = dokterBtn.querySelector('.tab-badge');
                    if (b) {
                        b.className =
                            'tab-badge text-[11px] px-2 py-0.5 rounded-full font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300';
                    }
                }

                if (pageTitle) pageTitle.textContent = 'Jadwal Konsultasi';
                if (pageDesc) pageDesc.textContent =
                    'Daftar reservasi sesi konsultasi kesehatan hewan Anda bersama dokter hewan Puskeswan dengan sistem kuota terkelola.';
                if (actionJadwalBtn) actionJadwalBtn.classList.remove('hidden');

                if (pushHistory) {
                    try {
                        const url = new URL(window.location);
                        url.searchParams.set('tab', 'jadwal');
                        window.history.replaceState({}, '', url);
                    } catch (e) {}
                }
            }
        }

        window.addEventListener('popstate', function() {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab') || 'dokter';
            if (tab === 'dokter' || tab === 'jadwal') {
                switchSubTab(tab, false);
            }
        });

        function openCalendarPicker() {
            const input = document.getElementById('rekam-medis-calendar-input');
            if (input) {
                if (typeof input.showPicker === 'function') {
                    input.showPicker();
                } else {
                    input.focus();
                }
            }
        }

        function applyRekamMedisDateFilter(selectedDate) {
            const hasServerFilter = {{ request()->filled('filter_date') ? 'true' : 'false' }};
            if (hasServerFilter) {
                if (selectedDate) {
                    window.location.href = "{{ route('konsultasi') }}?tab=rekam_medis&filter_date=" + encodeURIComponent(selectedDate);
                } else {
                    window.location.href = "{{ route('konsultasi') }}?tab=rekam_medis";
                }
                return;
            }

            const cards = document.querySelectorAll('.rekam-medis-card');
            const resetBtn = document.getElementById('reset-filter-rekam-medis');
            const emptyState = document.getElementById('filter-empty-state');
            const statusInfo = document.getElementById('filter-status-info');
            const emptyMsg = document.getElementById('filter-empty-message');

            if (!selectedDate) {
                cards.forEach(card => card.classList.remove('hidden'));
                if (resetBtn) resetBtn.classList.add('hidden');
                if (emptyState) emptyState.classList.add('hidden');
                if (statusInfo) {
                    statusInfo.innerHTML = '<span class="text-[11px] text-gray-400 dark:text-gray-500">Semua riwayat rekam medis ditampilkan</span>';
                }
                try {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', 'rekam_medis');
                    url.searchParams.delete('filter_date');
                    window.history.replaceState({}, '', url);
                } catch (e) {}
                return;
            }

            if (resetBtn) resetBtn.classList.remove('hidden');

            let visibleCount = 0;
            cards.forEach(card => {
                const cardDate = card.getAttribute('data-record-date');
                if (cardDate === selectedDate) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            const parts = selectedDate.split('-');
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            let formattedDate = selectedDate;
            if (parts.length === 3) {
                const day = parseInt(parts[2], 10);
                const month = months[parseInt(parts[1], 10) - 1];
                const year = parts[0];
                formattedDate = `${day} ${month} ${year}`;
            }

            if (statusInfo) {
                statusInfo.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200/80 px-2.5 py-1 rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Kalender: ${formattedDate} (${visibleCount} ditemukan)</span>
                    </span>
                `;
            }

            if (visibleCount === 0) {
                if (emptyState) emptyState.classList.remove('hidden');
                if (emptyMsg) emptyMsg.innerText = `Tidak ada rekam medis pada tanggal ${formattedDate}.`;
            } else {
                if (emptyState) emptyState.classList.add('hidden');
            }

            try {
                const url = new URL(window.location);
                url.searchParams.set('tab', 'rekam_medis');
                url.searchParams.set('filter_date', selectedDate);
                window.history.replaceState({}, '', url);
            } catch (e) {}
        }

        function resetRekamMedisDateFilter(e) {
            if (e) e.preventDefault();
            const hasServerFilter = {{ request()->filled('filter_date') ? 'true' : 'false' }};
            if (hasServerFilter) {
                window.location.href = "{{ route('konsultasi') }}?tab=rekam_medis";
                return;
            }
            const input = document.getElementById('rekam-medis-calendar-input');
            if (input) input.value = '';
            applyRekamMedisDateFilter('');
        }
    </script>
    </div>
@endsection

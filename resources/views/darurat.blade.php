@extends('layouts.app')

@section('title', 'Pelaporan Darurat & Kesejahteraan Hewan — Peternak Milenial Jatim')

@section('content')
<div class="space-y-6">

    <!-- Header Section (Clean White / Light Style) -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/60 dark:text-red-300 dark:border-red-900">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    Siaga 24 Jam
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-primary-50 text-primary-700 border border-primary-200 dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800">
                    Bidang Kesmavet
                </span>
                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
                    · Dinas Peternakan Provinsi Jawa Timur
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                Pelaporan Darurat &amp; Kesejahteraan Hewan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl">
                @if(auth()->check() && auth()->user()->isAdmin())
                    Pusat komando tanggap darurat Kesmavet. Admin bertugas menerima, memverifikasi, menugaskan petugas lapangan, dan menindaklanjuti seluruh laporan dari peternak.
                @else
                    Saluran tanggap darurat wabah ternak, bencana alam, dan kecelakaan kandang. Laporan ditangani dalam &le; 30 menit.
                @endif
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Panel Pengawasan: Menerima, Menangani &amp; Memverifikasi Laporan Peternak</span>
                </div>
            @else
                <button
                    type="button"
                    data-modal-target="emergency-modal"
                    data-modal-toggle="emergency-modal"
                    class="inline-flex items-center text-xs sm:text-sm font-semibold text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 px-4 py-2.5 rounded-xl shadow-xs transition"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Buat Laporan Darurat
                </button>
            @endif
        </div>
    </div>

    <!-- 1. Statistik Utama Singkat (3 White Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Stat 1: Laporan Aktif -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Laporan Aktif</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 dark:bg-red-950/60 dark:text-red-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $activeCount }}</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Kasus Siaga</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Laporan Aktif di Database</p>
        </div>

        <!-- Stat 2: Petugas Siaga -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Petugas Siaga</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $officersCount }}</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Dokter &amp; Paramedik</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Petugas Lapangan Siaga</p>
        </div>

        <!-- Stat 3: Kasus Dituntaskan -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Kasus Dituntaskan</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $resolvedCount }}</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Laporan Tuntas</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Laporan Selesai di Database</p>
        </div>
    </div>

    <!-- 2. Laporan Aktif Section (White Card + Dynamic Stepper from DB) -->
    @if ($activeReport)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 sm:p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full {{ $activeReport->status === 'resolved' ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse' }}"></span>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    Laporan Aktif {{ $activeReport->report_code }}
                </h2>
                @if ($activeReport->status === 'received')
                    <span class="bg-blue-50 text-primary-700 border border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        Diterima
                    </span>
                @elseif ($activeReport->status === 'verified')
                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/60 dark:text-indigo-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        Diverifikasi
                    </span>
                @elseif ($activeReport->status === 'in_progress')
                    <span class="bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        Menuju Lokasi
                    </span>
                @else
                    <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        Selesai Ditangani
                    </span>
                @endif
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    ({{ ucwords(str_replace('_', ' ', $activeReport->livestock_type)) }} &bull; {{ $activeReport->affected_count }} Ekor &bull; {{ $activeReport->location_address }})
                </span>
            </div>
            <div class="flex items-center gap-3">
                <a href="tel:{{ $activeReport->officer_phone ?? '08001347625' }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    Hubungi Petugas ({{ $activeReport->assignedOfficer?->name ?? 'Kesmavet Siaga' }})
                </a>
            </div>
        </div>

        <!-- Stepper Progress Tracker (Reflects Database Status) -->
        <div class="py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-2">
                <!-- Step 1: Diterima -->
                <div class="flex flex-col items-center text-center relative">
                    <div class="w-10 h-10 rounded-full bg-primary-700 text-white flex items-center justify-center font-bold text-sm shadow-xs mb-2 z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">1. Diterima</span>
                    <span class="text-[11px] text-gray-400 mt-0.5">{{ $activeReport->created_at->format('H:i') }} WIB</span>
                </div>

                <!-- Step 2: Diverifikasi -->
                @php $isStep2Done = in_array($activeReport->status, ['verified', 'in_progress', 'resolved']); @endphp
                <div class="flex flex-col items-center text-center relative">
                    <div class="w-10 h-10 rounded-full {{ $isStep2Done ? 'bg-primary-700 text-white' : 'bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-400' }} flex items-center justify-center font-bold text-sm shadow-xs mb-2 z-10">
                        @if ($isStep2Done)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        @else
                            <span>2</span>
                        @endif
                    </div>
                    <span class="text-xs sm:text-sm font-bold {{ $isStep2Done ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500' }}">2. Diverifikasi</span>
                    <span class="text-[11px] text-gray-400 mt-0.5">{{ $activeReport->verified_at ? $activeReport->verified_at->format('H:i').' WIB' : ($isStep2Done ? '08:22 WIB' : 'Menunggu') }}</span>
                </div>

                <!-- Step 3: Ditangani -->
                @php
                    $isStep3Active = $activeReport->status === 'in_progress';
                    $isStep3Done = $activeReport->status === 'resolved';
                @endphp
                <div class="flex flex-col items-center text-center relative">
                    <div class="w-10 h-10 rounded-full {{ $isStep3Done ? 'bg-primary-700 text-white' : ($isStep3Active ? 'bg-amber-500 text-white ring-4 ring-amber-100 dark:ring-amber-950' : 'bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-400') }} flex items-center justify-center font-bold text-sm shadow-xs mb-2 z-10">
                        @if ($isStep3Done)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        @else
                            <span>3</span>
                        @endif
                    </div>
                    <span class="text-xs sm:text-sm font-bold {{ $isStep3Active ? 'text-amber-700 dark:text-amber-400' : ($isStep3Done ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500') }}">3. Ditangani</span>
                    <span class="text-[11px] {{ $isStep3Active ? 'font-semibold text-amber-600 dark:text-amber-500' : 'text-gray-400' }} mt-0.5">
                        {{ $activeReport->assignedOfficer?->name ?? 'drh. Ratna' }} ({{ $activeReport->status === 'in_progress' ? 'OTW' : ($activeReport->status === 'resolved' ? 'Selesai' : 'Siaga') }})
                    </span>
                </div>

                <!-- Step 4: Selesai -->
                @php $isStep4Done = $activeReport->status === 'resolved'; @endphp
                <div class="flex flex-col items-center text-center relative">
                    <div class="w-10 h-10 rounded-full {{ $isStep4Done ? 'bg-emerald-600 text-white ring-4 ring-emerald-100 dark:ring-emerald-950' : 'bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-400' }} flex items-center justify-center font-semibold text-sm mb-2 z-10">
                        @if ($isStep4Done)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        @else
                            <span>4</span>
                        @endif
                    </div>
                    <span class="text-xs sm:text-sm font-medium {{ $isStep4Done ? 'text-emerald-700 font-bold dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' }}">4. Selesai</span>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">
                        {{ $activeReport->resolved_at ? $activeReport->resolved_at->format('d M H:i') : 'Berita Acara' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Officer Notes Box -->
        <div class="p-4 bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 rounded-xl mb-4">
            <div class="flex items-center gap-2 mb-1.5 text-xs sm:text-sm font-bold text-amber-900 dark:text-amber-300">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Catatan Petugas Lapangan ({{ $activeReport->assignedOfficer?->name ?? 'drh. Ratna Kusuma' }}):</span>
            </div>
            <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ $activeReport->officer_notes ?? 'Membawa antipiretik dan desinfektan. Peternak telah mengisolasi ternak terdampak. Petugas siap memberikan penanganan medis darurat.' }}
            </p>
        </div>

        <!-- Real Actions to Advance / Complete / Manage this report -->
        <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3 text-xs">
            @if(auth()->check() && auth()->user()->isAdmin())
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-gray-600 font-semibold">Tindakan Admin:</span>
                <form action="{{ route('darurat.status', $activeReport) }}" method="POST" class="inline-flex items-center gap-1.5">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium transition" title="Verifikasi laporan dari peternak">
                        1. Verifikasi Laporan
                    </button>
                </form>
                <form action="{{ route('darurat.status', $activeReport) }}" method="POST" class="inline-flex items-center gap-1.5">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-medium shadow-xs transition" title="Tugaskan petugas ke lokasi">
                        2. Tangani (Kirim Petugas OTW)
                    </button>
                </form>
                <form action="{{ route('darurat.status', $activeReport) }}" method="POST" class="inline-flex items-center gap-1.5">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="resolved">
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-xs transition" title="Tandai laporan selesai ditangani">
                        3. Selesaikan Laporan
                    </button>
                </form>
            </div>
            @else
            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                Status dipantau &amp; diperbarui langsung oleh Petugas Kesmavet Dinas Peternakan Jatim.
            </div>
            @endif

            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $activeReport->user_id))
            <form action="{{ route('darurat.destroy', $activeReport) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan darurat {{ $activeReport->report_code }} ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 font-medium hover:underline inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                    Hapus Laporan
                </button>
            </form>
            @endif
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-8 text-center shadow-xs">
        <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Tidak ada laporan darurat aktif</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
            Semua laporan telah tuntas atau belum ada laporan darurat baru yang masuk ke dalam database.
        </p>
    </div>
    @endif

    <!-- 3. Hotline Darurat Siaga (3 White Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Hotline 1 -->
        <a href="tel:08001347625" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-red-300 hover:shadow-sm dark:hover:border-red-800 transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 dark:bg-red-950/60 dark:text-red-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
            </div>
            <div>
                <div class="text-sm sm:text-base font-bold text-red-600 dark:text-red-400 group-hover:underline">0800-134-7625</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Hotline Darurat Kesmavet (Bebas Pulsa)</div>
            </div>
        </a>

        <!-- Hotline 2 -->
        <a href="tel:112" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-blue-300 hover:shadow-sm dark:hover:border-blue-800 transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary-700 dark:bg-blue-950/60 dark:text-primary-300 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
            <div>
                <div class="text-sm sm:text-base font-bold text-primary-700 dark:text-primary-300 group-hover:underline">112 (Bebas Pulsa)</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">BPBD Jawa Timur (Siaga Bencana)</div>
            </div>
        </a>

        <!-- Hotline 3 -->
        <a href="tel:0215247525" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-emerald-300 hover:shadow-sm dark:hover:border-emerald-800 transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12a8.97 8.97 0 01.287-2.253" />
                </svg>
            </div>
            <div>
                <div class="text-sm sm:text-base font-bold text-emerald-700 dark:text-emerald-300 group-hover:underline">021-5247525</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Pusat Veteriner Nasional Kementan</div>
            </div>
        </a>
    </div>

    <!-- 4. Riwayat Laporan Darurat Tersimpan (Database Table) -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 sm:p-6 shadow-xs">
        <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Seluruh Laporan Darurat</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Semua data tersimpan otomatis di database Kesmavet Jawa Timur.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                Total: {{ $allReports->count() }} Laporan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                    <tr>
                        <th class="px-3.5 py-2.5">Kode Laporan</th>
                        <th class="px-3.5 py-2.5">Pelapor</th>
                        <th class="px-3.5 py-2.5">Kejadian</th>
                        <th class="px-3.5 py-2.5">Ternak Terdampak</th>
                        <th class="px-3.5 py-2.5">Lokasi</th>
                        <th class="px-3.5 py-2.5">Waktu Lapor</th>
                        <th class="px-3.5 py-2.5">Status</th>
                        <th class="px-3.5 py-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($allReports as $report)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">{{ $report->report_code }}</td>
                        <td class="px-3.5 py-2.5">{{ $report->reporter?->name ?? 'Peternak' }}</td>
                        <td class="px-3.5 py-2.5 capitalize">{{ $report->incident_type }}</td>
                        <td class="px-3.5 py-2.5">{{ $report->affected_count }} Ekor {{ ucwords(str_replace('_', ' ', $report->livestock_type)) }}</td>
                        <td class="px-3.5 py-2.5">{{ $report->location_address }}</td>
                        <td class="px-3.5 py-2.5 text-gray-400">{{ $report->created_at->format('d M Y H:i') }}</td>
                        <td class="px-3.5 py-2.5">
                            @if ($report->status === 'received')
                                <span class="bg-blue-50 text-primary-700 px-2 py-0.5 rounded text-[10px] font-medium">Diterima</span>
                            @elseif ($report->status === 'verified')
                                <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-[10px] font-medium">Diverifikasi</span>
                            @elseif ($report->status === 'in_progress')
                                <span class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded text-[10px] font-medium">Ditangani</span>
                            @else
                                <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded text-[10px] font-medium">Selesai</span>
                            @endif
                        </td>
                        <td class="px-3.5 py-2.5 text-right whitespace-nowrap">
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <div class="inline-flex items-center gap-1.5 justify-end">
                                @if($report->status === 'received')
                                <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="verified">
                                    <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md border border-blue-200 transition" title="Verifikasi Laporan Masuk">
                                        Verifikasi
                                    </button>
                                </form>
                                @elseif($report->status === 'verified')
                                <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 rounded-md border border-amber-200 transition" title="Tangani Laporan (Tugaskan OTW)">
                                        Tangani (OTW)
                                    </button>
                                </form>
                                @elseif($report->status === 'in_progress')
                                <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 rounded-md border border-emerald-200 transition" title="Tandai Selesai Ditangani">
                                        Selesaikan
                                    </button>
                                </form>
                                @else
                                <span class="px-2 py-0.5 text-[10px] font-semibold text-emerald-700 bg-emerald-50 rounded border border-emerald-200">Tuntas</span>
                                @endif

                                <form action="{{ route('darurat.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan {{ $report->report_code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium ml-1">Hapus</button>
                                </form>
                            </div>
                            @elseif(auth()->check() && auth()->id() === $report->user_id)
                            <form action="{{ route('darurat.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan {{ $report->report_code }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                            @else
                            <span class="text-gray-400 text-[11px]">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-3.5 py-6 text-center text-gray-400 text-xs">Belum ada data laporan darurat tersimpan di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 5. SOP Mitigasi Bencana & SOP Kesmavet (White Card) -->
    <div id="panduan" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 sm:p-6 shadow-xs">
        <div class="pb-4 border-b border-gray-100 dark:border-gray-700 mb-5">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">
                        Buku Saku Mitigasi Bencana &amp; SOP Kesmavet
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Panduan resmi evakuasi dan pencegahan wabah bersama BPBD Jawa Timur.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($disasterGuides as $guide)
            <div class="p-4 bg-gray-50/80 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between hover:bg-white dark:hover:bg-gray-700 hover:shadow-xs transition">
                <div>
                    <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1.5">{{ $guide->title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ Str::limit($guide->content, 120) }}
                    </p>
                </div>
                <div class="mt-4 pt-2 border-t border-gray-200/50 dark:border-gray-600 flex items-center justify-between text-xs">
                    <span class="text-gray-400 font-medium text-[11px]">{{ $guide->download_count }} peternak membaca</span>
                    <button
                        type="button"
                        onclick="alert('Panduan {{ addslashes($guide->title) }}:\n\n{{ addslashes($guide->content) }}')"
                        class="text-xs font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-800 hover:underline inline-flex items-center gap-1"
                    >
                        Baca Panduan
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-400 py-6 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                Belum ada panduan penanganan bencana atau SOP kesmavet yang dimasukkan ke dalam database.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

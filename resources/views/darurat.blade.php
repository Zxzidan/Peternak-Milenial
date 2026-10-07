@extends('layouts.app')

@section('title', 'Pelaporan Darurat & Kesejahteraan Hewan — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = request('tab', 'masuk');
    if ($activeTab === 'dijawab') { $activeTab = 'ditangani'; }
    if ($activeTab === 'history') { $activeTab = 'riwayat'; }
    if (!in_array($activeTab, ['masuk', 'ditangani', 'riwayat'])) { $activeTab = 'masuk'; }
    $masukCount    = $allReports->whereIn('status', ['received', 'verified'])->count();
    $ditanganiCount = $allReports->where('status', 'in_progress')->count();
    $riwayatCount  = $allReports->where('status', 'resolved')->count();
@endphp
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 mb-2 sm:mb-2.5">
                <span class="bg-red-50 text-red-700 dark:bg-red-950/60 dark:text-red-300 text-xs font-medium px-2 py-0.5 rounded">
                    Bidang Kesmavet
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    · Siaga 24 Jam
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                @if(auth()->check() && auth()->user()->isAdmin())
                    @if($activeTab === 'masuk')
                        Laporan Masuk
                    @elseif($activeTab === 'ditangani')
                        Laporan Dijawab
                    @elseif($activeTab === 'riwayat')
                        History Laporan
                    @endif
                @else
                    Siaga Darurat Ternak
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed max-w-2xl">
                @if(auth()->check() && auth()->user()->isAdmin())
                    @if($activeTab === 'masuk')
                        Laporan darurat yang menunggu verifikasi dan penugasan petugas lapangan.
                    @elseif($activeTab === 'ditangani')
                        Laporan yang telah diverifikasi dan sedang ditangani petugas di lokasi.
                    @elseif($activeTab === 'riwayat')
                        Daftar riwayat laporan darurat yang telah berhasil diselesaikan.
                    @endif
                @else
                    Saluran tanggap darurat wabah ternak, bencana alam, dan kecelakaan kandang.
                @endif
            </p>
        </div>

        @if(!auth()->check() || !auth()->user()->isAdmin())
        <div class="flex items-center gap-3">
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="inline-flex items-center text-xs sm:text-sm font-semibold text-white bg-red-600 hover:bg-red-700 px-3.5 py-2 rounded-lg shadow-xs transition"
            >
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Buat Laporan Darurat
            </button>
        </div>
        @endif
    </div>

    <!-- Statistik Utama (3 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 border-l-4 border-l-red-500 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-3">Laporan Aktif</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-gray-900 dark:text-white leading-none">{{ $activeCount }}</span>
                <span class="text-sm text-gray-500 mb-0.5">kasus siaga</span>
            </div>
            <p class="text-xs text-gray-400">Laporan aktif di database</p>
        </div>
        <div class="bg-white dark:bg-gray-800 border-l-4 border-l-amber-400 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-3">Petugas Siaga</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-gray-900 dark:text-white leading-none">{{ $officersCount }}</span>
                <span class="text-sm text-gray-500 mb-0.5">dokter &amp; paramedik</span>
            </div>
            <p class="text-xs text-gray-400">Petugas lapangan siaga</p>
        </div>
        <div class="bg-white dark:bg-gray-800 border-l-4 border-l-emerald-500 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-xs hover:shadow-sm transition-shadow">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-3">Kasus Dituntaskan</p>
            <div class="flex items-end gap-2 mb-1">
                <span class="text-3xl font-bold text-gray-900 dark:text-white leading-none">{{ $resolvedCount }}</span>
                <span class="text-sm text-gray-500 mb-0.5">laporan selesai</span>
            </div>
            <p class="text-xs text-gray-400">Laporan selesai di database</p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
        @if($activeTab === 'masuk')
        {{-- ============================================================ --}}
        {{-- PANEL: LAPORAN MASUK (received + verified)                   --}}
        {{-- ============================================================ --}}
        <div id="panel-masuk" class="space-y-4">
        @php $laporanMasuk = $allReports->whereIn('status', ['received', 'verified']); @endphp

        @if($laporanMasuk->isEmpty())
        <div class="bg-white dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-10 text-center">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tidak ada laporan masuk</p>
            <p class="text-xs text-gray-400 mt-1">Belum ada laporan baru yang menunggu verifikasi.</p>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Laporan Masuk</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Laporan yang diterima dan menunggu tindakan verifikasi admin</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-200">{{ $laporanMasuk->count() }} laporan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-[11px] text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Pelapor</th>
                            <th class="px-5 py-3">Kejadian</th>
                            <th class="px-5 py-3">Ternak</th>
                            <th class="px-5 py-3">Lokasi</th>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($laporanMasuk as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                            <td class="px-5 py-3.5 font-bold text-gray-900 dark:text-white">{{ $report->report_code }}</td>
                            <td class="px-5 py-3.5">{{ $report->reporter?->name ?? 'Peternak' }}</td>
                            <td class="px-5 py-3.5 capitalize">{{ $report->incident_type }}</td>
                            <td class="px-5 py-3.5">{{ $report->affected_count }} Ekor {{ ucwords(str_replace('_', ' ', $report->livestock_type)) }}</td>
                            <td class="px-5 py-3.5">{{ $report->location_address }}</td>
                            <td class="px-5 py-3.5 text-gray-400">{{ $report->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3.5">
                                @if($report->status === 'received')
                                    <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-semibold border border-blue-200">Diterima</span>
                                @else
                                    <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-[10px] font-semibold border border-indigo-200">Diverifikasi</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2 justify-end">
                                    @if($report->status === 'received')
                                    <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md border border-blue-200 transition">Verifikasi</button>
                                    </form>
                                    @elseif($report->status === 'verified')
                                    <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 rounded-md border border-amber-200 transition">Tangani (OTW)</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('darurat.destroy', ['report' => $report, 'tab' => 'masuk']) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan {{ $report->report_code }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        </div>
        @elseif($activeTab === 'ditangani')
        {{-- ============================================================ --}}
        {{-- PANEL: SEDANG DITANGANI / LAPORAN DIJAWAB (in_progress)     --}}
        {{-- ============================================================ --}}
        <div id="panel-ditangani" class="space-y-4">
        @php $laporanDitangani = $allReports->where('status', 'in_progress'); @endphp

        @if($laporanDitangani->isEmpty())
        <div class="bg-white dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-10 text-center">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tidak ada laporan yang sedang ditangani</p>
            <p class="text-xs text-gray-400 mt-1">Semua laporan telah selesai atau belum ada yang dikirim petugas.</p>
        </div>
        @else
        @foreach($laporanDitangani as $report)
        <div class="bg-white dark:bg-gray-800 border border-amber-200 dark:border-amber-800/60 rounded-xl p-5 sm:p-6 shadow-xs">
            <!-- Report Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3 mb-5">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">{{ $report->report_code }}</h2>
                    <span class="bg-amber-50 text-amber-800 border border-amber-200 text-xs font-semibold px-2.5 py-0.5 rounded-full">Menuju Lokasi</span>
                    <span class="text-xs text-gray-500">({{ ucwords(str_replace('_', ' ', $report->livestock_type)) }} &bull; {{ $report->affected_count }} Ekor &bull; {{ $report->location_address }})</span>
                </div>
                <a href="tel:{{ $report->officer_phone ?? '08001347625' }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:underline shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    Hubungi Petugas ({{ $report->assignedOfficer?->name ?? 'Kesmavet Siaga' }})
                </a>
            </div>

            <!-- Stepper Progress -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-2 py-4">
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full bg-primary-700 text-white flex items-center justify-center font-bold text-sm shadow-xs mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white">1. Diterima</span>
                    <span class="text-[11px] text-gray-400 mt-0.5">{{ $report->created_at->format('H:i') }} WIB</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full bg-primary-700 text-white flex items-center justify-center font-bold text-sm shadow-xs mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white">2. Diverifikasi</span>
                    <span class="text-[11px] text-gray-400 mt-0.5">{{ $report->verified_at ? $report->verified_at->format('H:i').' WIB' : '-' }}</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full bg-amber-500 text-white ring-4 ring-amber-100 dark:ring-amber-950 flex items-center justify-center font-bold text-sm shadow-xs mb-2">3</div>
                    <span class="text-xs font-bold text-amber-700 dark:text-amber-400">3. Ditangani</span>
                    <span class="text-[11px] font-semibold text-amber-600 mt-0.5">{{ $report->assignedOfficer?->name ?? 'Petugas' }} (OTW)</span>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-400 flex items-center justify-center font-bold text-sm mb-2">4</div>
                    <span class="text-xs font-medium text-gray-400">4. Selesai</span>
                    <span class="text-[11px] text-gray-400 mt-0.5">Berita Acara</span>
                </div>
            </div>

            <!-- Officer Notes -->
            @if($report->officer_notes)
            <div class="p-4 bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 rounded-xl mb-4">
                <p class="text-xs font-bold text-amber-900 dark:text-amber-300 mb-1">Catatan Petugas ({{ $report->assignedOfficer?->name ?? 'Petugas' }}):</p>
                <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">{{ $report->officer_notes }}</p>
            </div>
            @endif

            <!-- Admin Actions -->
            <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-600 font-semibold">Tindakan Admin:</span>
                    <form action="{{ route('darurat.status', $report) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="resolved">
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-xs transition">Selesaikan Laporan</button>
                    </form>
                </div>
                <form action="{{ route('darurat.destroy', ['report' => $report, 'tab' => 'ditangani']) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan {{ $report->report_code }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium hover:underline">Hapus Laporan</button>
                </form>
            </div>
        </div>
        @endforeach
        @endif
        </div>
        @elseif($activeTab === 'riwayat')
        {{-- ============================================================ --}}
        {{-- PANEL: RIWAYAT / HISTORY LAPORAN (resolved)                  --}}
        {{-- ============================================================ --}}
        <div id="panel-riwayat" class="space-y-4">
        @php $laporanRiwayat = $allReports->where('status', 'resolved'); @endphp
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">History Laporan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Laporan yang telah diselesaikan dan dituntaskan oleh petugas</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">{{ $laporanRiwayat->count() }} selesai</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-[11px] text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Pelapor</th>
                            <th class="px-5 py-3">Kejadian</th>
                            <th class="px-5 py-3">Ternak</th>
                            <th class="px-5 py-3">Lokasi</th>
                            <th class="px-5 py-3">Waktu Lapor</th>
                            <th class="px-5 py-3">Diselesaikan</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($laporanRiwayat as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                            <td class="px-5 py-3.5 font-bold text-gray-900 dark:text-white">{{ $report->report_code }}</td>
                            <td class="px-5 py-3.5">{{ $report->reporter?->name ?? 'Peternak' }}</td>
                            <td class="px-5 py-3.5 capitalize">{{ $report->incident_type }}</td>
                            <td class="px-5 py-3.5">{{ $report->affected_count }} Ekor {{ ucwords(str_replace('_', ' ', $report->livestock_type)) }}</td>
                            <td class="px-5 py-3.5">{{ $report->location_address }}</td>
                            <td class="px-5 py-3.5 text-gray-400">{{ $report->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3.5 text-gray-400">{{ $report->resolved_at ? $report->resolved_at->format('d M Y H:i') : '-' }}</td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded text-[10px] font-semibold border border-emerald-200">Tuntas</span>
                                    <form action="{{ route('darurat.destroy', ['report' => $report, 'tab' => 'riwayat']) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan {{ $report->report_code }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-gray-400 text-xs">Belum ada laporan yang diselesaikan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        @endif
    @else
    {{-- ============================================================ --}}
    {{-- NON-ADMIN VIEW                                                --}}
    {{-- ============================================================ --}}
    @if ($activeReport)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 sm:p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full {{ $activeReport->status === 'resolved' ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse' }}"></span>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Laporan Aktif {{ $activeReport->report_code }}</h2>
                <span class="text-xs text-gray-500">({{ ucwords(str_replace('_', ' ', $activeReport->livestock_type)) }} &bull; {{ $activeReport->affected_count }} Ekor &bull; {{ $activeReport->location_address }})</span>
            </div>
            <a href="tel:{{ $activeReport->officer_phone ?? '08001347625' }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
                Hubungi Petugas ({{ $activeReport->assignedOfficer?->name ?? 'Kesmavet Siaga' }})
            </a>
        </div>
        <div class="py-4 text-xs text-gray-500 dark:text-gray-400 italic">
            Status dipantau &amp; diperbarui langsung oleh Petugas Kesmavet Dinas Peternakan Jatim.
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-10 text-center shadow-xs">
        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Tidak ada laporan darurat aktif</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Semua laporan telah tuntas atau belum ada laporan darurat baru.</p>
    </div>
    @endif
    @endif

    <!-- Hotline Darurat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="tel:08001347625" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-red-300 hover:shadow-sm transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-red-600 group-hover:underline">0800-134-7625</div>
                <div class="text-xs text-gray-500 font-medium">Hotline Darurat Kesmavet (Bebas Pulsa)</div>
            </div>
        </a>
        <a href="tel:112" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-blue-300 hover:shadow-sm transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-primary-700 group-hover:underline">112 (Bebas Pulsa)</div>
                <div class="text-xs text-gray-500 font-medium">BPBD Jawa Timur (Siaga Bencana)</div>
            </div>
        </a>
        <a href="tel:0215247525" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:border-emerald-300 hover:shadow-sm transition flex items-center gap-3.5 group">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12a8.97 8.97 0 01.287-2.253" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-emerald-700 group-hover:underline">021-5247525</div>
                <div class="text-xs text-gray-500 font-medium">Pusat Veteriner Nasional Kementan</div>
            </div>
        </a>
    </div>

</div>
@endsection

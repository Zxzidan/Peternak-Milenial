@extends('layouts.app')

@section('title', 'Jadwal Kunjungan Lapangan — Dokter Hewan Dinas')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                Jadwal Kunjungan Lapangan Peternakan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Daftar agenda peninjauan langsung kondisi kesehatan ternak ke kandang peternak di wilayah Jawa Timur.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dokter-hewan.dashboard') }}" class="px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 transition shadow-2xs">
                Lihat Semua Laporan
            </a>
        </div>
    </div>

    <!-- Visits Grid / List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($visits as $visit)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3.5 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-bold text-gray-900 dark:text-white">
                        {{ $visit->report->report_number }}
                    </span>
                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full border {{ $visit->status_badge_classes }}">
                        {{ $visit->status_label }}
                    </span>
                </div>

                <div class="space-y-1 text-xs">
                    <span class="text-[11px] text-gray-400 block">Peternak &amp; Lokasi:</span>
                    <span class="font-bold text-gray-900 dark:text-white block">{{ $visit->report->user->name }}</span>
                    <span class="text-gray-500 dark:text-gray-400 block">{{ $visit->report->farm_name ?? 'Peternakan' }} ({{ $visit->report->kabupaten ?? 'Jawa Timur' }})</span>
                </div>

                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl text-xs space-y-1">
                    <span class="text-[11px] font-semibold text-gray-500 block">Jadwal Kunjungan:</span>
                    <span class="font-bold text-orange-700 dark:text-orange-400 block">
                        {{ $visit->confirmed_date ? $visit->confirmed_date->format('d M Y, H:i') : $visit->proposed_date->format('d M Y, H:i') }} WIB
                    </span>
                    <span class="text-[10px] text-gray-400 block">
                        {{ $visit->confirmed_date ? '✓ Telah dikonfirmasi peternak' : '⏳ Menunggu konfirmasi peternak' }}
                    </span>
                </div>

                <div class="text-xs text-gray-700 dark:text-gray-300">
                    <span class="font-semibold block text-gray-800 dark:text-gray-200">Alasan Kunjungan:</span>
                    <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2">{{ $visit->visit_reason }}</p>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <a
                    href="{{ route('dokter-hewan.show', $visit->report) }}"
                    class="w-full inline-flex items-center justify-center gap-1 text-xs font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-800 py-1.5"
                >
                    <span>Buka Detail Laporan &amp; Tindakan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-12 text-center text-gray-500">
            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada jadwal kunjungan lapangan</h3>
            <p class="text-xs text-gray-400 mt-1">Kunjungan yang diusulkan atau disepakati akan tercatat di sini.</p>
        </div>
        @endforelse
    </div>

    @if($visits->hasPages())
    <div class="pt-2">
        {{ $visits->links() }}
    </div>
    @endif
</div>
@endsection

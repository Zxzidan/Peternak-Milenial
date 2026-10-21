@extends('layouts.app')

@php
    $isReportMenu = request()->routeIs('dokter-hewan.laporan.*')
        || request()->is('dokter-hewan/laporan*')
        || request()->has('tab');
@endphp

@section('title', $isReportMenu ? 'Laporan Kesehatan Ternak — Dinas Peternakan Jawa Timur' : 'Dashboard Dokter Hewan — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            @if($isReportMenu)
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                    Laporan Kesehatan Hewan Ternak
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Daftar laporan klinis dan konsultasi kesehatan ternak dari peternak Jawa Timur untuk pemeriksaan dan tindak lanjut medis.
                </p>
            @else
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                    Dashboard Dokter Hewan Dinas
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Pantau laporan klinis ternak dari peternak, berikan analisis dan rekomendasi profesional, serta kelola jadwal kunjungan lapangan.
                </p>
            @endif
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            @if($isReportMenu)
            <a
                href="{{ route('dokter-hewan.dashboard') }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs hover:bg-gray-50 dark:hover:bg-gray-700/60 transition"
                title="Kembali ke Dashboard Utama"
            >
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25-2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                <span>Dashboard Utama</span>
            </a>
            @endif

            <div class="flex items-center gap-2.5 bg-white dark:bg-gray-800 p-2.5 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
                <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-bold flex items-center justify-center text-xs">
                    {{ $currentVet ? $currentVet->initials : 'DR' }}
                </div>
                <div class="text-left">
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">{{ $currentVet?->puskeswan ?? 'Puskeswan Disnak Jatim' }}</span>
                </div>
            </div>
        </div>
    </div>

    @if(!$isReportMenu)
    <!-- Ringkasan Statistik (Hanya ditampilkan pada Dashboard Utama) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- 1. Laporan Masuk -->
        <a href="{{ route('dokter-hewan.laporan.index', ['tab' => 'masuk']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-amber-200/90 dark:border-amber-800/60 shadow-2xs hover:shadow-md hover:border-amber-400 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-800 dark:text-amber-400">Laporan Masuk</span>
                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-amber-700 dark:text-amber-400 mt-2 block tracking-tight">
                {{ $stats['laporan_masuk'] }}
            </span>
            <p class="text-[11px] text-amber-700/80 dark:text-amber-400/80 mt-1">
                Laporan baru belum mendapat respons
            </p>
        </a>

        <!-- 2. Sedang Ditangani -->
        <a href="{{ route('dokter-hewan.laporan.index', ['tab' => 'ditangani']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-blue-200/90 dark:border-blue-800/60 shadow-2xs hover:shadow-md hover:border-blue-400 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-blue-800 dark:text-blue-400">Sedang Ditangani</span>
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950/80 text-blue-600 dark:text-blue-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-blue-700 dark:text-blue-400 mt-2 block tracking-tight">
                {{ $stats['sedang_ditangani'] }}
            </span>
            <p class="text-[11px] text-blue-700/80 dark:text-blue-400/80 mt-1">
                Dalam pemeriksaan &amp; tindak lanjut
            </p>
        </a>

        <!-- 3. Sudah Dijawab -->
        <a href="{{ route('dokter-hewan.laporan.index', ['tab' => 'dijawab']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-indigo-200/90 dark:border-indigo-800/60 shadow-2xs hover:shadow-md hover:border-indigo-400 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-indigo-800 dark:text-indigo-400">Sudah Dijawab</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-indigo-700 dark:text-indigo-400 mt-2 block tracking-tight">
                {{ $stats['sudah_dijawab'] }}
            </span>
            <p class="text-[11px] text-indigo-700/80 dark:text-indigo-400/80 mt-1">
                Respons awal dokter telah terkirim
            </p>
        </a>

        <!-- 4. Perlu Kunjungan -->
        <a href="{{ route('dokter-hewan.laporan.index', ['tab' => 'kunjungan']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-orange-200/90 dark:border-orange-800/60 shadow-2xs hover:shadow-md hover:border-orange-400 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-orange-800 dark:text-orange-400">Perlu Kunjungan</span>
                <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-950/80 text-orange-600 dark:text-orange-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                </div>
            </div>
            <span class="text-2xl sm:text-3xl font-extrabold text-orange-700 dark:text-orange-400 mt-2 block tracking-tight">
                {{ $stats['perlu_kunjungan'] }}
            </span>
            <p class="text-[11px] text-orange-700/80 dark:text-orange-400/80 mt-1">
                Kunjungan lapangan diajukan/terjadwal
            </p>
        </a>
    </div>
    @endif

    <!-- Header Tabel Laporan & Search Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-4 sm:p-5 shadow-2xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 dark:border-gray-700 pb-3.5">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                        @if($currentTab === 'masuk')
                            Laporan Masuk
                        @elseif($currentTab === 'ditangani')
                            Laporan Sedang Ditangani
                        @elseif($currentTab === 'dijawab')
                            Laporan Sudah Dijawab
                        @elseif($currentTab === 'kunjungan')
                            Laporan Menunggu Kunjungan
                        @elseif($currentTab === 'selesai')
                            Laporan Penanganan Selesai
                        @else
                            Semua Laporan Kesehatan Ternak
                        @endif
                    </h2>
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-primary-50 text-primary-700 border border-primary-200/70 dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800/60">
                        {{ $reports->total() }} Laporan
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    @if($currentTab === 'masuk')
                        Daftar laporan klinis baru dari peternak yang belum ditanggapi dokter
                    @elseif($currentTab === 'ditangani')
                        Daftar laporan yang sedang dalam tahap pemeriksaan &amp; tindak lanjut
                    @elseif($currentTab === 'dijawab')
                        Daftar laporan yang telah menerima respons atau diagnosis awal dari dokter
                    @elseif($currentTab === 'kunjungan')
                        Daftar laporan yang membutuhkan atau telah dijadwalkan kunjungan lapangan
                    @elseif($currentTab === 'selesai')
                        Riwayat laporan penanganan klinis hewan yang telah selesai
                    @else
                        Seluruh rekap laporan klinis dan konsultasi kesehatan ternak
                    @endif
                </p>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('dokter-hewan.laporan.index') }}" class="flex items-center gap-2 shrink-0">
                <input type="hidden" name="tab" value="{{ $currentTab }}">
                <div class="relative w-full sm:w-64">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari no. laporan, peternak, ternak..."
                        class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-xs rounded-lg pl-8 p-2 w-full focus:ring-primary-500 focus:border-primary-500"
                    >
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                <button type="submit" class="px-3 py-2 text-xs font-medium text-white bg-primary-700 hover:bg-primary-800 rounded-lg transition cursor-pointer">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('dokter-hewan.laporan.index', ['tab' => $currentTab]) }}" class="text-xs text-gray-500 hover:text-gray-700 px-1">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Daftar Laporan Table -->
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50/90 dark:bg-gray-700/60 border-b border-gray-200 dark:border-gray-700 font-semibold tracking-wider text-center">
                    <tr>
                        <th scope="col" class="px-3.5 py-3 w-[15%] text-center whitespace-nowrap">No. Laporan &amp; Waktu</th>
                        <th scope="col" class="px-3.5 py-3 w-[17%] text-center">Peternak &amp; Lokasi</th>
                        <th scope="col" class="px-3.5 py-3 w-[14%] text-center">Hewan Ternak</th>
                        <th scope="col" class="px-3.5 py-3 w-[28%] text-center">Keluhan / Gejala Utama</th>
                        <th scope="col" class="px-2.5 py-3 w-[7%] text-center whitespace-nowrap">Urgensi</th>
                        <th scope="col" class="px-2.5 py-3 w-[10%] text-center whitespace-nowrap">Status</th>
                        <th scope="col" class="px-3.5 py-3 w-[9%] text-center whitespace-nowrap">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-5 whitespace-nowrap align-top">
                            <div class="space-y-1.5">
                                <span class="font-mono font-bold text-gray-900 dark:text-white block tracking-tight text-xs">{{ $report->report_number }}</span>
                                <span class="text-[11px] text-gray-400 dark:text-gray-500 block">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 align-top">
                            <div class="space-y-1.5">
                                <span class="font-semibold text-gray-900 dark:text-white block leading-snug">{{ $report->user->name }}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400 block leading-snug">{{ $report->farm_name ?? 'Peternakan Rakyat' }}</span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 block leading-snug">{{ $report->kabupaten ?? 'Jawa Timur' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 align-top">
                            <div class="space-y-1.5">
                                <span class="font-medium text-gray-800 dark:text-gray-200 block leading-snug">{{ $report->livestock_type }}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400 block leading-snug">{{ $report->affected_count }} ekor terdampak</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 align-top">
                            <p class="text-xs sm:text-[13px] text-gray-800 dark:text-gray-200 leading-relaxed font-normal whitespace-normal break-words text-justify">
                                {{ $report->symptoms }}
                            </p>
                            @if($report->symptoms_started_at)
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 block mt-2 font-medium">Gejala sejak: {{ $report->symptoms_started_at->format('d/m/Y') }}</span>
                            @endif
                        </td>
                        <td class="px-2.5 py-5 whitespace-nowrap align-top text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 text-[10px] font-semibold rounded-md border {{ $report->urgency_badge_classes }} shadow-2xs">
                                {{ $report->urgency_label }}
                            </span>
                        </td>
                        <td class="px-2.5 py-5 whitespace-nowrap align-top text-center">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[11px] font-semibold rounded-full border {{ $report->status_badge_classes }} gap-1 shadow-2xs whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-current shrink-0"></span>
                                <span>{{ $report->status_label }}</span>
                            </span>
                        </td>
                        <td class="px-4 py-5 text-center whitespace-nowrap align-top">
                            <div class="flex items-center justify-center gap-1.5">
                                <a
                                    href="{{ route('dokter-hewan.show', $report) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-2xs"
                                >
                                    <span>Lihat Detail</span>
                                </a>
                                @if($report->status !== 'selesai')
                                <a
                                    href="{{ route('dokter-hewan.show', $report) }}#form-tanggapan"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-2xs"
                                >
                                    <span>Tanggapi</span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="max-w-sm mx-auto space-y-2">
                                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                    @if($search)
                                        Tidak ditemukan laporan dengan kata kunci "{{ $search }}"
                                    @elseif($currentTab === 'masuk')
                                        Belum ada laporan baru yang masuk
                                    @elseif($currentTab === 'ditangani')
                                        Belum ada laporan yang sedang ditangani
                                    @elseif($currentTab === 'dijawab')
                                        Belum ada laporan yang sudah dijawab
                                    @elseif($currentTab === 'kunjungan')
                                        Belum ada laporan yang menunggu kunjungan
                                    @elseif($currentTab === 'selesai')
                                        Belum ada laporan dengan penanganan selesai
                                    @else
                                        Belum ada laporan kesehatan hewan yang perlu ditangani
                                    @endif
                                </h3>
                                <p class="text-xs text-gray-500">
                                    @if($search)
                                        Coba gunakan kata kunci pencarian yang lain atau reset filter pencarian.
                                    @elseif($currentTab === 'masuk')
                                        Laporan klinis baru yang diajukan oleh peternak di wilayah Jawa Timur akan muncul secara otomatis di sini.
                                    @elseif($currentTab === 'ditangani')
                                        Laporan yang Anda ambil untuk proses penanganan medis akan muncul di sini.
                                    @elseif($currentTab === 'dijawab')
                                        Laporan yang telah Anda kirimkan respons atau hipotesis awal akan tercatat di sini.
                                    @elseif($currentTab === 'kunjungan')
                                        Laporan yang membutuhkan kunjungan langsung ke lokasi peternak akan terdaftar di sini.
                                    @elseif($currentTab === 'selesai')
                                        Riwayat seluruh laporan yang penanganannya telah selesai dan tuntas akan tersimpan di sini.
                                    @else
                                        Laporan baru yang diajukan oleh peternak di wilayah Jawa Timur akan muncul secara otomatis di panel ini.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
            {{ $reports->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

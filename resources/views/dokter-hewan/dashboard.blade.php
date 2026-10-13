@extends('layouts.app')

@section('title', 'Dashboard Dokter Hewan — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-md">
                    Portal Tenaga Medis Veteriner
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Puskeswan Jawa Timur</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-1.5 leading-snug">
                Dashboard Dokter Hewan Dinas
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Pantau laporan klinis ternak dari peternak, berikan analisis dan rekomendasi profesional, serta kelola jadwal kunjungan lapangan.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0 bg-white dark:bg-gray-800 p-2.5 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
            <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-bold flex items-center justify-center text-xs">
                {{ $currentVet ? $currentVet->initials : 'DR' }}
            </div>
            <div class="text-left">
                <span class="text-xs font-bold text-gray-900 dark:text-white block">{{ auth()->user()->name }}</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 block">{{ $currentVet?->puskeswan ?? 'Puskeswan Disnak Jatim' }}</span>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik (Section 3.A Master Prompt) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- 1. Laporan Masuk -->
        <a href="{{ route('dokter-hewan.dashboard', ['tab' => 'masuk']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-amber-200/90 dark:border-amber-800/60 shadow-2xs hover:shadow-md hover:border-amber-400 transition-all">
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
        <a href="{{ route('dokter-hewan.dashboard', ['tab' => 'ditangani']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-blue-200/90 dark:border-blue-800/60 shadow-2xs hover:shadow-md hover:border-blue-400 transition-all">
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
        <a href="{{ route('dokter-hewan.dashboard', ['tab' => 'dijawab']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-indigo-200/90 dark:border-indigo-800/60 shadow-2xs hover:shadow-md hover:border-indigo-400 transition-all">
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
        <a href="{{ route('dokter-hewan.dashboard', ['tab' => 'kunjungan']) }}" class="group block bg-white dark:bg-gray-800 p-4 sm:p-5 rounded-2xl border border-orange-200/90 dark:border-orange-800/60 shadow-2xs hover:shadow-md hover:border-orange-400 transition-all">
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

    <!-- Filter Tab Bar & Search Form (Section 3.B Master Prompt) -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-4 shadow-2xs space-y-3.5">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 border-b border-gray-100 dark:border-gray-700 pb-3">
            <!-- Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar pb-1 text-xs">
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'semua', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'semua' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Semua Laporan ({{ $stats['total'] }})
                </a>
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'masuk', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'masuk' ? 'bg-amber-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Laporan Masuk ({{ $stats['laporan_masuk'] }})
                </a>
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'ditangani', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'ditangani' ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Sedang Ditangani ({{ $stats['sedang_ditangani'] }})
                </a>
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'dijawab', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'dijawab' ? 'bg-indigo-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Sudah Dijawab ({{ $stats['sudah_dijawab'] }})
                </a>
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'kunjungan', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'kunjungan' ? 'bg-orange-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Menunggu Kunjungan ({{ $stats['perlu_kunjungan'] }})
                </a>
                <a
                    href="{{ route('dokter-hewan.dashboard', ['tab' => 'selesai', 'search' => $search]) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'selesai' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                >
                    Selesai ({{ $stats['selesai'] }})
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('dokter-hewan.dashboard') }}" class="flex items-center gap-2 shrink-0">
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
                <a href="{{ route('dokter-hewan.dashboard', ['tab' => $currentTab]) }}" class="text-xs text-gray-500 hover:text-gray-700 px-1">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Daftar Laporan Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/60 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3">No. Laporan &amp; Waktu</th>
                        <th scope="col" class="px-4 py-3">Peternak &amp; Lokasi</th>
                        <th scope="col" class="px-4 py-3">Hewan Ternak</th>
                        <th scope="col" class="px-4 py-3">Keluhan / Gejala Utama</th>
                        <th scope="col" class="px-4 py-3">Urgensi</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-3.5">
                            <span class="font-mono font-bold text-gray-900 dark:text-white block">{{ $report->report_number }}</span>
                            <span class="text-[11px] text-gray-400 block mt-0.5">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="font-semibold text-gray-900 dark:text-white block">{{ $report->user->name }}</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 block">{{ $report->farm_name ?? 'Peternakan Rakyat' }}</span>
                            <span class="text-[10px] text-gray-400 block">{{ $report->kabupaten ?? 'Jawa Timur' }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="font-medium text-gray-800 dark:text-gray-200 block">{{ $report->livestock_type }}</span>
                            <span class="text-[11px] text-gray-500 block">{{ $report->affected_count }} ekor terdampak</span>
                        </td>
                        <td class="px-4 py-3.5 max-w-xs">
                            <p class="truncate text-gray-700 dark:text-gray-300 font-medium" title="{{ $report->symptoms }}">
                                {{ $report->symptoms }}
                            </p>
                            @if($report->symptoms_started_at)
                                <span class="text-[10px] text-gray-400 block mt-0.5">Gejala sejak: {{ $report->symptoms_started_at->format('d/m/Y') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md border {{ $report->urgency_badge_classes }}">
                                {{ $report->urgency_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full border {{ $report->status_badge_classes }} inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $report->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a
                                    href="{{ route('dokter-hewan.show', $report) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                                >
                                    Lihat Detail
                                </a>
                                @if($report->status !== 'selesai')
                                <a
                                    href="{{ route('dokter-hewan.show', $report) }}#form-tanggapan"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-2xs"
                                >
                                    Tanggapi
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
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada laporan kesehatan hewan yang perlu ditangani</h3>
                                <p class="text-xs text-gray-500">Laporan baru yang diajukan oleh peternak di wilayah Jawa Timur akan muncul secara otomatis di panel ini.</p>
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

@extends('layouts.app')

@section('title', 'Laporan Kesehatan Hewan Saya — Peternak Milenial Jatim')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-md">
                    Layanan Medis Veteriner
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Dinas Peternakan Provinsi Jawa Timur</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-1.5 leading-snug">
                Laporan Kesehatan Hewan Saya
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Laporkan gangguan kesehatan atau gejala klinis pada ternak Anda untuk mendapatkan analisis dan rekomendasi resmi dari Dokter Hewan Dinas.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a
                href="{{ route('kesehatan-hewan.create') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-4 py-2.5 rounded-xl transition shadow-xs cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Buat Laporan Baru</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Laporan Saya (Section 6 Master Prompt) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
            <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block">Total Laporan</span>
            <span class="text-2xl font-bold text-gray-900 dark:text-white mt-1 block">{{ $stats['total'] }}</span>
            <span class="text-[10px] text-gray-400 mt-0.5 block">Semua laporan yang dibuat</span>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-amber-200/90 dark:border-amber-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-medium text-amber-800 dark:text-amber-400">Menunggu Respons</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <span class="text-2xl font-bold text-amber-700 dark:text-amber-400 mt-1 block">{{ $stats['menunggu_respons'] }}</span>
            <span class="text-[10px] text-amber-600/80 mt-0.5 block">Belum ada tanggapan</span>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-indigo-200/90 dark:border-indigo-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-medium text-indigo-800 dark:text-indigo-400">Sudah Dijawab</span>
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
            </div>
            <span class="text-2xl font-bold text-indigo-700 dark:text-indigo-400 mt-1 block">{{ $stats['sudah_dijawab'] }}</span>
            <span class="text-[10px] text-indigo-600/80 mt-0.5 block">Dokter telah merespons</span>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-blue-200/90 dark:border-blue-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-medium text-blue-800 dark:text-blue-400">Sedang Ditangani</span>
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            </div>
            <span class="text-2xl font-bold text-blue-700 dark:text-blue-400 mt-1 block">{{ $stats['sedang_ditangani'] }}</span>
            <span class="text-[10px] text-blue-600/80 mt-0.5 block">Kunjungan / observasi aktif</span>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-emerald-200/90 dark:border-emerald-800/60 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-medium text-emerald-800 dark:text-emerald-400">Selesai</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <span class="text-2xl font-bold text-emerald-700 dark:text-emerald-400 mt-1 block">{{ $stats['selesai'] }}</span>
            <span class="text-[10px] text-emerald-600/80 mt-0.5 block">Penanganan tuntas</span>
        </div>
    </div>

    <!-- Filter Tabs & Table Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-4 shadow-2xs space-y-3.5">
        <!-- Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar pb-2 border-b border-gray-100 dark:border-gray-700 text-xs">
            <a
                href="{{ route('kesehatan-hewan.index', ['tab' => 'semua']) }}"
                class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'semua' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
            >
                Semua Laporan ({{ $stats['total'] }})
            </a>
            <a
                href="{{ route('kesehatan-hewan.index', ['tab' => 'menunggu_respons']) }}"
                class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'menunggu_respons' ? 'bg-amber-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
            >
                Menunggu Respons ({{ $stats['menunggu_respons'] }})
            </a>
            <a
                href="{{ route('kesehatan-hewan.index', ['tab' => 'sudah_dijawab']) }}"
                class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'sudah_dijawab' ? 'bg-indigo-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
            >
                Sudah Dijawab ({{ $stats['sudah_dijawab'] }})
            </a>
            <a
                href="{{ route('kesehatan-hewan.index', ['tab' => 'sedang_ditangani']) }}"
                class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'sedang_ditangani' ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
            >
                Sedang Ditangani ({{ $stats['sedang_ditangani'] }})
            </a>
            <a
                href="{{ route('kesehatan-hewan.index', ['tab' => 'selesai']) }}"
                class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'selesai' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
            >
                Selesai ({{ $stats['selesai'] }})
            </a>
        </div>

        <!-- Table Laporan (Section 6 Master Prompt) -->
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/60 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3">No. Laporan</th>
                        <th scope="col" class="px-4 py-3">Tanggal Laporan</th>
                        <th scope="col" class="px-4 py-3">Jenis Hewan</th>
                        <th scope="col" class="px-4 py-3">Ringkasan Keluhan</th>
                        <th scope="col" class="px-4 py-3">Status Terbaru</th>
                        <th scope="col" class="px-4 py-3">Respons Terakhir</th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-3.5">
                            <span class="font-mono font-bold text-gray-900 dark:text-white block">{{ $report->report_number }}</span>
                            <span class="text-[10px] text-gray-400">Urgensi: {{ $report->urgency_label }}</span>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="text-gray-800 dark:text-gray-200 block">{{ $report->created_at->format('d M Y') }}</span>
                            <span class="text-[10px] text-gray-400">{{ $report->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="font-semibold text-gray-900 dark:text-white block">{{ $report->livestock_type }}</span>
                            <span class="text-[11px] text-gray-500">{{ $report->affected_count }} Ekor</span>
                        </td>
                        <td class="px-4 py-3.5 max-w-xs">
                            <p class="truncate text-gray-700 dark:text-gray-300 font-medium" title="{{ $report->symptoms }}">
                                {{ $report->symptoms }}
                            </p>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full border {{ $report->status_badge_classes }} inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $report->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-[11px]">
                            @if($report->last_responded_at)
                                <span class="text-gray-800 dark:text-gray-200 font-medium block">{{ $report->last_responded_at->format('d M Y, H:i') }}</span>
                                <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">Telah Ditanggapi</span>
                            @else
                                <span class="text-gray-400 italic">Belum tersedia</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                @if($report->last_responded_at)
                                <a
                                    href="{{ route('kesehatan-hewan.show', $report) }}#tanggapan-dokter"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/60 dark:text-indigo-300 transition"
                                >
                                    Lihat Tanggapan
                                </a>
                                @endif
                                <a
                                    href="{{ route('kesehatan-hewan.show', $report) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                                >
                                    Lihat Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="max-w-sm mx-auto space-y-2">
                                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada laporan kesehatan hewan</h3>
                                <p class="text-xs text-gray-500">Jika ternak Anda mengalami gejala sakit, ajukan laporan untuk segera ditindaklanjuti dokter hewan dinas.</p>
                                <a href="{{ route('kesehatan-hewan.create') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary-700 hover:text-primary-800 mt-2">
                                    <span>+ Buat Laporan Pertama</span>
                                </a>
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

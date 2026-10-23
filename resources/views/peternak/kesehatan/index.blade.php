@extends('layouts.app')

@section('title', 'Laporan Kesehatan Hewan Saya — Peternak Milenial Jatim')

@section('content')
    <div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                    Laporan Kesehatan Hewan Saya
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Laporkan gangguan kesehatan atau gejala klinis pada ternak Anda untuk mendapatkan analisis dan
                    rekomendasi resmi dari Dokter Hewan Dinas.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('kesehatan-hewan.create') }}"
                    class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-4 py-2.5 rounded-xl transition shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
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

            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-amber-200/90 dark:border-amber-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-amber-800 dark:text-amber-400">Menunggu Respons</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <span
                    class="text-2xl font-bold text-amber-700 dark:text-amber-400 mt-1 block">{{ $stats['menunggu_respons'] }}</span>
                <span class="text-[10px] text-amber-600/80 mt-0.5 block">Belum ada tanggapan</span>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-indigo-200/90 dark:border-indigo-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-indigo-800 dark:text-indigo-400">Sudah Dijawab</span>
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                </div>
                <span
                    class="text-2xl font-bold text-indigo-700 dark:text-indigo-400 mt-1 block">{{ $stats['sudah_dijawab'] }}</span>
                <span class="text-[10px] text-indigo-600/80 mt-0.5 block">Dokter telah merespons</span>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-blue-200/90 dark:border-blue-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-blue-800 dark:text-blue-400">Sedang Ditangani</span>
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </div>
                <span
                    class="text-2xl font-bold text-blue-700 dark:text-blue-400 mt-1 block">{{ $stats['sedang_ditangani'] }}</span>
                <span class="text-[10px] text-blue-600/80 mt-0.5 block">Kunjungan / observasi aktif</span>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-emerald-200/90 dark:border-emerald-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-emerald-800 dark:text-emerald-400">Selesai</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                <span
                    class="text-2xl font-bold text-emerald-700 dark:text-emerald-400 mt-1 block">{{ $stats['selesai'] }}</span>
                <span class="text-[10px] text-emerald-600/80 mt-0.5 block">Penanganan tuntas</span>
            </div>
        </div>

        <!-- Filter Tabs & Table Section -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-4 shadow-2xs space-y-3.5">
            <!-- Tabs -->
            <div
                class="flex items-center gap-1.5 overflow-x-auto custom-scrollbar pb-2 border-b border-gray-100 dark:border-gray-700 text-xs">
                <a href="{{ route('kesehatan-hewan.index', ['tab' => 'semua']) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'semua' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Semua Laporan ({{ $stats['total'] }})
                </a>
                <a href="{{ route('kesehatan-hewan.index', ['tab' => 'menunggu_respons']) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'menunggu_respons' ? 'bg-amber-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Menunggu Respons ({{ $stats['menunggu_respons'] }})
                </a>
                <a href="{{ route('kesehatan-hewan.index', ['tab' => 'sudah_dijawab']) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'sudah_dijawab' ? 'bg-indigo-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Sudah Dijawab ({{ $stats['sudah_dijawab'] }})
                </a>
                <a href="{{ route('kesehatan-hewan.index', ['tab' => 'sedang_ditangani']) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'sedang_ditangani' ? 'bg-blue-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Sedang Ditangani ({{ $stats['sedang_ditangani'] }})
                </a>
                <a href="{{ route('kesehatan-hewan.index', ['tab' => 'selesai']) }}"
                    class="px-3 py-1.5 rounded-lg font-medium transition shrink-0 {{ $currentTab === 'selesai' ? 'bg-emerald-600 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Selesai ({{ $stats['selesai'] }})
                </a>
            </div>

            <!-- Desktop Table View (Spacious, balanced columns, no tight text, fits 100% with NO horizontal scrollbar) -->
            <div
                class="hidden md:block overflow-hidden rounded-xl border border-gray-200/80 dark:border-gray-700 bg-white dark:bg-gray-800">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead
                        class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50/90 dark:bg-gray-700/60 border-b border-gray-200 dark:border-gray-700 font-semibold tracking-wider text-center">
                        <tr>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap w-[23%] text-center">No. Laporan &amp;
                                Waktu</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap w-[18%] text-center">Jenis Hewan</th>
                            <th scope="col" class="px-6 py-4 w-[35%] text-center">Ringkasan Keluhan</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap w-[14%] text-center">Status &amp; Respons
                            </th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap w-[10%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                                <!-- Col 1: No. Laporan, Waktu & Urgensi -->
                                <td class="px-6 py-5 whitespace-nowrap align-top text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="font-mono font-bold text-gray-900 dark:text-white block text-[13px] tracking-normal">{{ $report->report_number }}</span>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400 block mt-1.5">{{ $report->created_at->format('d M Y, H:i') }}
                                            WIB</span>
                                        <div class="mt-2.5">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-semibold border {{ $report->urgency_badge_classes }}">
                                                Urgensi: {{ $report->urgency_label }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Col 2: Jenis Hewan & Jumlah -->
                                <td class="px-6 py-5 whitespace-nowrap align-top text-center">
                                    <span
                                        class="font-semibold text-gray-900 dark:text-white block text-[13px] leading-snug">{{ $report->livestock_type }}</span>
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400 block mt-1.5">{{ $report->affected_count }}
                                        Ekor terdampak</span>
                                </td>

                                <!-- Col 3: Ringkasan Keluhan (Full text, spacious line-height, beautiful wrap, justified) -->
                                <td class="px-6 py-5 align-top">
                                    <p
                                        class="text-xs sm:text-[13px] text-gray-800 dark:text-gray-200 leading-relaxed font-normal whitespace-normal break-words text-justify">
                                        {{ $report->symptoms }}
                                    </p>
                                    @if ($report->symptoms_started_at)
                                        <div class="mt-2.5">
                                            <span
                                                class="inline-flex items-center gap-1.5 text-[11px] text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-750 px-2 py-0.5 rounded border border-gray-200/60 dark:border-gray-700">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Gejala sejak: {{ $report->symptoms_started_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </td>

                                <!-- Col 4: Status Terbaru & Tanggapan Dokter -->
                                <td class="px-6 py-5 whitespace-nowrap align-top text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="px-3 py-1 text-[11px] font-semibold rounded-full border {{ $report->status_badge_classes }} inline-flex items-center gap-1.5 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $report->status_label }}
                                        </span>
                                        <div class="mt-2 text-[11px]">
                                            @if ($report->assignedVeterinarian)
                                                <span class="font-semibold text-gray-700 dark:text-gray-300 block">
                                                    {{ $report->assignedVeterinarian->name }}
                                                </span>
                                            @else
                                                <span class="text-amber-600 dark:text-amber-400 font-medium block">
                                                    Menunggu Penugasan
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-1 text-[11px]">
                                            @if ($report->last_responded_at)
                                                <span
                                                    class="text-emerald-700 dark:text-emerald-400 font-semibold inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                                        stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    Ditanggapi {{ $report->last_responded_at->format('d M, H:i') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 italic block">Menunggu
                                                    respons dokter</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Col 5: Aksi -->
                                <td class="px-6 py-5 whitespace-nowrap align-top text-center">
                                    <a href="{{ route('kesehatan-hewan.show', $report) }}"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900/60 transition shadow-2xs">
                                        <span>Lihat Detail</span>
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="max-w-sm mx-auto space-y-2">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada laporan
                                            kesehatan hewan</h3>
                                        <p class="text-xs text-gray-500">Jika ternak Anda mengalami gejala sakit, ajukan
                                            laporan untuk segera ditindaklanjuti dokter hewan dinas.</p>
                                        <a href="{{ route('kesehatan-hewan.create') }}"
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-primary-700 hover:text-primary-800 mt-2">
                                            <span>+ Buat Laporan Pertama</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (Shown on screens < md, completely responsive with NO horizontal scrollbar) -->
            <div class="block md:hidden space-y-3">
                @forelse($reports as $report)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 p-4 space-y-3 shadow-2xs">
                        <!-- Header Card: No. Laporan & Status Badge -->
                        <div
                            class="flex items-start justify-between gap-2 pb-2.5 border-b border-gray-100 dark:border-gray-700">
                            <div>
                                <span
                                    class="font-mono font-bold text-gray-900 dark:text-white text-xs block tracking-tight">{{ $report->report_number }}</span>
                                <span
                                    class="text-[11px] text-gray-400 block mt-0.5">{{ $report->created_at->format('d M Y, H:i') }}
                                    WIB</span>
                            </div>
                            <span
                                class="px-2.5 py-1 text-[10px] font-semibold rounded-full border {{ $report->status_badge_classes }} inline-flex items-center gap-1 shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $report->status_label }}
                            </span>
                        </div>

                        <!-- Info Ternak & Urgensi -->
                        <div class="flex items-center justify-between text-xs">
                            <div>
                                <span
                                    class="font-semibold text-gray-900 dark:text-white block">{{ $report->livestock_type }}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ $report->affected_count }}
                                    Ekor terdampak</span>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold border {{ $report->urgency_badge_classes }}">
                                Urgensi: {{ $report->urgency_label }}
                            </span>
                        </div>

                        <!-- Gejala Keluhan -->
                        <div
                            class="p-3 bg-gray-50/80 dark:bg-gray-750/50 rounded-lg border border-gray-100 dark:border-gray-700/60">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Keluhan
                                Gejala:</span>
                            <p class="text-xs text-gray-800 dark:text-gray-200 leading-relaxed break-words text-justify">
                                {{ $report->symptoms }}
                            </p>
                            @if ($report->symptoms_started_at)
                                <span class="text-[10px] text-gray-400 block mt-1.5">
                                    Gejala sejak: {{ $report->symptoms_started_at->format('d M Y') }}
                                </span>
                            @endif
                        </div>

                        <!-- Tanggapan & Aksi -->
                        <div
                            class="pt-2 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="text-[11px]">
                                @if ($report->last_responded_at)
                                    <span
                                        class="text-emerald-700 dark:text-emerald-400 font-semibold inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor"
                                            stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Ditanggapi {{ $report->last_responded_at->format('d M, H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">Menunggu tanggapan</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kesehatan-hewan.show', $report) }}"
                                    class="flex-1 sm:flex-none text-center px-3.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="p-8 text-center text-gray-500 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-medium">Belum ada laporan kesehatan hewan</p>
                    </div>
                @endforelse
            </div>

            @if ($reports->hasPages())
                <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

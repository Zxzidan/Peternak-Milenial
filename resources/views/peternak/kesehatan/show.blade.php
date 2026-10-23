@extends('layouts.app')

@section('title', 'Laporan ' . $report->report_number . ' — Peternak Milenial Jatim')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Top Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('kesehatan-hewan.index') }}" class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    <span>Kembali ke Laporan Saya</span>
                </a>
                <span class="text-gray-300">/</span>
                <span class="font-mono text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $report->report_number }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-1.5 leading-snug">
                Detail Laporan &amp; Respons Dokter Hewan
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Dibuat pada {{ $report->created_at->format('d F Y, H:i') }} WIB
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $report->status_badge_classes }} inline-flex items-center gap-1.5 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-current"></span>
                <span>{{ $report->status_label }}</span>
            </span>
            <span class="px-2.5 py-1 rounded-md text-xs font-bold border {{ $report->urgency_badge_classes }}">
                Urgensi: {{ $report->urgency_label }}
            </span>
            @if($report->status === 'selesai')
            <a href="{{ route('konsultasi.rekam-medis.download', ['type' => 'report', 'id' => $report->id]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-2xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                <span>Download PDF</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Main Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Responses, Doctor Advice & Replies (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- 1. Jadwal & Konfirmasi Kunjungan Lapangan (Jika ada usulan dokter) -->
            @if($report->visits->isNotEmpty())
            @php $latestVisit = $report->visits->first(); @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-orange-200/90 dark:border-orange-800/60 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-orange-100 dark:border-orange-900/40 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Usulan Kunjungan Lapangan Dokter Hewan</h2>
                            <span class="text-[11px] text-gray-400">Pemeriksaan fisik on-site di kandang peternakan Anda</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $latestVisit->status_badge_classes }}">
                        {{ $latestVisit->status_label }}
                    </span>
                </div>

                <div class="p-3.5 bg-orange-50/60 dark:bg-orange-950/20 rounded-xl border border-orange-200/80 dark:border-orange-900/40 space-y-3 text-xs">
                    <div>
                        <span class="text-[11px] font-semibold text-gray-500 block">Alasan Kunjungan oleh Dokter:</span>
                        <p class="font-medium text-gray-800 dark:text-gray-200 mt-0.5">{{ $latestVisit->visit_reason }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-orange-200/60 dark:border-orange-900/40">
                        <div>
                            <span class="text-[11px] text-gray-500 block">Jadwal Diusulkan Dokter:</span>
                            <span class="font-bold text-orange-800 dark:text-orange-300 text-sm">
                                {{ $latestVisit->proposed_date->format('d F Y, H:i') }} WIB
                            </span>
                        </div>
                        @if($latestVisit->confirmed_date)
                        <div>
                            <span class="text-[11px] text-gray-500 block">Status Kesepakatan:</span>
                            <span class="font-bold text-emerald-700 dark:text-emerald-300 text-xs">
                                ✓ Telah Anda Konfirmasi Siap Dikunjungi
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Tombol Konfirmasi Jadwal (Jika Masih Menunggu Konfirmasi) -->
                    @if($latestVisit->status === 'menunggu_konfirmasi')
                    <div class="pt-3 border-t border-orange-200 dark:border-orange-900/60 space-y-2">
                        <p class="text-gray-600 dark:text-gray-400 text-xs">
                            Dokter hewan siap berkunjung ke peternakan Anda pada jadwal di atas. Silakan konfirmasi kesediaan Anda:
                        </p>
                        <form method="POST" action="{{ route('kesehatan-hewan.visit.confirm', [$report, $latestVisit]) }}" class="space-y-2">
                            @csrf
                            <input
                                type="text"
                                name="farmer_notes"
                                placeholder="Catatan untuk dokter (contoh: 'Siap, kandang buka jam 08.00 pagi, patokan dekat masjid')"
                                class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"
                            >
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition cursor-pointer shadow-xs"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>Konfirmasi &amp; Setujui Jadwal Kunjungan</span>
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Hasil Pemeriksaan Pasca Kunjungan -->
                    @if($latestVisit->examination_notes)
                    <div class="mt-3 p-3.5 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="font-bold text-gray-900 dark:text-white block">Hasil Pemeriksaan Klinis di Kandang:</span>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $latestVisit->examination_notes }}</p>
                        @if($latestVisit->post_visit_recommendations)
                        <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="font-bold text-emerald-800 dark:text-emerald-400 block">Rekomendasi Lanjutan untuk Anda:</span>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $latestVisit->post_visit_recommendations }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- 2. Riwayat Tanggapan Dokter & Komunikasi Lanjutan -->
            <div id="tanggapan-dokter" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518z"/></svg>
                        <span>Tanggapan &amp; Rekomendasi Dokter Hewan</span>
                    </h2>
                    <span class="text-xs text-gray-400">Riwayat Penanganan</span>
                </div>

                @if($report->responses->isEmpty())
                <div class="p-8 text-center text-gray-500 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 text-xs">
                    <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="font-bold text-gray-700 dark:text-gray-300">Laporan Anda Sedang Menunggu Pemeriksaan Dokter</p>
                    <p class="text-gray-400 mt-1 max-w-sm mx-auto">Dokter hewan dinas penugasan wilayah akan segera memeriksa keluhan Anda dan mengirimkan analisis serta arahan penanganan di panel ini.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($report->responses as $response)
                    <div class="p-4 rounded-xl border text-xs {{ $response->isFromDoctor() ? 'bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200/90 dark:border-emerald-800/60' : 'bg-gray-50 dark:bg-gray-700/40 border-gray-200/80 dark:border-gray-700' }}">
                        <div class="flex items-center justify-between pb-2 border-b border-black/5 dark:border-white/5">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 dark:text-white">
                                    {{ $response->user->name }}
                                </span>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md {{ $response->isFromDoctor() ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                    {{ $response->isFromDoctor() ? 'Dokter Hewan Dinas' : 'Anda (Peternak)' }}
                                </span>
                            </div>
                            <span class="text-[11px] text-gray-400">
                                {{ $response->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>

                        <!-- Pesan Utama -->
                        <div class="mt-3 text-gray-800 dark:text-gray-200 whitespace-pre-line leading-relaxed">
                            {{ $response->message }}
                        </div>

                        <!-- Blok Dugaan Masalah & Rekomendasi (Dari Dokter) -->
                        @if($response->isFromDoctor())
                            @if($response->hypothesis)
                            <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-amber-200 dark:border-amber-800/60 space-y-1">
                                <span class="font-bold text-amber-800 dark:text-amber-300 text-[11px] flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    <span>Dugaan Masalah / Kondisi Awal:</span>
                                </span>
                                <p class="text-gray-700 dark:text-gray-300 italic">{{ $response->hypothesis }}</p>
                                <span class="text-[10px] text-gray-400 block">*Catatan: Ini merupakan dugaan klinis awal dokter berdasarkan gejala yang Anda laporkan.</span>
                            </div>
                            @endif

                            @if($response->recommendations)
                            <div class="mt-2.5 p-3 bg-white dark:bg-gray-800 rounded-lg border border-emerald-200 dark:border-emerald-800/60 space-y-1">
                                <span class="font-bold text-emerald-800 dark:text-emerald-300 text-[11px]">Rekomendasi Penanganan Awal yang Harus Dilakukan:</span>
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line font-medium">{{ $response->recommendations }}</p>
                            </div>
                            @endif

                            @if($response->follow_up_instructions)
                            <div class="mt-2.5 p-3 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-800/60 space-y-1">
                                <span class="font-bold text-blue-800 dark:text-blue-300 text-[11px]">Instruksi Tindak Lanjut untuk Anda:</span>
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $response->follow_up_instructions }}</p>
                            </div>
                            @endif
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Form Balas / Berikan Informasi Tambahan (Peternak) -->
                @if($report->status !== 'selesai')
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <form method="POST" action="{{ route('kesehatan-hewan.reply', $report) }}" class="space-y-3 text-xs">
                        @csrf
                        <label class="block font-bold text-gray-800 dark:text-gray-200">
                            Kirim Informasi Tambahan / Perkembangan Kondisi Ternak:
                        </label>
                        <textarea
                            name="message"
                            rows="3"
                            required
                            placeholder="Tuliskan perkembangan suhu, nafsu makan ternak, atau pertanyaan lanjutan kepada dokter..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"
                        ></textarea>
                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer"
                            >
                                <span>Kirim ke Dokter Hewan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Data Ternak & Riwayat Penanganan (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Data Hewan & Keluhan yang dilaporkan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3.5 text-xs">
                <h3 class="font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2.5">
                    Data Laporan Anda
                </h3>

                <div class="space-y-2.5">
                    @if($report->consultation)
                    <div class="p-2.5 bg-primary-50/70 dark:bg-primary-950/40 rounded-xl border border-primary-200/70 dark:border-primary-800/60">
                        <span class="text-[10px] font-bold text-primary-700 dark:text-primary-300 uppercase tracking-wider block">Sesi Konsultasi Terjadwal</span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="font-mono font-bold text-xs text-primary-900 dark:text-primary-200">{{ $report->consultation->booking_code }}</span>
                            <span class="text-[11px] text-primary-700 dark:text-primary-300">{{ $report->consultation->consultation_time }}</span>
                        </div>
                    </div>
                    @endif

                    <div>
                        <span class="text-[11px] text-gray-400 block">Jenis Hewan Ternak</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block mt-0.5">{{ $report->livestock_type }} ({{ $report->affected_count }} Ekor)</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block">Mulai Gejala</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200 block mt-0.5">{{ $report->symptoms_started_at ? $report->symptoms_started_at->format('d M Y') : 'Belum ditentukan' }}</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block">Keluhan yang Dilaporkan</span>
                        <p class="text-gray-700 dark:text-gray-300 mt-0.5 bg-gray-50 dark:bg-gray-700/40 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700 leading-relaxed font-medium">
                            {{ $report->symptoms }}
                        </p>
                    </div>

                    @if($report->photo_path)
                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Foto Kondisi Ternak</span>
                        <a href="{{ asset('storage/' . $report->photo_path) }}" target="_blank" class="block rounded-lg overflow-hidden border border-gray-200 shadow-2xs hover:opacity-95">
                            <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto Ternak" class="w-full h-36 object-cover">
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Dokter yang Menangani -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3 text-xs">
                <h3 class="font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">
                    Dokter Hewan Dinas
                </h3>

                @if($report->assignedVeterinarian)
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs">
                            {{ $report->assignedVeterinarian->initials }}
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white block">{{ $report->assignedVeterinarian->name }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ $report->assignedVeterinarian->puskeswan }}</span>
                        </div>
                    </div>
                    <span class="text-[11px] text-gray-500 block">Spesialisasi: {{ $report->assignedVeterinarian->specialization }}</span>
                </div>
                @else
                <p class="text-gray-500 italic text-[11px]">Sedang dalam penugasan dokter Puskeswan setempat.</p>
                @endif
            </div>

            <!-- Riwayat Status Penanganan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3 text-xs">
                <h3 class="font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">
                    Riwayat Perkembangan Status
                </h3>

                <div class="space-y-2 max-h-52 overflow-y-auto custom-scrollbar">
                    @foreach($report->statusHistories as $history)
                    <div class="p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $history->getStatusLabel($history->new_status) }}</span>
                            <span class="text-[10px] text-gray-400">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($history->notes)
                            <p class="text-gray-500 mt-0.5 italic">{{ $history->notes }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

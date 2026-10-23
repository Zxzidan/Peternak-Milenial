@extends('layouts.app')

@section('title', 'Detail Laporan ' . $report->report_number . ' — Dokter Hewan Dinas')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">    <!-- Top Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-2">
                <span class="font-mono text-xs font-semibold text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800">{{ $report->report_number }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-normal">
                Pemeriksaan Klinis Laporan Kesehatan Ternak
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                Diajukan oleh <strong class="text-gray-700 dark:text-gray-300">{{ $report->user->name }}</strong> pada {{ $report->created_at->format('d F Y, H:i') }} WIB
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $report->status_badge_classes }} inline-flex items-center gap-1.5 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-current"></span>
                <span>{{ $report->status_label }}</span>
            </span>
            <span class="px-3 py-1.5 rounded-md text-xs font-bold border {{ $report->urgency_badge_classes }}">
                Urgensi: {{ $report->urgency_label }}
            </span>
        </div>
    </div>

    @if($report->status === 'menunggu_respons')
    <!-- Quick Action Banner for Doctor to Immediately Handle Report -->
    <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/60 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-2xs">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/60 text-amber-700 dark:text-amber-300 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-amber-900 dark:text-amber-200">Laporan Baru Menunggu Respons</h2>
                <p class="text-xs text-amber-800 dark:text-amber-300 mt-1 leading-relaxed">
                    Peternak sedang menunggu tindakan dari Dokter Hewan Dinas. Anda dapat langsung mengambil kasus ini agar peternak mengetahui bahwa laporan sedang diperiksa secara klinis.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
            <form method="POST" action="{{ route('dokter-hewan.status.update', $report) }}" class="w-full sm:w-auto">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="sedang_ditangani">
                <input type="hidden" name="notes" value="Dokter hewan resmi mengambil alih dan mulai menangani laporan secara klinis.">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-xl shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Mulai Tangani Laporan</span>
                </button>
            </form>
            <a href="#form-tanggapan" class="w-full sm:w-auto inline-flex items-center justify-center gap-1 px-3.5 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl shadow-2xs transition">
                <span>Tulis Solusi Medis</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Main Content Layout (2 Columns: Left 8 cols, Right 4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-7">

        <!-- Left Column: Medical Inspection & Conversations (8 Cols) -->
        <div class="lg:col-span-8 space-y-6 sm:space-y-7">

            <!-- 1. Informasi Kesehatan Hewan & Gejala Klinis -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 sm:p-6 shadow-2xs space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3.5">
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        <span>Informasi Klinis &amp; Keluhan Hewan</span>
                    </h2>
                    <span class="text-xs text-gray-400">Data Dilaporkan Peternak</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 space-y-1">
                        <span class="text-[11px] text-gray-400 block">Jenis Ternak</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">{{ $report->livestock_type }}</span>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 space-y-1">
                        <span class="text-[11px] text-gray-400 block">Jumlah Hewan Sakit</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">{{ $report->affected_count }} Ekor</span>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 space-y-1">
                        <span class="text-[11px] text-gray-400 block">Mulai Muncul Gejala</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">
                            {{ $report->symptoms_started_at ? $report->symptoms_started_at->format('d M Y') : 'Belum tersedia' }}
                        </span>
                    </div>
                </div>

                <!-- Gejala yang dilaporkan -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block">Gejala &amp; Keluhan yang Dilaporkan:</label>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 text-xs text-gray-800 dark:text-gray-200 leading-relaxed font-medium">
                        {{ $report->symptoms }}
                    </div>
                </div>


                <!-- Foto Pendukung -->
                @if($report->photo_path)
                <div class="pt-2 border-t border-gray-100 dark:border-gray-700 space-y-2">
                    <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block">Foto / Bukti Klinis dari Peternak:</label>
                    <a href="{{ asset('storage/' . $report->photo_path) }}" target="_blank" class="block max-w-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-2xs hover:opacity-95 transition">
                        <img src="{{ asset('storage/' . $report->photo_path) }}" alt="Foto Klinis Hewan" class="w-full h-48 object-cover">
                    </a>
                </div>
                @endif
            </div>

            <!-- 2. Kunjungan Lapangan Terkini (Jika ada) -->
            @if($report->visits->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-orange-200/90 dark:border-orange-800/60 p-5 sm:p-6 shadow-2xs space-y-5">
                <div class="flex items-center justify-between border-b border-orange-100 dark:border-orange-900/40 pb-3.5">
                    <h2 class="text-sm font-bold text-orange-900 dark:text-orange-300 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span>Status Kunjungan Lapangan Dokter Hewan</span>
                    </h2>
                    @php $latestVisit = $report->visits->first(); @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $latestVisit->status_badge_classes }}">
                        {{ $latestVisit->status_label }}
                    </span>
                </div>

                @foreach($report->visits as $visit)
                <div class="p-4 bg-orange-50/50 dark:bg-orange-950/20 rounded-xl border border-orange-200/80 dark:border-orange-900/50 space-y-4 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <span class="font-bold text-gray-900 dark:text-white block">Alasan Kunjungan:</span>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $visit->visit_reason }}</p>
                        </div>
                        <div class="sm:text-right shrink-0">
                            <span class="text-[11px] text-gray-500 block">Jadwal Diusulkan:</span>
                            <span class="font-bold text-orange-800 dark:text-orange-300 text-xs">{{ $visit->proposed_date->format('d F Y, H:i') }} WIB</span>
                        </div>
                    </div>

                    @if($visit->confirmed_date)
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-950/40 rounded-lg border border-emerald-200 text-emerald-800 dark:text-emerald-300 text-xs space-y-1">
                        <div><strong>Jadwal Disepakati:</strong> {{ $visit->confirmed_date->format('d F Y, H:i') }} WIB</div>
                        @if($visit->farmer_notes)
                            <span class="block text-[11px] text-emerald-700 leading-relaxed">Catatan Peternak: {{ $visit->farmer_notes }}</span>
                        @endif
                    </div>
                    @endif

                    @if($visit->examination_notes)
                    <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 space-y-2">
                        <span class="font-bold text-gray-900 dark:text-white block">Hasil Pemeriksaan Klinis Lapangan:</span>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $visit->examination_notes }}</p>
                        @if($visit->post_visit_recommendations)
                        <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="font-bold text-primary-700 dark:text-primary-400 block">Rekomendasi Tindak Lanjut Pasca Kunjungan:</span>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $visit->post_visit_recommendations }}</p>
                        </div>
                        @endif
                    </div>
                    @elseif($visit->status === 'terjadwal' || $visit->status === 'sedang_berlangsung')
                    <!-- Form Catat Hasil Pemeriksaan Lapangan oleh Dokter -->
                    <div class="pt-2 border-t border-orange-200 dark:border-orange-900/60">
                        <button
                            type="button"
                            onclick="document.getElementById('form-catat-kunjungan-{{ $visit->id }}').classList.toggle('hidden')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 011.13-1.897L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            <span>Catat Hasil Pemeriksaan Lapangan</span>
                        </button>

                        <form id="form-catat-kunjungan-{{ $visit->id }}" method="POST" action="{{ route('dokter-hewan.visit.complete', [$report, $visit]) }}" class="mt-4 space-y-4 bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 hidden">
                            @csrf
                            <h4 class="font-bold text-gray-900 dark:text-white">Formulir Hasil Pemeriksaan di Peternakan</h4>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">Hasil Pemeriksaan Klinis &amp; Tindakan Medis yang Diberikan <span class="text-red-500">*</span></label>
                                <textarea name="examination_notes" rows="3" required placeholder="Catat kondisi klinis dan tindakan medis..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"></textarea>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">Rekomendasi Tindak Lanjut Peternak Pasca Kunjungan</label>
                                <textarea name="post_visit_recommendations" rows="2" placeholder="Instruksi tindak lanjut pasca kunjungan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"></textarea>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Laporan Setelah Kunjungan <span class="text-red-500">*</span></label>
                                <select name="next_report_status" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                    <option value="selesai">Selesai (Penanganan Tuntas)</option>
                                    <option value="menunggu_tindak_lanjut">Menunggu Tindak Lanjut (Observasi Mandiri Peternak)</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="document.getElementById('form-catat-kunjungan-{{ $visit->id }}').classList.add('hidden')" class="px-3 py-1.5 text-xs text-gray-600 bg-gray-100 rounded-lg">Batal</button>
                                <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-lg">Simpan Hasil Pemeriksaan</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif


            <!-- 4. Formulir Tanggapan Dokter Hewan (Section 4 Master Prompt) -->
            <div id="form-tanggapan" class="bg-white dark:bg-gray-800 rounded-2xl border border-primary-200/80 dark:border-primary-800/60 p-5 sm:p-6 shadow-2xs space-y-4">
                <div class="border-b border-gray-100 dark:border-gray-700 pb-3">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 011.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        <span>Formulir Tanggapan &amp; Rekomendasi Profesional</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Berikan tanggapan resmi dengan membedakan antara dugaan awal dan rekomendasi penanganan awal bagi peternak.
                    </p>
                </div>

                <form method="POST" action="{{ route('dokter-hewan.response.store', $report) }}" class="space-y-4 sm:space-y-5 text-xs">
                    @csrf

                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Pesan &amp; Hasil Analisis Awal Dokter <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="message"
                            rows="4"
                            required
                            placeholder="Tuliskan evaluasi klinis awal..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Dugaan Masalah / Kondisi Awal (Berdasarkan Gejala)
                            </label>
                            <input
                                type="text"
                                name="hypothesis"
                                placeholder="Contoh: Suspek Mastitis Subklinis"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                            >
                            <span class="text-[10px] text-gray-400 mt-1 block">Bersifat dugaan awal, bukan diagnosis definitif.</span>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tingkat Urgensi Tindak Lanjut
                            </label>
                            <select name="urgency_level" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                                <option value="sedang">Sedang (Dalam 24-48 Jam)</option>
                                <option value="tinggi">Tinggi (Perlu Segera Ditangani Hari Ini)</option>
                                <option value="kritis">Kritis (Darurat Medis / Isolasi Segera)</option>
                                <option value="rendah">Rendah (Dapat Diobservasi Mandiri)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Rekomendasi Penanganan Awal
                            </label>
                            <textarea
                                name="recommendations"
                                rows="3"
                                placeholder="Rekomendasi penanganan awal ternak..."
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Instruksi Tindak Lanjut bagi Peternak
                            </label>
                            <textarea
                                name="follow_up_instructions"
                                rows="3"
                                placeholder="Instruksi tindak lanjut bagi peternak..."
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Checklist Perlu Kunjungan Lapangan & Status Target -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 space-y-3.5">
                        <div class="flex items-center gap-2">
                            <input
                                id="requires_visit_check"
                                type="checkbox"
                                name="requires_visit"
                                value="1"
                                class="w-4 h-4 text-primary-600 bg-white border-gray-300 rounded focus:ring-primary-500"
                            >
                            <label for="requires_visit_check" class="font-bold text-gray-800 dark:text-gray-200 cursor-pointer">
                                Kasus ini memerlukan Kunjungan Langsung ke Lokasi Peternakan
                            </label>
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 pl-6 leading-relaxed">
                            Centang jika hewan membutuhkan palpasi, injeksi langsung, atau sampling laboratorium di kandang peternak.
                        </p>

                        <div class="pt-2.5 border-t border-gray-200 dark:border-gray-600 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Status Penanganan Setelah Tanggapan Ini <span class="text-red-500">*</span>
                                </label>
                                <select name="target_status" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                                    <option value="sudah_dijawab">Sudah Dijawab (Respons Awal Terkirim)</option>
                                    <option value="sedang_ditangani">Sedang Ditangani (Memerlukan Pemantauan Aktif)</option>
                                    <option value="menunggu_kunjungan">Menunggu Kunjungan (Persiapan Jadwal Lapangan)</option>
                                    <option value="menunggu_tindak_lanjut">Menunggu Tindak Lanjut dari Peternak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan Tambahan Dokter (Opsional)</label>
                                <input type="text" name="notes" placeholder="Catatan internal dinas..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <span class="text-[11px] text-gray-400">
                            Tanggapan akan tersimpan permanen dalam rekam riwayat penanganan laporan.
                        </span>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer"
                        >
                            <span>Kirim Tanggapan Profesional</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Column: Peternak Info & Actions / Audit Trail (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- 1. Profil Peternak & Lokasi Usaha -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 sm:p-6 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3.5">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Informasi Pelapor</h3>
                    <span class="text-[10px] uppercase font-bold text-primary-700 bg-primary-50 px-2.5 py-1 rounded-md">Peternak</span>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Nama Lengkap Peternak</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">{{ $report->user->name }}</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Kontak Telepon / WhatsApp</span>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $report->user->phone_number ?: 'Belum tersedia' }}</span>
                            @if($report->user->phone_number)
                            <a
                                href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $report->user->phone_number)) }}"
                                target="_blank"
                                class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-0.5"
                            >
                                <span>Hubungi WA</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Nama Usaha / Peternakan</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200 block">{{ $report->farm_name ?: 'Peternakan Rakyat' }}</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Wilayah Kabupaten/Kota</span>
                        <span class="font-semibold text-gray-900 dark:text-white block">{{ $report->kabupaten ?: 'Jawa Timur' }}</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Alamat Kandang / Titik Lokasi</span>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700/40 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            {{ $report->farm_address ?: 'Alamat belum diisi lengkap oleh peternak' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. Tindakan Kunjungan Lapangan (Action Card) -->
            @if(in_array($report->urgency, ['tinggi', 'kritis']))
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-orange-200/80 dark:border-orange-800/60 p-5 shadow-2xs space-y-3.5">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2.5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-orange-800 dark:text-orange-400">
                        Kunjungan Lapangan
                    </h3>
                    <span class="text-[10px] text-orange-600 bg-orange-100 px-2 py-0.5 rounded-md font-bold">On-Site</span>
                </div>

                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Ajukan jadwal inspeksi langsung ke lokasi peternakan jika kasus memerlukan observasi klinis fisik.
                </p>

                <button
                    type="button"
                    onclick="document.getElementById('modal-ajukan-kunjungan').classList.remove('hidden')"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 transition shadow-2xs cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span>Jadwalkan Kunjungan Lapangan</span>
                </button>
            </div>
            @endif

            <!-- 3. Perbarui Status Manual & Selesai -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3.5">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2.5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Pembaruan Status Laporan
                    </h3>
                </div>

                <form method="POST" action="{{ route('dokter-hewan.status.update', $report) }}" class="space-y-3 text-xs">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Ubah Status Menjadi:</label>
                        <select name="status" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            <option value="sedang_ditangani" {{ $report->status === 'sedang_ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                            <option value="sudah_dijawab" {{ $report->status === 'sudah_dijawab' ? 'selected' : '' }}>Sudah Dijawab</option>
                            <option value="menunggu_tindak_lanjut" {{ $report->status === 'menunggu_tindak_lanjut' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                            <option value="selesai" {{ $report->status === 'selesai' ? 'selected' : '' }}>Selesai (Kasus Ditutup)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Perubahan (Audit Trail):</label>
                        <input type="text" name="notes" placeholder="Alasan perubahan status..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-lg text-xs transition cursor-pointer">
                        Perbarui Status
                    </button>
                </form>
            </div>

            <!-- 4. Riwayat Transisi Status (Audit Trail Log) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700 pb-2">
                    Riwayat Transisi Status (Audit Trail)
                </h3>
                <div class="space-y-2 text-xs max-h-60 overflow-y-auto custom-scrollbar">
                    @forelse($report->statusHistories as $history)
                    <div class="p-2.5 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $history->getStatusLabel($history->new_status) }}</span>
                            <span class="text-[10px] text-gray-400">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($history->notes)
                            <p class="text-gray-600 dark:text-gray-400 mt-1 italic">{{ $history->notes }}</p>
                        @endif
                        @if($history->changer)
                            <span class="text-[10px] text-gray-400 block mt-0.5">Oleh: {{ $history->changer->name }}</span>
                        @endif
                    </div>
                    @empty
                    <span class="text-gray-400 text-xs">Belum ada catatan riwayat status.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Ajukan Kunjungan Lapangan (Section 4.B Master Prompt) -->
<div id="modal-ajukan-kunjungan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengajuan Kunjungan Lapangan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Usulkan tanggal dan waktu kunjungan langsung ke lokasi peternak.</p>
            </div>
            <button type="button" onclick="document.getElementById('modal-ajukan-kunjungan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none cursor-pointer">✕</button>
        </div>

        <form method="POST" action="{{ route('dokter-hewan.visit.propose', $report) }}" class="mt-4 space-y-3.5 text-xs">
            @csrf

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Alasan Kunjungan Lapangan <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="visit_reason"
                    rows="3"
                    required
                    placeholder="Contoh: Perlu observasi fisik dan injeksi obat langsung."
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                ></textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Usulan Tanggal &amp; Jam Kunjungan <span class="text-red-500">*</span>
                </label>
                <input
                    type="datetime-local"
                    name="proposed_date"
                    required
                    min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}"
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                >
                <span class="text-[11px] text-gray-400 mt-1 block">Jadwal akan berstatus Menunggu Konfirmasi sampai peternak menyetujui.</span>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-ajukan-kunjungan').classList.add('hidden')" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 transition shadow-xs cursor-pointer">
                    Kirim Usulan Kunjungan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

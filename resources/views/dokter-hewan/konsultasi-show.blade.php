@extends('layouts.app')

@section('title', 'Pemeriksaan Klinis Konsultasi ' . ($consultation->booking_code ?? ('#CONS-' . $consultation->id)) . ' — Dokter Hewan Dinas')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Back Navigation & Breadcrumb -->
    <div>
        <a href="{{ route('dokter-hewan.jadwal.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            <span>Kembali ke Jadwal Layanan Dokter</span>
        </a>
    </div>

    <!-- Top Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 flex-wrap mb-2">
                <span class="font-mono text-xs font-semibold text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800">
                    {{ $consultation->booking_code ?? ('#CONS-' . $consultation->id) }}
                </span>
                @if($consultation->consultation_type)
                    <span class="text-[11px] font-semibold text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 px-2 py-0.5 rounded-md border border-primary-200/80 dark:border-primary-800/60">
                        {{ ucfirst($consultation->consultation_type) }}
                    </span>
                @endif
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-normal">
                Pemeriksaan Klinis Laporan Kesehatan Ternak
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                Diajukan oleh <strong class="text-gray-700 dark:text-gray-300">{{ $consultation->user?->name ?? 'Peternak' }}</strong> pada {{ $consultation->created_at->translatedFormat('d F Y, H:i') }} WIB
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $consultation->status_badge_classes }} inline-flex items-center gap-1.5 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-current"></span>
                <span>{{ $consultation->status_label }}</span>
            </span>
            <span class="px-3 py-1.5 rounded-md text-xs font-bold border {{ $consultation->urgency_badge_classes }}">
                Urgensi: {{ $consultation->urgency_label }}
            </span>
        </div>
    </div>

    @if($consultation->status !== 'selesai')
    <!-- Quick Action Banner for Doctor to Immediately Handle Consultation -->
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
            @if($consultation->status !== 'sedang_ditangani')
            <form method="POST" action="{{ route('dokter-hewan.konsultasi.status.update', $consultation) }}" class="w-full sm:w-auto">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="sedang_ditangani">
                <input type="hidden" name="notes" value="Dokter hewan dinas membuka sesi dan mulai memeriksa laporan secara klinis.">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-xl shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span>Mulai Tangani Laporan</span>
                </button>
            </form>
            @endif
            <a href="#form-tanggapan" class="w-full sm:w-auto inline-flex items-center justify-center gap-1 px-3.5 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl shadow-2xs transition">
                <span>Tulis Solusi Medis</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Main Content Layout (2 Columns: Left 8 cols, Right 4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-7">

        <!-- Left Column: Medical Inspection & Tanggapan (8 Cols) -->
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
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">
                            {{ $consultation->livestock ? ($consultation->livestock->name . ' - ' . $consultation->livestock->type) : ($consultation->subject ?? 'Hewan Ternak / Ruminansia') }}
                        </span>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 space-y-1">
                        <span class="text-[11px] text-gray-400 block">Metode Layanan</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">
                            {{ ucfirst($consultation->consultation_type ?? 'Online') }}
                        </span>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 space-y-1">
                        <span class="text-[11px] text-gray-400 block">Jadwal Sesi Konsultasi</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">
                            {{ $consultation->consultation_date ? $consultation->consultation_date->format('d M Y') : 'Hari ini' }}
                        </span>
                        <span class="text-[10px] text-gray-500 font-mono block">{{ $consultation->time_formatted }}</span>
                    </div>
                </div>

                <!-- Gejala & Keluhan yang Dilaporkan -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block">Gejala &amp; Keluhan yang Dilaporkan:</label>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 text-xs text-gray-800 dark:text-gray-200 leading-relaxed font-medium whitespace-pre-line">
                        {{ $consultation->complaint_details ?: ($consultation->subject ?: 'Peternak mengajukan pemeriksaan konsultasi kesehatan umum untuk hewan ternaknya.') }}
                    </div>
                </div>
            </div>

            <!-- 2. Hasil Pemeriksaan Dokter Terdahulu (Jika sudah ditangani) -->
            @if($consultation->doctor_notes || $consultation->hypothesis || $consultation->prescription || $consultation->status === 'selesai')
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-emerald-200/80 dark:border-emerald-800/60 p-5 sm:p-6 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-emerald-100 dark:border-emerald-900/40 pb-3">
                    <h3 class="text-sm font-bold text-emerald-900 dark:text-emerald-300 flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Hasil Tanggapan Resmi Dokter yang Telah Dicatat</span>
                    </h3>
                    @if($consultation->status === 'selesai')
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border border-emerald-200">
                            Kasus Selesai
                        </span>
                    @endif
                </div>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="font-bold text-gray-700 dark:text-gray-300 block mb-1">Evaluasi Klinis &amp; Analisis Dokter:</span>
                        <p class="text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/30 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $consultation->doctor_notes ?: 'Pemeriksaan telemedisin selesai.' }}
                        </p>
                    </div>

                    @if($consultation->hypothesis)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 bg-blue-50/60 dark:bg-blue-950/30 rounded-xl border border-blue-100 dark:border-blue-900/50">
                            <span class="text-[11px] font-bold text-blue-800 dark:text-blue-300 block mb-0.5">Dugaan Masalah / Diagnosis:</span>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $consultation->hypothesis }}</span>
                        </div>
                        <div class="p-3 bg-purple-50/60 dark:bg-purple-950/30 rounded-xl border border-purple-100 dark:border-purple-900/50">
                            <span class="text-[11px] font-bold text-purple-800 dark:text-purple-300 block mb-0.5">Urgensi Tindak Lanjut:</span>
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $consultation->urgency_label }}</span>
                        </div>
                    </div>
                    @endif

                    @if($consultation->prescription || $consultation->recommendations)
                    <div class="p-3.5 bg-emerald-50/60 dark:bg-emerald-950/40 rounded-xl border border-emerald-100 dark:border-emerald-900/50">
                        <span class="font-bold text-emerald-800 dark:text-emerald-300 block mb-1">Rekomendasi Penanganan &amp; Terapi Obat:</span>
                        <p class="text-emerald-950 dark:text-emerald-200 whitespace-pre-line leading-relaxed">
                            {{ $consultation->prescription ?: $consultation->recommendations }}
                        </p>
                    </div>
                    @endif

                    @if($consultation->follow_up_instructions)
                    <div class="p-3.5 bg-amber-50/60 dark:bg-amber-950/40 rounded-xl border border-amber-100 dark:border-amber-900/50">
                        <span class="font-bold text-amber-800 dark:text-amber-300 block mb-1">Instruksi Tindak Lanjut bagi Peternak:</span>
                        <p class="text-amber-950 dark:text-amber-200 whitespace-pre-line leading-relaxed">
                            {{ $consultation->follow_up_instructions }}
                        </p>
                    </div>
                    @endif

                    @if($consultation->requires_visit)
                    <div class="p-3 bg-orange-50 dark:bg-orange-950/40 rounded-xl border border-orange-200 dark:border-orange-800/60 text-orange-900 dark:text-orange-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span class="font-semibold text-xs">Kasus ini ditandai memerlukan Kunjungan Lapangan Langsung ke Peternakan.</span>
                    </div>
                    @endif

                    <div class="pt-2 flex items-center justify-between">
                        <a
                            href="{{ route('konsultasi.rekam-medis.download', ['type' => 'consultation', 'id' => $consultation->id]) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-xl shadow-xs transition"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                            <span>Unduh Dokumen Laporan Kesehatan (PDF)</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- 3. Formulir Tanggapan & Rekomendasi Profesional (Identik dengan Screenshot Dokter) -->
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

                <form method="POST" action="{{ route('dokter-hewan.konsultasi.response.store', $consultation) }}" class="space-y-4 sm:space-y-5 text-xs">
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
                        >{{ old('message', $consultation->doctor_notes) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Dugaan Masalah / Kondisi Awal (Berdasarkan Gejala)
                            </label>
                            <input
                                type="text"
                                name="hypothesis"
                                value="{{ old('hypothesis', $consultation->hypothesis) }}"
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
                                <option value="sedang" {{ old('urgency_level', $consultation->urgency_level) === 'sedang' ? 'selected' : '' }}>Sedang (Dalam 24–48 Jam)</option>
                                <option value="tinggi" {{ old('urgency_level', $consultation->urgency_level) === 'tinggi' ? 'selected' : '' }}>Tinggi (Perlu Segera Ditangani Hari Ini)</option>
                                <option value="darurat" {{ old('urgency_level', $consultation->urgency_level) === 'darurat' ? 'selected' : '' }}>Kritis / Darurat (Isolasi &amp; Tindakan Segera)</option>
                                <option value="rendah" {{ old('urgency_level', $consultation->urgency_level) === 'rendah' ? 'selected' : '' }}>Rendah (Dapat Diobservasi Mandiri)</option>
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
                            >{{ old('recommendations', $consultation->prescription) }}</textarea>
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
                            >{{ old('follow_up_instructions', $consultation->follow_up_instructions) }}</textarea>
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
                                {{ old('requires_visit', $consultation->requires_visit) ? 'checked' : '' }}
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
                                <select name="status" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white font-medium">
                                    <option value="selesai" {{ old('status', $consultation->status) === 'selesai' ? 'selected' : '' }}>Penanganan Selesai (Kasus Tuntas)</option>
                                    <option value="sedang_ditangani" {{ old('status', $consultation->status) === 'sedang_ditangani' ? 'selected' : '' }}>Sedang Ditangani (Dalam Observasi Aktif)</option>
                                    <option value="sudah_dijawab" {{ old('status', $consultation->status) === 'sudah_dijawab' ? 'selected' : '' }}>Sudah Dijawab (Respons Awal Terkirim)</option>
                                    <option value="dikonfirmasi" {{ old('status', $consultation->status) === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi (Jadwal Terjadwal)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan Tambahan Dokter (Opsional)</label>
                                <input
                                    type="text"
                                    name="doctor_additional_notes"
                                    value="{{ old('doctor_additional_notes', $consultation->doctor_additional_notes) }}"
                                    placeholder="Catatan internal dinas..."
                                    class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 flex-wrap gap-3">
                        <span class="text-[11px] text-gray-400">
                            Tanggapan akan tersimpan permanen dalam rekam riwayat penanganan laporan.
                        </span>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer"
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
                    <span class="text-[10px] uppercase font-bold text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 px-2.5 py-1 rounded-md">Peternak</span>
                </div>

                @php
                    $peternakUser = $consultation->user;
                    $phone = $peternakUser?->phone_number ?? $peternakUser?->peternakProfile?->phone ?? '';
                    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    } elseif (str_starts_with($cleanPhone, '8')) {
                        $cleanPhone = '62' . $cleanPhone;
                    }
                @endphp

                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Nama Lengkap Peternak</span>
                        <span class="font-bold text-gray-900 dark:text-white text-sm block">{{ $peternakUser?->name ?? 'Peternak' }}</span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Kontak Telepon / WhatsApp</span>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $phone ?: 'Belum tersedia' }}</span>
                            @if($cleanPhone)
                            <a
                                href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Halo Bapak/Ibu ' . ($peternakUser?->name ?? 'Peternak') . ', saya dokter hewan dari Dinas Peternakan Jawa Timur terkait sesi konsultasi ' . ($consultation->booking_code ?? '')) }}"
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
                        <span class="font-medium text-gray-800 dark:text-gray-200 block">
                            {{ $peternakUser?->peternakProfile?->farm_name ?? 'Kelompok Peternak Mandiri' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Wilayah Kabupaten/Kota</span>
                        <span class="font-semibold text-gray-900 dark:text-white block">
                            {{ $peternakUser?->peternakProfile?->kabupaten ?? ($peternakUser?->alamat ?? 'Jawa Timur') }}
                        </span>
                    </div>

                    <div>
                        <span class="text-[11px] text-gray-400 block mb-1">Alamat Kandang / Titik Lokasi</span>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700/40 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            {{ $peternakUser?->alamat ?? ($peternakUser?->peternakProfile?->farm_address ?? 'Alamat belum diisi lengkap oleh peternak') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. Pembaruan Status Cepat -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3.5">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2.5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Pembaruan Status Laporan
                    </h3>
                </div>

                <form method="POST" action="{{ route('dokter-hewan.konsultasi.status.update', $consultation) }}" class="space-y-3 text-xs">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Ubah Status Menjadi:</label>
                        <select name="status" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            <option value="sedang_ditangani" {{ $consultation->status === 'sedang_ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                            <option value="dikonfirmasi" {{ $consultation->status === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="selesai" {{ $consultation->status === 'selesai' ? 'selected' : '' }}>Penanganan Selesai (Kasus Ditutup)</option>
                            <option value="dibatalkan" {{ $consultation->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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

            <!-- 3. Riwayat Transisi Status (Audit Trail Log) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 shadow-2xs space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700 pb-2">
                    Riwayat Transisi Status (Audit Trail)
                </h3>
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $consultation->status_label }}</span>
                            <span class="text-[10px] text-gray-400">{{ $consultation->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($consultation->doctor_additional_notes)
                            <p class="text-gray-600 dark:text-gray-400 mt-1 italic">{{ $consultation->doctor_additional_notes }}</p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 mt-1">Status aktif saat ini dalam sistem telemedisin veteriner dinas.</p>
                        @endif
                        <span class="text-[10px] text-gray-400 block mt-0.5">Oleh: {{ auth()->user()->name }}</span>
                    </div>

                    <div class="p-2.5 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-800 dark:text-gray-200">Reservasi Masuk</span>
                            <span class="text-[10px] text-gray-400">{{ $consultation->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Peternak berhasil mengajukan sesi konsultasi melalui sistem kuota.</p>
                        <span class="text-[10px] text-gray-400 block mt-0.5">Oleh: {{ $consultation->user?->name ?? 'Peternak' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

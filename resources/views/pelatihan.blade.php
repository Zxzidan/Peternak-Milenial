@extends('layouts.app')

@section('title', 'Pelatihan & Bimbingan Teknis — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang Pembibitan &amp; Produksi
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Pelatihan &amp; Bimbingan Teknis
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Program peningkatan kapasitas peternak bersama BBPP Batu dan akademisi peternakan Jawa Timur.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-tambah-bimtek').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
        >
            + Tambah Program Bimtek
        </button>
        <a href="#sertifikat" class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition">
            Sertifikat Saya
        </a>
    </div>
</div>

<!-- Form Tambah Program Bimtek (Collapsible) -->
<div id="form-tambah-bimtek" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tambah Program Bimtek Baru</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Data pelatihan akan langsung tersimpan ke database Dinas Peternakan Jatim.</p>
        </div>
        <button type="button" onclick="document.getElementById('form-tambah-bimtek').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">
            Batal
        </button>
    </div>

    <form action="{{ route('pelatihan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        @csrf
        <div class="md:col-span-2">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Pelatihan <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="Contoh: Formulasi Pakan Ransum & Silase Mandiri" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pengajar / Narasumber <span class="text-red-500">*</span></label>
            <input type="text" name="instructor" required placeholder="Dr. Ir. Hendro Wibowo, M.Sc" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-3">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat <span class="text-red-500">*</span></label>
            <textarea name="description" rows="2" required placeholder="Penjelasan silabus dan materi yang diajarkan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
            <input type="date" name="start_date" required value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
            <input type="date" name="end_date" required value="{{ date('Y-m-d', strtotime('+5 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Pelaksanaan <span class="text-red-500">*</span></label>
            <input type="text" name="location" required placeholder="BBPP Songgoriti, Batu" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kuota Peserta <span class="text-red-500">*</span></label>
            <input type="number" name="quota" required min="1" value="30" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Pendanaan</label>
            <select name="cost_type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option value="gratis_apbd">Gratis (APBD Jatim)</option>
                <option value="daring">Daring / Webinar</option>
                <option value="mandiri">Mandiri</option>
            </select>
        </div>
        <div class="flex items-end justify-end">
            <button type="submit" class="w-full bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2 px-4 rounded-lg shadow-xs transition">
                Simpan Bimtek Baru
            </button>
        </div>
    </form>
</div>

<!-- Tabs Nav -->
<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-xs font-medium text-gray-500 dark:text-gray-400 gap-4">
        <li>
            <a href="#jadwal" class="inline-block py-2.5 text-primary-700 border-b-2 border-primary-700 font-semibold dark:text-primary-400 dark:border-primary-400">
                Jadwal Bimtek ({{ $trainings->count() }})
            </a>
        </li>
        <li>
            <a href="#modul" class="inline-block py-2.5 hover:text-gray-900 dark:hover:text-white">
                Modul &amp; Video ({{ $materials->count() }})
            </a>
        </li>
        <li>
            <a href="#sertifikat" class="inline-block py-2.5 hover:text-gray-900 dark:hover:text-white">
                Sertifikat Digital ({{ $certificates->count() }})
            </a>
        </li>
    </ul>
</div>

<!-- Section 1: Jadwal Bimtek (Persisted from DB) -->
<div id="jadwal" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
        @forelse ($trainings as $training)
        @php
            $isRegistered = in_array($training->id, $myRegisteredTrainingIds);
            $userRegistration = $myRegistrations->firstWhere('training_id', $training->id);
        @endphp
        <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 flex flex-col justify-between shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
            <div>
                <div class="flex items-center justify-between mb-2">
                    @if ($training->remaining_quota > 0)
                        <span class="text-[11px] font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded dark:bg-green-950/60 dark:text-green-300">
                            Terbuka
                        </span>
                        <span class="text-[11px] text-gray-400 font-medium">Sisa {{ $training->remaining_quota }} Kuota</span>
                    @else
                        <span class="text-[11px] font-medium text-red-700 bg-red-50 px-2 py-0.5 rounded dark:bg-red-950/60 dark:text-red-300">
                            Penuh
                        </span>
                        <span class="text-[11px] text-red-400 font-medium">Kuota Habis</span>
                    @endif
                </div>

                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ $training->title }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    {{ Str::limit($training->description, 110) }}
                </p>

                <div class="mt-3.5 space-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Waktu:</span>
                        <span>{{ \Carbon\Carbon::parse($training->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Lokasi:</span>
                        <span>{{ $training->location }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-gray-400 text-[11px]">Pengajar:</span>
                        <span>{{ $training->instructor }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
                <span class="font-semibold text-cyan-700 dark:text-cyan-400 capitalize">
                    {{ str_replace('_', ' ', $training->cost_type) }}
                </span>

                <div class="flex items-center gap-1.5">
                    @if ($isRegistered && $userRegistration)
                        <form action="{{ route('pelatihan.cancel', $userRegistration) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran Bimtek ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-2.5 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-md font-medium text-xs transition"
                                title="Klik untuk membatalkan tiket"
                            >
                                &check; Terdaftar (Batal)
                            </button>
                        </form>
                    @elseif ($training->remaining_quota > 0)
                        <form action="{{ route('pelatihan.register', $training) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="px-3.5 py-1.5 bg-primary-700 hover:bg-primary-800 text-white font-medium rounded-md transition shadow-xs"
                            >
                                Daftar Sekarang
                            </button>
                        </form>
                    @else
                        <button type="button" disabled class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-md cursor-not-allowed text-xs">
                            Ditutup
                        </button>
                    @endif

                    <form action="{{ route('pelatihan.destroy', $training) }}" method="POST" onsubmit="return confirm('Hapus Bimtek {{ $training->title }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus Pelatihan">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-8 text-gray-400">Belum ada program pelatihan terjadwal di database.</div>
        @endforelse
    </div>
</div>

<!-- Section 2: Modul & Video Praktik (From Database) -->
<div id="modul" class="mb-6 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                Modul &amp; Video Praktik
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Materi resmi dinas dapat diakses dan diunduh secara bebas.</p>
        </div>
        <span class="text-xs font-medium text-gray-500">Tersedia {{ $materials->count() }} Modul</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
        @forelse ($materials as $material)
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between border border-gray-100 dark:border-gray-700">
            <div>
                <span class="font-bold text-gray-900 dark:text-white block">{{ $material->title }}</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400">
                    {{ $material->training?->title ?? 'Materi Dinas' }} &bull; {{ strtoupper($material->file_type) }} &bull; {{ $material->file_size ?? '3.5 MB' }}
                </span>
            </div>
            <a
                href="{{ $material->file_url ?? '#' }}"
                onclick="alert('Mengunduh materi: {{ addslashes($material->title) }}')"
                class="font-semibold text-primary-700 dark:text-primary-400 hover:underline px-2.5 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md"
            >
                {{ $material->file_type === 'video' ? 'Tonton' : 'Unduh' }}
            </a>
        </div>
        @empty
        <div class="col-span-2 text-center text-gray-400 py-3">Belum ada modul diunggah.</div>
        @endforelse
    </div>
</div>

<!-- Section 3: Sertifikat Digital (From Database) -->
<div id="sertifikat" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                Sertifikat Digital Saya
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Verifikasi tanda tangan elektronik Dinas Peternakan Jawa Timur.</p>
        </div>
        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tersertifikasi Resmi</span>
    </div>

    <div class="space-y-3">
        @forelse ($certificates as $cert)
        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200/80 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-1.5 py-0.5 rounded">
                        {{ $cert->is_valid ? 'Terverifikasi' : 'Kedaluwarsa' }}
                    </span>
                    <span class="text-gray-400 text-[11px]">No. Seri: {{ $cert->certificate_number }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ $cert->training?->title ?? 'Sertifikasi Kompetensi Peternak Milenial' }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mt-0.5">
                    Penerima: <strong>{{ $cert->user?->name ?? 'Peternak Binaan' }}</strong> &bull; Diterbitkan: {{ \Carbon\Carbon::parse($cert->issued_date)->format('d F Y') }}
                </p>
            </div>

            <button
                type="button"
                onclick="alert('Mengunduh e-Sertifikat resmi nomor {{ $cert->certificate_number }} untuk {{ addslashes($cert->user?->name ?? 'Peternak') }}...')"
                class="px-3.5 py-2 bg-primary-700 hover:bg-primary-800 text-white font-medium rounded-md shrink-0 transition shadow-xs"
            >
                Unduh PDF
            </button>
        </div>
        @empty
        <div class="text-center text-gray-400 py-4 text-xs">Belum ada sertifikat diterbitkan untuk akun ini.</div>
        @endforelse
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Pelatihan & Bimbingan Teknis — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = request('tab', 'jadwal');
    if (!in_array($activeTab, ['jadwal', 'modul', 'sertifikat'])) {
        $activeTab = 'jadwal';
    }
@endphp

<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2 mb-2 sm:mb-2.5">
                <span class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 text-xs font-medium px-2 py-0.5 rounded">
                    Bidang Pembibitan &amp; Produksi
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    · BBPP Batu &amp; Disnak Jatim
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                @if($activeTab === 'jadwal')
                    Jadwal Bimbingan Teknis
                @elseif($activeTab === 'modul')
                    Modul &amp; Video Praktik
                @elseif($activeTab === 'sertifikat')
                    {{ auth()->check() && auth()->user()->isAdmin() ? 'Basis Data Sertifikat Digital' : 'Sertifikat Digital Saya' }}
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed max-w-2xl">
                @if($activeTab === 'jadwal')
                    Program peningkatan kapasitas peternak bersama BBPP Batu dan akademisi peternakan Jawa Timur.
                @elseif($activeTab === 'modul')
                    Materi resmi dinas peternakan, SOP budidaya ternak, dan video tutorial yang dapat diakses bebas.
                @elseif($activeTab === 'sertifikat')
                    Verifikasi tanda tangan elektronik dan sertifikasi kompetensi resmi Dinas Peternakan Jawa Timur.
                @endif
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            @if($activeTab === 'jadwal')
                @if(auth()->check() && auth()->user()->isAdmin())
                <button
                    type="button"
                    onclick="document.getElementById('form-tambah-bimtek').classList.toggle('hidden')"
                    class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                >
                    + Tambah Program Bimtek
                </button>
                <button
                    type="button"
                    onclick="document.getElementById('panel-verifikasi-peserta').classList.toggle('hidden')"
                    class="inline-flex items-center text-xs font-medium text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 hover:bg-primary-100 border border-primary-200 dark:border-primary-800 px-3 py-2 rounded-lg transition"
                >
                    Verifikasi Peserta ({{ $allRegistrations->count() }})
                </button>
                @else
                <span class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                    {{ $trainings->count() }} Program Terbuka
                </span>
                @endif
            @elseif($activeTab === 'modul')
                <span class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                    Tersedia {{ $materials->count() }} Modul &amp; Video
                </span>
                @if(auth()->check() && auth()->user()->isAdmin())
                <button
                    type="button"
                    onclick="document.getElementById('form-unggah-materi').classList.toggle('hidden')"
                    class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                >
                    + Unggah Materi
                </button>
                @endif
            @elseif($activeTab === 'sertifikat')
                <span class="inline-flex items-center text-xs font-medium text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 px-3 py-2 rounded-lg">
                    Tersertifikasi Resmi
                </span>
                @if(auth()->check() && auth()->user()->isAdmin())
                <button
                    type="button"
                    onclick="document.getElementById('form-terbitkan-sertifikat').classList.toggle('hidden')"
                    class="inline-flex items-center text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-3.5 py-2 rounded-lg transition shadow-xs"
                >
                    + Terbitkan Sertifikat
                </button>
                @endif
            @endif
        </div>
    </div>

    @if($activeTab === 'jadwal')
        @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Panel Verifikasi Peserta Bimtek (Admin Only) -->
        <div id="panel-verifikasi-peserta" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Verifikasi Pendaftaran Peserta Bimtek</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Verifikasi dan tentukan status kepesertaan peternak yang mendaftar pelatihan.</p>
                </div>
                <button type="button" onclick="document.getElementById('panel-verifikasi-peserta').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Tutup</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                        <tr>
                            <th class="px-3.5 py-2.5">Nama Peternak</th>
                            <th class="px-3.5 py-2.5">Program Bimtek</th>
                            <th class="px-3.5 py-2.5">Waktu Daftar</th>
                            <th class="px-3.5 py-2.5">Status</th>
                            <th class="px-3.5 py-2.5 text-right">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($allRegistrations as $reg)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                            <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">{{ $reg->user?->name ?? 'Peternak' }}</td>
                            <td class="px-3.5 py-2.5">{{ $reg->training?->title ?? 'Pelatihan' }}</td>
                            <td class="px-3.5 py-2.5 text-gray-400">{{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y H:i') }}</td>
                            <td class="px-3.5 py-2.5">
                                @if ($reg->status === 'approved' || $reg->status === 'confirmed')
                                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold px-2 py-0.5 rounded">Disetujui</span>
                                @elseif ($reg->status === 'pending')
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold px-2 py-0.5 rounded">Menunggu</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-[10px] font-semibold px-2 py-0.5 rounded">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-3.5 py-2.5 text-right space-x-1">
                                @if ($reg->status !== 'approved' && $reg->status !== 'confirmed')
                                    <form action="{{ route('pelatihan.registration.status', $reg) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="tab" value="jadwal">
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2 py-1 rounded transition">Setujui</button>
                                    </form>
                                @endif
                                @if ($reg->status !== 'cancelled' && $reg->status !== 'rejected')
                                    <form action="{{ route('pelatihan.registration.status', $reg) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="tab" value="jadwal">
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-[10px] font-medium px-2 py-1 rounded transition">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-3.5 py-4 text-center text-gray-400">Belum ada peserta mendaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Tambah Program Bimtek (Collapsible) -->
        <div id="form-tambah-bimtek" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
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
                <input type="hidden" name="tab" value="jadwal">
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
        @endif

        <!-- Grid Jadwal Bimtek -->
        <div id="jadwal">
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
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <span class="px-2.5 py-1 bg-blue-50 text-primary-700 border border-blue-200 rounded-md font-semibold text-[11px]">
                                    Pengelola Bimtek
                                </span>
                                <form action="{{ route('pelatihan.destroy', $training) }}" method="POST" onsubmit="return confirm('Hapus Bimtek {{ $training->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="tab" value="jadwal">
                                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus Pelatihan">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            @else
                                @if ($isRegistered && $userRegistration)
                                    <form action="{{ route('pelatihan.cancel', $userRegistration) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran Bimtek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="tab" value="jadwal">
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
                                        <input type="hidden" name="tab" value="jadwal">
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
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 px-4 text-center bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada program pelatihan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Jadwal bimbingan teknis dan pelatihan peternak akan ditampilkan setelah dipublikasikan oleh Admin Dinas.</p>
                </div>
                @endforelse
            </div>
        </div>
    @elseif($activeTab === 'modul')
        @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Form Unggah Materi (Admin Only) -->
        <div id="form-unggah-materi" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Unggah Materi Pembelajaran Baru</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Publikasikan modul, buku pedoman, atau tautan video tutorial untuk peternak.</p>
                </div>
                <button type="button" onclick="document.getElementById('form-unggah-materi').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">
                    Batal
                </button>
            </div>

            <form action="{{ route('pelatihan.materials.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
                @csrf
                <input type="hidden" name="tab" value="modul">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Program Bimtek</label>
                    <select name="training_id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        <option value="">Umum (Dinas Peternakan Jatim)</option>
                        @foreach ($trainings as $t)
                            <option value="{{ $t->id }}">{{ $t->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Materi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="Modul Pembuatan Silase Mandiri..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Materi <span class="text-red-500">*</span></label>
                    <select name="file_type" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        <option value="pdf">PDF (Buku/Modul SOP)</option>
                        <option value="video">Video Praktik / Webinar</option>
                        <option value="slide">Slide Presentasi</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <div class="w-full">
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Ukuran / Keterangan File</label>
                        <input type="text" name="file_size" placeholder="Contoh: 4.2 MB" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2 px-3 rounded-lg shadow-xs transition shrink-0">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Daftar Modul & Video Praktik -->
        <div id="modul" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 text-xs">
                @forelse ($materials as $material)
                <div class="p-4 bg-gray-50 dark:bg-gray-750/50 rounded-xl flex items-center justify-between border border-gray-200/80 dark:border-gray-700 hover:border-gray-300 transition">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center shrink-0 text-primary-700 dark:text-primary-400 font-bold text-[10px] uppercase shadow-2xs">
                            @if(str_contains(strtolower($material->file_type ?? $material->category ?? ''), 'video'))
                                <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            @endif
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white block leading-snug">{{ $material->title }}</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">
                                {{ $material->training?->title ?? 'Materi Dinas' }} &bull; {{ strtoupper(str_replace('_', ' ', $material->file_type ?? $material->category ?? 'PDF')) }} &bull; {{ $material->file_size ?? '3.5 MB' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0 ms-2">
                        <a
                            href="{{ $material->file_url ?? '#' }}"
                            onclick="alert('Mengunduh materi: {{ addslashes($material->title) }}')"
                            class="font-semibold text-primary-700 dark:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg transition"
                        >
                            {{ str_contains(strtolower($material->file_type ?? $material->category ?? ''), 'video') ? 'Tonton' : 'Unduh' }}
                        </a>
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <form action="{{ route('pelatihan.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Hapus materi {{ $material->title }}?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tab" value="modul">
                            <button type="submit" class="text-gray-400 hover:text-red-600 p-1.5 rounded transition" title="Hapus Materi">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center text-gray-400 py-10 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                    Belum ada modul atau materi pembelajaran yang diunggah oleh Admin Dinas.
                </div>
                @endforelse
            </div>
        </div>
    @elseif($activeTab === 'sertifikat')
        @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Form Terbitkan Sertifikat (Admin Only) -->
        <div id="form-terbitkan-sertifikat" class="hidden bg-emerald-50/60 dark:bg-emerald-950/30 rounded-xl border border-emerald-200 dark:border-emerald-800 p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-emerald-200/70 dark:border-emerald-800 mb-3.5">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Terbitkan Sertifikat Digital Resmi</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Penerbitan e-Sertifikat kompetensi binaan dengan nomor registrasi Disnak Jatim.</p>
                </div>
                <button type="button" onclick="document.getElementById('form-terbitkan-sertifikat').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">
                    Batal
                </button>
            </div>

            <form action="{{ route('pelatihan.certificates.issue') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
                @csrf
                <input type="hidden" name="tab" value="sertifikat">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Penerima Peternak <span class="text-red-500">*</span></label>
                    <select name="user_id" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        @foreach ($peternakUsers as $pu)
                            <option value="{{ $pu->id }}">{{ $pu->name }} ({{ $pu->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Program Pelatihan <span class="text-red-500">*</span></label>
                    <select name="training_id" required class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        @foreach ($trainings as $t)
                            <option value="{{ $t->id }}">{{ $t->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Seri Sertifikat</label>
                    <input type="text" name="certificate_number" placeholder="JTM-CERT-2026-..." class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                </div>
                <div class="flex items-end justify-end">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-3 rounded-lg shadow-xs transition">
                        Terbitkan Sekarang
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Daftar Sertifikat Digital -->
        <div id="sertifikat" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
            <div class="space-y-3.5">
                @forelse ($certificates as $cert)
                <div class="p-4.5 rounded-xl bg-gray-50 dark:bg-gray-750/50 border border-gray-200/80 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs hover:border-gray-300 transition">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800 px-2 py-0.5 rounded">
                                {{ $cert->is_valid ?? true ? 'Terverifikasi Resmi' : 'Kedaluwarsa' }}
                            </span>
                            <span class="text-gray-400 text-[11px]">No. Seri: {{ $cert->certificate_number }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $cert->title ?? $cert->training?->title ?? 'Sertifikasi Kompetensi Peternak Milenial' }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                            Penerima: <strong class="text-gray-700 dark:text-gray-200">{{ $cert->recipient_name ?? $cert->user?->name ?? 'Peternak Binaan' }}</strong> &bull; Diterbitkan: {{ \Carbon\Carbon::parse($cert->issued_date)->format('d F Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            type="button"
                            onclick="alert('Mengunduh e-Sertifikat resmi nomor {{ $cert->certificate_number }} untuk {{ addslashes($cert->recipient_name ?? $cert->user?->name ?? 'Peternak') }}...')"
                            class="px-3.5 py-2 bg-primary-700 hover:bg-primary-800 text-white font-medium rounded-lg shrink-0 transition shadow-xs text-xs"
                        >
                            Unduh PDF
                        </button>
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <form action="{{ route('pelatihan.certificates.destroy', $cert) }}" method="POST" onsubmit="return confirm('Hapus sertifikat {{ $cert->certificate_number }}?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tab" value="sertifikat">
                            <button type="submit" class="text-gray-400 hover:text-red-600 p-1.5 rounded transition" title="Hapus Sertifikat">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-10 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                    Belum ada sertifikat digital yang diterbitkan di dalam database.
                </div>
                @endforelse
            </div>
        </div>
    @endif

</div>
@endsection

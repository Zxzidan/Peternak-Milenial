@extends('layouts.app')

@section('title', 'Formulir Laporan Kesehatan Hewan — Peternak Milenial Jatim')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pt-1 sm:pt-2">

    <!-- Header & Navigasi Kembali -->
    <div class="pb-5 border-b border-gray-200 dark:border-gray-800">
        <div class="mb-3">
            <a href="{{ route('kesehatan-hewan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                <span>Kembali ke Daftar Laporan</span>
            </a>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
            Formulir Laporan Kesehatan Ternak
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
            Isi rincian kondisi ternak Anda dengan lengkap agar dokter hewan dinas dapat memberikan analisis dan tindakan tepat sasaran.
        </p>
    </div>

    <!-- Alert Edukasi / Petunjuk Pengisian -->
    <div class="p-4 bg-primary-50/70 dark:bg-primary-950/30 rounded-2xl border border-primary-200/70 dark:border-primary-800/40 flex items-start gap-3 text-xs text-primary-900 dark:text-primary-200">
        <div class="w-7 h-7 rounded-xl bg-primary-100 text-primary-700 dark:bg-primary-900/60 dark:text-primary-300 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
        </div>
        <div class="space-y-0.5">
            <p class="font-bold text-primary-950 dark:text-primary-100">Petunjuk Pelaporan Penyakit Hewan:</p>
            <p class="text-primary-800 dark:text-primary-300 leading-relaxed text-[11px] sm:text-xs">
                Jelaskan gejala utama (seperti nafsu makan, kondisi pernapasan, mulut, kuku, atau produksi susu). Foto pendukung sangat disarankan untuk mempercepat akurasi penanganan awal oleh dokter.
            </p>
        </div>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/90 dark:border-gray-700 p-5 sm:p-7 shadow-xs">
        <form method="POST" action="{{ route('kesehatan-hewan.store') }}" enctype="multipart/form-data" class="space-y-7">
            @csrf

            <!-- Section 1: Informasi Hewan & Gejala Klinis -->
            <div class="space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="w-7 h-7 rounded-lg bg-primary-100 text-primary-700 dark:bg-primary-900/60 dark:text-primary-300 flex items-center justify-center font-bold text-xs ring-1 ring-primary-500/20">
                        1
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Data Hewan Ternak &amp; Gejala Sakit
                        </h2>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">
                            Identitas ternak yang terdampak serta keluhan yang teramati di kandang
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Jenis Ternak -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Jenis Hewan Ternak <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                name="livestock_type"
                                required
                                class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 px-3.5 pr-10 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition appearance-none cursor-pointer @error('livestock_type') border-red-500 @enderror"
                            >
                                <option value="" disabled {{ old('livestock_type') ? '' : 'selected' }}>Pilih Jenis Ternak...</option>
                                @foreach(['Sapi Potong', 'Sapi Perah', 'Kambing / Domba', 'Ayam Broiler', 'Ayam Petelur', 'Itik / Bebek', 'Kuda', 'Lainnya'] as $option)
                                    <option value="{{ $option }}" {{ old('livestock_type') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>
                        @error('livestock_type')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Ternak Terdampak -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Jumlah Ternak yang Sakit / Terdampak <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                name="affected_count"
                                value="{{ old('affected_count', 1) }}"
                                min="1"
                                required
                                class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-3.5 pr-14 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition @error('affected_count') border-red-500 @enderror"
                            >
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-xs font-semibold text-gray-400">
                                Ekor
                            </span>
                        </div>
                        @error('affected_count')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Kapan Mulai Muncul Gejala -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Kapan Mulai Muncul Gejala?
                        </label>
                        <input
                            type="date"
                            name="symptoms_started_at"
                            max="{{ now()->toDateString() }}"
                            value="{{ old('symptoms_started_at', now()->toDateString()) }}"
                            class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 px-3.5 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition cursor-pointer"
                        >
                        <span class="text-[11px] text-gray-400 mt-1 block">Perkiraan hari awal ternak menunjukkan penurunan kondisi</span>
                    </div>

                    <!-- Tingkat Urgensi Menurut Peternak -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Tingkat Urgensi Menurut Anda <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                name="urgency"
                                id="urgencySelect"
                                required
                                onchange="toggleSectionLocation(this.value)"
                                class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 px-3.5 pr-10 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition appearance-none cursor-pointer @error('urgency') border-red-500 @enderror"
                            >
                                <option value="sedang" {{ old('urgency', 'sedang') === 'sedang' ? 'selected' : '' }}>Sedang (Perlu Penanganan Biasa)</option>
                                <option value="tinggi" {{ old('urgency') === 'tinggi' ? 'selected' : '' }}>Tinggi (Kondisi Lemah / Menurun Cepat)</option>
                                <option value="kritis" {{ old('urgency') === 'kritis' ? 'selected' : '' }}>Kritis (Ternak Tidak Mau Berdiri / Kejang)</option>
                                <option value="rendah" {{ old('urgency') === 'rendah' ? 'selected' : '' }}>Rendah (Gejala Ringan)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>
                        @error('urgency')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keluhan & Gejala Klinis Utama -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                            Keluhan &amp; Gejala Klinis Utama <span class="text-red-500">*</span>
                        </label>
                        <span class="text-[11px] text-gray-400">Jelaskan sedetail mungkin</span>
                    </div>
                    <textarea
                        name="symptoms"
                        rows="3"
                        required
                        placeholder="Contoh: Sapi tidak mau makan, demam, dan lemas..."
                        class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-xs sm:text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 leading-relaxed transition @error('symptoms') border-red-500 @enderror"
                    >{{ old('symptoms') }}</textarea>
                    @error('symptoms')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Pendukung Kondisi Ternak (Modern Upload Dropzone) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Foto Pendukung Kondisi Ternak <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>

                    <div
                        id="photoDropzone"
                        onclick="document.getElementById('photoInput').click()"
                        class="border-2 border-dashed border-gray-200 hover:border-primary-400 dark:border-gray-700 dark:hover:border-primary-500 bg-gray-50/60 hover:bg-primary-50/20 dark:bg-gray-800/40 rounded-2xl p-5 text-center transition cursor-pointer group"
                    >
                        <input
                            type="file"
                            id="photoInput"
                            name="photo"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="hidden"
                            onchange="handlePhotoChange(event)"
                        >

                        <!-- Tampilan Default (Belum ada foto) -->
                        <div id="photoDropzonePrompt" class="flex flex-col items-center justify-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-primary-100/80 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 flex items-center justify-center group-hover:scale-105 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 block">
                                    Klik untuk memilih foto atau seret berkas ke sini
                                </span>
                                <span class="text-[11px] text-gray-400 mt-0.5 block">
                                    Foto luka, mata, lendir, atau tampak fisik ternak memudahkan dokter menganalisis kondisi
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">JPG, PNG, WEBP</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Maks. 5 MB</span>
                            </div>
                        </div>

                        <!-- Preview Foto yang Dipilih -->
                        <div id="photoPreviewContainer" class="hidden flex items-center justify-between gap-4 p-2 bg-white dark:bg-gray-700/60 rounded-xl border border-gray-200 dark:border-gray-600 text-left">
                            <div class="flex items-center gap-3 min-w-0">
                                <img id="photoPreviewImage" src="#" alt="Preview Foto" class="w-14 h-14 object-cover rounded-lg border border-gray-200 dark:border-gray-600 shrink-0">
                                <div class="min-w-0">
                                    <p id="photoFileName" class="text-xs font-bold text-gray-900 dark:text-white truncate">nama_foto.jpg</p>
                                    <p id="photoFileSize" class="text-[11px] text-gray-400">0.00 MB</p>
                                    <span class="inline-block mt-0.5 text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">✓ Siap diunggah</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 pr-2">
                                <button
                                    type="button"
                                    onclick="removeSelectedPhoto(event)"
                                    class="px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition"
                                >
                                    Hapus
                                </button>
                                <button
                                    type="button"
                                    onclick="event.stopPropagation(); document.getElementById('photoInput').click();"
                                    class="px-2.5 py-1.5 text-xs font-semibold text-primary-700 hover:bg-primary-50 dark:text-primary-300 dark:hover:bg-primary-950/40 rounded-lg transition"
                                >
                                    Ganti Foto
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('photo')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @php
                $isUrgent = in_array(old('urgency', 'sedang'), ['tinggi', 'kritis']);
            @endphp

            <!-- Section 2: Lokasi Usaha & Kontak Peternakan -->
            <div id="section-lokasi-peternakan" class="space-y-5 pt-4 border-t border-gray-100 dark:border-gray-700 {{ $isUrgent ? '' : 'hidden' }}">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300 flex items-center justify-center font-bold text-xs ring-1 ring-emerald-500/20">
                        2
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Lokasi Usaha &amp; Kontak Peternakan
                        </h2>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">
                            Memudahkan dokter hewan Puskeswan saat perlu melakukan kunjungan lapangan on-site
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Nama Peternakan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Peternakan / Kandang
                        </label>
                        <input
                            type="text"
                            name="farm_name"
                            value="{{ old('farm_name', $user->peternakProfile?->farm_name ?? 'Peternakan ' . $user->name) }}"
                            placeholder="Contoh: Peternakan Barokah Pasuruan"
                            class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 px-3.5 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition"
                        >
                    </div>

                    <!-- Kabupaten / Kota -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Kabupaten / Kota Lokasi Kandang <span class="text-red-500">*</span>
                        </label>
                        @php
                            $defaultKabupatens = [
                                'Kabupaten Bangkalan',
                                'Kabupaten Banyuwangi',
                                'Kabupaten Blitar',
                                'Kabupaten Bojonegoro',
                                'Kabupaten Bondowoso',
                                'Kabupaten Gresik',
                                'Kabupaten Jember',
                                'Kabupaten Jombang',
                                'Kabupaten Kediri',
                                'Kabupaten Lamongan',
                                'Kabupaten Lumajang',
                                'Kabupaten Madiun',
                                'Kabupaten Magetan',
                                'Kabupaten Malang',
                                'Kabupaten Mojokerto',
                                'Kabupaten Nganjuk',
                                'Kabupaten Ngawi',
                                'Kabupaten Pacitan',
                                'Kabupaten Pamekasan',
                                'Kabupaten Pasuruan',
                                'Kabupaten Ponorogo',
                                'Kabupaten Probolinggo',
                                'Kabupaten Sampang',
                                'Kabupaten Sidoarjo',
                                'Kabupaten Situbondo',
                                'Kabupaten Sumenep',
                                'Kabupaten Trenggalek',
                                'Kabupaten Tuban',
                                'Kabupaten Tulungagung',
                                'Kota Batu',
                                'Kota Blitar',
                                'Kota Kediri',
                                'Kota Madiun',
                                'Kota Malang',
                                'Kota Mojokerto',
                                'Kota Pasuruan',
                                'Kota Probolinggo',
                                'Kota Surabaya',
                            ];
                            $kabupatenList = isset($regions) && $regions->isNotEmpty()
                                ? collect($defaultKabupatens)->merge($regions->pluck('name'))->unique()->sort()->values()
                                : collect($defaultKabupatens)->sort()->values();
                            $selectedKabupaten = old('kabupaten', $user->kabupaten ?? 'Kabupaten Malang');
                        @endphp
                        <div class="relative">
                            <select
                                name="kabupaten"
                                id="kabupatenSelect"
                                {{ $isUrgent ? 'required' : '' }}
                                class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 px-3.5 pr-10 text-xs sm:text-sm font-medium text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition appearance-none cursor-pointer @error('kabupaten') border-red-500 @enderror"
                            >
                                <option value="" disabled {{ $selectedKabupaten ? '' : 'selected' }}>Pilih Kabupaten / Kota...</option>
                                @foreach($kabupatenList as $kab)
                                    <option value="{{ $kab }}" {{ $selectedKabupaten === $kab ? 'selected' : '' }}>
                                        {{ $kab }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>
                        @error('kabupaten')
                            <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Lengkap Kandang -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Alamat Lengkap Kandang / Titik Acuan
                    </label>
                    <textarea
                        name="farm_address"
                        rows="2"
                        placeholder="Contoh: Dusun Krajan RT 03 / RW 02, Desa Toyomarto, Kec. Singosari (patokan 200m barat Lapangan Desa)..."
                        class="w-full bg-gray-50/70 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-xs sm:text-sm text-gray-900 dark:text-white placeholder:text-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 leading-relaxed transition"
                    >{{ old('farm_address', $user->alamat ?? '') }}</textarea>
                </div>
            </div>

            <!-- Footer Action Bar -->
            <div class="pt-5 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-[11px] text-gray-400 dark:text-gray-500">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    <span>Laporan otomatis didistribusikan ke dokter Puskeswan wilayah setempat.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <a
                        href="{{ route('kesehatan-hewan.index') }}"
                        class="px-4 py-2.5 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-gray-100 dark:bg-gray-700/60 hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs hover:shadow cursor-pointer"
                    >
                        <span>Kirim Laporan ke Dokter Hewan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Script Preview Foto Real-Time -->
<script>
function handlePhotoChange(event) {
    const input = event.target;
    const file = input.files && input.files[0];
    const previewContainer = document.getElementById('photoPreviewContainer');
    const dropzonePrompt = document.getElementById('photoDropzonePrompt');
    const previewImage = document.getElementById('photoPreviewImage');
    const fileNameEl = document.getElementById('photoFileName');
    const fileSizeEl = document.getElementById('photoFileSize');

    if (file) {
        if (!file.type.match('image.*')) {
            alert('Silakan pilih berkas gambar (JPG, PNG, WEBP).');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            fileNameEl.textContent = file.name;
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            fileSizeEl.textContent = sizeInMB + ' MB';
            dropzonePrompt.classList.add('hidden');
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeSelectedPhoto(event) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const input = document.getElementById('photoInput');
    const previewContainer = document.getElementById('photoPreviewContainer');
    const dropzonePrompt = document.getElementById('photoDropzonePrompt');
    const previewImage = document.getElementById('photoPreviewImage');

    input.value = '';
    previewImage.src = '';
    previewContainer.classList.add('hidden');
    dropzonePrompt.classList.remove('hidden');
}

function toggleSectionLocation(urgency) {
    const section = document.getElementById('section-lokasi-peternakan');
    const kabupatenSelect = document.getElementById('kabupatenSelect');
    if (!section) return;

    if (urgency === 'tinggi' || urgency === 'kritis') {
        section.classList.remove('hidden');
        if (kabupatenSelect) {
            kabupatenSelect.required = true;
        }
    } else {
        section.classList.add('hidden');
        if (kabupatenSelect) {
            kabupatenSelect.required = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const urgencySelect = document.getElementById('urgencySelect');
    if (urgencySelect) {
        toggleSectionLocation(urgencySelect.value);
    }

    const dropzone = document.getElementById('photoDropzone');
    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-primary-500', 'bg-primary-50/40');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-primary-500', 'bg-primary-50/40');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                const input = document.getElementById('photoInput');
                input.files = files;
                handlePhotoChange({ target: input });
            }
        }, false);
    }
});
</script>
@endsection

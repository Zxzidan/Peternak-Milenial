@extends('layouts.app')

@section('title', 'Formulir Laporan Kesehatan Hewan — Peternak Milenial Jatim')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('kesehatan-hewan.index') }}" class="text-xs text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    <span>Kembali ke Daftar Laporan</span>
                </a>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-1 leading-snug">
                Formulir Laporan Kesehatan Ternak
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Isi rincian kondisi ternak Anda dengan lengkap agar dokter hewan dinas dapat memberikan analisis dan tindakan tepat sasaran.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/80 dark:border-gray-700 p-5 sm:p-7 shadow-2xs">
        <form method="POST" action="{{ route('kesehatan-hewan.store') }}" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <!-- Section 1: Informasi Hewan & Gejala -->
            <div class="space-y-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 dark:border-gray-700 pb-2">
                    1. Data Hewan Ternak &amp; Gejala Sakit
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Jenis Hewan Ternak <span class="text-red-500">*</span>
                        </label>
                        <select name="livestock_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Pilih Jenis Ternak...</option>
                            <option value="Sapi Potong">Sapi Potong</option>
                            <option value="Sapi Perah">Sapi Perah</option>
                            <option value="Kambing / Domba">Kambing / Domba</option>
                            <option value="Ayam Broiler">Ayam Broiler</option>
                            <option value="Ayam Petelur">Ayam Petelur</option>
                            <option value="Itik / Bebek">Itik / Bebek</option>
                            <option value="Kuda">Kuda</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Jumlah Ternak yang Sakit / Terdampak <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="affected_count"
                            value="1"
                            min="1"
                            required
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Kapan Mulai Muncul Gejala?
                        </label>
                        <input
                            type="date"
                            name="symptoms_started_at"
                            max="{{ now()->toDateString() }}"
                            value="{{ now()->toDateString() }}"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Tingkat Urgensi Menurut Anda <span class="text-red-500">*</span>
                        </label>
                        <select name="urgency" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                            <option value="sedang">Sedang (Perlu Penanganan Biasa)</option>
                            <option value="tinggi">Tinggi (Kondisi Lemah / Menurun Cepat)</option>
                            <option value="kritis">Kritis (Ternak Tidak Mau Berdiri / Kejang)</option>
                            <option value="rendah">Rendah (Gejala Ringan)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                        Keluhan &amp; Gejala Klinis Utama <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="symptoms"
                        rows="4"
                        required
                        placeholder="Contoh: Sapi tidak mau makan sejak kemarin, hidung berlendir, air liur berlebih, dan napas terdengar berat/tersengal..."
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-3 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 leading-relaxed"
                    ></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Riwayat Penyakit / Obat yang Sudah Diberikan
                        </label>
                        <textarea
                            name="medical_history"
                            rows="2"
                            placeholder="Contoh: Diberi vitamin B-kompleks cair 2 hari lalu..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Keterangan Tambahan (Opsional)
                        </label>
                        <textarea
                            name="additional_notes"
                            rows="2"
                            placeholder="Contoh: Kandang berdekatan dengan ternak tetangga yang juga pilek..."
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        ></textarea>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                        Foto Pendukung Kondisi Ternak (Opsional)
                    </label>
                    <input
                        type="file"
                        name="photo"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                    >
                    <span class="text-[10px] text-gray-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimal 5 MB.</span>
                </div>
            </div>

            <!-- Section 2: Informasi Lokasi Peternakan -->
            <div class="space-y-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 dark:border-gray-700 pb-2">
                    2. Lokasi Usaha &amp; Kontak Peternakan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Nama Peternakan
                        </label>
                        <input
                            type="text"
                            name="farm_name"
                            value="{{ $user->peternakProfile?->farm_name ?? 'Peternakan ' . $user->name }}"
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                            Kabupaten / Kota Lokasi Kandang <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="kabupaten"
                            value="{{ $user->kabupaten ?? 'Kabupaten Malang' }}"
                            required
                            class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-1">
                        Alamat Lengkap Kandang / Titik Lokasi
                    </label>
                    <textarea
                        name="farm_address"
                        rows="2"
                        placeholder="Dusun, RT/RW, Desa/Kelurahan, Kecamatan..."
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                    >{{ $user->alamat ?? '' }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('kesehatan-hewan.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 transition">
                    Batal
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer"
                >
                    <span>Kirim Laporan ke Dokter Hewan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

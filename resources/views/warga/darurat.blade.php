{{--
    DOKUMENTASI KODE TAMPILAN: PELAPORAN DARURAT & HOTLINE BENCANA TERNAK BAGI WARGA
    File: resources/views/warga/darurat.blade.php
    Deskripsi: Halaman respons cepat siaga darurat bagi masyarakat umum untuk melaporkan kejadian hewan
               sakit mendadak di lingkungan pemukiman, dugaan wabah, kecelakaan ternak, atau ternak terdampak
               bencana alam (erupsi, banjir) terintegrasi ke Posko Puskeswan dan BPBD Jatim.
--}}

@extends('layouts.app')

@section('title', 'Layanan Darurat & Siaga Bencana Ternak — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-2 pb-10">

    <!-- 1. HEADER KESIAPSIAGAAN DARURAT -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-600 animate-ping"></span>
                <span>Layanan Siaga Darurat Kesehatan Ternak Jatim</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Saluran siaga respons cepat 24 jam bagi masyarakat dan kelompok ternak untuk melaporkan indikasi wabah menular, ternak terlantar, atau hewan korban bencana alam.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="tel:08001347625" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                <span>Hotline Darurat: 0800-1-DISNAK</span>
            </a>
        </div>
    </div>

    <!-- 2. FORM PELAPORAN CEPAT WARGA -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs space-y-5">
            <div>
                <h3 class="text-base font-bold text-slate-900">Formulir Laporan Kejadian Darurat</h3>
                <p class="text-xs text-slate-500 mt-0.5">Petugas Puskeswan terdekat akan segera memverifikasi dan meluncur ke lokasi kejadian.</p>
            </div>

            <form method="POST" action="{{ route('darurat') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jenis Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kejadian</label>
                        <select name="incident_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition">
                            <option value="wabah">Indikasi Wabah Menular (Air Liur / Lesu / Demam)</option>
                            <option value="bencana">Terdampak Bencana Alam (Banjir / Erupsi)</option>
                            <option value="kecelakaan">Kecelakaan / Ternak Tercebur / Luka Parah</option>
                        </select>
                    </div>

                    <!-- Jenis Ternak -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Ternak Terdampak</label>
                        <select name="livestock_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition">
                            <option value="sapi_perah">Sapi Perah</option>
                            <option value="sapi_potong">Sapi Potong</option>
                            <option value="kambing">Kambing / Domba</option>
                            <option value="unggas">Unggas / Bebek / Ayam</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Estimasi Jumlah Ekor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Perkiraan Ekor Terdampak</label>
                        <input type="number" name="affected_count" min="1" value="1" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition">
                    </div>

                    <!-- Wilayah Kabupaten/Kota -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Wilayah Kabupaten/Kota</label>
                        <select name="region_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition">
                            <option value="">Pilih Kabupaten/Kota di Jatim</option>
                            @foreach($regions ?? [] as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Alamat Detail -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat / Patokan Lokasi Kejadian</label>
                    <input type="text" name="location_address" placeholder="Contoh: Dusun Tiripan RT 02/RW 01 dekat jembatan, Berbek" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition">
                </div>

                <!-- Deskripsi Gejala -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat Kondisi Hewan</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan kondisi ternak: apakah mengeluarkan liur berbusa, tidak bisa berdiri, bersin massal, dll..." required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                    Kirim Laporan Darurat Sekarang
                </button>
            </form>
        </div>

        <!-- 3. PANDUAN PENCEGAHAN BENCANA (DISASTER MITIGATION GUIDES) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 text-xs text-amber-900 space-y-2">
                <div class="flex items-center gap-2 font-bold text-amber-950">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    <span>Langkah Pertama Bila Menemukan Hewan Diduga Wabah:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-amber-800 leading-relaxed">
                    <li>Jangan mendekati atau menyentuh air liur dan kotoran hewan tanpa sarung tangan.</li>
                    <li>Batasi mobilitas keluar masuk orang luar ke area sekitar kandang.</li>
                    <li>Segera buat laporan lewat form ini agar petugas medik veteriner resmi segera bertindak.</li>
                </ul>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Panduan Mitigasi Bencana Jawa Timur</h4>
                <div class="space-y-2 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-800 block">Erupsi Gunung Berapi (Bromo/Semeru/Kelud)</strong>
                        <p class="text-slate-500 text-[11px] mt-0.5">Lindungi pakan hijauan dari debu silika. Gunakan pakan silase kedap udara dan bilas mata ternak.</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-800 block">Banjir &amp; Luapan Genangan Air</strong>
                        <p class="text-slate-500 text-[11px] mt-0.5">Lepaskan ikatan tali kandang saat air naik dan evakuasi ternak ke titik posko dataran tinggi aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


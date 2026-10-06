@extends('layouts.app')

@section('title', 'Konsultasi & Kesehatan Hewan — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang Keswan
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Konsultasi & Kesehatan Hewan
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Layanan dokter hewan, buku rekam medis digital, dan pedoman penyakit ternak.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="#rekam-medis" class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition">
            Rekam Medis Ternak
        </a>
    </div>
</div>

<!-- Section 1: Utas Percakapan Dokter Hewan -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Konsultasi Medis Aktif</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Puskeswan Pandaan & Tim Dokter Hewan Dinas</p>
        </div>
        <span class="text-xs font-medium text-primary-700 bg-primary-50 px-2 py-0.5 rounded dark:bg-primary-950/60 dark:text-primary-300 flex items-center">
            <span class="w-1.5 h-1.5 rounded-full bg-primary-600 mr-1.5"></span> drh. Ratna (Aktif)
        </span>
    </div>

    <!-- Chat Box -->
    <div class="space-y-3 max-h-80 overflow-y-auto p-3.5 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 text-xs">
        <!-- Message Peternak -->
        <div class="flex items-start gap-2 justify-end">
            <div class="bg-primary-700 text-white p-3 rounded-xl rounded-tr-none max-w-md">
                <div class="flex justify-between items-center mb-1 text-primary-200 text-[10px]">
                    <span class="font-semibold">Pak Slamet (Anda)</span>
                    <span>08:14 WIB</span>
                </div>
                <p class="leading-relaxed">
                    Selamat pagi Dokter Ratna. Sapi perah no. 14 terlihat lesu sejak kemarin sore, suhu 39.8°C dan nafsu makan berkurang. Mohon arahannya.
                </p>
            </div>
        </div>

        <!-- Message Dokter -->
        <div class="flex items-start gap-2">
            <div class="w-7 h-7 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 flex items-center justify-center font-bold text-xs shrink-0">
                RK
            </div>
            <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-3 rounded-xl rounded-tl-none max-w-md border border-gray-200 dark:border-gray-700 shadow-xs">
                <div class="flex justify-between items-center mb-1 text-gray-400 text-[10px]">
                    <span class="font-semibold text-gray-900 dark:text-white">drh. Ratna Kusuma</span>
                    <span>08:24 WIB</span>
                </div>
                <p class="leading-relaxed">
                    Selamat pagi Pak Slamet. Pisahkan sapi ke kandang karantina, beri air hangat + molase. Petugas lapangan sedang menuju lokasi membawa antipiretik.
                </p>
            </div>
        </div>
    </div>

    <!-- Reply Input Bar -->
    <div class="mt-3 flex items-center gap-2">
        <input
            type="text"
            placeholder="Ketik balasan untuk dokter hewan..."
            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg p-2.5 w-full text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
        />
        <button
            type="button"
            onclick="alert('Pesan terkirim ke dokter hewan!')"
            class="bg-primary-700 hover:bg-primary-800 text-white text-xs font-medium px-4 py-2.5 rounded-lg shrink-0 transition"
        >
            Kirim
        </button>
    </div>
</div>

<!-- Section 2: Rekam Medis Ternak Digital -->
<div id="rekam-medis" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Rekam Medis Ternak & E-Tagging</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan riwayat kesehatan, vaksinasi, dan inseminasi.</p>
        </div>
        <button
            type="button"
            onclick="alert('Form pendaftaran e-tag baru dibuka!')"
            class="text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-600"
        >
            + Tambah E-Tag
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
            <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                <tr>
                    <th class="px-3.5 py-2.5">ID E-Tag</th>
                    <th class="px-3.5 py-2.5">Nama Ternak</th>
                    <th class="px-3.5 py-2.5">Jenis</th>
                    <th class="px-3.5 py-2.5">Reproduksi</th>
                    <th class="px-3.5 py-2.5">Vaksinasi Terakhir</th>
                    <th class="px-3.5 py-2.5">Dokter</th>
                    <th class="px-3.5 py-2.5">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr>
                    <td class="px-3.5 py-2.5 font-mono font-medium text-gray-900 dark:text-white">JTM-PAS-0024</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white">Melati</td>
                    <td class="px-3.5 py-2.5">Sapi Perah FH</td>
                    <td class="px-3.5 py-2.5">Bunting 4 Bln</td>
                    <td class="px-3.5 py-2.5 text-primary-700 dark:text-primary-400 font-medium">PMK Booster 2</td>
                    <td class="px-3.5 py-2.5">drh. Bambang</td>
                    <td class="px-3.5 py-2.5"><span class="bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 text-[10px] font-medium px-2 py-0.5 rounded">Sehat</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-2.5 font-mono font-medium text-gray-900 dark:text-white">JTM-PAS-0014</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white">Bunga</td>
                    <td class="px-3.5 py-2.5">Sapi Perah FH</td>
                    <td class="px-3.5 py-2.5">Laktasi (17 L/hr)</td>
                    <td class="px-3.5 py-2.5 text-amber-700 dark:text-amber-400 font-medium">Jadwal Ulang</td>
                    <td class="px-3.5 py-2.5">drh. Ratna</td>
                    <td class="px-3.5 py-2.5"><span class="bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 text-[10px] font-medium px-2 py-0.5 rounded">Perawatan</span></td>
                </tr>
                <tr>
                    <td class="px-3.5 py-2.5 font-mono font-medium text-gray-900 dark:text-white">JTM-PAS-0031</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white">Si Manis</td>
                    <td class="px-3.5 py-2.5">Pedet FH Betina</td>
                    <td class="px-3.5 py-2.5">Sapih (3 Bln)</td>
                    <td class="px-3.5 py-2.5 text-primary-700 dark:text-primary-400 font-medium">Primer</td>
                    <td class="px-3.5 py-2.5">drh. Ratna</td>
                    <td class="px-3.5 py-2.5"><span class="bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 text-[10px] font-medium px-2 py-0.5 rounded">Sehat</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Section 3: Ensiklopedia Penyakit -->
<div id="info-penyakit" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">Ensiklopedia Penyakit Ternak</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Panduan gejala dan pertolongan pertama penyakit menular.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-xs">
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <span class="text-[10px] font-medium text-red-700 bg-red-50 dark:bg-red-950/60 dark:text-red-300 px-2 py-0.5 rounded">Penyakit Menular</span>
            <h4 class="text-xs font-bold text-gray-900 dark:text-white mt-1.5">Penyakit Mulut & Kuku (PMK)</h4>
            <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Lepuh pada lidah, bibir, dan sela kuku. Ternak pincang dan air liur berbusa menggantung.
            </p>
        </div>

        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <span class="text-[10px] font-medium text-amber-700 bg-amber-50 dark:bg-amber-950/60 dark:text-amber-300 px-2 py-0.5 rounded">Vektor Serangga</span>
            <h4 class="text-xs font-bold text-gray-900 dark:text-white mt-1.5">Lumpy Skin Disease (LSD)</h4>
            <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Nodul benjolan keras pada kulit leher dan punggung disertai demam tinggi ternak.
            </p>
        </div>

        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <span class="text-[10px] font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">Bakteri Ambing</span>
            <h4 class="text-xs font-bold text-gray-900 dark:text-white mt-1.5">Mastitis (Radang Ambing)</h4>
            <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Ambing bengkak, merah, dan panas. Susu pecah atau menggumpal saat diperah.
            </p>
        </div>
    </div>
</div>
@endsection

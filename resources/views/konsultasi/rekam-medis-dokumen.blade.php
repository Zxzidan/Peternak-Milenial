<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Rekam Medis & Panduan Penanganan Ternak — {{ $record['document_number'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .document-sheet {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: none !important;
                padding: 10mm 12mm !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4 portrait;
                margin: 8mm;
            }
        }
        .kop-double-border {
            border-bottom: 3px double #1e293b;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-6 px-3 sm:px-6 flex flex-col items-center justify-start font-sans antialiased text-gray-900">

    <!-- Screen Toolbar (No Print) -->
    <div class="no-print w-full max-w-4xl mb-4 flex flex-wrap items-center justify-between gap-3">
        <a
            href="{{ route('konsultasi', ['tab' => 'rekam_medis']) }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-gray-700 hover:text-gray-900 border border-gray-200 text-xs font-semibold shadow-2xs transition"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            <span>Kembali ke Rekam Medis</span>
        </a>

        <div class="flex items-center gap-2">
            <!-- Unduh File Dokumen Word/Doc -->
            <button
                type="button"
                onclick="downloadAsDoc()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-bold shadow-2xs transition cursor-pointer"
                title="Unduh berkas dokumen Microsoft Word / Dokumen Offline"
            >
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <span>Unduh Dokumen (.doc)</span>
            </button>

            <!-- Cetak / Simpan PDF -->
            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-xs font-bold shadow-md transition cursor-pointer"
                title="Cetak langsung atau simpan sebagai dokumen PDF"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.07-.341-2.17-.341-3.279 0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8c-1.11 0-2.209-.101-3.279-.341M3 21l9-9m0 0l-3-3m3 3l3-3"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Printable Official Sheet Container (A4 Portrait) -->
    <div id="printable-medical-record" class="document-sheet bg-white w-full max-w-4xl rounded-2xl shadow-xl border border-gray-200 p-8 sm:p-12 relative flex flex-col justify-start">

        <!-- 1. KOP SURAT RESMI PEMERINTAH PROVINSI JAWA TIMUR -->
        <div class="flex items-center justify-between pb-4 border-b-4 border-gray-900 mb-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Logo Peternak Milenial Jatim" class="w-20 h-20 object-contain shrink-0" />
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-widest text-[#013A85]">
                        Pemerintah Provinsi Jawa Timur
                    </h3>
                    <h1 class="text-xl sm:text-2xl font-black uppercase tracking-wide text-gray-900 leading-tight">
                        Dinas Peternakan
                    </h1>
                    <p class="text-xs font-bold text-gray-700">
                        Pusat Pelayanan Kesehatan Hewan Terpadu (Puskeswan) &amp; Telemedisin Veteriner
                    </p>
                    <p class="text-[11px] text-gray-500 mt-0.5">
                        Jl. Ahmad Yani No. 202, Gayungan, Surabaya 60235 | Telp: (031) 8292801 | disnak.jatimprov.go.id
                    </p>
                </div>
            </div>
            <div class="hidden sm:block text-right">
                <div class="inline-block border-2 border-emerald-600 bg-emerald-50 text-emerald-800 px-3 py-1.5 rounded-lg text-center">
                    <span class="block text-[9px] font-extrabold uppercase tracking-wider">E-Rekam Medis</span>
                    <span class="text-xs font-black">RESMI TERVERIFIKASI</span>
                </div>
            </div>
        </div>

        <!-- 2. JUDUL LEMBAR & NOMOR SURAT -->
        <div class="text-center my-3 pb-3 border-b border-gray-200">
            <h2 class="text-base sm:text-lg font-black uppercase tracking-wide text-gray-900">
                Lembar Hasil Rekam Medis &amp; Petunjuk Penanganan Ternak
            </h2>
            <div class="flex flex-wrap items-center justify-center gap-3 mt-1.5 text-xs text-gray-600">
                <span class="font-mono font-bold text-primary-700 bg-primary-50 px-2.5 py-0.5 rounded border border-primary-200">
                    No. Dokumen: {{ $record['document_number'] }}
                </span>
                <span>•</span>
                <span>Tanggal Pemeriksaan: <strong>{{ $record['date'] }}</strong></span>
                <span>•</span>
                <span>Waktu Sesi: <strong>{{ $record['time'] }}</strong></span>
                <span>•</span>
                <span class="font-semibold text-emerald-700">Status: {{ $record['status_label'] }}</span>
            </div>
        </div>

        <!-- 3. IDENTITAS PETERNAK & IDENTITAS TERNAK PASIEN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-3 text-xs">
            <!-- Box A: Identitas Pemilik Ternak -->
            <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-200 space-y-1.5">
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-900 pb-1 border-b border-gray-200">
                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    <span>I. IDENTITAS PETERNAK / PEMILIK</span>
                </div>
                <div class="grid grid-cols-3 gap-1 pt-1">
                    <span class="text-gray-500">Nama Peternak:</span>
                    <span class="col-span-2 font-bold text-gray-900">{{ $record['owner_name'] }}</span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Kontak / HP:</span>
                    <span class="col-span-2 font-semibold text-gray-800">{{ $record['owner_phone'] }}</span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Nama Peternakan:</span>
                    <span class="col-span-2 font-semibold text-gray-800">{{ $record['farm_name'] }}</span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Alamat / Wilayah:</span>
                    <span class="col-span-2 text-gray-700 leading-tight">{{ $record['owner_address'] }}</span>
                </div>
            </div>

            <!-- Box B: Identitas Ternak (Pasien) -->
            <div class="p-3.5 bg-gray-50 rounded-xl border border-gray-200 space-y-1.5">
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-900 pb-1 border-b border-gray-200">
                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386l5.411-3.18a2.25 2.25 0 00.916-1.542l.564-6.48a2.25 2.25 0 00-.659-1.591L12.5 3.659A2.25 2.25 0 0010.909 3h-1.34z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    <span>II. IDENTITAS TERNAK PASIEN</span>
                </div>
                <div class="grid grid-cols-3 gap-1 pt-1">
                    <span class="text-gray-500">Nomor E-Tag:</span>
                    <span class="col-span-2 font-mono font-bold text-primary-700 bg-white px-2 py-0.5 rounded border border-blue-200 inline-block w-fit">
                        {{ $record['animal_tag'] }}
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Nama / Bangsa:</span>
                    <span class="col-span-2 font-bold text-gray-900">{{ $record['animal_name'] }}</span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Jenis Ternak:</span>
                    <span class="col-span-2 font-semibold text-gray-800">{{ $record['animal_type'] }}</span>
                </div>
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-gray-500">Jenis Kelamin:</span>
                    <span class="col-span-2 text-gray-700">{{ $record['animal_gender'] }}</span>
                </div>
            </div>
        </div>

        <!-- 4. HASIL PEMERIKSAAN MEDIS, DIAGNOSA & RESEP DOKTER -->
        <div class="my-3 space-y-3 text-xs">
            <!-- Anamnesa & Keluhan -->
            <div class="p-3.5 bg-white rounded-xl border border-gray-200 space-y-1">
                <span class="font-bold text-gray-900 block text-xs">
                    III. KELUHAN AWAL / ANAMNESA PETERNAK:
                </span>
                <p class="font-semibold text-gray-800">{{ $record['subject'] }}</p>
                <p class="text-gray-600 leading-relaxed italic bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                    "{{ $record['complaint'] }}"
                </p>
            </div>

            <!-- Diagnosa & Tindakan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- Diagnosa Medis -->
                <div class="p-3.5 bg-blue-50/60 rounded-xl border border-blue-200 space-y-1.5">
                    <div class="flex items-center gap-1.5 font-bold text-blue-900">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        <span>IV. HASIL DIAGNOSA KLINIS DOKTER:</span>
                    </div>
                    <p class="text-gray-900 font-semibold leading-relaxed bg-white p-2.5 rounded-lg border border-blue-100">
                        {{ $record['diagnosis'] }}
                    </p>
                </div>

                <!-- Resep Obat & Tindakan -->
                <div class="p-3.5 bg-emerald-50/60 rounded-xl border border-emerald-200 space-y-1.5">
                    <div class="flex items-center gap-1.5 font-bold text-emerald-900">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <span>V. TINDAKAN MEDIS &amp; RESEP OBAT:</span>
                    </div>
                    <p class="text-emerald-950 font-bold leading-relaxed bg-white p-2.5 rounded-lg border border-emerald-100">
                        {{ $record['prescription'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- 5. SEKSI UTAMA: CARA PENANGANAN & PANDUAN PERAWATAN UNTUK PETERNAK (SOP KANDANG) -->
        <div class="my-3 p-4 bg-amber-50/50 rounded-xl border-2 border-amber-300 space-y-3 text-xs">
            <div class="flex items-center justify-between pb-2 border-b border-amber-200">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xs">VI</span>
                    <div>
                        <h3 class="text-xs sm:text-sm font-black text-amber-950 uppercase tracking-wide">
                            Petunjuk &amp; Cara Penanganan Ternak untuk Peternak di Kandang
                        </h3>
                        <p class="text-[11px] text-amber-800">
                            Wajib diikuti oleh peternak selama masa pemulihan untuk menjamin kesembuhan dan keamanan kawanan.
                        </p>
                    </div>
                </div>
                <span class="text-[10px] font-bold uppercase bg-amber-200 text-amber-900 px-2 py-0.5 rounded">SOP Veteriner Jatim</span>
            </div>

            <!-- List Panduan Berstruktur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5 pt-1">
                @foreach ($record['care_instructions'] as $item)
                    <div class="p-3 bg-white rounded-lg border border-amber-200 flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">
                            {{ $item['step'] }}
                        </span>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-gray-900 text-xs">{{ $item['title'] }}</h4>
                            <p class="text-gray-700 text-[11px] leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 6. PENGESAHAN DOKTER HEWAN & TANDA TANGAN DIGITAL RESMI -->
        <div class="mt-4 pt-4 border-t-2 border-gray-200 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs items-end">
            <!-- QR Verification -->
            <div class="flex items-center gap-2.5">
                <div class="w-16 h-16 bg-gray-100 border border-gray-300 rounded-lg p-1 flex items-center justify-center shrink-0">
                    <!-- SVG Barcode Representation -->
                    <svg class="w-14 h-14" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="5" width="25" height="25" stroke="#1e293b" stroke-width="4" fill="none" />
                        <rect x="12" y="12" width="11" height="11" fill="#1e293b" />
                        <rect x="70" y="5" width="25" height="25" stroke="#1e293b" stroke-width="4" fill="none" />
                        <rect x="77" y="12" width="11" height="11" fill="#1e293b" />
                        <rect x="5" y="70" width="25" height="25" stroke="#1e293b" stroke-width="4" fill="none" />
                        <rect x="12" y="77" width="11" height="11" fill="#1e293b" />
                        <rect x="40" y="20" width="8" height="8" fill="#1e293b" />
                        <rect x="52" y="20" width="8" height="8" fill="#1e293b" />
                        <rect x="40" y="40" width="20" height="20" fill="#1e293b" />
                        <rect x="70" y="40" width="8" height="8" fill="#1e293b" />
                        <rect x="82" y="52" width="8" height="8" fill="#1e293b" />
                        <rect x="40" y="70" width="12" height="8" fill="#1e293b" />
                        <rect x="70" y="70" width="20" height="8" fill="#1e293b" />
                    </svg>
                </div>
                <div class="text-[10px] text-gray-500 leading-tight">
                    <span class="font-bold text-gray-800 block">Verifikasi Digital:</span>
                    <span>Pindai barcode untuk memvalidasi keaslian rekam medis di database Disnak Prov. Jatim.</span>
                </div>
            </div>

            <!-- Stempel Digital -->
            <div class="hidden sm:flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 rounded-full border-2 border-emerald-700/60 flex items-center justify-center p-1 text-[8px] font-black uppercase text-emerald-800 rotate-[-12deg]">
                    <span>DISNAK JATIM<br>TERVERIFIKASI</span>
                </div>
            </div>

            <!-- Tanda Tangan Dokter Hewan -->
            <div class="text-right space-y-1">
                <p class="text-[11px] text-gray-600">Surabaya, {{ $record['date'] }}</p>
                <p class="text-[11px] font-bold text-gray-900">Dokter Hewan Pemeriksa,</p>
                <div class="py-2">
                    <span class="inline-block font-serif italic text-base font-bold text-[#013A85] border-b border-gray-400 pb-0.5">
                        {{ $record['doctor_name'] }}
                    </span>
                </div>
                <p class="text-[10px] text-gray-600">SIP: {{ $record['doctor_sip'] }}</p>
                <p class="text-[10px] font-semibold text-gray-700">{{ $record['doctor_puskeswan'] }}</p>
            </div>
        </div>

        <!-- Watermark / Footer Catatan Legal -->
        <div class="mt-6 pt-3 border-t border-gray-200 text-[10px] text-gray-400 flex flex-wrap items-center justify-between gap-2">
            <span>Sistem Informasi Kesehatan Hewan Peternak Milenial — Dinas Peternakan Provinsi Jawa Timur</span>
            <span>Dokumen Sah Elektronik Sesuai UU ITE No. 11/2008</span>
        </div>
    </div>

    <!-- Script Download & Auto Print -->
    <script>
        // Download document as .doc
        function downloadAsDoc() {
            const content = document.getElementById('printable-medical-record').innerHTML;
            const docTitle = @json('Rekam Medis ' . $record['document_number']);
            const preHtml = '\x3Chtml xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40"\x3E\x3Chead\x3E\x3Cmeta charset="utf-8"\x3E\x3Ctitle\x3E' + docTitle + '\x3C/title\x3E\x3Cstyle\x3Ebody{font-family:Arial,sans-serif;font-size:12pt;color:#1e293b;}\x3C/style\x3E\x3C/head\x3E\x3Cbody\x3E';
            const postHtml = '\x3C/body\x3E\x3C/html\x3E';
            const html = preHtml + content + postHtml;

            const blob = new Blob(['\ufeff', html], {
                type: 'application/msword'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = "Rekam-Medis-{{ str_replace(['/', ' '], '-', $record['document_number']) }}.doc";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Auto print trigger if query param ?print=1 is present
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === '1') {
                setTimeout(() => {
                    window.print();
                }, 400);
            }
        });
    </script>
</body>
</html>

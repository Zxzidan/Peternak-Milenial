<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Resmi — {{ $certificate->certificate_number }} — {{ $training->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body {
                background: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .certificate-container {
                box-shadow: none !important;
                border-width: 8px !important;
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                max-width: none !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
        .font-serif-title {
            font-family: 'Cinzel', serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-6 px-3 sm:px-6 flex flex-col items-center justify-center font-sans antialiased text-gray-900">

    <!-- Floating Top Toolbar (Screen Only) -->
    <div class="no-print w-full max-w-5xl mb-4 flex items-center justify-between gap-3">
        <a
            href="{{ route('pelatihan', ['tab' => 'sertifikat']) }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-gray-700 hover:text-gray-900 border border-gray-200 text-xs font-semibold shadow-2xs transition"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            <span>Kembali ke Pelatihan</span>
        </a>

        <div class="flex items-center gap-2">
            @if($isPreview ?? false)
            <span class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold">
                Mode Pratinjau Format (Admin)
            </span>
            @endif
            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md transition cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.07-.341-2.17-.341-3.279 0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8c-1.11 0-2.209-.101-3.279-.341M3 21l9-9m0 0l-3-3m3 3l3-3"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Certificate Document Container (A4 Landscape Aspect Ratio) -->
    <div class="certificate-container bg-white w-full max-w-5xl aspect-[1.414/1] rounded-2xl shadow-2xl border-[10px] border-[#013A85] p-8 sm:p-12 relative flex flex-col justify-between overflow-hidden">

        <!-- Decorative Double Inner Border -->
        <div class="absolute inset-2 border-2 border-amber-500/70 pointer-events-none rounded-lg"></div>
        <div class="absolute inset-3 border border-amber-400/40 pointer-events-none rounded-md"></div>

        <!-- Watermark Background Emblem -->
        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
            <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Watermark" class="w-96 h-96 object-contain filter grayscale" />
        </div>

        <!-- 1. Header Instansi Pemerintah -->
        <div class="relative z-10 flex items-center justify-between border-b-2 border-gray-200 pb-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Logo Peternak Milenial" class="w-16 h-16 object-contain" />
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-[#013A85]">
                        Pemerintah Provinsi Jawa Timur
                    </h4>
                    <h2 class="text-lg sm:text-xl font-extrabold uppercase tracking-wide text-gray-900 leading-tight">
                        Dinas Peternakan
                    </h2>
                    <p class="text-[10px] text-gray-500">
                        Jl. Ahmad Yani No. 202, Gayungan, Surabaya | Layanan E-Sertifikasi Peternak Milenial Jatim
                    </p>
                </div>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                    E-Signature Terverifikasi
                </span>
                <p class="font-mono text-xs font-extrabold text-gray-800 mt-1">
                    No: {{ $certificate->certificate_number }}
                </p>
            </div>
        </div>

        <!-- 2. Certificate Body / Isi Sertifikat -->
        <div class="relative z-10 text-center my-auto py-4 space-y-3">
            <h1 class="font-serif-title text-2xl sm:text-3xl font-extrabold text-[#013A85] tracking-widest uppercase">
                Sertifikat Kelulusan &amp; Kompetensi
            </h1>

            <p class="text-xs uppercase tracking-widest text-gray-500 font-semibold">
                Diberikan dengan bangga kepada:
            </p>

            <div class="py-1">
                <h3 class="text-2xl sm:text-4xl font-extrabold font-serif text-gray-900 uppercase tracking-wide underline decoration-amber-500 decoration-2 underline-offset-8">
                    {{ $certificate->recipient_name }}
                </h3>
                <p class="text-[11px] text-gray-400 mt-2 font-mono">
                    ID Penerima: {{ $certificate->recipient_code ?? ('NIK-JTM-' . $certificate->user_id . '026') }}
                </p>
            </div>

            <p class="text-xs text-gray-600 max-w-2xl mx-auto leading-relaxed pt-2">
                Atas partisipasi aktif, dedikasi, dan kelulusan evaluasi kompetensi pada program bimbingan teknis:
            </p>

            <div class="py-1">
                <h2 class="text-lg sm:text-2xl font-extrabold text-[#013A85]">
                    "{{ $training->certificate_title ?? $training->title }}"
                </h2>
                @if($training->certificate_title && $training->certificate_title !== $training->title)
                <p class="text-xs text-[#013A85] font-semibold mt-0.5">
                    Program Pelatihan: {{ $training->title }}
                </p>
                @endif
                <p class="text-xs text-gray-500 mt-1">
                    Instruktur / Pemateri: <strong>{{ $training->instructor ?? 'Tim Ahli Dinas Peternakan Jawa Timur' }}</strong>
                </p>
            </div>

            <p class="text-[11px] text-gray-500 max-w-2xl mx-auto">
                Diselenggarakan oleh Dinas Peternakan Provinsi Jawa Timur guna mendukung kemandirian, adopsi teknologi modern, dan kedaulatan pangan Peternak Milenial Indonesia.
            </p>
        </div>

        <!-- 3. Footer: Barcode, QR Code & Tanda Tangan Resmi -->
        <div class="relative z-10 pt-4 border-t-2 border-gray-200 flex items-end justify-between">
            <!-- Left: Barcode & Digital Verification Note -->
            <div class="space-y-1.5 text-left max-w-xs">
                <div class="flex items-center gap-2">
                    <!-- Barcode simulation -->
                    <div class="h-8 flex items-center gap-[2px] bg-gray-50 p-1 rounded border border-gray-200">
                        @for($i = 0; $i < 32; $i++)
                        <span class="inline-block bg-black {{ $i % 3 === 0 ? 'w-[3px]' : ($i % 2 === 0 ? 'w-[1.5px]' : 'w-[1px]') }} h-full"></span>
                        @endfor
                    </div>
                </div>
                <p class="text-[9px] text-gray-500 leading-tight">
                    Dokumen ini sah dan diterbitkan secara digital dengan QR-Signature Dinas Peternakan Jatim.
                </p>
                <p class="text-[10px] font-bold text-emerald-700">
                    &check; Terverifikasi Sah Otomatis
                </p>
            </div>

            <!-- Center: Golden Seal Badge -->
            <div class="hidden sm:flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-amber-400 via-amber-300 to-yellow-500 p-0.5 shadow-md flex items-center justify-center">
                    <div class="w-full h-full rounded-full border-2 border-dashed border-amber-700/60 flex flex-col items-center justify-center text-center p-1">
                        <span class="text-[7px] font-extrabold uppercase text-amber-900 leading-none">Resmi</span>
                        <span class="text-[8px] font-black uppercase text-amber-950 leading-none my-0.5">DISNAK</span>
                        <span class="text-[7px] font-extrabold uppercase text-amber-900 leading-none">JATIM</span>
                    </div>
                </div>
            </div>

            <!-- Right: Signature of Head of Agency -->
            <div class="text-right space-y-1">
                <p class="text-xs text-gray-600">
                    Surabaya, {{ $certificate->issued_date ? $certificate->issued_date->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                </p>
                <p class="text-xs font-bold text-[#013A85]">
                    Kepala Dinas Peternakan Provinsi Jawa Timur
                </p>

                <!-- Digital Stamp & Signature container -->
                <div class="relative py-1 flex items-center justify-end">
                    <div class="w-28 h-12 relative flex items-center justify-center">
                        <div class="absolute inset-0 flex items-center justify-center text-indigo-700 font-serif italic text-lg opacity-85 select-none pointer-events-none">
                            Indyah Aryani
                        </div>
                        <div class="absolute -left-3 -top-2 w-14 h-14 rounded-full border-2 border-dashed border-indigo-500/50 flex items-center justify-center text-center rotate-[-12deg] pointer-events-none">
                            <span class="text-[8px] font-bold text-indigo-600/70 uppercase">DISNAK JATIM</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h5 class="text-xs font-extrabold text-gray-900 underline decoration-gray-400">
                        Dr. Ir. Indyah Aryani, MM
                    </h5>
                    <p class="text-[10px] text-gray-500">
                        Pembina Utama Madya &bull; NIP. 19680514 199303 2 003
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>

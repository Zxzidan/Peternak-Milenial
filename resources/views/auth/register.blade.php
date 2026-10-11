<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru — Peternak Milenial Jawa Timur</title>

    <!-- Typography: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Flowbite & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        @keyframes stepFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-pane:not(.hidden) {
            animation: stepFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body
    class="bg-slate-100/70 text-slate-800 min-h-screen flex flex-col justify-between antialiased selection:bg-blue-600 selection:text-white">

    <!-- Main Content Area: Unified Modal Card (Split Layout: Image on Left, Form on Right - Matching Login Page) -->
    <main class="flex-1 flex items-center justify-center py-4 sm:py-6 lg:py-6 px-4 sm:px-6 lg:px-8">
        <div
            class="w-full max-w-5xl xl:max-w-6xl bg-white rounded-3xl sm:rounded-[32px] overflow-hidden shadow-2xl shadow-slate-900/10 border border-slate-200/80 grid grid-cols-1 lg:grid-cols-12">

            <!-- LEFT COLUMN: Hero Image Showcase with Dark Gradient Overlay (Matching Login Design) -->
            <div
                class="lg:col-span-5 relative hidden lg:flex flex-col justify-between p-7 sm:p-8 xl:p-9 text-white overflow-hidden group">
                <!-- Background Image (Full Bleed, High Definition) -->
                <img
                    src="{{ asset('img/hiasan baru 1.jpg') }}"
                    alt="Dukungan & Kemitraan Peternak Milenial Jatim"
                    class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105 select-none"
                />

                <!-- Multi-stop Gradient Overlay for Crisp Text Readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-900/25"></div>
                <div class="absolute inset-0 bg-slate-900/10 pointer-events-none"></div>

                <!-- Top Row Over Image: Badge -->
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-semibold tracking-wide text-white bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15">
                        Dinas Peternakan Jatim
                    </span>
                </div>

                <!-- Bottom Information: Title, Description & Feature Pills -->
                <div class="relative z-10 space-y-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight leading-snug drop-shadow-sm">
                            Bergabung dengan Ekosistem Peternak Milenial Jatim
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-200/90 mt-2 leading-relaxed">
                            Langkah nyata mewujudkan kemandirian pangan hewani melalui pendampingan ahli, sertifikasi ternak, dan kemudahan akses pasar di Jawa Timur.
                        </p>
                    </div>

                    <!-- Glassmorphic Benefit Badges -->
                    <div class="grid grid-cols-2 gap-2.5 pt-1">
                        <div class="p-2.5 sm:p-3 bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white truncate leading-tight">Bimbingan Teknis</h4>
                                <p class="text-[11px] text-slate-300 truncate leading-tight mt-0.5">e-Tag Barcode</p>
                            </div>
                        </div>

                        <div class="p-2.5 sm:p-3 bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-blue-500/20 border border-blue-400/30 text-blue-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white truncate leading-tight">Pasar Digital</h4>
                                <p class="text-[11px] text-slate-300 truncate leading-tight mt-0.5">Komoditas Jatim</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Registration Form (Spacious, Unified Single Modal) -->
            <div class="lg:col-span-7 p-6 sm:p-8 lg:p-8 xl:p-10 bg-white flex flex-col justify-between">

                <!-- Brand Header with Logo & Back to Home Link -->
                <div class="flex items-center justify-between mb-5 pb-3.5 border-b border-slate-100">
                    <a href="{{ route('landing') }}" class="flex items-center group" title="Kembali ke Beranda">
                        <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Peternak Milenial Jawa Timur"
                            class="h-8 sm:h-9 w-auto object-contain transition-transform group-hover:scale-105" />
                    </a>
                    <a href="{{ route('landing') }}"
                        class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-500 hover:text-blue-600 px-3 py-1.5 rounded-xl hover:bg-slate-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        <span>Halaman Utama</span>
                    </a>
                </div>

                <!-- Heading, Subtitle & Role Category Selector -->
                <div class="space-y-3.5 mb-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                                Sign up
                            </h1>
                            <span id="badge-role-title" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80 shadow-2xs">
                                Pendaftaran Peternak Milenial Jatim
                            </span>
                        </div>

                        <!-- Role Category Switcher -->
                        <div class="flex items-center gap-2.5 shrink-0">
                            <!-- Peternak Milenial -->
                            <button type="button" id="role-card-peternak" onclick="setRole('peternak')"
                                class="px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-blue-50/80 border-blue-600 ring-2 ring-blue-100 shadow-2xs">
                                <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-2xs" id="role-icon-peternak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-800">Peternak</span>
                            </button>

                            <!-- Masyarakat Umum -->
                            <button type="button" id="role-card-umum" onclick="setRole('umum')"
                                class="px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-white border-slate-200 hover:border-slate-300 shadow-2xs">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 shadow-2xs" id="role-icon-umum">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-800">Masyarakat</span>
                            </button>
                        </div>
                    </div>

                    <p id="subtitle-role" class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-2xl">
                        Lengkapi data diri, wilayah domisili, dan usaha peternakan Anda untuk mulai mengakses ekosistem digital Dinas Peternakan Jawa Timur.
                    </p>
                </div>

                <!-- Flash Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm">
                        <div class="font-semibold mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            Mohon perbaiki data formulir berikut:
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 text-red-700 ml-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $initialStepIndex = 0;
                    if ($errors->any()) {
                        $oldRole = old('role', request('role', 'peternak'));
                        if ($errors->has('password') || $errors->has('password_confirmation') || $errors->has('ktp_file')) {
                            $initialStepIndex = ($oldRole === 'umum') ? 2 : 3;
                        } elseif ($errors->has('livestock_type') || $errors->has('livestock_count')) {
                            $initialStepIndex = 2;
                        } elseif ($errors->has('kabupaten') || $errors->has('kecamatan') || $errors->has('desa') || $errors->has('alamat')) {
                            $initialStepIndex = 1;
                        } elseif ($errors->has('name') || $errors->has('birth_date') || $errors->has('email') || $errors->has('phone_number') || $errors->has('nik')) {
                            $initialStepIndex = 0;
                        }
                    }
                @endphp

                <!-- Register Form (Step-by-Step Wizard) -->
                <form id="register-form" action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                    @csrf
                    <input type="hidden" name="role" id="role_input" value="{{ old('role', request('role', 'peternak')) }}">
                    <input type="hidden" name="terms" value="1">

                    <!-- Multi-Step Wizard Progress Bar -->
                    <div id="wizard-progress-card" class="p-3.5 sm:p-4 bg-slate-50/90 border border-slate-200/90 rounded-2xl shadow-2xs mb-5">
                        <!-- Step Counter & Title -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <span id="wizard-step-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-600 text-white shadow-2xs">
                                    Langkah 1 dari 4
                                </span>
                                <span id="wizard-current-title" class="text-xs sm:text-sm font-bold text-slate-800">
                                    Identitas Diri &amp; Kontak
                                </span>
                            </div>
                            <span id="wizard-percent-text" class="text-xs sm:text-sm font-extrabold text-blue-600">
                                25% Selesai
                            </span>
                        </div>

                        <!-- Progress Bar Track -->
                        <div class="w-full bg-slate-200/90 rounded-full h-2 mb-2.5 overflow-hidden">
                            <div id="wizard-progress-bar" class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 25%"></div>
                        </div>

                        <!-- Step Tabs -->
                        <div id="wizard-steps-nav" class="grid grid-cols-4 gap-2 pt-2.5 border-t border-slate-200/70">
                            <!-- Step 0 Tab -->
                            <button type="button" onclick="handleStepNavClick(0)" id="step-nav-0"
                                class="step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-blue-800 bg-blue-50 ring-1 ring-blue-200">
                                <div id="step-num-0" class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-blue-600 text-white shadow-2xs">
                                    1
                                </div>
                                <div class="min-w-0 hidden sm:block">
                                    <p id="step-nav-title-0" class="text-xs font-bold text-slate-800 truncate">Identitas</p>
                                    <p id="step-nav-sub-0" class="text-[10px] text-slate-400 truncate mt-0.5">Data diri &amp; kontak</p>
                                </div>
                            </button>

                            <!-- Step 1 Tab -->
                            <button type="button" onclick="handleStepNavClick(1)" id="step-nav-1"
                                class="step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-slate-400 hover:bg-slate-50">
                                <div id="step-num-1" class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-slate-100 text-slate-500 border border-slate-200">
                                    2
                                </div>
                                <div class="min-w-0 hidden sm:block">
                                    <p id="step-nav-title-1" class="text-xs font-bold text-slate-700 truncate">Domisili</p>
                                    <p id="step-nav-sub-1" class="text-[10px] text-slate-400 truncate mt-0.5">Wilayah Jatim</p>
                                </div>
                            </button>

                            <!-- Step 2 Tab -->
                            <button type="button" onclick="handleStepNavClick(2)" id="step-nav-2"
                                class="step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-slate-400 hover:bg-slate-50">
                                <div id="step-num-2" class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-slate-100 text-slate-500 border border-slate-200">
                                    3
                                </div>
                                <div class="min-w-0 hidden sm:block">
                                    <p id="step-nav-title-2" class="text-xs font-bold text-slate-700 truncate">Peternakan</p>
                                    <p id="step-nav-sub-2" class="text-[10px] text-slate-400 truncate mt-0.5">Profil usaha ternak</p>
                                </div>
                            </button>

                            <!-- Step 3 Tab -->
                            <button type="button" onclick="handleStepNavClick(3)" id="step-nav-3"
                                class="step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-slate-400 hover:bg-slate-50">
                                <div id="step-num-3" class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-slate-100 text-slate-500 border border-slate-200">
                                    4
                                </div>
                                <div class="min-w-0 hidden sm:block">
                                    <p id="step-nav-title-3" class="text-xs font-bold text-slate-700 truncate">Keamanan</p>
                                    <p id="step-nav-sub-3" class="text-[10px] text-slate-400 truncate mt-0.5">Kata sandi &amp; KTP</p>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- STEP PANE 1: Identitas Diri & Kontak -->
                    <div id="step-pane-1" class="step-pane space-y-4">
                        <!-- SECTION 1: Identitas Diri -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 sm:p-6 space-y-4 sm:space-y-5 shadow-2xs">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200/80">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 id="sec1-title" class="text-sm sm:text-base font-bold text-slate-900 leading-normal">Identitas Diri &amp; Kontak</h2>
                                    <p id="sec1-desc" class="text-xs sm:text-sm text-slate-500 leading-normal mt-0.5">Informasi utama untuk verifikasi keanggotaan peternak</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="name" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Nama Lengkap<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                            placeholder="Nama Lengkap"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-3.5 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label for="birth_date" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Tanggal Lahir<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                        </div>
                                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-3.5 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition cursor-pointer">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="sm:col-span-2">
                                    <label for="email" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Email<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                            </svg>
                                        </div>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                            placeholder="Email"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-3.5 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                    </div>
                                </div>

                                <!-- No Telpon (WA) - Khusus Peternak -->
                                <div id="field-phone">
                                    <label for="phone_number" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        No Telpon (WA)<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H3.623a2.25 2.25 0 00-2.25 2.25z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                                            placeholder="628xxxxxxxxxx"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-3.5 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                    </div>
                                </div>

                                <!-- NIK - Khusus Peternak -->
                                <div id="field-nik">
                                    <label for="nik" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        NIK<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.364a2.25 2.25 0 00-2.044-1.239h-1.5a2.25 2.25 0 00-2.044 1.239A3.75 3.75 0 004.5 18h6.75a3.75 3.75 0 00-1.956-2.261z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" required
                                            placeholder="NIK"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-3.5 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1 Nav Action -->
                        <div class="pt-2 flex items-center justify-end">
                            <button type="button" onclick="nextStep()"
                                class="inline-flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-6 sm:px-7 transition duration-200 shadow-sm shadow-blue-500/20 hover:shadow-md cursor-pointer">
                                <span id="btn-next-step1-label">Lanjut: Wilayah Domisili</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP PANE 2: Alamat & Wilayah Domisili -->
                    <div id="step-pane-2" class="step-pane hidden space-y-4">
                        <!-- SECTION 2: Alamat & Wilayah Domisili -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 sm:p-6 space-y-4 sm:space-y-5 shadow-2xs">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200/70">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 id="sec2-title" class="text-sm sm:text-base font-bold text-slate-900 leading-normal">Alamat &amp; Wilayah Domisili</h2>
                                    <p id="sec2-desc" class="text-xs sm:text-sm text-slate-500 leading-normal mt-0.5">Alamat lengkap domisili tempat tinggal</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <!-- Alamat Lengkap -->
                                <div id="field-alamat">
                                    <label for="alamat" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Alamat Lengkap<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <textarea name="alamat" id="alamat" rows="3"
                                            placeholder="Alamat lengkap (nama jalan, RT/RW, nomor rumah, dsb.)"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full p-3 sm:p-3.5 placeholder-slate-400 shadow-2xs transition">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>

                                <!-- Wilayah Domisili (Jatim) - Cascading Dropdown Khusus Peternak -->
                                <div id="section-wilayah-cascading" class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 pt-3 border-t border-slate-200/60">
                                    <!-- Kabupaten/Kota -->
                                    <div class="sm:col-span-2">
                                        <label for="kabupaten" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                            Kabupaten/Kota<span class="text-red-500 font-bold ml-0.5">*</span>
                                        </label>
                                        @php
                                            $jatimKabupatens = [
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
                                        @endphp
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                            </div>
                                            <select name="kabupaten" id="kabupaten" required onchange="handleKabupatenChange(this.value)"
                                                class="appearance-none bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-9 py-2.5 sm:py-3 shadow-2xs transition cursor-pointer">
                                                <option value="" disabled {{ old('kabupaten') ? '' : 'selected' }}>Pilih Kabupaten...</option>
                                                @foreach ($jatimKabupatens as $kab)
                                                    <option value="{{ $kab }}" {{ old('kabupaten') == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kecamatan -->
                                    <div>
                                        <label for="kecamatan" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                            Kecamatan<span class="text-red-500 font-bold ml-0.5">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                                </svg>
                                            </div>
                                            <select name="kecamatan" id="kecamatan" required onchange="handleKecamatanChange(this.value)"
                                                class="appearance-none bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-9 py-2.5 sm:py-3 shadow-2xs transition cursor-pointer">
                                                <option value="" disabled {{ old('kecamatan') ? '' : 'selected' }}>Pilih Kecamatan...</option>
                                                @if(old('kecamatan'))
                                                    <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                                                @endif
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kelurahan/Desa -->
                                    <div>
                                        <label for="desa" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                            Kelurahan/Desa<span class="text-red-500 font-bold ml-0.5">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                                </svg>
                                            </div>
                                            <select name="desa" id="desa" required
                                                class="appearance-none bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-9 py-2.5 sm:py-3 shadow-2xs transition cursor-pointer">
                                                <option value="" disabled {{ old('desa') ? '' : 'selected' }}>Pilih Desa...</option>
                                                @if(old('desa'))
                                                    <option value="{{ old('desa') }}" selected>{{ old('desa') }}</option>
                                                @endif
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 Nav Action -->
                        <div class="pt-2 flex items-center justify-between gap-3">
                            <button type="button" onclick="prevStep()"
                                class="inline-flex items-center justify-center gap-2 text-slate-700 bg-slate-100 hover:bg-slate-200 focus:ring-2 focus:ring-slate-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-5 sm:px-6 transition duration-200 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                                <span>Sebelumnya</span>
                            </button>
                            <button type="button" onclick="nextStep()"
                                class="inline-flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-6 sm:px-7 transition duration-200 shadow-sm shadow-blue-500/20 hover:shadow-md cursor-pointer">
                                <span id="btn-next-step2-label">Lanjut: Profil Peternakan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP PANE 3: Profil Usaha Peternakan -->
                    <div id="step-pane-3" class="step-pane hidden space-y-4">
                        <!-- SECTION 3: Profil Usaha Peternakan -->
                        <div id="section-livestock" class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 sm:p-6 space-y-4 sm:space-y-5 shadow-2xs">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200/70">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 11l1 6l3 1l2-3h4l2 3l3-1l1-6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 10V7a3 3 0 013-3h4a3 3 0 013 3v3" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 16h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h.01M15 13h.01" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 10h2a2 2 0 002-2V7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 10H5a2 2 0 01-2-2V7" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-normal">Profil Usaha Peternakan</h2>
                                    <p class="text-xs sm:text-sm text-slate-500 leading-normal mt-0.5">Komoditas ternak yang sedang Anda budidayakan</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Jenis Ternak -->
                                <div>
                                    <label for="livestock_type" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Jenis Ternak<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    @php
                                        $livestockOptions = [
                                            'Sapi Potong',
                                            'Sapi Perah',
                                            'Ayam Broiler (Pedaging)',
                                            'Ayam Layer (Petelur)',
                                            'Kambing / Domba',
                                            'Bebek / Itik',
                                            'Burung Puyuh',
                                            'Kelinci',
                                            'Lainnya',
                                        ];
                                    @endphp
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 11l1 6l3 1l2-3h4l2 3l3-1l1-6" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 10V7a3 3 0 013-3h4a3 3 0 013 3v3" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 16h4" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h.01M15 13h.01" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 10h2a2 2 0 002-2V7" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 10H5a2 2 0 01-2-2V7" />
                                            </svg>
                                        </div>
                                        <select name="livestock_type" id="livestock_type" required
                                            class="appearance-none bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-9 py-2.5 sm:py-3 shadow-2xs transition cursor-pointer">
                                            <option value="" disabled {{ old('livestock_type') ? '' : 'selected' }}>Pilih Jenis Ternak...</option>
                                            @foreach ($livestockOptions as $opt)
                                                <option value="{{ $opt }}" {{ old('livestock_type') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jumlah Ternak -->
                                <div>
                                    <label for="livestock_count" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Jumlah Ternak<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-6-19.5l-3.9 19.5" />
                                            </svg>
                                        </div>
                                        <input type="number" min="0" name="livestock_count" id="livestock_count" value="{{ old('livestock_count') }}" required
                                            placeholder="Jumlah Ternak (ekor)"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-14 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs font-semibold text-slate-400 pointer-events-none">
                                            Ekor
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 Nav Action -->
                        <div class="pt-2 flex items-center justify-between gap-3">
                            <button type="button" onclick="prevStep()"
                                class="inline-flex items-center justify-center gap-2 text-slate-700 bg-slate-100 hover:bg-slate-200 focus:ring-2 focus:ring-slate-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-5 sm:px-6 transition duration-200 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                                <span>Sebelumnya</span>
                            </button>
                            <button type="button" onclick="nextStep()"
                                class="inline-flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-6 sm:px-7 transition duration-200 shadow-sm shadow-blue-500/20 hover:shadow-md cursor-pointer">
                                <span id="btn-next-step3-label">Lanjut: Keamanan &amp; KTP</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP PANE 4: Keamanan Akun & Berkas KTP -->
                    <div id="step-pane-4" class="step-pane hidden space-y-4">
                        <!-- SECTION 4: Keamanan & Berkas Verifikasi -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 sm:p-6 space-y-4 sm:space-y-5 shadow-2xs">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200/70">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 id="sec4-title" class="text-sm sm:text-base font-bold text-slate-900 leading-normal">Keamanan Akun &amp; Berkas Identitas</h2>
                                    <p id="sec4-desc" class="text-xs sm:text-sm text-slate-500 leading-normal mt-0.5">Kata sandi akun dan unggah foto KTP resmi untuk validasi</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Password Baru -->
                                <div>
                                    <label for="password" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Password Baru<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                        </div>
                                        <input type="password" name="password" id="password" required placeholder="Password Baru"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-10 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                        <button type="button" onclick="togglePasswordVisibility('password', 'password-eye-icon')" aria-label="Lihat kata sandi"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                            <svg id="password-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div>
                                    <label for="password_confirmation" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Konfirmasi Password<span class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi Password"
                                            class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-10 py-2.5 sm:py-3 placeholder-slate-400 shadow-2xs transition">
                                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'password_confirmation-eye-icon')" aria-label="Lihat konfirmasi kata sandi"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                            <svg id="password_confirmation-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Foto KTP (Comfortable Dropzone Container) -->
                                <div id="field-ktp" class="sm:col-span-2">
                                    <label for="ktp_file" class="block mb-2 text-xs sm:text-sm font-semibold text-slate-700">
                                        Foto KTP<span id="ktp-required-star" class="text-red-500 font-bold ml-0.5">*</span>
                                    </label>
                                    <div class="p-3.5 sm:p-4 border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-2xl bg-white hover:bg-blue-50/25 transition group">
                                        <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 w-full text-center sm:text-left">
                                                <input type="file" name="ktp_file" id="ktp_file" accept=".jpeg,.png,.jpg"
                                                    class="block w-full text-xs sm:text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer transition shadow-2xs" />
                                                <div class="mt-2 flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs text-slate-500 font-normal">
                                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 px-2.5 py-1 rounded-lg text-slate-600">
                                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                        * Besar Max 10 MB
                                                    </span>
                                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 px-2.5 py-1 rounded-lg text-slate-600">
                                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                        * Tipe: jpeg, png, dan jpg
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 Nav & Submit Action -->
                        <div class="pt-2 flex items-center justify-between gap-3">
                            <button type="button" onclick="prevStep()"
                                class="inline-flex items-center justify-center gap-2 text-slate-700 bg-slate-100 hover:bg-slate-200 focus:ring-2 focus:ring-slate-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-5 sm:px-6 transition duration-200 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                                <span>Sebelumnya</span>
                            </button>
                            <button type="submit" id="submit-btn"
                                class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-100 font-bold rounded-xl text-xs sm:text-sm py-2.5 sm:py-3 px-7 sm:px-8 transition duration-200 shadow-md shadow-blue-500/25 hover:shadow-lg cursor-pointer">
                                <span id="submit-btn-label">Sign Up</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Global Login Link (visible on all wizard steps) -->
                    <div class="mt-4 pt-3.5 border-t border-slate-100 text-center">
                        <p class="text-xs sm:text-sm text-slate-500">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-blue-600 hover:text-blue-700 font-bold hover:underline transition ml-1 inline-flex items-center gap-1">
                                <span>Masuk di sini</span>
                            </a>
                        </p>
                    </div>
                </form>

            </div>

        </div>
    </main>

    <!-- Footer (Bright Theme - Matching Login) -->
    <footer class="py-3 text-center text-xs text-slate-500 border-t border-slate-200/70 bg-white/60">
        &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Sistem Terpadu Peternak Milenial.
    </footer>

    <script>

        // Password visibility toggler
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            }
        }

        // Region Cascading Database (Provinsi Jawa Timur - 38 Kabupaten & Kota Resmi)
        const regionData = {
            "Kabupaten Bangkalan": {
                "Bangkalan": ["Demangan", "Kemayoran", "Kraton", "Mlajah", "Pejagan", "Pangeranan", "Mertajasah", "Sembilangan", "Ujung Piring"],
                "Burneh": ["Burneh", "Arok", "Benangkah", "Binoh", "Jambuh", "Kapor", "Langkap", "Pangolangan", "Sobih"],
                "Kamal": ["Banyuajuh", "Gili Anyar", "Gili Barat", "Gili Timur", "Kamal", "Kebun", "Tanjung Jati", "Telang"],
                "Socah": ["Socah", "Bilaporah", "Buluh", "Dakiring", "Junganyar", "Keleyan", "Parseh", "Pernajuh", "Petaonan", "Sanggrah Agung"],
                "Arosbaya": ["Arosbaya", "Balung", "Berbeluk", "Buduran", "Cendagah", "Dlemer", "Glagahan", "Karang Pao", "Lajing", "Makam Agung", "Pandan Lanjang", "Plakaran", "Tambegan", "Tengket"],
                "Blega": ["Blega", "Alas Rajah", "Bates", "Blega Oloh", "Campor", "Gadding", "Kampao", "Karang Gayam", "Karpote", "Ko'olan", "Lomaer", "Nyormanis", "Panjalinan", "Rosep"],
                "Tanjung Bumi": ["Tanjung Bumi", "Aeng Taber", "Bandang Dajah", "Bandang Laok", "Banyoneng Dajah", "Banyoneng Laok", "Bumianyar", "Larangan Timur", "Macajah", "Paseseh", "Tagungguh", "Telaga Biru", "Tlangoh"]
            },
            "Kabupaten Banyuwangi": {
                "Banyuwangi": ["Kampung Mandar", "Kampung Melayu", "Karangrejo", "Kebalenan", "Kepatihan", "Kertosari", "Lateng", "Pakis", "Panderejo", "Penganjuran", "Pengantigan", "Singonegaran", "Singotrunan", "Sobo", "Sukowidi", "Taman Baru", "Temenggungan"],
                "Rogojampi": ["Rogojampi", "Aliyan", "Gladag", "Gitik", "Karangbendo", "Kedaleman", "Lemahbangdewo", "Pengantigan", "Mangir"],
                "Genteng": ["Genteng Kulon", "Genteng Wetan", "Kaligondo", "Kembiritan", "Setail"],
                "Glenmore": ["Karangharjo", "Sumbergondo", "Sepanjang", "Tegalharjo", "Tulungrejo", "Bumiharjo"],
                "Kalipuro": ["Bulusan", "Gombengsari", "Kalipuro", "Klatak", "Ketapang", "Kelir", "Pesucen", "Telemung"],
                "Giri": ["Giri", "Boyolangu", "Grogol", "Jambesari", "Mojopanggung", "Penataban"],
                "Songgon": ["Songgon", "Balak", "Bangunsari", "Bayu", "Bedewang", "Parangharjo", "Sumberarum", "Sumberbulu", "Sragi"]
            },
            "Kabupaten Blitar": {
                "Kanigoro": ["Bangle", "Gaprang", "Gogodeso", "Jatinom", "Kanigoro", "Karangsono", "Kuningan", "Minggirsari", "Papungan", "Satreyan", "Sawentar", "Tlogo"],
                "Srengat": ["Bagelenan", "Dandong", "Dermaji", "Karanggayam", "Kauman", "Kendalrejo", "Kerjen", "Maron", "Ngaglik", "Pakisrejo", "Purwokerto", "Selokajang", "Srengat", "Togogan", "Wonorejo"],
                "Wlingi": ["Babadan", "Balerejo", "Beru", "Kudusan", "Ngadirejo", "Tegalasri", "Tembalang", "Wlingi"],
                "Gandusari": ["Butun", "Gadungan", "Gandusari", "Gondang", "Kotes", "Krisik", "Ngaringan", "Semen", "Slumbung", "Soso", "Sukosewu", "Sumberagung", "Tulungrejo"],
                "Garum": ["Bence", "Garum", "Karangrejo", "Pojok", "Slorok", "Sidodadi", "Tingal", "Tawangsari"],
                "Ponggok": ["Bacem", "Bendo", "Candirejo", "Dadaplangu", "Gembongan", "Jatilengger", "Karangbendo", "Kawedusan", "Kebonduren", "Maliran", "Pojok", "Ponggok", "Ringinanyar", "Sidorejo"]
            },
            "Kabupaten Bojonegoro": {
                "Bojonegoro": ["Campurejo", "Dander", "Kadipaten", "Karang Pacar", "Kauman", "Klangon", "Ledok Kulon", "Ledok Wetan", "Mojokampung", "Mulyoagung", "Ngrowo", "Pacul", "Semanding", "Sukorejo", "Sumbang"],
                "Dander": ["Dander", "Jatiblimbing", "Karangsono", "Kunci", "Ngablak", "Ngunut", "Sendangrejo", "Somodikaran", "Sumberagung", "Sumberarum", "Sumbertlaseh"],
                "Kapas": ["Bakat", "Bangilan", "Bogo", "Kapas", "Kedaton", "Klampok", "Mojodeso", "Ngampel", "Padang Mentoyo", "Plesungan", "Sambiroto", "Sembung", "Semanding", "Sukowati", "Tanjungharjo", "Tapelan", "Wedi"],
                "Kalitidu": ["Brenggolo", "Mojo", "Mojosari", "Mayanggeneng", "Mayangrejo", "Mlaten", "Ngringinrejo", "Panjunan", "Pilangsari", "Pungpungan", "Sukoharjo", "Sumengko", "Talok", "Wotanngare"],
                "Padangan": ["Banjarjo", "Dengok", "Kebonagung", "Kendung", "Kuncen", "Ngasinan", "Ngeper", "Ngradin", "Nguken", "Padangan", "Prangi", "Purworejo", "Sidorejo", "Sonorejo", "Tebon"],
                "Sumberrejo": ["Banjarejo", "Bogangin", "Butoh", "Deru", "Kayulemah", "Kedungrejo", "Margoagung", "Mejuwet", "Mlinjeng", "Ngampal", "Pejambon", "Pekuwon", "Prayungan", "Sambongrejo", "Sendangagung", "Sumberharjo", "Sumberrejo", "Sumuragung", "Teleng", "Tulungrejo", "Wotan"]
            },
            "Kabupaten Bondowoso": {
                "Bondowoso": ["Badean", "Blindungan", "Dabasah", "Kademangan", "Kotakulon", "Nangkaan", "Pancoran", "Pejaten", "Sukowiryo"],
                "Curahdami": ["Curahdami", "Curahpoh", "Jetis", "Kupang", "Locangang", "Pakuwesi", "Penambangan", "Petung", "Poncogati", "Selolembu", "Sumbersuko"],
                "Tamanan": ["Kalianyar", "Karang Melok", "Kemirian", "Mengen", "Sukosari", "Sumber Kemuning", "Sumber Anom", "Tamanan", "Wonosuko"],
                "Prajekan": ["Bandaran", "Cangkring", "Prajekan Kidul", "Prajekan Lor", "Sempol", "Tarum", "Walidono"],
                "Maesan": ["Gambangan", "Gunungsari", "Maesan", "Pakuniran", "Penanggungan", "Pujer Baru", "Seletreng", "Suka Makmur", "Sumber Anyar", "Sumber Pakem", "Suger Lor", "Tanah Wulan"],
                "Tapen": ["Cindogo", "Gunung Anyar", "Jurang Sapi", "Kalitapen", "Mangli Wetan", "Mrawan", "Taal", "Tapen", "Wonokusumo"]
            },
            "Kabupaten Gresik": {
                "Gresik": ["Bedilan", "Karangpoh", "Kebungson", "Kemuteran", "Kroman", "Lumpur", "Ngipik", "Pekauman", "Pekelingan", "Pulopancikan", "Sidokumpul", "Sukodono", "Sukorame", "Tlogopojok", "Tlogopatut"],
                "Kebomas": ["Dahanrejo", "Giri", "Gulomantung", "Kedanyang", "Kebomas", "Kembangan", "Klangonan", "Randuagung", "Segoromadu", "Sekarkurung", "Sidomukti", "Sukorejo", "Tengket"],
                "Manyar": ["Banjarsari", "Banyuwangi", "Betoyoguci", "Betoyokauman", "Karangrejo", "Leran", "Manyar Sidomukti", "Manyar Sidorukun", "Manyarejo", "Morobakung", "Ngampel", "Peganden", "Pejangganan", "Roomo", "Sembayat", "Suci", "Sukomulyo", "Tanggulrejo", "Tebalo", "Yosowilangun"],
                "Driyorejo": ["Bambe", "Banjaran", "Cangkir", "Driyorejo", "Gadung", "Karanglo", "Kesamben Wetan", "Krikilan", "Mojosarirejo", "Mulung", "Petiken", "Randegansari", "Sumput", "Tanjungan", "Tenaru", "Wedoroanom"],
                "Menganti": ["Beton", "Boboh", "Boteng", "Bringkang", "Domas", "Drancang", "Gadingwatu", "Gempolkurung", "Hendrosari", "Hulaan", "Kepatihan", "Laban", "Menganti", "Pelemwatu", "Pengalangan", "Pranti", "Randupadangan", "Setro", "Sidojangkung"],
                "Cerme": ["Banjarsari", "Betiting", "Cerme Kidul", "Cerme Lor", "Dadapkuning", "Dampaan", "Dooro", "Dungus", "Gedangkulut", "Guranganyar", "Iker-iker Geger", "Kambingan", "Kandangan", "Lengkong", "Morowudi", "Ngabetan", "Ngembung", "Padeg", "Pandu", "Semampir", "Sukoanyar"]
            },
            "Kabupaten Jember": {
                "Kaliwates": ["Jember Kidul", "Kaliwates", "Kebon Agung", "Kepatihan", "Mangli", "Sempusari", "Tegal Besar"],
                "Sumbersari": ["Antirogo", "Karangrejo", "Kebonsari", "Kranjingan", "Sumbersari", "Tegalgede", "Wirolegi"],
                "Patrang": ["Banjarsari", "Baratan", "Bintoro", "Gebang", "Jemberlor", "Jumerto", "Patrang", "Slawu"],
                "Tanggul": ["Darungan", "Klatakan", "Kramat Sukoharjo", "Manggisan", "Patemon", "Tanggul Kulon", "Tanggul Wetan"],
                "Ambulu": ["Ambulu", "Andongsari", "Karang Anyar", "Pontang", "Sabrang", "Sumberejo", "Tegalsari"],
                "Kencong": ["Cakru", "Kencong", "Kraton", "Paseban", "Wonorejo"],
                "Arjasa": ["Arjasa", "Bintoro", "Candijati", "Darsono", "Kamal", "Kemuning Lor", "Sukojember"]
            },
            "Kabupaten Jombang": {
                "Jombang": ["Candimulyo", "Dapurkejambon", "Denanyar", "Jombang", "Jombatan", "Kaliwungu", "Kepanjen", "Plandi", "Plosogeneng", "Pulolor", "Sambongdukuh", "Sengon", "Tambakrejo", "Tunggorono"],
                "Peterongan": ["Bongkot", "Dukuhklopo", "Kebontemu", "Kepuhkembeng", "Morosunggingan", "Ngrandulor", "Peterongan", "Senden", "Sumberagung", "Tanjunganom", "Tengaran", "Tugusumberjo"],
                "Diwek": ["Balongbesuk", "Bandung", "Bendet", "Brambang", "Bulurejo", "Ceweng", "Cukir", "Diwek", "Grogol", "Janti", "Jatirejo", "Kayangan", "Kedawong", "Keras", "Kwaron", "Ngudirejo", "Pandanwangi", "Pundong", "Puton", "Watugaluh"],
                "Ploso": ["Bawangan", "Daditunggal", "Gedongombo", "Jatibanjar", "Jatigedong", "Kebonagung", "Kedungdowo", "Losari", "Pagertanjung", "Pandanblole", "Ploso", "Rejoagung", "Tanggungkramat"],
                "Mojoagung": ["Betek", "Dukuhdimoro", "Dukuhmojo", "Gambiran", "Janti", "Johowinong", "Kademangan", "Karobelah", "Kauman", "Kedunglumpang", "Miagan", "Mojotrisno", "Murukan", "Seketi", "Tanggalrejo", "Tejo", "Wringinpitu"],
                "Bareng": ["Bareng", "Mundusewu", "Ngrimbi", "Olak-Alen", "Pulosari", "Tebel", "Karangan", "Jenisgelaran", "Ngampungan"]
            },
            "Kabupaten Kediri": {
                "Pare": ["Bendo", "Darungan", "Gedangsewu", "Pelem", "Sambirejo", "Sidorejo", "Sumberbendo", "Tertek", "Tulungrejo"],
                "Ngasem": ["Doko", "Gogorante", "Karangrejo", "Kwadungan", "Ngasem", "Nambaan", "Paron", "Sukorejo", "Toyoresmi", "Tugurejo", "Wonocatur"],
                "Gurah": ["Adan-adan", "Bangsongan", "Besuk", "Banyuanyar", "Gempolan", "Gurah", "Kerkep", "Kranggan", "Nglumbang", "Ngreco", "Sukorejo", "Tambakrejo", "Tiru Kidul", "Tiru Lor", "Turus", "Wonojoyo"],
                "Wates": ["Canayan", "Gadungan", "Janti", "Joho", "Karanganyar", "Pagu", "Plaosan", "Pojok", "Segaran", "Silir", "Sumberagung", "Tawang", "Tempurejo", "Wates", "Wonorejo"],
                "Kandangan": ["Banaran", "Bukur", "Jerukwangi", "Jlumbang", "Kandangan", "Karangtengah", "Kasreman", "Kemiri", "Klampisan", "Medowo", "Mriyunan"],
                "Mojo": ["Batokan", "Blimbing", "Jugo", "Kedawung", "Keniten", "Kranding", "Kraton", "Maesan", "Mlati", "Mojo", "Mondo", "Ngadi", "Ngetrep", "Pamongan", "Petok", "Ploso", "Ponggok", "Sukoanyar", "Surat", "Tambibendo"]
            },
            "Kabupaten Lamongan": {
                "Lamongan": ["Banjarmendalan", "Jetis", "Sidoharjo", "Sidokumpul", "Sukomulyo", "Sukorejo", "Tlogoanyar", "Kebet", "Kramat", "Made", "Plosowahyu", "Rancangkencono", "Sendangrejo", "Sidorejo", "Sumberjo", "Tanjung", "Wajik"],
                "Babat": ["Babat", "Banaran", "Bedahan", "Datinawong", "Gendong Kulon", "Karang Kembang", "Kebalandono", "Kebalanpelang", "Keyongan", "Kuripan", "Moropelang", "Pabuaran", "Plaosan", "Pucakwangi", "Sambangan", "Sogo", "Sumuragung", "Trepan", "Tritunggal"],
                "Tikung": ["Bakalanpule", "Balongwangi", "Banter", "Botoputih", "Dukuhagung", "Guminingrejo", "Jatirejo", "Kelorarum", "Pengumbulanadi", "Soko", "Takerankelenting", "Wonokromo"],
                "Paciran": ["Banjarwati", "Drajat", "Kandangsemangkon", "Kemantren", "Kranji", "Paciran", "Paloh", "Sendangagung", "Sendangduwur", "Sidokumpul", "Sumurgayam", "Tunggul", "Warulor", "Weru"],
                "Sekaran": ["Besur", "Bugel", "Keting", "Kudikan", "Latek", "Manyar", "Miru", "Moro", "Ngarum", "Porodeso", "Sekaran", "Simo", "Sungegembang", "Titik", "Trosono"],
                "Sukodadi": ["Balung", "Bandungsari", "Banjarejo", "Gedangan", "Kadungrembug", "Kebonsari", "Madulegi", "Menongo", "Pajangan", "Plumpang", "Siwalanrejo", "Sukodadi", "Sukolilo", "Sumberagung", "Surabayan"]
            },
            "Kabupaten Lumajang": {
                "Lumajang": ["Blukon", "Citrodiwangsan", "Denok", "Ditotrunan", "Jogotrunan", "Jogoyudan", "Kepuharjo", "Rogotrunan", "Tompokerso"],
                "Pasirian": ["Bades", "Bago", "Gondoruso", "Kalibendo", "Madiredo", "Pasirian", "Selok Anyar", "Selok Awar-Awar", "Sememu"],
                "Tempeh": ["Besuk", "Jatisari", "Jokarto", "Kaliwungu", "Lempeni", "Pandanarum", "Pandanwangi", "Pulo", "Sumberjati", "Tempeh Kidul", "Tempeh Lor", "Tempeh Tengah"],
                "Senduro": ["Argosari", "Burno", "Kandangtepus", "Kandangan", "Pandansari", "Purworejo", "Ranupani", "Senduro", "Wonocepoko Ayu", "Wonocoyo"],
                "Yosowilangun": ["Darungan", "Karanganyar", "Karangrejo", "Krai", "Kraton", "Munder", "Tunjung", "Wotgalih", "Yosowilangun Kidul", "Yosowilangun Lor"],
                "Klakah": ["Duren", "Kebonan", "Klakah", "Kudus", "Mlawang", "Ranupakis", "Sawaran Lor", "Sruni", "Tegalciut"]
            },
            "Kabupaten Madiun": {
                "Mejayan": ["Bangunsari", "Blabakan", "Darmorejo", "Kaliabu", "Klecorejo", "Krajan", "Kuncen", "Mejayan", "Ngampel", "Wonorejo"],
                "Madiun": ["Bagi", "Banjarsari", "Betek", "Dempelan", "Dimong", "Gunungsari", "Nglames", "Sendangrejo", "Sirapan", "Sumberejo", "Tanjungrejo", "Tiron"],
                "Balerejo": ["Babadan", "Balerejo", "Banaran", "Garon", "Glonggong", "Kedungjati", "Kedungrejo", "Kuwu", "Pacinan", "Simo", "Sogo", "Sumberbening"],
                "Wonoasri": ["Banyukambang", "Buduran", "Jatirejo", "Klitik", "Ngadirejo", "Plumpungrejo", "Purwosari", "Sidomulyo"],
                "Pilangkenceng": ["Duren", "Kedungbanteng", "Kenongorejo", "Luworo", "Muneng", "Ngale", "Pilangkenceng", "Pulerejo", "Sumbergandu", "Wonoayu"],
                "Jiwan": ["Bedoho", "Bibrik", "Bukur", "Grobogan", "Jiwan", "Kincang", "Kwangsen", "Ngetrep", "Sambirejo", "Sukolilo", "Teguhan", "Wayut"],
                "Geger": ["Banaran", "Geger", "Jatisari", "Kaibon", "Kertosari", "Kertobanyon", "Pagotan", "Purworejo", "Sambirejo", "Sangen", "Slambur", "Sumberejo", "Uteran"],
                "Dolopo": ["Bader", "Blimbing", "Candimulyo", "Doho", "Dolopo", "Glonggong", "Ketawang", "Kradinan", "Lembah", "Suluk"],
                "Saradan": ["Bajulan", "Bandungan", "Bener", "Bongsopotro", "Klangon", "Pajaran", "Sambirejo", "Sidorejo", "Sugihwaras", "Sumberbendo", "Tulung"],
                "Dagangan": ["Banjarsari Kulon", "Banjarsari Wetan", "Dagangan", "Joho", "Kepet", "Ketandan", "Mendak", "Mruwak", "Ngranget", "Padas", "Prambon", "Segulung", "Tileng"],
                "Kebonsari": ["Balerejo", "Kebonsari", "Mojorejo", "Palur", "Pucanganom", "Rejosari", "Sidorejo", "Singgahan", "Sukorejo", "Tambakmas", "Tanjungrejo"]
            },
            "Kabupaten Magetan": {
                "Magetan": ["Bulukerto", "Candirejo", "Kebonagung", "Magetan", "Mangkujayan", "Purwosari", "Ringinagung", "Selosari", "Sukowinangun", "Tambran", "Tawanganom"],
                "Plaosan": ["Bogoarum", "Bulugunung", "Buluharjo", "Dadi", "Durenan", "Ngancar", "Pacalan", "Plaosan", "Plumpung", "Puntukdoro", "Sarangan", "Sendangagung", "Sidomukti", "Sumberagung"],
                "Maospati": ["Gulun", "Klagen Gambiran", "Kraton", "Malang", "Maospati", "Ngujung", "Pandeyan", "Pesu", "Ronowijayan", "Sugihwaras", "Sumberejo", "Suratmajan", "Tanjungsari"],
                "Kawedanan": ["Balerejo", "Bogem", "Garon", "Genengan", "Giripurno", "Karangrejo", "Kawedanan", "Mangunrejo", "Mojorejo", "Ngadirejo", "Ngentep", "Ngunut", "Pojok", "Rejosari", "Sampung", "Selorejo", "Tladan"],
                "Panekan": ["Banjarejo", "Bedagung", "Cepoko", "Iliek-iliek", "Jabung", "Manjung", "Milangasri", "Ngiliran", "Panekan", "Rejomulyo", "Sidowayah", "Sukowidi", "Sumberdodol", "Tanjungsari", "Tapak", "Terjan", "Wates"],
                "Bendo": ["Bendo", "Belotan", "Bulak", "Carikan", "Dukuh", "Duwet", "Kleco", "Kledokan", "Lemahbang", "Pingkuk", "Setren", "Soco", "Tanjung", "Tegalarum"]
            },
            "Kabupaten Malang": {
                "Kepanjen": ["Ardirejo", "Cepokomulyo", "Curungrejo", "Jatirejoyoso", "Kepanjen", "Mangunrejo", "Panggungrejo", "Sengguruh", "Sukoraharjo", "Tegalsari"],
                "Singosari": ["Banjararum", "Candirenggo", "Dengok", "Gunungrejo", "Klampok", "Losari", "Pagentan", "Purwoasri", "Tunjungtirto", "Watugede"],
                "Lawang": ["Bedali", "Kalirejo", "Ketindan", "Lawang", "Mulyoarjo", "Sidodadi", "Srigading", "Turirejo", "Wonorejo"],
                "Pujon": ["Bendosari", "Madiredo", "Ngabab", "Ngroto", "Pandansari", "Pujon Kidul", "Pujon Lor", "Sukomulyo", "Tawangsari", "Wiyurejo"],
                "Dau": ["Gadingkulon", "Kalirejo", "Karangwidoro", "Kucur", "Landungsari", "Petungsewu", "Selorejo", "Sumbersekar"],
                "Turen": ["Jeru", "Kedok", "Kemulan", "Pagedangan", "Sanankerto", "Sanankulon", "Sedayu", "Tawangrejeni", "Turen", "Undaan"],
                "Pakis": ["Ampeldento", "Asrikaton", "Banjarejo", "Bunutwetan", "Kedungrejo", "Mangliawan", "Pakisjajar", "Pakiskembar", "Pagentan", "Saptorenggo", "Sekarpuro", "Sumberkradenan", "Sumberpasir", "Tirtomoyo"]
            },
            "Kabupaten Mojokerto": {
                "Mojosari": ["Awang-awang", "Belahan Tengah", "Jotangan", "Kebondalem", "Kedunggempol", "Menanggal", "Modopuro", "Mojosari", "Randubango", "Sarirejo", "Sawahan", "Seduri", "Sumbertanggul"],
                "Trowulan": ["Balong Sambi", "Bejijong", "Beloh", "Domas", "Jatipasar", "Kejagan", "Pakis", "Panggih", "Sentonorejo", "Tawangsari", "Temon", "Trowulan", "Watesumpak", "Wonorejo"],
                "Ngoro": ["Bandarasri", "Candiharjo", "Jasem", "Kembangsri", "Kesemen", "Kunjorowesi", "Lolawang", "Manduro", "Ngoro", "Purwojati", "Sedati", "Srigading", "Tanjangrono", "Watesnegoro"],
                "Pacet": ["Bendunganjati", "Candiwatu", "Cembor", "Claket", "Dlanggu", "Kemasantani", "Kesimantengah", "Kuripansari", "Mojokembang", "Nogosari", "Pacet", "Padusan", "Petak", "Sajen", "Warugunung"],
                "Puri": ["Balongmojo", "Banjaragung", "Brayung", "Katemasdungus", "Kebonagung", "Kenanten", "Kintelan", "Medali", "Plososari", "Puri", "Sumbergirang", "Tambakagung", "Tangunan"],
                "Sooko": ["Blimbingsari", "Brangkal", "Gemekan", "Jampirogo", "Japan", "Karangkedawung", "Kedungmaling", "Klinterejo", "Modongan", "Sambiroto", "Sooko", "Tempuran", "Wringinrejo"]
            },
            "Kabupaten Nganjuk": {
                "Nganjuk": ["Begadung", "Bogo", "Ganungkidul", "Jatirejo", "Kauman", "Kartoharjo", "Kramat", "Mangundikaran", "Payaman", "Ploso", "Werungotok"],
                "Kertosono": ["Banaran", "Bangsri", "Drenges", "Kudu", "Kutorejo", "Lambangkuning", "Pandantoyo", "Pelem", "Tanjung", "Tembarak", "Yuwono"],
                "Tanjunganom": ["Kedungombo", "Kedungrejo", "Malangsari", "Ngadirejo", "Sambirejo", "Sidoharjo", "Sumberkepuh", "Tanjunganom", "Wates", "Warujayeng"],
                "Baron": ["Baron", "Garu", "Gebangkerep", "Jambi", "Jekek", "Katerban", "Kemaduh", "Kemlokolegi", "Mabung", "Sambiroto", "Waung"],
                "Loceret": ["Bajulan", "Candirejo", "Gejagan", "Genjeng", "Godean", "Jatirejo", "Karangsono", "Kenep", "Kwagean", "Loceret", "Macanan", "Mungkung", "Ngepeh", "Patihan", "Putukrejo", "Sekaran", "Sombron", "Sukorejo", "Tanjungrejo", "Tekenglagahan"],
                "Berbek": ["Balongrejo", "Bendungrejo", "Berbek", "Bulu", "Cepoko", "Grojogan", "Maguan", "Mlilir", "Ngrawan", "Patranrejo", "Semare", "Sendangbumi", "Sengkut", "Sonopatik", "Sumberurip", "Tiripan"]
            },
            "Kabupaten Ngawi": {
                "Ngawi": ["Banyuanyar", "Beran", "Grudo", "Jururejo", "Karang Asri", "Karangtengah", "Karangtengah Prandon", "Kartoharjo", "Karangasri", "Klitik", "Mangunharjo", "Margomulyo", "Ngawi", "Pelem", "Watualang"],
                "Geneng": ["Baderan", "Dempel", "Geneng", "Kasreman", "Keniten", "Keras Kidul", "Kerik", "Klampisan", "Kresikan", "Majasem", "Ngale", "Sidorejo", "Tepas"],
                "Paron": ["Babadan", "Gelung", "Gentong", "Jambangan", "Kebon", "Kedungputri", "Ngale", "Paron", "Semen", "Sirigan", "Tempuran", "Teguhan"],
                "Kedunggalar": ["Bangunrejo Kidul", "Begal", "Gemarang", "Jenggrik", "Katikan", "Kawu", "Kedunggalar", "Pelang Kidul", "Pelang Lor", "Wonorejo"],
                "Sine": ["Gendol", "Girikerto", "Jagir", "Kauman", "Ketanggung", "Kuniran", "Ngrendeng", "Pandansari", "Pocol", "Sine", "Sumbersari", "Tulakan", "Wonosobo"],
                "Jogorogo": ["Brubuh", "Dawung", "Girimulyo", "Jaten", "Jogorogo", "Kletekan", "Macanan", "Ngrayudan", "Soco", "Tanjungsari", "Umbulrejo"]
            },
            "Kabupaten Pacitan": {
                "Pacitan": ["Arjowinangun", "Asmorobangun", "Bangunsari", "Banjarsari", "Kayen", "Kembang", "Menadi", "Mentoro", "Nanggungan", "Pacitan", "Ploso", "Pucangsewu", "Purworejo", "Sambong", "Sedeng", "Semanten", "Sirnoboyo", "Sukoharjo", "Sumberharjo", "Tanjungsari", "Tambakrejo", "Widoro"],
                "Kebonagung": ["Banjar", "Gawang", "Gembuk", "Kalipelus", "Karanganyar", "Karangnongko", "Katipugal", "Kebonagung", "Klesem", "Mantren", "Plumbungan", "Punjung", "Purwoasri", "Sanggrahan", "Sidomulyo", "Sukoharjo", "Wora Wari"],
                "Punung": ["Bomo", "Gondosari", "Kebonsari", "Kendal", "Mantren", "Mendolo Kidul", "Mendolo Lor", "Piton", "Ploso", "Punung", "Sooka", "Tinatar"],
                "Ngadirojo": ["Bodag", "Bogoharjo", "Cangkring", "Hadiluwih", "Hadiwarno", "Ngadirojo", "Nogosari", "Pagerejo", "Tanjung Lor", "Tanjungpuro", "Wiyoro", "Wonodadi", "Wonokarto", "Wonosobo"],
                "Nawangan": ["Gondang", "Jetis Lor", "Mujing", "Nawangan", "Ngromo", "Pakis Baru", "Penggung", "Sempu", "Tokawi"],
                "Tegalombo": ["Gedangan", "Kasihan", "Kebondalem", "Kemuning", "Ngreco", "Ploso", "Pucangombo", "Tahunan", "Tegalombo"]
            },
            "Kabupaten Pamekasan": {
                "Pamekasan": ["Barurambat Kota", "Bugih", "Gladak Anyar", "Jungcangcang", "Kolpajung", "Kowel", "Panempan", "Parteker", "Patemon"],
                "Pademawu": ["Barurambat Timur", "Baddurih", "Buddagan", "Bunder", "Durbuk", "Jarin", "Lemper", "Murtajih", "Pademawu Barat", "Pademawu Timur", "Pagagan", "Prekbun", "Sopa'ah", "Sumedangan", "Tambung", "Tanjung"],
                "Tlanakan": ["Ambat", "Bandaran", "Branta Pesisir", "Branta Tinggi", "Bukek", "Dabuan", "Kramat", "Larangan Slampar", "Mangar", "Panglegur", "Taro'an", "Terrak", "Tlanakan", "Tlesah"],
                "Proppo": ["Badung", "Banyubulu", "Batokalangan", "Billa'an", "Campor", "Candi Burung", "Gro'om", "Jambringin", "Karanganyar", "Klampar", "Kodik", "Mapper", "Panagguan", "Pangorayan", "Pangbatok", "Proppo", "Rangperang Daja", "Rangperang Laok", "Samatan", "Samiran", "Srambah", "Tlangoh", "Toket"],
                "Larangan": ["Blumbungan", "Duko Timur", "Grujugan", "Kaduara Barat", "Lancar", "Larangan Dalam", "Larangan Luar", "Montok", "Panaguan", "Peltong", "Taraban", "Tentenan Barat", "Tentenan Timur"],
                "Galis": ["Artodung", "Bulay", "Galis", "Konang", "Lembung", "Pagendingan", "Pandan", "Polagan", "Tobungan"]
            },
            "Kabupaten Pasuruan": {
                "Purwosari": ["Bakalan", "Cendono", "Karangrejo", "Kayoman", "Kertosari", "Martopuro", "Pucangsari", "Purwosari", "Sekarmojo", "Sengonagung", "Sumberanyar", "Sumbersuko", "Tejowangi", "Wonorejo"],
                "Pandaan": ["Banjarsari", "Durensewu", "Jogosari", "Kebonwaru", "Kemirisewu", "Kutorejo", "Nogosari", "Pandaan", "Petungasri", "Plintahan", "Sebani", "Sumber Gedang", "Sumberrejo", "Tawangrejo", "Tunggulwulung", "Wedoro"],
                "Prigen": ["Bulukandang", "Candi Wates", "Dayurejo", "Gambiran", "Jatiarjo", "Ledug", "Lumbangrejo", "Prigen", "Sekarjoho", "Sukolilo", "Sukoreno", "Watuagung"],
                "Grati": ["Cukurgondang", "Gratitunon", "Kalipang", "Kambingan Rejo", "Keboncandi", "Kedawung Kulon", "Kedawung Wetan", "Plososari", "Ranuklindungan", "Rebalas", "Rowogembong", "Sumberagung", "Sumberdawesari", "Trewung", "Wotgalih"],
                "Bangil": ["Bendo Mungal", "Dermo", "Gempeng", "Kalirejo", "Kauman", "Kersikan", "Kiduldalem", "Kolursari", "Latek", "Manaruwi", "Masangan", "Pogar", "Raci", "Sidowayah", "Tambakan"],
                "Gempol": ["Bulusari", "Carat", "Gempol", "Jerukpurut", "Karangrejo", "Kejapanan", "Kepulungan", "Legok", "Ngerong", "Randupitu", "Sumbersuko", "Watukosek", "Winong"]
            },
            "Kabupaten Ponorogo": {
                "Ponorogo": ["Bangunsari", "Banyudono", "Beduri", "Babadan", "Cokromenggalan", "Jingglong", "Kauman", "Keniten", "Kepatihan", "Mangkujayan", "Nologaten", "Paju", "Pakunden", "Purbosuman", "Surodikraman", "Tamanarum", "Tambakbayan", "Tonatan"],
                "Babadan": ["Babadan", "Bareng", "Cekok", "Gupolo", "Japan", "Kertosari", "Lembah", "Ngunut", "Polorejo", "Pondok", "Purwosari", "Sukosari", "Trisono"],
                "Siman": ["Beton", "Brahu", "Demangan", "Jarak", "Madusari", "Manuk", "Ngabar", "Patihan Kidul", "Pijeran", "Ronosentanan", "Sawuh", "Sekaran", "Siman", "Tajug"],
                "Kauman": ["Bringin", "Carat", "Ciluk", "Gabel", "Kauman", "Maron", "Nglarangan", "Ngrandu", "Nongkodono", "Pengkol", "Plosojenar", "Semanding", "Somoroto", "Sukosari", "Tegalombo"],
                "Jenangan": ["Jenangan", "Kemiri", "Mrican", "Nayang", "Ngrupit", "Panjeng", "Paringan", "Pintu", "Plalangan", "Sedah", "Semanding", "Shanti", "Tanjungsari", "Wates"],
                "Pulung": ["Banaran", "Bedrug", "Bekiring", "Karangpatihan", "Kesugihan", "Munggung", "Patik", "Plunturan", "Pomahan", "Pulung", "Pulung Merdiko", "Serag", "Sidoharjo", "Singgahan", "Turlap", "Wagir Kidul", "Wayang", "Wotan"]
            },
            "Kabupaten Probolinggo": {
                "Kraksaan": ["Asembagus", "Bulu", "Kalibuntu", "Kandangjati Kulon", "Kandangjati Wetan", "Kebonagung", "Kraksaan Wetan", "Kregenan", "Patokan", "Rondoningo", "Semampir", "Sidopekso", "Sumberlele", "Tamansari"],
                "Paiton": ["Bhinor", "Jabung Candi", "Jabung Sisir", "Karanganyar", "Paiton", "Petunjungan", "Plampang", "Pandean", "Pondokkelor", "Randumerak", "Sidodadi", "Sukodadi", "Sumberanyar", "Sumberrejo", "Taman"],
                "Dringu": ["Dringu", "Kalirejo", "Kalisalam", "Kedungdalem", "Mranggon Lawang", "Pabean", "Randuputih", "Sekarkare", "Sumberagung", "Tamansari", "Tegalrejo", "Watuwungkuk"],
                "Gending": ["Banyuanyar Lor", "Brumbungan Lor", "Curahsawo", "Gending", "Jatiadi", "Klaseman", "Pajurangan", "Pikatan", "Randupitu", "Sebaung"],
                "Sukapura": ["Jetak", "Ngadas", "Ngadirejo", "Ngadisari", "Pakel", "Sapikerep", "Sariwani", "Sukapura", "Wonokerto", "Wonotoro"],
                "Tongas": ["Bayeman", "Curah Dringu", "Curah Tulis", "Dungun", "Klampok", "Pamatan", "Sumberkramat", "Sumendi", "Tambakrejo", "Tanjungrejo", "Tongas Kulon", "Tongas Wetan", "Wringinanom"]
            },
            "Kabupaten Sampang": {
                "Sampang": ["Aeng Sareh", "Banyumas", "Baruh", "Baturasang", "Gunung Maddah", "Kamoning", "Karang Dalem", "Pangelen", "Panggung", "Pasean", "Pekalongan", "Polagan", "Rongtengah", "Tanggumong"],
                "Camplong": ["Anggersek", "Banjartabulu", "Banjar Talela", "Batukarang", "Dharma Camplong", "Dharma Tanjung", "Madupat", "Pamolaan", "Plampa'an", "Prajjan", "Rabasan", "Sejati", "Taddan", "Tambaan"],
                "Torjun": ["Bringin", "Dulang", "Jeruk Porot", "Kanjar", "Kara", "Krampon", "Pangongsean", "Patapan", "Petapan", "Tanah Merah", "Torjun"],
                "Kedungdung": ["Bajrasangkal", "Banjar", "Banyukapah", "Batoporo Barat", "Batoporo Timur", "Daleman", "Gunungelek", "Kedungdung", "Komis", "Kramat", "Moktesareh", "Nyeloh", "Ombul", "Pajeruan", "Palenggiyan", "Pasarenan", "Rabasan", "Rohayu"],
                "Ketapang": ["Bira Barat", "Bunten Barat", "Bunten Timur", "Ketapang Barat", "Ketapang Daya", "Ketapang Laok", "Ketapang Timur", "Pancor", "Paopale Daya", "Paopale Laok", "Rabiyan", "Karang Anyar"],
                "Banyuates": ["Asem Jajar", "Banyuates", "Batioh", "Jatra Timur", "Kembang Jeruk", "Lar-Lar", "Masaran", "Montor", "Morbatoh", "Nagasari", "Nepa", "Olor", "Planggaran Barat", "Planggaran Timur", "Tapaan", "Terbun", "Tlagah"]
            },
            "Kabupaten Sidoarjo": {
                "Sidoarjo": ["Banjarbendo", "Bluru Kidul", "Cemengbakalan", "Cemengkalang", "Gebang", "Jati", "Kemiri", "Lebo", "Lemahputro", "Magersari", "Pekauman", "Pucang", "Pucanganom", "Rangkah Kidul", "Sarirogo", "Sekardangan", "Sidokare", "Sidoklumpuk", "Sidokumpul", "Urangagung"],
                "Waru": ["Berbek", "Bungurasih", "Janti", "Kedungrejo", "Kepuhkiriman", "Kureksari", "Medaeng", "Ngingas", "Pepelegi", "Tambak Oso", "Tambak Sawah", "Tambak Sumur", "Tropodo", "Wadungasri", "Waru", "Wedoro"],
                "Gedangan": ["Ganting", "Gedangan", "Gemurung", "Karangbong", "Keboansikep", "Keboananom", "Ketajen", "Kragan", "Punggul", "Sawohan", "Semambung", "Seruni", "Tebel", "Wedi"],
                "Taman": ["Bebekan", "Geluran", "Kalijaten", "Ketegan", "Kletek", "Kramat Jegu", "Krembangan", "Ngelom", "Sepanjang", "Sidodadi", "Tawangsari", "Trosobo", "Wage", "Wonocolo"],
                "Candi": ["Balongdowo", "Balonggabus", "Candi", "Durungbanjar", "Durungbedug", "Gelam", "Kalipecabean", "Karangtanjung", "Kebonsari", "Kedungkendo", "Kedungpeluk", "Kendalpecabean", "Klurak", "Larangan", "Sepande", "Sidodadi", "Sugihwaras", "Sumokali", "Tenggulunan", "Urangagung", "Wedoroklurak"],
                "Krian": ["Barat", "Gamping", "Jatikalang", "Jerukgamping", "Junwangi", "Katerungan", "Keboharan", "Kraton", "Krian", "Ponokawan", "Sedengan Mijen", "Sidomojo", "Sidomulyo", "Tambak Kemerakan", "Tempel", "Terik", "Terung Kulon", "Terung Wetan", "Tropodo", "Watugolong"]
            },
            "Kabupaten Situbondo": {
                "Situbondo": ["Dawuhan", "Kalibagor", "Kotakan", "Olean", "Panji Anom", "Patokan", "Talkandang"],
                "Panji": ["Arjasa", "Battal", "Curah Jeru", "Juglangan", "Kayu Putih", "Klampokan", "Mimbaan", "Panji Kidul", "Panji Lor", "Sliwung", "Tokelan"],
                "Besuki": ["Besuki", "Blimbing", "Kalimas", "Langkap", "Pesisir", "Sumberejo", "Widoropayung"],
                "Asembagus": ["Asembagus", "Awar-Awar", "Bantal", "Gudang", "Kertosari", "Mojosari", "Parante", "Trigonco", "Wringin Anom"],
                "Kapongan": ["Curah Cottok", "Gebangan", "Kandang", "Kapongan", "Kesambirampak", "Landangan", "Peleyan", "Pokaan", "Seletreng", "Wonokoyo"],
                "Banyuputih": ["Banyuputih", "Sumberanyar", "Sumberejo", "Sumberwaru", "Wonorejo"]
            },
            "Kabupaten Sumenep": {
                "Kota Sumenep": ["Bangkal", "Batuan", "Beliuk", "Kacongan", "Karanganyar", "Kebonagung", "Kebunan", "Kolor", "Marengan Daya", "Paberasan", "Pajagalan", "Panagan", "Pandian", "Pangarangan", "Parsanga", "Pabian"],
                "Kalianget": ["Kalimook", "Kalianget Barat", "Kalianget Timur", "Karanganyar", "Kertasada", "Marengan Laok", "Pinggirpapas"],
                "Saronggi": ["Aengtongtong", "Juluk", "Kambingan Barat", "Moangan", "Nambakor", "Pagarbatu", "Saronggi", "Talang", "Tanamerah", "Tanjung"],
                "Lenteng": ["Banasare", "Cangkreng", "Ellak Daya", "Ellak Laok", "Kambingan", "Lembung Timur", "Lenteng Barat", "Lenteng Timur", "Meddelan", "Moncek Barat", "Moncek Tengah", "Moncek Timur", "Sendir", "Taraban"],
                "Gapura": ["Andulang", "Balo", "Banjar Barat", "Banjar Timur", "Batudinding", "Beraji", "Gapura Barat", "Gapura Tengah", "Gapura Timur", "Gersik Putih", "Karangbudi", "Longos", "Mandala", "Paloloan", "Panagan", "Poja"],
                "Ambunten": ["Ambunten Barat", "Ambunten Tengah", "Ambunten Timur", "Belluk Ares", "Belluk Kenek", "Belluk Raja", "Bukabu", "Campor Barat", "Campor Timur", "Keles", "Sogian", "Tambaagung Ares", "Tambaagung Barat", "Tambaagung Tengah", "Tambaagung Timur"]
            },
            "Kabupaten Trenggalek": {
                "Trenggalek": ["Dobangsan", "Kelutan", "Ngantru", "Parakan", "Rejowinangun", "Sambirejo", "Sukosari", "Sumberdadi", "Sumbergedong", "Surodakan", "Tamanan"],
                "Karangan": ["Buluagung", "Jati", "Jatiprahu", "Karangan", "Kayen", "Kedungsigit", "Kerjo", "Ngentrong", "Salamrejo", "Sukowetan", "Sumber"],
                "Durenan": ["Baruharjo", "Durenan", "Gador", "Karanganyar", "Malasan", "Ngadisuko", "Pandean", "Panggungsari", "Semarum", "Sumberejo"],
                "Watulimo": ["Dukuh", "Gemaharjo", "Karanggandu", "Karangtengah", "Margomulyo", "Ngembel", "Pakel", "Prigi", "Sawahan", "Slawe", "Tasikmadu", "Watuagung"],
                "Gandusari": ["Gandusari", "Jajar", "Karanganyar", "Krandegan", "Melis", "Ngrayung", "Sukorame", "Sukorejo", "Widoro", "Wonoanti"],
                "Panggul": ["Banjar", "Besuki", "Bodag", "Depok", "Gayam", "Karangtengah", "Kertosono", "Manggis", "Nglebeng", "Nglayur", "Panggul", "Sawahan", "Tangkil", "Terbis", "Wonocoyo"]
            },
            "Kabupaten Tuban": {
                "Tuban": ["Baturetno", "Doromukti", "Kebonsari", "Karangsari", "Kingking", "Kutorejo", "Latsari", "Mondokan", "Perbon", "Ronggomulyo", "Sendangharjo", "Sidomulyo", "Sidorejo", "Sukolilo", "Sugiharjo", "Sumurgung"],
                "Semanding": ["Bektiharjo", "Genaharjo", "Gedongombo", "Gesing", "Jadi", "Karang", "Kowang", "Ngino", "Penambangan", "Prunggahan Kulon", "Prunggahan Wetan", "Sambongrejo", "Semanding", "Tegalagung", "Tunah"],
                "Merakurak": ["Bogorejo", "Borehbangle", "Kapu", "Mandirejo", "Sambonggede", "Sembungrejo", "Sendanghaji", "Senori", "Sugihan", "Sumberejo", "Tahulu", "Tegalrejo", "Temandang", "Tuwiri Kulon", "Tuwiri Wetan"],
                "Palang": ["Cendoro", "Cepokorejo", "Dawung", "Gesikharjo", "Glodogan", "Karangagung", "Ketambul", "Kradenan", "Leran Kulon", "Leran Wetan", "Ngimbang", "Padek", "Palang", "Panyuran", "Tasikmadu", "Tegalbang", "Wangun"],
                "Jenu": ["Beji", "Jenu", "Jenggolo", "Kaliuntu", "Mentoso", "Rawasan", "Remen", "Sekardadi", "Semenpinggir", "Socorejo", "Sugihwaras", "Suwalan", "Tasikharjo", "Temaji", "Wadung"],
                "Rengel": ["Banjaragung", "Banjararum", "Bulurejo", "Campurejo", "Kanorejo", "Karangtinoto", "Kebonagung", "Maibit", "Ngadirejo", "Pekuwon", "Prambontergayang", "Rengel", "Sawahan", "Sumberejo"]
            },
            "Kabupaten Tulungagung": {
                "Tulungagung": ["Bago", "Botoran", "Jepun", "Kampungdalem", "Karangwaru", "Kauman", "Kedungsoko", "Kenayan", "Kepatihan", "Kutoanyar", "Panggungrejo", "Sembung", "Tamanan", "Tertek"],
                "Kedungwaru": ["Boro", "Bulusari", "Gendingan", "Kedungwaru", "Ketanon", "Loderesan", "Majan", "Mangunsari", "Ngujang", "Plandaan", "Plosokandang", "Rejoagung", "Ringinpitu", "Simo", "Tapan", "Tawangsari", "Tunggulsari", "Winong"],
                "Boyolangu": ["Beji", "Bono", "Boyolangu", "Gedangsewu", "Karangrejo", "Kendalbulur", "Kresikan", "Moyoketen", "Ngranti", "Pucungkidul", "Sanggrahan", "Serut", "Sobontoro", "Tanjungsari", "Wajakkidul", "Wajaklor"],
                "Ngunut": ["Balesono", "Gilang", "Kacangan", "Kalangan", "Kaliwungu", "Karangsono", "Kromasan", "Ngunut", "Pandansari", "Pulosari", "Pulotondo", "Purworejo", "Selorejo", "Sumberejo Kulon", "Sumberejo Wetan"],
                "Kauman": ["Balerejo", "Banaran", "Batangsaren", "Bolorejo", "Jatimulyo", "Kalangbret", "Karanganom", "Kauman", "Kates", "Mojosari", "Pucangan", "Sidorejo", "Sukowiyono"],
                "Campurdarat": ["Campurdarat", "Gamping", "Gedangan", "Ngentrong", "Pelem", "Pojok", "Sawo", "Tanggung", "Wates"]
            },
            "Kota Batu": {
                "Batu": ["Oro-Oro Ombo", "Pesanggrahan", "Sidomulyo", "Sumberejo", "Ngaglik", "Sisir", "Songgokerto", "Temas"],
                "Bumiaji": ["Bumiaji", "Giripurno", "Gunungsari", "Pandanrejo", "Punten", "Sumber Brantas", "Sumbergondo", "Tulungrejo"],
                "Junrejo": ["Beji", "Junrejo", "Mojorejo", "Pendem", "Tlekung", "Torongrejo", "Dadaprejo"]
            },
            "Kota Blitar": {
                "Kepanjenkidul": ["Bando", "Kauman", "Kepanjenkidul", "Kepanjenlor", "Ngadirejo", "Sentul", "Tanggung"],
                "Sananwetan": ["Bendogerit", "Gedog", "Karangtengah", "Klampok", "Plosokerep", "Rembang", "Sananwetan"],
                "Sukorejo": ["Blitar", "Karangsari", "Sukorejo", "Pakunden", "Tanjungsari", "Turi", "Tlumpu"]
            },
            "Kota Kediri": {
                "Kota": ["Balowerti", "Banjaran", "Dandangan", "Jagalan", "Kampungdalem", "Kemasan", "Manisrenggo", "Ngadirejo", "Pakelan", "Pocanan", "Rejomulyo", "Ringinanom", "Semampir", "Setonogedong", "Setonopande"],
                "Mojoroto": ["Bandar Kidul", "Bandar Lor", "Banjarmlati", "Bujel", "Campurejo", "Dermo", "Gayam", "Lirboyo", "Mojoroto", "Mrican", "Ngampel", "Pojok", "Sukorame", "Tamanan"],
                "Pesantren": ["Bawang", "Betet", "Bence", "Blabak", "Burengan", "Jamsaren", "Ketami", "Ngletih", "Pakunden", "Pesantren", "Singonegaran", "Tempurejo", "Tosaren"]
            },
            "Kota Madiun": {
                "Kartoharjo": ["Kanigoro", "Kartoharjo", "Kelun", "Klegen", "Oro-Oro Ombo", "Pilangkenceng", "Rejomulyo", "Sukosari", "Tawangrejo"],
                "Manguharjo": ["Madiun Lor", "Manguharjo", "Nambangan Kidul", "Nambangan Lor", "Ngegong", "Pangongangan", "Patihan", "Sogaten", "Winongo"],
                "Taman": ["Banjarejo", "Demangan", "Josenan", "Kejuron", "Kuncen", "Manisrejo", "Mojorejo", "Pandean", "Taman"]
            },
            "Kota Malang": {
                "Klojen": ["Bareng", "Gadingkasri", "Kasin", "Kauman", "Kiduldalem", "Klojen", "Oro-Oro Dowo", "Penanggungan", "Rampal Celaket", "Samaan", "Sukoharjo"],
                "Blimbing": ["Arjosari", "Balearjosari", "Blimbing", "Bunulrejo", "Jodipan", "Kesatrian", "Pandanwangi", "Polehan", "Polowijen", "Purwantoro", "Purwodadi"],
                "Lowokwaru": ["Dinoyo", "Jatimulyo", "Ketawanggede", "Lowokwaru", "Merjosari", "Mojolangu", "Sumbersari", "Tasikmadu", "Tlogomas", "Tunggulwulung", "Tulusrejo"],
                "Sukun": ["Bakalankrajan", "Bandungrejosari", "Ciptomulyo", "Gadang", "Karangbesuki", "Kebonsari", "Mulyorejo", "Pisangcandi", "Sukun", "Tanjungrejo"],
                "Kedungkandang": ["Arjowinangun", "Bumiayu", "Buring", "Cemorokandang", "Kedungkandang", "Kotalama", "Lesanpuro", "Madyopuro", "Mergosono", "Sawojajar", "Wonokoyo"]
            },
            "Kota Mojokerto": {
                "Magersari": ["Balongsari", "Gedongan", "Gunung Gedangan", "Kedundung", "Magersari", "Wates"],
                "Kranggan": ["Jagalan", "Kranggan", "Meri", "Miji", "Purwotengah", "Sentanan"],
                "Prajurit Kulon": ["Blooto", "Kauman", "Mentikan", "Prajurit Kulon", "Pulorejo", "Surodinawan"]
            },
            "Kota Pasuruan": {
                "Panggungrejo": ["Bangilan", "Bugul Lor", "Kandangsapi", "Karanganyar", "Kebonsari", "Mandaranrejo", "Mayangan", "Ngemplakrejo", "Panggungrejo", "Pekuncen", "Petamanan", "Tambaan", "Trajeng"],
                "Purworejo": ["Kebonagung", "Pohjentrek", "Purutrejo", "Purworejo", "Sekargadung", "Tembokrejo", "Wirogunan"],
                "Bugul Kidul": ["Kepel", "Krampyangan", "Bakalan", "Blandongan", "Tapaan"],
                "Gadingrejo": ["Bukir", "Gadingrejo", "Gentong", "Karangketug", "Krapyakrejo", "Petahunan", "Randusari", "Sebani", "Tambaksari"]
            },
            "Kota Probolinggo": {
                "Kanigaran": ["Curahgrinting", "Kanigaran", "Kebonsari Kulon", "Kebonsari Wetan", "Sukoharjo", "Tisnonegaran"],
                "Mayangan": ["Jati", "Mangunharjo", "Mayangan", "Sukabumi", "Wiroborang"],
                "Kademangan": ["Kademangan", "Ketapang", "Pilang", "Poh Sangkir", "Triwung Kidul", "Triwung Lor"],
                "Wonoasih": ["Jrebeng Kidul", "Kedung Asem", "Kedung Galeng", "Pakistaji", "Wonoasih"],
                "Kedopok": ["Jrebeng Kulon", "Jrebeng Lor", "Jrebeng Wetan", "Kareng Lor", "Kedopok"]
            },
            "Kota Surabaya": {
                "Wonokromo": ["Darmo", "Jagir", "Ngagel", "Ngagelrejo", "Sawunggaling", "Wonokromo"],
                "Gubeng": ["Airlangga", "Barata Jaya", "Gubeng", "Kertajaya", "Mojo", "Pucang Sewu"],
                "Sukolilo": ["Gebang Putih", "Keputih", "Klampis Ngasem", "Medokan Semampir", "Menur Pumpungan", "Nginden Jangkungan", "Semolowaru"],
                "Rungkut": ["Kalirungkut", "Kedung Baruk", "Medokan Ayu", "Penjaringan Sari", "Rungkut Kidul", "Wonorejo"],
                "Tegalsari": ["Dr. Soetomo", "Kedungdoro", "Keputran", "Tegalsari", "Wonorejo"],
                "Genteng": ["Embong Kaliasin", "Genteng", "Kapasari", "Ketabang", "Peneleh"],
                "Tambaksari": ["Gading", "Dukuh Setro", "Kapas Madya", "Pacar Kembang", "Pacar Keling", "Ploso", "Rangkah", "Tambaksari"],
                "Kenjeran": ["Bulakbanteng", "Tambakwedi", "Tanah Kali Kedinding", "Sidotopo Wetan"],
                "Sawahan": ["Banyu Urip", "Kupang Krajan", "Pakis", "Petemon", "Putat Jaya", "Sawahan"]
            }
        };

        function handleKabupatenChange(kabupaten, selectedKecamatan = null, selectedDesa = null) {
            const kecSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');
            if (!kecSelect || !desaSelect) return;

            kecSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan...</option>';
            desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa...</option>';

            if (!kabupaten) return;

            let kecamatans = [];
            if (regionData[kabupaten]) {
                kecamatans = Object.keys(regionData[kabupaten]);
            }

            kecamatans.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = kec;
                if (selectedKecamatan && selectedKecamatan === kec) {
                    opt.selected = true;
                }
                kecSelect.appendChild(opt);
            });

            if (selectedKecamatan) {
                handleKecamatanChange(selectedKecamatan, selectedDesa);
            }
        }

        function handleKecamatanChange(kecamatan, selectedDesa = null) {
            const kabSelect = document.getElementById('kabupaten');
            const desaSelect = document.getElementById('desa');
            if (!kabSelect || !desaSelect) return;

            const kabupaten = kabSelect.value;
            desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa...</option>';

            if (!kecamatan) return;

            let desas = [];
            if (regionData[kabupaten] && regionData[kabupaten][kecamatan]) {
                desas = regionData[kabupaten][kecamatan];
            }

            desas.forEach(desa => {
                const opt = document.createElement('option');
                opt.value = desa;
                opt.textContent = desa;
                if (selectedDesa && selectedDesa === desa) {
                    opt.selected = true;
                }
                desaSelect.appendChild(opt);
            });
        }

        // Multi-Step Wizard State & Configuration
        let currentRole = 'peternak';
        let currentStepIndex = 0;

        const wizardConfig = {
            peternak: [
                {
                    paneId: 'step-pane-1',
                    badge: 'Langkah 1 dari 4',
                    title: 'Identitas Diri & Kontak',
                    navTitle: 'Identitas',
                    navSub: 'Data diri & kontak'
                },
                {
                    paneId: 'step-pane-2',
                    badge: 'Langkah 2 dari 4',
                    title: 'Alamat & Wilayah Domisili',
                    navTitle: 'Domisili',
                    navSub: 'Wilayah Jatim'
                },
                {
                    paneId: 'step-pane-3',
                    badge: 'Langkah 3 dari 4',
                    title: 'Profil Usaha Peternakan',
                    navTitle: 'Peternakan',
                    navSub: 'Profil usaha'
                },
                {
                    paneId: 'step-pane-4',
                    badge: 'Langkah 4 dari 4',
                    title: 'Keamanan Akun & Berkas KTP',
                    navTitle: 'Keamanan',
                    navSub: 'Kata sandi & KTP'
                }
            ],
            umum: [
                {
                    paneId: 'step-pane-1',
                    badge: 'Langkah 1 dari 3',
                    title: 'Identitas Diri',
                    navTitle: 'Identitas',
                    navSub: 'Nama & email'
                },
                {
                    paneId: 'step-pane-2',
                    badge: 'Langkah 2 dari 3',
                    title: 'Alamat Domisili',
                    navTitle: 'Alamat',
                    navSub: 'Tempat tinggal'
                },
                {
                    paneId: 'step-pane-4',
                    badge: 'Langkah 3 dari 3',
                    title: 'Keamanan Akun',
                    navTitle: 'Keamanan',
                    navSub: 'Kata sandi akun'
                }
            ]
        };

        function validateStep(stepIndex) {
            const steps = wizardConfig[currentRole];
            if (!steps || !steps[stepIndex]) return true;

            const pane = document.getElementById(steps[stepIndex].paneId);
            if (!pane) return true;

            const inputs = pane.querySelectorAll('input:not([type="hidden"]), select, textarea');
            for (const input of inputs) {
                // Skip inputs hidden by role
                if (input.closest('.hidden') !== null) {
                    continue;
                }

                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }

                if (currentRole === 'peternak' && input.id === 'nik' && input.value) {
                    if (!/^\d{16}$/.test(input.value.trim())) {
                        input.setCustomValidity('NIK harus berupa 16 digit angka');
                        input.reportValidity();
                        return false;
                    } else {
                        input.setCustomValidity('');
                    }
                }

                if (input.id === 'password_confirmation') {
                    const pass = document.getElementById('password')?.value;
                    if (pass && input.value !== pass) {
                        input.setCustomValidity('Konfirmasi password tidak cocok dengan password');
                        input.reportValidity();
                        return false;
                    } else {
                        input.setCustomValidity('');
                    }
                }
            }
            return true;
        }

        function updateStepperUI() {
            const steps = wizardConfig[currentRole];
            const currentStep = steps[currentStepIndex];
            const totalSteps = steps.length;
            const progressPercent = Math.round(((currentStepIndex + 1) / totalSteps) * 100);

            const badge = document.getElementById('wizard-step-badge');
            const currentTitle = document.getElementById('wizard-current-title');
            const percentText = document.getElementById('wizard-percent-text');
            const progressBar = document.getElementById('wizard-progress-bar');

            if (badge) badge.textContent = currentStep.badge;
            if (currentTitle) currentTitle.textContent = currentStep.title;
            if (percentText) percentText.textContent = `${progressPercent}% Selesai`;
            if (progressBar) progressBar.style.width = `${progressPercent}%`;

            const navContainer = document.getElementById('wizard-steps-nav');
            if (navContainer) {
                if (currentRole === 'peternak') {
                    navContainer.className = 'grid grid-cols-4 gap-2 pt-2.5 border-t border-slate-200/70';
                } else {
                    navContainer.className = 'grid grid-cols-3 gap-2 pt-2.5 border-t border-slate-200/70';
                }
            }

            for (let i = 0; i < 4; i++) {
                const navBtn = document.getElementById('step-nav-' + i);
                const stepNum = document.getElementById('step-num-' + i);
                const navTitle = document.getElementById('step-nav-title-' + i);
                const navSub = document.getElementById('step-nav-sub-' + i);

                if (i < totalSteps) {
                    if (navBtn) navBtn.classList.remove('hidden');
                    const stepData = steps[i];
                    if (navTitle) navTitle.textContent = stepData.navTitle;
                    if (navSub) navSub.textContent = stepData.navSub;

                    if (i < currentStepIndex) {
                        // Completed step
                        if (stepNum) {
                            stepNum.className = 'w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-emerald-600 text-white shadow-2xs';
                            stepNum.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
                        }
                        if (navBtn) navBtn.className = 'step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-emerald-700 bg-emerald-50/50 hover:bg-emerald-50';
                    } else if (i === currentStepIndex) {
                        // Current active step
                        const activeColor = currentRole === 'umum' ? 'bg-emerald-600' : 'bg-blue-600';
                        const activeBg = currentRole === 'umum' ? 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200' : 'bg-blue-50 text-blue-800 ring-1 ring-blue-200';
                        if (stepNum) {
                            stepNum.className = `w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition ${activeColor} text-white shadow-2xs`;
                            stepNum.textContent = (i + 1);
                        }
                        if (navBtn) navBtn.className = `step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer ${activeBg}`;
                    } else {
                        // Upcoming step
                        if (stepNum) {
                            stepNum.className = 'w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 transition bg-slate-100 text-slate-500 border border-slate-200';
                            stepNum.textContent = (i + 1);
                        }
                        if (navBtn) navBtn.className = 'step-nav-btn flex items-center gap-2 p-1.5 sm:p-2 rounded-xl text-left transition cursor-pointer text-slate-400 hover:bg-slate-50';
                    }
                } else {
                    if (navBtn) navBtn.classList.add('hidden');
                }
            }

            // Update Next button labels inside panes
            const btnNext1 = document.getElementById('btn-next-step1-label');
            if (btnNext1) {
                btnNext1.textContent = currentRole === 'umum' ? 'Lanjut: Alamat Lengkap' : 'Lanjut: Wilayah Domisili';
            }
            const btnNext2 = document.getElementById('btn-next-step2-label');
            if (btnNext2) {
                btnNext2.textContent = currentRole === 'umum' ? 'Lanjut: Keamanan Akun' : 'Lanjut: Profil Peternakan';
            }
        }

        function goToStepIndex(index) {
            const steps = wizardConfig[currentRole];
            if (index < 0 || index >= steps.length) return;

            currentStepIndex = index;

            // Hide all 4 potential step panes
            [1, 2, 3, 4].forEach(p => {
                const pane = document.getElementById('step-pane-' + p);
                if (pane) {
                    pane.classList.add('hidden');
                }
            });

            // Show active pane
            const activePane = document.getElementById(steps[index].paneId);
            if (activePane) {
                activePane.classList.remove('hidden');
            }

            updateStepperUI();

            const card = document.getElementById('wizard-progress-card');
            if (card) {
                const rect = card.getBoundingClientRect();
                if (rect.top < 0 || rect.top > 250) {
                    card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }

        function nextStep() {
            const steps = wizardConfig[currentRole];
            if (currentStepIndex < steps.length - 1) {
                if (!validateStep(currentStepIndex)) {
                    return;
                }
                goToStepIndex(currentStepIndex + 1);
            }
        }

        function prevStep() {
            if (currentStepIndex > 0) {
                goToStepIndex(currentStepIndex - 1);
            }
        }

        function handleStepNavClick(targetIndex) {
            const steps = wizardConfig[currentRole];
            if (targetIndex < 0 || targetIndex >= steps.length) return;

            if (targetIndex <= currentStepIndex) {
                goToStepIndex(targetIndex);
            } else {
                for (let i = currentStepIndex; i < targetIndex; i++) {
                    if (!validateStep(i)) {
                        if (i !== currentStepIndex) goToStepIndex(i);
                        return;
                    }
                }
                goToStepIndex(targetIndex);
            }
        }

        // Dynamic Role Switcher (Peternak Milenial vs Masyarakat Umum)
        function setRole(role) {
            const roleInput = document.getElementById('role_input');
            if (roleInput) roleInput.value = role;

            currentRole = (role === 'umum') ? 'umum' : 'peternak';

            const cardPeternak = document.getElementById('role-card-peternak');
            const cardUmum = document.getElementById('role-card-umum');
            const iconPeternak = document.getElementById('role-icon-peternak');
            const iconUmum = document.getElementById('role-icon-umum');
            const sectionLivestock = document.getElementById('section-livestock');
            const livestockType = document.getElementById('livestock_type');
            const livestockCount = document.getElementById('livestock_count');
            const ktpStar = document.getElementById('ktp-required-star');
            const badgeTitle = document.getElementById('badge-role-title');
            const subtitle = document.getElementById('subtitle-role');
            const btnLabel = document.getElementById('submit-btn-label');

            const fieldPhone = document.getElementById('field-phone');
            const phoneNumber = document.getElementById('phone_number');
            const fieldNik = document.getElementById('field-nik');
            const nikInput = document.getElementById('nik');
            const fieldKtp = document.getElementById('field-ktp');
            const ktpFileInput = document.getElementById('ktp_file');
            const fieldAlamat = document.getElementById('field-alamat');
            const alamatInput = document.getElementById('alamat');
            const sectionWilayahCascading = document.getElementById('section-wilayah-cascading');
            const kabupaten = document.getElementById('kabupaten');
            const kecamatan = document.getElementById('kecamatan');
            const desa = document.getElementById('desa');
            const sec1Title = document.getElementById('sec1-title');
            const sec1Desc = document.getElementById('sec1-desc');
            const sec2Title = document.getElementById('sec2-title');
            const sec2Desc = document.getElementById('sec2-desc');
            const sec4Title = document.getElementById('sec4-title');
            const sec4Desc = document.getElementById('sec4-desc');

            if (role === 'umum') {
                // Highlight Umum Card
                if (cardUmum) {
                    cardUmum.className = 'px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-emerald-50/80 border-emerald-600 ring-2 ring-emerald-100 shadow-2xs';
                }
                if (iconUmum) {
                    iconUmum.className = 'w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs';
                }
                if (cardPeternak) {
                    cardPeternak.className = 'px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-white border-slate-200 hover:border-slate-300 shadow-2xs';
                }
                if (iconPeternak) {
                    iconPeternak.className = 'w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 shadow-2xs';
                }

                // Sembunyikan field yang tidak diperlukan untuk masyarakat umum
                if (fieldPhone) fieldPhone.classList.add('hidden');
                if (phoneNumber) phoneNumber.removeAttribute('required');
                if (fieldNik) fieldNik.classList.add('hidden');
                if (nikInput) nikInput.removeAttribute('required');
                if (fieldKtp) fieldKtp.classList.add('hidden');
                if (ktpFileInput) ktpFileInput.removeAttribute('required');
                if (sectionLivestock) sectionLivestock.classList.add('hidden');
                if (livestockType) livestockType.removeAttribute('required');
                if (livestockCount) livestockCount.removeAttribute('required');
                if (sectionWilayahCascading) sectionWilayahCascading.classList.add('hidden');
                if (kabupaten) kabupaten.removeAttribute('required');
                if (kecamatan) kecamatan.removeAttribute('required');
                if (desa) desa.removeAttribute('required');

                // Alamat lengkap wajib untuk masyarakat
                if (alamatInput) alamatInput.setAttribute('required', 'required');

                // Update text header
                if (sec1Title) sec1Title.textContent = 'Identitas Diri';
                if (sec1Desc) sec1Desc.textContent = 'Nama lengkap, tanggal lahir, dan email akun Anda';
                if (sec2Title) sec2Title.textContent = 'Alamat Lengkap';
                if (sec2Desc) sec2Desc.textContent = 'Alamat domisili lengkap tempat tinggal Anda';
                if (sec4Title) sec4Title.textContent = 'Keamanan Akun';
                if (sec4Desc) sec4Desc.textContent = 'Kata sandi untuk login masuk ke sistem';

                if (badgeTitle) {
                    badgeTitle.textContent = 'Pendaftaran Akun Masyarakat Umum Jatim';
                    badgeTitle.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs';
                }
                if (subtitle) {
                    subtitle.textContent = 'Cukup isi nama lengkap, tanggal lahir, alamat lengkap, dan kata sandi untuk mulai mengakses akun dan layanan.';
                }
                if (btnLabel) btnLabel.textContent = 'Sign Up sebagai Masyarakat Umum';
            } else {
                // Highlight Peternak Card
                if (cardPeternak) {
                    cardPeternak.className = 'px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-blue-50/80 border-blue-600 ring-2 ring-blue-100 shadow-2xs';
                }
                if (iconPeternak) {
                    iconPeternak.className = 'w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-2xs';
                }
                if (cardUmum) {
                    cardUmum.className = 'px-3.5 py-2 rounded-xl border-2 text-left transition-all flex items-center gap-2.5 cursor-pointer bg-white border-slate-200 hover:border-slate-300 shadow-2xs';
                }
                if (iconUmum) {
                    iconUmum.className = 'w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 shadow-2xs';
                }

                // Tampilkan field lengkap peternak
                if (fieldPhone) fieldPhone.classList.remove('hidden');
                if (phoneNumber) phoneNumber.setAttribute('required', 'required');
                if (fieldNik) fieldNik.classList.remove('hidden');
                if (nikInput) nikInput.setAttribute('required', 'required');
                if (fieldKtp) fieldKtp.classList.remove('hidden');
                if (sectionLivestock) sectionLivestock.classList.remove('hidden');
                if (livestockType) livestockType.setAttribute('required', 'required');
                if (livestockCount) livestockCount.setAttribute('required', 'required');
                if (sectionWilayahCascading) sectionWilayahCascading.classList.remove('hidden');
                if (kabupaten) kabupaten.setAttribute('required', 'required');
                if (kecamatan) kecamatan.setAttribute('required', 'required');
                if (desa) desa.setAttribute('required', 'required');
                if (ktpStar) ktpStar.classList.remove('hidden');
                if (alamatInput) alamatInput.removeAttribute('required');

                // Update text header
                if (sec1Title) sec1Title.textContent = 'Identitas Diri & Kontak';
                if (sec1Desc) sec1Desc.textContent = 'Informasi utama untuk verifikasi keanggotaan peternak';
                if (sec2Title) sec2Title.textContent = 'Wilayah Domisili (Jawa Timur)';
                if (sec2Desc) sec2Desc.textContent = 'Penentuan sentra binaan dan penugasan petugas pendamping';
                if (sec4Title) sec4Title.textContent = 'Keamanan Akun & Berkas Identitas';
                if (sec4Desc) sec4Desc.textContent = 'Kata sandi akun dan unggah foto KTP resmi untuk validasi';

                if (badgeTitle) {
                    badgeTitle.textContent = 'Pendaftaran Peternak Milenial Jatim';
                    badgeTitle.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80 shadow-2xs';
                }
                if (subtitle) {
                    subtitle.textContent = 'Lengkapi data diri, wilayah domisili, dan usaha peternakan Anda untuk mulai mengakses ekosistem digital Dinas Peternakan Jawa Timur.';
                }
                if (btnLabel) btnLabel.textContent = 'Sign Up';
            }

            goToStepIndex(0);
        }

        // Form Submit Handler & Event Listeners
        const regForm = document.getElementById('register-form');
        if (regForm) {
            regForm.addEventListener('submit', function(e) {
                const steps = wizardConfig[currentRole];
                // If user pressed Enter on an earlier step, advance to next step
                if (currentStepIndex < steps.length - 1) {
                    e.preventDefault();
                    nextStep();
                    return;
                }

                // If on final step, validate all steps in sequence
                for (let i = 0; i < steps.length; i++) {
                    if (!validateStep(i)) {
                        e.preventDefault();
                        goToStepIndex(i);
                        return;
                    }
                }
            });
        }

        ['nik', 'password_confirmation', 'password'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        });

        // Restore old inputs if present
        document.addEventListener('DOMContentLoaded', () => {
            const initialRole = @json(old('role', request('role', 'peternak')));
            setRole(initialRole);

            const oldKab = @json(old('kabupaten'));
            const oldKec = @json(old('kecamatan'));
            const oldDesa = @json(old('desa'));

            if (oldKab) {
                handleKabupatenChange(oldKab, oldKec, oldDesa);
            }

            const initialStep = @json($initialStepIndex);
            if (initialStep > 0) {
                goToStepIndex(initialStep);
            }
        });
    </script>
</body>

</html>

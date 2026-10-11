<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pusat Informasi &amp; FAQ — Peternak Milenial Dinas Peternakan Jawa Timur</title>

    <!-- Typography: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-primary: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            --color-bg-primary: #faf8ff;
            --color-text-primary: #131b2e;
            --color-text-secondary: #464554;
            --color-text-softer: #767586;
            --color-border-subtle: #e2e7ff;
            --color-brand: #2a14b4;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            background-color: var(--color-bg-primary);
            color: var(--color-text-primary);
            font-family: var(--font-primary);
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* Smooth details open accordion transitions */
        details[open] summary ~ * {
            animation: accordion-expand 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes accordion-expand {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            details[open] summary ~ * {
                animation: none;
            }
        }
    </style>
</head>

<body class="bg-[#faf8ff] text-[#131b2e] selection:bg-indigo-700 selection:text-white flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- 1. STICKY NAVIGATION BAR (~68px height, Translucent Lavender/White, Backdrop Blur, Border Indigo) -->
    <header class="sticky top-0 z-50 w-full h-[68px] bg-white/95 backdrop-blur-[12px] border-b border-indigo-100/80 px-4 sm:px-6 md:px-8 lg:px-12 flex items-center shadow-[0px_4px_16px_rgba(42,20,180,0.04)] transition-all">
        <div class="max-w-[1180px] mx-auto w-full flex items-center justify-between gap-4">

            <!-- Brand Logo & Wordmark -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 shrink-0 group focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700 rounded-lg" title="Peternak Milenial Jawa Timur">
                <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Peternak Milenial Jawa Timur Logo"
                    class="h-8 sm:h-9 w-auto max-w-[140px] sm:max-w-none object-contain transition-transform duration-200 group-hover:scale-[1.02]" />
            </a>

            <!-- Desktop Navigation Links (>= 1024px) -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-xs lg:text-[13.5px] font-medium text-[#464554]" aria-label="Main navigation">
                <a href="{{ route('landing') }}#tentang" class="hover:text-[#2a14b4] transition-colors py-1">Tentang Platform</a>
                <a href="{{ route('landing') }}#layanan" class="hover:text-[#2a14b4] transition-colors py-1">Ekosistem Layanan</a>
                <a href="{{ route('landing') }}#testimoni" class="hover:text-[#2a14b4] transition-colors py-1">Kisah Sukses</a>
                <a href="{{ route('faq') }}" class="text-[#2a14b4] font-semibold transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-gradient-to-r after:from-indigo-700 after:to-[#2a14b4] after:rounded-full">Pusat Informasi</a>
            </nav>

            <!-- Action Buttons (Desktop & Tablet) -->
            <div class="hidden sm:flex items-center gap-2.5 lg:gap-3 shrink-0">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-700 hover:bg-indigo-800 text-white shadow-sm shadow-indigo-950/20 transition-all duration-200 active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                        <span>Buka Dashboard</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" id="nav-masuk-btn"
                        class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs sm:text-sm font-medium text-[#464554] hover:text-[#2a14b4] hover:bg-[#eaedff]/60 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" id="nav-login-btn"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-indigo-700 hover:bg-indigo-800 text-white shadow-sm shadow-indigo-950/20 transition-all duration-200 active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                        <span>Daftar Akun</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Toggle (< 1024px) -->
            <button type="button" onclick="toggleMobileMenu()" id="mobile-menu-btn"
                class="lg:hidden p-2 rounded-xl text-[#464554] hover:text-[#2a14b4] hover:bg-[#eaedff]/60 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700"
                aria-label="Buka menu navigasi" aria-expanded="false">
                <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </header>

    <!-- Mobile Navigation Drawer Backdrop & Drawer (< 1024px) -->
    <div id="mobile-menu-backdrop" onclick="closeMobileMenu()" class="fixed inset-0 bg-slate-900/30 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity" aria-hidden="true"></div>
    <div id="mobile-menu" class="fixed top-[68px] left-0 right-0 bg-white/98 backdrop-blur-xl border-b border-indigo-100 shadow-2xl z-40 hidden lg:hidden px-5 py-6 transition-all">
        <nav class="flex flex-col gap-3 text-sm font-medium text-[#464554]">
            <a href="{{ route('landing') }}#tentang" onclick="closeMobileMenu()" class="py-2 px-3 rounded-lg hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors">Tentang Platform</a>
            <a href="{{ route('landing') }}#layanan" onclick="closeMobileMenu()" class="py-2 px-3 rounded-lg hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors">Ekosistem Layanan</a>
            <a href="{{ route('landing') }}#testimoni" onclick="closeMobileMenu()" class="py-2 px-3 rounded-lg hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors">Kisah Sukses</a>
            <a href="{{ route('faq') }}" onclick="closeMobileMenu()" class="py-2 px-3 rounded-lg bg-[#e2e7ff] text-[#2a14b4] font-semibold">Pusat Informasi &amp; FAQ</a>
            <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2.5">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl font-semibold text-white bg-indigo-700 shadow-sm">Buka Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl font-medium text-[#464554] border border-slate-200 hover:bg-slate-50">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl font-semibold text-white bg-indigo-700 shadow-sm">Daftar Akun</a>
                @endauth
            </div>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-grow flex flex-col items-center w-full">

        <!-- 2. CENTERED FAQ HERO SECTION & 3. VERTICAL FAQ ACCORDION -->
        <section id="faq" aria-labelledby="faq-heading"
            class="relative flex flex-col w-full items-center px-4 sm:px-6 md:px-8 lg:px-12 py-16 sm:py-20 lg:py-24 bg-[#faf8ff] border-b border-indigo-100/70 overflow-hidden">

            <!-- Subtle ambient radial glows matching website theme (pointer-events-none) -->
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-gradient-to-b from-indigo-600/10 via-[#2a14b4]/5 to-transparent rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
            <div class="absolute top-1/3 -right-24 w-80 h-80 bg-[#2a14b4]/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
            <div class="absolute bottom-10 -left-24 w-80 h-80 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

            <div class="max-w-[1180px] mx-auto w-full relative z-10 flex flex-col items-center">

                <!-- Centered FAQ Hero Header -->
                <header class="flex flex-col max-w-2xl items-center gap-2.5 sm:gap-3 text-center px-2 mb-10 sm:mb-12 lg:mb-14">
                    <span class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-1 rounded-full text-[11px] sm:text-xs font-semibold tracking-wide uppercase bg-[#e2e7ff] text-[#2a14b4] border border-indigo-200/60 shadow-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#2a14b4] animate-pulse" aria-hidden="true"></span>
                        Pusat Informasi &amp; FAQ
                    </span>

                    <div class="w-full">
                        <h1 id="faq-heading"
                            class="font-extrabold text-[#131b2e] text-2xl sm:text-3xl md:text-4xl lg:text-[40px] tracking-[-0.8px] leading-tight sm:leading-[1.2]">
                            Frequently Asked <span class="text-indigo-700">Questions</span>
                        </h1>
                    </div>

                    <p class="font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] text-center leading-relaxed max-w-xl">
                        Jawaban ringkas seputar tata cara pendaftaran akun, layanan dokter dinas gratis, dan rujukan pasar.
                    </p>
                </header>

                <!-- Vertical FAQ Accordion Stack (max-w ~820px) -->
                <div class="w-full max-w-[820px] flex flex-col gap-3.5 sm:gap-4">

                    <!-- FAQ 1 (Open by default) -->
                    <details open class="group bg-white rounded-2xl border border-indigo-100/90 shadow-[0_2px_12px_rgba(42,20,180,0.04)] open:border-indigo-400/80 open:shadow-[0_12px_32px_-6px_rgba(42,20,180,0.12)] transition-all duration-300 overflow-hidden">
                        <summary class="flex items-center justify-between gap-3.5 sm:gap-4 p-4.5 sm:p-5 md:p-6 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 rounded-2xl transition-colors">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 text-left">
                                <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-[#f2f3ff] text-[#2a14b4] border border-indigo-100/80 flex items-center justify-center shrink-0 transition-all duration-300 group-open:bg-gradient-to-r group-open:from-indigo-700 group-open:to-[#2a14b4] group-open:text-white group-open:border-transparent group-open:shadow-xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-[#131b2e] text-sm sm:text-base md:text-[16.5px] leading-snug tracking-[-0.2px] group-hover:text-[#2a14b4] transition-colors">
                                    Siapa saja yang berhak mendaftar di portal Peternak Milenial?
                                </h3>
                            </div>
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-lg flex items-center justify-center shrink-0 text-[#767586] group-open:text-[#2a14b4] group-hover:text-[#2a14b4] transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transform transition-transform duration-300 ease-in-out group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </summary>
                        <div class="px-4.5 sm:px-5 md:px-6 pb-5 sm:pb-6 pt-2 border-t border-indigo-50/80 text-left">
                            <p class="font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] leading-relaxed">
                                Seluruh pemuda, wirausaha pemula, kelompok peternak rakyat, serta pelaku UMKM olahan ternak yang berdomisili di 38 kabupaten/kota se-Jawa Timur dapat mendaftarkan akun secara mandiri tanpa pungutan biaya.
                            </p>
                            <div class="pt-3.5 mt-2 flex items-center">
                                <a href="#support" class="inline-flex items-center gap-1.5 font-semibold text-xs sm:text-[13px] text-[#2a14b4] hover:text-indigo-800 transition-colors group/link focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                                    <span>Click to learn more</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </details>

                    <!-- FAQ 2 -->
                    <details class="group bg-white rounded-2xl border border-indigo-100/90 shadow-[0_2px_12px_rgba(42,20,180,0.04)] open:border-indigo-400/80 open:shadow-[0_12px_32px_-6px_rgba(42,20,180,0.12)] transition-all duration-300 overflow-hidden">
                        <summary class="flex items-center justify-between gap-3.5 sm:gap-4 p-4.5 sm:p-5 md:p-6 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 rounded-2xl transition-colors">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 text-left">
                                <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-[#f2f3ff] text-[#2a14b4] border border-indigo-100/80 flex items-center justify-center shrink-0 transition-all duration-300 group-open:bg-gradient-to-r group-open:from-indigo-700 group-open:to-[#2a14b4] group-open:text-white group-open:border-transparent group-open:shadow-xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-[#131b2e] text-sm sm:text-base md:text-[16.5px] leading-snug tracking-[-0.2px] group-hover:text-[#2a14b4] transition-colors">
                                    Apakah layanan siaga darurat kesmavet dikenakan biaya?
                                </h3>
                            </div>
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-lg flex items-center justify-center shrink-0 text-[#767586] group-open:text-[#2a14b4] group-hover:text-[#2a14b4] transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transform transition-transform duration-300 ease-in-out group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </summary>
                        <div class="px-4.5 sm:px-5 md:px-6 pb-5 sm:pb-6 pt-2 border-t border-indigo-50/80 text-left">
                            <p class="font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] leading-relaxed">
                                Layanan pelaporan siaga tanggap darurat dan konsultasi penyakit ternak bersama dokter hewan dinas merupakan fasilitas pelayanan publik resmi dari Pemprov Jawa Timur dan sepenuhnya gratis 24 jam.
                            </p>
                            <div class="pt-3.5 mt-2 flex items-center">
                                <a href="{{ route('darurat') }}" class="inline-flex items-center gap-1.5 font-semibold text-xs sm:text-[13px] text-[#2a14b4] hover:text-indigo-800 transition-colors group/link focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                                    <span>Click to learn more</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </details>

                    <!-- FAQ 3 -->
                    <details class="group bg-white rounded-2xl border border-indigo-100/90 shadow-[0_2px_12px_rgba(42,20,180,0.04)] open:border-indigo-400/80 open:shadow-[0_12px_32px_-6px_rgba(42,20,180,0.12)] transition-all duration-300 overflow-hidden">
                        <summary class="flex items-center justify-between gap-3.5 sm:gap-4 p-4.5 sm:p-5 md:p-6 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 rounded-2xl transition-colors">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 text-left">
                                <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-[#f2f3ff] text-[#2a14b4] border border-indigo-100/80 flex items-center justify-center shrink-0 transition-all duration-300 group-open:bg-gradient-to-r group-open:from-indigo-700 group-open:to-[#2a14b4] group-open:text-white group-open:border-transparent group-open:shadow-xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-[#131b2e] text-sm sm:text-base md:text-[16.5px] leading-snug tracking-[-0.2px] group-hover:text-[#2a14b4] transition-colors">
                                    Bagaimana prosedur sertifikasi Nomor Kontrol Veteriner (NKV)?
                                </h3>
                            </div>
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-lg flex items-center justify-center shrink-0 text-[#767586] group-open:text-[#2a14b4] group-hover:text-[#2a14b4] transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transform transition-transform duration-300 ease-in-out group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </summary>
                        <div class="px-4.5 sm:px-5 md:px-6 pb-5 sm:pb-6 pt-2 border-t border-indigo-50/80 text-left">
                            <p class="font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] leading-relaxed">
                                Setelah akun terdaftar, peternak dapat mengajukan asesmen mandiri kesiapan sanitasi kandang melalui portal. Tim pembina mutu dinas akan melakukan visitasi lapangan dan bimbingan hingga sertifikat NKV diterbitkan.
                            </p>
                            <div class="pt-3.5 mt-2 flex items-center">
                                <a href="{{ route('pelatihan') }}" class="inline-flex items-center gap-1.5 font-semibold text-xs sm:text-[13px] text-[#2a14b4] hover:text-indigo-800 transition-colors group/link focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                                    <span>Click to learn more</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </details>

                    <!-- FAQ 4 -->
                    <details class="group bg-white rounded-2xl border border-indigo-100/90 shadow-[0_2px_12px_rgba(42,20,180,0.04)] open:border-indigo-400/80 open:shadow-[0_12px_32px_-6px_rgba(42,20,180,0.12)] transition-all duration-300 overflow-hidden">
                        <summary class="flex items-center justify-between gap-3.5 sm:gap-4 p-4.5 sm:p-5 md:p-6 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 rounded-2xl transition-colors">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 text-left">
                                <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-xl bg-[#f2f3ff] text-[#2a14b4] border border-indigo-100/80 flex items-center justify-center shrink-0 transition-all duration-300 group-open:bg-gradient-to-r group-open:from-indigo-700 group-open:to-[#2a14b4] group-open:text-white group-open:border-transparent group-open:shadow-xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-[#131b2e] text-sm sm:text-base md:text-[16.5px] leading-snug tracking-[-0.2px] group-hover:text-[#2a14b4] transition-colors">
                                    Dari mana sumber data rujukan harga pasar harian?
                                </h3>
                            </div>
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-lg flex items-center justify-center shrink-0 text-[#767586] group-open:text-[#2a14b4] group-hover:text-[#2a14b4] transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 transform transition-transform duration-300 ease-in-out group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </summary>
                        <div class="px-4.5 sm:px-5 md:px-6 pb-5 sm:pb-6 pt-2 border-t border-indigo-50/80 text-left">
                            <p class="font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] leading-relaxed">
                                Data harga harian dihimpun setiap pagi oleh petugas pencatat harga dinas langsung dari pasar-pasar hewan utama dan koperasi peternak di seluruh 38 kabupaten/kota di Jawa Timur.
                            </p>
                            <div class="pt-3.5 mt-2 flex items-center">
                                <a href="{{ route('harga-komoditas') }}" class="inline-flex items-center gap-1.5 font-semibold text-xs sm:text-[13px] text-[#2a14b4] hover:text-indigo-800 transition-colors group/link focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700">
                                    <span>Click to learn more</span>
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </details>

                </div>

                <!-- Aside Support Banner (Responsive Layout, max-w ~820px, Matching Website Theme) -->
                <aside id="support"
                    class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center justify-between gap-3.5 sm:gap-4 p-4.5 sm:p-5 w-full max-w-[820px] bg-white rounded-2xl border border-indigo-100/90 shadow-[0_2px_12px_rgba(42,20,180,0.04)] text-center sm:text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#e2e7ff] text-[#2a14b4] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01" />
                            </svg>
                        </div>
                        <span class="font-medium text-[#464554] text-xs sm:text-sm">
                            Belum menemukan jawaban Anda?
                        </span>
                    </div>
                    <a href="mailto:disnak@jatimprov.go.id"
                        class="inline-flex items-center gap-1.5 font-semibold text-xs sm:text-[13px] text-[#2a14b4] hover:text-indigo-800 hover:underline transition-colors shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700 rounded-sm">
                        <span>Hubungi posko siaga dinas sekarang (0800-1-DARURAT)</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </aside>

            </div>
        </section>

        <!-- 4. CIVIC CTA SECTION (MATCHING WEBSITE THEME) -->
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 w-full bg-[#faf8ff]" aria-labelledby="faq-cta-title">
            <div class="max-w-[1180px] mx-auto w-full">
                <div
                    class="max-w-[940px] mx-auto px-6 sm:px-10 md:px-14 lg:px-16 py-10 sm:py-14 lg:py-16 relative bg-gradient-to-r from-[#1e1b4b] via-indigo-900 to-[#2a14b4] rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0_20px_40px_-15px_rgba(42,20,180,0.35)] flex flex-col items-center text-center">

                    <!-- Ambient Soft Glow Overlays (pointer-events-none) -->
                    <div class="absolute -top-32 -left-32 w-80 h-80 bg-white/10 rounded-full blur-[48px] pointer-events-none" aria-hidden="true"></div>
                    <div class="absolute -right-32 -bottom-32 w-80 h-80 bg-indigo-500/20 rounded-full blur-[48px] pointer-events-none" aria-hidden="true"></div>

                    <div class="flex flex-col max-w-2xl items-center gap-3.5 sm:gap-4 relative z-10">

                        <span class="inline-block px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs text-[11px] sm:text-xs font-semibold text-white border border-white/25 shadow-xs">
                            Program Pembinaan Terpadu Dinas Peternakan Jatim
                        </span>

                        <h2 id="faq-cta-title"
                            class="font-extrabold text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-tight leading-tight sm:leading-[1.2]">
                            Wujudkan Peternakan Tangguh &amp; Modern di Jawa Timur
                        </h2>

                        <!-- Frosted translucent supporting panel to maintain excellent readability -->
                        <div class="w-full bg-white/10 backdrop-blur-xs rounded-xl px-4 py-2.5 sm:px-5 sm:py-3.5 my-1 sm:my-2 border border-white/15">
                            <p class="font-normal text-white/95 text-xs sm:text-sm md:text-[14.5px] text-center leading-relaxed">
                                Daftarkan kelompok atau unit usaha peternakan Anda sekarang untuk mendapatkan akses bimbingan teknis, pengawasan medis 24 jam, dan integrasi pasar daerah.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-3.5 w-full sm:w-auto pt-2 sm:pt-3">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-5 sm:px-7 py-3 sm:py-3.5 bg-white/15 hover:bg-white/25 text-white border border-white/25 rounded-xl font-semibold text-xs sm:text-sm backdrop-blur-xs transition-colors duration-200 active:scale-[0.98] text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                                Masuk ke Portal
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 bg-white hover:bg-[#f2f3ff] text-[#2a14b4] rounded-xl font-bold text-xs sm:text-sm shadow-[0_8px_16px_-4px_rgba(0,0,0,0.15)] transition-all duration-200 active:scale-[0.98] group text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                                <span>Daftar Akun Sekarang</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5"
                                    fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- 5. MINIMAL FOOTER (Lavender Background, Subtle Border, Brand Lockup, Copyright, Official Links) -->
    <footer class="w-full bg-[#f2f3ff] border-t border-indigo-100/70 px-4 sm:px-6 md:px-8 lg:px-12 py-8 sm:py-10 text-xs text-[#464554]">
        <div class="max-w-[1180px] mx-auto w-full flex flex-col sm:flex-row items-center justify-between gap-5 sm:gap-6 text-center sm:text-left">

            <!-- Brand Identity Lockup -->
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                <a href="{{ route('landing') }}" class="flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-700 rounded-lg">
                    <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Peternak Milenial Logo" class="h-7 sm:h-8 w-auto object-contain" />
                </a>
                <span class="hidden sm:inline-block w-px h-4 bg-indigo-200" aria-hidden="true"></span>
                <p class="text-[11.5px] sm:text-xs text-[#767586]">
                    &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Seluruh Hak Cipta Dilindungi.
                </p>
            </div>

            <!-- Supporting Official Links & Contact -->
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-4 sm:gap-6 text-[11.5px] sm:text-xs text-[#464554]">
                <a href="{{ route('landing') }}" class="hover:text-[#2a14b4] transition-colors">Beranda</a>
                <a href="{{ route('darurat') }}" class="hover:text-[#2a14b4] transition-colors">Posko Siaga (0800-1-DARURAT)</a>
                <a href="mailto:disnak@jatimprov.go.id" class="hover:text-[#2a14b4] transition-colors">disnak@jatimprov.go.id</a>
            </div>

        </div>
    </footer>

    <!-- Interactive Client Scripts for Drawer -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('mobile-menu-backdrop');
            const btn = document.getElementById('mobile-menu-btn');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (menu) {
                const isOpening = menu.classList.contains('hidden');
                menu.classList.toggle('hidden');
                if (backdrop) backdrop.classList.toggle('hidden', !isOpening);
                if (btn) btn.setAttribute('aria-expanded', isOpening ? 'true' : 'false');
                if (hamburgerIcon && closeIcon) {
                    hamburgerIcon.classList.toggle('hidden', isOpening);
                    closeIcon.classList.toggle('hidden', !isOpening);
                }
            }
        }

        function closeMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('mobile-menu-backdrop');
            const btn = document.getElementById('mobile-menu-btn');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (menu) menu.classList.add('hidden');
            if (backdrop) backdrop.classList.add('hidden');
            if (btn) btn.setAttribute('aria-expanded', 'false');
            if (hamburgerIcon) hamburgerIcon.classList.remove('hidden');
            if (closeIcon) closeIcon.classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileMenu();
            }
        });
    </script>
</body>

</html>

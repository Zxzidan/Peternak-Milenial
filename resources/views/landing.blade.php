<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peternak Milenial Jatim — Portal Resmi Dinas Peternakan Provinsi Jawa Timur</title>

    <!-- Typography: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-primary: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            --font-inter: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: var(--font-primary);
            background-color: #faf8ff;
            color: #131b2e;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* Seamless Horizontal Marquee Ticker with Hover-Pause */
        @keyframes marquee-scroll {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee-scroll 28s linear infinite;
            will-change: transform;
        }

        .marquee-container:hover .marquee-track {
            animation-play-state: paused;
        }

        @media (prefers-reduced-motion: reduce) {
            .marquee-track {
                animation: none;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body class="bg-[#faf8ff] text-[#131b2e] selection:bg-indigo-700 selection:text-white flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- 1. Floating Fluid Navigation Bar (Responsive Across Mobile, Tablet, Laptop, Desktop) -->
    <div class="fixed top-2 sm:top-3.5 lg:top-4 left-0 right-0 z-50 px-3 sm:px-5 lg:px-6 flex justify-center pointer-events-none pt-[env(safe-area-inset-top,0px)]">
        <header class="w-full max-w-6xl bg-white/95 backdrop-blur-[12px] [-webkit-backdrop-filter:blur(12px)] border border-indigo-100/80 rounded-2xl sm:rounded-full px-3.5 sm:px-5 lg:px-6 py-2 sm:py-2.5 shadow-[0px_4px_16px_rgba(42,20,180,0.06)] flex items-center justify-between pointer-events-auto transition-all">
            
            <!-- Left: Official Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2 shrink-0 group min-w-0" title="Peternak Milenial Jawa Timur">
                <img
                    src="{{ asset('img/Peternak Milenial.png') }}"
                    alt="Peternak Milenial Jawa Timur Logo"
                    class="h-7 sm:h-8 md:h-9 lg:h-10 w-auto max-w-[120px] sm:max-w-none object-contain transition-transform duration-300 group-hover:scale-[1.02]"
                />
            </a>

            <!-- Center: Editorial Navigation Links (Desktop & Laptop: >= 1024px) -->
            <nav class="hidden lg:flex items-center gap-5 xl:gap-7 text-xs lg:text-[13px] font-medium tracking-tight text-[#464554]">
                <a href="#tentang" class="hover:text-[#2a14b4] transition-colors py-1">Tentang Platform</a>
                <a href="#layanan" class="hover:text-[#2a14b4] transition-colors py-1">Ekosistem Layanan</a>
                <a href="#testimoni" class="hover:text-[#2a14b4] transition-colors py-1">Kisah Sukses</a>
                <a href="#faq" class="hover:text-[#2a14b4] transition-colors py-1">Pusat Informasi</a>
            </nav>

            <!-- Right: Action Buttons (Desktop, Laptop & Tablet: >= 640px) -->
            <div class="hidden sm:flex items-center gap-2 lg:gap-2.5 shrink-0">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs font-semibold bg-indigo-700 hover:bg-indigo-800 text-white shadow-sm shadow-indigo-950/20 transition-all duration-200 active:scale-[0.98]"
                    >
                        <span>Buka Dashboard</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        id="nav-masuk-btn"
                        class="inline-flex items-center px-3 lg:px-3.5 py-1.5 rounded-full text-xs font-medium text-[#464554] hover:text-[#2a14b4] hover:bg-[#eaedff]/60 transition-all duration-200"
                    >
                        Masuk
                    </a>
                    <a
                        href="{{ route('register') }}"
                        id="nav-login-btn"
                        class="inline-flex items-center gap-1.5 px-3.5 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs font-semibold bg-indigo-700 hover:bg-indigo-800 text-white shadow-sm shadow-indigo-950/20 transition-all duration-200 active:scale-[0.98]"
                    >
                        <span>Daftar Akun</span>
                        <svg class="w-3.5 h-3.5 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Mobile & Tablet Hamburger Toggle (< 1024px) -->
            <div class="flex lg:hidden items-center gap-1.5 sm:gap-2 shrink-0">
                @auth
                    <a href="{{ route('dashboard') }}" class="sm:hidden px-2.5 py-1.5 rounded-full text-[11px] font-semibold bg-indigo-700 text-white shadow-xs">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="sm:hidden px-2.5 py-1.5 rounded-full text-[11px] font-semibold text-[#464554] border border-slate-200 hover:bg-slate-50 transition-colors">
                        Masuk
                    </a>
                @endauth
                <button
                    type="button"
                    onclick="toggleMobileMenu()"
                    aria-label="Buka Menu Navigasi"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    id="mobile-menu-btn"
                    class="p-1.5 sm:p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-700 transition-colors"
                >
                    <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg id="close-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </header>

        <!-- Mobile & Tablet Drawer Menu Dropdown -->
        <div id="mobile-menu" class="hidden absolute top-13 sm:top-15 left-3 right-3 sm:left-5 sm:right-5 bg-white/98 backdrop-blur-xl border border-indigo-100 rounded-2xl p-4 shadow-2xl pointer-events-auto space-y-2.5 lg:hidden max-h-[calc(100vh-5rem)] overflow-y-auto transition-all duration-300">
            <nav class="flex flex-col space-y-1 text-sm font-medium text-[#464554]">
                <a href="#tentang" onclick="closeMobileMenu()" class="px-3 py-2 rounded-xl hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors flex items-center justify-between">
                    <span>Tentang Platform</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="#layanan" onclick="closeMobileMenu()" class="px-3 py-2 rounded-xl hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors flex items-center justify-between">
                    <span>Ekosistem Layanan</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="#testimoni" onclick="closeMobileMenu()" class="px-3 py-2 rounded-xl hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors flex items-center justify-between">
                    <span>Kisah Sukses</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="#faq" onclick="closeMobileMenu()" class="px-3 py-2 rounded-xl hover:bg-[#faf8ff] hover:text-[#2a14b4] transition-colors flex items-center justify-between">
                    <span>Pusat Informasi</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </nav>
            <div class="pt-2.5 border-t border-slate-100 flex flex-col gap-2 sm:hidden">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-indigo-700 text-white shadow-sm">
                        Buka Dashboard
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-xl text-xs sm:text-sm font-medium text-[#464554] border border-slate-200 hover:bg-slate-50 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-xl text-xs sm:text-sm font-bold bg-indigo-700 text-white shadow-sm">
                            Daftar Akun
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Backdrop Overlay -->
    <div id="mobile-menu-backdrop" class="hidden fixed inset-0 bg-slate-900/30 backdrop-blur-xs z-40 lg:hidden" onclick="closeMobileMenu()"></div>

    <!-- 2. Hero Section: Full Background with gradasi.png (Ultra Responsive Mobile, Tablet, Laptop, Desktop) -->
    <section
        id="tentang"
        aria-labelledby="hero-heading"
        class="relative flex flex-col justify-center w-full min-h-[500px] sm:min-h-[560px] md:min-h-[620px] lg:min-h-[660px] xl:min-h-[700px] pt-20 sm:pt-28 md:pt-32 lg:pt-36 pb-16 sm:pb-20 md:pb-24 lg:pb-28 px-4 sm:px-6 md:px-8 lg:px-12 overflow-hidden bg-cover bg-no-repeat border-b border-indigo-100/60"
        style="background-image: url('{{ asset('img/gradasi.png') }}'); background-position: right bottom;"
    >
        <!-- Adaptive Legibility Scrim (Protects text contrast on phones & portrait tablets while blending to transparent on desktop) -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/85 to-white/50 sm:from-white/90 sm:via-white/70 sm:to-transparent lg:from-white/30 lg:via-transparent lg:to-transparent pointer-events-none"></div>

        <div class="max-w-[1120px] mx-auto w-full relative z-10">
            <!-- Left: Headline & Actions -->
            <div class="max-w-xl flex flex-col items-start gap-3.5 sm:gap-5">
                
                <!-- Official Institutional Tag -->
                <div class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 bg-[#e2e7ff] rounded-full shadow-[0px_1px_2px_#0000000d]">
                    <p class="[font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-[10px] sm:text-[11px] tracking-[0.40px] sm:tracking-[0.50px] leading-4 whitespace-nowrap">
                        Dinas Peternakan Provinsi Jawa Timur
                    </p>
                </div>

                <!-- 3-Line High-Impact Headline (Fluid Typography) -->
                <div class="w-full">
                    <h1
                        id="hero-heading"
                        class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-extrabold text-[#131b2e] text-[26px] xs:text-[28px] sm:text-3xl md:text-4xl lg:text-[44px] xl:text-[48px] tracking-[-1px] leading-[1.16] break-words"
                    >
                        Pemberdayaan Digital
                        <br class="hidden sm:inline" />
                        <span class="text-indigo-700">Peternak Muda</span> Jawa
                        <br class="hidden sm:inline" />
                        Timur
                    </h1>
                </div>

                <!-- Narrative Lead -->
                <div class="max-w-lg">
                    <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] tracking-[0] leading-relaxed">
                        Ekosistem satu pintu untuk memetakan sentra ternak, siaga tanggap darurat kesmavet 24 jam, standardisasi mutu pakan modern, dan transparansi harga pasar di 38 kabupaten/kota.
                    </p>
                </div>

                <!-- Primary & Secondary Action CTAs -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3.5 w-full sm:w-auto pt-1">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-lg sm:rounded-xl shadow-[0px_6px_8px_-4px_#0000001a,0px_16px_20px_-4px_#0000001a] transition-all duration-200 active:scale-[0.98] group text-center"
                        >
                            <span class="[font-family:'Inter',sans-serif] font-semibold text-white text-xs sm:text-sm sm:whitespace-nowrap">
                                Buka Dashboard Sistem
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @else
                        <a
                            href="{{ route('register') }}"
                            id="hero-daftar-btn"
                            class="inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-lg sm:rounded-xl shadow-[0px_6px_8px_-4px_#0000001a,0px_16px_20px_-4px_#0000001a] transition-all duration-200 active:scale-[0.98] group text-center"
                        >
                            <span class="[font-family:'Inter',sans-serif] font-semibold text-white text-xs sm:text-sm sm:whitespace-nowrap">
                                Daftar Akun Peternak
                            </span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a
                            href="{{ route('register', ['role' => 'umum']) }}"
                            class="inline-flex items-center justify-center px-4.5 sm:px-6 py-3 sm:py-3.5 bg-white/90 hover:bg-white text-emerald-800 border border-emerald-200/80 rounded-lg sm:rounded-xl shadow-xs transition-all duration-200 active:scale-[0.98] text-center"
                        >
                            <span class="[font-family:'Inter',sans-serif] font-semibold text-xs sm:text-[13px] sm:whitespace-nowrap">
                                Daftar Masyarakat Umum
                            </span>
                        </a>
                    @endauth
                </div>

                <!-- Social Proof / Farmer Community Avatars -->
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3.5 pt-1">
                    <div aria-label="Peternak terdaftar" class="inline-flex items-center shrink-0">
                        <div class="flex w-7 sm:w-8 h-7 sm:h-8 items-center justify-center bg-[#e2e7ff] text-[#2a14b4] rounded-full border-2 border-[#faf8ff] shadow-xs [font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[11px]">
                            JD
                        </div>
                        <div class="flex w-7 sm:w-8 h-7 sm:h-8 items-center justify-center bg-[#eaddff] text-[#25005a] rounded-full border-2 border-[#faf8ff] shadow-xs [font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[11px] -ml-2">
                            KL
                        </div>
                        <div class="flex w-7 sm:w-8 h-7 sm:h-8 items-center justify-center bg-[#acedff] text-[#001f26] rounded-full border-2 border-[#faf8ff] shadow-xs [font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[11px] -ml-2">
                            SR
                        </div>
                    </div>
                    <div class="inline-flex flex-col items-start">
                        <p class="[font-family:'Inter',sans-serif] font-semibold text-[#131b2e] text-xs leading-tight">
                            100+ Peternak Terdaftar
                        </p>
                        <span class="text-[10px] text-[#464554]">Aktif di 38 Kabupaten / Kota se-Jatim</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Mitra & Kolaborasi Resmi (Standalone Partner Marquee Section Outside Jumbotron) -->
    @php
        $partners = [
            [
                'name' => 'Pemerintah Provinsi Jawa Timur',
                'logo' => asset('img/logo-jatim.png'),
            ],
            [
                'name' => 'Kementerian Peternakan RI',
                'logo' => asset('img/logo-kementan.png'),
            ],
            [
                'name' => 'Universitas Brawijaya',
                'logo' => asset('img/logo-ub.png'),
            ],
            [
                'name' => 'UPN "Veteran" Jawa Timur',
                'logo' => asset('img/logo-upn.png'),
            ],
        ];
        $tickerSequence = array_merge($partners, $partners, $partners);
    @endphp
    <section class="py-6 sm:py-8 lg:py-10 bg-white border-b border-indigo-100/60 overflow-hidden">
        <div class="max-w-[1120px] mx-auto px-4 sm:px-6 mb-3 sm:mb-5 text-center">
            <p class="[font-family:'Inter',sans-serif] text-[10px] sm:text-[11px] font-semibold tracking-[0.60px] text-[#2a14b4] uppercase">
                Mitra Kolaborasi Strategis
            </p>
            <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-xs sm:text-base md:text-lg font-bold text-[#131b2e] tracking-tight mt-1">
                Sinergi Pemerintah Daerah, Kementerian &amp; Perguruan Tinggi
            </h3>
        </div>

        <div class="relative w-full overflow-hidden marquee-container py-1.5">
            <!-- Left Gradient Edge Fade (Adaptive Width) -->
            <div class="pointer-events-none absolute inset-y-0 left-0 w-8 sm:w-16 md:w-28 lg:w-36 bg-gradient-to-r from-white via-white/80 to-transparent z-10"></div>
            
            <!-- Right Gradient Edge Fade (Adaptive Width) -->
            <div class="pointer-events-none absolute inset-y-0 right-0 w-8 sm:w-16 md:w-28 lg:w-36 bg-gradient-to-l from-white via-white/80 to-transparent z-10"></div>

            <!-- Scrolling Track (Infinite Loop) -->
            <div class="marquee-track flex items-center gap-3 sm:gap-4 md:gap-5">
                {{-- First Half --}}
                @foreach($tickerSequence as $partner)
                    <div class="flex items-center justify-center px-3 sm:px-5 md:px-6 py-2 sm:py-3 rounded-xl sm:rounded-2xl bg-[#faf8ff] border border-indigo-100/80 shadow-[0px_1px_2px_#0000000d] hover:shadow-md hover:border-indigo-300 hover:-translate-y-0.5 transition-all duration-300 w-24 sm:w-32 md:w-36 h-12 sm:h-16 md:h-18 shrink-0 select-none group/card cursor-pointer">
                        <img
                            src="{{ $partner['logo'] }}"
                            alt="{{ $partner['name'] }}"
                            class="max-h-full max-w-full object-contain group-hover/card:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    </div>
                @endforeach

                {{-- Second Half for loop --}}
                @foreach($tickerSequence as $partner)
                    <div class="flex items-center justify-center px-3 sm:px-5 md:px-6 py-2 sm:py-3 rounded-xl sm:rounded-2xl bg-[#faf8ff] border border-indigo-100/80 shadow-[0px_1px_2px_#0000000d] hover:shadow-md hover:border-indigo-300 hover:-translate-y-0.5 transition-all duration-300 w-24 sm:w-32 md:w-36 h-12 sm:h-16 md:h-18 shrink-0 select-none group/card cursor-pointer" aria-hidden="true">
                        <img
                            src="{{ $partner['logo'] }}"
                            alt="{{ $partner['name'] }}"
                            class="max-h-full max-w-full object-contain group-hover/card:scale-105 transition-transform duration-300"
                            loading="lazy"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. RemoteTeamFeaturesSection: CORE CAPABILITIES (Responsive Grid Layout) -->
    <section id="layanan" class="flex flex-col w-full items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-white border-b border-indigo-100/60 shadow-[0px_1px_2px_#0000000d]">
        <div class="flex flex-col max-w-[1120px] mx-auto items-center gap-8 sm:gap-10 lg:gap-12 w-full">
            
            <header class="flex flex-col max-w-2xl items-center gap-1.5 sm:gap-2 text-center px-2">
                <div class="[font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-[11px] text-center tracking-[0.60px] leading-4 uppercase whitespace-nowrap">
                    CORE CAPABILITIES
                </div>
                <div class="w-full">
                    <h2 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[#131b2e] text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]">
                        Semua Kebutuhan Peternak Muda
                        <br class="hidden sm:inline" />
                        dalam Satu Ekosistem
                    </h2>
                </div>
                <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] leading-relaxed">
                    Empat modul terintegrasi untuk mendampingi siklus usaha peternakan rakyat dari hulu ke hilir.
                </p>
            </header>

            <!-- Grid of Cards (Single col on phone, 2 cols on tablet, 3 cols on desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-7 w-full">
                
                <!-- Feature 1: Posko Darurat Kesmavet -->
                <article class="flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] hover:shadow-md hover:border-indigo-300 hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <div class="w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-[#e2e7ff] rounded-xl flex mb-4 sm:mb-5 text-[#2a14b4]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug mb-2 sm:mb-2.5">
                            Posko Darurat Kesmavet 24 Jam
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed mb-4 sm:mb-5">
                            Sistem pelaporan siaga gejala klinis ternak dan konsultasi cepat bersama dokter hewan dinas terdekat di tingkat 38 kabupaten/kota.
                        </p>
                    </div>
                    <div class="pt-3.5 border-t border-indigo-100/60 w-full">
                        <a
                            href="{{ route('darurat') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-xs tracking-[0] leading-5 hover:underline group"
                        >
                            <span>Buka Siaga Darurat</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Feature 2: Transparansi Harga Pasar Harian -->
                <article class="flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] hover:shadow-md hover:border-purple-300 hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <div class="w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-[#eaddff] rounded-xl flex mb-4 sm:mb-5 text-[#712ae2]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug mb-2 sm:mb-2.5">
                            Transparansi Rujukan Harga Pasar
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed mb-4 sm:mb-5">
                            Pembaruan harian harga sapi potong, susu murni, kambing, dan telur langsung dari pasar hewan serta koperasi ternak se-Jawa Timur.
                        </p>
                    </div>
                    <div class="pt-3.5 border-t border-indigo-100/60 w-full">
                        <a
                            href="{{ route('harga-komoditas') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-[#712ae2] text-xs tracking-[0] leading-5 hover:underline group"
                        >
                            <span>Pantau Harga Harian</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Feature 3: Bimtek Pakan & Sertifikasi NKV -->
                <article class="flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] hover:shadow-md hover:border-teal-300 hover:-translate-y-1 transition-all duration-300 md:col-span-2 lg:col-span-1">
                    <div>
                        <div class="w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-[#e0f7fa] rounded-xl flex mb-4 sm:mb-5 text-[#005a6a]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug mb-2 sm:mb-2.5">
                            Bimtek Pakan &amp; Sertifikasi NKV
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed mb-4 sm:mb-5">
                            Kurikulum formulasi silase mandiri biomassa lokal serta bimbingan audit sanitasi kandang untuk pemenuhan sertifikat Nomor Kontrol Veteriner.
                        </p>
                    </div>
                    <div class="pt-3.5 border-t border-indigo-100/60 w-full">
                        <a
                            href="{{ route('pelatihan') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-[#005a6a] text-xs tracking-[0] leading-5 hover:underline group"
                        >
                            <span>Jadwal Bimtek Terbuka</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- 5. TeamAnalyticsShowcaseSection: PERTUMBUHAN & STATISTIK (Responsive Layout) -->
    <section id="pertumbuhan" class="flex w-full flex-col items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-[#faf8ff]">
        <div class="max-w-[1120px] mx-auto w-full">
            <div class="relative flex w-full flex-col items-start gap-8 sm:gap-10 lg:gap-12 rounded-2xl sm:rounded-3xl bg-[#eaedff] p-5 sm:p-7 md:p-9 lg:p-12 border border-indigo-100 shadow-[0px_4px_6px_-4px_#0000001a,0px_10px_15px_-3px_#0000001a] overflow-hidden">
                
                <!-- Ambient Subtle Glow Circles -->
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-[#8a4cfc20] rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center w-full">
                    
                    <!-- Left: Copy & Getting Started CTA -->
                    <div class="lg:col-span-7 flex flex-col items-start gap-3.5 sm:gap-4.5">
                        
                        <div class="inline-flex items-center gap-1.5 rounded-full bg-white px-2.5 sm:px-3 py-1 shadow-[0px_1px_2px_#0000000d]">
                            <svg class="w-3 h-3 text-[#2a14b4]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                            <p class="[font-family:'Inter',sans-serif] text-[10px] sm:text-[11px] font-semibold tracking-[0] text-[#2a14b4] whitespace-nowrap">
                                Fast Setup &amp; Zero Complexity
                            </p>
                        </div>

                        <div class="w-full">
                            <h2 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold leading-tight sm:leading-[1.2] tracking-[-0.8px] text-[#131b2e]">
                                Mulai Bersama Peternak Milenial
                                <br class="hidden sm:inline" />
                                Lebih Mudah dari Sebelumnya
                            </h2>
                        </div>

                        <div class="max-w-xl">
                            <p class="[font-family:'Inter',sans-serif] text-xs sm:text-sm md:text-[15px] font-normal leading-relaxed text-[#464554]">
                                Pendaftaran mandiri gratis tanpa syarat rumit. Terhubung langsung ke peta sentra ternak kabupaten/kota, rujukan harga harian pasar hewan, serta respons visitasi dokter dinas.
                            </p>
                        </div>

                        <div class="w-full sm:w-auto pt-1">
                            @auth
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg sm:rounded-xl bg-indigo-700 hover:bg-indigo-800 px-5 sm:px-7 py-3 sm:py-3.5 text-white font-semibold text-xs sm:text-sm shadow-[0px_6px_8px_-4px_#0000001a,0px_16px_20px_-4px_#0000001a] transition-all active:scale-[0.98] w-full sm:w-auto text-center"
                                >
                                    <span>Buka Dashboard Peternakan</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            @else
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg sm:rounded-xl bg-indigo-700 hover:bg-indigo-800 px-5 sm:px-7 py-3 sm:py-3.5 text-white font-semibold text-xs sm:text-sm shadow-[0px_6px_8px_-4px_#0000001a,0px_16px_20px_-4px_#0000001a] transition-all active:scale-[0.98] w-full sm:w-auto text-center"
                                >
                                    <span>Mulai Bergabung Sekarang</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            @endauth
                        </div>

                    </div>

                    <!-- Right: Live Platform Growth Visual Chart -->
                    <article class="lg:col-span-5 bg-white rounded-2xl p-4 sm:p-5 lg:p-6 shadow-[0px_2px_4px_-2px_#0000001a,0px_4px_6px_-1px_#0000001a] border border-slate-100 flex flex-col justify-between w-full">
                        <header class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-sm font-semibold text-[#131b2e]">
                                    Platform Growth &bull; Jatim
                                </h3>
                                <p class="text-[10px] sm:text-[11px] text-[#464554]">Populasi &amp; Kemitraan Aktif</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#e2e7ff] text-[#2a14b4] text-[10px] sm:text-[11px] font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#2a14b4] animate-pulse"></span>
                                Live Feed
                            </span>
                        </header>

                        <!-- Bar Graph matching chartBars (Fluid Height on mobile) -->
                        <div class="flex h-22 sm:h-28 items-end gap-1.5 sm:gap-2 md:gap-2.5 py-3 sm:py-4 px-1" role="img" aria-label="Platform growth chart showing rising adoption">
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-8 sm:h-11 bg-[#e2e7ff] transition-all duration-300 hover:bg-[#c3c0ff]" title="Bulan 1: Formulasi dasar"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-11 sm:h-16 bg-[#e2e7ff] transition-all duration-300 hover:bg-[#c3c0ff]" title="Bulan 2: Pelatihan awal"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-9 sm:h-13 bg-[#e2e7ff] transition-all duration-300 hover:bg-[#c3c0ff]" title="Bulan 3: Audit kandang"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-13 sm:h-19 bg-[#e2e7ff] transition-all duration-300 hover:bg-[#c3c0ff]" title="Bulan 4: Uji laboratorium"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-11 sm:h-16 bg-[#e2e7ff] transition-all duration-300 hover:bg-[#c3c0ff]" title="Bulan 5: Sertifikasi NKV"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-16 sm:h-22 bg-[#c3c0ff] transition-all duration-300 hover:bg-indigo-600" title="Bulan 6: Rantai pasok pasar"></div>
                            <div class="flex-1 rounded-[4px_4px_0px_0px] h-20 sm:h-28 bg-indigo-700 shadow-md transition-all duration-300 hover:bg-indigo-800" title="Bulan 7: Kemandirian penuh"></div>
                        </div>

                        <div class="pt-2.5 border-t border-slate-100 text-center">
                            <p class="[font-family:'Inter',sans-serif] text-[11px] sm:text-xs font-normal text-[#464554] leading-snug">
                                Akselerasi siklus produksi &amp; kemandirian pakan di seluruh sentra daerah
                            </p>
                        </div>
                    </article>

                </div>

                <!-- Bottom 3 Statistics Cards (Grid: 1 col on mobile, 3 cols on tablet & desktop) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-5 w-full pt-1 sm:pt-2">
                    
                    <!-- Stat 1: 38 Kab/Kota -->
                    <article class="flex flex-col items-start rounded-xl sm:rounded-2xl bg-white shadow-[0px_1px_2px_#0000000d] p-4 sm:p-5 border border-slate-100">
                        <div class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-2xl sm:text-3xl lg:text-[38px] font-extrabold leading-tight tracking-[-0.8px] text-[#2a14b4]">
                            38 Wilayah
                        </div>
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-sm font-semibold text-[#131b2e] mt-1.5 mb-0.5">
                            Sentra Ternak Terpetakan
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] text-[11px] sm:text-xs text-[#464554]">
                            Mencakup seluruh 38 kabupaten &amp; kota se-Jawa Timur
                        </p>
                    </article>

                    <!-- Stat 2: 93% -->
                    <article class="flex flex-col items-start rounded-xl sm:rounded-2xl bg-white shadow-[0px_1px_2px_#0000000d] p-4 sm:p-5 border border-slate-100">
                        <div class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-2xl sm:text-3xl lg:text-[38px] font-extrabold leading-tight tracking-[-0.8px] text-[#712ae2]">
                            93%
                        </div>
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-sm font-semibold text-[#131b2e] mt-1.5 mb-0.5">
                            Tingkat Kepuasan Peternak
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] text-[11px] sm:text-xs text-[#464554]">
                            Berdasarkan survei pendampingan teknis lapangan
                        </p>
                    </article>

                    <!-- Stat 3: 4.9 Rating -->
                    <article class="flex flex-col items-start rounded-xl sm:rounded-2xl bg-white shadow-[0px_1px_2px_#0000000d] p-4 sm:p-5 border border-slate-100">
                        <div class="inline-flex items-center gap-1.5">
                            <div class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-2xl sm:text-3xl lg:text-[38px] font-extrabold leading-tight tracking-[-0.8px] text-[#131b2e]">
                                4.9
                            </div>
                            <!-- 5 Stars SVG Container -->
                            <div class="flex items-center text-amber-400 gap-0.5">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-sm font-semibold text-[#131b2e] mt-1.5 mb-0.5">
                            Rating Layanan Publik
                        </h3>
                        <p class="[font-family:'Inter',sans-serif] text-[11px] sm:text-xs text-[#464554]">
                            Dari ribuan ulasan kelompok peternak rakyat
                        </p>
                    </article>

                </div>

            </div>
        </div>
    </section>

    <!-- 6. ProjectManagementFeaturesSection: WORKFLOW PROCESS (1, 2, 3 Steps - Responsive Grid) -->
    <section id="alur" class="flex flex-col w-full items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-white border-b border-indigo-100/60 shadow-[0px_1px_2px_#0000000d]">
        <div class="flex flex-col max-w-[1120px] mx-auto items-center gap-8 sm:gap-10 lg:gap-12 w-full">
            
            <header class="flex flex-col max-w-2xl items-center gap-1.5 sm:gap-2 text-center px-2">
                <div class="[font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-[11px] text-center tracking-[0.60px] leading-4 uppercase whitespace-nowrap">
                    WORKFLOW PROCESS
                </div>
                <div class="w-full">
                    <h2 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[#131b2e] text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]">
                        Alur Mudah Bergabung &amp; Berkembang
                    </h2>
                </div>
                <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] text-center leading-relaxed">
                    Tiga langkah terstruktur untuk meningkatkan produktivitas kandang dan terhubung ke rantai pasok industri.
                </p>
            </header>

            <ol class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 lg:gap-7 w-full list-none m-0 p-0">
                
                <!-- Step 1 -->
                <li class="flex flex-col items-center p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 text-center hover:shadow-md hover:border-indigo-300 transition-all duration-300">
                    <div class="flex w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-indigo-700 text-white font-semibold text-base sm:text-lg rounded-full shadow-[0px_4px_6px_-1px_#0000001a] mb-4 sm:mb-5">
                        1
                    </div>
                    <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg leading-snug mb-1.5 sm:mb-2">
                        Daftarkan Usaha Ternak
                    </h3>
                    <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] leading-relaxed">
                        Registrasi cepat dalam 2 menit. Daftarkan lokasi sentra, estimasi populasi hewan, serta komoditas unggulan Anda.
                    </p>
                </li>

                <!-- Step 2 -->
                <li class="flex flex-col items-center p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 text-center hover:shadow-md hover:border-purple-300 transition-all duration-300">
                    <div class="flex w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-[#712ae2] text-white font-semibold text-base sm:text-lg rounded-full shadow-[0px_4px_6px_-1px_#0000001a] mb-4 sm:mb-5">
                        2
                    </div>
                    <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg leading-snug mb-1.5 sm:mb-2">
                        Verifikasi &amp; Pembinaan Mutu
                    </h3>
                    <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] leading-relaxed">
                        Dapatkan pendampingan dokter dinas, bimbingan formulasi pakan silase mandiri, dan audit sanitasi standar NKV.
                    </p>
                </li>

                <!-- Step 3 -->
                <li class="flex flex-col items-center p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 text-center hover:shadow-md hover:border-teal-300 transition-all duration-300">
                    <div class="flex w-10 sm:w-11 h-10 sm:h-11 items-center justify-center bg-[#005a6a] text-white font-semibold text-base sm:text-lg rounded-full shadow-[0px_4px_6px_-1px_#0000001a] mb-4 sm:mb-5">
                        3
                    </div>
                    <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg leading-snug mb-1.5 sm:mb-2">
                        Akses Pasar &amp; Sukses Mandiri
                    </h3>
                    <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] leading-relaxed">
                        Pantau pembaruan rujukan harga harian dan pasarkan produk olahan atau ternak hidup langsung ke pembeli industri tanpa calo.
                    </p>
                </li>

            </ol>
        </div>
    </section>

    <!-- 7. CustomerTestimonialsSection: USER ENDORSEMENTS (With Responsive Photography Cards) -->
    <section id="testimoni" class="flex flex-col w-full items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-[#faf8ff] border-b border-indigo-100/60">
        <div class="flex flex-col max-w-[1120px] mx-auto items-center gap-8 sm:gap-10 lg:gap-12 w-full">
            
            <header class="flex flex-col max-w-2xl items-center gap-1.5 sm:gap-2 text-center px-2">
                <div class="[font-family:'Inter',sans-serif] font-semibold text-[#712ae2] text-[11px] text-center tracking-[0.60px] leading-4 uppercase whitespace-nowrap">
                    USER ENDORSEMENTS
                </div>
                <div class="w-full">
                    <h2 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[#131b2e] text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]">
                        Kisah Sukses Peternak Muda
                        <br class="hidden sm:inline" />
                        Binaan Jawa Timur
                    </h2>
                </div>
                <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] text-center leading-relaxed">
                    Testimoni nyata dari pelaku usaha peternakan yang menerapkan pencatatan digital, pakan mandiri, dan sertifikasi dinas.
                </p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6 w-full">
                
                <!-- Testimonial 1: Slamet Riyadi (Malang) -->
                <article class="flex flex-col justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_2px_4px_-2px_#0000001a,0px_4px_6px_-1px_#0000001a] border border-indigo-100/60 hover:shadow-lg transition-all duration-300">
                    <div>
                        <!-- Existing Farmer Photography -->
                        <div class="relative w-full h-36 sm:h-44 md:h-48 rounded-xl overflow-hidden bg-slate-100 mb-4 sm:mb-5 group">
                            <img
                                src="{{ asset('img/peternakan2.webp') }}"
                                alt="Slamet Riyadi Peternakan Domba Malang"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                            <div class="absolute bottom-2 sm:bottom-2.5 left-2 sm:left-2.5 bg-[#131b2e]/85 backdrop-blur-sm text-white px-2 sm:px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold">
                                Efisiensi Pakan +28%
                            </div>
                        </div>

                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg md:text-xl tracking-[0] leading-snug mb-2 sm:mb-2.5">
                            &ldquo;Formula Pakan Murah, Kenaikan Bobot Harian Terukur&rdquo;
                        </h3>

                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] tracking-[0] leading-relaxed mb-4 sm:mb-5">
                            Dulu kami kesulitan mengatur formula pakan yang murah tapi berbobot. Sejak mengikuti bimbingan silase biomassa mandiri dan pendampingan recording dari dinas, kenaikan bobot harian ternak naik konsisten 180 gram per hari.
                        </p>
                    </div>

                    <!-- Author Identity Strip -->
                    <footer class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-full bg-indigo-700 text-white [font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-sm sm:text-base flex items-center justify-center shrink-0">
                            SR
                        </div>
                        <div class="flex flex-col">
                            <div class="[font-family:'Inter',sans-serif] font-semibold text-[#131b2e] text-xs sm:text-sm leading-tight">
                                Slamet Riyadi
                            </div>
                            <div class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-[11px] sm:text-xs leading-tight mt-0.5">
                                Ketua Kelompok Ternak Mandiri &bull; Malang
                            </div>
                        </div>
                    </footer>
                </article>

                <!-- Testimonial 2: Siti Rahmawati (Blitar) -->
                <article class="flex flex-col justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_2px_4px_-2px_#0000001a,0px_4px_6px_-1px_#0000001a] border border-indigo-100/60 hover:shadow-lg transition-all duration-300">
                    <div>
                        <!-- Existing Farmer Photography -->
                        <div class="relative w-full h-36 sm:h-44 md:h-48 rounded-xl overflow-hidden bg-slate-100 mb-4 sm:mb-5 group">
                            <img
                                src="{{ asset('img/peternakan1.jpeg') }}"
                                alt="Siti Rahmawati Peternakan Ayam Petelur Blitar"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                            <div class="absolute bottom-2 sm:bottom-2.5 left-2 sm:left-2.5 bg-emerald-800/85 backdrop-blur-sm text-white px-2 sm:px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold">
                                Sertifikasi Higienitas NKV
                            </div>
                        </div>

                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg md:text-xl tracking-[0] leading-snug mb-2 sm:mb-2.5">
                            &ldquo;Sertifikasi Higienitas NKV Membuka Akses Pasar Ritel&rdquo;
                        </h3>

                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[14.5px] tracking-[0] leading-relaxed mb-4 sm:mb-5">
                            Sertifikasi sanitasi kandang dan transparansi harga pasar harian membuat telur dari peternakan kami langsung diserap pasar ritel dan horeka. Tidak ada lagi kekhawatiran dipermainkan tengkulak saat masa panen tiba.
                        </p>
                    </div>

                    <!-- Author Identity Strip -->
                    <footer class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 sm:w-10 h-9 sm:h-10 rounded-full bg-[#712ae2] text-white [font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-sm sm:text-base flex items-center justify-center shrink-0">
                            SR
                        </div>
                        <div class="flex flex-col">
                            <div class="[font-family:'Inter',sans-serif] font-semibold text-[#131b2e] text-xs sm:text-sm leading-tight">
                                Siti Rahmawati
                            </div>
                            <div class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-[11px] sm:text-xs leading-tight mt-0.5">
                                Blitar Layer Farm &bull; Blitar
                            </div>
                        </div>
                    </footer>
                </article>

            </div>
        </div>
    </section>

    <!-- 7.5 Bagian Pendaftaran untuk Masyarakat Umum (Konsumen & Publik) -->
    <section id="masyarakat" class="flex flex-col w-full items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-white border-b border-indigo-100/60 shadow-[0px_1px_2px_#0000000d]">
        <div class="flex flex-col max-w-[1120px] mx-auto items-center gap-8 sm:gap-10 w-full">
            
            <header class="flex flex-col max-w-2xl items-center gap-1.5 sm:gap-2 text-center px-2">
                <span class="[font-family:'Inter',sans-serif] font-semibold text-emerald-700 bg-emerald-50 px-2.5 sm:px-3 py-0.5 rounded-full border border-emerald-100 text-[11px] tracking-wide">
                    LAYANAN PUBLIK TERBUKA
                </span>
                <div class="w-full">
                    <h2 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[#131b2e] text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]">
                        Pendaftaran Akun Masyarakat Umum &amp; Konsumen
                    </h2>
                </div>
                <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] text-center leading-relaxed">
                    Beli daging sapi, telur segar, dan susu langsung dari kandang binaan terverifikasi tanpa syarat kepemilikan usaha peternakan.
                </p>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 w-full">
                
                <div class="p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] flex flex-col justify-between hover:shadow-md hover:border-emerald-300 transition-all duration-300">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25c-.669 0-1.189-.578-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-base sm:text-lg font-bold text-[#131b2e] mb-1.5 leading-snug">Belanja Langsung Peternak</h3>
                        <p class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] text-[#464554] leading-relaxed mb-4 sm:mb-5">
                            Dapatkan komoditas hewani segar berstandar sanitasi NKV langsung dari tangan peternak rakyat dengan jaminan kualitas ASUH (Aman, Sehat, Utuh, Halal).
                        </p>
                    </div>
                    <a href="{{ route('marketplace') }}" class="text-xs font-semibold text-emerald-700 hover:underline inline-flex items-center gap-1">
                        <span>Buka Marketplace Komoditas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                <div class="p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] flex flex-col justify-between hover:shadow-md hover:border-amber-300 transition-all duration-300">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-base sm:text-lg font-bold text-[#131b2e] mb-1.5 leading-snug">Transparansi Rujukan Harian</h3>
                        <p class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] text-[#464554] leading-relaxed mb-4 sm:mb-5">
                            Pantau harga resmi harian komoditas hewani dari pasar hewan di 38 kabupaten/kota se-Jatim untuk kebutuhan belanja rumah tangga atau wirausaha kuliner.
                        </p>
                    </div>
                    <a href="{{ route('harga-komoditas') }}" class="text-xs font-semibold text-amber-700 hover:underline inline-flex items-center gap-1">
                        <span>Pantau Rujukan Harga Harian</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                <div class="p-5 sm:p-6 lg:p-7 bg-[#faf8ff] rounded-2xl border border-indigo-100/60 shadow-[0px_1px_2px_#0000000d] flex flex-col justify-between hover:shadow-md hover:border-blue-300 transition-all duration-300 sm:col-span-2 lg:col-span-1">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#013a85] flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-base sm:text-lg font-bold text-[#131b2e] mb-1.5 leading-snug">Pameran &amp; Festival Ternak</h3>
                        <p class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] text-[#464554] leading-relaxed mb-4 sm:mb-5">
                            Lihat kalender pameran peternakan daerah, festival kontes ternak unggul, dan edukasi konsumsi protein hewani terbuka bagi seluruh keluarga.
                        </p>
                    </div>
                    <a href="{{ route('pameran') }}" class="text-xs font-semibold text-[#013a85] hover:underline inline-flex items-center gap-1">
                        <span>Jadwal Agenda Publik</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

            </div>

            <!-- Callout Action Card for Public Users (Responsive Stack) -->
            <div class="w-full rounded-2xl sm:rounded-3xl bg-gradient-to-r from-emerald-800 to-teal-800 p-5 sm:p-7 lg:p-8 text-white shadow-lg flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-white/15 text-[11px] font-semibold mb-1.5">
                        Tanpa Syarat Kepemilikan Ternak
                    </span>
                    <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] text-lg sm:text-xl md:text-2xl font-bold leading-snug">
                        Daftar Akun Masyarakat
                    </h3>
                    <p class="text-emerald-100/90 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                        Mulai berbelanja langsung komoditas segar dan pantau informasi harga tanpa perlu memiliki usaha peternakan.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 shrink-0 w-full lg:w-auto">
                    <a
                        href="{{ route('register', ['role' => 'umum']) }}"
                        class="px-5 py-3 rounded-lg bg-white text-emerald-800 font-bold text-xs sm:text-sm hover:bg-emerald-50 transition-colors shadow-sm text-center"
                    >
                        Daftar Akun Masyarakat
                    </a>
                    <a
                        href="{{ route('marketplace') }}"
                        class="px-4.5 py-3 rounded-lg bg-white/10 text-white font-semibold text-xs sm:text-sm hover:bg-white/20 border border-white/20 transition-colors text-center"
                    >
                        Jelajahi Produk
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 8. FrequentlyAskedQuestionsSection: COMMON QUERIES (Responsive 2x2 Grid + Aside) -->
    <section
        id="faq"
        aria-labelledby="faq-heading"
        class="flex flex-col w-full items-start px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 lg:py-20 bg-[#faf8ff] border-b border-indigo-100/60"
    >
        <div class="flex flex-col max-w-[1120px] mx-auto items-center gap-8 sm:gap-10 lg:gap-12 w-full">
            
            <header class="flex flex-col max-w-2xl items-center gap-1.5 sm:gap-2 text-center px-2">
                <div class="[font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-[11px] text-center tracking-[0.60px] leading-4 uppercase whitespace-nowrap">
                    COMMON QUERIES
                </div>
                <div class="w-full">
                    <h2
                        id="faq-heading"
                        class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-[#131b2e] text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]"
                    >
                        Frequently Asked Questions
                    </h2>
                </div>
                <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-sm md:text-[15px] text-center leading-relaxed">
                    Jawaban ringkas seputar tata cara pendaftaran akun, layanan dokter dinas gratis, dan rujukan pasar.
                </p>
            </header>

            <!-- 2x2 Grid of FAQ Articles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 w-full">
                
                <!-- FAQ 1 -->
                <article class="w-full flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col items-start gap-3 sm:gap-3.5 w-full">
                        <div class="flex items-start gap-2.5 sm:gap-3 w-full">
                            <span class="w-7 sm:w-8 h-7 sm:h-8 rounded-xl bg-[#e2e7ff] text-[#2a14b4] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01" />
                                </svg>
                            </span>
                            <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug">
                                Siapa saja yang berhak mendaftar di portal Peternak Milenial?
                            </h3>
                        </div>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed">
                            Seluruh pemuda, wirausaha pemula, kelompok peternak rakyat, serta pelaku UMKM olahan ternak yang berdomisili di 38 kabupaten/kota se-Jawa Timur dapat mendaftarkan akun secara mandiri tanpa pungutan biaya.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 w-full mt-3.5 sm:mt-4">
                        <a
                            href="#support"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-xs tracking-[0] leading-5 text-[#2a14b4] hover:underline"
                        >
                            <span>Click to learn more</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- FAQ 2 -->
                <article class="w-full flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col items-start gap-3 sm:gap-3.5 w-full">
                        <div class="flex items-start gap-2.5 sm:gap-3 w-full">
                            <span class="w-7 sm:w-8 h-7 sm:h-8 rounded-xl bg-[#eaddff] text-[#712ae2] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </span>
                            <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug">
                                Apakah layanan siaga darurat kesmavet dikenakan biaya?
                            </h3>
                        </div>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed">
                            Layanan pelaporan siaga tanggap darurat dan konsultasi penyakit ternak bersama dokter hewan dinas merupakan fasilitas pelayanan publik resmi dari Pemprov Jawa Timur dan sepenuhnya gratis 24 jam.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 w-full mt-3.5 sm:mt-4">
                        <a
                            href="{{ route('darurat') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-xs tracking-[0] leading-5 text-[#712ae2] hover:underline"
                        >
                            <span>Click to learn more</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- FAQ 3 -->
                <article class="w-full flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col items-start gap-3 sm:gap-3.5 w-full">
                        <div class="flex items-start gap-2.5 sm:gap-3 w-full">
                            <span class="w-7 sm:w-8 h-7 sm:h-8 rounded-xl bg-[#e0f7fa] text-[#005a6a] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </span>
                            <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug">
                                Bagaimana prosedur sertifikasi Nomor Kontrol Veteriner (NKV)?
                            </h3>
                        </div>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed">
                            Setelah akun terdaftar, peternak dapat mengajukan asesmen mandiri kesiapan sanitasi kandang melalui portal. Tim pembina mutu dinas akan melakukan visitasi lapangan dan bimbingan hingga sertifikat NKV diterbitkan.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 w-full mt-3.5 sm:mt-4">
                        <a
                            href="{{ route('pelatihan') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-xs tracking-[0] leading-5 text-[#005a6a] hover:underline"
                        >
                            <span>Click to learn more</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- FAQ 4 -->
                <article class="w-full flex flex-col items-start justify-between p-5 sm:p-6 lg:p-7 bg-white rounded-2xl shadow-[0px_1px_2px_#0000000d] border border-indigo-100/60 hover:shadow-md transition-all duration-300">
                    <div class="flex flex-col items-start gap-3 sm:gap-3.5 w-full">
                        <div class="flex items-start gap-2.5 sm:gap-3 w-full">
                            <span class="w-7 sm:w-8 h-7 sm:h-8 rounded-xl bg-[#e2e7ff] text-[#2a14b4] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </span>
                            <h3 class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-semibold text-[#131b2e] text-base sm:text-lg tracking-[0] leading-snug">
                                Dari mana sumber data rujukan harga pasar harian?
                            </h3>
                        </div>
                        <p class="[font-family:'Inter',sans-serif] font-normal text-[#464554] text-xs sm:text-[13.5px] tracking-[0] leading-relaxed">
                            Data harga harian dihimpun setiap pagi oleh petugas pencatat harga dinas langsung dari pasar-pasar hewan utama dan koperasi peternak di seluruh 38 kabupaten/kota di Jawa Timur.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 w-full mt-3.5 sm:mt-4">
                        <a
                            href="{{ route('harga-komoditas') }}"
                            class="inline-flex items-center gap-1.5 [font-family:'Inter',sans-serif] font-semibold text-xs tracking-[0] leading-5 text-[#2a14b4] hover:underline"
                        >
                            <span>Click to learn more</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </article>

            </div>

            <!-- Albino Support Aside Banner (Responsive Layout) -->
            <aside
                id="support"
                class="flex flex-col items-center justify-center p-4 sm:p-5 w-full bg-[#eaedff] rounded-2xl border border-indigo-100/60"
            >
                <div class="flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2 text-center">
                    <span class="[font-family:'Inter',sans-serif] font-normal text-[#131b2e] text-xs sm:text-sm tracking-[0] leading-snug">
                        Belum menemukan jawaban Anda?
                    </span>
                    <a
                        href="mailto:disnak@jatimprov.go.id"
                        class="[font-family:'Inter',sans-serif] font-semibold text-[#2a14b4] text-xs sm:text-sm hover:underline"
                    >
                        Hubungi posko siaga dinas sekarang (0800-1-DARURAT)
                    </a>
                </div>
            </aside>

        </div>
    </section>

    <!-- 9. LandingPageCallToActionSection: HIGH-IMPACT CIVIC BANNER (Fully Responsive Across All Screens) -->
    <section
        class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 bg-[#faf8ff]"
        aria-labelledby="landing-page-cta-title"
    >
        <div class="max-w-[1120px] mx-auto w-full">
            <div class="px-5 sm:px-8 md:px-12 lg:px-16 py-10 sm:py-12 lg:py-16 relative bg-[#283044] rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0px_25px_50px_-12px_#00000040] flex flex-col items-center text-center">
                
                <!-- Ambient Spheres Blur from Albino Design -->
                <div
                    class="absolute -top-32 -left-32 w-72 h-72 bg-[#8a4cfc33] rounded-full blur-[48px] pointer-events-none"
                    aria-hidden="true"
                ></div>
                <div
                    class="absolute -right-32 -bottom-32 w-72 h-72 bg-[#005a6a4c] rounded-full blur-[48px] pointer-events-none"
                    aria-hidden="true"
                ></div>

                <div class="flex flex-col max-w-2xl items-center gap-3.5 sm:gap-5 relative z-10">
                    
                    <span class="inline-block px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-white/10 text-[11px] sm:text-xs font-semibold text-indigo-200 border border-white/15">
                        Program Pembinaan Terpadu Dinas Peternakan Jatim
                    </span>

                    <h2
                        id="landing-page-cta-title"
                        class="[font-family:'Plus_Jakarta_Sans',sans-serif] font-bold text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl text-center tracking-[-0.8px] leading-tight sm:leading-[1.2]"
                    >
                        Wujudkan Peternakan Tangguh &amp; Modern di Jawa Timur
                    </h2>

                    <p class="[font-family:'Inter',sans-serif] font-normal text-[#dae2fdcc] text-xs sm:text-sm md:text-[15px] text-center tracking-[0] leading-relaxed">
                        Daftarkan kelompok atau unit usaha peternakan Anda sekarang untuk mendapatkan akses bimbingan teknis, pengawasan medis 24 jam, dan integrasi pasar daerah.
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 sm:gap-3.5 w-full sm:w-auto pt-1 sm:pt-3">
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-5 sm:px-7 py-3 sm:py-3.5 bg-[#dae2fd] hover:bg-[#c3cffc] text-[#283044] rounded-lg font-semibold text-xs sm:text-sm transition-colors duration-200 active:scale-[0.98] text-center"
                        >
                            Masuk ke Portal
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-lg font-semibold text-xs sm:text-sm shadow-[0px_8px_10px_-6px_#0000001a,0px_20px_25px_-5px_#0000001a] transition-all duration-200 active:scale-[0.98] group text-center"
                        >
                            <span>Daftar Akun Sekarang</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- 10. FooterNavigationSection: FULL GRID FOOTER (Responsive Multi-Column) -->
    <footer class="flex w-full flex-col items-start bg-[#f2f3ff] px-4 sm:px-6 md:px-8 lg:px-12 py-10 sm:py-12 pb-[calc(2.5rem+env(safe-area-inset-bottom,0px))] border-t border-indigo-100/70">
        <div class="max-w-[1120px] mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10">
                
                <!-- Brand Profile & Identity (Cols 1-4) -->
                <div class="lg:col-span-4 flex flex-col items-start gap-2.5 sm:gap-3.5">
                    <img
                        class="h-8 sm:h-9 w-auto object-contain"
                        alt="Peternak Milenial Logo"
                        src="{{ asset('img/Peternak Milenial.png') }}"
                    />
                    <p class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] font-normal leading-relaxed text-[#464554] max-w-sm">
                        Portal resmi Pemerintah Provinsi Jawa Timur melalui Dinas Peternakan untuk membina wirausaha muda peternakan dan menjamin kedaulatan pangan hewani berkelanjutan di 38 kabupaten/kota.
                    </p>
                    <div class="pt-1 text-[11px] sm:text-xs text-slate-500">
                        <p class="font-semibold text-slate-700">Kantor Dinas Peternakan Provinsi Jatim</p>
                        <p>Jl. Jenderal Ahmad Yani No. 202, Gayungan, Surabaya, Jawa Timur 60235</p>
                    </div>
                    <p class="pt-1 text-[11px] sm:text-xs text-slate-400">
                        &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Hak Cipta Dilindungi.
                    </p>
                </div>

                <!-- 4 Link Navigation Columns (Cols 5-12, 2 cols on mobile, 4 cols on tablet & desktop) -->
                <nav class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-5 sm:gap-6" aria-label="Footer navigation">
                    
                    <!-- Col 1: Layanan Peternak -->
                    <div class="flex flex-col items-start gap-2 sm:gap-2.5">
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] font-semibold leading-5 text-[#131b2e]">
                            Layanan Peternak
                        </h3>
                        <ul class="flex flex-col items-start gap-1 sm:gap-1.5 text-[11px] sm:text-xs text-[#464554]">
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('darurat') }}">Siaga Darurat 24 Jam</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('pelatihan') }}">Bimtek &amp; Pelatihan</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('marketplace') }}">Pasar Komoditas</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('pameran') }}">Pameran Peternakan</a></li>
                        </ul>
                    </div>

                    <!-- Col 2: Data & Rujukan -->
                    <div class="flex flex-col items-start gap-2 sm:gap-2.5">
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] font-semibold leading-5 text-[#131b2e]">
                            Data &amp; Rujukan
                        </h3>
                        <ul class="flex flex-col items-start gap-1 sm:gap-1.5 text-[11px] sm:text-xs text-[#464554]">
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('harga-komoditas') }}">Rujukan Harga Harian</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="#pertumbuhan">Peta Sentra Daerah</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="#alur">Standarisasi NKV</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('search') }}">Pencarian Sentra</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Akses Akun -->
                    <div class="flex flex-col items-start gap-2 sm:gap-2.5">
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] font-semibold leading-5 text-[#131b2e]">
                            Akses Akun
                        </h3>
                        <ul class="flex flex-col items-start gap-1 sm:gap-1.5 text-[11px] sm:text-xs text-[#464554]">
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('login') }}">Masuk Akun</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('register') }}">Pendaftaran Peternak</a></li>
                            <li><a class="hover:text-emerald-700 font-medium transition-colors" href="{{ route('register', ['role' => 'umum']) }}">Pendaftaran Masyarakat</a></li>
                            <li><a class="hover:text-[#2a14b4] transition-colors" href="{{ route('dashboard') }}">Dashboard Sistem</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: Posko Dinas -->
                    <div class="flex flex-col items-start gap-2 sm:gap-2.5">
                        <h3 class="[font-family:'Inter',sans-serif] text-xs sm:text-[13px] font-semibold leading-5 text-[#131b2e]">
                            Bantuan &amp; Kontak
                        </h3>
                        <ul class="flex flex-col items-start gap-1 sm:gap-1.5 text-[11px] sm:text-xs text-[#464554]">
                            <li>Posko: <span class="font-bold text-[#2a14b4] block">0800-1-DARURAT</span></li>
                            <li>Email: <a href="mailto:disnak@jatimprov.go.id" class="hover:underline truncate block">disnak@jatimprov.go.id</a></li>
                            <li>Jam Kerja: <span class="text-[10px] sm:text-[11px] text-slate-500 block">Senin–Jumat 07.30–16.00</span></li>
                        </ul>
                    </div>

                </nav>

            </div>
        </div>
    </footer>

    <!-- Interactive Client Scripts -->
    <script>
        // Accessible Mobile Drawer Menu Toggle with Backdrop & Icon Sync
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

        // Close on Escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Close mobile drawer when resizing back to desktop screen width
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>

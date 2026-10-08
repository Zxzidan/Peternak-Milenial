<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peternak Milenial Jatim — Portal Resmi Dinas Peternakan Provinsi Jawa Timur</title>

    <!-- Google Fonts: Outfit (Editorial Grotesque) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-primary: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --brand-navy: #013a85;
            --brand-cyan: #009fd2;
            --brand-green: #209527;
            --brand-gold: #fbbb03;
        }

        body {
            font-family: var(--font-primary);
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        /* Subtle tactile grain overlay */
        .bg-grain {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.035'/%3E%3C/svg%3E");
        }

        /* Double-bezel haptic container technique */
        .double-bezel {
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.03), 0 10px 25px -5px rgba(1, 58, 133, 0.04);
        }

        .double-bezel:hover {
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 20px 35px -10px rgba(1, 58, 133, 0.08);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 selection:bg-[#013a85] selection:text-white flex flex-col min-h-screen relative overflow-x-hidden bg-grain">

    <!-- 1. Floating Fluid Navigation Bar -->
    <div class="fixed top-3 sm:top-5 left-0 right-0 z-50 px-3 sm:px-6 flex justify-center pointer-events-none">
        <header class="w-full max-w-6xl bg-white/95 backdrop-blur-md border border-slate-200/90 rounded-2xl sm:rounded-full px-4 sm:px-6 py-2.5 shadow-sm shadow-slate-900/5 flex items-center justify-between pointer-events-auto transition-all">
            
            <!-- Left: Official Logo with Provincial Context -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 shrink-0 group" title="Peternak Milenial Jawa Timur">
                <img
                    src="{{ asset('img/logoaplikasi2.png') }}"
                    alt="Peternak Milenial Jawa Timur Logo"
                    class="h-11 sm:h-12 md:h-[50px] w-auto object-contain transition-transform duration-300 group-hover:scale-[1.02]"
                />
            </a>

            <!-- Center: Editorial Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-[13.5px] font-medium tracking-tight text-slate-600">
                <a href="#tentang" class="hover:text-[#013a85] transition-colors py-1">Tentang Platform</a>
                <a href="#layanan" class="hover:text-[#013a85] transition-colors py-1">Ekosistem Layanan</a>
                <a href="#dampak" class="hover:text-[#013a85] transition-colors py-1">Kisah Sukses</a>
                <a href="#faq" class="hover:text-[#013a85] transition-colors py-1">Pusat Informasi</a>
            </nav>

            <!-- Right: Action Buttons (Desktop & Tablet) -->
            <div class="hidden sm:flex items-center gap-2.5">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-[#013a85] hover:bg-blue-900 text-white shadow-xs transition-all duration-200 active:scale-[0.98]"
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
                        class="inline-flex items-center px-4 py-2 rounded-full text-xs sm:text-sm font-medium text-slate-700 hover:text-[#013a85] hover:bg-slate-100/70 transition-all duration-200"
                    >
                        Masuk
                    </a>
                    <a
                        href="{{ route('register') }}"
                        id="nav-login-btn"
                        class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-[#013a85] hover:bg-blue-900 text-white shadow-xs shadow-blue-950/20 transition-all duration-200 active:scale-[0.98]"
                    >
                        <span>Daftar Akun</span>
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Toggle -->
            <div class="flex sm:hidden items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-full text-xs font-semibold bg-[#013a85] text-white">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-full text-xs font-semibold text-slate-700 border border-slate-200">
                        Masuk
                    </a>
                @endauth
                <button
                    type="button"
                    onclick="toggleMobileMenu()"
                    aria-label="Buka Menu Navigasi"
                    class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none"
                >
                    <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

        </header>

        <!-- Mobile Drawer Menu Dropdown -->
        <div id="mobile-menu" class="hidden absolute top-16 left-3 right-3 bg-white border border-slate-200 rounded-2xl p-4 shadow-xl pointer-events-auto space-y-3 sm:hidden transition-all duration-300">
            <nav class="flex flex-col space-y-2 text-sm font-medium text-slate-700">
                <a href="#tentang" onclick="closeMobileMenu()" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-[#013a85]">Tentang Platform</a>
                <a href="#layanan" onclick="closeMobileMenu()" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-[#013a85]">Ekosistem Layanan</a>
                <a href="#dampak" onclick="closeMobileMenu()" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-[#013a85]">Kisah Sukses</a>
                <a href="#faq" onclick="closeMobileMenu()" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-[#013a85]">Pusat Informasi</a>
            </nav>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl text-xs font-bold bg-[#013a85] text-white">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl text-xs font-bold bg-[#013a85] text-white">
                        Daftar Akun Peternak
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- 2. Hero Section: Editorial Split with Macro Spacing & Grounded Photography -->
    <section id="tentang" class="relative pt-32 pb-16 sm:pt-40 sm:pb-24 border-b border-slate-200/70 overflow-hidden bg-white">
        
        <!-- Architectural ambient glow (Strict brand colors, non-distracting) -->
        <div class="absolute top-0 right-1/4 w-[500px] h-[350px] bg-blue-50/70 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-32 left-1/3 w-[300px] h-[300px] bg-emerald-50/50 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left: Focused Editorial Narrative -->
                <div class="lg:col-span-7">
                    
                    <!-- Official Institutional Tag -->
                   

                    <!-- 2-Line High-Impact Headline (No messy cursive, pure editorial confidence) -->
                    <h1 class="text-3xl sm:text-5xl lg:text-5.5xl font-extrabold text-slate-900 tracking-tight leading-[1.12] mb-6">
                        Pemberdayaan Digital 
                        <span class="text-[#013a85] inline-block">Peternak Muda</span>
                        Jawa Timur
                    </h1>

                    <!-- Concise, Meaningful Value Proposition -->
                    <p class="text-base sm:text-lg text-slate-600 max-w-xl leading-relaxed mb-8 font-normal">
                        Ekosistem satu pintu untuk memetakan sentra ternak, siaga tanggap darurat kesmavet 24 jam, standardisasi mutu pakan modern, dan transparansi harga pasar di 38 kabupaten/kota.
                    </p>

                    <!-- Primary & Secondary CTAs with Button-in-Button Architecture -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 mb-10">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center gap-3 px-7 py-3.5 rounded-full font-semibold text-sm text-white bg-[#013a85] hover:bg-blue-900 shadow-md shadow-blue-950/15 transition-all duration-200 active:scale-[0.98] group"
                            >
                                <span>Menuju Dashboard Sistem</span>
                                <span class="w-6 h-6 rounded-full bg-white/15 flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </span>
                            </a>
                        @else
                            <a
                                href="{{ route('register') }}"
                                id="hero-daftar-btn"
                                class="inline-flex items-center justify-center gap-3 px-7 py-3.5 rounded-full font-semibold text-sm text-white bg-[#013a85] hover:bg-blue-900 shadow-md shadow-blue-950/15 transition-all duration-200 active:scale-[0.98] group"
                            >
                                <span>Daftar Akun Peternak</span>
                                <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:translate-x-0.5 transition-transform">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </span>
                            </a>

                            <a
                                href="{{ route('login') }}"
                                id="hero-masuk-btn"
                                class="inline-flex items-center justify-center px-6 py-3.5 rounded-full font-semibold text-sm text-slate-700 bg-white border border-slate-200/90 hover:bg-slate-50 hover:text-[#013a85] hover:border-slate-300 transition-all duration-200 active:scale-[0.98]"
                            >
                                <span>Masuk ke Portal</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right: Double-Bezel Framing of Real Regional Farm Production -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        
                        <!-- Outer machined shell -->
                        <div class="p-2 sm:p-2.5 rounded-3xl bg-slate-100/90 border border-slate-200/90 shadow-xl shadow-slate-900/5">
                            <!-- Inner image core -->
                            <div class="relative h-80 sm:h-96 lg:h-[420px] rounded-[calc(1.5rem-2px)] overflow-hidden bg-slate-200 group">
                                <img
                                    src="{{ asset('img/peternakan2.webp') }}"
                                    alt="Peternak Muda Ruminansia Binaan Dinas Peternakan Jawa Timur"
                                    class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-700 ease-out"
                                    loading="eager"
                                />
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Grounded Impact Metrics Strip (Real System Database Statistics) -->
    <section class="py-10 bg-slate-50 border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 divide-y sm:divide-y-0 sm:divide-x divide-slate-200/80">
                
                <div class="pt-4 sm:pt-0 sm:px-4 first:pl-0">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $regionCount ?: 38 }}
                    </p>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-1">
                        Kabupaten &amp; Kota Terhubung
                    </p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <p class="text-2xl sm:text-3xl font-extrabold text-[#013a85] tracking-tight">
                        {{ $centerCount ?: 12 }}
                    </p>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-1">
                        Sentra Komoditas Ternak
                    </p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">
                        {{ $commodityCount ?: 8 }}
                    </p>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-1">
                        Komoditas Unggulan Terdata
                    </p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $activeTrainingsCount ?: 4 }}
                    </p>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-1">
                        Agenda Bimtek &amp; Pelatihan
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Ekosistem Layanan Utama (Asymmetrical Gapless Bento Grid) -->
    <section id="layanan" class="py-20 sm:py-28 bg-white border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="max-w-2xl mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-[#013a85]">Fasilitas Publik Terpadu</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1.5 leading-tight">
                    Empat Pilar Utama Pengembangan Peternak Muda
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2.5 leading-relaxed">
                    Setiap modul dirancang untuk mengatasi hambatan riil peternak di lapangan, dari pencegahan wabah hingga kepastian serapan pasar.
                </p>
            </div>

            <!-- Bento Grid: Gapless, Interlocking, Varied Visual Weight -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <!-- Bento 1: Featured Pillar (7 cols) - Kesmavet & Tanggap Darurat 24 Jam -->
                <div class="md:col-span-7 double-bezel rounded-3xl bg-slate-50/70 p-6 sm:p-8 flex flex-col justify-between group transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="w-10 h-10 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-100/70 text-red-700">
                                Respons Cepat 24 Jam
                            </span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight group-hover:text-[#013a85] transition-colors mb-3">
                            Posko Darurat Kesmavet &amp; Rekam Medis Ternak
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Sistem pelaporan siaga untuk gejala klinis hewan ternak dan deteksi dini wabah. Terhubung langsung ke dokter hewan dinas terdekat di tingkat kabupaten/kota untuk visitasi dan penanganan cepat.
                        </p>
                    </div>

                    <!-- Mini UI Preview Card inside Bento -->
                    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs font-medium text-slate-700">Layanan Siaga Aktif Seluruh Sentra</span>
                        </div>
                        <a href="{{ route('darurat') }}" class="text-xs font-bold text-[#013a85] hover:underline flex items-center gap-1">
                            <span>Buka Siaga</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Bento 2: Secondary Pillar (5 cols) - Transparansi Harga Pasar Harian -->
                <div class="md:col-span-5 double-bezel rounded-3xl bg-white p-6 sm:p-8 flex flex-col justify-between group transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                Data Harian Riil
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight group-hover:text-[#013a85] transition-colors mb-2.5">
                            Transparansi Harga Pasar
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                            Pembaruan harian harga sapi potong, susu segar, kambing, dan telur langsung dari pasar hewan serta sentra produksi se-Jawa Timur untuk melindungi posisi tawar peternak rakyat.
                        </p>
                    </div>

                    <a href="{{ route('harga-komoditas') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#013a85] hover:text-blue-900 mt-2">
                        <span>Pantau Rujukan Harga Harian</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Bento 3: Secondary Pillar (5 cols) - Bimtek & Standardisasi Mutu NKV -->
                <div class="md:col-span-5 double-bezel rounded-3xl bg-white p-6 sm:p-8 flex flex-col justify-between group transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="w-10 h-10 rounded-2xl bg-blue-50 text-[#013a85] border border-blue-100 flex items-center justify-center font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-[#013a85] border border-blue-100">
                                Bersertifikat
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight group-hover:text-[#013a85] transition-colors mb-2.5">
                            Bimtek Pakan &amp; Sertifikasi NKV
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                            Kurikulum praktis formulasi pakan silase berbasis biomassa lokal dan pendampingan audit sanitasi kandang untuk pemenuhan sertifikat Nomor Kontrol Veteriner (NKV).
                        </p>
                    </div>

                    <a href="{{ route('pelatihan') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#013a85] hover:text-blue-900 mt-2">
                        <span>Lihat Jadwal Pelatihan Terbuka</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Bento 4: Featured Pillar (7 cols) - Marketplace & Akses Pasar Industri -->
                <div class="md:col-span-7 double-bezel rounded-3xl bg-slate-50/70 p-6 sm:p-8 flex flex-col justify-between group transition-all duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.651V9.35m0 0a3.001 3.001 0 003.75-.614A2.993 2.993 0 009 9.35c.71 0 1.373-.247 1.895-.664.522.417 1.185.664 1.895.664.71 0 1.373-.247 1.895-.664.522.417 1.185.664 1.895.664a3.001 3.001 0 003.75.614m-16.5 0L4.5 4.5h15l1.5 4.85" />
                                </svg>
                            </span>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Hilirisasi Produk
                            </span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight group-hover:text-[#013a85] transition-colors mb-3">
                            Kemitraan Pasar &amp; Marketplace Komoditas
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Kanal pemasaran langsung yang mempertemukan peternak rakyat dengan pembeli grosir, horeka, dan rantai pasok industri tanpa perantara yang merugikan.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-700">Daging Sapi, Domba, Susu Murni, dan Telur Segar</span>
                        <a href="{{ route('marketplace') }}" class="text-xs font-bold text-[#013a85] hover:underline flex items-center gap-1">
                            <span>Jelajahi Produk</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. Dokumentasi Lapangan & Cerita Sukses Peternak (Editorial Split Case Stories) -->
    <section id="dampak" class="py-20 sm:py-28 bg-slate-50 border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="max-w-2xl mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-[#013a85]">Dampak Nyata Lapangan</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1.5 leading-tight">
                    Transformasi Nyata Peternak Muda Jawa Timur
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2.5 leading-relaxed">
                    Pengalaman peternak binaan yang menerapkan pencatatan digital, sanitasi bersertifikat, dan efisiensi pakan mandiri.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Story 1: Slamet Riyadi - Ruminansia Domba Malang -->
                <div class="bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Author Metadata Strip -->
                        <div class="flex items-center gap-4 mb-6">
                            <img
                                src="{{ asset('img/peternakan2.webp') }}"
                                alt="Slamet Riyadi"
                                class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs shrink-0"
                            />
                            <div>
                                <h4 class="text-base font-bold text-slate-900 leading-snug">Slamet Riyadi</h4>
                                <p class="text-xs font-semibold text-[#013a85]">Kelompok Ternak Mandiri &bull; Malang</p>
                                <span class="inline-block mt-0.5 text-[11px] text-slate-500 font-medium">Binaan Sentra Ruminansia Pedaging</span>
                            </div>
                        </div>

                        <!-- Editorial Quote -->
                        <p class="text-slate-700 text-sm sm:text-base leading-relaxed">
                            &ldquo;Dulu kami kesulitan mengatur formula pakan yang murah tapi berbobot. Sejak mengikuti pelatihan silase biomassa mandiri dan pendampingan recording dari dinas, efisiensi pakan meningkat dan kenaikan bobot harian ternak kami konsisten naik 180 gram per hari. Usaha menjadi jauh lebih terukur.&rdquo;
                        </p>
                    </div>

                    <!-- Impact Badge -->
                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Hasil Implementasi:</span>
                        <span class="font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                            Efisiensi Pakan +28%
                        </span>
                    </div>
                </div>

                <!-- Story 2: Siti Rahmawati - Perunggasan Blitar -->
                <div class="bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Author Metadata Strip -->
                        <div class="flex items-center gap-4 mb-6">
                            <img
                                src="{{ asset('img/peternakan1.jpeg') }}"
                                alt="Siti Rahmawati"
                                class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs shrink-0"
                            />
                            <div>
                                <h4 class="text-base font-bold text-slate-900 leading-snug">Siti Rahmawati</h4>
                                <p class="text-xs font-semibold text-emerald-700">Blitar Layer Farm &bull; Blitar</p>
                                <span class="inline-block mt-0.5 text-[11px] text-slate-500 font-medium">Sertifikasi Higienitas NKV Level 1</span>
                            </div>
                        </div>

                        <!-- Editorial Quote -->
                        <p class="text-slate-700 text-sm sm:text-base leading-relaxed">
                            &ldquo;Sertifikasi sanitasi NKV dan respons siaga darurat membuat telur dari peternakan kami langsung dipercaya pasar ritel dan industri pangan. Tidak ada lagi kekhawatiran harga jatuh saat panen raya karena data harga pasar transparan setiap hari.&rdquo;
                        </p>
                    </div>

                    <!-- Impact Badge -->
                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Hasil Implementasi:</span>
                        <span class="font-bold text-[#013a85] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Mitra Ritel &amp; Horeka Resmi
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. Pusat Informasi & FAQ (Asymmetric 2-Column Architecture) -->
    <section id="faq" class="py-20 sm:py-28 bg-white border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left: Static Context & Support Call Card -->
                <div class="lg:col-span-5">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#013a85]">Bantuan &amp; Regulasi</span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1.5 leading-tight">
                        Pertanyaan Umum Peternak
                    </h2>
                    <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                        Jawaban ringkas seputar tata cara pendaftaran, layanan dokter hewan gratis, sertifikasi sanitasi kandang, dan rujukan pasar.
                    </p>

                    <!-- Contact Hotline Card -->
                    <div class="mt-8 p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <p class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Butuh Bantuan Mendesak?</p>
                        <p class="text-xs text-slate-500 mb-3 leading-relaxed">
                            Hubungi posko siaga kesehatan hewan atau tim pendampingan teknis dinas.
                        </p>
                        <div class="space-y-2 text-xs font-medium text-slate-700">
                            <div class="flex items-center justify-between py-1 border-b border-slate-200/60">
                                <span>Posko Kesmavet:</span>
                                <span class="font-bold text-[#013a85]">0800-1-DARURAT</span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span>Email Binaan:</span>
                                <a href="mailto:disnak@jatimprov.go.id" class="text-blue-600 hover:underline">disnak@jatimprov.go.id</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Clean Border-Divided Accordion List -->
                <div class="lg:col-span-7 divide-y divide-slate-200/80">
                    
                    <!-- FAQ Item 1 -->
                    <div class="py-5 first:pt-0">
                        <button
                            type="button"
                            onclick="toggleFaq(this)"
                            class="w-full text-left flex items-start justify-between gap-4 font-bold text-slate-900 hover:text-[#013a85] transition-colors"
                        >
                            <span class="text-base">Siapa saja yang berhak mendaftar di portal Peternak Milenial?</span>
                            <span class="faq-icon text-xl text-slate-400 font-normal shrink-0 mt-0.5 transition-transform duration-200">+</span>
                        </button>
                        <div class="faq-content hidden mt-3 text-sm text-slate-600 leading-relaxed pr-6">
                            Seluruh pemuda, wirausaha pemula, kelompok peternak rakyat, serta pelaku UMKM olahan ternak yang berdomisili di 38 kabupaten/kota se-Jawa Timur dapat mendaftarkan akun secara mandiri tanpa pungutan biaya.
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="py-5">
                        <button
                            type="button"
                            onclick="toggleFaq(this)"
                            class="w-full text-left flex items-start justify-between gap-4 font-bold text-slate-900 hover:text-[#013a85] transition-colors"
                        >
                            <span class="text-base">Apakah layanan siaga darurat kesmavet dikenakan biaya?</span>
                            <span class="faq-icon text-xl text-slate-400 font-normal shrink-0 mt-0.5 transition-transform duration-200">+</span>
                        </button>
                        <div class="faq-content hidden mt-3 text-sm text-slate-600 leading-relaxed pr-6">
                            Layanan pelaporan siaga tanggap darurat dan konsultasi penyakit ternak bersama dokter hewan dinas merupakan fasilitas pelayanan publik resmi dari Pemerintah Provinsi Jawa Timur dan sepenuhnya gratis.
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="py-5">
                        <button
                            type="button"
                            onclick="toggleFaq(this)"
                            class="w-full text-left flex items-start justify-between gap-4 font-bold text-slate-900 hover:text-[#013a85] transition-colors"
                        >
                            <span class="text-base">Bagaimana prosedur pengajuan sertifikasi Nomor Kontrol Veteriner (NKV)?</span>
                            <span class="faq-icon text-xl text-slate-400 font-normal shrink-0 mt-0.5 transition-transform duration-200">+</span>
                        </button>
                        <div class="faq-content hidden mt-3 text-sm text-slate-600 leading-relaxed pr-6">
                            Setelah akun terdaftar, peternak dapat mengajukan asesmen mandiri kesiapan sanitasi kandang melalui portal. Tim pembina mutu dinas akan melakukan visitasi lapangan dan bimbingan hingga sertifikat NKV diterbitkan.
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="py-5">
                        <button
                            type="button"
                            onclick="toggleFaq(this)"
                            class="w-full text-left flex items-start justify-between gap-4 font-bold text-slate-900 hover:text-[#013a85] transition-colors"
                        >
                            <span class="text-base">Dari mana sumber data harga pasar harian komoditas?</span>
                            <span class="faq-icon text-xl text-slate-400 font-normal shrink-0 mt-0.5 transition-transform duration-200">+</span>
                        </button>
                        <div class="faq-content hidden mt-3 text-sm text-slate-600 leading-relaxed pr-6">
                            Data harga harian dihimpun setiap pagi oleh petugas pencatat harga dinas langsung dari pasar-pasar hewan utama dan koperasi peternak di seluruh kabupaten/kota di Jawa Timur.
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 7. High-Contrast Civic Action Banner (Grounded Institutional Confidence) -->
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-[#013a85] p-8 sm:p-14 lg:p-16 text-white shadow-xl shadow-blue-950/15 relative overflow-hidden">
                
                <!-- Geometric decorative grid subtle accent -->
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 24px 24px;"></div>

                <div class="relative max-w-2xl">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-xs font-semibold tracking-wider uppercase mb-5 border border-white/15">
                        Program Pembinaan Resmi
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight mb-4">
                        Wujudkan Peternakan Tangguh &amp; Modern di Jawa Timur
                    </h2>
                    <p class="text-sm sm:text-base text-blue-100/90 leading-relaxed mb-8 font-normal">
                        Daftarkan kelompok atau unit usaha peternakan Anda sekarang untuk mendapatkan akses bimbingan teknis, pengawasan medis, dan integrasi pasar daerah.
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full font-semibold text-sm bg-white text-[#013a85] hover:bg-blue-50 shadow-sm transition-all duration-200 active:scale-[0.98]"
                        >
                            <span>Daftar Akun Baru Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-6 py-3.5 rounded-full font-semibold text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all duration-200 active:scale-[0.98]"
                        >
                            <span>Masuk ke Portal</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 8. Provincial Authority Footer -->
    <footer class="bg-white border-t border-slate-200 pt-16 pb-12 text-slate-500 text-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-100">
                
                <!-- Column 1: Identity & Official Presence (5 cols) -->
                <div class="md:col-span-5">
                    <img
                        src="{{ asset('img/logoaplikasi2.png') }}"
                        alt="Peternak Milenial Jawa Timur"
                        class="h-10 w-auto object-contain mb-4"
                    />
                    <p class="text-slate-600 max-w-sm leading-relaxed mb-4">
                        Portal resmi Pemerintah Provinsi Jawa Timur melalui Dinas Peternakan untuk membina wirausaha muda peternakan dan menjamin kedaulatan pangan hewani berkelanjutan.
                    </p>
                    <p class="text-slate-400 text-[11px] leading-relaxed">
                        Jl. Jenderal Ahmad Yani No. 202, Gayungan, Surabaya, Jawa Timur 60235
                    </p>
                </div>

                <!-- Column 2: Public Modules (3 cols) -->
                <div class="md:col-span-3">
                    <h4 class="text-xs uppercase font-bold tracking-wider text-slate-900 mb-3.5">Layanan Publik</h4>
                    <ul class="space-y-2.5 font-medium">
                        <li><a href="{{ route('harga-komoditas') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Informasi Harga Pasar Harian</a></li>
                        <li><a href="{{ route('darurat') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Posko Siaga Darurat Kesmavet</a></li>
                        <li><a href="{{ route('pelatihan') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Agenda Bimtek &amp; Pelatihan</a></li>
                        <li><a href="{{ route('marketplace') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Pasar Komoditas Ternak</a></li>
                        <li><a href="{{ route('pameran') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Agenda Pameran Daerah</a></li>
                    </ul>
                </div>

                <!-- Column 3: Quick Navigation (2 cols) -->
                <div class="md:col-span-2">
                    <h4 class="text-xs uppercase font-bold tracking-wider text-slate-900 mb-3.5">Akses Akun</h4>
                    <ul class="space-y-2.5 font-medium">
                        <li><a href="{{ route('login') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Pendaftaran Baru</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-[#013a85] transition-colors">Dashboard Sistem</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact & Emergency (2 cols) -->
                <div class="md:col-span-2">
                    <h4 class="text-xs uppercase font-bold tracking-wider text-slate-900 mb-3.5">Kontak Dinas</h4>
                    <ul class="space-y-2 text-slate-600 font-medium">
                        <li>Posko: <span class="font-bold text-[#013a85] block">0800-1-DARURAT</span></li>
                        <li>Email: <a href="mailto:disnak@jatimprov.go.id" class="text-blue-600 hover:underline block truncate">disnak@jatimprov.go.id</a></li>
                        <li>Jam: <span class="text-slate-500 text-[11px] block">Senin–Jumat 07.30–16.00</span></li>
                    </ul>
                </div>

            </div>

            <!-- Footer Bottom Strip -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400">
                <p>&copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-slate-600 transition-colors">Sistem Informasi Peternak Milenial Jatim</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Client Scripts -->
    <script>
        // Mobile Drawer Menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        function closeMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.add('hidden');
            }
        }

        // Accessible FAQ Accordion Toggle
        function toggleFaq(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.faq-icon');
            const isCurrentlyOpen = !content.classList.contains('hidden');

            // Close all items
            document.querySelectorAll('.faq-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(el => {
                el.textContent = '+';
                el.classList.remove('rotate-45');
            });

            // Toggle target
            if (!isCurrentlyOpen) {
                content.classList.remove('hidden');
                icon.textContent = '×';
            }
        }
    </script>
</body>
</html>

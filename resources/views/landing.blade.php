<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peternak Milenial Jatim - Portal Resmi Dinas Peternakan Provinsi Jawa Timur</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Flowbite & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white flex flex-col min-h-screen">

    <!-- 1. Header & Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <img
                    src="{{ asset('img/logoaplikasi2.png') }}"
                    alt="Peternak Milenial Logo"
                    class="h-9 sm:h-10 w-auto object-contain dark:brightness-110 group-hover:opacity-90 transition-opacity"
                />
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600 dark:text-gray-300">
                <a href="#tentang" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tentang</a>
                <a href="#fitur" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Fitur Unggulan</a>
                <a href="#keunggulan" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Ekosistem</a>
                <a href="#kontak" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Kontak Dinas</a>
            </nav>

            <!-- Actions / Auth Buttons (Masuk & Login) -->
            <div class="flex items-center gap-3">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow transition"
                    >
                        <span>Buka Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <!-- Button "Login" pada navbar -->
                    <a
                        href="{{ route('login') }}"
                        id="nav-login-btn"
                        class="inline-flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 transition"
                    >
                        Login
                    </a>
                    <!-- Button "Masuk" / "Daftar" -->
                    <a
                        href="{{ route('login') }}"
                        id="nav-masuk-btn"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition"
                    >
                        Masuk
                    </a>
                    <a
                        href="{{ route('register') }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition"
                    >
                        Daftar
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button
                    type="button"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                    aria-label="Buka Menu"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-4 space-y-3">
            <a href="#tentang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Tentang</a>
            <a href="#fitur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Fitur Unggulan</a>
            <a href="#keunggulan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Ekosistem</a>
            <a href="#kontak" class="block text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Kontak Dinas</a>
            <div class="pt-3 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="w-full text-center py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white">Masuk / Login</a>
                <a href="{{ route('register') }}" class="w-full text-center py-2 text-sm font-semibold rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">Daftar Akun</a>
            </div>
        </div>
    </header>

    <!-- 2. Hero Section -->
    <section class="relative pt-12 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
        <!-- Background subtle accent gradients -->
        <div class="absolute inset-0 -z-10 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-r from-blue-400/15 via-cyan-300/15 to-emerald-400/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Hero Headline & CTA -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <!-- Government badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200/80 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400 animate-pulse"></span>
                        <span>Program Resmi Dinas Peternakan Jawa Timur</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-[1.15] mb-6">
                        Pemberdayaan Digital <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400">Peternak Muda</span> Jawa Timur
                    </h1>

                    <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Satu pintu terintegrasi untuk pemetaan sentra ternak, siaga tanggap darurat kesmavet 24 jam, bimbingan teknologi pakan modern, dan pemasaran komoditas unggulan daerah.
                    </p>

                    <!-- Main Call to Actions (CTA) -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 mb-10">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/25 transition duration-150"
                            >
                                <span>Menuju Dashboard Saya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        @else
                            <!-- Button "Masuk" yang wajib ada di landing page -->
                            <a
                                href="{{ route('login') }}"
                                id="hero-masuk-btn"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/25 transition duration-150"
                            >
                                <span>Masuk ke Aplikasi</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>

                            <a
                                href="{{ route('register') }}"
                                id="hero-daftar-btn"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 shadow-sm transition duration-150"
                            >
                                <span>Daftar Akun Peternak</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Trust indicators -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-800 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Terhubung Database Dinas</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Kesmavet Siaga 24 Jam</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Bimtek Bersertifikat</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Live System Summary Card -->
                <div class="lg:col-span-5">
                    <div class="relative max-w-md mx-auto">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700/80 shadow-2xl p-6 sm:p-8 backdrop-blur">
                            
                            <!-- Header card -->
                            <div class="flex items-center justify-between pb-5 border-b border-gray-100 dark:border-gray-700">
                                <div>
                                    <div class="text-xs uppercase font-bold tracking-wider text-blue-600 dark:text-blue-400">Live Status Portal</div>
                                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mt-0.5">Sistem Jatim Siaga</h3>
                                </div>
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                            </div>

                            <!-- Live Metric Counters from DB -->
                            <div class="grid grid-cols-2 gap-3.5 my-6">
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-gray-750 border border-gray-100 dark:border-gray-700">
                                    <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $regionCount }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kab/Kota Terdaftar</div>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-gray-750 border border-gray-100 dark:border-gray-700">
                                    <div class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ $centerCount }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sentra Produksi MASP</div>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-gray-750 border border-gray-100 dark:border-gray-700">
                                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $commodityCount }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sektor Komoditas</div>
                                </div>

                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-gray-750 border border-gray-100 dark:border-gray-700">
                                    <div class="text-2xl font-black text-amber-500">{{ $activeTrainingsCount }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Bimtek Dibuka</div>
                                </div>
                            </div>

                            <!-- Quick access row -->
                            <div class="space-y-2.5 pt-2">
                                <a href="{{ route('login') }}" class="flex items-center justify-between p-3 rounded-xl bg-blue-50/70 hover:bg-blue-100/70 dark:bg-blue-950/40 dark:hover:bg-blue-900/40 border border-blue-100 dark:border-blue-900 transition">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold">1</div>
                                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">Akses Masuk Peternak &amp; Petugas</span>
                                    </div>
                                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold">Login &rarr;</span>
                                </a>

                                <a href="{{ route('register') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-gray-750 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 transition">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-gray-800 text-white flex items-center justify-center text-xs font-bold">2</div>
                                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">Registrasi Usaha Ternak Baru</span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-bold">Daftar &rarr;</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Section Fitur Utama & Keunggulan -->
    <section id="fitur" class="py-16 sm:py-24 bg-white dark:bg-gray-850 border-y border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-xs uppercase font-bold tracking-wider text-blue-600 dark:text-blue-400 mb-2">Layanan Terpadu</h2>
                <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Fitur Ekosistem Peternak Milenial
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                    Dirancang untuk meningkatkan produktivitas, transparansi pasar, dan perlindungan kesehatan hewan di Jawa Timur.
                </p>
            </div>

            <!-- Features Grid (Clean 3-column layout) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                
                <!-- Fitur 1: MASP Sentra Ternak -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-blue-400 dark:hover:border-blue-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Peta Sentra MASP Jatim</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Visualisasi interaktif sebaran sentra sapi perah, sapi potong, dan unggas di berbagai kabupaten dengan data produksi terintegrasi.
                    </p>
                </div>

                <!-- Fitur 2: Siaga Darurat Kesmavet -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-red-400 dark:hover:border-red-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Pelaporan Darurat 24/7</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Pelaporan cepat kasus gejala penyakit dan wabah ternak langsung terhubung dengan unit reaksi cepat medikvet dinas.
                    </p>
                </div>

                <!-- Fitur 3: Harga Komoditas Real-Time -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-emerald-400 dark:hover:border-emerald-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Informasi Harga Komoditas</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Pemantauan harga harian susu segar, sapi hidup, daging, dan pakan ternak di tingkat peternak dan pasar se-Jawa Timur.
                    </p>
                </div>

                <!-- Fitur 4: Bimtek & Sertifikasi -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-blue-400 dark:hover:border-blue-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/50 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Bimtek &amp; Pelatihan BBPP</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Pendaftaran pelatihan fermentasi silase, biosekuriti, dan sertifikasi keahlian bekerjasama dengan Balai Besar Pelatihan Peternakan.
                    </p>
                </div>

                <!-- Fitur 5: Marketplace & e-Tag -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-purple-400 dark:hover:border-purple-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25a.75.75 0 01-.75-.75V3.75a.75.75 0 01.75-.75h14.25a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75h-3.75z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Marketplace &amp; e-Tag Ternak</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Penjualan produk ternak terverifikasi serta pencatatan barcode e-tag identitas ternak untuk kemudahan *traceability*.
                    </p>
                </div>

                <!-- Fitur 6: Tanya Dokter Hewan -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 hover:border-teal-400 dark:hover:border-teal-500 transition shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/50 text-teal-600 dark:text-teal-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Konsultasi Dokter &amp; Rekam Medis</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Layanan tanya jawab medis hewan langsung dengan dokter hewan terdaftar dan pencatatan buku vaksinasi digital.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- 4. Section Alur & Ekosistem Sederhana -->
    <section id="keunggulan" class="py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-xs uppercase font-bold tracking-wider text-blue-600 dark:text-blue-400 mb-2">Alur Kemudahan</h2>
                <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    3 Langkah Bergabung ke Ekosistem Digital
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center mx-auto mb-4 text-sm">
                        1
                    </div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2">Registrasi Akun</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        Daftar mandiri melalui formulir online dan verifikasi data kelompok ternak atau usaha Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center mx-auto mb-4 text-sm">
                        2
                    </div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2">Akses Layanan Dinas</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        Gunakan fasilitas siaga darurat kesmavet, ikuti bimtek pakan gratis, dan daftarkan barcode e-tag ternak.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/80 text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center mx-auto mb-4 text-sm">
                        3
                    </div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2">Perluas Pasar Ternak</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        Pantau pergerakan harga komoditas pasar dan pasarkan produk olahan susu maupun daging di marketplace.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Call to Action Banner (Bawah) -->
    <section class="py-16 bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-600 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight mb-4">
                Siap Menjadi Bagian dari Peternak Milenial Jatim?
            </h2>
            <p class="text-sm sm:text-base text-blue-100 max-w-xl mx-auto mb-8 leading-relaxed">
                Akses dashboard terpadu, konsultasikan ternak Anda, dan tingkatkan daya saing usaha peternakan di era digital.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a
                    href="{{ route('login') }}"
                    class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-bold text-sm bg-white text-blue-700 hover:bg-gray-50 shadow-lg transition"
                >
                    Masuk ke Akun Sekarang
                </a>
                <a
                    href="{{ route('register') }}"
                    class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-semibold text-sm bg-blue-800/60 hover:bg-blue-800 text-white border border-blue-400/30 transition"
                >
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </section>

    <!-- 6. Footer -->
    <footer id="kontak" class="bg-gray-900 text-gray-400 text-xs py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-3">
                        <img
                            src="{{ asset('img/logoaplikasi2.png') }}"
                            alt="Peternak Milenial Logo"
                            class="h-8 w-auto object-contain brightness-0 invert"
                        />
                    </div>
                    <p class="text-gray-400 max-w-md leading-relaxed mb-4">
                        Platform digital resmi Pemerintah Provinsi Jawa Timur melalui Dinas Peternakan dalam membina wirausaha muda peternakan dan menjamin ketahanan pangan hewani.
                    </p>
                    <p class="text-gray-500">
                        Jl. Jenderal Ahmad Yani No. 202, Gayungan, Surabaya, Jawa Timur 60235
                    </p>
                </div>

                <div>
                    <h4 class="text-xs uppercase font-bold tracking-wider text-white mb-3">Navigasi Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('landing') }}" class="hover:text-white transition">Halaman Utama</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Halaman Masuk (Login)</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Pendaftaran Akun</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard Sistem</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs uppercase font-bold tracking-wider text-white mb-3">Kontak &amp; Siaga</h4>
                    <ul class="space-y-2">
                        <li>Kesmavet Siaga: <span class="text-white">0800-1-DARURAT</span></li>
                        <li>Email: <span class="text-white">disnak@jatimprov.go.id</span></li>
                        <li>Jam Layanan: <span class="text-white">Senin - Jumat (07.30 - 16.00 WIB)</span></li>
                    </ul>
                </div>

            </div>

            <div class="pt-8 border-t border-gray-800 text-center text-gray-500 text-[11px] flex flex-col sm:flex-row items-center justify-between gap-3">
                <p>&copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-300">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-gray-300">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

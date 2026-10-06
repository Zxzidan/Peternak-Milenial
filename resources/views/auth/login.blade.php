<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk ke Akun — Peternak Milenial Jawa Timur</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Flowbite & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        @keyframes floatHeroIcon {
            0%, 100% {
                transform: translateY(0px) scale(1);
            }
            50% {
                transform: translateY(-12px) scale(1.02);
            }
        }

        @keyframes pulseAura {
            0%, 100% {
                opacity: 0.45;
                transform: scale(0.92);
            }
            50% {
                opacity: 0.85;
                transform: scale(1.08);
            }
        }

        .hero-float-animation {
            animation: floatHeroIcon 4.5s ease-in-out infinite;
            will-change: transform;
        }

        .hero-pulse-aura {
            animation: pulseAura 4s ease-in-out infinite;
            will-change: transform, opacity;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-slate-50 via-blue-50/40 to-sky-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white">

    <!-- Main Content Area: Split Card Layout -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-10">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

            <!-- LEFT COLUMN: Login Card (Bright Theme) -->
            <div class="lg:col-span-7 w-full max-w-xl mx-auto lg:max-w-none">
                <div
                    class="bg-white/95 border border-slate-200/90 rounded-2xl p-6 sm:p-10 shadow-xl shadow-slate-200/60 backdrop-blur">

                    <!-- Brand Header with Official Logo from img/ -->
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <a href="{{ route('landing') }}" class="flex items-center group" title="Kembali ke Beranda">
                            <img src="{{ asset('img/logoaplikasi2.png') }}" alt="Peternak Milenial Jawa Timur"
                                class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                        </a>
                        <a href="{{ route('landing') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-blue-600 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            <span>Halaman Utama</span>
                        </a>
                    </div>

                    <!-- Welcome Heading & Subtitle -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                        Welcome back
                    </h1>


                    <!-- Flash Notifications -->
                    @if (session('success'))
                        <div
                            class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                            <div class="font-semibold mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                Mohon periksa kembali:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-red-700">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- 2-Column Grid for Email and Password -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block mb-2 text-xs font-semibold text-slate-700">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    autofocus placeholder="name@company.com"
                                    class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <div>
                                <label for="password" class="block mb-2 text-xs font-semibold text-slate-700">
                                    Kata Sandi
                                </label>
                                <input type="password" name="password" id="password" required placeholder="••••••••"
                                    class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-xs pt-1">
                            <label class="flex items-center cursor-pointer text-slate-600 hover:text-slate-800">
                                <input type="checkbox" name="remember" id="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2">Ingat saya</span>
                            </label>
                            <a href="#"
                                onclick="alert('Silakan hubungi administrator dinas untuk pemulihan kata sandi.'); return false;"
                                class="text-blue-600 hover:text-blue-700 font-medium hover:underline">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Primary Sign In Button -->
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-semibold rounded-xl text-sm px-5 py-3 text-center transition duration-150 shadow-md shadow-blue-500/25">
                            Masuk ke Akun
                        </button>

                        <p class="text-sm text-slate-500 mb-6">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition">
                                Sign up / Daftar di sini.
                            </a>
                        </p>

                        <!-- OR Divider -->
                        <div class="relative flex py-2 items-center">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span
                                class="flex-shrink mx-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">or</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <!-- Social Login Buttons -->
                        <div class="space-y-2.5">
                            <!-- Sign in with Google -->
                            <button type="button"
                                onclick="fillAccount('slamet@peternak.id', 'password'); document.forms[0].submit();"
                                class="w-full text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-xs px-5 py-2.5 text-center inline-flex items-center justify-center gap-2.5 shadow-2xs transition">
                                <svg class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                </svg>
                                <span>Sign in with Google</span>
                            </button>

                            <!-- Sign in with Apple -->
                            <button type="button"
                                onclick="fillAccount('budi@gmail.com', 'password'); document.forms[0].submit();"
                                class="w-full text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-xs px-5 py-2.5 text-center inline-flex items-center justify-center gap-2.5 shadow-2xs transition">
                                <svg class="w-4 h-4 fill-current text-slate-800" viewBox="0 0 170 170">
                                    <path
                                        d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.83-12-14.37-6.53-9.9-11.75-21.2-15.65-33.9-3.9-12.7-5.86-24.89-5.86-36.57 0-14.13 3.47-26.04 10.42-35.73 6.95-9.69 15.86-14.65 26.74-14.88 4.99 0 10.57 1.34 16.74 4.02 6.17 2.68 10.23 4.08 12.18 4.2 1.63.13 5.48-1.28 11.55-4.22 6.07-2.94 11.45-4.3 16.14-4.08 12.28.64 22.38 5.25 30.3 13.82-10.74 6.53-16.03 15.76-15.86 27.69.17 9.46 3.84 17.47 11 24.03 7.16 6.56 15.74 10.33 25.75 11.31-2.08 6.53-4.55 12.98-7.41 19.35zM119.22 31.84c0-7.39 2.65-14.42 7.95-21.09 5.3-6.67 11.83-10.47 19.59-11.4 1.02 7.16-1.42 14.42-7.31 21.78-5.89 7.36-12.64 11.26-20.23 10.71z" />
                                </svg>
                                <span>Sign in with Apple</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- RIGHT COLUMN: Illustration Container (Bright Theme - Animated Floating Icon Hiasan 1, 2, 3, 5) -->
            <div class="lg:col-span-5 hidden lg:flex flex-col items-center justify-center">
                <div class="relative w-full max-w-md" id="illustration-slider-container">
                    <!-- Subtle ambient backlight glow behind card -->
                    <div class="absolute -inset-3 bg-gradient-to-r from-blue-200/50 via-emerald-200/40 to-teal-100/50 rounded-3xl blur-2xl opacity-70"></div>

                    <!-- Illustration Container Card -->
                    <div class="relative bg-white/95 border border-slate-200/90 rounded-3xl overflow-hidden p-6 shadow-xl backdrop-blur flex flex-col items-center">
                        @php
                            $slides = [
                                [
                                    'img' => asset('img/hiasan1.png'),
                                    'tag' => '📊 Monitoring & Data',
                                    'tag_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'title' => 'Statistik & Kesehatan Ternak',
                                    'desc' => 'Pencatatan digital real-time populasi hewan, sensor kesehatan, dan grafik produktivitas terpadu.'
                                ],
                                [
                                    'img' => asset('img/hiasan2.png'),
                                    'tag' => '🌾 Smart Farming',
                                    'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'title' => 'Peternak Cerdas & Drone IoT',
                                    'desc' => 'Pemanfaatan pemantauan drone, sensor presisi, dan tata kelola usaha peternakan modern.'
                                ],
                                [
                                    'img' => asset('img/hiasan3.png'),
                                    'tag' => '⚡ Kandang Hijau',
                                    'tag_color' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'title' => 'Kandang Modern Ramah Lingkungan',
                                    'desc' => 'Integrasi energi surya mandiri, biosekuriti kandang pintar, dan sirkulasi ramah lingkungan.'
                                ],
                                [
                                    'img' => asset('img/hiasan5.png'),
                                    'tag' => '🤝 Ekosistem Utama',
                                    'tag_color' => 'bg-teal-50 text-teal-700 border-teal-200',
                                    'title' => 'Ekosistem Peternak Milenial Jatim',
                                    'desc' => 'Sistem Terpadu Kesmavet, Pelatihan Bimtek, e-Tag Barcode & Pasar Digital Jawa Timur.'
                                ],
                            ];
                        @endphp

                        <!-- Category Tag Badge at Top -->
                        <div class="mb-3">
                            <span id="slide-badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-2xs transition-all duration-300 {{ $slides[0]['tag_color'] }}">
                                {{ $slides[0]['tag'] }}
                            </span>
                        </div>

                        <!-- Floating Animated Icon Stage (Clean & Background-Free) -->
                        <div class="relative w-full h-64 sm:h-72 flex items-center justify-center group my-1">
                            
                            <!-- Ambient glowing aura behind floating icon -->
                            <div class="absolute w-52 h-52 sm:w-60 sm:h-60 rounded-full bg-gradient-to-tr from-emerald-200/50 via-sky-200/40 to-blue-200/50 blur-3xl pointer-events-none hero-pulse-aura"></div>

                            <!-- Animated Floating Icons Wrapper -->
                            <div class="relative w-full h-full flex items-center justify-center hero-float-animation">
                                @foreach($slides as $index => $slide)
                                    <div
                                        class="slide-item absolute inset-0 flex items-center justify-center p-2 transition-all duration-700 ease-out {{ $index === 0 ? 'opacity-100 scale-100 z-10' : 'opacity-0 scale-90 pointer-events-none z-0' }}"
                                        data-slide-index="{{ $index }}"
                                    >
                                        <img
                                            src="{{ $slide['img'] }}"
                                            alt="{{ $slide['title'] }}"
                                            class="max-h-60 sm:max-h-68 w-auto object-contain filter drop-shadow-2xl transition-transform duration-500 hover:scale-105 select-none"
                                        />
                                    </div>
                                @endforeach
                            </div>

                            <!-- Previous / Next Controls -->
                            <button
                                type="button"
                                onclick="prevSlide()"
                                aria-label="Slide sebelumnya"
                                class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 shadow-md border border-slate-200/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button
                                type="button"
                                onclick="nextSlide()"
                                aria-label="Slide berikutnya"
                                class="absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 shadow-md border border-slate-200/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        <!-- Slide Text Caption -->
                        <div class="px-2 pt-2 text-center min-h-[72px] flex flex-col justify-center">
                            <h2 id="slide-title" class="text-sm font-bold text-slate-900 transition-opacity duration-300">
                                {{ $slides[0]['title'] }}
                            </h2>
                            <p id="slide-desc" class="text-xs text-slate-500 mt-1 transition-opacity duration-300 line-clamp-2">
                                {{ $slides[0]['desc'] }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer (Bright Theme) -->
    <footer class="py-5 text-center text-xs text-slate-500 border-t border-slate-200/70 bg-white/60">
        &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Sistem Terpadu Peternak Milenial.
    </footer>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Illustration Carousel Logic (Hiasan 1, 2, 3, 5)
        const slideData = @json($slides);
        let currentSlide = 0;
        let slideTimer = null;

        function updateSlideUI() {
            const slides = document.querySelectorAll('.slide-item');
            const badge = document.getElementById('slide-badge');
            const title = document.getElementById('slide-title');
            const desc = document.getElementById('slide-desc');

            slides.forEach((el, idx) => {
                if (idx === currentSlide) {
                    el.classList.remove('opacity-0', 'scale-90', 'pointer-events-none', 'z-0');
                    el.classList.add('opacity-100', 'scale-100', 'z-10');
                } else {
                    el.classList.add('opacity-0', 'scale-90', 'pointer-events-none', 'z-0');
                    el.classList.remove('opacity-100', 'scale-100', 'z-10');
                }
            });

            if (badge && slideData[currentSlide]) {
                badge.className = `inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-2xs transition-all duration-300 ${slideData[currentSlide].tag_color}`;
                badge.textContent = slideData[currentSlide].tag;
            }

            if (title && desc && slideData[currentSlide]) {
                title.textContent = slideData[currentSlide].title;
                desc.textContent = slideData[currentSlide].desc;
            }
        }

        function goToSlide(index) {
            currentSlide = (index + slideData.length) % slideData.length;
            updateSlideUI();
            resetSlideTimer();
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        function resetSlideTimer() {
            if (slideTimer) clearInterval(slideTimer);
            slideTimer = setInterval(nextSlide, 4500);
        }

        // Pause rotation on hover
        const sliderContainer = document.getElementById('illustration-slider-container');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => {
                if (slideTimer) clearInterval(slideTimer);
            });
            sliderContainer.addEventListener('mouseleave', () => {
                resetSlideTimer();
            });
        }

        // Initialize auto slide
        resetSlideTimer();
    </script>
</body>

</html>

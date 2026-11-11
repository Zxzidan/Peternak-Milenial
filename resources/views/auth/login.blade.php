<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk ke Akun — Peternak Milenial Jawa Timur</title>

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
    </style>
</head>

<body
    class="bg-slate-100/70 text-slate-800 min-h-screen flex flex-col justify-between antialiased selection:bg-blue-600 selection:text-white">

    <!-- Main Content Area: Unified Modal Card (Split Layout: Image on Left, Form on Right) -->
    <main class="flex-1 flex items-center justify-center py-6 sm:py-10 lg:py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="w-full max-w-5xl xl:max-w-6xl bg-white rounded-3xl sm:rounded-[32px] overflow-hidden shadow-2xl shadow-slate-900/10 border border-slate-200/80 grid grid-cols-1 lg:grid-cols-12">

            <!-- LEFT COLUMN: Hero Image Showcase with Dark Gradient Overlay -->
            <div
                class="lg:col-span-6 relative hidden lg:flex flex-col justify-between p-8 sm:p-10 xl:p-12 text-white min-h-[620px] overflow-hidden group">
                <!-- Background Image -->
                <img src="{{ asset('img/hiasan baru 2.jpg') }}" alt="Manajemen Kandang & Sapi Perah Modern"
                    class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105 select-none" />

                <!-- Multi-stop Gradient Overlay for Crisp Text Readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
                <div class="absolute inset-0 bg-slate-900/10 pointer-events-none"></div>

                <!-- Top Badge: Jawa Timur -->
                <div class="relative z-10 flex items-center justify-between">
                    <span
                        class="text-xs font-semibold tracking-wide text-white bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15">
                        Jawa Timur
                    </span>
                </div>

                <!-- Bottom Information: Title, Description & Feature Pills -->
                <div class="relative z-10 space-y-5">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                            Manajemen Kandang &amp; Sapi Perah Modern
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-200/90 mt-3 leading-relaxed max-w-md">
                            Penerapan standar biosekuriti higienis, pakan presisi, dan pemeliharaan sapi perah
                            unggul untuk menghasilkan mutu susu berkualitas tinggi di Jawa Timur.
                        </p>
                    </div>

                    <!-- Glassmorphic Feature Pills -->
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div
                            class="p-3 bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white truncate leading-tight">Layanan Terpadu</h4>
                                <p class="text-[11px] text-slate-300 truncate leading-tight mt-0.5">Kesmavet &amp; Digital</p>
                            </div>
                        </div>

                        <div
                            class="p-3 bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-400/30 text-blue-400 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-white truncate leading-tight">Sistem Resmi</h4>
                                <p class="text-[11px] text-slate-300 truncate leading-tight mt-0.5">Dinas Peternak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Authentication Form -->
            <div class="lg:col-span-6 p-7 sm:p-9 lg:p-11 xl:p-12 bg-white flex flex-col justify-between h-full">

                <!-- Top Header: Logo & Back to Home Link -->
                <div class="flex items-center justify-between mb-6 sm:mb-8">
                    <a href="{{ route('landing') }}" class="flex items-center group" title="Kembali ke Beranda">
                        <img src="{{ asset('img/Peternak Milenial.png') }}" alt="Peternak Milenial"
                            class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                    </a>
                    <a href="{{ route('landing') }}"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        <span>Halaman Utama</span>
                    </a>
                </div>

                <!-- Form Section -->
                <div class="my-auto">
                    <!-- Badge -->
                    <div class="mb-3.5">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                            Portal Masuk Akun
                        </span>
                    </div>

                    <!-- Welcome Heading -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Welcome back
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 mb-6 sm:mb-7 leading-relaxed max-w-md">
                        Masukkan email dan kata sandi Anda untuk mengakses dashboard dan layanan terpadu Peternak Milenial Jawa Timur.
                    </p>

                    <!-- Flash Notifications -->
                    @if (session('success'))
                        <div
                            class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                            <div class="font-semibold mb-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                Mohon periksa kembali:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-red-700 ml-1">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form id="login-form" action="{{ route('login.submit') }}" method="POST" class="space-y-4 sm:space-y-4.5">
                        @csrf

                        <!-- Quick Demo Accounts Selector (1-Klik Isi Akun Presentasi) -->
                        <div class="mb-5 p-3.5 bg-slate-50 border border-slate-200/90 rounded-2xl shadow-2xs">
                            <div class="flex items-center justify-between mb-2.5">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Akun Demo Presentasi (1-Klik Isi)</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-medium">Database Siap Demo</span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <!-- 1. Admin Dinas -->
                                <button type="button"
                                    onclick="fillDemoAccount('admin@disnak.jatimprov.go.id', 'password', 'Admin Dinas — Dr. Ir. Indyah Aryani, MM', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-blue-400 hover:bg-blue-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-100 px-1.5 py-0.5 rounded-md">👑 Admin</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-blue-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">Dr. Ir. Indyah</div>
                                    <div class="text-[10px] text-slate-500 truncate">admin@disnak...</div>
                                </button>

                                <!-- 2. Peternak Randy Zidan -->
                                <button type="button"
                                    onclick="fillDemoAccount('dandiazaidanekerja35@gmail.com', 'password', 'Peternak Bebek Nganjuk — Randy Zidan', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-emerald-400 hover:bg-emerald-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded-md">🦆 Peternak</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-emerald-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">Randy Zidan</div>
                                    <div class="text-[10px] text-slate-500 truncate">Itik Nganjuk</div>
                                </button>

                                <!-- 3. Peternak Slamet Rahardjo -->
                                <button type="button"
                                    onclick="fillDemoAccount('slamet@peternak.com', 'password', 'Peternak Sapi Pasuruan — Slamet Rahardjo', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-emerald-400 hover:bg-emerald-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded-md">🐄 Peternak</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-emerald-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">Slamet R.</div>
                                    <div class="text-[10px] text-slate-500 truncate">Sapi Pasuruan</div>
                                </button>

                                <!-- 4. Dokter Hewan drh. Nur Cahyo -->
                                <button type="button"
                                    onclick="fillDemoAccount('nurcahyo@disnak.jatimprov.go.id', 'password', 'Dokter Hewan — drh. Nur Cahyo, M.Vet', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-purple-400 hover:bg-purple-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-100 px-1.5 py-0.5 rounded-md">🩺 Dokter</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-purple-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">drh. Nur Cahyo</div>
                                    <div class="text-[10px] text-slate-500 truncate">Spesialis Unggas</div>
                                </button>

                                <!-- 5. Dokter Hewan drh. Ratna Kusuma -->
                                <button type="button"
                                    onclick="fillDemoAccount('ratnak@disnak.jatimprov.go.id', 'password', 'Dokter Hewan — drh. Ratna Kusuma', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-purple-400 hover:bg-purple-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-100 px-1.5 py-0.5 rounded-md">🩺 Dokter</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-purple-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">drh. Ratna K.</div>
                                    <div class="text-[10px] text-slate-500 truncate">Spesialis Sapi</div>
                                </button>

                                <!-- 6. Warga / Pembeli Budi Santoso -->
                                <button type="button"
                                    onclick="fillDemoAccount('budi@gmail.com', 'password', 'Masyarakat Umum / Pembeli — Budi Santoso', this)"
                                    class="demo-card text-left p-2.5 rounded-xl border border-slate-200/90 bg-white hover:border-amber-400 hover:bg-amber-50/40 transition shadow-2xs cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-100 px-1.5 py-0.5 rounded-md">🛒 Warga</span>
                                        <span class="text-[10px] text-slate-400 group-hover:text-amber-600 transition font-mono">1-Klik</span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs mt-1 truncate">Budi Santoso</div>
                                    <div class="text-[10px] text-slate-500 truncate">Konsumen Sby</div>
                                </button>
                            </div>

                            <!-- Selected Status Notification & Instant Login button -->
                            <div id="demo-selected-banner" class="hidden mt-2.5 pt-2 border-t border-slate-200/80 flex items-center justify-between text-xs">
                                <span class="text-slate-600 font-medium flex items-center gap-1.5 truncate mr-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span class="truncate">Terpilih: <strong id="demo-selected-name" class="text-slate-900"></strong></span>
                                </span>
                                <button type="button" onclick="submitLoginForm()" class="shrink-0 text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 cursor-pointer bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100 hover:bg-blue-100 transition">
                                    <span>Langsung Masuk</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block mb-1.5 text-xs sm:text-sm font-semibold text-slate-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    required autofocus placeholder="name@company.com"
                                    class="bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-4 py-3 placeholder-slate-400 transition" />
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block mb-1.5 text-xs sm:text-sm font-semibold text-slate-700">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" required
                                    placeholder="••••••••"
                                    class="bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 pr-11 py-3 placeholder-slate-400 transition" />
                                <button type="button"
                                    onclick="togglePasswordVisibility('password', 'password-eye-icon')"
                                    aria-label="Lihat kata sandi"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                    <svg id="password-eye-icon" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                                        stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-xs sm:text-sm pt-1 pb-1">
                            <label class="flex items-center cursor-pointer text-slate-600 hover:text-slate-800 select-none">
                                <input type="checkbox" name="remember" id="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition" />
                                <span class="ml-2">Ingat saya</span>
                            </label>
                            <a href="#"
                                onclick="alert('Silakan hubungi administrator dinas untuk pemulihan kata sandi.'); return false;"
                                class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Primary Sign In Button -->
                        <div class="pt-1.5">
                            <button type="submit"
                                class="w-full text-white bg-[#2563eb] hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 font-semibold rounded-xl text-sm sm:text-base py-3 sm:py-3.5 text-center transition duration-200 shadow-sm shadow-blue-500/25 hover:shadow-md cursor-pointer flex items-center justify-center gap-2">
                                <span>Masuk ke Akun</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bottom Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-xs sm:text-sm text-slate-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition ml-1">
                            Daftar di sini
                        </a>
                    </p>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer Copyright -->
    <footer class="py-5 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Sistem Terpadu Peternak Milenial.
    </footer>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function fillDemoAccount(email, password, roleLabel, buttonEl) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;

                // Reset active styling pada semua kartu demo
                document.querySelectorAll('.demo-card').forEach(card => {
                    card.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500', 'bg-blue-50/50');
                });

                // Tambahkan active ring pada kartu yang diklik
                if (buttonEl) {
                    buttonEl.classList.add('ring-2', 'ring-blue-500', 'border-blue-500', 'bg-blue-50/50');
                }

                // Efek visual highlight pada input email & password
                emailInput.classList.add('ring-4', 'ring-emerald-200', 'border-emerald-500');
                passwordInput.classList.add('ring-4', 'ring-emerald-200', 'border-emerald-500');
                setTimeout(() => {
                    emailInput.classList.remove('ring-4', 'ring-emerald-200', 'border-emerald-500');
                    passwordInput.classList.remove('ring-4', 'ring-emerald-200', 'border-emerald-500');
                }, 1000);

                // Tampilkan banner notifikasi akun terpilih
                const banner = document.getElementById('demo-selected-banner');
                const nameEl = document.getElementById('demo-selected-name');
                if (banner && nameEl) {
                    nameEl.textContent = roleLabel;
                    banner.classList.remove('hidden');
                }
            }
        }

        function submitLoginForm() {
            const form = document.getElementById('login-form');
            if (form) form.submit();
        }

        // Password visibility toggler
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            } else {
                input.type = 'password';
                icon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            }
        }
    </script>
</body>

</html>

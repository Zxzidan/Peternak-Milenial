<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru - Flowbite Peternak Milenial Jatim</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Flowbite & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background-color: #111827;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white">

    <!-- Top Flowbite Toolbar (Exact match with screenshot) -->
    <header class="border-b border-gray-800 bg-gray-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between text-xs">
            <!-- Left: Back Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Halaman Utama</span>
                </a>
                <span class="hidden sm:inline-block text-gray-500">|</span>
                <span class="hidden sm:inline-block text-gray-400 font-medium">Registrasi Mandiri Peternak Milenial</span>
            </div>

            <!-- Middle: Responsive Viewport Icons -->
            <div class="hidden md:flex items-center bg-gray-800 border border-gray-700 rounded-lg p-0.5">
                <button type="button" class="p-1.5 rounded text-blue-400 bg-gray-700 hover:text-white" title="Desktop view">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                    </svg>
                </button>
                <button type="button" class="p-1.5 rounded text-gray-400 hover:text-white" title="Tablet view">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </button>
                <button type="button" class="p-1.5 rounded text-gray-400 hover:text-white" title="Mobile view">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                </button>
            </div>

            <!-- Right: Font Selector & Theme Controls -->
            <div class="flex items-center gap-2">
                <div class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-2.5 py-1 text-xs font-medium flex items-center gap-1.5">
                    <span>Inter</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div class="flex items-center bg-gray-800 border border-gray-700 rounded-lg p-1 gap-1">
                    <span class="w-3.5 h-3.5 rounded bg-blue-600 inline-block"></span>
                </div>
                <button type="button" class="p-1.5 text-gray-400 hover:text-white bg-gray-800 border border-gray-700 rounded-lg">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area: Split Card Layout -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-12">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            <!-- LEFT COLUMN: Flowbite Register Card -->
            <div class="lg:col-span-7 w-full max-w-xl mx-auto lg:max-w-none">
                <div class="bg-gray-800/90 border border-gray-700/80 rounded-2xl p-6 sm:p-10 shadow-2xl backdrop-blur">

                    <!-- Flowbite Logo & Brand Header -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/20 text-white font-black text-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1.5">
                                Flowbite
                                <span class="text-[10px] uppercase font-semibold tracking-wider px-1.5 py-0.5 rounded bg-blue-950 text-blue-400 border border-blue-800">Peternak Jatim</span>
                            </span>
                        </div>
                    </div>

                    <!-- Heading & Subtitle -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-2">
                        Create your account
                    </h1>
                    <p class="text-sm text-gray-400 mb-6">
                        Start managing your farm in seconds. Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400 font-semibold hover:underline transition">
                            Sign in.
                        </a>
                    </p>

                    <!-- Flash Errors -->
                    @if($errors->any())
                        <div class="mb-5 p-3.5 rounded-lg bg-red-950/60 border border-red-800 text-red-300 text-xs">
                            <div class="font-semibold mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                Mohon lengkapi formulir pendaftaran:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-red-300/90">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Register Form -->
                    <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Row 1: Nama Lengkap & Nomor HP -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block mb-2 text-xs font-medium text-gray-300">
                                    Nama Lengkap <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="Contoh: Raditya Pratama"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400 transition"
                                >
                            </div>

                            <div>
                                <label for="phone_number" class="block mb-2 text-xs font-medium text-gray-300">
                                    Nomor WhatsApp / HP
                                </label>
                                <input
                                    type="text"
                                    name="phone_number"
                                    id="phone_number"
                                    value="{{ old('phone_number') }}"
                                    placeholder="081234567890"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400 transition"
                                >
                            </div>
                        </div>

                        <!-- Row 2: Email & Peran Akun -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block mb-2 text-xs font-medium text-gray-300">
                                    Email <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="name@company.com"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400 transition"
                                >
                            </div>

                            <div>
                                <label for="role" class="block mb-2 text-xs font-medium text-gray-300">
                                    Tipe Keanggotaan
                                </label>
                                <select
                                    name="role"
                                    id="role"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition"
                                >
                                    <option value="peternak" {{ old('role') == 'peternak' ? 'selected' : '' }}>👨‍🌾 Peternak Milenial (Produsen / Kandang)</option>
                                    <option value="umum" {{ old('role') == 'umum' ? 'selected' : '' }}>🛒 Pembeli / Konsumen Komoditas</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Password & Confirm Password -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block mb-2 text-xs font-medium text-gray-300">
                                    Kata Sandi <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    placeholder="••••••••"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400 transition"
                                >
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-2 text-xs font-medium text-gray-300">
                                    Ulangi Kata Sandi <span class="text-red-400">*</span>
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    required
                                    placeholder="••••••••"
                                    class="bg-gray-700/70 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400 transition"
                                >
                            </div>
                        </div>

                        <!-- Terms & Conditions Checkbox -->
                        <div class="pt-1">
                            <label class="flex items-start cursor-pointer text-xs text-gray-400 hover:text-gray-300">
                                <input
                                    type="checkbox"
                                    name="terms"
                                    id="terms"
                                    value="1"
                                    required
                                    checked
                                    class="mt-0.5 w-4 h-4 rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 focus:ring-offset-gray-800 shrink-0"
                                >
                                <span class="ml-2.5">
                                    Saya menyetujui <a href="#" class="text-blue-500 hover:underline">Syarat &amp; Ketentuan</a> serta <a href="#" class="text-blue-500 hover:underline">Kebijakan Privasi</a> program Peternak Milenial Jatim.
                                </span>
                            </label>
                        </div>

                        <!-- Primary Register Button -->
                        <button
                            type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-800/80 font-medium rounded-lg text-sm px-5 py-3 text-center transition duration-150 shadow-lg shadow-blue-600/30"
                        >
                            Daftar Akun Sekarang
                        </button>

                        <!-- OR Divider -->
                        <div class="relative flex py-2 items-center">
                            <div class="flex-grow border-t border-gray-700"></div>
                            <span class="flex-shrink mx-4 text-xs font-medium text-gray-500 uppercase tracking-wider">or</span>
                            <div class="flex-grow border-t border-gray-700"></div>
                        </div>

                        <!-- Social Register Buttons -->
                        <div class="space-y-2.5">
                            <button
                                type="button"
                                onclick="alert('Pendaftaran instan dengan akun Google akan menghubungkan email Google Anda ke database peternak.');"
                                class="w-full text-gray-200 bg-gray-700/50 hover:bg-gray-700 border border-gray-600/80 hover:border-gray-500 focus:ring-4 focus:ring-gray-700 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center justify-center gap-2.5 transition"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                </svg>
                                <span>Sign up with Google</span>
                            </button>

                            <button
                                type="button"
                                onclick="alert('Pendaftaran dengan ID Apple didukung untuk ekosistem perangkat iOS/macOS.');"
                                class="w-full text-gray-200 bg-gray-700/50 hover:bg-gray-700 border border-gray-600/80 hover:border-gray-500 focus:ring-4 focus:ring-gray-700 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center justify-center gap-2.5 transition"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 170 170">
                                    <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.83-12-14.37-6.53-9.9-11.75-21.2-15.65-33.9-3.9-12.7-5.86-24.89-5.86-36.57 0-14.13 3.47-26.04 10.42-35.73 6.95-9.69 15.86-14.65 26.74-14.88 4.99 0 10.57 1.34 16.74 4.02 6.17 2.68 10.23 4.08 12.18 4.2 1.63.13 5.48-1.28 11.55-4.22 6.07-2.94 11.45-4.3 16.14-4.08 12.28.64 22.38 5.25 30.3 13.82-10.74 6.53-16.03 15.76-15.86 27.69.17 9.46 3.84 17.47 11 24.03 7.16 6.56 15.74 10.33 25.75 11.31-2.08 6.53-4.55 12.98-7.41 19.35zM119.22 31.84c0-7.39 2.65-14.42 7.95-21.09 5.3-6.67 11.83-10.47 19.59-11.4 1.02 7.16-1.42 14.42-7.31 21.78-5.89 7.36-12.64 11.26-20.23 10.71z"/>
                                </svg>
                                <span>Sign up with Apple</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- RIGHT COLUMN: 3D Illustration & Atmosphere -->
            <div class="lg:col-span-5 hidden lg:flex flex-col items-center justify-center">
                <div class="relative w-full max-w-md">
                    <!-- Subtle ambient backlight glow -->
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-blue-600/30 to-cyan-500/20 rounded-3xl blur-2xl opacity-75"></div>

                    <!-- 3D Illustration Container -->
                    <div class="relative bg-gray-800/60 border border-gray-700/60 rounded-3xl overflow-hidden p-3 shadow-2xl backdrop-blur">
                        <img
                            src="{{ asset('img/auth-illustration.jpg') }}"
                            alt="Ilustrasi Peternak Milenial Flowbite"
                            class="w-full h-auto object-cover rounded-2xl shadow-inner"
                        />
                        <div class="p-4 text-center">
                            <div class="text-sm font-semibold text-white">Bergabung dengan Ribuan Peternak Jatim</div>
                            <div class="text-xs text-gray-400 mt-1">Dapatkan Akses Bimtek Gratis, e-Tag Barcode &amp; Pasar Digital</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-gray-500 border-t border-gray-800/60">
        &copy; {{ date('Y') }} Dinas Peternakan Provinsi Jawa Timur. Didukung oleh Flowbite &amp; Laravel.
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru — Peternak Milenial Jawa Timur</title>

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

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-12px) scale(1.02);
            }
        }

        @keyframes pulseAura {

            0%,
            100% {
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

            <!-- LEFT COLUMN: Register Card (Bright Theme) -->
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

                    <!-- Heading: Sign up (As shown in design) -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 text-center tracking-tight mb-6">
                        Sign up
                    </h1>

                    <!-- Flash Errors -->
                    @if ($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                            <div class="font-semibold mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                Mohon lengkapi formulir pendaftaran:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-red-700">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Register Form -->
                    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="peternak">
                        <input type="hidden" name="terms" value="1">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3.5">
                            <!-- Row 1: Nama* & Email* -->
                            <div>
                                <label for="name" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Nama<span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    placeholder="Nama Lengkap"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <div>
                                <label for="email" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Email<span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    placeholder="Email"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <!-- Row 2: No Telpon (WA)* & NIK* -->
                            <div>
                                <label for="phone_number" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    No Telpon (WA)<span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                                    placeholder="628xxxxxxxxxx"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <div>
                                <label for="nik" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    NIK<span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" required
                                    placeholder="NIK"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <!-- Row 3: Tanggal Lahir* & Kabupaten/Kota* -->
                            <div>
                                <label for="birth_date" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Tanggal Lahir<span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition cursor-pointer">
                            </div>

                            <div>
                                <label for="kabupaten" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Kabupaten/Kota<span class="text-red-500">*</span>
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
                                <select name="kabupaten" id="kabupaten" required onchange="handleKabupatenChange(this.value)"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 shadow-2xs transition cursor-pointer">
                                    <option value="" disabled {{ old('kabupaten') ? '' : 'selected' }}>Pilih Kabupaten...</option>
                                    @foreach ($jatimKabupatens as $kab)
                                        <option value="{{ $kab }}" {{ old('kabupaten') == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Row 4: Kecamatan* & Kelurahan/Desa* -->
                            <div>
                                <label for="kecamatan" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Kecamatan<span class="text-red-500">*</span>
                                </label>
                                <select name="kecamatan" id="kecamatan" required onchange="handleKecamatanChange(this.value)"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 shadow-2xs transition cursor-pointer">
                                    <option value="" disabled {{ old('kecamatan') ? '' : 'selected' }}>Pilih Kecamatan...</option>
                                    @if(old('kecamatan'))
                                        <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                                    @endif
                                </select>
                            </div>

                            <div>
                                <label for="desa" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Kelurahan/Desa<span class="text-red-500">*</span>
                                </label>
                                <select name="desa" id="desa" required
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 shadow-2xs transition cursor-pointer">
                                    <option value="" disabled {{ old('desa') ? '' : 'selected' }}>Pilih Desa...</option>
                                    @if(old('desa'))
                                        <option value="{{ old('desa') }}" selected>{{ old('desa') }}</option>
                                    @endif
                                </select>
                            </div>

                            <!-- Row 5: Password Baru* & Konfirmasi Password* -->
                            <div>
                                <label for="password" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Password Baru<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required placeholder="Password Baru"
                                        class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 pr-10 placeholder-slate-400 shadow-2xs transition">
                                    <button type="button" onclick="togglePasswordVisibility('password', 'password-eye-icon')" aria-label="Lihat kata sandi"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                        <svg id="password-eye-icon" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Konfirmasi Password<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi Password"
                                        class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 pr-10 placeholder-slate-400 shadow-2xs transition">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'password_confirmation-eye-icon')" aria-label="Lihat konfirmasi kata sandi"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                        <svg id="password_confirmation-eye-icon" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Row 6: Ternak yang Dimiliki* & Jumlah Ternak yang Dimiliki* -->
                            <div>
                                <label for="livestock_type" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Ternak yang Dimiliki<span class="text-red-500">*</span>
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
                                <select name="livestock_type" id="livestock_type" required
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 shadow-2xs transition cursor-pointer">
                                    <option value="" disabled {{ old('livestock_type') ? '' : 'selected' }}>Pilih ...</option>
                                    @foreach ($livestockOptions as $opt)
                                        <option value="{{ $opt }}" {{ old('livestock_type') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="livestock_count" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Jumlah Ternak yang Dimiliki<span class="text-red-500">*</span>
                                </label>
                                <input type="number" min="0" name="livestock_count" id="livestock_count" value="{{ old('livestock_count') }}" required
                                    placeholder="Jumlah Ternak yang Dimiliki (per ekor)"
                                    class="bg-white border border-slate-300 text-slate-900 text-xs sm:text-sm rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 sm:p-3 placeholder-slate-400 shadow-2xs transition">
                            </div>

                            <!-- Row 7: Foto Berkas KTP* (Full Width) -->
                            <div class="sm:col-span-2">
                                <label for="ktp_file" class="block mb-1.5 text-xs font-semibold text-slate-700">
                                    Foto Berkas KTP<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="ktp_file" id="ktp_file" accept=".jpeg,.png,.jpg"
                                        class="block w-full text-xs sm:text-sm text-slate-600 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-3 sm:file:mr-4 file:py-2 file:px-3 sm:file:px-4 file:rounded-l-lg file:border-0 file:border-r file:border-slate-300 file:text-xs file:font-medium file:bg-slate-100 file:text-slate-800 hover:file:bg-slate-200 transition" />
                                </div>
                                <div class="mt-1.5 space-y-0.5 text-[11px] sm:text-xs text-slate-500 font-normal">
                                    <p>* Besar Max 10 MB</p>
                                    <p>* Tipe: jpeg, png, dan jpg</p>
                                </div>
                            </div>

                            <!-- Row 8: Sign Up Submit Button (Full Width) -->
                            <div class="sm:col-span-2 pt-2">
                                <button type="submit"
                                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-semibold rounded-lg text-sm px-5 py-3 text-center transition duration-150 shadow-md shadow-blue-500/20 cursor-pointer">
                                    Sign Up
                                </button>
                            </div>
                        </div>

                        <!-- Login Shortcut Link -->
                        <p class="text-xs text-center text-slate-500 pt-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition">
                                Masuk di sini.
                            </a>
                        </p>
                    </form>

                </div>
            </div>

            <!-- RIGHT COLUMN: Illustration Container (Bright Theme - Animated Floating Icon Hiasan 1, 2, 3, 5) -->
            <div class="lg:col-span-5 hidden lg:flex flex-col items-center justify-center">
                <div class="relative w-full max-w-md" id="illustration-slider-container">
                    <!-- Subtle ambient backlight glow behind card -->
                    <div
                        class="absolute -inset-3 bg-gradient-to-r from-blue-200/50 via-emerald-200/40 to-teal-100/50 rounded-3xl blur-2xl opacity-70">
                    </div>

                    <!-- Illustration Container Card -->
                    <div
                        class="relative bg-white/95 border border-slate-200/90 rounded-3xl overflow-hidden p-6 shadow-xl backdrop-blur flex flex-col items-center">
                        @php
                            $slides = [
                                [
                                    'img' => asset('img/hiasan1.png'),
                                    'tag' => '📊 Monitoring & Data',
                                    'tag_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'title' => 'Statistik & Kesehatan Ternak',
                                    'desc' =>
                                        'Pencatatan digital real-time populasi hewan, sensor kesehatan, dan grafik produktivitas terpadu.',
                                ],
                                [
                                    'img' => asset('img/hiasan2.png'),
                                    'tag' => '🌾 Smart Farming',
                                    'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'title' => 'Peternak Cerdas & Drone IoT',
                                    'desc' =>
                                        'Pemanfaatan pemantauan drone, sensor presisi, dan tata kelola usaha peternakan modern.',
                                ],
                                [
                                    'img' => asset('img/hiasan3.png'),
                                    'tag' => '⚡ Kandang Hijau',
                                    'tag_color' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'title' => 'Kandang Modern Ramah Lingkungan',
                                    'desc' =>
                                        'Integrasi energi surya mandiri, biosekuriti kandang pintar, dan sirkulasi ramah lingkungan.',
                                ],
                                [
                                    'img' => asset('img/hiasan5.png'),
                                    'tag' => '🤝 Ekosistem Utama',
                                    'tag_color' => 'bg-teal-50 text-teal-700 border-teal-200',
                                    'title' => 'Bergabung dengan Peternak Jatim',
                                    'desc' =>
                                        'Dapatkan akses Bimtek gratis, e-Tag Barcode, dan peluang pasar digital Jawa Timur.',
                                ],
                            ];
                        @endphp

                        <!-- Category Tag Badge at Top -->
                        <div class="mb-3">
                            <span id="slide-badge"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-2xs transition-all duration-300 {{ $slides[0]['tag_color'] }}">
                                {{ $slides[0]['tag'] }}
                            </span>
                        </div>

                        <!-- Floating Animated Icon Stage (Clean & Background-Free) -->
                        <div class="relative w-full h-64 sm:h-72 flex items-center justify-center group my-1">

                            <!-- Ambient glowing aura behind floating icon -->
                            <div
                                class="absolute w-52 h-52 sm:w-60 sm:h-60 rounded-full bg-gradient-to-tr from-emerald-200/50 via-sky-200/40 to-blue-200/50 blur-3xl pointer-events-none hero-pulse-aura">
                            </div>

                            <!-- Animated Floating Icons Wrapper -->
                            <div class="relative w-full h-full flex items-center justify-center hero-float-animation">
                                @foreach ($slides as $index => $slide)
                                    <div class="slide-item absolute inset-0 flex items-center justify-center p-2 transition-all duration-700 ease-out {{ $index === 0 ? 'opacity-100 scale-100 z-10' : 'opacity-0 scale-90 pointer-events-none z-0' }}"
                                        data-slide-index="{{ $index }}">
                                        <img src="{{ $slide['img'] }}" alt="{{ $slide['title'] }}"
                                            class="max-h-60 sm:max-h-68 w-auto object-contain filter drop-shadow-2xl transition-transform duration-500 hover:scale-105 select-none" />
                                    </div>
                                @endforeach
                            </div>

                            <!-- Previous / Next Controls -->
                            <button type="button" onclick="prevSlide()" aria-label="Slide sebelumnya"
                                class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 shadow-md border border-slate-200/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button type="button" onclick="nextSlide()" aria-label="Slide berikutnya"
                                class="absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 shadow-md border border-slate-200/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        <!-- Slide Text Caption -->
                        <div class="px-2 pt-2 text-center min-h-[72px] flex flex-col justify-center">
                            <h2 id="slide-title"
                                class="text-sm font-bold text-slate-900 transition-opacity duration-300">
                                {{ $slides[0]['title'] }}
                            </h2>
                            <p id="slide-desc"
                                class="text-xs text-slate-500 mt-1 transition-opacity duration-300 line-clamp-2">
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
                badge.className =
                    `inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-2xs transition-all duration-300 ${slideData[currentSlide].tag_color}`;
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

        // Region Cascading Database (Jawa Timur)
        const regionData = {
            "Kabupaten Malang": {
                "Kepanjen": ["Ardirejo", "Cepokomulyo", "Curungrejo", "Jatirejoyoso", "Kepanjen", "Mangunrejo", "Panggungrejo", "Sengguruh", "Sukoraharjo", "Tegalsari"],
                "Singosari": ["Candirenggo", "Pagentan", "Losari", "Banjararum", "Dengkol", "Gunungrejo", "Klampok", "Purwoasri", "Tunjungtirto", "Watugede"],
                "Lawang": ["Kalirejo", "Lawang", "Bedali", "Ketindan", "Mulyoarjo", "Sidodadi", "Srigading", "Turirejo", "Wonorejo"],
                "Pujon": ["Bendosari", "Madiredo", "Ngabab", "Ngroto", "Pandansari", "Pujon Kidul", "Pujon Lor", "Sukomulyo", "Tawangsari", "Wiyurejo"],
                "Dau": ["Gadingkulon", "Kalirejo", "Karangwidoro", "Kucur", "Landungsari", "Petungsewu", "Selorejo", "Sumbersekar"],
                "Turen": ["Jeru", "Kedok", "Kemulan", "Pagedangan", "Sanankerto", "Sanankulon", "Sedayu", "Tawangrejeni", "Turen", "Undaan"]
            },
            "Kabupaten Blitar": {
                "Kanigoro": ["Bangle", "Gaprang", "Gogodeso", "Jatinom", "Kanigoro", "Karangsono", "Kuningan", "Minggirsari", "Papungan", "Satreyan", "Sawentar", "Tlogo"],
                "Srengat": ["Bagelenan", "Dandong", "Dermaji", "Karanggayam", "Kauman", "Kendalrejo", "Kerjen", "Maron", "Ngaglik", "Pakisrejo", "Purwokerto", "Selokajang", "Srengat", "Togogan", "Wonorejo"],
                "Wlingi": ["Babadan", "Balerejo", "Beru", "Kudusan", "Ngadirejo", "Tegalasri", "Tembalang", "Wlingi"],
                "Gandusari": ["Butun", "Gadungan", "Gandusari", "Gondang", "Kotes", "Krisik", "Ngaringan", "Semencen", "Slumbung", "Soso", "Sukosewu", "Sumberagung", "Tulungrejo"]
            },
            "Kabupaten Pasuruan": {
                "Purwosari": ["Bakalan", "Cendono", "Karangrejo", "Kayoman", "Kertosari", "Martopuro", "Pucangsari", "Purwosari", "Sekarmojo", "Sengonagung", "Sumberanyar", "Sumbersuko", "Tejowangi", "Wonorejo"],
                "Pandaan": ["Banjarsari", "Durensewu", "Jogosari", "Kebonwaru", "Kemirisewu", "Kutorejo", "Nogosari", "Pandaan", "Petungasri", "Plintahan", "Sebani", "Sumber Gedang", "Sumberrejo", "Tawangrejo", "Tunggulwulung", "Wedoro"],
                "Prigen": ["Bulukandang", "Candi Wates", "Dayurejo", "Gambiran", "Jatiarjo", "Ledug", "Lumbangrejo", "Prigen", "Sekarjoho", "Sukolilo", "Sukoreno", "Watuagung"],
                "Grati": ["Cukurgondang", "Gratitunon", "Kalipang", "Kambingan Rejo", "Keboncandi", "Kedawung Kulon", "Kedawung Wetan", "Plososari", "Ranuklindungan", "Rebalas", "Rowogembong", "Sumberagung", "Sumberdawesari", "Trewung", "Wotgalih"]
            },
            "Kabupaten Lamongan": {
                "Lamongan": ["Banjarmendalan", "Jetis", "Sidoharjo", "Sidokumpul", "Sukomulyo", "Sukorejo", "Tlogoanyar", "Kebet", "Kramat", "Made", "Plosowahyu", "Rancangkencono", "Sendangrejo", "Sidorejo", "Sumberjo", "Tanjung", "Wajik"],
                "Babat": ["Babat", "Banaran", "Bedahan", "Datinawong", "Gendong Kulon", "Karang Kembang", "Kebalandono", "Kebalanpelang", "Keyongan", "Kuripan", "Moropelang", "Pabuaran", "Plaosan", "Pucakwangi", "Sambangan", "Sogo", "Sumuragung", "Trepan", "Tritunggal"],
                "Tikung": ["Bakalanpule", "Balongwangi", "Banter", "Botoputih", "Dukuhagung", "Guminingrejo", "Jatirejo", "Kelorarum", "Pengumbulanadi", "Soko", "Takerankelenting", "Wonokromo"]
            },
            "Kabupaten Bojonegoro": {
                "Bojonegoro": ["Campurejo", "Dander", "Kadipaten", "Karang Pacar", "Kauman", "Klangon", "Ledok Kulon", "Ledok Wetan", "Mojokampung", "Mulyoagung", "Ngrowo", "Pacul", "Semanding", "Sukorejo", "Sumbang"],
                "Dander": ["Dander", "Jatiblimbing", "Karangsono", "Kunci", "Ngablak", "Ngunut", "Sendangrejo", "Somodikaran", "Sumberagung", "Sumberarum", "Sumbertlaseh", "Sumodikaran"],
                "Kapas": ["Bakat", "Bangilan", "Bogo", "Kapas", "Kedaton", "Klampok", "Mojodeso", "Ngampel", "Padang Mentoyo", "Plesungan", "Sambiroto", "Sembung", "Semanding", "Sukowati", "Tanjungharjo", "Tapelan", "Wedi"]
            },
            "Kota Surabaya": {
                "Wonokromo": ["Darmo", "Jagir", "Ngagel", "Ngagelrejo", "Sawunggaling", "Wonokromo"],
                "Gubeng": ["Airlangga", "Barata Jaya", "Gubeng", "Kertajaya", "Mojo", "Pucang Sewu"],
                "Sukolilo": ["Gebang Putih", "Keputih", "Klampis Ngasem", "Medokan Semampir", "Menur Pumpungan", "Nginden Jangkungan", "Semolowaru"],
                "Rungkut": ["Kalirungkut", "Kedung Baruk", "Medokan Ayu", "Penjaringan Sari", "Rungkut Kidul", "Wonorejo"]
            },
            "Kota Batu": {
                "Batu": ["Oro-Oro Ombo", "Pesanggrahan", "Sidomulyo", "Sumberejo", "Ngaglik", "Sisir", "Songgokerto", "Temas"],
                "Bumiaji": ["Bumiaji", "Giripurno", "Gunungsari", "Pandanrejo", "Punten", "Sumber Brantas", "Sumbergondo", "Tulungrejo"],
                "Junrejo": ["Beji", "Junrejo", "Mojorejo", "Pendem", "Tlekung", "Torongrejo", "Dadaprejo"]
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
            } else {
                const cleanName = kabupaten.replace(/Kabupaten |Kota /g, '');
                kecamatans = [`${cleanName} Kota`, `${cleanName} Barat`, `${cleanName} Timur`, `${cleanName} Selatan`, `${cleanName} Utara`, 'Kecamatan Lainnya'];
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
            } else {
                desas = ['Desa Sentra Ternak 1', 'Desa Sentra Ternak 2', 'Desa Maju Makmur', 'Desa Sukamaju', 'Kelurahan / Desa Lainnya'];
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

        // Restore old inputs if present
        document.addEventListener('DOMContentLoaded', () => {
            const oldKab = @json(old('kabupaten'));
            const oldKec = @json(old('kecamatan'));
            const oldDesa = @json(old('desa'));

            if (oldKab) {
                handleKabupatenChange(oldKab, oldKec, oldDesa);
            }
        });
    </script>
</body>

</html>

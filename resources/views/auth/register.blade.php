<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru — Peternak Milenial Jawa Timur</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    <!-- Flowbite & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

    <!-- Main Content Area: Spacious & Refined Split Layout -->
    <main class="flex-1 flex items-start justify-center py-8 sm:py-12 lg:py-16 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-start">

            <!-- LEFT COLUMN: Register Card (Spacious, Well-Organized & Clean Theme) -->
            <div class="lg:col-span-7 xl:col-span-8 w-full">
                <div
                    class="bg-white/95 border border-slate-200/90 rounded-3xl p-6 sm:p-10 lg:p-12 shadow-xl shadow-slate-200/50 backdrop-blur">

                    <!-- Brand Header with Official Logo from img/ -->
                    <div class="flex items-center justify-between mb-8 pb-5 border-b border-slate-100">
                        <a href="{{ route('landing') }}" class="flex items-center group" title="Kembali ke Beranda">
                            <img src="{{ asset('img/logoaplikasi2.png') }}" alt="Peternak Milenial Jawa Timur"
                                class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                        </a>
                        <a href="{{ route('landing') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-blue-600 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            <span>Halaman Utama</span>
                        </a>
                    </div>

                    <!-- Heading & Subtitle -->
                    <div class="text-center mb-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/70 mb-3">
                            Pendaftaran Peternak Milenial Jatim
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Sign up
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-2 leading-relaxed">
                            Lengkapi data diri, wilayah domisili, dan usaha peternakan Anda untuk mulai mengakses ekosistem digital Dinas Peternakan Jawa Timur.
                        </p>
                    </div>

                    <!-- Flash Errors -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs">
                            <div class="font-semibold mb-1.5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                Mohon perbaiki data formulir berikut:
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-red-700 ml-1">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Register Form (Spacious Logical Grouping) -->
                    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
                        @csrf
                        <input type="hidden" name="role" value="peternak">
                        <input type="hidden" name="terms" value="1">

                        <!-- SECTION 1: Identitas & Kontak -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-4 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200/70">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xs sm:text-sm font-bold text-slate-900">Identitas Diri &amp; Kontak</h2>
                                    <p class="text-[11px] text-slate-500">Informasi utama untuk verifikasi keanggotaan peternak</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="name" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Nama Lengkap<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        placeholder="Nama Lengkap"
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 placeholder-slate-400 shadow-2xs transition">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Email<span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        placeholder="Email"
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 placeholder-slate-400 shadow-2xs transition">
                                </div>

                                <!-- No Telpon (WA) -->
                                <div>
                                    <label for="phone_number" class="block mb-2 text-xs font-semibold text-slate-700">
                                        No Telpon (WA)<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                                        placeholder="628xxxxxxxxxx"
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 placeholder-slate-400 shadow-2xs transition">
                                </div>

                                <!-- NIK -->
                                <div>
                                    <label for="nik" class="block mb-2 text-xs font-semibold text-slate-700">
                                        NIK<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" required
                                        placeholder="NIK"
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 placeholder-slate-400 shadow-2xs transition">
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="sm:col-span-2">
                                    <label for="birth_date" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Tanggal Lahir<span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 placeholder-slate-400 shadow-2xs transition cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Wilayah Domisili (Jawa Timur) -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-4 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200/70">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xs sm:text-sm font-bold text-slate-900">Wilayah Domisili (Jawa Timur)</h2>
                                    <p class="text-[11px] text-slate-500">Penentuan sentra binaan dan penugasan petugas pendamping</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Kabupaten/Kota -->
                                <div class="sm:col-span-2">
                                    <label for="kabupaten" class="block mb-2 text-xs font-semibold text-slate-700">
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
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 shadow-2xs transition cursor-pointer">
                                        <option value="" disabled {{ old('kabupaten') ? '' : 'selected' }}>Pilih Kabupaten...</option>
                                        @foreach ($jatimKabupatens as $kab)
                                            <option value="{{ $kab }}" {{ old('kabupaten') == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kecamatan -->
                                <div>
                                    <label for="kecamatan" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Kecamatan<span class="text-red-500">*</span>
                                    </label>
                                    <select name="kecamatan" id="kecamatan" required onchange="handleKecamatanChange(this.value)"
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 shadow-2xs transition cursor-pointer">
                                        <option value="" disabled {{ old('kecamatan') ? '' : 'selected' }}>Pilih Kecamatan...</option>
                                        @if(old('kecamatan'))
                                            <option value="{{ old('kecamatan') }}" selected>{{ old('kecamatan') }}</option>
                                        @endif
                                    </select>
                                </div>

                                <!-- Kelurahan/Desa -->
                                <div>
                                    <label for="desa" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Kelurahan/Desa<span class="text-red-500">*</span>
                                    </label>
                                    <select name="desa" id="desa" required
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 shadow-2xs transition cursor-pointer">
                                        <option value="" disabled {{ old('desa') ? '' : 'selected' }}>Pilih Desa...</option>
                                        @if(old('desa'))
                                            <option value="{{ old('desa') }}" selected>{{ old('desa') }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Profil Usaha Peternakan -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-4 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200/70">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xs sm:text-sm font-bold text-slate-900">Profil Usaha Peternakan</h2>
                                    <p class="text-[11px] text-slate-500">Komoditas ternak yang sedang Anda budidayakan</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Ternak yang Dimiliki -->
                                <div>
                                    <label for="livestock_type" class="block mb-2 text-xs font-semibold text-slate-700">
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
                                        class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 shadow-2xs transition cursor-pointer">
                                        <option value="" disabled {{ old('livestock_type') ? '' : 'selected' }}>Pilih ...</option>
                                        @foreach ($livestockOptions as $opt)
                                            <option value="{{ $opt }}" {{ old('livestock_type') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jumlah Ternak yang Dimiliki -->
                                <div>
                                    <label for="livestock_count" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Jumlah Ternak yang Dimiliki<span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" min="0" name="livestock_count" id="livestock_count" value="{{ old('livestock_count') }}" required
                                            placeholder="Jumlah Ternak yang Dimiliki (per ekor)"
                                            class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 pr-16 placeholder-slate-400 shadow-2xs transition">
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs font-semibold text-slate-400 pointer-events-none">
                                            Ekor
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: Keamanan & Berkas Verifikasi -->
                        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-4 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200/70">
                                <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xs sm:text-sm font-bold text-slate-900">Keamanan Akun &amp; Berkas Identitas</h2>
                                    <p class="text-[11px] text-slate-500">Kata sandi akun dan unggah foto KTP resmi untuk validasi</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Password Baru -->
                                <div>
                                    <label for="password" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Password Baru<span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" required placeholder="Password Baru"
                                            class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 pr-11 placeholder-slate-400 shadow-2xs transition">
                                        <button type="button" onclick="togglePasswordVisibility('password', 'password-eye-icon')" aria-label="Lihat kata sandi"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                            <svg id="password-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div>
                                    <label for="password_confirmation" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Konfirmasi Password<span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi Password"
                                            class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full px-3.5 py-3 pr-11 placeholder-slate-400 shadow-2xs transition">
                                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'password_confirmation-eye-icon')" aria-label="Lihat konfirmasi kata sandi"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                            <svg id="password_confirmation-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Foto Berkas KTP (Spacious Styled Dropzone Container) -->
                                <div class="sm:col-span-2">
                                    <label for="ktp_file" class="block mb-2 text-xs font-semibold text-slate-700">
                                        Foto Berkas KTP<span class="text-red-500">*</span>
                                    </label>
                                    <div class="p-4 sm:p-5 border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-2xl bg-white hover:bg-blue-50/20 transition group">
                                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 text-center sm:text-left">
                                                <input type="file" name="ktp_file" id="ktp_file" accept=".jpeg,.png,.jpg"
                                                    class="block w-full text-xs sm:text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer transition" />
                                                <div class="mt-2.5 flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1 text-[11px] sm:text-xs text-slate-500 font-normal">
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                        * Besar Max 10 MB
                                                    </span>
                                                    <span class="inline-flex items-center gap-1">
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

                        <!-- Submit Button & Login Link -->
                        <div class="pt-3 space-y-4">
                            <button type="submit"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 font-bold rounded-xl text-sm sm:text-base py-3.5 sm:py-4 text-center transition duration-200 shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/35 cursor-pointer flex items-center justify-center gap-2">
                                <span>Sign Up</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>

                            <p class="text-xs sm:text-sm text-center text-slate-500">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                    class="text-blue-600 hover:text-blue-700 font-bold hover:underline transition ml-1">
                                    Masuk di sini.
                                </a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

            <!-- RIGHT COLUMN: Illustration Container (Sticky & Balanced) -->
            <div class="lg:col-span-5 xl:col-span-4 hidden lg:flex flex-col items-center justify-start sticky top-8">
                <div class="relative w-full max-w-md" id="illustration-slider-container">
                    <!-- Subtle ambient backlight glow behind card -->
                    <div
                        class="absolute -inset-3 bg-gradient-to-r from-blue-200/50 via-emerald-200/40 to-teal-100/50 rounded-3xl blur-2xl opacity-70">
                    </div>

                    <!-- Illustration Container Card -->
                    <div
                        class="relative bg-white/95 border border-slate-200/90 rounded-3xl overflow-hidden p-6 sm:p-7 shadow-xl backdrop-blur flex flex-col items-center">
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

                    <!-- Benefit / Trust Badges -->
                    <div class="w-full mt-5 p-4 sm:p-5 bg-white/80 border border-slate-200/80 rounded-2xl shadow-sm backdrop-blur space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Bimbingan Teknis &amp; Sertifikat</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed">Akses modul pelatihan, e-sertifikat resmi, dan e-Tag barcode ternak.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Pasar Digital Peternak Jatim</h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed">Jual beli komoditas langsung tanpa perantara dengan transparansi harga.</p>
                            </div>
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

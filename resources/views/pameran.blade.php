@extends('layouts.app')

@section('title', 'Pameran & Kalender Terpadu — Peternak Milenial Jatim')

@section('content')
@php
    $activeTab = $activeTab ?? request('tab', 'agenda');
    if (!in_array($activeTab, ['agenda', 'stand', 'kalender'])) {
        $activeTab = 'agenda';
    }
    $isAdmin = auth()->check() && auth()->user()->isAdmin();
    $isPeternak = auth()->check() && auth()->user()->isPeternak();
@endphp

<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col gap-4 pb-5 sm:pb-6 border-b border-gray-200 dark:border-gray-800">
        <!-- Top Row: Department Info, Title, Subtitle & Action Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-snug">
                    @if($activeTab === 'agenda')
                        Pameran &amp; Agenda Expo
                    @elseif($activeTab === 'stand')
                        {{ $isAdmin ? 'Verifikasi Peserta Stand Pameran' : 'Daftar Stand & Pengajuan Peserta' }}
                    @elseif($activeTab === 'kalender')
                        Kalender Terpadu Kegiatan
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
                    @if($activeTab === 'agenda')
                        Temu bisnis, promosi komoditas unggulan peternak, dan pameran teknologi peternakan Jawa Timur.
                    @elseif($activeTab === 'stand')
                        {{ $isAdmin ? 'Verifikasi pengajuan kepesertaan stand pameran dinas dan alokasi booth peternak.' : 'Status pengajuan stand pameran dan fasilitas booth binaan Dinas Peternakan Jawa Timur.' }}
                    @elseif($activeTab === 'kalender')
                        Jadwal kegiatan resmi dinas, vaksinasi massal, bimtek lapangan, dan expo di 38 Kabupaten/Kota.
                    @endif
                </p>
            </div>

            <!-- Action Buttons on Top Right -->
            <div class="flex flex-wrap items-center gap-2 shrink-0 self-start md:self-center">
                @if($isAdmin)
                    @if($activeTab === 'agenda')
                        <button
                            type="button"
                            onclick="document.getElementById('form-tambah-pameran').classList.toggle('hidden')"
                            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                        >
                            + Buat Agenda Pameran
                        </button>
                        <a
                            href="{{ url('/pameran?tab=stand') }}"
                            class="inline-flex items-center text-xs font-medium text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 hover:bg-primary-100 border border-primary-200 dark:border-primary-800 px-3 py-2 rounded-lg transition"
                        >
                            Verifikasi Peserta ({{ $registrations->where('status', 'pending')->count() }})
                        </a>
                    @elseif($activeTab === 'stand')
                        <button
                            type="button"
                            onclick="document.getElementById('form-daftar-pameran').classList.toggle('hidden')"
                            class="inline-flex items-center text-xs font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg transition shadow-2xs"
                        >
                            + Daftarkan Peserta Baru
                        </button>
                    @elseif($activeTab === 'kalender')
                        <button
                            type="button"
                            onclick="document.getElementById('form-tambah-agenda').classList.toggle('hidden')"
                            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                        >
                            + Buat Agenda Kegiatan
                        </button>
                    @endif
                @elseif($isPeternak)
                    @if($activeTab === 'agenda' || $activeTab === 'stand')
                    <button
                        type="button"
                        onclick="document.getElementById('form-daftar-pameran').classList.toggle('hidden')"
                        class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
                    >
                        + Ajukan Stand Pameran
                    </button>
                    @endif
                @endif
            </div>
        </div>

        <!-- Bottom Row: Clean Tab Navigation Bar -->
        <div class="flex items-center overflow-x-auto pt-1">
            <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-0.5 text-xs shadow-2xs">
                <a
                    href="{{ url('/pameran?tab=agenda') }}"
                    class="px-3.5 py-1.5 rounded-md font-medium transition {{ $activeTab === 'agenda' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Agenda Pameran
                </a>
                <a
                    href="{{ url('/pameran?tab=stand') }}"
                    class="px-3.5 py-1.5 rounded-md font-medium transition {{ $activeTab === 'stand' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    {{ $isAdmin ? 'Verifikasi Peserta (' . $registrations->count() . ')' : 'Stand Terdaftar (' . $registrations->count() . ')' }}
                </a>
                <a
                    href="{{ url('/pameran?tab=kalender') }}"
                    class="px-3.5 py-1.5 rounded-md font-medium transition {{ $activeTab === 'kalender' ? 'bg-primary-700 text-white font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    Kalender Terpadu ({{ $calendarEvents->count() }})
                </a>
            </div>
        </div>
    </div>

    <!-- Alert / Flash Messages -->
    @if(session('success'))
    <div class="p-3 text-xs text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 dark:hover:text-white">✕</button>
    </div>
    @endif

    @if(session('error'))
    <div class="p-3 text-xs text-red-800 bg-red-50 rounded-lg border border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 dark:hover:text-white">✕</button>
    </div>
    @endif

    @if($isAdmin)
    <!-- Form Tambah Agenda Pameran Baru (Admin Only - Collapsible) -->
    <div id="form-tambah-pameran" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Buat Agenda Pameran / Expo Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Publikasikan agenda pameran peternakan resmi Dinas Jawa Timur.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-tambah-pameran').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('pameran.exhibition.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div class="md:col-span-2">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pameran / Expo <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Jatim Dairy & Livestock Expo 2026" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas Stand (Booth) <span class="text-red-500">*</span></label>
                <input type="number" name="stand_capacity" required min="1" value="100" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" required value="{{ date('Y-m-d', strtotime('+14 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                <input type="date" name="end_date" required value="{{ date('Y-m-d', strtotime('+16 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Gedung / Tempat <span class="text-red-500">*</span></label>
                <input type="text" name="location" required placeholder="Grand City Convex, Surabaya" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Isi Kegiatan Acara <span class="text-red-500">*</span></label>
                <textarea name="description" rows="2" required placeholder="Jelaskan tema pameran, agenda lelang/temu bisnis, target buyer, dan materi kegiatan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Fasilitas Stand &amp; Peserta (Pisahkan dengan koma)</label>
                <input type="text" name="facilities" placeholder="Booth Stand 3x3m, Meja & Kursi, Listrik 450W, Chiller Pendingin, Sertifikat Resmi Disnak" value="Booth Stand 3x3m, Meja Display Kaca & Kursi, Daya Listrik & Pendingin Chiller, Business Matching Buyer Modern, Sertifikat Resmi Disnak Jatim" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3 flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_featured" value="1" checked class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span>Jadikan sebagai Pameran Utama (Featured Agenda)</span>
                </label>
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Terbitkan Agenda Pameran
                </button>
            </div>
        </form>
    </div>

    <!-- Form Tambah Agenda Kegiatan Kalender Baru (Admin Only - Collapsible) -->
    <div id="form-tambah-agenda" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Buat Agenda Kegiatan Peternakan Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Jadwal kegiatan veteriner, vaksinasi, bimtek, atau pasar ternak di Jawa Timur.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-tambah-agenda').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('pameran.calendar.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Vaksinasi PMK Booster Serentak" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Kegiatan <span class="text-red-500">*</span></label>
                <select name="event_type" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="vaksinasi">Vaksinasi Massal</option>
                    <option value="pelatihan">Bimtek &amp; Pelatihan</option>
                    <option value="pameran">Pameran &amp; Temu Bisnis</option>
                    <option value="pasar_ternak">Pasar Hewan / Lelang</option>
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                <input type="date" name="event_date" required value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten/Kota (Opsional)</label>
                <select name="region_id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    <option value="">-- Seluruh Wilayah Jatim --</option>
                    @foreach ($regions as $reg)
                        <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Detail <span class="text-red-500">*</span></label>
                <input type="text" name="location" required placeholder="Kecamatan Purwosari, Kabupaten Pasuruan" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan / Sasaran Peternak</label>
                <input type="text" name="description" placeholder="Sasaran 500 ekor sapi perah rakyat kelompok peternak binaan..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3 flex justify-end gap-2 pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    Simpan Agenda Kegiatan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Form Pengajuan Stand (Collapsible) -->
    <div id="form-daftar-pameran" class="hidden bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ $isAdmin ? 'Daftarkan Peserta Stand Baru' : 'Pengajuan Stand Pameran Peternak' }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Fasilitas stand pameran binaan Dinas Peternakan Provinsi Jawa Timur.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-daftar-pameran').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
        </div>

        <form action="{{ route('pameran.register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Usaha / Kelompok Ternak <span class="text-red-500">*</span></label>
                <input type="text" name="business_name" required value="{{ $isPeternak ? (auth()->user()?->name ?? '') : '' }}" placeholder="Nama usaha atau kelompok ternak" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pilihan Pameran <span class="text-red-500">*</span></label>
                <select name="exhibition_id" id="select-exhibition-id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    @foreach ($exhibitions as $ex)
                        <option value="{{ $ex->id }}">{{ $ex->title }} ({{ $ex->location }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Produk yang Dipamerkan <span class="text-red-500">*</span></label>
                <input type="text" name="exhibited_products" required placeholder="Contoh: Susu Pasteurisasi & Keju Mozzarella" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Kebutuhan Stand (Opsional)</label>
                <input type="text" name="notes" placeholder="Contoh: Membutuhkan pasokan listrik freezer chiller 1000W" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
            </div>
            <div class="md:col-span-3 flex justify-end gap-2 pt-1">
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                    {{ $isAdmin ? 'Simpan Peserta Stand' : 'Kirim Pengajuan Stand' }}
                </button>
            </div>
        </form>
    </div>

    {{-- ======================================================== --}}
    {{-- TAB 1: AGENDA PAMERAN & EXPO                             --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'agenda')
    <!-- Section: Daftar Agenda Pameran (Format Kotak-Kotak / Card Grid) -->
    <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            @forelse ($exhibitions as $expo)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border {{ $expo->is_featured ? 'border-primary-300 dark:border-primary-700/80 ring-1 ring-primary-500/20 shadow-xs' : 'border-gray-200 dark:border-gray-700 shadow-2xs' }} p-4 sm:p-5 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <!-- Header Card: Badge & Admin Action Buttons (Edit & Hapus) -->
                    <div class="flex items-center justify-between gap-2 mb-2.5">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            @if ($expo->is_featured)
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-primary-700 dark:bg-blue-950/70 dark:text-primary-300 border border-blue-200/60 dark:border-blue-800">
                                <svg class="w-3 h-3 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Agenda Utama
                            </span>
                            @else
                            <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                Agenda Pameran
                            </span>
                            @endif

                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                                Subsidi 100%
                            </span>
                        </div>

                        @if ($isAdmin)
                        <div class="flex items-center gap-1 shrink-0">
                            <!-- Tombol Edit -->
                            <button
                                type="button"
                                onclick="document.getElementById('modal-edit-expo-{{ $expo->id }}').classList.remove('hidden')"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-primary-700 hover:bg-blue-50 dark:hover:bg-gray-700 transition"
                                title="Edit Agenda Pameran"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </button>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('pameran.exhibition.destroy', $expo) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda pameran \'{{ $expo->title }}\'?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-gray-700 transition"
                                    title="Hapus Agenda Pameran"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Judul & Isi Kegiatan (Overview) -->
                    <h3 class="text-base font-bold text-gray-900 dark:text-white leading-snug">
                        {{ $expo->title }}
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed line-clamp-2">
                        {{ $expo->description }}
                    </p>

                    <!-- Key Event Specs -->
                    <div class="mt-3 space-y-1.5 text-xs">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            <span class="font-medium text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($expo->start_date)->format('d M') }} &ndash; {{ \Carbon\Carbon::parse($expo->end_date)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span class="truncate">{{ $expo->location }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.651V9.35m0 0a3.001 3.001 0 003.75-.614A2.993 2.993 0 009 9.35c.704 0 1.352-.243 1.868-.654a3.004 3.004 0 004.264 0A2.993 2.993 0 0017 9.35a3.001 3.001 0 003.75-.614M3.75 9.349L3 3h18l-.75 6.349" /></svg>
                            <span>Stand: <strong class="text-gray-900 dark:text-white">{{ $expo->registered_stands_count }} / {{ $expo->stand_capacity }}</strong> ({{ max(0, $expo->stand_capacity - $expo->registered_stands_count) }} Tersedia)</span>
                        </div>
                    </div>

                    <!-- Highlight Fasilitas Stand & Peserta -->
                    <div class="mt-3.5 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <div class="text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                            <span>Fasilitas Stand Binaan:</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @php
                                $facilityList = array_filter(array_map('trim', explode(',', $expo->facilities ?? 'Booth Stand 3x3m, Meja & Kursi, Daya Listrik & Chiller, Business Matching, Sertifikat Resmi')));
                            @endphp
                            @foreach (array_slice($facilityList, 0, 3) as $fac)
                            <span class="inline-flex items-center text-[10px] px-2 py-0.5 rounded-md bg-cyan-50 dark:bg-cyan-950/50 text-cyan-700 dark:text-cyan-300 border border-cyan-200/50 dark:border-cyan-800/50">
                                ✓ {{ $fac }}
                            </span>
                            @endforeach
                            @if (count($facilityList) > 3)
                            <span class="inline-flex items-center text-[10px] px-1.5 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                +{{ count($facilityList) - 3 }} Lainnya
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Card Action Buttons -->
                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <button
                        type="button"
                        onclick="document.getElementById('modal-detail-expo-{{ $expo->id }}').classList.remove('hidden')"
                        class="flex-1 py-2 px-3 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-650 text-gray-800 dark:text-gray-200 text-xs font-semibold rounded-lg transition"
                    >
                        Lihat Fasilitas &amp; Isi
                    </button>

                    @if ($isAdmin)
                    <a
                        href="{{ route('pameran', ['tab' => 'stand']) }}"
                        class="py-2 px-3 text-center bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-lg transition shadow-2xs"
                        title="Verifikasi Pengajuan Stand Peserta"
                    >
                        Stand ({{ $expo->registered_stands_count }})
                    </a>
                    @elseif ($isPeternak)
                    <button
                        type="button"
                        onclick="openDaftarStandModal({{ $expo->id }})"
                        class="py-2 px-3 text-center bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-lg transition shadow-2xs"
                    >
                        Ajukan Stand
                    </button>
                    @endif
                </div>
            </div>

            <!-- Modal: Lihat Detail, Fasilitas & Isi Kegiatan -->
            <div id="modal-detail-expo-{{ $expo->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative animate-in fade-in duration-200">
                    <button type="button" onclick="document.getElementById('modal-detail-expo-{{ $expo->id }}').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-lg">✕</button>

                    <div class="flex items-center gap-2 mb-2">
                        @if ($expo->is_featured)
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-primary-700 dark:bg-blue-950/70 dark:text-primary-300 border border-blue-200/60 dark:border-blue-800">
                            ★ Agenda Utama Dinas
                        </span>
                        @endif
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                            Fasilitas Subsidi 100%
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-snug">
                        {{ $expo->title }}
                    </h3>

                    <div class="mt-4 space-y-3.5 text-xs">
                        <!-- Rincian Isi & Kegiatan -->
                        <div class="p-3 bg-gray-50 dark:bg-gray-750/40 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="font-bold text-gray-900 dark:text-white block mb-1">📋 Isi &amp; Fokus Rangkaian Acara:</span>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-[11px] whitespace-pre-line">
                                {{ $expo->description }}
                            </p>
                        </div>

                        <!-- Rincian Fasilitas Stand & Peserta -->
                        <div class="p-3 bg-cyan-50/50 dark:bg-cyan-950/30 rounded-xl border border-cyan-100 dark:border-cyan-800/40">
                            <span class="font-bold text-cyan-900 dark:text-cyan-200 block mb-1.5 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-cyan-700 dark:text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                                Fasilitas yang Disediakan Untuk Peserta:
                            </span>
                            <ul class="space-y-1.5 text-[11px] text-gray-700 dark:text-gray-300">
                                @foreach ($facilityList as $facItem)
                                <li class="flex items-start gap-1.5">
                                    <span class="text-cyan-600 dark:text-cyan-400 font-bold shrink-0">✓</span>
                                    <span>{{ $facItem }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Detail Pelaksanaan -->
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div class="p-2.5 bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-gray-100 dark:border-gray-700">
                                <span class="text-gray-400 block text-[10px]">Jadwal Pelaksanaan</span>
                                <strong class="text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($expo->start_date)->format('d M') }} &ndash; {{ \Carbon\Carbon::parse($expo->end_date)->format('d M Y') }}</strong>
                            </div>
                            <div class="p-2.5 bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-gray-100 dark:border-gray-700">
                                <span class="text-gray-400 block text-[10px]">Lokasi Gedung / Tempat</span>
                                <strong class="text-gray-800 dark:text-gray-200">{{ $expo->location }}</strong>
                            </div>
                            <div class="p-2.5 bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-gray-100 dark:border-gray-700 col-span-2">
                                <span class="text-gray-400 block text-[10px]">Alokasi Stand Booth</span>
                                <strong class="text-gray-800 dark:text-gray-200">{{ $expo->registered_stands_count }} Terdaftar dari {{ $expo->stand_capacity }} Kuota (Tersedia: {{ max(0, $expo->stand_capacity - $expo->registered_stands_count) }} Stand)</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end gap-2">
                        <button
                            type="button"
                            onclick="document.getElementById('modal-detail-expo-{{ $expo->id }}').classList.add('hidden')"
                            class="px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition"
                        >
                            Tutup
                        </button>
                        @if ($isPeternak)
                        <button
                            type="button"
                            onclick="document.getElementById('modal-detail-expo-{{ $expo->id }}').classList.add('hidden'); openDaftarStandModal({{ $expo->id }});"
                            class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-xs transition"
                        >
                            Ajukan Stand Sekarang
                        </button>
                        @elseif ($isAdmin)
                        <button
                            type="button"
                            onclick="document.getElementById('modal-detail-expo-{{ $expo->id }}').classList.add('hidden'); document.getElementById('modal-edit-expo-{{ $expo->id }}').classList.remove('hidden');"
                            class="px-4 py-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-xs transition"
                        >
                            Edit Pameran Ini
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal: Edit Agenda Pameran (Admin Only) -->
            @if ($isAdmin)
            <div id="modal-edit-expo-{{ $expo->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl border border-gray-200 dark:border-gray-700 relative animate-in fade-in duration-200">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Agenda Pameran / Expo</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Perbarui rincian kegiatan, fasilitas binaan, dan kapasitas stand.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('modal-edit-expo-{{ $expo->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">✕</button>
                    </div>

                    <form action="{{ route('pameran.exhibition.update', $expo) }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pameran / Expo <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required value="{{ $expo->title }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas Stand <span class="text-red-500">*</span></label>
                                <input type="number" name="stand_capacity" required min="1" value="{{ $expo->stand_capacity }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Tempat <span class="text-red-500">*</span></label>
                                <input type="text" name="location" required value="{{ $expo->location }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" required value="{{ \Carbon\Carbon::parse($expo->start_date)->format('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" required value="{{ \Carbon\Carbon::parse($expo->end_date)->format('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Isi Kegiatan Acara <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="2" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">{{ $expo->description }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Fasilitas Stand &amp; Peserta (Pisahkan dengan koma)</label>
                            <textarea name="facilities" rows="2" placeholder="Booth Stand 3x3m, Meja & Kursi, Listrik 450W, Chiller Susu, Sertifikat Resmi" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">{{ $expo->facilities }}</textarea>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-gray-700 dark:text-gray-300 text-xs">
                                <input type="checkbox" name="is_featured" value="1" {{ $expo->is_featured ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span>Jadikan Agenda Utama</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="document.getElementById('modal-edit-expo-{{ $expo->id }}').classList.add('hidden')" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition font-medium">
                                    Batal
                                </button>
                                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-1.5 rounded-lg shadow-xs transition">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @empty
            <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-8 text-center shadow-xs">
                <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada agenda pameran</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Agenda pameran dan temu bisnis peternakan akan ditampilkan setelah dipublikasikan oleh Admin Dinas.</p>
            </div>
            @endforelse
        </div>
    </div>

    @endif

    {{-- ======================================================== --}}
    {{-- TAB 2: STAND TERDAFTAR & VERIFIKASI PESERTA             --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'stand')
    <!-- Executive KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- KPI 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pengajuan Stand</span>
                    <span class="p-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                        {{ $registrations->count() }} Pelaku Usaha
                    </span>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Peternak &amp; UMKM Binaan Terdaftar
            </p>
        </div>

        <!-- KPI 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Stand Terverifikasi</span>
                    <span class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-emerald-700 dark:text-emerald-400">
                        {{ $registrations->where('status', 'approved')->count() }} Disetujui
                    </span>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Memperoleh Nomor Booth Resmi
            </p>
        </div>

        <!-- KPI 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Menunggu Persetujuan</span>
                    <span class="p-1 rounded-md bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-amber-600 dark:text-amber-400">
                        {{ $registrations->where('status', 'pending')->count() }} Menunggu
                    </span>
                    @if($registrations->where('status', 'rejected')->count() > 0)
                    <span class="text-xs text-red-600 dark:text-red-400 font-medium">
                        · {{ $registrations->where('status', 'rejected')->count() }} Ditolak
                    </span>
                    @endif
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Verifikasi Dokumen Oleh Admin Dinas
            </p>
        </div>
    </div>

    <!-- Tabel Verifikasi Peserta / Stand Terdaftar -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ $isAdmin ? 'Panel Verifikasi Peserta Stand Pameran' : 'Daftar Pengajuan Stand Pameran' }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $isAdmin ? 'Kelola persetujuan, tolak permohonan, atau alokasikan nomor stand pameran binaan.' : 'Daftar peserta terdaftar dan status fasilitas stand pameran dinas.' }}
                </p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                Total: {{ $registrations->count() }} Stand
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                    <tr>
                        <th class="px-3.5 py-2.5">Nomor Stand</th>
                        <th class="px-3.5 py-2.5">Nama Usaha / Peternak</th>
                        <th class="px-3.5 py-2.5">Pameran</th>
                        <th class="px-3.5 py-2.5">Produk Dipamerkan</th>
                        <th class="px-3.5 py-2.5">Status</th>
                        <th class="px-3.5 py-2.5 text-right">Aksi {{ $isAdmin ? 'Verifikasi' : '' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($registrations as $reg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-primary-700 dark:bg-blue-950/60 dark:text-primary-300">
                                {{ $reg->stand_number ?? 'STD-BELUM' }}
                            </span>
                        </td>
                        <td class="px-3.5 py-2.5 font-medium text-gray-800 dark:text-gray-200">
                            <div>{{ $reg->business_name }}</div>
                            @if($isAdmin && $reg->user)
                                <div class="text-[10px] text-gray-400">{{ $reg->user->name }} ({{ $reg->user->email }})</div>
                            @endif
                        </td>
                        <td class="px-3.5 py-2.5">{{ $reg->exhibition?->title ?? 'Pameran' }}</td>
                        <td class="px-3.5 py-2.5">
                            <div>{{ $reg->exhibited_products }}</div>
                            @if($reg->notes)
                                <div class="text-[10px] text-gray-400 italic mt-0.5">{{ $reg->notes }}</div>
                            @endif
                        </td>
                        <td class="px-3.5 py-2.5">
                            @if ($reg->status === 'approved')
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold px-2 py-0.5 rounded">Disetujui</span>
                            @elseif ($reg->status === 'pending')
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold px-2 py-0.5 rounded">Menunggu</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-[10px] font-semibold px-2 py-0.5 rounded">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-3.5 py-2.5 text-right space-x-1 whitespace-nowrap">
                            @if($isAdmin)
                                @if ($reg->status !== 'approved')
                                    <form action="{{ route('pameran.status', $reg) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2.5 py-1 rounded transition shadow-2xs" title="Setujui dan Terbitkan Nomor Stand">
                                            ✓ Setujui
                                        </button>
                                    </form>
                                @endif

                                @if ($reg->status !== 'rejected')
                                    <form action="{{ route('pameran.status', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Tolak permohonan stand {{ $reg->business_name }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-[10px] font-semibold px-2.5 py-1 rounded transition" title="Tolak Pengajuan">
                                            ✕ Tolak
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('pameran.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Hapus permanen data pengajuan stand {{ $reg->business_name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 text-xs font-medium ml-1">Hapus</button>
                                </form>
                            @else
                                @if(auth()->id() === $reg->user_id)
                                <form action="{{ route('pameran.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan pengajuan stand {{ $reg->business_name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Batalkan</button>
                                </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3.5 py-8 text-center text-gray-400 text-xs">Belum ada pengajuan stand pameran terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ======================================================== --}}
    {{-- TAB 3: KALENDER KEGIATAN TERPADU                         --}}
    {{-- ======================================================== --}}
    @if($activeTab === 'kalender')
    <!-- Executive KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
        <!-- KPI 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Agenda Terdata</span>
                    <span class="p-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                        {{ $calendarEvents->count() }} Kegiatan
                    </span>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Jadwal Resmi Seluruh Jawa Timur
            </p>
        </div>

        <!-- KPI 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Cakupan Wilayah</span>
                    <span class="p-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                        38 Kab / Kota
                    </span>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Terkoordinasi Disnak Provinsi
            </p>
        </div>

        <!-- KPI 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kategori Kegiatan</span>
                    <span class="p-1 rounded-md bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.38a15.094 15.094 0 005.82-5.82c.492-.827.32-1.908-.379-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                        Vaksinasi &amp; Expo
                    </span>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                Layanan Pembinaan &amp; Pemasaran
            </p>
        </div>
    </div>

    <!-- Daftar Agenda Kalender -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 sm:p-5 shadow-xs">
        <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Kalender Terpadu Kegiatan &amp; Agenda Dinas</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Jadwal kegiatan resmi peternakan di 38 Kabupaten/Kota.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-blue-50 text-primary-700 dark:bg-blue-950/60 dark:text-primary-300">
                Terdata: {{ $calendarEvents->count() }} Kegiatan
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-xs">
            @forelse ($calendarEvents as $event)
            <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full capitalize {{ $event->event_type === 'vaksinasi' ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300' : ($event->event_type === 'pelatihan' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300') }}">
                            {{ str_replace('_', ' ', $event->event_type) }}
                        </span>
                        <span class="text-[11px] text-gray-500 font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $event->title }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-[11px]">{{ $event->description }}</p>
                    <div class="mt-2.5 pt-2 border-t border-gray-200/60 dark:border-gray-600/60 text-gray-600 dark:text-gray-300 text-[11px] flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                Belum ada agenda kegiatan yang dijadwalkan.
            </div>
            @endforelse
        </div>
    </div>
    @endif
</div>

<script>
function openDaftarStandModal(exhibitionId) {
    const form = document.getElementById('form-daftar-pameran');
    if (form) {
        form.classList.remove('hidden');
        const select = document.getElementById('select-exhibition-id');
        if (select && exhibitionId) {
            select.value = exhibitionId;
        }
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>
@endsection

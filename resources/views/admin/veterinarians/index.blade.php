@extends('layouts.app')

@section('title', 'Manajemen Akun Dokter Hewan — Dinas Peternakan Jawa Timur')

@section('content')
<div class="space-y-6 sm:space-y-8 pt-1 sm:pt-2">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-primary-800 bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 rounded-md">
                    Otoritas Admin Dinas
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Provinsi Jawa Timur</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-1.5 leading-snug">
                Manajemen Akun Dokter Hewan Dinas
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Kelola akun profesional, penugasan wilayah, dan pantau efektivitas penanganan laporan kesehatan hewan ternak di Jawa Timur.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button
                type="button"
                onclick="document.getElementById('modal-buat-dokter').classList.remove('hidden')"
                class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-4 py-2.5 rounded-xl transition shadow-xs cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Buat Akun Dokter Hewan</span>
            </button>
        </div>
    </div>

    <!-- Banner Kredensial Dokter Hewan Baru Dibuat (Email & Password untuk Diserahkan ke Dokter) -->
    @if(session('newly_created_vet'))
    @php $createdVet = session('newly_created_vet'); @endphp
    <div id="card-new-vet-credentials" class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-950 shadow-xs space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-emerald-200 pb-2.5">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                <h3 class="font-bold text-sm sm:text-base text-emerald-900">
                    Akun Dokter Hewan Berhasil Dibuat oleh Admin!
                </h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-200 text-emerald-800">
                Kredensial Login Dokter Dinas
            </span>
        </div>

        <p class="text-xs text-emerald-800 leading-relaxed">
            Admin telah menetapkan email dan kata sandi untuk <strong>{{ $createdVet['name'] }}</strong>. Serahkan kredensial di bawah ini agar dokter dapat segera login ke Dashboard Dokter Hewan:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-white rounded-xl border border-emerald-200 text-xs">
            <div>
                <span class="text-[11px] font-semibold text-gray-500 block">Email Login (Username):</span>
                <span class="font-mono font-bold text-gray-900 text-xs select-all block mt-0.5" id="disp-vet-email">{{ $createdVet['email'] }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-gray-500 block">Kata Sandi Awal:</span>
                <span class="font-mono font-bold text-emerald-700 text-xs select-all block mt-0.5" id="disp-vet-pass">{{ $createdVet['password'] }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-gray-500 block">Puskeswan Penugasan:</span>
                <span class="font-medium text-gray-800 text-xs block mt-0.5">{{ $createdVet['puskeswan'] }}</span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-1">
            <span class="text-[11px] text-emerald-700">Dokter akan langsung masuk ke Dashboard Dokter Hewan saat login.</span>
            <button
                type="button"
                onclick="copyVetCredentials('{{ $createdVet['email'] }}', '{{ $createdVet['password'] }}', '{{ $createdVet['name'] }}')"
                id="btn-copy-vet"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition cursor-pointer shadow-xs"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                <span id="text-copy-vet">Salin Email &amp; Password</span>
            </button>
        </div>
    </div>
    @endif

    <!-- Monitoring Laporan Kesehatan Hewan (Section 2.A Master Prompt) -->
    <div class="space-y-2.5">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                Monitoring Status Penanganan Laporan Kesehatan Ternak Jawa Timur
            </h2>
            <span class="text-[11px] text-gray-400">Pembaruan Real-Time</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
                <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block">Total Laporan</span>
                <span class="text-xl font-bold text-gray-900 dark:text-white mt-0.5 block">{{ $reportMetrics['total'] }}</span>
                <span class="text-[10px] text-gray-400 mt-1 block">Seluruh Laporan</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-amber-200/80 dark:border-amber-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-amber-700 dark:text-amber-400">Menunggu Respons</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <span class="text-xl font-bold text-amber-700 dark:text-amber-400 mt-0.5 block">{{ $reportMetrics['menunggu_respons'] }}</span>
                <span class="text-[10px] text-amber-600/80 mt-1 block">Belum Ditanggapi</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-blue-200/80 dark:border-blue-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-blue-700 dark:text-blue-400">Sedang Ditangani</span>
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </div>
                <span class="text-xl font-bold text-blue-700 dark:text-blue-400 mt-0.5 block">{{ $reportMetrics['sedang_ditangani'] }}</span>
                <span class="text-[10px] text-blue-600/80 mt-1 block">Proses Analisis/Pemeriksaan</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-indigo-200/80 dark:border-indigo-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-indigo-700 dark:text-indigo-400">Sudah Dijawab</span>
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                </div>
                <span class="text-xl font-bold text-indigo-700 dark:text-indigo-400 mt-0.5 block">{{ $reportMetrics['sudah_dijawab'] }}</span>
                <span class="text-[10px] text-indigo-600/80 mt-1 block">Arahan Terkirim</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-orange-200/80 dark:border-orange-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-orange-700 dark:text-orange-400">Perlu Kunjungan</span>
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                </div>
                <span class="text-xl font-bold text-orange-700 dark:text-orange-400 mt-0.5 block">{{ $reportMetrics['perlu_kunjungan'] }}</span>
                <span class="text-[10px] text-orange-600/80 mt-1 block">Tinjauan Lapangan</span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-3.5 rounded-xl border border-emerald-200/80 dark:border-emerald-800/60 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-medium text-emerald-700 dark:text-emerald-400">Penanganan Selesai</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                <span class="text-xl font-bold text-emerald-700 dark:text-emerald-400 mt-0.5 block">{{ $reportMetrics['selesai'] }}</span>
                <span class="text-[10px] text-emerald-600/80 mt-1 block">Tuntas &amp; Arsip</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-2xs">
        <form method="GET" action="{{ route('admin.veterinarians.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari dokter, Puskeswan, STRV..."
                    class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5"
                >
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-xs rounded-lg p-2.5 focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="">Semua Status Operasional</option>
                    <option value="online" {{ $statusFilter === 'online' ? 'selected' : '' }}>Online (Siaga)</option>
                    <option value="praktik_lapangan" {{ $statusFilter === 'praktik_lapangan' ? 'selected' : '' }}>Praktik Lapangan</option>
                    <option value="siaga" {{ $statusFilter === 'siaga' ? 'selected' : '' }}>Siaga Panggilan</option>
                    <option value="offline" {{ $statusFilter === 'offline' ? 'selected' : '' }}>Sedang Istirahat</option>
                    <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Akun Aktif</option>
                    <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Akun Nonaktif</option>
                </select>

                @if($search || $statusFilter)
                <a href="{{ route('admin.veterinarians.index') }}" class="p-2.5 text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Reset
                </a>
                @endif

                <button
                    type="button"
                    onclick="document.getElementById('modal-buat-dokter').classList.remove('hidden')"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-primary-700 hover:bg-primary-800 text-white rounded-lg text-xs font-semibold transition cursor-pointer shadow-xs shrink-0"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Buat Akun Dokter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Veterinarians List Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                <thead class="text-[11px] text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/60 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3.5">Dokter Hewan</th>
                        <th scope="col" class="px-4 py-3.5">Akun &amp; Kontak</th>
                        <th scope="col" class="px-4 py-3.5">Wilayah Penugasan</th>
                        <th scope="col" class="px-4 py-3.5">Status Layanan</th>
                        <th scope="col" class="px-4 py-3.5">Status Akun</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($veterinarians as $vet)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary-100 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 font-bold flex items-center justify-center shrink-0 text-xs">
                                    {{ $vet->initials }}
                                </div>
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white block">{{ $vet->name }}</span>
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400 block">{{ $vet->specialization }}</span>
                                    @if($vet->strv_number)
                                        <span class="text-[10px] text-gray-400 font-mono">STRV: {{ $vet->strv_number }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="font-medium text-gray-900 dark:text-white block">{{ $vet->email ?? ($vet->user?->email ?? '-') }}</span>
                            <span class="text-gray-500 block">{{ $vet->phone_number }}</span>
                            <span class="inline-flex items-center gap-1 text-[10px] text-primary-700 dark:text-primary-400 font-medium mt-0.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                                Role: Dokter Hewan
                            </span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="font-semibold text-gray-800 dark:text-gray-200 block">{{ $vet->puskeswan }}</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 block">
                                Wilayah: {{ $vet->wilayah_penugasan ?? $vet->puskeswan }}
                            </span>
                            <span class="text-[10px] text-gray-400 block mt-0.5">Jam: {{ $vet->consultation_hours }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            @if($vet->status === 'online')
                                <span class="px-2 py-0.5 text-[10px] font-semibold text-emerald-800 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-md">Online (Siaga)</span>
                            @elseif($vet->status === 'praktik_lapangan')
                                <span class="px-2 py-0.5 text-[10px] font-semibold text-blue-800 bg-blue-100 dark:bg-blue-950/60 dark:text-blue-300 rounded-md">Praktik Lapangan</span>
                            @elseif($vet->status === 'siaga')
                                <span class="px-2 py-0.5 text-[10px] font-semibold text-amber-800 bg-amber-100 dark:bg-amber-950/60 dark:text-amber-300 rounded-md">Siaga Darurat</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-semibold text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-md">Offline</span>
                            @endif
                            <div class="mt-1 flex items-center gap-1 text-[11px] text-gray-500 dark:text-gray-400">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Beban Laporan:</span>
                                <span class="px-1.5 py-0.5 rounded font-semibold {{ ($vet->active_reports_count ?? 0) > 0 ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $vet->active_reports_count ?? 0 }} aktif
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <form method="POST" action="{{ route('admin.veterinarians.toggle-active', $vet) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition cursor-pointer {{ $vet->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800 hover:bg-rose-100' }}"
                                    title="Klik untuk ubah status akun"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full {{ $vet->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span>{{ $vet->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button
                                    type="button"
                                    onclick='openEditVetAdminModal(@json($vet))'
                                    class="p-1.5 text-gray-600 hover:text-primary-700 dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                    title="Edit Akun, Email & Kata Sandi Dokter"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </button>
                                <form method="POST" action="{{ route('admin.veterinarians.destroy', $vet) }}" onsubmit="return confirm('Hapus akun dokter hewan {{ $vet->name }} dari sistem? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="p-1.5 text-rose-500 hover:text-rose-700 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/40 transition cursor-pointer"
                                        title="Hapus dokter hewan"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="max-w-sm mx-auto space-y-2">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                <p class="text-xs font-medium">Tidak ada dokter hewan yang cocok dengan kriteria pencarian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($veterinarians->hasPages())
        <div class="p-3 border-t border-gray-100 dark:border-gray-700">
            {{ $veterinarians->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Buat Akun Dokter Hewan Baru (Admin Only) -->
<div id="modal-buat-dokter" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Pendaftaran Resmi Akun Dokter Hewan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Akun Dokter Hewan hanya dapat dibuat secara resmi oleh Admin Dinas Peternakan.</p>
            </div>
            <button type="button" onclick="document.getElementById('modal-buat-dokter').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none cursor-pointer">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.veterinarians.store') }}" class="mt-4 space-y-3.5 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: drh. Bambang Irawan, M.Si" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Bidang Spesialisasi <span class="text-red-500">*</span></label>
                    <input type="text" name="specialization" required value="{{ old('specialization') }}" placeholder="Contoh: Sapi Perah &amp; Reproduksi Ruminansia" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Dinas (Username Login) <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="Contoh: drh.bambang@disnak.jatimprov.go.id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Awal <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Puskeswan Induk Penugasan <span class="text-red-500">*</span></label>
                    <input type="text" name="puskeswan" required value="{{ old('puskeswan') }}" placeholder="Contoh: Puskeswan Singosari" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Penugasan (Kabupaten/Kota)</label>
                    <input type="text" name="wilayah_penugasan" value="{{ old('wilayah_penugasan') }}" placeholder="Contoh: Kabupaten Malang" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone_number" required value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Registrasi / STRV</label>
                    <input type="text" name="strv_number" value="{{ old('strv_number') }}" placeholder="Contoh: STRV-35.07.2026.012" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan</label>
                    <input type="text" name="consultation_hours" value="{{ old('consultation_hours', '08.00 - 16.00 WIB') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Operasional Awal <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        <option value="online" {{ old('status', 'online') === 'online' ? 'selected' : '' }}>Online (Siaga)</option>
                        <option value="praktik_lapangan" {{ old('status') === 'praktik_lapangan' ? 'selected' : '' }}>Praktik Lapangan</option>
                        <option value="siaga" {{ old('status') === 'siaga' ? 'selected' : '' }}>Siaga Panggilan</option>
                        <option value="offline" {{ old('status') === 'offline' ? 'selected' : '' }}>Sedang Istirahat</option>
                    </select>
                </div>
            </div>

            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200/80 dark:border-amber-800 text-[11px] text-amber-800 dark:text-amber-300">
                <strong>Catatan Keamanan:</strong> Email dan kata sandi yang dibuat oleh Admin ini adalah kredensial resmi bagi dokter hewan untuk login langsung ke Dashboard Dokter Hewan Dinas.
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-buat-dokter').classList.add('hidden')" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer">
                    Buat Akun Dokter Hewan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Dokter Hewan (Admin) -->
<div id="modal-edit-dokter-admin" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-xl border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Perbarui Data Dokter Hewan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola penugasan dan kredensial akun dokter hewan.</p>
            </div>
            <button type="button" onclick="document.getElementById('modal-edit-dokter-admin').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none cursor-pointer">✕</button>
        </div>

        <form id="form-edit-vet-admin" method="POST" class="mt-4 space-y-3.5 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap &amp; Gelar <span class="text-red-500">*</span></label>
                    <input type="text" id="admin-edit-vet-name" name="name" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Spesialisasi <span class="text-red-500">*</span></label>
                    <input type="text" id="admin-edit-vet-specialization" name="specialization" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Email Akun (Username Login) <span class="text-red-500">*</span></label>
                    <input type="email" id="admin-edit-vet-email" name="email" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Tetapkan / Ganti Kata Sandi (Password)</label>
                    <input type="password" name="password" minlength="6" placeholder="Ketik kata sandi baru untuk login dokter" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                    <span class="text-[10px] text-gray-400 block mt-0.5">Kosongkan bila tidak ingin mengubah kata sandi.</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Puskeswan Induk <span class="text-red-500">*</span></label>
                    <input type="text" id="admin-edit-vet-puskeswan" name="puskeswan" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Penugasan</label>
                    <input type="text" id="admin-edit-vet-wilayah" name="wilayah_penugasan" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" id="admin-edit-vet-phone" name="phone_number" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Registrasi / STRV</label>
                    <input type="text" id="admin-edit-vet-strv" name="strv_number" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelayanan</label>
                    <input type="text" id="admin-edit-vet-hours" name="consultation_hours" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                    <select id="admin-edit-vet-status" name="status" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2.5 text-xs text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        <option value="online">Online (Siaga)</option>
                        <option value="praktik_lapangan">Praktik Lapangan</option>
                        <option value="siaga">Siaga Panggilan</option>
                        <option value="offline">Sedang Istirahat</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="document.getElementById('modal-edit-dokter-admin').classList.add('hidden')" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 transition shadow-xs cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function copyVetCredentials(email, password, name) {
        const text = `Akun Dokter Hewan:\nNama: ${name}\nEmail: ${email}\nPassword: ${password}\nLogin di: {{ route('login') }}`;
        navigator.clipboard.writeText(text).then(() => {
            const btnText = document.getElementById('text-copy-vet');
            if (btnText) {
                btnText.innerText = 'Tersalin ke Clipboard!';
                setTimeout(() => {
                    btnText.innerText = 'Salin Email & Password';
                }, 3000);
            }
        }).catch(err => {
            console.error('Gagal menyalin:', err);
        });
    }

    function openEditVetAdminModal(vet) {
        document.getElementById('form-edit-vet-admin').action = "{{ url('/admin/dokter-hewan') }}/" + vet.id;
        document.getElementById('admin-edit-vet-name').value = vet.name || '';
        document.getElementById('admin-edit-vet-specialization').value = vet.specialization || '';
        document.getElementById('admin-edit-vet-email').value = vet.email || (vet.user ? vet.user.email : '');
        document.getElementById('admin-edit-vet-puskeswan').value = vet.puskeswan || '';
        document.getElementById('admin-edit-vet-wilayah').value = vet.wilayah_penugasan || vet.puskeswan || '';
        document.getElementById('admin-edit-vet-phone').value = vet.phone_number || '';
        document.getElementById('admin-edit-vet-strv').value = vet.strv_number || '';
        document.getElementById('admin-edit-vet-hours').value = vet.consultation_hours || '08.00 - 16.00 WIB';
        document.getElementById('admin-edit-vet-status').value = vet.status || 'online';
        document.getElementById('modal-edit-dokter-admin').classList.remove('hidden');
    }

    @if($errors->any() && !old('_method'))
        document.addEventListener('DOMContentLoaded', function() {
            const createModal = document.getElementById('modal-buat-dokter');
            if (createModal) {
                createModal.classList.remove('hidden');
            }
        });
    @endif
</script>
@endsection

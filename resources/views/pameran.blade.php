@extends('layouts.app')

@section('title', 'Pameran & Kalender Terpadu — Peternak Milenial Jatim')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang PPHP
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Pameran &amp; Kalender Terpadu
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Agenda pameran peternakan, temu bisnis, dan kalender kegiatan dinas Jawa Timur.
        </p>
    </div>
    @if(auth()->check() && (auth()->user()->isPeternak() || auth()->user()->isAdmin()))
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-daftar-pameran').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
        >
            + Daftar Peserta Pameran
        </button>
    </div>
    @endif
</div>

<!-- Form Pengajuan Stand (Collapsible & Persisted into Database) -->
<div id="form-daftar-pameran" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pengajuan Stand Pameran (Database)</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Fasilitas stand dinas untuk peternak lokal Jawa Timur.</p>
        </div>
        <button type="button" onclick="document.getElementById('form-daftar-pameran').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
    </div>

    <form action="{{ route('pameran.register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        @csrf
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Usaha / Kelompok Ternak <span class="text-red-500">*</span></label>
            <input type="text" name="business_name" required value="{{ auth()->user()?->name ?? '' }}" placeholder="Nama usaha atau kelompok ternak Anda" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Pilihan Pameran <span class="text-red-500">*</span></label>
            <select name="exhibition_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($exhibitions as $ex)
                    <option value="{{ $ex->id }}">{{ $ex->title }} ({{ $ex->location }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Produk yang Dipamerkan <span class="text-red-500">*</span></label>
            <input type="text" name="exhibited_products" required placeholder="Contoh: Susu Pasteurisasi & Keju Mozzarella" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-3 flex justify-end gap-2 pt-1">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                Kirim Pengajuan Stand
            </button>
        </div>
    </form>
</div>

<!-- Section 1: Pameran Utama (From Database) -->
@if ($featuredExhibition)
<div class="mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 sm:p-6 shadow-xs">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
        <div>
            <span class="text-[11px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-2 py-0.5 rounded">
                Agenda Utama Dinas
            </span>
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mt-1.5">
                {{ $featuredExhibition->title }}
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-xl leading-relaxed">
                {{ $featuredExhibition->description }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3.5 text-xs">
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Waktu</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($featuredExhibition->start_date)->format('d M') }} &ndash; {{ \Carbon\Carbon::parse($featuredExhibition->end_date)->format('d M Y') }}
                    </span>
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Tempat</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $featuredExhibition->location }}</span>
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <span class="text-gray-400 block text-[10px]">Kapasitas Stand</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $featuredExhibition->registered_stands_count }} / {{ $featuredExhibition->stand_capacity }} Stand Terisi
                    </span>
                </div>
            </div>
        </div>

        @if(auth()->check() && (auth()->user()->isPeternak() || auth()->user()->isAdmin()))
        <div class="flex flex-col sm:flex-row lg:flex-col gap-2 shrink-0">
            <button
                type="button"
                onclick="document.getElementById('form-daftar-pameran').classList.remove('hidden')"
                class="px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-lg text-center transition shadow-xs"
            >
                Daftar Stand Sekarang
            </button>
        </div>
        @endif
    </div>
</div>
@else
<div class="mb-5 bg-white rounded-xl border border-dashed border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-8 text-center shadow-xs">
    <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-400 mb-2.5 shadow-xs">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>
    </div>
    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada agenda pameran</h3>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Agenda pameran dan temu bisnis peternakan akan ditampilkan setelah dipublikasikan oleh Admin Dinas.</p>
</div>
@endif

<!-- Section 2: Daftar Stand Terdaftar (Real Database Table) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Pengajuan Stand Pameran</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Semua pengajuan peserta pameran yang tercatat di database.</p>
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
                    <th class="px-3.5 py-2.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($registrations as $reg)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                    <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">{{ $reg->stand_number ?? 'STD-BELUM' }}</td>
                    <td class="px-3.5 py-2.5 font-medium text-gray-800 dark:text-gray-200">{{ $reg->business_name }}</td>
                    <td class="px-3.5 py-2.5">{{ $reg->exhibition?->title ?? 'Pameran' }}</td>
                    <td class="px-3.5 py-2.5">{{ $reg->exhibited_products }}</td>
                    <td class="px-3.5 py-2.5">
                        @if ($reg->status === 'approved')
                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold px-2 py-0.5 rounded">Disetujui</span>
                        @elseif ($reg->status === 'pending')
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-semibold px-2 py-0.5 rounded">Menunggu</span>
                        @else
                            <span class="bg-red-50 text-red-700 border border-red-200 text-[10px] font-semibold px-2 py-0.5 rounded">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-3.5 py-2.5 text-right space-x-1">
                        @if(auth()->check() && auth()->user()->isAdmin())
                            @if ($reg->status !== 'approved')
                                <form action="{{ route('pameran.status', $reg) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2 py-1 rounded transition">Setujui</button>
                                </form>
                            @endif
                        @endif

                        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $reg->user_id))
                        <form action="{{ route('pameran.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan pengajuan stand {{ $reg->business_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Batal</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-3.5 py-6 text-center text-gray-400 text-xs">Belum ada pengajuan stand pameran di dalam database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Section 3: Kalender Kegiatan Terpadu (From Database) -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Kalender Kegiatan &amp; Agenda Dinas</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Jadwal kegiatan resmi peternakan di 38 Kabupaten/Kota.</p>
        </div>
        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-50 text-primary-700">Terdata: {{ $calendarEvents->count() }} Kegiatan</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-xs">
        @forelse ($calendarEvents as $event)
        <div class="p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200/80 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold text-primary-700 bg-blue-50 px-2 py-0.5 rounded capitalize">
                        {{ str_replace('_', ' ', $event->event_type) }}
                    </span>
                    <span class="text-[11px] text-gray-500 font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $event->title }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $event->description }}</p>
                <div class="mt-2 text-gray-600 dark:text-gray-300 text-[11px]">
                    <strong>Lokasi:</strong> {{ $event->location }}
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-6 text-gray-400 text-xs bg-gray-50 dark:bg-gray-750/30 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
            Belum ada agenda kegiatan di dalam database.
        </div>
        @endforelse
    </div>
</div>
@endsection

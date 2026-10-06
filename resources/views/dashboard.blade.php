@extends('layouts.app')

@section('title', 'Ringkasan — Peternak Milenial Jawa Timur')

@section('content')
<!-- Header: Clean Page Title & Action -->
<div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Ringkasan Peternakan
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Bpk. Slamet Rahardjo · Pandaan, Kab. Pasuruan
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            data-modal-target="emergency-modal"
            data-modal-toggle="emergency-modal"
            class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-xs px-3 py-2 transition"
        >
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            Siaga Darurat
        </button>
        <a
            href="{{ url('/harga-komoditas') }}"
            class="inline-flex items-center text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 font-medium rounded-lg text-xs px-3 py-2 transition"
        >
            Pantau Harga
        </a>
    </div>
</div>

<!-- Row 1: KPI Metrics (4 Kolom) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 mb-4">
    <!-- Stat 1: Populasi Ternak -->
    <x-stat-card
        title="Populasi Ternak"
        value="24"
        unit="Ekor Sapi FH"
        desc="18 Laktasi · 4 Bunting · 2 Pedet"
        badge="E-Tag 100%"
        badge-type="success"
        action-url="{{ url('/konsultasi#rekam-medis') }}"
        action-label="Detail"
    >
        <x-slot:icon>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25-2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <!-- Stat 2: Harga Susu KUD -->
    <x-stat-card
        title="Harga Susu KUD"
        value="Rp 7.450"
        unit="/ Liter"
        desc="+Rp 250 vs minggu lalu"
        badge="Pasuruan"
        badge-type="cyan"
        action-url="{{ url('/harga-komoditas') }}"
        action-label="Tren"
    >
        <x-slot:icon>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <!-- Stat 3: Bimtek Terbuka -->
    <x-stat-card
        title="Bimtek Terbuka"
        value="2"
        unit="Kelas"
        desc="Silase Jagung Fermentasi"
        badge="14 Kuota"
        badge-type="warning"
        action-url="{{ url('/pelatihan') }}"
        action-label="Daftar"
    >
        <x-slot:icon>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <!-- Stat 4: Siaga Medis -->
    <x-stat-card
        title="Dokter Hewan"
        value="Standby"
        unit=""
        desc="drh. Ratna · Puskeswan"
        badge="Siaga Medis"
        badge-type="success"
        action-url="{{ url('/konsultasi') }}"
        action-label="Konsultasi"
    >
        <x-slot:icon>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </x-slot:icon>
    </x-stat-card>
</div>

<!-- Row 2: Grafik Tren Harga Komoditas -->
<x-price-chart-panel />

<!-- Row 3: Penanganan Operasional (Status Darurat & Konsultasi Dokter) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
    <x-emergency-tracker-card />
    <x-consultation-card />
</div>

<!-- Row 4: Sentra Produksi & Materi Pelatihan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
    <x-sentra-map-card />
    <x-library-certificate-card />
</div>

<!-- Row 5: Marketplace Peternak -->
<x-marketplace-panel />

<!-- Row 6: Agenda & Evakuasi (Pameran, Kalender, Rekam Medis, Mitigasi) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-expo-card />
    <x-calendar-card />
    <x-health-record-card />
    <x-disaster-mitigation-card />
</div>
@endsection

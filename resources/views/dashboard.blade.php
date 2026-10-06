@extends('layouts.app')

@section('title', 'Dashboard Pertumbuhan Peternak — Peternak Milenial')

@section('content')
<div class="space-y-5">
    <!-- Header Dashboard: Role Peternak Growth Overview -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-gray-200 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-heading dark:text-white">
                    Dashboard Pertumbuhan Ternak
                </h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300">
                    Role Peternak Aktif
                </span>
            </div>
            <p class="text-xs sm:text-sm text-body dark:text-gray-400 mt-1">
                Monitoring laju pertumbuhan populasi, produktivitas susu harian, bobot ternak, dan omzet peternakan
                <span class="font-medium text-gray-700 dark:text-gray-300">· Kandang Bpk. Slamet Rahardjo (Pasuruan)</span>
            </p>
        </div>

        <!-- Filter Periode & Kandang Peternak -->
        <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
            <!-- Filter Kelompok Kandang -->
            <div class="relative">
                <select id="filter-kandang-ternak" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 pr-8 shadow-xs">
                    <option value="all">Semua Kandang (24 Ekor)</option>
                    <option value="Kandang Laktasi A">Kandang Laktasi A</option>
                    <option value="Kandang Bunting B">Kandang Bunting B</option>
                    <option value="Kandang Pedet C">Kandang Pedet C</option>
                </select>
            </div>

            <!-- Filter Status Reproduksi -->
            <div class="relative">
                <select id="filter-status-ternak" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 pr-8 shadow-xs">
                    <option value="all">Semua Status Ternak</option>
                    <option value="Laktasi Aktif">Laktasi Aktif</option>
                    <option value="Bunting">Bunting</option>
                    <option value="Pedet Sapih">Pedet Sapih</option>
                    <option value="Masa Kering">Masa Kering</option>
                </select>
            </div>

            <!-- Filter Periode Pertumbuhan -->
            <div class="relative">
                <select id="filter-periode-pertumbuhan" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 pr-8 shadow-xs font-medium">
                    <option value="year">Tahun Ini (2026)</option>
                    <option value="90d">90 Hari Terakhir</option>
                    <option value="30d">30 Hari Terakhir</option>
                    <option value="7d">7 Hari Terakhir</option>
                </select>
            </div>

            <!-- Emergency Action Trigger -->
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 shadow-xs transition"
            >
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Siaga Darurat
            </button>
        </div>
    </div>

    <!-- 4 Growth KPI Cards (Pertumbuhan Utama Role Peternak) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Growth Card 1: Produksi Susu Harian -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </div>
                <span class="inline-flex items-center text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                    +18.2% bln ini
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-2xl font-bold tracking-tight text-heading dark:text-white" id="stat-milk-growth">315</h3>
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Liter / Hari</span>
                </div>
                <p class="text-xs font-medium text-body dark:text-gray-400 mt-0.5">Pertumbuhan Produksi Susu</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                    Rata-rata 17.5 L / ekor laktasi (+48 L vs bln lalu)
                </p>
            </div>
        </div>

        <!-- Growth Card 2: Populasi & Kelahiran Ternak -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-lg bg-green-50 dark:bg-green-950/60 text-green-700 dark:text-green-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <span class="inline-flex items-center text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                    +20.0% thn ini
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-2xl font-bold tracking-tight text-heading dark:text-white" id="stat-herd-growth">24</h3>
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Ekor Sapi FH</span>
                </div>
                <p class="text-xs font-medium text-body dark:text-gray-400 mt-0.5">Pertumbuhan Populasi Ternak</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                    18 Laktasi · 4 Bunting · 2 Pedet (+4 kelahiran baru)
                </p>
            </div>
        </div>

        <!-- Growth Card 3: Laju Pertumbuhan Bobot Harian (ADG) -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0l-3.75-3.75M12 20.25l3.75-3.75M3.75 9h16.5" />
                    </svg>
                </div>
                <span class="inline-flex items-center text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">
                    +0.12 kg ADG
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-2xl font-bold tracking-tight text-heading dark:text-white" id="stat-adg-growth">+0.85</h3>
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">kg / Hari (ADG)</span>
                </div>
                <p class="text-xs font-medium text-body dark:text-gray-400 mt-0.5">Laju Pertambahan Bobot Harian</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                    Efisiensi pakan silase mandiri menekan FCR ke 6.2
                </p>
            </div>
        </div>

        <!-- Growth Card 4: Pertumbuhan Omzet & Pendapatan Ternak -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-lg bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0H3m0 0h18m0 0h.75a.75.75 0 01.75.75v.75m-19.5 0h19.5m0 0v11.25a.75.75 0 01-.75.75h-.75m-18 0h-.75a.75.75 0 01-.75-.75V6z" />
                    </svg>
                </div>
                <span class="inline-flex items-center text-xs font-semibold px-2 py-0.5 rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900/60 dark:text-cyan-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                    +15.4% bln ini
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-2xl font-bold tracking-tight text-heading dark:text-white" id="stat-revenue-growth">Rp 42.85</h3>
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Juta / Bln</span>
                </div>
                <p class="text-xs font-medium text-body dark:text-gray-400 mt-0.5">Pertumbuhan Omzet Peternakan</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700/60">
                    Setoran Susu KUD Pasuruan Rp 7.450/L (+Rp 250)
                </p>
            </div>
        </div>
    </div>

    <!-- Charts Row: Pertumbuhan Produksi Susu & Komposisi Populasi -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Chart 1: Laju Pertumbuhan Produksi Susu Harian (Area / Line Chart) -->
        <div class="lg:col-span-8 bg-neutral-primary-soft bg-white dark:bg-gray-800 border border-default border-gray-200 dark:border-gray-700 rounded-base rounded-xl shadow-xs p-4 sm:p-6 flex flex-col justify-between">
            <div>
                <!-- Header Chart Container -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
                    <div class="flex items-center">
                        <div class="w-11 h-11 bg-neutral-primary-medium bg-blue-50 dark:bg-blue-950/60 border border-default-medium border-blue-200 dark:border-blue-800 flex items-center justify-center rounded-full me-3 shrink-0 text-primary-700 dark:text-primary-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-1.5">
                                <h5 class="text-2xl font-bold text-heading dark:text-white" id="chart-growth-value">315 Liter</h5>
                                <span class="text-xs text-gray-500 dark:text-gray-400">/ hari</span>
                            </div>
                            <p class="text-xs sm:text-sm text-body dark:text-gray-400">Tren Pertumbuhan Produksi Susu Sapi Perah (Liter)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center bg-green-50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-xs font-semibold px-2 py-1 rounded">
                            ↑ +31.2% akumulasi tahun ini
                        </span>
                    </div>
                </div>

                <!-- Metric Row -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                    <dl class="flex items-center">
                        <dt class="text-body dark:text-gray-400 text-xs font-normal me-1.5">Puncak Produksi:</dt>
                        <dd class="text-heading dark:text-white text-xs sm:text-sm font-semibold" id="chart-peak-production">340 L/hari</dd>
                    </dl>
                    <dl class="flex items-center">
                        <dt class="text-body dark:text-gray-400 text-xs font-normal me-1.5">Rata-rata/Ekor:</dt>
                        <dd class="text-heading dark:text-white text-xs sm:text-sm font-semibold">17.5 L/hari</dd>
                    </dl>
                    <dl class="flex items-center sm:justify-end col-span-2 sm:col-span-1">
                        <dt class="text-body dark:text-gray-400 text-xs font-normal me-1.5">Kualitas Susu:</dt>
                        <dd class="text-heading dark:text-white text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Lemak 3.8% (Grade A)</dd>
                    </dl>
                </div>

                <!-- ApexChart Area Container -->
                <div id="chart-perkembangan-peternak" class="w-full min-h-[300px]"></div>
            </div>

            <!-- Footer Chart with Period Filter -->
            <div class="grid grid-cols-1 items-center border-t border-gray-100 dark:border-gray-700 justify-between mt-4 pt-3 sm:pt-4">
                <div class="flex justify-between items-center">
                    <!-- Dropdown Periode Chart -->
                    <div class="flex items-center gap-1.5">
                        <button
                            id="dropdown-growth-period-btn"
                            type="button"
                            data-dropdown-toggle="dropdown-growth-period"
                            class="text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-2.5 py-1.5 inline-flex items-center gap-1 transition"
                        >
                            <span id="label-growth-period">Tahun Ini</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>

                        <div id="dropdown-growth-period" class="z-10 hidden bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700 rounded-lg shadow-lg w-40 border border-gray-200 dark:border-gray-700">
                            <ul class="py-1 text-xs text-gray-700 dark:text-gray-200 font-medium">
                                <li><a href="javascript:void(0)" onclick="updateGrowthChartPeriod('7d', '7 Hari Terakhir')" class="block px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700">7 Hari Terakhir</a></li>
                                <li><a href="javascript:void(0)" onclick="updateGrowthChartPeriod('30d', '30 Hari Terakhir')" class="block px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700">30 Hari Terakhir</a></li>
                                <li><a href="javascript:void(0)" onclick="updateGrowthChartPeriod('90d', '90 Hari Terakhir')" class="block px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700">90 Hari Terakhir</a></li>
                                <li><a href="javascript:void(0)" onclick="updateGrowthChartPeriod('year', 'Tahun Ini')" class="block px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700">Tahun Ini (2026)</a></li>
                            </ul>
                        </div>
                    </div>

                    <a href="#tabel-data-peternak" class="text-xs font-semibold text-primary-700 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 inline-flex items-center gap-1">
                        Monitoring Ternak Individual ↓
                    </a>
                </div>
            </div>
        </div>

        <!-- Chart 2: Komposisi & Fase Pertumbuhan Populasi (Donut Chart) -->
        <div class="lg:col-span-4 bg-neutral-primary-soft bg-white dark:bg-gray-800 border border-default border-gray-200 dark:border-gray-700 rounded-base rounded-xl shadow-xs p-4 sm:p-6 flex flex-col justify-between">
            <div>
                <!-- Header Chart -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-11 h-11 bg-green-50 dark:bg-green-950/60 border border-green-200 dark:border-green-800 flex items-center justify-center rounded-full me-3 shrink-0 text-green-700 dark:text-green-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-2xl font-bold text-heading dark:text-white">24 Ekor</h5>
                            <p class="text-xs sm:text-sm text-body dark:text-gray-400">Total Populasi Ternak Aktif</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center bg-blue-50 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2 py-0.5 rounded">
                        E-Tag 100%
                    </span>
                </div>

                <!-- Metric Row -->
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <dl class="flex items-center">
                        <dt class="text-body dark:text-gray-400 text-xs font-normal me-1">Sapi Perah:</dt>
                        <dd class="text-heading dark:text-white text-xs font-semibold">18 Laktasi</dd>
                    </dl>
                    <dl class="flex items-center justify-end">
                        <dt class="text-body dark:text-gray-400 text-xs font-normal me-1">Bunting:</dt>
                        <dd class="text-heading dark:text-white text-xs font-semibold">4 Ekor</dd>
                    </dl>
                </div>

                <!-- ApexChart Donut Container -->
                <div id="chart-distribusi-status" class="w-full min-h-[260px] flex items-center justify-center"></div>

                <!-- Breakdown Komposisi Ternak -->
                <div class="space-y-1.5 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700/60 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-gray-600 dark:text-gray-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 me-2"></span> Sapi Laktasi Aktif
                        </span>
                        <span class="font-semibold text-heading dark:text-white">18 ekor (75.0%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-gray-600 dark:text-gray-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 me-2"></span> Sapi Bunting (4-7 bln)
                        </span>
                        <span class="font-semibold text-heading dark:text-white">4 ekor (16.7%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-gray-600 dark:text-gray-300">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 me-2"></span> Pedet Masa Sapih
                        </span>
                        <span class="font-semibold text-heading dark:text-white">2 ekor (8.3%)</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700 pt-3 mt-4 flex items-center justify-between">
                <span class="text-[11px] text-gray-400">Target Reproduksi 2026: 6 Pedet</span>
                <a href="{{ url('/konsultasi#rekam-medis') }}" class="text-xs font-semibold text-primary-700 dark:text-primary-400 hover:underline">
                    Rekam Medis E-Tag →
                </a>
            </div>
        </div>
    </div>

    <!-- Chart 3: Pertumbuhan Bobot Badan & Efisiensi Ransum per Kelompok (Bar Chart) -->
    <div class="bg-neutral-primary-soft bg-white dark:bg-gray-800 border border-default border-gray-200 dark:border-gray-700 rounded-base rounded-xl shadow-xs p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
            <div class="flex items-center">
                <div class="w-11 h-11 bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 flex items-center justify-center rounded-full me-3 shrink-0 text-amber-700 dark:text-amber-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div>
                    <h5 class="text-xl sm:text-2xl font-bold text-heading dark:text-white">+0.85 kg / hari</h5>
                    <p class="text-xs sm:text-sm text-body dark:text-gray-400">Pertambahan Bobot Harian (ADG) Berdasarkan Fase Pertumbuhan</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center bg-green-50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 text-xs font-semibold px-2.5 py-1 rounded">
                    Ransum Silase Mandiri
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4 text-xs">
            <dl>
                <dt class="text-gray-500 dark:text-gray-400">Pedet Sapih (0-3 bln):</dt>
                <dd class="text-heading dark:text-white font-bold text-sm">+0.65 kg / hari (ADG Sehat)</dd>
            </dl>
            <dl>
                <dt class="text-gray-500 dark:text-gray-400">Dara Tumbuh (4-12 bln):</dt>
                <dd class="text-heading dark:text-white font-bold text-sm">+0.85 kg / hari (Target Kawin)</dd>
            </dl>
            <dl>
                <dt class="text-gray-500 dark:text-gray-400">Sapi Bunting:</dt>
                <dd class="text-heading dark:text-white font-bold text-sm">+0.95 kg / hari (Nutrisi Janin)</dd>
            </dl>
            <dl>
                <dt class="text-gray-500 dark:text-gray-400">Laktasi Produktif:</dt>
                <dd class="text-heading dark:text-white font-bold text-sm">Bobot Stabil 485-510 kg</dd>
            </dl>
        </div>

        <!-- ApexChart Bar Container -->
        <div id="chart-kategori-program" class="w-full min-h-[280px]"></div>

        <div class="border-t border-gray-100 dark:border-gray-700 pt-3 mt-4 flex items-center justify-between text-xs">
            <span class="text-gray-500 dark:text-gray-400">Efisiensi Biaya Pakan Mandiri: Menghemat 28.5% Biaya Ransum</span>
            <a href="{{ url('/pelatihan#modul') }}" class="font-semibold text-primary-700 dark:text-primary-400 hover:underline">
                Panduan Formulasi Silase Jagung →
            </a>
        </div>
    </div>

    <!-- Section: Tabel Monitoring Pertumbuhan Ternak Individual -->
    <div id="tabel-data-peternak" class="bg-neutral-primary-soft bg-white dark:bg-gray-800 border border-default border-gray-200 dark:border-gray-700 rounded-base rounded-xl shadow-xs p-4 sm:p-6 space-y-4">
        <!-- Table Header & Controls -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-heading dark:text-white">
                    Monitoring Pertumbuhan Ternak Individual
                </h3>
                <p class="text-xs text-body dark:text-gray-400 mt-0.5">
                    Data harian produksi susu, pertumbuhan bobot (ADG), dan status kesehatan ternak binaan kandang
                </p>
            </div>

            <!-- Search & Filter Controls -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Search Input -->
                <div class="relative w-full sm:w-60">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <input
                        type="text"
                        id="table-search"
                        class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2"
                        placeholder="Cari E-Tag, nama sapi..."
                    />
                </div>

                <!-- Kandang Filter -->
                <select id="table-filter-kandang" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 pr-8">
                    <option value="all">Semua Kandang</option>
                    <option value="Kandang Laktasi A">Kandang Laktasi A</option>
                    <option value="Kandang Bunting B">Kandang Bunting B</option>
                    <option value="Kandang Pedet C">Kandang Pedet C</option>
                </select>

                <!-- Status Filter -->
                <select id="table-filter-status" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-heading dark:text-white text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 pr-8">
                    <option value="all">Semua Status</option>
                    <option value="Laktasi Aktif">Laktasi Aktif</option>
                    <option value="Bunting">Bunting</option>
                    <option value="Pedet Sapih">Pedet Sapih</option>
                    <option value="Masa Kering">Masa Kering</option>
                </select>
            </div>
        </div>

        <!-- Table Container -->
        <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table id="default-table" class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
                <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/60 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 select-none">
                    <tr>
                        <!-- Col 1: E-Tag & Nama Ternak -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('name')">
                            <span class="flex items-center">
                                E-Tag & Identitas Sapi
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 2: Kandang -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('kandang')">
                            <span class="flex items-center">
                                Lokasi Kandang
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 3: Produksi Harian -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('yield')">
                            <span class="flex items-center">
                                Produksi Susu Harian
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 4: Bobot & ADG -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('weight')">
                            <span class="flex items-center">
                                Bobot & Pertumbuhan (ADG)
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 5: Status Reproduksi -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('status')">
                            <span class="flex items-center">
                                Status & Kebugaran
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 6: Terakhir Timbang/Catat -->
                        <th scope="col" class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="sortLivestockTable('date')">
                            <span class="flex items-center">
                                Terakhir Dicatat
                                <svg class="w-3.5 h-3.5 ms-1 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>

                        <!-- Col 7: Aksi -->
                        <th scope="col" class="px-4 py-3 text-right">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Populated via JavaScript dynamically -->
                </tbody>
            </table>

            <!-- Empty State -->
            <div id="table-empty-state" class="hidden p-8 text-center bg-white dark:bg-gray-800">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h4 class="mt-2 text-sm font-semibold text-heading dark:text-white">Tidak ada data ternak yang cocok</h4>
                <p class="mt-1 text-xs text-body dark:text-gray-400">Silakan ubah kata kunci pencarian E-Tag atau sesuaikan pilihan filter kandang.</p>
                <button type="button" onclick="resetLivestockFilters()" class="mt-3 inline-flex items-center text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline">
                    Reset Filter Pencarian
                </button>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 text-xs">
            <span class="text-body dark:text-gray-400" id="table-pagination-info">
                Menampilkan 1 - 10 dari 24 data ternak
            </span>

            <div class="inline-flex items-center gap-1" id="table-pagination-controls">
                <!-- Injected via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Ternak Individual -->
<div id="modal-detail-peternak" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-xl shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white" id="modal-peternak-title">
                    Detail Pertumbuhan Ternak
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg text-sm p-1.5" data-modal-hide="modal-detail-peternak">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-4 space-y-3 text-xs" id="modal-peternak-body">
                <!-- Content injected dynamically -->
            </div>
            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 flex justify-end">
                <button type="button" class="py-1.5 px-3 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600" data-modal-hide="modal-detail-peternak">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/**
 * Peternak Growth Monitoring Engine (Role Peternak Sapi Perah Pasuruan)
 * Real data visualization for production, livestock herd growth, ADG, and milk revenue.
 */

// 1. DATASET TERNAK INDIVIDUAL (24 Ekor Milik Peternak Slamet Rahardjo)
const livestockData = [
    { id: 1, tag: "JTM-PAS-0024", name: "Melati", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 21.5, weight: 512, adg: "+0.85 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Laktasi ke-2, puncak produksi" },
    { id: 2, tag: "JTM-PAS-0014", name: "Bunga", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 18.0, weight: 495, adg: "+0.70 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Sembuh dari radang ringan, nafsu makan normal" },
    { id: 3, tag: "JTM-PAS-0031", name: "Si Manis", type: "Sapi Perah FH", kandang: "Kandang Pedet C", yield: 0, weight: 145, adg: "+0.95 kg/hr", status: "Pedet Sapih", date: "2026-10-05", notes: "Pertumbuhan sangat cepat, pakan konsentrat pemula" },
    { id: 4, tag: "JTM-PAS-0008", name: "Sri Rejeki", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 22.0, weight: 520, adg: "+0.80 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Produksi konsisten stabil di atas 20 L" },
    { id: 5, tag: "JTM-PAS-0019", name: "Kenanga", type: "Sapi Perah FH", kandang: "Kandang Bunting B", yield: 8.5, weight: 535, adg: "+1.10 kg/hr", status: "Bunting", date: "2026-10-04", notes: "Bunting 6 bulan, persiapan masa kering" },
    { id: 6, tag: "JTM-PAS-0012", name: "Lestari", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 19.5, weight: 488, adg: "+0.75 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Kadar lemak 3.9%, susu kualitas premium" },
    { id: 7, tag: "JTM-PAS-0005", name: "Mawar", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 20.0, weight: 505, adg: "+0.82 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Vaksinasi booster PMK lengkap" },
    { id: 8, tag: "JTM-PAS-0027", name: "Anggrek", type: "Sapi Perah FH", kandang: "Kandang Bunting B", yield: 0, weight: 540, adg: "+0.90 kg/hr", status: "Bunting", date: "2026-10-03", notes: "Bunting 7.5 bulan, masa kering total" },
    { id: 9, tag: "JTM-PAS-0033", name: "Kancil", type: "Sapi Perah FH", kandang: "Kandang Pedet C", yield: 0, weight: 110, adg: "+0.85 kg/hr", status: "Pedet Sapih", date: "2026-10-05", notes: "Kelahiran Agustus 2026, aktif dan lincah" },
    { id: 10, tag: "JTM-PAS-0015", name: "Srikandi", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 17.5, weight: 480, adg: "+0.65 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Ransum silase jagung 100% lahap" },
    { id: 11, tag: "JTM-PAS-0022", name: "Sekar", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 21.0, weight: 510, adg: "+0.88 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Kondisi ambing sangat bersih dan elastis" },
    { id: 12, tag: "JTM-PAS-0018", name: "Kusuma", type: "Sapi Perah FH", kandang: "Kandang Bunting B", yield: 10.0, weight: 525, adg: "+0.92 kg/hr", status: "Bunting", date: "2026-10-04", notes: "Bunting 4 bulan hasil IB bibit pejantan unggul" },
    { id: 13, tag: "JTM-PAS-0009", name: "Cempaka", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 19.0, weight: 490, adg: "+0.78 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Susu grade A setoran KUD Pandaan" },
    { id: 14, tag: "JTM-PAS-0007", name: "Arum", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 18.5, weight: 485, adg: "+0.70 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Diperah 2 kali sehari (pagi & sore)" },
    { id: 15, tag: "JTM-PAS-0021", name: "Dahlia", type: "Sapi Perah FH", kandang: "Kandang Bunting B", yield: 11.0, weight: 518, adg: "+0.85 kg/hr", status: "Bunting", date: "2026-10-04", notes: "Bunting 5 bulan, USG kehamilan positif sehat" },
    { id: 16, tag: "JTM-PAS-0011", name: "Puspa", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 20.5, weight: 508, adg: "+0.80 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Tingkat sel somatik rendah (higienis)" },
    { id: 17, tag: "JTM-PAS-0003", name: "Kendedes", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 16.5, weight: 475, adg: "+0.68 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Laktasi stabil bulan ke-7" },
    { id: 18, tag: "JTM-PAS-0016", name: "Sari", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 17.0, weight: 482, adg: "+0.72 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "E-Tag aktif terverifikasi Disnak" },
    { id: 19, tag: "JTM-PAS-0029", name: "Roro", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 19.8, weight: 498, adg: "+0.84 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Hasil pemerahan pagi 11.2 L, sore 8.6 L" },
    { id: 20, tag: "JTM-PAS-0004", name: "Dewi", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 18.2, weight: 486, adg: "+0.74 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Kondisi kaki & kuku terawat prima" },
    { id: 21, tag: "JTM-PAS-0026", name: "Kinasih", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 20.2, weight: 502, adg: "+0.81 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Produksi harian meningkat pasca ransum silase" },
    { id: 22, tag: "JTM-PAS-0017", name: "Widuri", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 17.8, weight: 480, adg: "+0.69 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Kandang bersih steril dengan desinfektan berkala" },
    { id: 23, tag: "JTM-PAS-0023", name: "Endah", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 18.7, weight: 492, adg: "+0.77 kg/hr", status: "Laktasi Aktif", date: "2026-10-06", notes: "Susu langsung disaring dan disimpan di cooling tank" },
    { id: 24, tag: "JTM-PAS-0002", name: "Gayatri", type: "Sapi Perah FH", kandang: "Kandang Laktasi A", yield: 0, weight: 520, adg: "+0.60 kg/hr", status: "Masa Kering", date: "2026-10-02", notes: "Masa kering istirahat ambing menjelang melahirkan" }
];

// Table State
let currentLivestockData = [...livestockData];
let currentSortCol = 'yield';
let currentSortDir = 'desc';
let currentPage = 1;
const rowsPerPage = 10;

// Chart Instances
let growthChartInstance = null;
let statusChartInstance = null;
let programChartInstance = null;

// Period datasets for Milk Production Growth Area Chart (Role Peternak)
const milkGrowthData = {
    '7d': {
        categories: ['Sen (30/9)', 'Sel (1/10)', 'Rab (2/10)', 'Kam (3/10)', 'Jum (4/10)', 'Sab (5/10)', 'Min (6/10)'],
        actual: [298, 304, 308, 310, 312, 314, 315],
        target: [290, 290, 295, 295, 300, 300, 300]
    },
    '30d': {
        categories: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        actual: [280, 292, 304, 315],
        target: [270, 280, 290, 300]
    },
    '90d': {
        categories: ['Agustus', 'September', 'Oktober'],
        actual: [265, 290, 315],
        target: [250, 275, 300]
    },
    'year': {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
        actual: [240, 248, 255, 260, 272, 280, 292, 298, 308, 315],
        target: [230, 240, 250, 255, 265, 275, 280, 285, 295, 300]
    }
};

/**
 * 2. INITIALIZE APEXCHARTS FOR PETERNAK GROWTH
 */
function initCharts() {
    if (typeof ApexCharts === 'undefined') {
        console.warn('ApexCharts is not loaded yet.');
        return;
    }

    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9ca3af' : '#64748b';
    const gridColor = isDarkMode ? '#374151' : '#f1f5f9';

    // A. Chart Pertumbuhan Produksi Susu (Area Chart)
    const growthOptions = {
        series: [
            { name: 'Realisasi Produksi (Liter)', data: milkGrowthData.year.actual },
            { name: 'Target Produksi (Liter)', data: milkGrowthData.year.target }
        ],
        chart: {
            type: 'area',
            height: 310,
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            toolbar: { show: false },
            animations: { enabled: true, easing: 'easeinout', speed: 500 }
        },
        colors: ['#013A85', '#209527'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5 },
        xaxis: {
            categories: milkGrowthData.year.categories,
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: { colors: textColor, fontSize: '11px' },
                formatter: (val) => `${val} L`
            }
        },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: textColor },
            markers: { radius: 12 }
        },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            y: { formatter: (val) => `${val} Liter / Hari` }
        }
    };

    const growthElem = document.querySelector('#chart-perkembangan-peternak');
    if (growthElem) {
        growthElem.innerHTML = '';
        growthChartInstance = new ApexCharts(growthElem, growthOptions);
        growthChartInstance.render();
    }

    // B. Chart Komposisi Populasi & Reproduksi Ternak (Donut Chart)
    const statusOptions = {
        series: [18, 4, 2],
        chart: {
            type: 'donut',
            height: 270,
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        labels: ['Sapi Laktasi Aktif', 'Sapi Bunting (4-7 bln)', 'Pedet Masa Sapih'],
        colors: ['#209527', '#FBBB03', '#009FD2'],
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Populasi',
                            color: textColor,
                            fontSize: '11px',
                            formatter: () => '24 Ekor'
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 700,
                            color: isDarkMode ? '#ffffff' : '#111827',
                            formatter: (val) => `${val} Ekor`
                        }
                    }
                }
            }
        },
        legend: { show: false },
        stroke: { width: 2, colors: [isDarkMode ? '#1f2937' : '#ffffff'] },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            y: { formatter: (val) => `${val} Ekor Ternak` }
        }
    };

    const statusElem = document.querySelector('#chart-distribusi-status');
    if (statusElem) {
        statusElem.innerHTML = '';
        statusChartInstance = new ApexCharts(statusElem, statusOptions);
        statusChartInstance.render();
    }

    // C. Chart Pertumbuhan Bobot Badan & ADG per Kelompok (Bar Chart)
    const programOptions = {
        series: [
            {
                name: 'Laju Pertambahan Bobot Harian (kg/hari)',
                data: [0.65, 0.85, 0.95, 0.75, 1.10]
            }
        ],
        chart: {
            type: 'bar',
            height: 270,
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '45%',
                distributed: true,
                dataLabels: { position: 'top' }
            }
        },
        colors: ['#009FD2', '#209527', '#FBBB03', '#013A85', '#8b5cf6'],
        dataLabels: {
            enabled: true,
            formatter: (val) => `+${val} kg/hr`,
            offsetY: -20,
            style: { fontSize: '11px', colors: [textColor] }
        },
        legend: { show: false },
        xaxis: {
            categories: ['Pedet (0-3 bln)', 'Dara (4-12 bln)', 'Sapi Bunting', 'Laktasi Awal', 'Penggemukan'],
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: { colors: textColor, fontSize: '11px' },
                formatter: (val) => `+${val} kg`
            }
        },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            y: { formatter: (val) => `+${val} kg / ekor / hari` }
        }
    };

    const programElem = document.querySelector('#chart-kategori-program');
    if (programElem) {
        programElem.innerHTML = '';
        programChartInstance = new ApexCharts(programElem, programOptions);
        programChartInstance.render();
    }
}

/**
 * Update Grafik Produksi Susu Berdasarkan Periode
 */
function updateGrowthChartPeriod(key, label) {
    if (!growthChartInstance || !milkGrowthData[key]) return;

    const data = milkGrowthData[key];
    growthChartInstance.updateOptions({
        xaxis: { categories: data.categories }
    });
    growthChartInstance.updateSeries([
        { name: 'Realisasi Produksi (Liter)', data: data.actual },
        { name: 'Target Produksi (Liter)', data: data.target }
    ]);

    const labelElem = document.getElementById('label-growth-period');
    if (labelElem) labelElem.textContent = label;

    const latestVal = data.actual[data.actual.length - 1];
    const growthElem = document.getElementById('chart-growth-value');
    if (growthElem) growthElem.textContent = `${latestVal} Liter`;
}

/**
 * 3. INTERACTIVE DATA TABLE FOR INDIVIDUAL LIVESTOCK
 */
function renderLivestockTable() {
    const tbody = document.getElementById('table-body');
    const emptyState = document.getElementById('table-empty-state');
    const infoElem = document.getElementById('table-pagination-info');
    const controlsElem = document.getElementById('table-pagination-controls');

    if (!tbody) return;

    const searchVal = document.getElementById('table-search')?.value.toLowerCase().trim() || '';
    const kandangFilter = document.getElementById('table-filter-kandang')?.value || 'all';
    const statusFilter = document.getElementById('table-filter-status')?.value || 'all';

    let filtered = livestockData.filter(item => {
        const matchesSearch =
            item.name.toLowerCase().includes(searchVal) ||
            item.tag.toLowerCase().includes(searchVal) ||
            item.kandang.toLowerCase().includes(searchVal) ||
            item.status.toLowerCase().includes(searchVal);

        const matchesKandang = (kandangFilter === 'all') || item.kandang === kandangFilter;
        const matchesStatus = (statusFilter === 'all') || item.status === statusFilter;

        return matchesSearch && matchesKandang && matchesStatus;
    });

    // Sorting
    filtered.sort((a, b) => {
        let valA = a[currentSortCol];
        let valB = b[currentSortCol];

        if (currentSortCol === 'yield' || currentSortCol === 'weight') {
            valA = Number(valA);
            valB = Number(valB);
        } else if (typeof valA === 'string') {
            valA = valA.toLowerCase();
            valB = valB.toLowerCase();
        }

        if (valA < valB) return currentSortDir === 'asc' ? -1 : 1;
        if (valA > valB) return currentSortDir === 'asc' ? 1 : -1;
        return 0;
    });

    // Pagination
    const totalRecords = filtered.length;
    const totalPages = Math.ceil(totalRecords / rowsPerPage) || 1;
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = Math.min(startIndex + rowsPerPage, totalRecords);
    const paginatedItems = filtered.slice(startIndex, endIndex);

    if (totalRecords === 0) {
        tbody.innerHTML = '';
        emptyState?.classList.remove('hidden');
        if (infoElem) infoElem.textContent = 'Menampilkan 0 data ternak';
        if (controlsElem) controlsElem.innerHTML = '';
        return;
    } else {
        emptyState?.classList.add('hidden');
    }

    tbody.innerHTML = paginatedItems.map(item => {
        let badgeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
        if (item.status === 'Laktasi Aktif') {
            badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300';
        } else if (item.status === 'Bunting') {
            badgeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-300';
        } else if (item.status === 'Pedet Sapih') {
            badgeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300';
        }

        const d = new Date(item.date);
        const dateFormatted = `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()}`;

        return `
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-primary-700 dark:text-primary-300 font-bold flex items-center justify-center text-xs me-2.5 shrink-0 border border-blue-200 dark:border-blue-800">
                            🐄
                        </div>
                        <div>
                            <div class="font-bold text-xs text-gray-900 dark:text-white">${item.name}</div>
                            <div class="text-[11px] text-primary-700 dark:text-primary-400 font-mono">${item.tag}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        ${item.kandang}
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    ${item.yield > 0
                        ? `<span class="font-bold text-primary-700 dark:text-primary-400 text-sm">${item.yield}</span> <span class="text-xs text-gray-500">L / hari</span>`
                        : `<span class="text-gray-400 text-xs italic">- (Non-Laktasi)</span>`
                    }
                </td>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    <span class="font-semibold">${item.weight} kg</span>
                    <span class="text-[11px] text-green-600 dark:text-green-400 font-medium block">${item.adg}</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold ${badgeClass}">
                        ${item.status}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                    ${dateFormatted}
                </td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <button type="button" onclick="showLivestockDetail(${item.id})" class="text-primary-700 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 font-semibold text-xs px-2.5 py-1 rounded-md hover:bg-primary-50 dark:hover:bg-primary-950/50 transition">
                        Detail
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    if (infoElem) {
        infoElem.textContent = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalRecords} data ternak`;
    }

    if (controlsElem) {
        let buttons = `
            <button type="button" onclick="changeLivestockPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-2.5 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700">
                Sebelumnya
            </button>
        `;

        for (let i = 1; i <= totalPages; i++) {
            buttons += `
                <button type="button" onclick="changeLivestockPage(${i})" class="px-2.5 py-1 text-xs font-medium rounded-md transition ${currentPage === i ? 'bg-primary-700 text-white dark:bg-primary-600' : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700'}">
                    ${i}
                </button>
            `;
        }

        buttons += `
            <button type="button" onclick="changeLivestockPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="px-2.5 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700">
                Berikutnya
            </button>
        `;

        controlsElem.innerHTML = buttons;
    }
}

function sortLivestockTable(col) {
    if (currentSortCol === col) {
        currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        currentSortCol = col;
        currentSortDir = 'desc';
    }
    renderLivestockTable();
}

function changeLivestockPage(page) {
    currentPage = page;
    renderLivestockTable();
}

function resetLivestockFilters() {
    const search = document.getElementById('table-search');
    const kandang = document.getElementById('table-filter-kandang');
    const status = document.getElementById('table-filter-status');
    if (search) search.value = '';
    if (kandang) kandang.value = 'all';
    if (status) status.value = 'all';
    currentPage = 1;
    renderLivestockTable();
}

function showLivestockDetail(id) {
    const item = livestockData.find(f => f.id === id);
    if (!item) return;

    const modalTitle = document.getElementById('modal-peternak-title');
    const modalBody = document.getElementById('modal-peternak-body');
    if (modalTitle) modalTitle.textContent = `Rekam Pertumbuhan: ${item.name} (${item.tag})`;

    if (modalBody) {
        modalBody.innerHTML = `
            <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-heading dark:text-white">${item.name}</span>
                    <span class="text-xs font-mono font-bold text-primary-700 dark:text-primary-400">${item.tag}</span>
                </div>
                <div class="text-xs text-body dark:text-gray-300">${item.type} · ${item.kandang}</div>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-2">
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Produksi Susu Harian</span>
                    <span class="font-bold text-sm text-heading dark:text-white">${item.yield > 0 ? item.yield + ' L / hari' : 'Masa Non-Laktasi'}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Bobot & Laju Tumbuh</span>
                    <span class="font-bold text-sm text-heading dark:text-white">${item.weight} kg (${item.adg})</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Fase Status</span>
                    <span class="font-semibold text-heading dark:text-white">${item.status}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Terakhir Timbang</span>
                    <span class="font-semibold text-heading dark:text-white">${item.date}</span>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                <span class="text-gray-400 block text-[10px] uppercase">Catatan Perkembangan & Kesehatan</span>
                <span class="font-medium text-heading dark:text-white block mt-0.5">${item.notes}</span>
            </div>
        `;
    }

    const modal = document.getElementById('modal-detail-peternak');
    modal?.classList.remove('hidden');
    modal?.classList.add('flex');
}

// Close detail modal listener
document.addEventListener('click', (e) => {
    if (e.target.matches('[data-modal-hide="modal-detail-peternak"]')) {
        const modal = document.getElementById('modal-detail-peternak');
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');
    }
});

/**
 * 4. INITIALIZE ON DOM READY
 */
document.addEventListener('DOMContentLoaded', () => {
    initCharts();
    renderLivestockTable();

    // Search and Filter Listeners
    document.getElementById('table-search')?.addEventListener('input', () => {
        currentPage = 1;
        renderLivestockTable();
    });

    document.getElementById('table-filter-kandang')?.addEventListener('change', () => {
        currentPage = 1;
        renderLivestockTable();
    });

    document.getElementById('table-filter-status')?.addEventListener('change', () => {
        currentPage = 1;
        renderLivestockTable();
    });

    // Global Header Filter Sync
    document.getElementById('filter-kandang-ternak')?.addEventListener('change', (e) => {
        const tableKandang = document.getElementById('table-filter-kandang');
        if (tableKandang) {
            tableKandang.value = e.target.value;
            currentPage = 1;
            renderLivestockTable();
        }
    });

    document.getElementById('filter-status-ternak')?.addEventListener('change', (e) => {
        const tableStatus = document.getElementById('table-filter-status');
        if (tableStatus) {
            tableStatus.value = e.target.value;
            currentPage = 1;
            renderLivestockTable();
        }
    });

    document.getElementById('filter-periode-pertumbuhan')?.addEventListener('change', (e) => {
        const periodKey = e.target.value;
        const labels = {
            'year': 'Tahun Ini (2026)',
            '90d': '90 Hari Terakhir',
            '30d': '30 Hari Terakhir',
            '7d': '7 Hari Terakhir'
        };
        updateGrowthChartPeriod(periodKey, labels[periodKey] || 'Tahun Ini');
    });

    // Sync ApexCharts on dark mode toggle
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        setTimeout(initCharts, 250);
    });
});
</script>
@endpush

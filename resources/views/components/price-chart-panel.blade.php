<!-- Price Chart & Market Overview -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-4 shadow-xs">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
        <div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                Tren Harga Komoditas
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Pembaruan harian 06:00 WIB · 38 Kab/Kota Jawa Timur
            </p>
        </div>

        <!-- Filter Controls -->
        <div class="flex items-center gap-2 flex-wrap">
            <select class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="susu">Susu Sapi Segar</option>
                <option value="daging_sapi">Daging Sapi Murni</option>
                <option value="ayam_broiler">Daging Ayam Ras</option>
                <option value="telur">Telur Ayam Ras</option>
                <option value="konsentrat">Pakan Konsentrat</option>
            </select>

            <select class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="pasuruan" selected>Kab. Pasuruan</option>
                <option value="all">Rata-rata Jatim</option>
                <option value="malang">Kab. Malang</option>
                <option value="blitar">Kab. Blitar</option>
                <option value="surabaya">Kota Surabaya</option>
            </select>

            <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 p-0.5 bg-gray-50 dark:bg-gray-700/50" role="group">
                <button type="button" class="px-2.5 py-1 text-xs font-semibold text-gray-900 bg-white rounded-md shadow-xs dark:bg-gray-800 dark:text-white">
                    7 Hari
                </button>
                <button type="button" class="px-2.5 py-1 text-xs font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    30 Hari
                </button>
                <button type="button" class="px-2.5 py-1 text-xs font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    1 Tahun
                </button>
            </div>
        </div>
    </div>

    <!-- Vector Chart -->
    <div class="py-4">
        <div class="relative w-full h-48 sm:h-56">
            <svg class="w-full h-full overflow-visible" viewBox="0 0 800 220" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="priceLineGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#16a34a" stop-opacity="0.18" />
                        <stop offset="100%" stop-color="#16a34a" stop-opacity="0.0" />
                    </linearGradient>
                </defs>

                <!-- Grid Horizontal Lines -->
                <line x1="0" y1="35" x2="800" y2="35" stroke="currentColor" class="text-gray-100 dark:text-gray-700/60" stroke-width="1" stroke-dasharray="3 3" />
                <line x1="0" y1="85" x2="800" y2="85" stroke="currentColor" class="text-gray-100 dark:text-gray-700/60" stroke-width="1" stroke-dasharray="3 3" />
                <line x1="0" y1="135" x2="800" y2="135" stroke="currentColor" class="text-gray-100 dark:text-gray-700/60" stroke-width="1" stroke-dasharray="3 3" />
                <line x1="0" y1="185" x2="800" y2="185" stroke="currentColor" class="text-gray-100 dark:text-gray-700/60" stroke-width="1" stroke-dasharray="3 3" />

                <!-- Price Area Fill -->
                <polygon points="40,165 150,150 260,155 370,125 480,105 590,115 700,65 760,55 760,200 40,200" fill="url(#priceLineGrad)" />

                <!-- Price Polyline -->
                <polyline points="40,165 150,150 260,155 370,125 480,105 590,115 700,65 760,55" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />

                <!-- Data Points -->
                <circle cx="40" cy="165" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="150" cy="150" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="260" cy="155" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="370" cy="125" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="480" cy="105" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="590" cy="115" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="700" cy="65" r="3.5" class="fill-white dark:fill-gray-900 stroke-primary-600" stroke-width="2" />
                <circle cx="760" cy="55" r="4.5" class="fill-primary-600 stroke-white dark:stroke-gray-800" stroke-width="2" />
            </svg>

            <!-- Price Tag Overlay -->
            <div class="absolute right-2 top-2 bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900 text-xs font-semibold px-2.5 py-1 rounded-md shadow-xs flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-400"></span>
                <span>Rp 7.450 / Liter</span>
            </div>
        </div>

        <!-- X-Axis Labels -->
        <div class="flex justify-between text-[11px] text-gray-400 dark:text-gray-500 pt-2 px-1 border-t border-gray-100 dark:border-gray-700">
            <span>30 Sep</span>
            <span>01 Okt</span>
            <span>02 Okt</span>
            <span>03 Okt</span>
            <span>04 Okt</span>
            <span>05 Okt</span>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Hari ini</span>
        </div>
    </div>

    <!-- Snapshot Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-gray-100 dark:border-gray-700 text-xs">
        <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
            <span class="text-gray-500 dark:text-gray-400 block text-[11px]">Tertinggi (Surabaya)</span>
            <span class="font-semibold text-gray-900 dark:text-white tabular-nums">Rp 7.800</span>
        </div>
        <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
            <span class="text-gray-500 dark:text-gray-400 block text-[11px]">Rata-rata KUD</span>
            <span class="font-semibold text-gray-900 dark:text-white tabular-nums">Rp 7.420</span>
        </div>
        <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
            <span class="text-gray-500 dark:text-gray-400 block text-[11px]">HPP Rekomendasi</span>
            <span class="font-semibold text-primary-700 dark:text-primary-400 tabular-nums">Rp 6.800</span>
        </div>
        <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
            <span class="text-gray-500 dark:text-gray-400 block text-[11px]">Margin Peternak</span>
            <span class="font-semibold text-primary-700 dark:text-primary-400 tabular-nums">+Rp 650</span>
        </div>
    </div>
</div>

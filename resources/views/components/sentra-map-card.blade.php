<!-- Sentra Produksi Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Sentra Produksi</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebaran Wilayah Komoditas Unggulan</p>
            </div>
            <a href="{{ url('/harga-komoditas#peta') }}" class="text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline">
                Peta Lengkap
            </a>
        </div>

        <div class="mt-3 divide-y divide-gray-100 dark:divide-gray-700/60">
            <!-- Item 1: Pasuruan -->
            <div class="py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-semibold">
                        SP
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white block">Pasuruan & Malang</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Sapi Perah · 145.000 L/hari</span>
                    </div>
                </div>
                <span class="text-[11px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-2 py-0.5 rounded">Wilayah Anda</span>
            </div>

            <!-- Item 2: Blitar -->
            <div class="py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-semibold">
                        TL
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white block">Blitar & Tulungagung</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Telur Unggas · 70% Suplai</span>
                    </div>
                </div>
                <span class="text-xs text-gray-400">32 km</span>
            </div>

            <!-- Item 3: Lumajang -->
            <div class="py-2.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700/60 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-semibold">
                        KS
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white block">Senduro, Lumajang</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Kambing Senduro Plasma Nutfah</span>
                    </div>
                </div>
                <span class="text-xs text-gray-400">85 km</span>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Data Balai Pembibitan Ternak</span>
        <a href="{{ url('/harga-komoditas#unggulan') }}" class="font-medium text-primary-700 dark:text-primary-400 hover:underline">
            Lihat Komoditas →
        </a>
    </div>
</div>

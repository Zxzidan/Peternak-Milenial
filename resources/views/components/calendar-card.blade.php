<!-- Kalender Kegiatan Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Kalender Kegiatan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Jadwal Vaksinasi & Pelayanan</p>
            </div>
            <span class="text-[11px] font-medium text-gray-500">Oktober 2026</span>
        </div>

        <div class="mt-3 space-y-2">
            <!-- Event 1 -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 flex flex-col items-center justify-center font-bold text-xs shrink-0">
                        <span>12</span>
                        <span class="text-[9px] font-normal uppercase leading-none">Okt</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white block">Vaksinasi Massal PMK</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Puskeswan Pandaan & Sukorejo</span>
                    </div>
                </div>
                <span class="text-[11px] font-medium text-primary-700 dark:text-primary-400">Wajib</span>
            </div>

            <!-- Event 2 -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 flex flex-col items-center justify-center font-bold text-xs shrink-0">
                        <span>15</span>
                        <span class="text-[9px] font-normal uppercase leading-none">Okt</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white block">Bimtek Silase Pakan</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">BBPP Batu · Daring & Praktik</span>
                    </div>
                </div>
                <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400">Terdaftar</span>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Tersinkronisasi Kalender Dinas</span>
        <a href="{{ url('/pameran#kalender') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Jadwal Lengkap →
        </a>
    </div>
</div>

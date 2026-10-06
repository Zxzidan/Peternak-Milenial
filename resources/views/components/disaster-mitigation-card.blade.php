<!-- Mitigasi Bencana Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Mitigasi Bencana</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">SOP Evakuasi & Penyelamatan Ternak</p>
            </div>
            <a href="{{ url('/darurat#panduan') }}" class="text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline">
                Panduan
            </a>
        </div>

        <div class="mt-3 space-y-2">
            <!-- SOP 1 -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white block">Erupsi Bromo & Semeru</span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400">Tutup sumber pakan rumput dari abu silika</span>
                </div>
                <button
                    type="button"
                    onclick="alert('Membuka SOP Erupsi...')"
                    class="text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600"
                >
                    SOP
                </button>
            </div>

            <!-- SOP 2 -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white block">Banjir & Luapan Sungai</span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400">Rute evakuasi ke posko dataran tinggi</span>
                </div>
                <button
                    type="button"
                    onclick="alert('Membuka Rute Evakuasi...')"
                    class="text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600"
                >
                    Rute
                </button>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Kerjasama BPBD Jawa Timur</span>
        <a href="{{ url('/darurat#panduan') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Buku Saku Lengkap →
        </a>
    </div>
</div>

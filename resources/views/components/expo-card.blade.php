<!-- Pameran Peternakan Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pameran Peternakan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Jatim Livestock Expo 2026</p>
            </div>
            <span class="text-[11px] font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">
                24–26 Okt
            </span>
        </div>

        <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <h4 class="text-xs font-bold text-gray-900 dark:text-white">
                Grand City Convention Hall, Surabaya
            </h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Temu bisnis peternak milenial dengan 120 stand binaan Dinas Peternakan.
            </p>
            <div class="mt-2.5">
                <button
                    type="button"
                    onclick="alert('Pendaftaran Stand Peternak Pasuruan telah diajukan!')"
                    class="text-xs font-medium text-primary-700 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-600 transition"
                >
                    Daftar Stand Binaan
                </button>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Fasilitas Subsidi APBD</span>
        <a href="{{ url('/pameran') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Detail Agenda →
        </a>
    </div>
</div>

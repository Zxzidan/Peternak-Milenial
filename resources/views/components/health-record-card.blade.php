<!-- Rekam Medis & E-Tag Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Rekam Medis E-Tag</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan Kesehatan Ternak</p>
            </div>
            <span class="text-[11px] font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">
                iSIKHNAS
            </span>
        </div>

        <!-- Specimen Info Box -->
        <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-900 dark:text-white">Melati · JTM-PAS-0024</span>
                <span class="text-[10px] font-semibold text-green-700 bg-green-50 dark:bg-green-950/60 dark:text-green-300 px-1.5 py-0.2 rounded">
                    Laktasi II
                </span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-[10px] text-gray-400 block">Kebuntingan</span>
                    <span class="font-medium text-gray-800 dark:text-gray-200">Bunting 4 Bln</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 block">Produksi Susu</span>
                    <span class="font-medium text-gray-800 dark:text-gray-200">18,5 L / Hari</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 block">Vaksin Terakhir</span>
                    <span class="font-medium text-gray-800 dark:text-gray-200">PMK Booster II</span>
                </div>
                <div>
                    <span class="text-[10px] text-gray-400 block">Pemeriksa</span>
                    <span class="font-medium text-gray-800 dark:text-gray-200">drh. Bambang</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">24 Ekor Terdata</span>
        <a href="{{ url('/konsultasi#rekam-medis') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Daftar Ternak →
        </a>
    </div>
</div>

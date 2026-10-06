<!-- Modul & Sertifikat Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Modul & Sertifikat</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Materi & Bukti Kelulusan Bimtek</p>
            </div>
            <a href="{{ url('/pelatihan') }}" class="text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline">
                Katalog
            </a>
        </div>

        <div class="mt-3 space-y-2">
            <!-- Modul Item -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white block">SOP Pembuatan Silase</span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400">PDF · 3.2 MB</span>
                </div>
                <button
                    type="button"
                    onclick="alert('Mengunduh Modul Silase...')"
                    class="text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline"
                >
                    Unduh
                </button>
            </div>

            <!-- Sertifikat Item -->
            <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white block">Bimtek Susu Higienis</span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400">No: CERT-891 · Terverifikasi</span>
                </div>
                <a
                    href="{{ url('/pelatihan#sertifikat') }}"
                    class="text-xs font-medium text-primary-700 dark:text-primary-400 hover:underline"
                >
                    Lihat
                </a>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Terakreditasi BBPP Batu</span>
        <a href="{{ url('/pelatihan') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Pelatihan Lainnya →
        </a>
    </div>
</div>

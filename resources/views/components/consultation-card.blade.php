<!-- Konsultasi Dokter Hewan Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Konsultasi Dokter Hewan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tele-Medis Kesejahteraan Hewan</p>
            </div>
            <span class="inline-flex items-center text-[11px] font-medium text-green-700 bg-green-50 dark:bg-green-950/60 dark:text-green-300 px-2 py-0.5 rounded">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Aktif
            </span>
        </div>

        <!-- Latest Message Bubble -->
        <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-gray-900 dark:text-white">drh. Ratna Kusuma</span>
                <span class="text-[10px] text-gray-400">08:24</span>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed mb-2.5">
                Pisahkan sapi no. 14 ke kandang isolasi, beri air hangat dan molase sambil menunggu petugas tiba.
            </p>
            <div class="flex items-center gap-1.5">
                <input
                    type="text"
                    placeholder="Balas pesan..."
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-xs rounded-md p-1.5 w-full text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                />
                <button
                    type="button"
                    onclick="alert('Pesan terkirim ke dokter hewan!')"
                    class="bg-primary-700 hover:bg-primary-800 text-white text-xs font-medium px-2.5 py-1.5 rounded-md shrink-0 transition"
                >
                    Kirim
                </button>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-400 dark:text-gray-500 text-[11px]">Puskeswan Pandaan</span>
        <a href="{{ url('/konsultasi') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Riwayat Chat →
        </a>
    </div>
</div>

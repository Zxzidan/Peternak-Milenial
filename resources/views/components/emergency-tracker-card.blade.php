<!-- Status Laporan Darurat Card -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 flex flex-col justify-between shadow-xs">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Status Laporan Darurat</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Penanganan Kasus & Bencana</p>
            </div>
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-950/60 dark:text-red-300 dark:hover:bg-red-900/50 px-2.5 py-1 rounded-md transition"
            >
                + Lapor Baru
            </button>
        </div>

        <!-- Active Report Box -->
        <div class="mt-3 p-3.5 bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200/80 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-xs font-semibold text-gray-900 dark:text-white">#EM-2026-081</span>
                <span class="text-[11px] font-medium text-amber-700 bg-amber-50 px-2 py-0.5 rounded dark:bg-amber-950/60 dark:text-amber-300">
                    Menuju Lokasi
                </span>
            </div>
            <p class="text-xs text-gray-700 dark:text-gray-300">
                Demam pada 4 ekor sapi laktasi · Kandang 2, Pandaan
            </p>

            <!-- Stepper -->
            <div class="mt-3 pt-2 border-t border-gray-200/60 dark:border-gray-600/60">
                <div class="grid grid-cols-4 gap-1 text-center">
                    <div>
                        <div class="h-1 bg-primary-600 rounded-full mb-1.5"></div>
                        <span class="text-[10px] font-medium text-primary-700 dark:text-primary-400 block">Diterima</span>
                    </div>
                    <div>
                        <div class="h-1 bg-primary-600 rounded-full mb-1.5"></div>
                        <span class="text-[10px] font-medium text-primary-700 dark:text-primary-400 block">Diverifikasi</span>
                    </div>
                    <div>
                        <div class="h-1 bg-amber-500 rounded-full mb-1.5"></div>
                        <span class="text-[10px] font-medium text-amber-700 dark:text-amber-400 block">Penanganan</span>
                    </div>
                    <div>
                        <div class="h-1 bg-gray-200 dark:bg-gray-600 rounded-full mb-1.5"></div>
                        <span class="text-[10px] text-gray-400 block">Selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs">
        <span class="text-gray-500 dark:text-gray-400 text-[11px]">Petugas: drh. Ratna (ETA ~15 mnt)</span>
        <a href="{{ url('/darurat') }}" class="font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
            Riwayat →
        </a>
    </div>
</div>

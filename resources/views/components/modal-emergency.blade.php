<!-- Emergency Report Modal -->
<div id="emergency-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            Pelaporan Darurat Kesejahteraan Hewan
                        </h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Bidang Kesmavet Dinas Peternakan Jawa Timur</p>
                    </div>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg text-sm p-1.5 inline-flex items-center" data-modal-hide="emergency-modal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>

            <!-- Modal Body (Persists to Database) -->
            <form action="{{ route('darurat.store') }}" method="POST" class="p-4 space-y-3.5 text-xs">
                @csrf

                <!-- 1. Kategori Kejadian -->
                <div>
                    <label class="block mb-1.5 font-medium text-gray-700 dark:text-gray-300">Jenis Kejadian <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <label class="flex items-center p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 has-checked:border-red-500 has-checked:bg-red-50/50 dark:has-checked:bg-red-950/30">
                            <input type="radio" name="incident_type" value="wabah" checked class="w-3.5 h-3.5 text-red-600 focus:ring-red-500">
                            <span class="ms-2 text-gray-800 dark:text-gray-200 font-medium">Wabah Ternak</span>
                        </label>
                        <label class="flex items-center p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 has-checked:border-red-500 has-checked:bg-red-50/50 dark:has-checked:bg-red-950/30">
                            <input type="radio" name="incident_type" value="bencana" class="w-3.5 h-3.5 text-red-600 focus:ring-red-500">
                            <span class="ms-2 text-gray-800 dark:text-gray-200 font-medium">Bencana Alam</span>
                        </label>
                        <label class="flex items-center p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 has-checked:border-red-500 has-checked:bg-red-50/50 dark:has-checked:bg-red-950/30">
                            <input type="radio" name="incident_type" value="kecelakaan" class="w-3.5 h-3.5 text-red-600 focus:ring-red-500">
                            <span class="ms-2 text-gray-800 dark:text-gray-200 font-medium">Kecelakaan</span>
                        </label>
                    </div>
                </div>

                <!-- 2. Ternak & Lokasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Ternak Terdampak &amp; Jumlah <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <select name="livestock_type" required class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-red-500 focus:border-red-500 block w-2/3 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="sapi_perah">Sapi Perah</option>
                                <option value="sapi_potong">Sapi Potong</option>
                                <option value="kambing">Kambing / Domba</option>
                                <option value="unggas">Unggas</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <input type="number" name="affected_count" value="4" min="1" required class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-red-500 focus:border-red-500 block w-1/3 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ekor">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Lokasi / Kandang <span class="text-red-500">*</span></label>
                        <input type="text" name="location_address" required value="Pandaan, Pasuruan (Kandang Kelompok Ternak)" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Alamat kandang peternak...">
                    </div>
                </div>

                <!-- 3. Keterangan -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Keterangan Gejala / Situasi</label>
                    <textarea name="description" rows="2" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Tanda-tanda klinis ternak atau kondisi kandang..."></textarea>
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" data-modal-hide="emergency-modal" class="py-2 px-3 text-xs font-medium text-gray-600 hover:text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 font-semibold rounded-lg text-xs px-4 py-2 text-center transition flex items-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        <span>Kirim Laporan ke Database</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Marketplace Panel Component -->
<div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 mb-4 shadow-xs">
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 gap-3">
        <div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                Marketplace Peternak Milenial
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Produk Olahan, Pakan, dan Bibit Ternak Terverifikasi
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a
                href="{{ url('/marketplace#toko') }}"
                class="text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-600 transition"
            >
                + Pasang Produk
            </a>
            <a
                href="{{ url('/marketplace') }}"
                class="text-xs font-medium text-white bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700 px-3 py-1.5 rounded-lg transition"
            >
                Katalog Lengkap →
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mt-4">
        <x-product-card
            title="Susu Segar Pasteurisasi (1 L)"
            price="Rp 18.000"
            badge="Organik"
            region="Pasuruan"
            desc="Susu sapi perah segar tanpa pengawet dengan sertifikat uji TPC."
        />

        <x-product-card
            title="Silase Jagung Fermentasi (50 Kg)"
            price="Rp 95.000"
            badge="Siap Saji"
            region="Batu"
            desc="Pakan bernutrisi tinggi untuk menunjang produksi susu harian."
        />

        <x-product-card
            title="Daging Sapi Has Luar (1 Kg)"
            price="Rp 128.000"
            badge="RPH Halal"
            region="Lamongan"
            desc="Daging segar higienis bersertifikat NKV dengan rantai dingin."
        />

        <x-product-card
            title="Bibit Kambing Senduro (7 Bln)"
            price="Rp 2.850.000"
            badge="Bersertifikat"
            region="Lumajang"
            desc="Plasma nutfah murni Senduro dengan bobot 38 kg siap pejantan."
        />
    </div>
</div>

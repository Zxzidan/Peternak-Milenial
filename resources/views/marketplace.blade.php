@extends('layouts.app')

@section('title', 'Marketplace Peternak Milenial — Jawa Timur')

@section('content')
<!-- Page Header -->
<div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">
                Bidang PPHP
            </span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Marketplace Peternak Milenial
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
            Katalog produk peternakan terverifikasi langsung dari peternak Jawa Timur.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button
            type="button"
            onclick="document.getElementById('form-tambah-produk').classList.toggle('hidden')"
            class="inline-flex items-center text-xs font-medium text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition"
        >
            + Tambah Produk
        </button>
    </div>
</div>

<!-- Form Tambah Produk (Collapsible) -->
<div id="form-tambah-produk" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tambah Produk Baru</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Produk akan diverifikasi oleh dinas sebelum dipublikasikan.</p>
        </div>
        <button
            type="button"
            onclick="document.getElementById('form-tambah-produk').classList.add('hidden')"
            class="text-gray-400 hover:text-gray-600 text-xs"
        >
            Batal
        </button>
    </div>

    <form onsubmit="event.preventDefault(); alert('Produk berhasil diajukan!'); document.getElementById('form-tambah-produk').classList.add('hidden');" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk</label>
            <input type="text" required placeholder="Susu Pasteurisasi 1L" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
            <select class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                <option value="susu">Susu Olahan</option>
                <option value="daging">Daging Segar</option>
                <option value="pakan">Pakan & Silase</option>
                <option value="bibit">Bibit Ternak</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Satuan (Rp)</label>
            <input type="number" required placeholder="18000" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Stok & Satuan</label>
            <input type="text" required placeholder="150 Liter" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-2">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
            <textarea rows="2" placeholder="Kualitas produk dan sertifikasi..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
        </div>
        <div class="md:col-span-2 flex justify-end gap-2 pt-2">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-medium px-4 py-2 rounded-lg">
                Simpan Produk
            </button>
        </div>
    </form>
</div>

<!-- Filter Bar -->
<div class="mb-4 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-xs">
    <div class="flex items-center gap-1.5 flex-wrap">
        <button class="px-2.5 py-1 text-xs font-semibold rounded-md bg-primary-700 text-white">Semua</button>
        <button class="px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200">Susu</button>
        <button class="px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200">Daging</button>
        <button class="px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200">Pakan</button>
        <button class="px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200">Bibit</button>
    </div>

    <div class="flex items-center gap-2">
        <select class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2 text-gray-900 dark:text-white">
            <option>Semua Wilayah</option>
            <option>Pasuruan</option>
            <option>Batu</option>
            <option>Lamongan</option>
            <option>Lumajang</option>
        </select>
        <select class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2 text-gray-900 dark:text-white">
            <option>Terbaru</option>
            <option>Harga Terendah</option>
        </select>
    </div>
</div>

<!-- Product Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <!-- Item 1 -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 flex flex-col justify-between shadow-xs">
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">
                    Pasuruan
                </span>
                <span class="text-[10px] font-medium text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 px-1.5 py-0.5 rounded">
                    Terverifikasi
                </span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                Susu Segar Pasteurisasi KUD Pandaan (1 L)
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Sapi perah FH terakreditasi, kadar lemak 3.8%, botol higienis segel dingin.
            </p>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
            <span class="text-sm font-bold text-gray-900 dark:text-white tabular-nums">Rp 18.000</span>
            <button onclick="alert('Pesanan diproses!')" class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-medium rounded-md transition">
                Beli
            </button>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 flex flex-col justify-between shadow-xs">
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">
                    Kota Batu
                </span>
                <span class="text-[10px] font-medium text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 px-1.5 py-0.5 rounded">
                    Siap Saji
                </span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                Silase Jagung Fermentasi (50 Kg)
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Pakan awetan bernutrisi fermentasi Lactobacillus untuk menunjang produksi susu.
            </p>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
            <span class="text-sm font-bold text-gray-900 dark:text-white tabular-nums">Rp 95.000</span>
            <button onclick="alert('Pesanan diproses!')" class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-medium rounded-md transition">
                Beli
            </button>
        </div>
    </div>

    <!-- Item 3 -->
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 flex flex-col justify-between shadow-xs">
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">
                    Lamongan
                </span>
                <span class="text-[10px] font-medium text-primary-700 bg-primary-50 dark:bg-primary-950/60 dark:text-primary-300 px-1.5 py-0.5 rounded">
                    RPH Halal
                </span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                Daging Sapi Has Luar Segar (1 Kg)
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Pemotongan resmi RPH modern standar NKV dengan rantai dingin vacuum pack.
            </p>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
            <span class="text-sm font-bold text-gray-900 dark:text-white tabular-nums">Rp 128.000</span>
            <button onclick="alert('Pesanan diproses!')" class="px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-medium rounded-md transition">
                Beli
            </button>
        </div>
    </div>
</div>

<!-- Section: Kelola Pesanan -->
<div id="pesanan" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <h2 class="text-sm font-bold text-gray-900 dark:text-white">Kelola Pesanan Masuk</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar transaksi produk dari peternak ke pembeli.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
            <thead class="text-[11px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-3.5 py-2.5">No. Pesanan</th>
                    <th scope="col" class="px-3.5 py-2.5">Pembeli</th>
                    <th scope="col" class="px-3.5 py-2.5">Produk</th>
                    <th scope="col" class="px-3.5 py-2.5">Total</th>
                    <th scope="col" class="px-3.5 py-2.5">Status</th>
                    <th scope="col" class="px-3.5 py-2.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr>
                    <td class="px-3.5 py-2.5 font-medium text-gray-900 dark:text-white">#ORD-902</td>
                    <td class="px-3.5 py-2.5">Budi (Surabaya)</td>
                    <td class="px-3.5 py-2.5">10 Botol Susu Murni</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white tabular-nums">Rp 180.000</td>
                    <td class="px-3.5 py-2.5"><span class="bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 text-[10px] font-medium px-2 py-0.5 rounded">Perlu Dikirim</span></td>
                    <td class="px-3.5 py-2.5 text-right">
                        <button onclick="alert('Pesanan diproses!')" class="bg-primary-700 hover:bg-primary-800 text-white text-[11px] font-medium px-2.5 py-1 rounded">Proses</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-3.5 py-2.5 font-medium text-gray-900 dark:text-white">#ORD-882</td>
                    <td class="px-3.5 py-2.5">Rini (Malang)</td>
                    <td class="px-3.5 py-2.5">5 Karung Silase (250 Kg)</td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white tabular-nums">Rp 475.000</td>
                    <td class="px-3.5 py-2.5"><span class="bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 text-[10px] font-medium px-2 py-0.5 rounded">Selesai</span></td>
                    <td class="px-3.5 py-2.5 text-right text-gray-400 text-[11px]">Selesai</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

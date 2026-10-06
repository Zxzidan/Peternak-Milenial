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
            class="inline-flex items-center text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 px-3.5 py-2 rounded-lg transition shadow-xs"
        >
            + Tambah Produk
        </button>
    </div>
</div>

<!-- Form Tambah Produk (Collapsible & Persistent to Database) -->
<div id="form-tambah-produk" class="hidden mb-5 bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tambah Produk Baru ke Database</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Produk akan langsung tampil di katalog marketplace peternak Jawa Timur.</p>
        </div>
        <button
            type="button"
            onclick="document.getElementById('form-tambah-produk').classList.add('hidden')"
            class="text-gray-400 hover:text-gray-600 text-xs"
        >
            Batal
        </button>
    </div>

    <form action="{{ route('marketplace.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
        @csrf
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" required placeholder="Contoh: Susu Segar Pasteurisasi 1 Liter" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Produk <span class="text-red-500">*</span></label>
            <select name="product_category_id" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Wilayah Sentra <span class="text-red-500">*</span></label>
            <select name="region_id" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                @foreach ($regions as $reg)
                    <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="price" required min="100" placeholder="18000" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Stok <span class="text-red-500">*</span></label>
            <input type="number" name="stock" required min="1" placeholder="150" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan Produk <span class="text-red-500">*</span></label>
            <input type="text" name="unit" required placeholder="Botol (1L) / Karung (50Kg) / Kg" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
        </div>
        <div class="md:col-span-2">
            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan Produk &amp; Sertifikasi</label>
            <textarea name="description" rows="2" placeholder="Standar higienis, kadar lemak, sertifikat NKV/Halal..." class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white"></textarea>
        </div>
        <div class="md:col-span-2 flex justify-end gap-2 pt-2">
            <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-4 py-2 rounded-lg shadow-xs transition">
                Simpan Produk ke Database
            </button>
        </div>
    </form>
</div>

<!-- Filter Bar (Backend Powered) -->
<form action="{{ route('marketplace') }}" method="GET" class="mb-5 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-xs">
    <div class="flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('marketplace') }}" class="px-2.5 py-1 text-xs font-semibold rounded-md {{ empty($selectedCategory) ? 'bg-primary-700 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('marketplace', array_merge(request()->query(), ['kategori' => $cat->slug])) }}" class="px-2.5 py-1 text-xs font-medium rounded-md {{ $selectedCategory == $cat->slug ? 'bg-primary-700 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="flex items-center gap-2">
        <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari nama produk..." class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2.5 text-gray-900 dark:text-white">
        <select name="wilayah" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2 text-gray-900 dark:text-white">
            <option value="">Semua Wilayah</option>
            @foreach ($regions as $reg)
                <option value="{{ $reg->id }}" {{ $selectedRegion == $reg->id ? 'selected' : '' }}>{{ $reg->name }}</option>
            @endforeach
        </select>
        <select name="sort" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded-lg py-1 px-2 text-gray-900 dark:text-white">
            <option value="terbaru" {{ $selectedSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            <option value="termurah" {{ $selectedSort == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
            <option value="termahal" {{ $selectedSort == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
        </select>
        <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white text-xs px-2.5 py-1 rounded-lg">Cari</button>
    </div>
</form>

<!-- Product Grid (From Database) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @forelse ($products as $product)
    <div class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-4 flex flex-col justify-between shadow-xs hover:border-gray-300 dark:hover:border-gray-600 transition">
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">
                    {{ $product->region?->name ?? 'Jawa Timur' }}
                </span>
                <span class="text-[10px] font-semibold text-cyan-700 bg-cyan-50 dark:bg-cyan-950/60 dark:text-cyan-300 px-1.5 py-0.5 rounded">
                    {{ $product->category?->name ?? 'Ternak' }}
                </span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                {{ $product->name }}
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                {{ Str::limit($product->description, 110) }}
            </p>
            <div class="mt-2 text-[11px] text-gray-500">
                Stok: <strong class="text-gray-800 dark:text-gray-200">{{ $product->stock }} {{ $product->unit }}</strong> &bull; Penjual: {{ $product->seller?->name ?? 'Peternak Binaan' }}
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
            <span class="text-sm font-extrabold text-gray-900 dark:text-white tabular-nums">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>

            <div class="flex items-center gap-1.5">
                <!-- Trigger Buy Modal -->
                <button
                    type="button"
                    onclick="document.getElementById('buy-modal-{{ $product->id }}').classList.remove('hidden')"
                    class="px-3.5 py-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-semibold rounded-md transition shadow-xs"
                >
                    Beli
                </button>

                <!-- Delete Product -->
                <form action="{{ route('marketplace.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $product->name }} dari marketplace?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus Produk">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Buy Modal (Persists Real Order into Database) -->
        <div id="buy-modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-xs p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-5 shadow-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700 mb-3">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Form Pembelian: {{ $product->name }}</h3>
                    <button type="button" onclick="document.getElementById('buy-modal-{{ $product->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-sm">&times;</button>
                </div>
                <form action="{{ route('marketplace.products.buy', $product) }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Pembelian (Maks: {{ $product->stock }} {{ $product->unit }}) <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" required min="1" max="{{ $product->stock }}" value="1" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pembeli <span class="text-red-500">*</span></label>
                        <input type="text" name="buyer_name" required value="Budi Setiawan (Surabaya)" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor WhatsApp / HP <span class="text-red-500">*</span></label>
                        <input type="text" name="buyer_phone" required value="081234567890" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Pengiriman <span class="text-red-500">*</span></label>
                        <input type="text" name="shipping_address" required value="Jl. Basuki Rahmat No. 45, Surabaya" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan</label>
                        <input type="text" name="notes" placeholder="Contoh: Packing dingin / Bubble wrap" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 text-xs text-gray-900 dark:text-white">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" onclick="document.getElementById('buy-modal-{{ $product->id }}').classList.add('hidden')" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 text-xs font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-lg shadow-xs transition">
                            Konfirmasi Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-8 text-gray-400">Tidak ada produk ditemukan sesuai filter.</div>
    @endforelse
</div>

<!-- Section: Kelola Pesanan (Real Database Orders) -->
<div id="pesanan" class="bg-white rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 shadow-xs">
    <div class="pb-3 border-b border-gray-100 dark:border-gray-700 mb-3.5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900 dark:text-white">Kelola Pesanan Masuk (Database)</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar transaksi produk dari peternak ke pembeli yang tersimpan di sistem.</p>
        </div>
        <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
            Total: {{ $orders->count() }} Transaksi
        </span>
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
                    <th scope="col" class="px-3.5 py-2.5 text-right">Aksi Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                    <td class="px-3.5 py-2.5 font-bold text-gray-900 dark:text-white">{{ $order->order_code }}</td>
                    <td class="px-3.5 py-2.5">
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $order->shipping_address }}</span>
                        <div class="text-[10px] text-gray-400">{{ $order->buyer_phone }}</div>
                    </td>
                    <td class="px-3.5 py-2.5">
                        @foreach ($order->items as $item)
                            <div>{{ $item->quantity }}x {{ $item->product?->name ?? 'Produk' }}</div>
                        @endforeach
                    </td>
                    <td class="px-3.5 py-2.5 font-semibold text-gray-900 dark:text-white tabular-nums">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="px-3.5 py-2.5">
                        @if ($order->status === 'pending')
                            <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-[10px] font-medium px-2 py-0.5 rounded">Menunggu</span>
                        @elseif ($order->status === 'processing')
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-medium px-2 py-0.5 rounded">Diproses / Kirim</span>
                        @elseif ($order->status === 'completed')
                            <span class="bg-green-50 text-green-700 border border-green-200 text-[10px] font-medium px-2 py-0.5 rounded">Selesai</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-medium px-2 py-0.5 rounded">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td class="px-3.5 py-2.5 text-right space-x-1">
                        @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                            <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-semibold px-2 py-1 rounded transition shadow-xs">
                                    Selesaikan
                                </button>
                            </form>
                            <form action="{{ route('marketplace.orders.status', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-[10px] font-medium px-2 py-1 rounded transition">
                                    Batal
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-[11px]">Tuntas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-3.5 py-4 text-center text-gray-400">Belum ada pesanan tersimpan di database.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

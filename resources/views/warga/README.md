# Dokumentasi Arsitektur & Codingan Tampilan Warga (Masyarakat Umum)

Modul ini mendokumentasikan seluruh tampilan antarmuka (*user interface*), alur logika, dan struktur kode yang ditujukan khusus bagi pengguna dengan role **Warga / Masyarakat Umum (`role: 'umum'`)** pada platform **Portal Peternak Milenial Jawa Timur**.

---

## 1. Peran & Hak Akses Warga (`role: 'umum'`)

Dalam arsitektur *Role-Based Access Control* (RBAC) aplikasi:
- **Warga / Masyarakat Umum** bertindak sebagai **konsumen akhir, pengawas publik, dan pembeli komoditas ternak**.
- Berbeda dari role **Peternak** yang mengelola kandang dan produk, serta **Dokter Hewan** yang menangani konsultasi medis, Warga berfokus pada:
  1. **Akses Belanja Produk Pangan Asal Hewan**: Produk segar berstandar ASUH (Aman, Sehat, Utuh, Halal) langsung dari peternak lokal.
  2. **Pelacakan Transaksi & Pesanan**: Memantau status pengiriman dengan jaminan rantai dingin (*cold chain system*).
  3. **Transparansi Informasi Pasar**: Memantau fluktuasi harga komoditas harian (susu, telur, daging sapi/ayam) di pasar-pasar Jawa Timur.
  4. **Partisipasi Publik & Darurat**: Melaporkan temuan kejadian hewan ternak darurat/wabah di lingkungan tempat tinggal.
  5. **Kunjungan Pameran & Edukasi**: Mengakses agenda expo, festival ternak, dan materi edukasi terbuka.

---

## 2. Struktur Berkas Tampilan Warga (`resources/views/warga/`)

Folder ini mengelompokkan kode tampilan khusus warga untuk kebutuhan dokumentasi akademik, laporan tugas akhir/skripsi, dan bahan presentasi:

| Berkas Blade | Nama Modul | Deskripsi Fungsi bagi Warga |
| :--- | :--- | :--- |
| `dashboard.blade.php` | **Dashboard Portal Warga** | Tampilan beranda belanja (*Shopee-Style*), metrik pesanan saya, dan rekomendasi produk unggulan hari ini |
| `marketplace.blade.php` | **Katalog Belanja Marketplace** | Halaman eksplorasi produk ternak, filter kategori & wilayah, verifikasi mutu dinas, dan modal pemesanan |
| `pesanan.blade.php` | **Pesanan Saya & Tracking** | Riwayat transaksi belanja, pelacakan kurir (*JNE Cold / Paxel*), rincian pembayaran, dan invoice |
| `harga-komoditas.blade.php`| **Pantauan Harga Pangan** | Informasi harga bahan pokok asal ternak di 38 kab/kota Jatim, margin peternak vs konsumen, tren 7 hari |
| `darurat.blade.php` | **Siaga Darurat & Bencana** | Form pelaporan cepat warga bila menemukan ternak sakit/terlantar, hotline Puskeswan, & panduan bencana |
| `pameran.blade.php` | **Agenda Expo & Pameran** | Daftar pameran peternakan Jawa Timur yang dapat dikunjungi warga untuk membeli bibit atau produk olahan |

---

## 3. Pemetaan Routing & Controller untuk Warga

Seluruh tampilan warga dipasok oleh data real-time dari controller Laravel berikut:

```
[Pengguna Warga / Tamu]
          │
          ├── GET /dashboard ────────► DashboardController@index (Blok $user->isUmum())
          ├── GET /marketplace ──────► MarketplaceController@index (Tab 'katalog')
          ├── GET /pesanan ──────────► MarketplaceController@ordersIndex ($user->buyer_id)
          ├── GET /harga-komoditas ──► CommodityPriceController@index
          ├── GET /darurat ──────────► EmergencyReportController@index
          └── GET /pameran ──────────► ExhibitionController@index
```

### Cuplikan Logika Controller Khusus Warga:

#### a. Filter Transaksi Pembelian Warga (`MarketplaceController.php`):
```php
if ($currentUser && $currentUser->isUmum()) {
    $ordersQuery = Order::where('buyer_id', $currentUser->id)
        ->with(['items.product.category', 'items.product.region', 'items.seller', 'buyer'])
        ->latest();
}
```

#### b. Metrik Khusus Dashboard Warga (`DashboardController.php`):
```php
$umumMetrics = [
    'availableProductsCount' => $activeProductCount,
    'myOrdersCount'          => $user ? Order::where('buyer_id', $user->id)->count() : 0,
    'exhibitionsCount'       => $publicData['exhibitionsCount'],
    'commoditiesCount'       => $commodityCount,
];
```

---

## 4. Akun Dummy untuk Demonstrasi Modul Warga

Untuk mendemokan tampilan warga secara langsung, gunakan akun berikut:
- **Email**: `budi@gmail.com`
- **Password**: `password`
- **Nama Pengguna**: Budi Santoso (Masyarakat Umum, Kota Surabaya)
- **Data Tersedia**: Memiliki 6 riwayat transaksi aktif (pesanan selesai, dalam pengiriman kurir pendingin, diproses, dan menunggu pembayaran).


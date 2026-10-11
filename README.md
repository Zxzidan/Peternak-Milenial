# 🌾 Peternak Milenial Jawa Timur (SIP-Milenial)

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Framework">
</p>

<p align="center">
  <b>Portal Digital Terpadu Pemberdayaan Peternak Milenial, Siaga Tanggap Darurat Kesehatan Hewan, dan Hilirisasi Komoditas Peternakan Jawa Timur</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13.x">
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS v4">
  <img src="https://img.shields.io/badge/Pest_Testing-70%20Passed-22c55e?style=for-the-badge&logo=pest" alt="Pest Tests">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License MIT">
</p>

---

## 📖 Tentang Proyek

**Peternak Milenial Jawa Timur** adalah platform berbasis web modern yang dirancang untuk mendukung regenerasi petani/peternak muda di Provinsi Jawa Timur. Platform ini menghubungkan peternak milenial secara langsung dengan **Dinas Peternakan Provinsi Jawa Timur**, dokter hewan puskeswan, serta pasar konsumen umum. 

Sistem ini mengintegrasikan ekosistem peternakan dari hulu ke hilir: mulai dari pemantauan data populasi & sentra komoditas daerah, tanggap darurat wabah dan penyakit ternak (PMK, LSD, dll.), bimbingan teknis bersertifikat, konsultasi medis daring, hingga pasar digital (marketplace) hasil ternak terverifikasi.

---

## ✨ Fitur Utama

### 1. 📊 Dashboard Peternakan & Visualisasi Sentra Jatim (`/dashboard`)
- **Statistik Terpadu**: Pemantauan data populasi sapi potong, sapi perah, kambing, domba, dan unggas berbasis data resmi Dinas Peternakan dan BPS Jawa Timur.
- **Sebaran Sentra Produksi**: Visualisasi kabupaten/kota sentra penghasil susu, daging, bibit, dan pakan (seperti Pasuruan, Malang, Batu, Blitar, Tuban, Lamongan).
- **Tampilan Khusus Per Role**: Metrik yang disesuaikan secara dinamis untuk Admin Disnak, Peternak, dan Pembeli Umum.

### 2. 🛒 Marketplace & Manajemen Pesanan (`/marketplace`, `/pesanan`)
- **Katalog Produk Terverifikasi**: Menjual susu segar, olahan susu, daging segar/beku bersertifikat, pakan fermentasi (silase), dan bibit ternak unggul.
- **Verifikasi Produk Resmi**: Admin Disnak meninjau kelayakan mutu dan sanitasi produk sebelum tayang di marketplace.
- **Manajemen Pesanan Transparan**: Alur status pesanan terstruktur (`menunggu`, `dikonfirmasi`, `diproses`, `dikirim`, `selesai`, `dibatalkan`).
- **Invoice & Struk Digital**: Rincian transaksi lengkap dengan kalkulasi total belanja.

### 3. 🚨 Siaga Darurat & Kesejahteraan Hewan (`/darurat`)
- **Pelaporan Cepat Tanggap**: Laporan indikasi wabah hewan mendadak, bencana alam kandang (erupsi, banjir), atau kecelakaan ternak dengan lampiran foto bukti.
- **Triase Penanganan**: Penentuan skala prioritas penanganan darurat (`menunggu`, `diproses`, `selesai`) dan penugasan tim medis Puskeswan setempat.
- **Panduan Mitigasi & SOP Darurat**: Panduan praktis penanganan pertama saat ternak terjangkit penyakit menular atau menghadapi bencana alam.

### 4. 🩺 Telekonsultasi Dokter Hewan & Rekam Medis Digital (`/konsultasi`)
- **Konsultasi Interaktif**: Komunikasi tanya-jawab online antara peternak dengan Dokter Hewan resmi Disnak.
- **Registrasi Identitas Hewan**: Pendataan populasi ternak (ID tag ternak, jenis hewan, ras, tanggal lahir, bobot).
- **Rekam Medis Digital**: Riwayat diagnosis, riwayat vaksinasi (PMK/Brucellosis), pemberian vitamin, dan catatan dokter.
- **Ensiklopedia Penyakit**: Basis pengetahuan gejala dan penanganan penyakit umum ternak.

### 5. 🎓 Pelatihan & Bimbingan Teknis Bersertifikat (`/pelatihan`)
- **Katalog Pelatihan Terbuka**: Bimtek formulasi pakan silase, digitalisasi kandang pintar (IoT), biosekuriti modern, dan sertifikasi NKV/Halal.
- **Pendaftaran & Kuota Realtime**: Pendaftaran kuota APBD terintegrasi untuk peternak milenial terdaftar.
- **Materi Belajar Digital**: Unduh materi presentasi, modul panduan, dan video pelatihan.
- **E-Sertifikat Resmi**: Penerbitan sertifikat bimbingan teknis berpenomoran resmi dari Disnak Jatim.

### 6. 📈 Pantauan Harga Komoditas Pasar (`/harga-komoditas`)
- **Transparansi Harga**: Informasi harga harian tingkat produsen (peternak) dan harga eceran pasar di seluruh kabupaten/kota Jawa Timur.
- **Indikator Fluktuasi**: Analisis tren kenaikan/penurunan harga untuk melindungi peternak dari permainan harga tengkulak.

### 7. 🎪 Pameran Ternak & Kalender Agenda Terpadu (`/pameran`)
- **Informasi Expo & Kontes**: Kalender tahunan Jambore Peternak Milenial, Pameran Hewan Kurban, dan Kontes Ternak Piala Gubernur.
- **Pendaftaran Booth Online**: Registrasi stand pameran bagi peternak binaan secara mandiri melalui sistem.

### 8. 🔍 Pencarian Global & REST API Publik
- **Pencarian Terpadu (`/search`)**: Mencari produk marketplace, agenda bimtek, ensiklopedia penyakit, dan kegiatan pameran dalam satu input.
- **REST API Data Terbuka**:
  - `GET /api/statistik-peternakan` — Rekapitulasi statistik peternakan Jawa Timur.
  - `GET /api/sentra-peternakan` — Data wilayah sentra produksi komoditas peternakan.

---

## 👥 Matriks Hak Akses (User Roles)

| Modul / Fitur | Tamu (Guest) | Pembeli Umum (`umum`) | Peternak Milenial (`peternak`) | Admin Disnak (`admin`) |
| :--- | :---: | :---: | :---: | :---: |
| Landing Page & FAQ | ✅ | ✅ | ✅ | ✅ |
| Pantau Harga Komoditas | ✅ | ✅ | ✅ | ✅ |
| Jelajah Marketplace | ✅ | ✅ | ✅ | ✅ |
| Transaksi / Beli Produk | ❌ | ✅ | ✅ | ✅ |
| Kelola Produk Toko Sendiri | ❌ | ❌ | ✅ | ✅ |
| Verifikasi Produk Marketplace | ❌ | ❌ | ❌ | ✅ |
| Lapor Darurat Hewan | ❌ | ❌ | ✅ | ✅ |
| Manajemen Tindak Lanjut Darurat | ❌ | ❌ | ❌ | ✅ |
| Daftar Pelatihan / Bimtek | ❌ | ❌ | ✅ | ✅ |
| Kelola Pelatihan & Sertifikat | ❌ | ❌ | ❌ | ✅ |
| Konsultasi Dokter Hewan & Ternak | ❌ | ❌ | ✅ | ✅ |
| Entri Rekam Medis & Diagnosis | ❌ | ❌ | ❌ | ✅ |
| Registrasi Stand Pameran | ❌ | ❌ | ✅ | ✅ |
| Kelola Agenda Pameran | ❌ | ❌ | ❌ | ✅ |

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

- **Bahasa & Framework**: [PHP 8.3+](https://www.php.net/) & [Laravel 13.x](https://laravel.com/)
- **Frontend & Desain**: Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), [Flowbite](https://flowbite.com/), [Vite 8](https://vitejs.dev/)
- **Database**: SQLite (Bawaan development / kompatibel dengan MySQL & PostgreSQL)
- **Pengujian (Testing)**: [Pest PHP 5.x](https://pestphp.com/) (70 Automated Tests, 770+ Assertions)
- **Formatting Kode**: [Laravel Pint](https://laravel.com/docs/pint)
- **Developer Tools**: Laravel Tinker, Laravel Boost, Laravel Pail

---

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

### 1. Prasyarat Sistem
Pastikan perangkat Anda telah terpasang:
- PHP >= 8.3 (dengan ekstensi `pdo_sqlite`, `curl`, `mbstring`, `openssl`, `bcmath`)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (versi LTS direkomendasikan) & NPM
- Git

### 2. Kloning Repositori
```bash
git clone https://github.com/Zxzidan/Peternak-Milenial.git
cd peternakmilenial
```

### 3. Instalasi Dependensi PHP & Node
```bash
# Instal dependensi backend
composer install

# Instal dependensi frontend
npm install
```

### 4. Konfigurasi Lingkungan (.env)
Salin berkas template lingkungan dan buat Application Key:
```bash
cp .env.example .env
php artisan key:generate
```

*Catatan: Konfigurasi default menggunakan SQLite (`database/database.sqlite`). Jika berkas belum ada, sistem akan membuatnya secara otomatis.*

### 5. Menjalankan Migrasi & Data Seeder
Jalankan migrasi tabel beserta data demo bawaan (wilayah Jatim, akun demo, produk, pelatihan, dokter hewan, dll.):
```bash
php artisan migrate:fresh --seed
```

### 6. Menjalankan Aplikasi
Jalankan server pengembangan Laravel dan compiler aset Vite:

**Opsi A — Menggunakan perintah terpadu (Rekomendasi):**
```bash
composer run dev
```

**Opsi B — Menjalankan di terminal terpisah:**
```bash
# Terminal 1: Dev server Laravel
php artisan serve

# Terminal 2: Vite bundler
npm run dev
```

Aplikasi dapat diakses melalui peramban di: **`http://127.0.0.1:8000`** (atau via domain Herd jika menggunakan Laravel Herd: `http://peternakmilenial.test`).

---

## 🔑 Akun Demo (Bawaan Seeder)

Semua akun demo di bawah ini menggunakan kata sandi bawaan: **`password`**

| Peran (Role) | Nama | Alamat Email | Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin Disnak** | Dr. Ir. Indyah Aryani, MM | `admin@disnak.jatimprov.go.id` | Dashboard Disnak, Verifikasi Produk, Kelola Bimtek, Sertifikat, Tanggap Darurat |
| **Dokter Hewan Dinas** | drh. Ratna Kusuma | `ratna.kusuma@disnak.jatimprov.go.id` | Konsultasi Medis, Rekam Medis Hewan, Ensiklopedia Penyakit, Triase Darurat |
| **Peternak Milenial** | Slamet Rahardjo | `slamet@peternak.id` | Manajemen Produk Ternak, Lapor Darurat, Daftar Bimtek, Konsultasi, Daftar Expo |
| **Pembeli Umum** | Budi Santoso | `budi@gmail.com` | Belanja Marketplace, Pelacakan Pesanan, Pantau Harga Komoditas |

---

## 🧪 Pengujian Otomatis & Standar Kode

### Menjalankan Test Suite (Pest)
Proyek ini dilengkapi dengan 70 skenario pengujian komprehensif yang mencakup seluruh alur bisnis dan autentikasi:
```bash
php artisan test --compact
```
Atau langsung melalui Pest binary:
```bash
./vendor/bin/pest
```

### Standar Pemformatan Kode (Pint)
Untuk menjaga konsistensi gaya penulisan kode PHP sesuai standar PSR-12 dan konvensi Laravel:
```bash
./vendor/bin/pint --format agent
```

---

## 📂 Struktur Direktori Utama

```text
peternakmilenial/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controller alur kerja (Marketplace, Konsultasi, Bimtek, dll.)
│   │   └── Middleware/           # Middleware pemeriksaan otorisasi role
│   └── Models/                   # Model Eloquent (User, Product, Order, EmergencyReport, dll.)
├── database/
│   ├── factories/                # Model Factories untuk pengujian otomatis
│   ├── migrations/               # Skema tabel database relasional
│   └── seeders/                  # Seeder master data (Wilayah Jatim, Komoditas, Akun)
├── resources/
│   ├── css/                      # Konfigurasi Tailwind CSS v4
│   ├── js/                       # Skrip JavaScript / interaktivitas Flowbite
│   └── views/                    # Template Blade (Landing, Dashboard, Marketplace, dll.)
├── routes/
│   └── web.php                   # Rute web portal & endpoints API
└── tests/
    └── Feature/                  # Test suite Pest PHP untuk fitur-fitur aplikasi
```

---

## 🤝 Kontribusi

Kontribusi untuk perbaikan bug dan peningkatan fitur sangat terbuka!
1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b fitur/nama-fitur`)
3. Commit perubahan Anda (`git commit -m "Tambah fitur XYZ"`)
4. Jalankan pengujian (`php artisan test`) dan formatting (`./vendor/bin/pint --format agent`)
5. Push ke branch Anda (`git push origin fitur/nama-fitur`)
6. Buka **Pull Request**

---

## 📄 Lisensi

Aplikasi Peternak Milenial ini dirilis di bawah lisensi terbuka [MIT License](LICENSE).

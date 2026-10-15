# 🌾 Peternak Milenial Jawa Timur (SIP-Milenial)

<p align="center">
  <img src="public/img/Peternak%20Milenial.png" width="380" alt="Logo Peternak Milenial Jawa Timur">
</p>

<p align="center">
  <b>Portal Digital Terpadu Pemberdayaan Peternak Milenial, Layanan Kesehatan Hewan Terpadu (Puskeswan & Dokter Hewan Dinas), LMS Pembelajaran Bersertifikat, dan Hilirisasi Komoditas Peternakan Jawa Timur</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13.x">
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS v4">
  <img src="https://img.shields.io/badge/Pest_Testing-94%20Passed-22c55e?style=for-the-badge&logo=pest" alt="Pest Tests">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License MIT">
</p>

---

## 📖 Tentang Proyek

**Peternak Milenial Jawa Timur (SIP-Milenial)** adalah platform ekosistem digital terpadu yang dirancang untuk mempercepat regenerasi peternak muda di Provinsi Jawa Timur. Platform ini menghubungkan peternak milenial secara langsung dengan **Dinas Peternakan Provinsi Jawa Timur**, jaringan dokter hewan Puskeswan di berbagai kabupaten/kota, serta pasar konsumen umum.

Sistem ini mengintegrasikan ekosistem peternakan dari hulu ke hilir:
- **Hulu**: Pemantauan data populasi & sentra komoditas daerah resmi Disnak & BPS Jatim, registrasi identitas ternak berbasis E-Tag, ensiklopedia pedoman penyakit, serta pelaporan kesehatan hewan dan penjadwalan kunjungan medis lapangan oleh Dokter Hewan Dinas.
- **Pemberdayaan**: *Learning Management System* (LMS) peternak terpadu dengan materi modul video interaktif, pelacak progres belajar, kuis evaluasi pemahaman berstandar kelulusan, jadwal kelas tatap muka daring via Zoom, hingga penerbitan E-Sertifikat bimbingan teknis resmi ber-QR Code.
- **Hilir**: Transparansi pantauan harga komoditas pasar produsen & eceran harian, pendaftaran partisipasi pameran ternak (*expo*), serta pasar digital (*marketplace*) hasil ternak terverifikasi kelayakan mutu & sanitasi oleh Disnak.

---

## ✨ Fitur Utama

### 1. 📊 Dashboard Peternakan & Visualisasi Sentra Jatim (`/dashboard`)
- **Statistik Terpadu**: Pemantauan data populasi sapi potong, sapi perah, kambing, domba, dan unggas berbasis data resmi Dinas Peternakan dan BPS Jawa Timur.
- **Sebaran Sentra Produksi**: Visualisasi kabupaten/kota sentra penghasil susu, daging, bibit, dan pakan (seperti Pasuruan, Malang, Batu, Blitar, Tuban, Lamongan, Kediri, Jombang, Bojonegoro, dan Lumajang).
- **Tampilan Adaptif Berbasis Role**: Metrik dan widget dashboard yang disesuaikan secara dinamis untuk Admin Disnak, Dokter Hewan Dinas, Peternak Milenial, dan Pembeli Umum.

### 2. 🩺 Layanan Kesehatan Hewan Terpadu & Kunjungan Lapangan Dokter Hewan (`/kesehatan-hewan`, `/dokter-hewan`, `/admin/dokter-hewan`)
- **Pelaporan Klinis oleh Peternak (`/kesehatan-hewan`)**: Peternak dapat melaporkan kondisi ternak sakit dengan data lengkap (jenis hewan, jumlah terdampak, deskripsi gejala, tanggal awal gejala, riwayat medis, tingkat urgensi dari biasa hingga kritis, serta foto kondisi ternak) dengan penerbitan nomor tiket resmi otomatis (`LKH-xxxxx`).
- **Dedicated Portal & Dashboard Dokter Hewan Dinas (`/dokter-hewan`)**: Portal kerja khusus tenaga medis veteriner untuk melakukan triase laporan (`Laporan Masuk`, `Sedang Ditangani`, `Sudah Dijawab`, `Menunggu Kunjungan`, `Penanganan Selesai`), menyusun dugaan hipotesis klinis awal, memberikan rekomendasi tindakan darurat & isolasi, serta komunikasi dua arah interaktif dengan peternak.
- **Pengajuan & Konfirmasi Kunjungan Lapangan (*Field Visit*)**: Dokter hewan dapat menjadwalkan kunjungan inspeksi langsung ke kandang ternak, yang kemudian dapat dikonfirmasi oleh peternak, serta pencatatan berita acara hasil pemeriksaan dan tindakan medis di lapangan.
- **Manajemen Akun Dokter Hewan oleh Admin Disnak (`/admin/dokter-hewan`)**: Pembuatan akun dokter hewan dinas resmi, validasi nomor STRV (Surat Tanda Registrasi Veteriner), penugasan Puskeswan dan wilayah kerja kabupaten/kota, serta monitoring ketersediaan status dokter (aktif, cuti, dinas lapangan).

### 3. 🎓 LMS Pembelajaran & Bimbingan Teknis Bersertifikat (`/pelatihan`, `/pembelajaran`)
- **Modul & Video Praktik Interaktif**: Akses materi video pembelajaran modern (teknologi silase, sanitasi perah & cold chain, biosekuriti kandang, pakan konsentrat) yang dilengkapi sistem pelacakan progres tonton otomatis per peternak.
- **Kuis Evaluasi Pemahaman**: Kuis interaktif berbasis pilihan ganda dengan batas skor kelulusan (*passing score*), batasan waktu pengerjaan, pembahasan jawaban, dan rekam riwayat pengerjaan (*attempts*).
- **Sesi Kelas Virtual Terintegrasi (Zoom Cloud Meetings)**: Jadwal bimbingan teknis daring dengan tautan ruang Zoom, Meeting ID, Passcode, dan silabus dokumen panduan yang dapat diunduh.
- **Generator E-Sertifikat Digital Dinamis**: Penerbitan sertifikat kelulusan bimtek otomatis dengan template resmi, penandatangan resmi Disnak, stempel dinas, validasi nomor registrasi sertifikat, verifikasi QR Code, serta pratinjau dan unduh sertifikat PDF/HTML.
- **Katalog Bimtek APBD Luring**: Informasi agenda bimbingan teknis luring dengan kuota pendaftaran transparan untuk peternak milenial terdaftar.

### 4. 🛒 Marketplace & Manajemen Transaksi Pesanan (`/marketplace`, `/pesanan`)
- **Katalog Komoditas Terverifikasi**: Penjualan susu segar pasteurisasi, daging sapi berstandar Halal/NKV, silase pakan komplit fermentasi, dan bibit ternak unggul langsung dari kelompok peternak binaan.
- **Verifikasi Mutu oleh Admin**: Pemeriksaan kelayakan sanitasi dan mutu produk oleh Admin Disnak sebelum produk tayang di etalase publik.
- **Alur Transaksi & Pesanan Transparan**: Alur siklus status pesanan terstruktur (`menunggu`, `dikonfirmasi`, `diproses`, `dikirim`, `selesai`, `dibatalkan`).
- **Pelacakan Belanja & Manajemen Penjualan**: Antarmuka belanja modern untuk masyarakat umum serta panel kelola pesanan masuk bagi peternak milenial.

### 5. 📋 Telekonsultasi Dokter Hewan & Rekam Medis E-Tag (`/konsultasi`)
- **Telekonsultasi Interaktif**: Komunikasi tanya-jawab seputar keluhan kesehatan ternak harian antara peternak dan dokter hewan resmi Disnak Jatim.
- **Identitas Ternak Digital (E-Tag)**: Pendataan populasi ternak peternak (nomor E-Tag, nama ternak, ras, status reproduksi seperti laktasi/bunting/sapih, dan kondisi fisik).
- **Rekam Medis Historis**: Riwayat vaksinasi (PMK Booster, LSD), diagnosis pengobatan, pemberian antibiotik & vitamin, serta catatan dokter pemeriksa.
- **Pedoman Penyakit Ternak**: Basis pengetahuan komprehensif mengenai gejala klinis, langkah pencegahan biosekuriti, dan pertolongan pertama penyakit hewan menular.

### 6. 📈 Pantauan Harga Komoditas Pasar Jawa Timur (`/harga-komoditas`)
- **Transparansi Harga Harian**: Pantauan harga harian komoditas utama (sapi bakalan, karkas sapi, susu segar KUD, kambing, domba, pakan silase) tingkat produsen (peternak) dan konsumen (eceran pasar) di seluruh kabupaten/kota Jawa Timur.
- **Perbaruan Data Terpusat**: Panel entri dan pembaruan data harga resmi oleh Admin Dinas Peternakan.

### 7. 🎪 Pameran Ternak & Kalender Agenda Terpadu (`/pameran`)
- **Informasi Expo & Kontes Ternak**: Kalender tahunan Jatim Dairy & Livestock Expo, Pameran Hewan Kurban, Kontes Ternak Piala Gubernur, dan jadwal vaksinasi massal lapangan.
- **Pendaftaran Stand Mandiri**: Registrasi *booth* stan pameran bagi peternak binaan secara mandiri melalui platform dengan verifikasi kuota oleh Disnak.

### 8. 🔍 Pencarian Global & REST API Publik
- **Pencarian Terpadu (`/search`)**: Pencarian lintas modul (produk marketplace, modul LMS/bimtek, pedoman penyakit, dan kegiatan pameran) dalam satu bar pencarian responsif.
- **REST API Data Terbuka**:
  - `GET /api/statistik-peternakan` — Rekapitulasi statistik peternakan resmi Jawa Timur.
  - `GET /api/sentra-peternakan` — Data geospasial wilayah sentra produksi komoditas peternakan Jawa Timur.

---

## 👥 Matriks Hak Akses (User Roles)

Sistem mengadopsi kontrol akses berbasis peran (*Role-Based Access Control*) yang mencakup 5 tingkat akses:

| Modul / Fitur | Tamu (Guest) | Pembeli Umum (`umum`) | Peternak Milenial (`peternak`) | Dokter Hewan (`dokter_hewan`) | Admin Disnak (`admin`) |
| :--- | :---: | :---: | :---: | :---: | :---: |
| Landing Page, FAQ & Portal Publik | ✅ | ✅ | ✅ | ✅ | ✅ |
| Pantau Harga Komoditas Harian | ✅ | ✅ | ✅ | ✅ | ✅ |
| Jelajah & Beli Produk Marketplace | ✅ *(Lihat)* | ✅ *(Beli)* | ✅ *(Beli)* | ✅ *(Beli)* | ✅ *(Beli)* |
| Kelola Produk Toko Sendiri | ❌ | ❌ | ✅ | ❌ | ✅ |
| Verifikasi Produk Marketplace | ❌ | ❌ | ❌ | ❌ | ✅ |
| Lapor Sakit / Kesehatan Hewan (`/kesehatan-hewan`) | ❌ | ❌ | ✅ | ❌ | ✅ |
| Triage Laporan, Diagnosis & Rekomendasi | ❌ | ❌ | ❌ | ✅ | ✅ |
| Pengajuan Jadwal Kunjungan Lapangan | ❌ | ❌ | ❌ | ✅ | ✅ |
| Konfirmasi Jadwal Kunjungan Lapangan | ❌ | ❌ | ✅ | ❌ | ❌ |
| Dashboard Medis Khusus Dokter Hewan | ❌ | ❌ | ❌ | ✅ | ❌ |
| Kelola Akun Dokter Hewan Dinas | ❌ | ❌ | ❌ | ❌ | ✅ |
| Akses LMS Pembelajaran & Kuis Evaluasi | ❌ | ❌ | ✅ | ❌ | ✅ |
| Unduh E-Sertifikat Kelulusan Bimtek | ❌ | ❌ | ✅ | ❌ | ✅ |
| Kelola Materi LMS, Kuis & Terbitkan Sertifikat | ❌ | ❌ | ❌ | ❌ | ✅ |
| Registrasi Identitas E-Tag Ternak | ❌ | ❌ | ✅ | ❌ | ✅ |
| Rekam Medis & Pedoman Penyakit | ❌ | ❌ | ✅ *(Lihat)* | ✅ *(Kelola)* | ✅ *(Kelola)* |
| Registrasi Stand Pameran Ternak | ❌ | ❌ | ✅ | ❌ | ✅ |
| Kelola Kalender Agenda & Pameran | ❌ | ❌ | ❌ | ❌ | ✅ |

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

- **Bahasa & Framework**: [PHP 8.3+](https://www.php.net/) & [Laravel 13.x](https://laravel.com/)
- **Frontend & Desain**: Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), [Flowbite](https://flowbite.com/), [Vite 8](https://vitejs.dev/)
- **Database**: SQLite (Bawaan development / kompatibel penuh dengan MySQL & PostgreSQL)
- **Pengujian (Testing)**: [Pest PHP 5.x](https://pestphp.com/) (94 Automated Tests, 949 Assertions)
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
Jalankan migrasi tabel beserta data demo bawaan (wilayah Jatim, akun demo lintas role, dokter hewan, produk, materi LMS, kuis, pelatihan, pameran):
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

| Peran (Role) | Nama | Alamat Email | Puskeswan / Wilayah | Akses & Kewenangan Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Admin Disnak** | Dr. Ir. Indyah Aryani, MM | `admin@disnak.jatimprov.go.id` | Disnak Prov. Jatim | Dashboard Disnak, Verifikasi Produk, Kelola Akun Dokter Hewan, Kelola Materi LMS & Kuis, Penerbitan Sertifikat, Master Harga Pasar |
| **Dokter Hewan Dinas** | drh. Ratna Kusuma | `ratna.kusuma@disnak.jatimprov.go.id` | Puskeswan Surabaya | Dashboard Dokter, Triase Laporan Klinis, Hipotesis & Rekomendasi Medis, Pengajuan Kunjungan Lapangan, Rekam Medis E-Tag |
| **Dokter Hewan Dinas** | drh. Bambang Trihatmojo | `bambang@disnak.jatimprov.go.id` | Puskeswan Purwosari, Pasuruan | Spesialis Ruminansia Besar, Penanganan Laporan Lapangan & Rekam Medis |
| **Dokter Hewan Dinas** | drh. Nur Cahyo, M.Vet | `nurcahyo@disnak.jatimprov.go.id` | Puskeswan Pare, Kediri | Spesialis Biosekuriti & Unggas, Penanganan Laporan Lapangan & Praktik |
| **Peternak Milenial** | Slamet Rahardjo | `slamet@peternak.id` | Pandaan, Kab. Pasuruan | Lapor Kesehatan Hewan, Konfirmasi Kunjungan Dokter, LMS Video & Kuis, Unduh E-Sertifikat, Kelola Produk & Pesanan Masuk, Daftar Pameran |
| **Pembeli Umum** | Budi Santoso | `budi@gmail.com` | Kota Surabaya | Belanja Produk Marketplace Peternak, Pelacakan Status Pesanan, Pantau Harga Komoditas |

---

## 🧪 Pengujian Otomatis & Standar Kode

### Menjalankan Test Suite (Pest)
Proyek ini dilengkapi dengan 94 skenario pengujian komprehensif (949 assertions) yang mencakup seluruh alur bisnis, autentikasi multi-role, sistem dokter hewan, LMS pembelajaran, verifikasi produk, hingga integritas database:
```bash
php artisan test --compact
```
Atau langsung melalui pest binary:
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
│   │   ├── Controllers/
│   │   │   ├── AdminVeterinarianController.php      # Manajemen akun dokter hewan dinas oleh Admin
│   │   │   ├── AnimalHealthReportController.php     # Pelaporan klinis ternak oleh Peternak
│   │   │   ├── VeterinarianDashboardController.php  # Portal & dashboard penanganan dokter hewan
│   │   │   ├── TrainingController.php               # LMS pembelajaran, kuis & sertifikat digital
│   │   │   ├── MarketplaceController.php            # Transaksi belanja & verifikasi produk
│   │   │   ├── ConsultationController.php           # Telekonsultasi, rekam medis & pedoman penyakit
│   │   │   ├── CommodityPriceController.php         # Pantauan harga pasar komoditas daerah
│   │   │   └── ExhibitionController.php             # Pameran peternakan & kalender agenda terpadu
│   │   └── Middleware/                              # Pemeriksaan otorisasi peran (Role Middleware)
│   └── Models/                                      # Model Eloquent (User, Veterinarian, AnimalHealthReport, Training, LearningMaterial, Product, Order, dll.)
├── database/
│   ├── factories/                                   # Factory data pengujian otomatis (User, Veterinarian, AnimalHealthReport, dll.)
│   ├── migrations/                                  # Skema tabel database relasional
│   └── seeders/                                     # Seeder data master resmi Jawa Timur & akun demo
├── resources/
│   ├── css/                                         # Styling modern Tailwind CSS v4
│   ├── js/                                          # Skrip interaktivitas komponen Flowbite
│   └── views/                                       # Template Blade (Landing, Dashboard, Dokter Hewan, Peternak, LMS, dll.)
├── routes/
│   └── web.php                                      # Definisi rute web portal, rute terproteksi role & endpoints API
└── tests/
    └── Feature/                                     # Test suite Pest PHP komprehensif (94 skenario pengujian)
```

---

## 🤝 Kontribusi

Kontribusi untuk perbaikan bug dan peningkatan fitur sangat terbuka!
1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b fitur/nama-fitur`)
3. Commit perubahan Anda (`git commit -m "Tambah fitur XYZ"`)
4. Jalankan pengujian (`php artisan test --compact`) dan formatting (`./vendor/bin/pint --format agent`)
5. Push ke branch Anda (`git push origin fitur/nama-fitur`)
6. Buka **Pull Request**

---

## 📄 Lisensi

Aplikasi Peternak Milenial ini dirilis di bawah lisensi terbuka [MIT License](LICENSE).


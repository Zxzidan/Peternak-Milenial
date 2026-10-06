# PRD — Peternak Milenial

**Product Requirements Document**
Versi 1.0 · Sumber: *Analisis & Perancangan Sistem Aplikasi Peternak Milenial* (Dinas Peternakan Provinsi Jawa Timur, Nov 2026)

---

## 1. Ringkasan Produk

**Peternak Milenial** adalah platform digital terintegrasi (mobile Android/iOS + web) milik Dinas Peternakan Provinsi Jawa Timur. Platform ini menyatukan layanan dari empat bidang dinas dalam satu aplikasi:

| Bidang Dinas | Layanan di Aplikasi |
|---|---|
| Pembibitan, Pakan & Produksi Peternakan | Pelatihan & bimtek, materi digital, peta sentra produksi, komoditas unggulan |
| Kesehatan Hewan | Konsultasi, pelaporan penyakit, riwayat kesehatan ternak, info penyakit |
| PPHP (Pengolahan & Pemasaran Hasil Peternakan) | Marketplace, harga komoditas, pameran & promosi |
| Kesmavet (Kesehatan Masyarakat Veteriner) | Pelaporan darurat & kesejahteraan hewan, panduan penanganan bencana |

**Pernyataan masalah.** Peternak skala kecil–menengah di Jawa Timur kesulitan mengakses informasi pelatihan, pasar, harga yang transparan, dan layanan kesehatan hewan. Pemerintah juga belum memiliki data terpusat tentang sentra produksi dan kondisi peternak.

**Visi.** Satu pintu digital bagi peternak Jawa Timur untuk belajar, menjual, memantau harga, melindungi ternak, dan dipromosikan.

---

## 2. Tujuan & Metrik Keberhasilan

### 2.1 Tujuan produk
1. Memusatkan informasi dan pendaftaran pelatihan/bimtek, lengkap dengan sertifikat digital.
2. Membuka akses pasar digital bagi peternak lewat marketplace.
3. Memberi acuan harga komoditas yang transparan dan peta sebaran sentra produksi.
4. Mempercepat respons darurat dan penyakit ternak.
5. Mendokumentasikan riwayat kesehatan ternak secara digital.
6. Mempromosikan produk dan usaha peternakan lokal.
7. Memberi pemerintah data terpusat untuk pengawasan dan kebijakan.

### 2.2 Metrik (target awal, perlu divalidasi dengan Dinas)

| Metrik | Indikator | Target |
|---|---|---|
| Adopsi | Peternak terdaftar & terverifikasi | *TBD oleh Dinas* |
| Pembelajaran | Pendaftar pelatihan, sertifikat terbit | *TBD* |
| Marketplace | Jumlah produk aktif, pesanan selesai | *TBD* |
| Darurat | Waktu kirim laporan → diterima admin | < 3 detik (NFR) |
| Darurat | Waktu laporan → status "ditindaklanjuti" | *TBD (SLA Dinas)* |
| Ketersediaan | Uptime | 24/7 |
| Ekonomi (dokumen) | ROI 3 tahun, BEP | 4,05%, ± 2,89 tahun |

> Target kuantitatif adopsi belum ada di dokumen sumber. Lihat bagian 12 (Pertanyaan Terbuka).

---

## 3. Pengguna & Persona

| Role | Deskripsi | Akses |
|---|---|---|
| **Admin Dinas Peternakan** | Pengelola sistem, termasuk petugas/dokter hewan yang menindaklanjuti data | Penuh (back-office) |
| **Peternak** | Pemilik usaha ternak skala kecil–menengah di Jatim; literasi digital beragam | Seluruh fitur peternak |
| **Masyarakat Umum** | Pembeli / pengakses informasi publik | Terbatas (katalog, transaksi, harga, peta, info penyakit, pameran, kalender) |

### Persona ringkas
- **Pak Slamet (48, peternak sapi perah, Pasuruan)** — Ponsel Android entry-level, sinyal tidak stabil. Butuh lapor cepat saat sapi sakit dan acuan harga susu agar tidak ditekan tengkulak.
- **Rini (27, peternak milenial, Batu)** — Aktif di media sosial. Ingin ikut pelatihan, dapat sertifikat, jual produk olahan, ikut pameran.
- **dr. Hana (35, dokter hewan Dinas)** — Menerima konsultasi dan laporan penyakit/darurat. Butuh daftar laporan yang terprioritas dan mudah diperbarui statusnya.
- **Budi (31, pembeli umum, Surabaya)** — Mencari produk peternakan lokal, cek harga pasar.

---

## 4. Ruang Lingkup

### 4.1 In scope (v1.0)
Tujuh modul: Autentikasi & Profil, Pelatihan & Bimtek, Marketplace, Harga & Peta Sentra Produksi, Pelaporan Darurat & Kesejahteraan Hewan, Konsultasi & Kesehatan Hewan, Pameran & Promosi (termasuk Kalender). Ditambah panel admin untuk seluruh modul dan manajemen pengguna.

### 4.2 Out of scope (v1.0)
- Integrasi ke sistem informasi peternakan nasional (disiapkan, belum diimplementasi).
- Fitur komersial di luar layanan publik (iklan berbayar, dll.).

### 4.3 Perlu keputusan (lihat bagian 12)
Pembayaran/logistik di marketplace, kanal konsultasi (chat/telepon/video), mode offline.

---

## 5. Kebutuhan Fungsional

Kode mengikuti dokumen sumber (APM-FR-xx).

### 5.1 Autentikasi & Profil
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-01 | Login dengan autentikasi per role | Admin, Peternak, Umum |
| APM-FR-02 | Register akun | Peternak, Umum |
| APM-FR-03 | Lihat & ubah profil | Peternak, Umum |
| APM-FR-36 | Kelola data pengguna: lihat, verifikasi, hapus akun | Admin |

### 5.2 Pelatihan & Bimbingan Teknis
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-04 | Lihat jadwal, materi, lokasi pelatihan | Peternak, Umum |
| APM-FR-05 | Daftar pelatihan | Peternak |
| APM-FR-06 | CRUD jadwal pelatihan, verifikasi peserta | Admin |
| APM-FR-07 | Akses modul, video, panduan budidaya | Peternak |
| APM-FR-08 | CRUD materi pembelajaran | Admin |
| APM-FR-09 | Terbitkan sertifikat digital | Admin |
| APM-FR-10 | Unduh sertifikat | Peternak |

### 5.3 Marketplace
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-11 | CRUD produk (foto, deskripsi, harga, stok) | Peternak |
| APM-FR-12 | Katalog dengan filter kategori & lokasi penjual | Peternak, Umum |
| APM-FR-13 | Kelola pesanan masuk sampai selesai | Peternak |
| APM-FR-14 | Pesan & beli produk | Masyarakat Umum |

Catatan dari dokumen sumber: admin juga memverifikasi dan mengelola produk yang diunggah peternak (moderasi).

### 5.4 Harga & Peta Sentra Produksi
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-15 | Lihat harga komoditas per jenis & wilayah | Peternak, Umum |
| APM-FR-16 | Grafik perkembangan harga per periode | Peternak, Umum |
| APM-FR-17 | Input & ubah data harga per wilayah | Admin |
| APM-FR-18 | Peta lokasi & persebaran sentra produksi | Peternak, Umum |
| APM-FR-19 | Informasi komoditas unggulan per wilayah | Peternak, Umum |
| APM-FR-20 | Kelola data sentra produksi & komoditas unggulan | Admin |

### 5.5 Pelaporan Darurat & Kesejahteraan Hewan
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-21 | Lapor kejadian darurat (bencana, wabah, kecelakaan) | Peternak |
| APM-FR-22 | Lapor kondisi ternak terdampak: info, foto, lokasi, jumlah | Peternak |
| APM-FR-23 | Pantau status & progres penanganan | Peternak |
| APM-FR-24 | Verifikasi laporan & perbarui status penanganan | Admin |
| APM-FR-25 | Panduan penyelamatan ternak saat bencana | Peternak |

### 5.6 Konsultasi & Kesehatan Hewan
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-26 | Konsultasi kesehatan ternak | Peternak |
| APM-FR-27 | Lapor penyakit hewan (gejala, lokasi, data ternak) | Peternak |
| APM-FR-28 | Tanggapi konsultasi & tindak lanjut laporan penyakit | Admin (petugas/dokter hewan) |
| APM-FR-29 | Catat & lihat riwayat kesehatan (penyakit, pemeriksaan, pengobatan, vaksinasi) | Peternak, Admin |
| APM-FR-30 | Info penyakit: jenis, gejala, pencegahan, penanganan | Peternak, Umum |

### 5.7 Pameran & Promosi
| Kode | Kebutuhan | Role |
|---|---|---|
| APM-FR-31 | Lihat info kegiatan pameran | Peternak, Umum |
| APM-FR-32 | Daftar pameran bersama produk | Peternak |
| APM-FR-33 | Kelola pameran, verifikasi peserta | Admin |
| APM-FR-34 | Publikasi produk & profil usaha | Peternak |
| APM-FR-35 | Kalender kegiatan (peternakan, pameran, pelatihan, promosi) | Peternak, Umum |

### 5.7 Matriks Hak Akses (ringkas)

| Modul | Admin | Peternak | Umum |
|---|:-:|:-:|:-:|
| Autentikasi & profil | ✔ | ✔ | ✔ |
| Info pelatihan / kalender | CRUD | Lihat | Lihat |
| Daftar pelatihan, materi, sertifikat | CRUD | Pakai | ✘ |
| Katalog produk | Moderasi | CRUD & lihat | Lihat |
| Beli / pesanan | Pantau | Kelola pesanan masuk | Beli |
| Harga, peta sentra, komoditas unggulan | CRUD | Lihat | Lihat |
| Lapor darurat & kondisi ternak | Tindak lanjut | Buat & pantau | ✘ |
| Konsultasi, lapor penyakit, riwayat | Tanggapi | Buat & lihat milik sendiri | ✘ |
| Info penyakit | CRUD | Lihat | Lihat |
| Pameran | CRUD & verifikasi | Daftar & publikasi | Lihat |
| Manajemen pengguna | ✔ | ✘ | ✘ |

---

## 6. Kebutuhan Non-Fungsional

| Kode | Parameter | Spesifikasi |
|---|---|---|
| APM-NF-01 | Availability | Beroperasi 24/7, terutama untuk pelaporan darurat |
| APM-NF-02 | Security | RBAC per role; JWT; HTTPS |
| APM-NF-03 | Performance | Kirim laporan darurat & tampil harga komoditas < 3 detik |
| APM-NF-04 | Scalability | Menangani lonjakan pengguna (bencana, pameran); arsitektur microservices |
| APM-NF-05 | Usability | Sederhana, ramah literasi digital rendah |
| APM-NF-06 | Reliability | Data riwayat kesehatan, transaksi, status laporan tidak hilang |
| APM-NF-07 | Maintainability | Mudah dipelihara tim internal Dinas |
| APM-NF-08 | Compatibility | Android, iOS, browser umum; kompatibel dengan data harga & sistem pelaporan existing Dinas |

---

## 7. Alur Pengguna Utama

1. **Daftar & verifikasi** — Register → (Peternak) menunggu verifikasi admin → login.
2. **Ikut pelatihan** — Lihat pelatihan → daftar → admin verifikasi → ikut → admin terbitkan sertifikat → peternak unduh.
3. **Jual produk** — Peternak unggah produk → admin moderasi → tampil di katalog → pembeli pesan → peternak perbarui status pesanan sampai selesai.
4. **Lapor darurat** — Peternak isi laporan (jenis, foto, lokasi, jumlah) → terkirim < 3 dtk → admin verifikasi → status berubah → peternak memantau.
5. **Konsultasi/penyakit** — Peternak kirim konsultasi atau laporan → petugas menanggapi → hasil masuk riwayat kesehatan ternak.
6. **Pameran** — Lihat pameran → daftar dengan produk → admin verifikasi → produk dipublikasikan.

---

## 8. Arsitektur & Teknologi

| Lapisan | Pilihan (dari dokumen sumber) |
|---|---|
| Mobile | React Native (Android & iOS) |
| Web | Web app (stack *TBD*; disarankan React agar berbagi komponen/logika) |
| Backend | Node.js REST API, pendekatan microservices |
| Auth | JWT + RBAC |
| Transport | HTTPS |
| Hosting | Cloud (AWS atau Google Cloud) |
| Peta | Google Maps API atau Mapbox |
| Data | Basis data dengan dukungan geospasial (mis. PostgreSQL + PostGIS — usulan) |
| Notifikasi | Push & kanal komunikasi (biaya sudah dianggarkan) |

**Rekomendasi pemecahan layanan (usulan):** `auth`, `training`, `marketplace`, `market-info` (harga & peta), `emergency`, `animal-health`, `exhibition`, `notification`.

---

## 9. Model Data (garis besar, perlu disesuaikan dengan class diagram)

Diagram kelas pada dokumen sumber hanya berupa gambar. Entitas berikut diturunkan dari fitur dan harus diverifikasi:

`User`, `Role`, `PeternakProfile`, `Training`, `TrainingRegistration`, `LearningMaterial`, `Certificate`, `Product`, `Order`, `OrderItem`, `Commodity`, `CommodityPrice`, `Region`, `ProductionCenter`, `EmergencyReport`, `AffectedLivestock`, `DisasterGuide`, `Consultation`, `DiseaseReport`, `Livestock`, `HealthRecord`, `Disease`, `Exhibition`, `ExhibitionRegistration`, `BusinessProfile`, `CalendarEvent`.

---

## 10. Jadwal, Biaya & Sumber Daya

- **Estimasi usaha (Use Case Point = 109):** 2.180–3.052 person-hours; 8,38–17,34 person-month; durasi sekitar **6–8 bulan** tergantung jam kerja dan multiplier.
- **Biaya pengembangan:** Rp150.000.000 (2026). Biaya operasional Rp90 jt (2026), Rp114 jt (2027), Rp131 jt (2028). Sumber dana: APBN.
- **Manfaat:** Rp0 / Rp210 jt / Rp320 jt (2026/27/28). Discount rate 6%.
- **Tim:** Product Owner — Dinas Peternakan Prov. Jatim; Project Manager — Dr. Ir. Indyah Aryani, MM.; System/Business Analyst — Dandi Azaidane; Programmer & Tester — Anthony Enrico Chiesa, S.Kom.

**Mitra:** Universitas Brawijaya (Fapet/Pertanian & FEB — modul), PT Ikon Jawa Timur (video pembelajaran), BBPP Batu (bimtek & praktik lapangan).

---

## 11. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Literasi digital peternak rendah | Adopsi rendah | UI sederhana, bimtek penggunaan, penyuluh pendamping |
| Sinyal buruk di desa | Laporan darurat gagal terkirim | Antrean offline untuk laporan, kompresi foto, fallback SMS/WA (usulan) |
| Lonjakan trafik saat bencana/pameran | Layanan lambat | Autoscaling, caching, uji beban |
| Data harga tidak mutakhir | Kepercayaan turun | Tanggal pembaruan tampil jelas, SOP input admin |
| Beban verifikasi admin tinggi | Antrean menumpuk | Dashboard antrean, notifikasi, pembagian per wilayah |
| Penyalahgunaan marketplace | Penipuan | Moderasi produk, pelaporan, rating |
| Keamanan data pribadi & kesehatan ternak | Kebocoran | RBAC, enkripsi, audit log |
| Kesenjangan SDM internal | Pemeliharaan sulit | Dokumentasi, stack umum |

---

## 12. Asumsi & Pertanyaan Terbuka

1. **Pembayaran marketplace** — dokumen hanya menyebut "transaksi jual-beli". Apakah pembayaran in-app (payment gateway) atau pesanan lalu bayar langsung (COD/transfer manual)? *Default PRD: pesanan + konfirmasi manual di v1.*
2. **Kanal konsultasi** — chat teks asinkron, atau juga telepon/video? *Default: chat teks dengan lampiran foto.*
3. **Real-time harga** — dokumen menyebut real-time, tetapi data diinput admin. *Default: diperbarui admin; ada cap waktu pembaruan.*
4. **Registrasi peternak** — dokumen mengatur admin memverifikasi akun, tapi syarat/dokumen verifikasi belum jelas (NIK, KTP, NIB, dll.).
5. **Penerbitan sertifikat** — manual oleh admin (sesuai FR-09) atau otomatis setelah kehadiran/ujian?
6. **Hak akses peternak sebagai pembeli** — FR-14 hanya menyebut Masyarakat Umum; apakah peternak boleh membeli juga?
7. **Mode offline** — belum ada di dokumen; direkomendasikan untuk pelaporan darurat.
8. **Bahasa** — Bahasa Indonesia; pertimbangkan Bahasa Jawa/Madura untuk label tertentu (opsional).
9. **Target adopsi** kuantitatif belum ditetapkan.
10. **Inkonsistensi dokumen sumber** — Bab III dan Table 3 masih menyebut "Margin Guard" dan "Jatim Eats" (sisa template). Diasumsikan salah ketik dan bukan produk lain.

---

## 13. Kriteria Rilis (Definition of Done v1.0)

- Seluruh APM-FR-01 s.d. 36 lolos UAT per role.
- APM-NF-01–08 terverifikasi (uji beban, uji keamanan, uji kompatibilitas perangkat).
- Laporan darurat terkirim < 3 detik pada jaringan 3G/4G standar.
- Panel admin dapat dipakai Dinas tanpa bantuan developer.
- Dokumentasi pengguna dan materi pelatihan penggunaan aplikasi siap.
- Pilot di minimal beberapa kabupaten sebelum peluncuran provinsi (usulan).

# TASK — Peternak Milenial

Rencana pengerjaan berdasarkan `prd.md`. Estimasi total **± 6–8 bulan** (sesuai analisis Use Case Point).
Format: `[ ]` belum · `[~]` berjalan · `[x]` selesai. Kode `FR`/`NF` merujuk dokumen sumber.

**Tim:** PM — Indyah Aryani · SA/BA — Dandi Azaidane · Dev & QA — Anthony Enrico Chiesa
Prioritas: **P0** wajib rilis awal · **P1** penting · **P2** bisa menyusul

---

## Fase 0 — Persiapan & Keputusan (Minggu 1–3)

- [ ] **P0** Selesaikan pertanyaan terbuka PRD bagian 12 (pembayaran, kanal konsultasi, syarat verifikasi, sertifikat)
- [ ] **P0** Perbaiki dokumen sumber: ganti sisa "Margin Guard" & "Jatim Eats"
- [ ] **P0** Tetapkan target adopsi & SLA penanganan darurat bersama Dinas
- [ ] **P0** Export diagram (use case, activity, class, sequence) ke format teks/editable agar bisa jadi acuan dev
- [ ] **P0** Finalisasi ERD dari class diagram
- [ ] **P0** Setup repo (monorepo): `apps/mobile`, `apps/web`, `services/*`, `packages/shared`
- [ ] **P0** Setup CI/CD, lingkungan dev/staging/prod di cloud (AWS/GCP)
- [ ] **P0** Pilih peta: Google Maps vs Mapbox (biaya, kuota, data geospasial)
- [ ] **P1** Setup monitoring, logging terpusat, error tracking
- [ ] **P1** Terapkan design tokens dari `styleguide.md` ke kode (tema mobile & web)
- [ ] **P1** Kontrak API (OpenAPI) draf awal

## Fase 1 — Fondasi: Auth, RBAC, Profil (Minggu 3–6)

- [ ] **P0** Skema DB: User, Role, PeternakProfile, Region
- [ ] **P0** **FR-02** Register (Peternak, Umum) + validasi
- [ ] **P0** **FR-01** Login JWT + refresh token, logout, sesi aman
- [ ] **P0** **NF-02** Middleware RBAC (Admin, Peternak, Umum)
- [ ] **P0** Reset/lupa kata sandi
- [ ] **P0** **FR-03** Lihat & edit profil
- [ ] **P0** Alur verifikasi akun peternak oleh admin
- [ ] **P0** Layanan notifikasi dasar (push + in-app)
- [ ] **P1** Audit log aksi admin
- [ ] **P1** Onboarding singkat pengguna baru (3 layar)
- [ ] **P0** Test: unit auth/RBAC, uji penetrasi dasar

## Fase 2 — Panel Admin Dasar & Manajemen Pengguna (Minggu 5–8)

- [ ] **P0** Kerangka web admin: layout, navigasi, tabel data standar
- [ ] **P0** **FR-36** Kelola pengguna: daftar, filter, verifikasi, hapus/nonaktifkan
- [ ] **P1** Dashboard ringkasan (jumlah pengguna, laporan masuk, antrean verifikasi)
- [ ] **P1** Filter berdasarkan wilayah (kabupaten/kota)

## Fase 3 — Pelatihan & Bimbingan Teknis (Minggu 7–11)

**Peternak/Umum**
- [ ] **P0** **FR-04** Daftar & detail pelatihan (jadwal, lokasi, materi)
- [ ] **P0** **FR-05** Daftar pelatihan + status pendaftaran
- [ ] **P0** **FR-07** Perpustakaan materi: modul (PDF), video, panduan
- [ ] **P0** **FR-10** Unduh sertifikat (PDF)
- [ ] **P1** Penanda progres belajar

**Admin**
- [ ] **P0** **FR-06** CRUD pelatihan + verifikasi peserta
- [ ] **P0** **FR-08** CRUD materi (upload file/video, kategori)
- [ ] **P0** **FR-09** Penerbitan sertifikat (template, nomor unik, QR verifikasi)
- [ ] **P1** Ekspor daftar peserta (CSV/XLSX)

**Teknis**
- [ ] **P0** Penyimpanan file (object storage) + CDN untuk video
- [ ] **P1** Streaming video adaptif untuk jaringan lambat
- [ ] **P0** Test: pendaftaran, kuota, sertifikat

## Fase 4 — Marketplace (Minggu 10–16)

**Peternak**
- [ ] **P0** **FR-11** CRUD produk (foto multi, deskripsi, harga, stok, kategori)
- [ ] **P0** **FR-13** Kelola pesanan masuk (terima, proses, kirim, selesai, batal)
- [ ] **P1** Notifikasi pesanan baru

**Pembeli**
- [ ] **P0** **FR-12** Katalog: pencarian, filter kategori & lokasi penjual
- [ ] **P0** Detail produk + profil penjual
- [ ] **P0** **FR-14** Keranjang & checkout/pemesanan
- [ ] **P0** Riwayat & pelacakan pesanan
- [ ] **P1** Ulasan & rating

**Admin**
- [ ] **P0** Moderasi produk (setujui/tolak/takedown)
- [ ] **P1** Laporan transaksi
- [ ] **P1** Mekanisme laporan produk/penjual bermasalah

**Keputusan perlu**
- [ ] **P0** Putuskan model pembayaran (manual/gateway) sebelum mulai checkout
- [ ] **P1** Ongkos kirim / logistik (jika dibutuhkan)

**Teknis**
- [ ] **P0** Kompresi & resize gambar sisi klien
- [ ] **P0** Manajemen stok anti-race condition
- [ ] **P0** Test: alur pesanan end-to-end

## Fase 5 — Harga Komoditas & Peta Sentra Produksi (Minggu 14–19)

- [ ] **P0** Skema: Commodity, CommodityPrice (per wilayah & tanggal), ProductionCenter (geospasial)
- [ ] **P0** Telaah integrasi dengan data harga existing Dinas (impor/sinkron)
- [ ] **P0** **FR-17** Admin: input/ubah harga (form + impor CSV)
- [ ] **P0** **FR-15** Daftar harga per jenis & wilayah, dengan tanggal pembaruan
- [ ] **P0** **FR-16** Grafik perkembangan harga (7 hari/30 hari/1 tahun)
- [ ] **P0** **FR-20** Admin: kelola sentra produksi & komoditas unggulan (pin di peta)
- [ ] **P0** **FR-18** Peta sentra produksi (marker, cluster, filter komoditas)
- [ ] **P0** **FR-19** Halaman komoditas unggulan per wilayah
- [ ] **P1** Cache harga agar tampil < 3 detik (**NF-03**)
- [ ] **P2** Notifikasi perubahan harga signifikan (opt-in)

## Fase 6 — Pelaporan Darurat & Kesejahteraan Hewan (Minggu 18–23)

> Fitur kritis. Dukung jaringan lemah dan uji paling ketat.

- [ ] **P0** Skema: EmergencyReport, AffectedLivestock, status & riwayat status
- [ ] **P0** **FR-21** Form lapor darurat (jenis kejadian, deskripsi) — maksimal 3 langkah
- [ ] **P0** **FR-22** Lampiran foto, lokasi GPS otomatis, jumlah ternak terdampak
- [ ] **P0** Antrean offline: simpan lokal dan kirim ulang saat online
- [ ] **P0** **FR-23** Pantau status laporan (Diterima → Diverifikasi → Ditangani → Selesai)
- [ ] **P0** **FR-24** Admin: antrean laporan, verifikasi, ubah status, catatan penanganan
- [ ] **P0** Notifikasi ke admin untuk laporan baru; ke peternak saat status berubah
- [ ] **P0** **FR-25** Konten panduan penanganan bencana (CRUD admin + tampilan peternak)
- [ ] **P1** Peta sebaran laporan untuk admin
- [ ] **P1** Penandaan prioritas/tingkat keparahan
- [ ] **P0** **NF-03** Uji: laporan terkirim & diteruskan < 3 detik
- [ ] **P0** **NF-04** Uji beban simulasi bencana massal

## Fase 7 — Konsultasi & Kesehatan Hewan (Minggu 22–28)

- [ ] **P0** Skema: Livestock, HealthRecord, Consultation, DiseaseReport, Disease
- [ ] **P0** Registrasi data ternak milik peternak (jenis, jumlah, identitas)
- [ ] **P0** **FR-26** Konsultasi: kirim pertanyaan + foto, utas percakapan
- [ ] **P0** **FR-27** Lapor penyakit: gejala, lokasi, data ternak
- [ ] **P0** **FR-28** Admin/dokter hewan: antrean konsultasi & laporan, balasan, tindak lanjut
- [ ] **P0** **FR-29** Riwayat kesehatan: penyakit, pemeriksaan, pengobatan, vaksinasi (peternak & petugas)
- [ ] **P0** **FR-30** Info penyakit hewan (CRUD admin, baca publik)
- [ ] **P1** Pengingat jadwal vaksinasi
- [ ] **P1** Hubungkan hasil konsultasi/laporan ke riwayat kesehatan
- [ ] **P2** Peta sebaran kasus penyakit untuk admin

## Fase 8 — Pameran, Promosi & Kalender (Minggu 26–31)

- [ ] **P0** Skema: Exhibition, ExhibitionRegistration, BusinessProfile, CalendarEvent
- [ ] **P0** **FR-31** Daftar & detail kegiatan pameran
- [ ] **P0** **FR-32** Daftar pameran bersama produk terpilih
- [ ] **P0** **FR-33** Admin: CRUD pameran, verifikasi peserta
- [ ] **P0** **FR-34** Publikasi produk & profil usaha
- [ ] **P0** **FR-35** Kalender terpadu (pelatihan + pameran + kegiatan lain)
- [ ] **P1** Pengingat kegiatan (push)
- [ ] **P1** Halaman profil usaha dapat dibagikan (tautan)

## Fase 9 — Penguatan & Kualitas (Minggu 30–34)

**Non-fungsional**
- [ ] **NF-01** Rancang HA: multi-zona, backup, health check, rencana pemulihan
- [ ] **NF-04** Autoscaling + uji beban (lonjakan pameran/bencana)
- [ ] **NF-02** Review keamanan: OWASP, rate limiting, validasi unggahan, enkripsi data sensitif
- [ ] **NF-05** Uji kegunaan dengan peternak nyata (literasi rendah) + perbaikan
- [ ] **NF-06** Uji integritas data (transaksi, riwayat, status)
- [ ] **NF-07** Dokumentasi teknis, panduan pemeliharaan, runbook
- [ ] **NF-08** Uji perangkat: Android (low-end), iOS, browser umum
- [ ] **P1** Aksesibilitas: ukuran sentuh, kontras, label (lihat `styleguide.md`)
- [ ] **P1** Lokalisasi teks dan pengecekan bahasa sederhana

**QA**
- [ ] **P0** Regresi menyeluruh FR-01 s.d. FR-36
- [ ] **P0** UAT per role bersama Dinas (Admin, Peternak, Umum)
- [ ] **P0** Perbaikan bug prioritas tinggi

## Fase 10 — Peluncuran & Pendampingan (Minggu 33–38)

- [ ] **P0** Pilot terbatas di beberapa kabupaten dengan BBPP Batu & penyuluh
- [ ] **P0** Materi pelatihan penggunaan aplikasi (panduan + video pendek)
- [ ] **P0** Isi konten awal: pelatihan, materi UB/PT Ikon, info penyakit, panduan bencana
- [ ] **P0** Migrasi/impor data harga & sentra produksi existing
- [ ] **P0** Rilis Play Store & App Store + web
- [ ] **P0** Sosialisasi ke seluruh kabupaten/kota
- [ ] **P1** Kanal bantuan (FAQ, kontak admin)
- [ ] **P1** Dashboard analitik penggunaan untuk Dinas
- [ ] **P1** Retrospektif & rencana iterasi v1.1 (integrasi sistem nasional, dll.)

---

## Dependensi Utama

| Tugas | Bergantung pada |
|---|---|
| Semua modul | Fase 1 (auth/RBAC) |
| Sertifikat | Pelatihan terverifikasi (Fase 3) |
| Pameran | Produk marketplace (Fase 4) |
| Riwayat kesehatan | Data ternak (Fase 7) |
| Peta sentra / sebaran laporan | Keputusan penyedia peta (Fase 0) |
| Checkout | Keputusan model pembayaran (Fase 0/4) |
| Konten awal | Mitra: UB (modul), PT Ikon (video), BBPP Batu (bimtek) |

## Definition of Done per Tugas

1. Memenuhi kriteria di PRD dan lolos review kode.
2. Test otomatis lulus (unit/integrasi); jalur kritis punya test E2E.
3. Mengikuti `styleguide.md`; teks UI sudah ditinjau.
4. Diuji di perangkat Android entry-level.
5. Dokumentasi API/perubahan diperbarui.
6. Disetujui Product Owner (Dinas) pada demo sprint.

## Catatan Beban Kerja

Dokumen sumber hanya menempatkan satu programmer sekaligus tester. Dengan lingkup 36 FR dan 8 NF, jadwal 6–8 bulan hanya realistis bila ada tambahan tenaga (mis. desainer UI/UX, QA terpisah, DevOps paruh waktu). Rekomendasikan ini ke PM sebelum Fase 1.

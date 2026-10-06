# Style Guide — Peternak Milenial

Panduan visual, interaksi, dan bahasa untuk aplikasi mobile (React Native) dan web (admin & publik).

## 1. Prinsip Desain

1. **Jelas sebelum cantik.** Pengguna utama adalah peternak dengan literasi digital beragam. Satu layar, satu tujuan.
2. **Terbaca di lapangan.** Dipakai di bawah matahari, dengan tangan kotor, di ponsel entry-level dan sinyal lemah. Kontras tinggi, target sentuh besar, gambar ringan.
3. **Darurat itu cepat.** Alur lapor darurat harus bisa diselesaikan dalam beberapa ketukan dan tidak boleh bergantung pada hal-hal dekoratif.
4. **Terpercaya seperti layanan pemerintah, hangat seperti komunitas.** Rapi dan konsisten, bahasanya akrab tetapi sopan.
5. **Ikon + kata.** Jangan bergantung pada ikon saja. Selalu sertakan label.

---

## 2. Warna

Semua warna teks diuji terhadap latar sesuai WCAG AA (≥ 4.5:1 untuk teks normal).

### 2.1 Warna Merek Resmi (Diekstrak dari Logo Aplikasi)

| Identitas Logo | Token | Hex | Pemakaian |
|---|---|---|---|
| **Peternak (Navy Blue)** | `--color-primary-700` | `#013A85` | **Warna Brand Utama**: Word "Peternak", siluet sapi, tombol utama, tautan aktif |
| | `--color-primary-600` | `#0A52AB` | State hover tombol utama, ikon interaktif |
| | `--color-primary-50`  | `#EFF6FC` | Latar kartu/menu aktif, highlight navigasi |
| **Milenial (Cyan / Sky)** | `--color-cyan-500`    | `#009FD2` | **Warna Aksen Milenial**: Word "Milenial", pixel digital, badge sertifikasi, chip teknologi |
| | `--color-cyan-50`     | `#F0F9FD` | Latar chip verifikasi, info digital |
| **Pertumbuhan (Green)** | `--color-green-500`   | `#209527` | **Warna Pertumbuhan & Pakan**: Panah pertumbuhan, daun, status ternak sehat/stabil, margin laba |
| | `--color-green-700`   | `#04793F` | Hijau dasar daun logo, teks kontras tinggi di atas latar terang |
| | `--color-green-50`    | `#F0FBF2` | Latar badge sukses, status sehat |
| **Mentari Jatim (Sun Gold)** | `--color-amber-500`   | `#FBBB03` | **Warna Mentari Logo**: Matahari terbit, status proses/tindakan, rating, perhatian |
| | `--color-amber-50`    | `#FFFBF0` | Latar chip proses, warning lembut |

### 2.2 Warna Semantik

| Token | Hex | Pemakaian |
|---|---|---|
| `--color-danger-600` | `#DC2626` | Tombol/banner **darurat 24/7**, laporan wabah kesmavet |
| `--color-danger-50`  | `#FEF2F2` | Latar pesan darurat/error |
| `--color-warning-500`| `#FBBB03` | Peringatan, status "sedang ditangani / fluktuatif" (Sinar Mentari Logo) |
| `--color-success-500`| `#209527` | Sukses, ternak sehat, komoditas stabil (Pertumbuhan Logo) |
| `--color-info-500`   | `#009FD2` | Informasi, teknologi smart farming (Milenial Cyan Logo) |

### 2.3 Netral

| Token | Hex | Pemakaian |
|---|---|---|
| `--color-text` | `#111827` | Teks utama |
| `--color-text-muted` | `#6B7280` | Teks sekunder |
| `--color-border` | `#E5E7EB` | Garis, pemisah |
| `--color-surface` | `#FFFFFF` | Kartu, container |
| `--color-bg` | `#F9FAFB` | Latar halaman terang |
| `--color-bg-dark` | `#111827` | Latar halaman gelap |

### 2.4 Mode Gelap
Dukungan mode gelap menggunakan varian `.dark` Tailwind CSS v4 dengan surface `#1F2937` dan background `#111827`. Warna darurat merah tetap terjaga tegas.

### 2.5 Aturan Pemakaian
- **Biru Peternak (`#013A85`)**: Wibawa instansi pemerintah dan fondasi utama peternakan.
- **Cyan Milenial (`#009FD2`)**: Sentuhan modernitas generasi muda dan digitalisasi.
- **Hijau Pertumbuhan (`#209527`)**: Keberhasilan, kesehatan ternak, dan kemakmuran pakan.
- **Kuning Mentari (`#FBBB03`)**: Energi, kewaspadaan penanganan, dan optimisme.
- **Merah Kesmavet (`#DC2626`)**: **Hanya** untuk tombol Siaga Darurat 24/7 dan peringatan kritis.

---

## 3. Tipografi

**Font:** [Inter](https://rsms.me/inter/) (utama). Cadangan: `system-ui, -apple-system, "Segoe UI", Roboto, sans-serif`. Di perangkat low-end boleh langsung memakai font sistem untuk menghemat unduhan.

| Gaya | Ukuran / Line-height | Berat | Pemakaian |
|---|---|---|---|
| `display` | 28 / 36 | 700 | Judul beranda, angka besar harga |
| `h1` | 24 / 32 | 700 | Judul layar |
| `h2` | 20 / 28 | 600 | Judul seksi |
| `h3` | 18 / 26 | 600 | Judul kartu |
| `body-lg` | 17 / 26 | 400 | Teks bacaan utama di mobile |
| `body` | 16 / 24 | 400 | Teks standar (minimum untuk isi) |
| `label` | 14 / 20 | 600 | Label form, tombol kecil |
| `caption` | 13 / 18 | 400 | Keterangan, cap waktu |

Aturan:
- **Ukuran isi minimum 16 px** di mobile. Jangan memakai < 13 px.
- Dukung pembesaran teks sistem hingga 200% tanpa elemen terpotong.
- Angka harga memakai `font-variant-numeric: tabular-nums`.
- Panjang baris maksimal ± 70 karakter di web.

---

## 4. Spasi, Tata Letak & Bentuk

### 4.1 Skala spasi (basis 4 px)
`4 · 8 · 12 · 16 · 24 · 32 · 48 · 64`

- Padding layar mobile: **16**
- Jarak antar kartu: **12**
- Jarak antar seksi: **24**

### 4.2 Radius
| Token | Nilai | Pemakaian |
|---|---|---|
| `radius-sm` | 8 | Input, chip |
| `radius-md` | 12 | Tombol, kartu |
| `radius-lg` | 16 | Sheet, modal |
| `radius-full` | 999 | Avatar, badge bulat |

### 4.3 Elevasi
- `shadow-1`: `0 1px 2px rgba(0,0,0,.08)` — kartu
- `shadow-2`: `0 4px 12px rgba(0,0,0,.12)` — sheet, dropdown
- Utamakan **garis tipis** (`--color-border`) dibanding bayangan berat, agar ringan di perangkat murah.

### 4.4 Grid & breakpoint (web)
| Nama | Lebar | Kolom |
|---|---|---|
| mobile | < 640 | 4 |
| tablet | 640–1023 | 8 |
| desktop | ≥ 1024 | 12 (maks konten 1200) |

Panel admin mengutamakan desktop; situs publik dan aplikasi peternak mengutamakan mobile.

---

## 5. Ikonografi & Gambar

- Set ikon: **Lucide** (garis 2 px, sudut membulat), ukuran 24 (standar), 20 (padat), 32 (navigasi besar).
- Ikon selalu berpasangan dengan label teks pada navigasi dan aksi penting.
- Ilustrasi: sederhana, datar, bertema ternak (sapi, kambing, ayam, domba), memakai palet merek. Hindari foto stok generik.
- Foto produk: rasio **4:3**, dikompres sisi klien (maks ± 1 MB), `placeholder` abu-abu saat memuat.
- Foto laporan darurat: kompres otomatis, simpan metadata lokasi.
- Selalu sediakan `alt`/`accessibilityLabel` bermakna.

---

## 6. Komponen

### 6.1 Tombol

| Varian | Tampilan | Pemakaian |
|---|---|---|
| **Primary** | Latar `primary-600`, teks putih, tinggi 52 | Aksi utama |
| **Secondary** | Garis `primary-600`, teks `primary-700`, latar transparan | Aksi pendukung |
| **Accent** | Latar `accent-600`, teks `#1F2933` | Promosi, ajakan khusus |
| **Danger** | Latar `danger-700`, teks putih | **Lapor darurat**, hapus |
| **Text** | Hanya teks `primary-700` | Aksi tersier |

Aturan:
- Tinggi minimum **48 px**, area sentuh minimum **48×48 dp**; jarak antar target ≥ 8.
- Tombol lebar penuh di mobile untuk aksi utama.
- State: default, tekan (satu tingkat lebih gelap), fokus (ring 3 px `info-600`), nonaktif (`disabled` + alasan bila perlu), memuat (spinner + teks tetap terlihat).
- Label kata kerja: "Daftar Pelatihan", "Kirim Laporan", bukan "OK" atau "Submit".

### 6.2 Input Form
- Tinggi 52, radius 8, garis 1.5 px `--color-border`, fokus `primary-600`.
- **Label selalu terlihat di atas input** (bukan hanya placeholder).
- Teks bantuan di bawah (caption). Error: garis + teks `danger-600` + ikon, tulis solusi ("Nomor HP harus 10–13 digit").
- Gunakan tipe keyboard yang tepat (angka untuk harga/jumlah, telepon, email).
- Pilihan: gunakan **segmented control/radio besar** bila ≤ 4 opsi, bukan dropdown kecil.
- Pilih wilayah bertingkat (Kabupaten → Kecamatan → Desa) dengan pencarian.
- Simpan draf otomatis pada form panjang (laporan penyakit, produk).

### 6.3 Kartu
- Latar putih, radius 12, garis `--color-border`, padding 16.
- Seluruh kartu dapat disentuh bila mengarah ke detail.
- Varian: **KartuProduk** (foto 4:3, nama, harga, lokasi), **KartuPelatihan** (tanggal, lokasi, kuota, status), **KartuLaporan** (jenis, waktu, status), **KartuHarga** (komoditas, harga, perubahan ▲▼).

### 6.4 Badge Status

| Status | Warna | Ikon | Contoh teks |
|---|---|---|---|
| Menunggu | `warning-700` di atas `accent-100` | Jam | Menunggu verifikasi |
| Diproses | `info-600` di atas `info-50` | Roda gigi | Sedang ditangani |
| Selesai | `primary-700` di atas `primary-50` | Centang | Selesai |
| Ditolak/Gagal | `danger-600` di atas `danger-50` | Silang | Ditolak |

Dipakai untuk: pendaftaran pelatihan, pesanan, laporan darurat, laporan penyakit, pendaftaran pameran, verifikasi akun.

### 6.5 Navigasi
- **Mobile (Peternak):** tab bawah, 5 item: **Beranda · Belajar · Pasar · Kesehatan · Akun**. Tombol **Lapor Darurat** merah, selalu terjangkau (tombol melayang di Beranda atau pintasan tetap).
- **Mobile (Umum):** Beranda · Pasar · Harga & Peta · Info · Akun.
- **Web Admin:** sidebar kiri (modul), header atas (pencarian, notifikasi, profil). Tampilkan jumlah antrean pada modul (mis. "Darurat 3").
- Tombol kembali selalu ada; judul layar jelas; breadcrumb di web.

### 6.6 Tabel & Data Admin
- Baris 48–56 px, zebra tipis, header lengket.
- Filter wilayah dan status di atas tabel; aksi massal bila perlu.
- Aksi destruktif memakai dialog konfirmasi menyebut objeknya ("Hapus pengguna *Slamet*?").
- Ekspor CSV/XLSX tersedia pada tabel utama.

### 6.7 Grafik Harga
- Garis tunggal `primary-600`, area fill 12% opasitas; bandingkan wilayah dengan maks 3 garis (warna berbeda + gaya garis berbeda).
- Pemilih periode: **7H · 30H · 1T**.
- Tampilkan **harga terkini besar**, perubahan (▲ hijau / ▼ merah + persen), dan **cap waktu pembaruan** ("Diperbarui 6 Okt 2026, 09.00").
- Sumbu dan label ≥ 12 px, sentuhan menampilkan tooltip nilai.
- Sediakan tabel alternatif untuk pembaca layar.

### 6.8 Peta Sentra Produksi
- Marker berwarna/ikon per komoditas, cluster bila padat.
- Bottom sheet detail saat marker disentuh (nama sentra, komoditas unggulan, kontak).
- Filter komoditas dan wilayah di atas peta; tombol "Lokasi saya".
- Muat tile ringan; tampilkan daftar sebagai alternatif saat peta gagal dimuat.

### 6.9 Notifikasi & Umpan Balik
- **Toast** (3–4 detik) untuk keberhasilan ringan; **banner** untuk peringatan; **dialog** untuk tindakan yang tak bisa dibatalkan.
- Banner darurat sistem (mis. status bencana): latar `danger-50`, garis kiri `danger-700`, ikon peringatan.
- Setiap aksi berbalas dalam < 100 ms (state tekan, spinner).

### 6.10 State Kosong, Memuat, Error
- **Skeleton** untuk daftar, bukan spinner penuh layar.
- **Kosong:** ilustrasi kecil + penjelasan + satu tombol aksi ("Belum ada produk. Tambah produk pertama Anda").
- **Error jaringan:** pesan ramah + tombol "Coba lagi" + info bahwa data tersimpan bila sedang menulis.
- **Offline:** banner tipis "Anda sedang offline" dan tampilkan data terakhir yang tersimpan.

---

## 7. Pola Khusus Fitur

### 7.1 Lapor Darurat (kritis)
1. Tombol merah **"Lapor Darurat"** selalu tersedia dari Beranda.
2. Langkah 1: pilih jenis kejadian (kartu besar bergambar: banjir, kebakaran, gempa/longsor, wabah penyakit, kecelakaan, lainnya).
3. Langkah 2: foto (opsional tapi disarankan), lokasi otomatis (bisa diubah), jumlah ternak terdampak (stepper besar +/−), catatan singkat.
4. Langkah 3: tinjau → **Kirim Laporan**.
5. Setelah terkirim: layar konfirmasi besar dengan nomor laporan, status awal, dan tombol "Pantau Laporan".
6. Tanpa sinyal: simpan lokal, tampilkan "Laporan tersimpan, akan terkirim otomatis saat online" dengan badge antrean.
7. Tidak ada iklan, pop-up, atau elemen lain yang mengganggu alur ini.

### 7.2 Marketplace
- Beranda pasar: pencarian, chip kategori, grid 2 kolom produk.
- Harga selalu dengan "Rp" dan pemisah ribuan titik (`Rp1.250.000`), satuan jelas ("/kg", "/ekor").
- Lencana **"Terverifikasi Dinas"** untuk penjual/produk yang telah dimoderasi.
- Stok rendah dan habis ditandai jelas.

### 7.3 Pelatihan & Sertifikat
- Kartu pelatihan menampilkan tanggal, lokasi, sisa kuota, dan status pendaftaran.
- Perpustakaan materi: tab Modul · Video · Panduan; ikon jenis file dan ukuran unduhan; tandai "Sudah dipelajari".
- Sertifikat: pratinjau, tombol **Unduh PDF** dan **Bagikan**; mengandung nomor unik dan QR verifikasi.

### 7.3 Kesehatan Ternak
- Riwayat berbentuk **timeline vertikal** per ternak/kelompok, ikon per jenis (penyakit, pemeriksaan, obat, vaksin).
- Konsultasi seperti obrolan: gelembung, lampiran foto, penanda "dokter hewan".
- Info penyakit: kartu dengan bagian terlipat — Gejala · Pencegahan · Penanganan.

---

## 8. Aksesibilitas

- Kontras teks ≥ 4.5:1; elemen UI & grafik ≥ 3:1.
- Target sentuh ≥ 48 dp, jarak ≥ 8.
- Semua kontrol memiliki `accessibilityLabel`/`aria-label`; urutan fokus logis.
- Dukung TalkBack/VoiceOver, perbesaran teks 200%, dan ring fokus terlihat di web.
- Jangan membatasi waktu tanpa peringatan; hindari animasi berkedip. Hormati *reduce motion*.
- Pesan error dibacakan (live region) dan menjelaskan cara memperbaiki.

---

## 9. Gerak (Motion)

- Durasi 150–250 ms, kurva `ease-out` untuk masuk, `ease-in` untuk keluar.
- Gerak hanya untuk memberi petunjuk (transisi layar, sheet). Tidak ada animasi dekoratif pada alur darurat.
- Mati otomatis bila *reduce motion* aktif.

---

## 10. Performa Antarmuka

- Target ukuran halaman awal web < 300 KB (tanpa gambar).
- Gambar lazy-load, format WebP, ukuran sesuai layar.
- Daftar panjang memakai paginasi/infinite scroll dengan skeleton.
- Cache data baca (harga, katalog, materi terunduh) untuk penggunaan jaringan lemah.
- Video: kualitas adaptif, opsi "Hemat data" dan unduh via Wi-Fi.

---

## 11. Suara & Bahasa (UX Writing)

**Karakter:** ramah, sopan, lugas. Seperti penyuluh lapangan yang membantu, bukan formulir birokrasi.

| Prinsip | Hindari | Gunakan |
|---|---|---|
| Kalimat pendek, kata sehari-hari | "Lakukan autentikasi kredensial Anda" | "Masuk ke akun Anda" |
| Kata kerja pada tombol | "Submit" | "Kirim Laporan" |
| Jelaskan solusi pada error | "Terjadi kesalahan" | "Foto terlalu besar. Pilih foto di bawah 5 MB." |
| Hormat tanpa kaku | "Anda wajib…" | "Mohon lengkapi nomor HP agar kami bisa menghubungi Anda" |
| Hindari istilah teknis | "Sinkronisasi gagal (timeout)" | "Belum ada sinyal. Data Anda aman dan akan terkirim nanti." |

- Bahasa utama **Bahasa Indonesia**. Sapaan: "Anda"; jangan terlalu santai pada layar darurat.
- Format: tanggal `6 Okt 2026`, waktu `09.00 WIB`, uang `Rp1.250.000`, angka desimal pakai koma.
- Istilah tetap: **Peternak Milenial** (nama produk), **Dinas Peternakan Provinsi Jawa Timur**, **Bimtek**, **Sentra Produksi**.
- Nada pada status darurat: tenang dan memberi kepastian ("Laporan Anda sudah kami terima. Petugas akan menindaklanjuti.").

---

## 12. Token Desain (referensi kode)

### CSS (web)
```css
:root {
  /* Warna */
  --color-primary-700: #1B5E20;
  --color-primary-600: #2E7D32;
  --color-primary-500: #43A047;
  --color-primary-100: #C8E6C9;
  --color-primary-50:  #E8F5E9;
  --color-accent-600:  #F9A825;
  --color-accent-100:  #FFF3CD;
  --color-earth-700:   #5D4037;
  --color-earth-100:   #EFEBE9;
  --color-danger-700:  #B71C1C;
  --color-danger-600:  #C62828;
  --color-danger-50:   #FDECEA;
  --color-warning-700: #E65100;
  --color-info-600:    #1565C0;
  --color-info-50:     #E3F2FD;
  --color-text:        #1F2933;
  --color-text-muted:  #52606D;
  --color-border:      #CBD2D9;
  --color-surface:     #FFFFFF;
  --color-bg:          #F5F7F5;

  /* Tipografi */
  --font-sans: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;

  /* Spasi */
  --space-1: 4px;  --space-2: 8px;  --space-3: 12px; --space-4: 16px;
  --space-6: 24px; --space-8: 32px; --space-12: 48px; --space-16: 64px;

  /* Bentuk */
  --radius-sm: 8px; --radius-md: 12px; --radius-lg: 16px; --radius-full: 999px;
  --shadow-1: 0 1px 2px rgba(0,0,0,.08);
  --shadow-2: 0 4px 12px rgba(0,0,0,.12);

  /* Interaksi */
  --tap-min: 48px;
  --focus-ring: 0 0 0 3px rgba(21,101,192,.5);
}
```

### React Native (`theme.ts`)
```ts
export const theme = {
  color: {
    primary: { 700: '#1B5E20', 600: '#2E7D32', 500: '#43A047', 100: '#C8E6C9', 50: '#E8F5E9' },
    accent: { 600: '#F9A825', 100: '#FFF3CD' },
    earth: { 700: '#5D4037', 100: '#EFEBE9' },
    danger: { 700: '#B71C1C', 600: '#C62828', 50: '#FDECEA' },
    warning: { 700: '#E65100' },
    info: { 600: '#1565C0', 50: '#E3F2FD' },
    text: '#1F2933', textMuted: '#52606D', border: '#CBD2D9',
    surface: '#FFFFFF', bg: '#F5F7F5',
  },
  space: [0, 4, 8, 12, 16, 24, 32, 48, 64],
  radius: { sm: 8, md: 12, lg: 16, full: 999 },
  tapMin: 48,
  font: {
    display: { fontSize: 28, lineHeight: 36, fontWeight: '700' },
    h1: { fontSize: 24, lineHeight: 32, fontWeight: '700' },
    h2: { fontSize: 20, lineHeight: 28, fontWeight: '600' },
    h3: { fontSize: 18, lineHeight: 26, fontWeight: '600' },
    bodyLg: { fontSize: 17, lineHeight: 26, fontWeight: '400' },
    body: { fontSize: 16, lineHeight: 24, fontWeight: '400' },
    label: { fontSize: 14, lineHeight: 20, fontWeight: '600' },
    caption: { fontSize: 13, lineHeight: 18, fontWeight: '400' },
  },
} as const;
```

---

## 13. Checklist Review Desain

- [ ] Satu tombol utama per layar; tombol merah hanya untuk darurat/destruktif
- [ ] Teks isi ≥ 16 px; kontras lulus AA
- [ ] Target sentuh ≥ 48 dp
- [ ] Status tidak hanya dibedakan warna
- [ ] State memuat, kosong, error, offline sudah dirancang
- [ ] Teks menggunakan Bahasa Indonesia sederhana; error memberi solusi
- [ ] Diuji di Android layar kecil/entry-level dan jaringan lambat
- [ ] Alur lapor darurat ≤ 3 langkah dan berfungsi offline
- [ ] Format tanggal, waktu, uang konsisten

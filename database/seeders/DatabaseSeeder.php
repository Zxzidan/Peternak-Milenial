<?php

namespace Database\Seeders;

use App\Models\CalendarEvent;
use App\Models\Certificate;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\DisasterGuide;
use App\Models\Disease;
use App\Models\EmergencyReport;
use App\Models\EmergencyReportLog;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\HealthRecord;
use App\Models\LearningMaterial;
use App\Models\Livestock;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PeternakProfile;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductionCenter;
use App\Models\Region;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with initial website data.
     */
    public function run(): void
    {
        // 1. Wilayah Administratif Jawa Timur (Sentra Utama)
        $regions = [
            'pasuruan' => Region::create(['name' => 'Kabupaten Pasuruan', 'code' => 'JTM-PAS', 'type' => 'kabupaten', 'latitude' => -7.6521, 'longitude' => 112.6983]),
            'malang' => Region::create(['name' => 'Kabupaten Malang', 'code' => 'JTM-MLG', 'type' => 'kabupaten', 'latitude' => -8.1664, 'longitude' => 112.6317]),
            'batu' => Region::create(['name' => 'Kota Batu', 'code' => 'JTM-BAT', 'type' => 'kota', 'latitude' => -7.8671, 'longitude' => 112.5239]),
            'blitar' => Region::create(['name' => 'Kabupaten Blitar', 'code' => 'JTM-BLT', 'type' => 'kabupaten', 'latitude' => -8.1333, 'longitude' => 112.2167]),
            'lumajang' => Region::create(['name' => 'Kabupaten Lumajang', 'code' => 'JTM-LMJ', 'type' => 'kabupaten', 'latitude' => -8.1331, 'longitude' => 113.2246]),
            'surabaya' => Region::create(['name' => 'Kota Surabaya', 'code' => 'JTM-SBY', 'type' => 'kota', 'latitude' => -7.2575, 'longitude' => 112.7521]),
            'tuban' => Region::create(['name' => 'Kabupaten Tuban', 'code' => 'JTM-TBN', 'type' => 'kabupaten', 'latitude' => -6.8972, 'longitude' => 112.0649]),
            'lamongan' => Region::create(['name' => 'Kabupaten Lamongan', 'code' => 'JTM-LMG', 'type' => 'kabupaten', 'latitude' => -7.1199, 'longitude' => 112.4158]),
            'kediri' => Region::create(['name' => 'Kabupaten Kediri', 'code' => 'JTM-KDR', 'type' => 'kabupaten', 'latitude' => -7.8480, 'longitude' => 112.0178]),
            'jombang' => Region::create(['name' => 'Kabupaten Jombang', 'code' => 'JTM-JMB', 'type' => 'kabupaten', 'latitude' => -7.5460, 'longitude' => 112.2331]),
            'bojonegoro' => Region::create(['name' => 'Kabupaten Bojonegoro', 'code' => 'JTM-BJN', 'type' => 'kabupaten', 'latitude' => -7.1502, 'longitude' => 111.8818]),
        ];

        // 2. Akun Pengguna & Profil
        $admin = User::create([
            'name' => 'Dr. Ir. Indyah Aryani, MM',
            'email' => 'admin@disnak.jatimprov.go.id',
            'phone_number' => '08113339900',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $drhRatna = User::create([
            'name' => 'drh. Ratna Kusuma',
            'email' => 'ratna.kusuma@disnak.jatimprov.go.id',
            'phone_number' => '08001347625',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $drhBambang = User::create([
            'name' => 'drh. Bambang Trihatmojo',
            'email' => 'bambang@disnak.jatimprov.go.id',
            'phone_number' => '081234567800',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $peternakSlamet = User::create([
            'name' => 'Slamet Rahardjo',
            'email' => 'slamet@peternak.id',
            'phone_number' => '081234567890',
            'role' => 'peternak',
            'is_active' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        PeternakProfile::create([
            'user_id' => $peternakSlamet->id,
            'region_id' => $regions['pasuruan']->id,
            'farm_name' => 'Kelompok Peternak Sapi Perah Pasuruan',
            'nik' => '3514081203760001',
            'nib' => '1203760001928374',
            'address' => 'Desa Durensewu, Pandaan, Kab. Pasuruan',
            'latitude' => -7.6521,
            'longitude' => 112.6983,
            'verification_status' => 'verified',
            'verified_at' => now()->subMonths(6),
            'verified_by' => $admin->id,
        ]);

        $pembeliBudi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'phone_number' => '085712345678',
            'role' => 'umum',
            'is_active' => true,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 3. Modul Pelatihan & Bimtek
        $t1 = Training::create([
            'title' => 'Formulasi Pakan Ransum & Silase',
            'slug' => 'formulasi-pakan-ransum-silase',
            'description' => 'Efisiensi biaya pakan mandiri dengan limbah pertanian lokal dan probiotik.',
            'instructor' => 'Dr. Ir. Hendro Wibowo',
            'start_date' => '2026-10-12',
            'end_date' => '2026-10-14',
            'time_info' => '08:00 - 15:00 WIB',
            'location' => 'BBPP Songgoriti, Batu',
            'is_online' => false,
            'quota' => 25,
            'remaining_quota' => 14,
            'cost_type' => 'gratis_apbd',
            'status' => 'open',
        ]);

        $t2 = Training::create([
            'title' => 'Biosekuriti & Pencegahan Penyakit',
            'slug' => 'biosekuriti-pencegahan-penyakit',
            'description' => 'SOP sterilisasi kandang, deteksi dini PMK/LSD, dan manajemen sanitasi.',
            'instructor' => 'drh. Nur Cahyo, M.Vet',
            'start_date' => '2026-10-19',
            'end_date' => '2026-10-20',
            'time_info' => '08:30 - 14:00 WIB',
            'location' => 'Puskeswan Pandaan',
            'is_online' => false,
            'quota' => 30,
            'remaining_quota' => 22,
            'cost_type' => 'gratis_apbd',
            'status' => 'open',
        ]);

        $t3 = Training::create([
            'title' => 'Pemasaran Digital & KUR Peternakan',
            'slug' => 'pemasaran-digital-kur-peternakan',
            'description' => 'Branding produk olahan, akses permodalan KUR, dan integrasi pasar digital.',
            'instructor' => 'OJK Jatim & Praktisi',
            'start_date' => '2026-10-28',
            'end_date' => '2026-10-28',
            'time_info' => '13:00 - 16:30 WIB',
            'location' => 'Zoom Webinar Disnak',
            'is_online' => true,
            'quota' => 250,
            'remaining_quota' => 85,
            'cost_type' => 'daring',
            'status' => 'open',
        ]);

        TrainingRegistration::create([
            'training_id' => $t1->id,
            'user_id' => $peternakSlamet->id,
            'registration_code' => 'REG-SILASE-0024',
            'status' => 'confirmed',
            'registered_at' => now()->subDays(2),
        ]);

        LearningMaterial::create([
            'title' => 'SOP Budidaya Sapi Perah Berkelanjutan',
            'slug' => 'sop-budidaya-sapi-perah-berkelanjutan',
            'category' => 'modul_pdf',
            'file_path' => 'materials/sop-sapi-perah-ub.pdf',
            'file_size' => '4.8 MB',
            'author_institution' => 'Fakultas Peternakan UB',
            'downloads_count' => 342,
        ]);

        LearningMaterial::create([
            'title' => 'Teknologi Silase & Hay Ternak',
            'slug' => 'teknologi-silase-hay-ternak',
            'category' => 'modul_pdf',
            'file_path' => 'materials/silase-bbpp-batu.pdf',
            'file_size' => '3.1 MB',
            'author_institution' => 'BBPP Batu',
            'downloads_count' => 518,
        ]);

        LearningMaterial::create([
            'title' => 'Video Pemerahan Higienis Menekan TPC',
            'slug' => 'video-pemerahan-higienis-menekan-tpc',
            'category' => 'video_praktik',
            'file_path' => 'materials/video-pemerahan-higienis.mp4',
            'duration' => '18 Menit',
            'author_institution' => 'Dinas Peternakan Jatim',
            'downloads_count' => 890,
        ]);

        Certificate::create([
            'user_id' => $peternakSlamet->id,
            'training_id' => $t1->id,
            'certificate_number' => 'DISNAK-JATIM/2026/CERT-891',
            'recipient_name' => 'Slamet Rahardjo',
            'recipient_code' => 'JTM-PAS-0024',
            'title' => 'Sertifikasi Peternak Sapi Perah Higienis',
            'issued_date' => '2026-08-15',
            'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
        ]);

        // 4. Modul Marketplace & Produk
        $catSusu = ProductCategory::create(['name' => 'Susu Olahan', 'slug' => 'susu-olahan']);
        $catDaging = ProductCategory::create(['name' => 'Daging Segar', 'slug' => 'daging-segar']);
        $catPakan = ProductCategory::create(['name' => 'Pakan & Silase', 'slug' => 'pakan-silase']);
        $catBibit = ProductCategory::create(['name' => 'Bibit Ternak', 'slug' => 'bibit-ternak']);

        $p1 = Product::create([
            'user_id' => $peternakSlamet->id,
            'product_category_id' => $catSusu->id,
            'region_id' => $regions['pasuruan']->id,
            'name' => 'Susu Segar Pasteurisasi KUD Pandaan (1 L)',
            'slug' => 'susu-segar-pasteurisasi-kud-pandaan-1l',
            'description' => 'Sapi perah FH terakreditasi, kadar lemak 3.8%, botol higienis segel dingin.',
            'price' => 18000,
            'stock' => 150,
            'unit' => 'Liter',
            'is_verified' => true,
            'status' => 'active',
        ]);

        $p2 = Product::create([
            'user_id' => $peternakSlamet->id,
            'product_category_id' => $catDaging->id,
            'region_id' => $regions['malang']->id,
            'name' => 'Daging Sapi Wagyu Lokal Malang (1 Kg)',
            'slug' => 'daging-sapi-wagyu-lokal-malang-1kg',
            'description' => 'Dipotong di RPH bersertifikat Halal dan NKV, marbling score 4.',
            'price' => 145000,
            'stock' => 40,
            'unit' => 'Kilogram',
            'is_verified' => true,
            'status' => 'active',
        ]);

        $p3 = Product::create([
            'user_id' => $peternakSlamet->id,
            'product_category_id' => $catPakan->id,
            'region_id' => $regions['batu']->id,
            'name' => 'Silase Pakan Komplit Fermentasi (50 Kg)',
            'slug' => 'silase-pakan-komplit-fermentasi-50kg',
            'description' => 'Jagung tebon fermentasi siap saji dengan probiotik BBPP Batu.',
            'price' => 85000,
            'stock' => 80,
            'unit' => 'Sak',
            'is_verified' => true,
            'status' => 'active',
        ]);

        $order1 = Order::create([
            'order_code' => 'ORD-202610-001',
            'buyer_id' => $pembeliBudi->id,
            'total_amount' => 54000,
            'status' => 'completed',
            'shipping_address' => 'Jl. Pemuda No. 45, Kota Surabaya',
            'buyer_phone' => '085712345678',
            'notes' => 'Metode: Transfer Bank BCA • Catatan: Tolong packing sterofoam dingin.',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p1->id,
            'seller_id' => $peternakSlamet->id,
            'quantity' => 3,
            'price_per_unit' => 18000,
            'subtotal' => 54000,
        ]);

        $order2 = Order::create([
            'order_code' => 'ORD-202610-002',
            'buyer_id' => $pembeliBudi->id,
            'total_amount' => 290000,
            'status' => 'processing',
            'shipping_address' => 'Jl. Dharmawangsa No. 12, Gubeng, Kota Surabaya',
            'buyer_phone' => '085712345678',
            'notes' => 'Metode: QRIS Instan • Catatan: Pastikan segel daging beku tetap rapat.',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p2->id,
            'seller_id' => $peternakSlamet->id,
            'quantity' => 2,
            'price_per_unit' => 145000,
            'subtotal' => 290000,
        ]);

        // Multi-item order: Susu Segar + Silase Pakan Komplit
        $order3 = Order::create([
            'order_code' => 'ORD-202610-003',
            'buyer_id' => $pembeliBudi->id,
            'total_amount' => 157000,
            'status' => 'shipped',
            'shipping_address' => 'Jl. Basuki Rahmat No. 88, Tegalsari, Kota Surabaya',
            'buyer_phone' => '085712345678',
            'notes' => 'Metode: Transfer Bank Mandiri • Catatan: Tolong kirim pagi sebelum jam 10.',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $p1->id,
            'seller_id' => $peternakSlamet->id,
            'quantity' => 4,
            'price_per_unit' => 18000,
            'subtotal' => 72000,
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $p3->id,
            'seller_id' => $peternakSlamet->id,
            'quantity' => 1,
            'price_per_unit' => 85000,
            'subtotal' => 85000,
        ]);

        // 5. Modul Harga Komoditas & Sentra Produksi
        $commSusu = Commodity::create(['name' => 'Susu Sapi Segar', 'slug' => 'susu-sapi-segar', 'unit' => 'Liter']);
        $commDaging = Commodity::create(['name' => 'Daging Sapi Murni', 'slug' => 'daging-sapi-murni', 'unit' => 'Kilogram']);
        $commAyam = Commodity::create(['name' => 'Daging Ayam Ras', 'slug' => 'daging-ayam-ras', 'unit' => 'Kilogram']);
        $commTelur = Commodity::create(['name' => 'Telur Ayam Ras', 'slug' => 'telur-ayam-ras', 'unit' => 'Kilogram']);
        $commJagung = Commodity::create(['name' => 'Jagung Pakan Pipil', 'slug' => 'jagung-pakan-pipil', 'unit' => 'Kilogram']);

        CommodityPrice::create([
            'commodity_id' => $commSusu->id,
            'region_id' => $regions['pasuruan']->id,
            'recorded_date' => now()->toDateString(),
            'farmer_price' => 7450,
            'consumer_price' => 9500,
            'price_change_7d' => 250,
            'price_change_percentage' => 3.4,
            'status' => 'stabil',
            'source' => 'KUD Pasuruan & Pasar Induk',
            'recorded_by' => $admin->id,
        ]);

        CommodityPrice::create([
            'commodity_id' => $commDaging->id,
            'region_id' => $regions['tuban']->id,
            'recorded_date' => now()->toDateString(),
            'farmer_price' => 128500,
            'consumer_price' => 135000,
            'price_change_7d' => 0,
            'price_change_percentage' => 0.0,
            'status' => 'stabil',
            'source' => 'Pasar Hewan Tuban',
            'recorded_by' => $admin->id,
        ]);

        CommodityPrice::create([
            'commodity_id' => $commAyam->id,
            'region_id' => $regions['blitar']->id,
            'recorded_date' => now()->toDateString(),
            'farmer_price' => 23200,
            'consumer_price' => 34000,
            'price_change_7d' => -600,
            'price_change_percentage' => -2.5,
            'status' => 'fluktuatif',
            'source' => 'PINSAR Blitar',
            'recorded_by' => $admin->id,
        ]);

        CommodityPrice::create([
            'commodity_id' => $commTelur->id,
            'region_id' => $regions['blitar']->id,
            'recorded_date' => now()->toDateString(),
            'farmer_price' => 24800,
            'consumer_price' => 26800,
            'price_change_7d' => 400,
            'price_change_percentage' => 1.6,
            'status' => 'stabil',
            'source' => 'Koperasi Peternak Unggas Blitar',
            'recorded_by' => $admin->id,
        ]);

        CommodityPrice::create([
            'commodity_id' => $commJagung->id,
            'region_id' => $regions['bojonegoro']->id,
            'recorded_date' => now()->toDateString(),
            'farmer_price' => 4900,
            'consumer_price' => 5200,
            'price_change_7d' => 0,
            'price_change_percentage' => 0.0,
            'status' => 'stabil',
            'source' => 'Pasar Agrobis Bojonegoro',
            'recorded_by' => $admin->id,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['pasuruan']->id,
            'commodity_id' => $commSusu->id,
            'name' => 'Sentra Sapi Perah Pasuruan',
            'description' => 'Kawasan sentra populasi sapi perah terbesar Jawa Timur di Grati dan Nongkojajar.',
            'livestock_population' => 92400,
            'latitude' => -7.7836,
            'longitude' => 112.8582,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['malang']->id,
            'commodity_id' => $commSusu->id,
            'name' => 'Sentra Sapi Perah Malang',
            'description' => 'Sentra agribisnis persusuan terpadu dataran tinggi Malang di Pujon dan Ngantang.',
            'livestock_population' => 88600,
            'latitude' => -7.8466,
            'longitude' => 112.4697,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['blitar']->id,
            'commodity_id' => $commTelur->id,
            'name' => 'Sentra Unggas & Telur Blitar',
            'description' => 'Pemasok 70% kebutuhan telur Jawa Timur dan penyangga 30% ketahanan pangan telur nasional.',
            'livestock_population' => 16500000,
            'latitude' => -8.0954,
            'longitude' => 112.1609,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['tuban']->id,
            'commodity_id' => $commDaging->id,
            'name' => 'Sentra Sapi Potong Tuban',
            'description' => 'Sentra populasi sapi potong nomor satu Jawa Timur dan wilayah sumber bibit sapi PO.',
            'livestock_population' => 345000,
            'latitude' => -6.8972,
            'longitude' => 112.0649,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['bojonegoro']->id,
            'commodity_id' => $commDaging->id,
            'name' => 'Sentra Sapi Potong Bojonegoro',
            'description' => 'Kawasan korporasi peternakan sapi potong wilayah barat Jatim terintegrasi pertanian jagung.',
            'livestock_population' => 248000,
            'latitude' => -7.1502,
            'longitude' => 111.8817,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['lumajang']->id,
            'commodity_id' => $commDaging->id,
            'name' => 'Sentra Kambing Senduro Lumajang',
            'description' => 'Balai pelestarian bibit rumpun asli kambing Senduro unggulan lereng Semeru.',
            'livestock_population' => 48200,
            'latitude' => -8.1138,
            'longitude' => 113.0645,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['kediri']->id,
            'commodity_id' => $commAyam->id,
            'name' => 'Sentra Ayam Ras & Unggas Kediri',
            'description' => 'Sentra agribisnis unggas pedaging dan petelur modern terpadu korporasi peternak.',
            'livestock_population' => 14800000,
            'latitude' => -7.8228,
            'longitude' => 112.0119,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['jombang']->id,
            'commodity_id' => $commAyam->id,
            'name' => 'Sentra Ayam Broiler Jombang',
            'description' => 'Sentra adopsi kandang closed-house modern pemasok daging ayam higienis.',
            'livestock_population' => 12300000,
            'latitude' => -7.5460,
            'longitude' => 112.2331,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['lamongan']->id,
            'commodity_id' => $commDaging->id,
            'name' => 'Sentra Sapi Potong & Pakan Lamongan',
            'description' => 'Sentra peternakan sapi rakyat berbasis pengolahan limbah jerami fermentasi & feedlot.',
            'livestock_population' => 118000,
            'latitude' => -7.1206,
            'longitude' => 112.4158,
            'is_featured' => true,
        ]);

        ProductionCenter::create([
            'region_id' => $regions['batu']->id,
            'commodity_id' => $commSusu->id,
            'name' => 'Sentra Agrowisata Sapi Perah Batu',
            'description' => 'Sentra edukasi agrowisata persusuan dan hilirisasi olahan susu pasteurisasi & keju.',
            'livestock_population' => 14200,
            'latitude' => -7.8671,
            'longitude' => 112.5239,
            'is_featured' => true,
        ]);

        // 6. Modul Pelaporan Darurat & Kesejahteraan Hewan
        $emReport = EmergencyReport::create([
            'report_code' => 'EM-2026-081',
            'user_id' => $peternakSlamet->id,
            'region_id' => $regions['pasuruan']->id,
            'incident_type' => 'wabah',
            'livestock_type' => 'sapi_perah',
            'affected_count' => 4,
            'location_address' => 'Pandaan, Pasuruan (-7.6521, 112.6983)',
            'latitude' => -7.6521,
            'longitude' => 112.6983,
            'description' => 'Sapi perah lesu sejak kemarin sore, demam tinggi 39.8C, air liur berbusa.',
            'status' => 'in_progress',
            'officer_notes' => 'Membawa antipiretik dan desinfektan. Peternak telah mengisolasi 4 ekor ternak terdampak di kandang belakang.',
            'assigned_officer_id' => $drhRatna->id,
            'officer_phone' => '08001347625',
            'verified_at' => now()->subHours(2),
        ]);

        EmergencyReportLog::create([
            'emergency_report_id' => $emReport->id,
            'status' => 'received',
            'officer_id' => null,
            'note' => 'Laporan masuk dari peternak via sistem',
            'logged_at' => now()->subHours(3),
        ]);

        EmergencyReportLog::create([
            'emergency_report_id' => $emReport->id,
            'status' => 'verified',
            'officer_id' => $admin->id,
            'note' => 'Diverifikasi oleh admin Kesmavet',
            'logged_at' => now()->subHours(2)->addMinutes(8),
        ]);

        EmergencyReportLog::create([
            'emergency_report_id' => $emReport->id,
            'status' => 'in_progress',
            'officer_id' => $drhRatna->id,
            'note' => 'drh. Ratna OTW ke kandang peternak',
            'logged_at' => now()->subHours(1),
        ]);

        DisasterGuide::create([
            'title' => 'Erupsi Gunung Berapi',
            'slug' => 'erupsi-gunung-berapi',
            'disaster_type' => 'erupsi',
            'summary' => 'Lindungi pakan hijauan dari abu silika. Gunakan pakan silase kedap udara dan bilas ternak dengan air bersih.',
            'content' => 'Langkah evakuasi darurat ternak saat terjadi hujan abu vulkanik di kawasan Bromo, Semeru, dan Kelud...',
            'partner_agency' => 'BPBD Jawa Timur',
        ]);

        DisasterGuide::create([
            'title' => 'Banjir & Longsor',
            'slug' => 'banjir-longsor',
            'disaster_type' => 'banjir_longsor',
            'summary' => 'Lepaskan ikatan tali kandang dan arahkan kelompok ternak ke rute posko dataran tinggi yang telah ditentukan.',
            'content' => 'Protokol penanganan ternak korban luapan sungai dan genangan air kandang...',
            'partner_agency' => 'BPBD Jawa Timur',
        ]);

        DisasterGuide::create([
            'title' => 'Biosekuriti Kandang',
            'slug' => 'biosekuriti-kandang',
            'disaster_type' => 'biosekuriti',
            'summary' => 'Sediakan bak celup kaki berdesinfektan di pintu kandang dan batasi akses pedagang luar saat siaga wabah.',
            'content' => 'SOP desinfeksi kendaraan pengangkut ternak, sanitasi pekerja, dan isolasi ternak baru...',
            'partner_agency' => 'Dinas Peternakan Provinsi Jawa Timur',
        ]);

        // 7. Modul Ternak & Rekam Medis
        $sapi1 = Livestock::create([
            'user_id' => $peternakSlamet->id,
            'e_tag_number' => 'JTM-PAS-0024',
            'name' => 'Melati',
            'type' => 'sapi_perah_fh',
            'gender' => 'betina',
            'birth_date' => '2023-03-10',
            'reproductive_status' => 'Bunting 4 Bln',
            'health_status' => 'sehat',
        ]);

        $sapi2 = Livestock::create([
            'user_id' => $peternakSlamet->id,
            'e_tag_number' => 'JTM-PAS-0014',
            'name' => 'Bunga',
            'type' => 'sapi_perah_fh',
            'gender' => 'betina',
            'birth_date' => '2022-11-20',
            'reproductive_status' => 'Laktasi (17 L/hr)',
            'health_status' => 'perawatan',
        ]);

        $sapi3 = Livestock::create([
            'user_id' => $peternakSlamet->id,
            'e_tag_number' => 'JTM-PAS-0031',
            'name' => 'Si Manis',
            'type' => 'sapi_perah_fh',
            'gender' => 'betina',
            'birth_date' => '2026-07-02',
            'reproductive_status' => 'Sapih (3 Bln)',
            'health_status' => 'sehat',
        ]);

        HealthRecord::create([
            'livestock_id' => $sapi1->id,
            'veterinarian_id' => $drhBambang->id,
            'record_type' => 'vaksinasi',
            'title' => 'PMK Booster 2',
            'diagnosis' => 'Vaksinasi berkala pencegahan PMK',
            'treatment' => 'Aftovaxpur 2ml IM',
            'notes' => 'Ternak sehat tidak ada reaksi anafilaksis.',
            'record_date' => now()->subMonths(1)->toDateString(),
        ]);

        HealthRecord::create([
            'livestock_id' => $sapi2->id,
            'veterinarian_id' => $drhRatna->id,
            'record_type' => 'pengobatan',
            'title' => 'Pemeriksaan Lesu & Demam',
            'diagnosis' => 'Kelelahan laktasi dan radang ringan',
            'treatment' => 'Antipiretik + Vitamin B kompleks',
            'notes' => 'Jadwal ulang vaksinasi ditunda sampai sembuh.',
            'record_date' => now()->toDateString(),
        ]);

        // 8. Modul Konsultasi Medis & Penyakit
        $consult = Consultation::create([
            'user_id' => $peternakSlamet->id,
            'veterinarian_id' => $drhRatna->id,
            'subject' => 'Sapi perah no. 14 lesu dan demam 39.8C',
            'status' => 'answered',
        ]);

        ConsultationMessage::create([
            'consultation_id' => $consult->id,
            'sender_id' => $peternakSlamet->id,
            'message' => 'Selamat pagi Dokter Ratna. Sapi perah no. 14 terlihat lesu sejak kemarin sore, suhu 39.8°C dan nafsu makan berkurang. Mohon arahannya.',
        ]);

        ConsultationMessage::create([
            'consultation_id' => $consult->id,
            'sender_id' => $drhRatna->id,
            'message' => 'Selamat pagi Pak Slamet. Pisahkan sapi ke kandang karantina, beri air hangat + molase. Petugas lapangan sedang menuju lokasi membawa antipiretik.',
        ]);

        Disease::create([
            'name' => 'Penyakit Mulut & Kuku (PMK)',
            'slug' => 'penyakit-mulut-dan-kuku',
            'category' => 'Penyakit Menular',
            'symptoms' => 'Lepuh pada lidah, bibir, dan sela kuku. Ternak pincang dan air liur berbusa menggantung.',
            'prevention_steps' => 'Vaksinasi berkala, biosekuriti kandang, dan disinfeksi kendaraan.',
            'treatment_first_aid' => 'Semprot luka dengan antiseptik gentian violet, isolasi di kandang kering.',
        ]);

        Disease::create([
            'name' => 'Lumpy Skin Disease (LSD)',
            'slug' => 'lumpy-skin-disease',
            'category' => 'Vektor Serangga',
            'symptoms' => 'Nodul benjolan keras pada kulit leher dan punggung disertai demam tinggi ternak.',
            'prevention_steps' => 'Pengendalian lalat/nyamuk kandang, vaksinasi homolog LSD.',
            'treatment_first_aid' => 'Pemberian antibiotik pencegah infeksi sekunder dan oles salep antiseptik.',
        ]);

        Disease::create([
            'name' => 'Mastitis (Radang Ambing)',
            'slug' => 'mastitis-radang-ambing',
            'category' => 'Bakteri Ambing',
            'symptoms' => 'Ambing bengkak, merah, dan panas. Susu pecah atau menggumpal saat diperah.',
            'prevention_steps' => 'Dipping puting antiseptik pasca perah, kebersihan mesin perah.',
            'treatment_first_aid' => 'Infusi intramamari antibiotik dan kompres hangat.',
        ]);

        // 9. Modul Pameran & Kalender Terpadu
        $expo = Exhibition::create([
            'title' => 'Jatim Dairy & Livestock Expo 2026',
            'slug' => 'jatim-dairy-livestock-expo-2026',
            'description' => 'Pameran teknologi budidaya, lelang bibit unggul, dan temu jaringan pasar peternak Jawa Timur.',
            'start_date' => '2026-10-24',
            'end_date' => '2026-10-26',
            'location' => 'Grand City Convex, Surabaya',
            'stand_capacity' => 120,
            'registered_stands_count' => 84,
            'is_featured' => true,
        ]);

        ExhibitionRegistration::create([
            'exhibition_id' => $expo->id,
            'user_id' => $peternakSlamet->id,
            'business_name' => 'Peternak Sapi Perah Pasuruan',
            'exhibited_products' => 'Susu Pasteurisasi & Keju',
            'status' => 'approved',
            'stand_number' => 'B-14',
            'notes' => 'Stand binaan Disnak Prov. Jatim',
        ]);

        CalendarEvent::create([
            'title' => 'Vaksinasi Massal PMK & LSD',
            'event_type' => 'vaksinasi',
            'event_date' => '2026-10-12',
            'time_info' => '08:00 WIB',
            'location' => 'Pandaan, Pasuruan',
            'region_id' => $regions['pasuruan']->id,
            'is_mandatory' => true,
            'description' => 'Pelayanan lapangan petugas Puskeswan ke kelompok ternak.',
        ]);

        CalendarEvent::create([
            'title' => 'Praktik Silase & Fermentasi',
            'event_type' => 'pelatihan',
            'event_date' => '2026-10-15',
            'time_info' => '09:00 WIB',
            'location' => 'Batu',
            'region_id' => $regions['batu']->id,
            'is_mandatory' => false,
            'description' => 'Bimbingan teknis pengolahan pakan hijauan mandiri.',
        ]);

        CalendarEvent::create([
            'title' => 'Jatim Dairy & Livestock Expo 2026',
            'event_type' => 'pameran',
            'event_date' => '2026-10-24',
            'time_info' => '10:00 - 20:00 WIB',
            'location' => 'Grand City Surabaya',
            'region_id' => $regions['surabaya']->id,
            'is_mandatory' => false,
            'description' => 'Pameran peternakan terbesar Jawa Timur bersama 120 stand binaan.',
        ]);
    }
}

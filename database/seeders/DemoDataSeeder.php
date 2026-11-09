<?php

namespace Database\Seeders;

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportStatusHistory;
use App\Models\CalendarEvent;
use App\Models\Certificate;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\ConsultationSchedule;
use App\Models\EmergencyReport;
use App\Models\EmergencyReportLog;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\HealthRecord;
use App\Models\LearningMaterial;
use App\Models\LearningQuiz;
use App\Models\Livestock;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PeternakProfile;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductionCenter;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\Region;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Models\UserLearningProgress;
use App\Models\Veterinarian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run comprehensive database seeds for realistic East Java millennial livestock farming demo.
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. WILAYAH ADMINISTRATIF JAWA TIMUR
        // -------------------------------------------------------------
        $regions = [
            'pasuruan' => Region::firstOrCreate(['code' => 'JTM-PAS'], ['name' => 'Kabupaten Pasuruan', 'type' => 'kabupaten', 'latitude' => -7.6521, 'longitude' => 112.6983]),
            'malang' => Region::firstOrCreate(['code' => 'JTM-MLG'], ['name' => 'Kabupaten Malang', 'type' => 'kabupaten', 'latitude' => -8.1664, 'longitude' => 112.6317]),
            'batu' => Region::firstOrCreate(['code' => 'JTM-BAT'], ['name' => 'Kota Batu', 'type' => 'kota', 'latitude' => -7.8671, 'longitude' => 112.5239]),
            'blitar' => Region::firstOrCreate(['code' => 'JTM-BLT'], ['name' => 'Kabupaten Blitar', 'type' => 'kabupaten', 'latitude' => -8.1333, 'longitude' => 112.2167]),
            'lumajang' => Region::firstOrCreate(['code' => 'JTM-LMJ'], ['name' => 'Kabupaten Lumajang', 'type' => 'kabupaten', 'latitude' => -8.1331, 'longitude' => 113.2246]),
            'surabaya' => Region::firstOrCreate(['code' => 'JTM-SBY'], ['name' => 'Kota Surabaya', 'type' => 'kota', 'latitude' => -7.2575, 'longitude' => 112.7521]),
            'tuban' => Region::firstOrCreate(['code' => 'JTM-TBN'], ['name' => 'Kabupaten Tuban', 'type' => 'kabupaten', 'latitude' => -6.8972, 'longitude' => 112.0649]),
            'lamongan' => Region::firstOrCreate(['code' => 'JTM-LMG'], ['name' => 'Kabupaten Lamongan', 'type' => 'kabupaten', 'latitude' => -7.1199, 'longitude' => 112.4158]),
            'kediri' => Region::firstOrCreate(['code' => 'JTM-KDR'], ['name' => 'Kabupaten Kediri', 'type' => 'kabupaten', 'latitude' => -7.8480, 'longitude' => 112.0178]),
            'jombang' => Region::firstOrCreate(['code' => 'JTM-JMB'], ['name' => 'Kabupaten Jombang', 'type' => 'kabupaten', 'latitude' => -7.5460, 'longitude' => 112.2331]),
            'bojonegoro' => Region::firstOrCreate(['code' => 'JTM-BJN'], ['name' => 'Kabupaten Bojonegoro', 'type' => 'kabupaten', 'latitude' => -7.1502, 'longitude' => 111.8818]),
            'nganjuk' => Region::firstOrCreate(['code' => 'JTM-NGJ'], ['name' => 'Kabupaten Nganjuk', 'type' => 'kabupaten', 'latitude' => -7.6041, 'longitude' => 111.9015]),
            'sidoarjo' => Region::firstOrCreate(['code' => 'JTM-SDA'], ['name' => 'Kabupaten Sidoarjo', 'type' => 'kabupaten', 'latitude' => -7.4726, 'longitude' => 112.6675]),
        ];

        // -------------------------------------------------------------
        // 2. AKUN PENGGUNA (SEMUA ROLE)
        // -------------------------------------------------------------

        // ADMIN DISNAK PROV. JAWA TIMUR
        $admin = User::updateOrCreate(
            ['email' => 'admin@disnak.jatimprov.go.id'],
            [
                'name' => 'Dr. Ir. Indyah Aryani, MM',
                'phone_number' => '08113339900',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // DOKTER HEWAN DINAS (6 DOKTER WILAYAH JATIM)
        $drhRatna = User::updateOrCreate(
            ['email' => 'ratnak@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Ratna Kusuma',
                'phone_number' => '08001347625',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $drhBambang = User::updateOrCreate(
            ['email' => 'bambang@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Bambang Trihatmojo',
                'phone_number' => '081234567800',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $drhNurCahyo = User::updateOrCreate(
            ['email' => 'nurcahyo@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Nur Cahyo, M.Vet',
                'phone_number' => '081399887766',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $drhSiti = User::updateOrCreate(
            ['email' => 'siti@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Siti Aminah, M.Si',
                'phone_number' => '081255443322',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $drhAhmad = User::updateOrCreate(
            ['email' => 'ahmad@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Ahmad Fauzi',
                'phone_number' => '081322334455',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $drhDewi = User::updateOrCreate(
            ['email' => 'dewi@disnak.jatimprov.go.id'],
            [
                'name' => 'drh. Dewi Sartika',
                'phone_number' => '081377889900',
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // PROFIL VETERINARIAN
        $vetsData = [
            [
                'user_id' => $drhRatna->id,
                'name' => 'drh. Ratna Kusuma',
                'specialization' => 'Spesialis Sapi Perah & Reproduksi',
                'puskeswan' => 'Puskeswan Disnak Prov. Jatim - Surabaya',
                'wilayah_penugasan' => 'Kabupaten Pasuruan, Kota Surabaya',
                'strv_number' => 'STRV-35.78.2023.001',
                'phone_number' => '08001347625',
                'email' => 'ratnak@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhBambang->id,
                'name' => 'drh. Bambang Trihatmojo',
                'specialization' => 'Spesialis Ruminansia Besar & Bedah',
                'puskeswan' => 'Puskeswan Purwosari, Kab. Pasuruan',
                'wilayah_penugasan' => 'Kabupaten Pasuruan, Kota Malang',
                'strv_number' => 'STRV-35.14.2022.042',
                'phone_number' => '081234567800',
                'email' => 'bambang@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.30 - 15.30 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhNurCahyo->id,
                'name' => 'drh. Nur Cahyo, M.Vet',
                'specialization' => 'Spesialis Unggas, Domba & Biosekuriti',
                'puskeswan' => 'Puskeswan Pare, Kab. Kediri',
                'wilayah_penugasan' => 'Kabupaten Kediri, Kabupaten Nganjuk, Kabupaten Jombang',
                'strv_number' => 'STRV-35.06.2024.118',
                'phone_number' => '081399887766',
                'email' => 'nurcahyo@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhSiti->id,
                'name' => 'drh. Siti Aminah, M.Si',
                'specialization' => 'Spesialis Sapi Potong & Nutrisi Ternak',
                'puskeswan' => 'Puskeswan Dander, Kab. Bojonegoro',
                'wilayah_penugasan' => 'Kabupaten Bojonegoro, Kabupaten Tuban',
                'strv_number' => 'STRV-35.22.2023.077',
                'phone_number' => '081255443322',
                'email' => 'siti@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 15.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhAhmad->id,
                'name' => 'drh. Ahmad Fauzi',
                'specialization' => 'Spesialis Penyakit Menular & Vaksinasi',
                'puskeswan' => 'Puskeswan Pandaan, Kab. Pasuruan',
                'wilayah_penugasan' => 'Kabupaten Pasuruan, Kabupaten Sidoarjo',
                'strv_number' => 'STRV-35.14.2024.088',
                'phone_number' => '081322334455',
                'email' => 'ahmad@disnak.jatimprov.go.id',
                'status' => 'siaga',
                'consultation_hours' => '08.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhDewi->id,
                'name' => 'drh. Dewi Sartika',
                'specialization' => 'Spesialis Inseminasi Buatan & Kebuntingan',
                'puskeswan' => 'Puskeswan Sukorejo, Kab. Pasuruan',
                'wilayah_penugasan' => 'Kabupaten Pasuruan, Kota Batu',
                'strv_number' => 'STRV-35.14.2025.105',
                'phone_number' => '081377889900',
                'email' => 'dewi@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 15.30 WIB',
                'is_active' => true,
            ],
        ];

        $vets = [];
        foreach ($vetsData as $vData) {
            $vets[$vData['email']] = Veterinarian::updateOrCreate(
                ['user_id' => $vData['user_id']],
                $vData
            );
        }

        // PETERNAK MILENIAL (Randy Zidan, Slamet Rahardjo, Ahmad Fauzan, Dian Pratiwi)
        $userRandy = User::where('email', 'dandiazaidanekerja35@gmail.com')->first();
        if (! $userRandy) {
            $userRandy = User::create([
                'name' => 'Randy Zidan',
                'email' => 'dandiazaidanekerja35@gmail.com',
                'phone_number' => '082131466947',
                'nik' => '3578052209800026',
                'birth_date' => '2005-06-22',
                'kabupaten' => 'Kabupaten Nganjuk',
                'kecamatan' => 'Berbek',
                'desa' => 'Tiripan',
                'alamat' => 'Dusun Tiripan RT 03/RW 02, Desa Tiripan, Berbek, Nganjuk',
                'livestock_type' => 'Bebek / Itik',
                'livestock_count' => 150,
                'role' => 'peternak',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        } else {
            $userRandy->update([
                'role' => 'peternak',
                'is_active' => true,
                'email_verified_at' => now(),
                'livestock_type' => 'Bebek / Itik',
                'livestock_count' => 150,
                'kabupaten' => 'Kabupaten Nganjuk',
                'kecamatan' => 'Berbek',
                'desa' => 'Tiripan',
                'alamat' => 'Dusun Tiripan RT 03/RW 02, Desa Tiripan, Berbek, Nganjuk',
            ]);
        }

        // Profil Peternak Randy Zidan
        PeternakProfile::updateOrCreate(
            ['user_id' => $userRandy->id],
            [
                'region_id' => $regions['nganjuk']->id,
                'farm_name' => 'Peternakan Bebek & Unggas Milenial Berkah Tiripan',
                'nik' => '3578052209800026',
                'nib' => '1980002609871234',
                'address' => 'Dusun Tiripan RT 03/RW 02, Desa Tiripan, Kec. Berbek, Kab. Nganjuk',
                'latitude' => -7.6432,
                'longitude' => 111.9056,
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(3),
                'verified_by' => $admin->id,
            ]
        );

        $userSlamet = User::where('email', 'slamet@peternak.com')->first();
        if (! $userSlamet) {
            $userSlamet = User::where('email', 'slamet@peternak.id')->first();
        }
        if (! $userSlamet) {
            $userSlamet = User::create([
                'name' => 'Slamet Rahardjo',
                'email' => 'slamet@peternak.com',
                'phone_number' => '081234567890',
                'role' => 'peternak',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        } else {
            $userSlamet->update([
                'role' => 'peternak',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        PeternakProfile::updateOrCreate(
            ['user_id' => $userSlamet->id],
            [
                'region_id' => $regions['pasuruan']->id,
                'farm_name' => 'Kelompok Peternak Sapi Perah Barokah Pandaan',
                'nik' => '3514081203760001',
                'nib' => '1203760001928374',
                'address' => 'Desa Durensewu, Kec. Pandaan, Kab. Pasuruan',
                'latitude' => -7.6521,
                'longitude' => 112.6983,
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(6),
                'verified_by' => $admin->id,
            ]
        );

        $userFauzan = User::updateOrCreate(
            ['email' => 'fauzan@peternak.id'],
            [
                'name' => 'Ahmad Fauzan',
                'phone_number' => '081298765432',
                'role' => 'peternak',
                'kabupaten' => 'Kabupaten Malang',
                'kecamatan' => 'Singosari',
                'desa' => 'Klampok',
                'livestock_type' => 'Sapi Potong & Domba',
                'livestock_count' => 26,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        PeternakProfile::updateOrCreate(
            ['user_id' => $userFauzan->id],
            [
                'region_id' => $regions['malang']->id,
                'farm_name' => 'Kandang Milenial Singosari Mandiri (Sapi Limousin & Domba Dorper)',
                'nik' => '3507182504950003',
                'nib' => '1995000308765432',
                'address' => 'Desa Klampok, Kec. Singosari, Kab. Malang',
                'latitude' => -7.8921,
                'longitude' => 112.6644,
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(2),
                'verified_by' => $admin->id,
            ]
        );

        // Peternak baru status PENDING (untuk demo Admin melakukan verifikasi peternak)
        $userDian = User::updateOrCreate(
            ['email' => 'dian.pratiwi@peternak.id'],
            [
                'name' => 'Dian Pratiwi, S.Pt',
                'phone_number' => '085233445566',
                'role' => 'peternak',
                'kabupaten' => 'Kabupaten Lumajang',
                'kecamatan' => 'Senduro',
                'desa' => 'Kandangtepus',
                'livestock_type' => 'Kambing Senduro & PE',
                'livestock_count' => 45,
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        PeternakProfile::updateOrCreate(
            ['user_id' => $userDian->id],
            [
                'region_id' => $regions['lumajang']->id,
                'farm_name' => 'Senduro Dairy Goat Farm Lumajang',
                'nik' => '3508126011980002',
                'nib' => '1998000201123456',
                'address' => 'Desa Kandangtepus, Kec. Senduro, Kab. Lumajang',
                'latitude' => -8.1138,
                'longitude' => 113.0645,
                'verification_status' => 'pending',
            ]
        );

        // PENGGUNA UMUM / PEMBELI MARKETPLACE
        $pembeliBudi = User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'phone_number' => '085712345678',
                'role' => 'umum',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $pembeliSiti = User::updateOrCreate(
            ['email' => 'siti.rahayu@gmail.com'],
            [
                'name' => 'Siti Rahayu',
                'phone_number' => '087812998877',
                'role' => 'umum',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $pembeliAgus = User::updateOrCreate(
            ['email' => 'agus.prasetyo@gmail.com'],
            [
                'name' => 'Agus Prasetyo',
                'phone_number' => '081344556677',
                'role' => 'umum',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // -------------------------------------------------------------
        // 3. TERNAK & REKAM MEDIS (LIVESTOCK & HEALTH RECORDS)
        // -------------------------------------------------------------

        // Ternak Randy Zidan (Nganjuk - Bebek / Itik)
        $bebek1 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-NGJ-0101'],
            [
                'user_id' => $userRandy->id,
                'name' => 'Rombongan Bebek Petelur Mojosari Unggul A',
                'type' => 'unggas',
                'gender' => 'betina',
                'birth_date' => '2025-06-15',
                'reproductive_status' => 'Produksi Bertelur (85%/hari)',
                'health_status' => 'sehat',
            ]
        );

        $bebek2 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-NGJ-0102'],
            [
                'user_id' => $userRandy->id,
                'name' => 'Rombongan Bebek Pedaging Hibrida Super B',
                'type' => 'unggas',
                'gender' => 'jantan',
                'birth_date' => '2026-09-20',
                'reproductive_status' => 'Fase Finisher (Umur 45 Hari)',
                'health_status' => 'sehat',
            ]
        );

        $bebek3 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-NGJ-0103'],
            [
                'user_id' => $userRandy->id,
                'name' => 'Rombongan Bebek Dara Siap Telur Pullet C',
                'type' => 'unggas',
                'gender' => 'betina',
                'birth_date' => '2026-05-10',
                'reproductive_status' => 'Fase Pullet Siap Telur (5 Bulan)',
                'health_status' => 'sehat',
            ]
        );

        // Rekam Medis Bebek Randy Zidan (oleh drh. Nur Cahyo, M.Vet)
        HealthRecord::updateOrCreate(
            ['livestock_id' => $bebek1->id, 'title' => 'Vaksinasi AI (Avian Influenza) Booster'],
            [
                'veterinarian_id' => $drhNurCahyo->id,
                'record_type' => 'vaksinasi',
                'diagnosis' => 'Vaksinasi pencegahan flu burung rutin periode produksi telur',
                'treatment' => 'Medivac AI Subtipe H5N1 0.5ml per ekor subkutan',
                'notes' => 'Seluruh 150 ekor merespons baik tanpa efek samping anafilaksis.',
                'record_date' => now()->subDays(28)->toDateString(),
            ]
        );

        HealthRecord::updateOrCreate(
            ['livestock_id' => $bebek1->id, 'title' => 'Terapi Anti-Stres & Suplemen Elektrolit Cuaca'],
            [
                'veterinarian_id' => $drhNurCahyo->id,
                'record_type' => 'pengobatan',
                'diagnosis' => 'Pencegahan stres dingin dan stabilisasi produksi pasca hujan lebat',
                'treatment' => 'Vita-Stress 5gr/10L air minum + Egg Stimulant',
                'notes' => 'Kondisi produksi telur stabil kembali di angka 85% per hari.',
                'record_date' => now()->subDays(3)->toDateString(),
            ]
        );

        HealthRecord::updateOrCreate(
            ['livestock_id' => $bebek2->id, 'title' => 'Kontrol Pertumbuhan Bobot Badan & Sanitasi'],
            [
                'veterinarian_id' => $drhNurCahyo->id,
                'record_type' => 'pemeriksaan',
                'diagnosis' => 'Pemeriksaan rutin fase pembesaran itik pedaging',
                'treatment' => 'Probiotik Bacillus subtilis pada pakan starter + desinfeksi sekam',
                'notes' => 'Pertambahan bobot badan harian (PBBH) mencapai 38 gram/hari, sangat memuaskan.',
                'record_date' => now()->subDays(12)->toDateString(),
            ]
        );

        // Ternak Slamet Rahardjo (Pasuruan - Sapi Perah)
        $sapi1 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-PAS-0024'],
            [
                'user_id' => $userSlamet->id,
                'name' => 'Melati',
                'type' => 'sapi_perah_fh',
                'gender' => 'betina',
                'birth_date' => '2023-03-10',
                'reproductive_status' => 'Bunting 5 Bulan',
                'health_status' => 'sehat',
            ]
        );

        $sapi2 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-PAS-0014'],
            [
                'user_id' => $userSlamet->id,
                'name' => 'Bunga',
                'type' => 'sapi_perah_fh',
                'gender' => 'betina',
                'birth_date' => '2022-11-20',
                'reproductive_status' => 'Laktasi (19 L/hr)',
                'health_status' => 'sehat',
            ]
        );

        $sapi3 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-PAS-0031'],
            [
                'user_id' => $userSlamet->id,
                'name' => 'Si Manis',
                'type' => 'sapi_perah_fh',
                'gender' => 'betina',
                'birth_date' => '2025-07-02',
                'reproductive_status' => 'Dara Bunting Muda (1 Bulan)',
                'health_status' => 'sehat',
            ]
        );

        $sapi4 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-PAS-0042'],
            [
                'user_id' => $userSlamet->id,
                'name' => 'Dewi Sri',
                'type' => 'sapi_perah_fh',
                'gender' => 'betina',
                'birth_date' => '2022-04-18',
                'reproductive_status' => 'Laktasi Puncak (24 L/hr)',
                'health_status' => 'sehat',
            ]
        );

        $sapi5 = Livestock::updateOrCreate(
            ['e_tag_number' => 'JTM-PAS-0055'],
            [
                'user_id' => $userSlamet->id,
                'name' => 'Si Gandi',
                'type' => 'sapi_perah_fh',
                'gender' => 'jantan',
                'birth_date' => '2026-08-14',
                'reproductive_status' => 'Pedet Lepas Sapih (3 Bulan)',
                'health_status' => 'sehat',
            ]
        );

        // Rekam Medis Sapi Slamet
        HealthRecord::updateOrCreate(
            ['livestock_id' => $sapi1->id, 'title' => 'PMK Booster 2 Berkala'],
            [
                'veterinarian_id' => $drhBambang->id,
                'record_type' => 'vaksinasi',
                'diagnosis' => 'Vaksinasi berkala pencegahan PMK dosis lanjutan',
                'treatment' => 'Aftovaxpur 2ml IM',
                'notes' => 'Ternak sehat bugar tidak ada reaksi anafilaksis.',
                'record_date' => now()->subMonths(2)->toDateString(),
            ]
        );

        HealthRecord::updateOrCreate(
            ['livestock_id' => $sapi1->id, 'title' => 'USG & Palpasi Kebuntingan Melati'],
            [
                'veterinarian_id' => $drhDewi->id,
                'record_type' => 'pemeriksaan',
                'diagnosis' => 'Pemeriksaan kebuntingan (PKB) trimester kedua',
                'treatment' => 'Injeksi Calcidex 50ml + Vitamin AD3E',
                'notes' => 'Positif bunting 5 bulan, kondisi foetus aktif dan serviks tertutup rapat.',
                'record_date' => now()->subDays(20)->toDateString(),
            ]
        );

        HealthRecord::updateOrCreate(
            ['livestock_id' => $sapi2->id, 'title' => 'Terapi Mastitis Subklinis & Demam Ringan'],
            [
                'veterinarian_id' => $drhRatna->id,
                'record_type' => 'pengobatan',
                'diagnosis' => 'Kelelahan laktasi pasca pergantian cuaca dan radang ambing ringan',
                'treatment' => 'Infusi intramamari Cloxacillin + Antipiretik Flunixin + Vit B Kompleks',
                'notes' => 'Ambing telah normal kembali dan hasil uji California Mastitis Test (CMT) negatif.',
                'record_date' => now()->subDays(10)->toDateString(),
            ]
        );

        HealthRecord::updateOrCreate(
            ['livestock_id' => $sapi4->id, 'title' => 'Inseminasi Buatan Pejantan FH Import'],
            [
                'veterinarian_id' => $drhDewi->id,
                'record_type' => 'inseminasi_buatan',
                'diagnosis' => 'Pelaksanaan IB pada fase estrus optimal',
                'treatment' => 'Straw Pejantan Bull Friesian Holstein BBIB Singosari',
                'notes' => 'Inseminasi berjalan lancar pada posisi 4 cincin serviks.',
                'record_date' => now()->subMonths(3)->toDateString(),
            ]
        );

        // -------------------------------------------------------------
        // 4. JADWAL PRAKTEK & KONSULTASI DOKTER HEWAN
        // -------------------------------------------------------------
        $datesToSeed = [
            now()->subDays(2)->toDateString(),
            now()->subDay()->toDateString(),
            now()->toDateString(),
            now()->addDay()->toDateString(),
            now()->addDays(2)->toDateString(),
        ];

        $timeSlots = [
            ['start' => '08:00', 'end' => '09:00', 'type' => 'konsultasi_online', 'quota' => 4],
            ['start' => '09:30', 'end' => '10:30', 'type' => 'konsultasi_online', 'quota' => 4],
            ['start' => '11:00', 'end' => '12:00', 'type' => 'tatap_muka', 'quota' => 3],
            ['start' => '13:30', 'end' => '15:00', 'type' => 'konsultasi_online', 'quota' => 5],
        ];

        $createdSchedules = [];
        foreach ($vets as $vet) {
            foreach ($datesToSeed as $dateStr) {
                foreach ($timeSlots as $slot) {
                    $createdSchedules[$vet->id][$dateStr][$slot['start']] = ConsultationSchedule::updateOrCreate(
                        [
                            'veterinarian_id' => $vet->id,
                            'date' => $dateStr,
                            'start_time' => $slot['start'],
                        ],
                        [
                            'end_time' => $slot['end'],
                            'quota' => $slot['quota'],
                            'status' => 'buka',
                            'service_type' => $slot['type'],
                            'notes' => $slot['type'] === 'tatap_muka' ? 'Pemeriksaan langsung di klinik Puskeswan' : 'Telemedisin online via aplikasi',
                        ]
                    );
                }
            }
        }

        // KONSULTASI 1: Randy Zidan dengan drh. Nur Cahyo (HARI INI - Dikonfirmasi)
        $slotRandyToday = $createdSchedules[$vets['nurcahyo@disnak.jatimprov.go.id']->id][now()->toDateString()]['09:30'] ?? null;
        $consultRandy1 = Consultation::updateOrCreate(
            ['booking_code' => 'JDW-202611-0101'],
            [
                'user_id' => $userRandy->id,
                'veterinarian_id' => $drhNurCahyo->id,
                'consultation_schedule_id' => $slotRandyToday?->id,
                'livestock_id' => $bebek1->id,
                'consultation_date' => now()->toDateString(),
                'consultation_time' => '09:30 - 10:30 WIB',
                'subject' => 'Formulasi Ransum Bebek Petelur Stabilisasi Pasca Musim Hujan',
                'complaint_details' => 'Produksi telur sempat sedikit turun karena suhu dingin malam hari di Berbek. Mohon rekomendasi proporsi bekatul jagung dan premix asam amino agar produksi konsisten di atas 80%.',
                'doctor_notes' => 'Kondisi rombongan itik baik. Rekomendasi formulasi ransum berprotein 18-19% dengan tambahan tepung ikan dan bekatul halus.',
                'hypothesis' => 'Fluktuasi suhu lingkungan mempengaruhi metabolisme energi pada itik petelur.',
                'prescription' => 'Premix mineral itik petelur 20g/kg pakan, Vitamin Vita-Stress pada air minum pagi hari selama 3 hari.',
                'recommendations' => 'Pastikan alas kandang sekam selalu kering dan hangat. Jangan biarkan air minum tergenang di area pakan.',
                'consultation_type' => 'konsultasi_online',
                'status' => 'dikonfirmasi',
            ]
        );

        ConsultationMessage::firstOrCreate(
            ['consultation_id' => $consultRandy1->id, 'sender_id' => $userRandy->id],
            [
                'message' => 'Selamat pagi Dokter Nur Cahyo. Mohon saran untuk formula ransum pakan itik petelur saya di Berbek, kemarin sempat turun karena hujan terus.',
                'created_at' => now()->subHours(2),
            ]
        );

        ConsultationMessage::firstOrCreate(
            ['consultation_id' => $consultRandy1->id, 'sender_id' => $drhNurCahyo->id],
            [
                'message' => 'Selamat pagi Mas Randy. Pakan bisa disesuaikan: jagung giling 35%, konsentrat itik 25%, bekatul halus 32%, dan tepung ikan 8%. Tambahkan premix vitamin pada air minum pagi. Besok saya jadwalkan mampir ke kandang untuk cek langsung ya.',
                'created_at' => now()->subHour(),
            ]
        );

        // KONSULTASI 2: Randy Zidan dengan drh. Nur Cahyo (SELESAI - Riwayat Vaksinasi)
        $slotRandyPast = $createdSchedules[$vets['nurcahyo@disnak.jatimprov.go.id']->id][now()->subDays(2)->toDateString()]['08:00'] ?? null;
        Consultation::updateOrCreate(
            ['booking_code' => 'JDW-202611-0102'],
            [
                'user_id' => $userRandy->id,
                'veterinarian_id' => $drhNurCahyo->id,
                'consultation_schedule_id' => $slotRandyPast?->id,
                'livestock_id' => $bebek1->id,
                'consultation_date' => now()->subDays(2)->toDateString(),
                'consultation_time' => '08:00 - 09:00 WIB',
                'subject' => 'Evaluasi Titer Antibodi Pasca Vaksinasi AI Unggas',
                'complaint_details' => 'Memastikan jadwal pengulangan vaksin flu burung berikutnya untuk 150 ekor itik mojosari.',
                'doctor_notes' => 'Titer antibodi diperkirakan protektif hingga 4 bulan ke depan. Jadwal vaksinasi ulang direkomendasikan pada Februari 2027.',
                'prescription' => 'Pertahankan biosekuriti kandang dan penyemprotan desinfektan 2x seminggu.',
                'consultation_type' => 'konsultasi_online',
                'status' => 'selesai',
            ]
        );

        // KONSULTASI 3: Slamet Rahardjo dengan drh. Ratna Kusuma (SELESAI)
        $slotSlametToday = $createdSchedules[$vets['ratnak@disnak.jatimprov.go.id']->id][now()->toDateString()]['08:00'] ?? null;
        $consultSlamet1 = Consultation::updateOrCreate(
            ['booking_code' => 'JDW-202611-0201'],
            [
                'user_id' => $userSlamet->id,
                'veterinarian_id' => $drhRatna->id,
                'consultation_schedule_id' => $slotSlametToday?->id,
                'livestock_id' => $sapi2->id,
                'consultation_date' => now()->toDateString(),
                'consultation_time' => '08:00 - 09:00 WIB',
                'subject' => 'Evaluasi Ambing & Pemulihan Produksi Susu Sapi Bunga',
                'complaint_details' => 'Sapi Bunga no. 14 nafsu makan sudah membaik pasca terapi. Ingin konsultasi apakah sudah boleh diperah penuh dengan mesin.',
                'doctor_notes' => 'Uji CMT negatif, ambing tidak bengkak. Sudah boleh diperah bertahap mulai hari ini.',
                'prescription' => 'Lanjutkan teat dipping antiseptik iodin 1% setiap selesai pemerahan pagi dan sore.',
                'consultation_type' => 'konsultasi_online',
                'status' => 'selesai',
            ]
        );

        ConsultationMessage::firstOrCreate(
            ['consultation_id' => $consultSlamet1->id, 'sender_id' => $userSlamet->id],
            [
                'message' => 'Selamat pagi Dokter Ratna. Ambing sapi Bunga sudah kenyal kembali dan suhu tubuh normal 38.6°C. Apakah sudah aman kami perah lagi dok?',
                'created_at' => now()->subHours(3),
            ]
        );

        ConsultationMessage::firstOrCreate(
            ['consultation_id' => $consultSlamet1->id, 'sender_id' => $drhRatna->id],
            [
                'message' => 'Alhamdulillah Pak Slamet. Hasilnya sudah sangat bagus. Silakan perah manual dulu 2 hari ini untuk memastikan aliran lancar, lalu bisa kembali dengan mesin perah.',
                'created_at' => now()->subHours(2),
            ]
        );

        // KONSULTASI 4: Slamet dengan drh. Dewi Sartika (BESOK - Dikonfirmasi)
        $slotSlametTomorrow = $createdSchedules[$vets['dewi@disnak.jatimprov.go.id']->id][now()->addDay()->toDateString()]['11:00'] ?? null;
        Consultation::updateOrCreate(
            ['booking_code' => 'JDW-202611-0202'],
            [
                'user_id' => $userSlamet->id,
                'veterinarian_id' => $drhDewi->id,
                'consultation_schedule_id' => $slotSlametTomorrow?->id,
                'livestock_id' => $sapi1->id,
                'consultation_date' => now()->addDay()->toDateString(),
                'consultation_time' => '11:00 - 12:00 WIB',
                'subject' => 'Pemeriksaan Kebuntingan Lanjutan Melati (Bunting 5 Bulan)',
                'complaint_details' => 'Pemeriksaan USG berkala di Puskeswan untuk memantau detak jantung janin pedet.',
                'consultation_type' => 'tatap_muka',
                'status' => 'dikonfirmasi',
            ]
        );

        // KONSULTASI 5: Ahmad Fauzan dengan drh. Bambang (MENUNGGU KONFIRMASI - untuk demo dokter)
        $slotBambangToday = $createdSchedules[$vets['bambang@disnak.jatimprov.go.id']->id][now()->toDateString()]['13:30'] ?? null;
        Consultation::updateOrCreate(
            ['booking_code' => 'JDW-202611-0301'],
            [
                'user_id' => $userFauzan->id,
                'veterinarian_id' => $drhBambang->id,
                'consultation_schedule_id' => $slotBambangToday?->id,
                'consultation_date' => now()->toDateString(),
                'consultation_time' => '13:30 - 15:00 WIB',
                'subject' => 'Pencegahan Bloat / Timpani Rumen pada Sapi Penggemukan Ransum Basah',
                'complaint_details' => 'Sapi limousin sering terlihat sedikit kembung saat diberi rumput gajah muda basah pasca panen hujan. Mohon arahan dokter.',
                'consultation_type' => 'konsultasi_online',
                'status' => 'menunggu_konfirmasi',
            ]
        );

        // -------------------------------------------------------------
        // 5. LAPORAN KESEHATAN HEWAN (ANIMAL HEALTH REPORTS)
        // -------------------------------------------------------------

        // LAPORAN 1: Randy Zidan (Nganjuk - KUNJUNGAN TERJADWAL BESOK)
        $repRandy1 = AnimalHealthReport::updateOrCreate(
            ['report_number' => 'LKH-20261106-0001-NGJ'],
            [
                'user_id' => $userRandy->id,
                'assigned_veterinarian_id' => $vets['nurcahyo@disnak.jatimprov.go.id']->id,
                'livestock_type' => 'Bebek / Itik Petelur Mojosari',
                'affected_count' => 8,
                'symptoms' => 'Beberapa itik tampak bersin, mata agak berair dan hidung berlendir encer. Konsumsi pakan turun sekitar 15% sejak pergantian cuaca dingin 3 hari lalu.',
                'symptoms_started_at' => now()->subDays(3)->toDateString(),
                'urgency' => 'sedang',
                'farm_name' => 'Peternakan Bebek & Unggas Milenial Berkah Tiripan',
                'farm_address' => 'Dusun Tiripan RT 03/RW 02, Desa Tiripan, Kec. Berbek, Kab. Nganjuk',
                'kabupaten' => 'Kabupaten Nganjuk',
                'status' => 'kunjungan_terjadwal',
                'last_responded_at' => now()->subDay(),
            ]
        );

        $repRandy1->responses()->updateOrCreate(
            ['message' => 'Laporan masuk telah kami periksa dan evaluasi klinis. Indikasi mengarah pada Infectious Coryza (Snot) stadium awal akibat kelembapan sekam kandang.'],
            [
                'user_id' => $drhNurCahyo->id,
                'hypothesis' => 'Dugaan klinis: Coryza ringan diperparah stres fluktuasi kelembapan udara malam hari.',
                'recommendations' => "1. Ganti sekam kandang yang basah dengan sekam kering bersih.\n2. Berikan Enrofloxacin 10% larut air minum selama 3 hari berturut-turut.\n3. Tambahkan multivitamin Vita-Stress pada pagi hari.",
                'follow_up_instructions' => 'Kandang akan kami tinjau langsung besok pagi pukul 10.00 WIB untuk nekropsi dan uji kualitas air minum.',
                'urgency_level' => 'sedang',
                'requires_visit' => true,
                'notes' => 'Telah dikoordinasikan jadwal kunjungan lapangan veteriner.',
            ]
        );

        $repRandy1->visits()->updateOrCreate(
            ['visit_reason' => 'Pemeriksaan fisik langsung populasi itik di Tiripan Berbek, auskultasi pernapasan, dan sanitasi kandang.'],
            [
                'veterinarian_id' => $vets['nurcahyo@disnak.jatimprov.go.id']->id,
                'created_by_id' => $drhNurCahyo->id,
                'proposed_date' => now()->addDay()->setHour(10)->setMinute(0),
                'confirmed_date' => now()->addDay()->setHour(10)->setMinute(0),
                'status' => 'terjadwal',
                'farmer_notes' => 'Siap dokter, gerbang kandang di Dusun Tiripan sudah kami siapkan beserta sampel air minum ternak.',
            ]
        );

        AnimalHealthReportStatusHistory::firstOrCreate(
            ['animal_health_report_id' => $repRandy1->id, 'new_status' => 'kunjungan_terjadwal'],
            [
                'changed_by_id' => $drhNurCahyo->id,
                'previous_status' => 'sedang_ditangani',
                'notes' => 'Kunjungan telah disepakati kedua belah pihak.',
            ]
        );

        // LAPORAN 2: Randy Zidan (SELESAI - Kasus Masa Lalu)
        $repRandy2 = AnimalHealthReport::updateOrCreate(
            ['report_number' => 'LKH-20261012-0003-SLS'],
            [
                'user_id' => $userRandy->id,
                'assigned_veterinarian_id' => $vets['nurcahyo@disnak.jatimprov.go.id']->id,
                'livestock_type' => 'Bebek Pedaging Hibrida',
                'affected_count' => 3,
                'symptoms' => 'Itik pedaging kotoran agak encer kehijauan pasca pergantian konsentrat baru.',
                'symptoms_started_at' => now()->subDays(25)->toDateString(),
                'urgency' => 'rendah',
                'farm_name' => 'Peternakan Bebek & Unggas Milenial Berkah Tiripan',
                'farm_address' => 'Desa Tiripan, Kec. Berbek, Kab. Nganjuk',
                'kabupaten' => 'Kabupaten Nganjuk',
                'status' => 'selesai',
                'last_responded_at' => now()->subDays(20),
                'resolved_at' => now()->subDays(18),
            ]
        );

        $repRandy2->responses()->updateOrCreate(
            ['message' => 'Penyesuaian adaptasi bakteri usus terhadap pergantian ransum. Berikan probiotik cair Lactobacillus.'],
            [
                'user_id' => $drhNurCahyo->id,
                'hypothesis' => 'Gangguan pencernaan fisiologis ringan non-bakterial.',
                'recommendations' => 'Campurkan probiotik 5ml per liter air minum selama 3 hari.',
                'follow_up_instructions' => 'Kondisi telah pulih total.',
                'urgency_level' => 'rendah',
                'requires_visit' => false,
            ]
        );

        // LAPORAN 3: Slamet Rahardjo (Pasuruan - SEDANG DITANGANI)
        $repSlamet1 = AnimalHealthReport::updateOrCreate(
            ['report_number' => 'LAP-202610-0012'],
            [
                'user_id' => $userSlamet->id,
                'assigned_veterinarian_id' => $vets['ratnak@disnak.jatimprov.go.id']->id,
                'livestock_type' => 'Sapi Perah Friesian Holstein',
                'affected_count' => 2,
                'symptoms' => 'Dua ekor sapi perah betina mengalami demam 39.8°C, produksi susu anjlok 50%, nafsu makan menurun drastis, dan ambing teraba tegang.',
                'symptoms_started_at' => now()->subDays(4)->toDateString(),
                'urgency' => 'tinggi',
                'farm_name' => 'Kelompok Peternak Sapi Perah Barokah Pandaan',
                'farm_address' => 'Desa Durensewu, Pandaan, Kab. Pasuruan',
                'kabupaten' => 'Kabupaten Pasuruan',
                'status' => 'sedang_ditangani',
                'last_responded_at' => now()->subHours(6),
            ]
        );

        // LAPORAN 4: Laporan Masuk Baru untuk drh. Ratna (MENUNGGU RESPONS - untuk demo dokter menjawab laporan)
        AnimalHealthReport::updateOrCreate(
            ['report_number' => 'LKH-20261109-0004-INCM'],
            [
                'user_id' => $userSlamet->id,
                'assigned_veterinarian_id' => $vets['ratnak@disnak.jatimprov.go.id']->id,
                'livestock_type' => 'Sapi Perah Friesian Holstein',
                'affected_count' => 1,
                'symptoms' => 'Sapi perah laktasi tiba-tiba enggan berdiri sejak subuh tadi, telinga teraba dingin dan mata tampak sayu pasca melahirkan 3 hari lalu.',
                'symptoms_started_at' => now()->toDateString(),
                'urgency' => 'tinggi',
                'farm_name' => 'Kelompok Peternak Sapi Perah Barokah Pandaan',
                'farm_address' => 'Desa Durensewu, Pandaan, Kab. Pasuruan',
                'kabupaten' => 'Kabupaten Pasuruan',
                'status' => 'menunggu_respons',
            ]
        );

        // LAPORAN 5: Ahmad Fauzan (Malang - SUDAH DIJAWAB oleh drh. Bambang)
        $repFauzan = AnimalHealthReport::updateOrCreate(
            ['report_number' => 'LKH-20261107-0002-MLG'],
            [
                'user_id' => $userFauzan->id,
                'assigned_veterinarian_id' => $vets['bambang@disnak.jatimprov.go.id']->id,
                'livestock_type' => 'Sapi Potong Limousin',
                'affected_count' => 1,
                'symptoms' => 'Sapi pejantan pincang pada kaki kanan belakang setelah berjalan di area lantai kandang semen basah.',
                'symptoms_started_at' => now()->subDays(2)->toDateString(),
                'urgency' => 'sedang',
                'farm_name' => 'Kandang Milenial Singosari Mandiri',
                'farm_address' => 'Desa Klampok, Singosari, Malang',
                'kabupaten' => 'Kabupaten Malang',
                'status' => 'sudah_dijawab',
                'last_responded_at' => now()->subHours(8),
            ]
        );

        $repFauzan->responses()->updateOrCreate(
            ['message' => 'Dugaan trauma kuku (pododermatitis aseptik). Bersihkan celah kuku dengan larutan tembaga sulfat 5%.'],
            [
                'user_id' => $drhBambang->id,
                'hypothesis' => 'Trauma mekanis gesekan kuku tanpa keterlibatan abses supuratif.',
                'recommendations' => "1. Tempatkan sapi di kandang beralas pasir atau jerami tebal kering.\n2. Semprotkan semprotan antiseptik oxytetracycline pada celah kuku.\n3. Istirahatkan dari latihan jalan selama 3 hari.",
                'follow_up_instructions' => 'Bila dalam 48 jam masih terdapat kepincangan akut, kami akan jadwalkan trimming kuku korektif.',
                'urgency_level' => 'sedang',
                'requires_visit' => false,
            ]
        );

        // -------------------------------------------------------------
        // 6. MARKETPLACE: KATEGORI, PRODUK & PESANAN LENGKAP
        // -------------------------------------------------------------
        $catSusu = ProductCategory::firstOrCreate(['slug' => 'susu-olahan'], ['name' => 'Susu Olahan']);
        $catDaging = ProductCategory::firstOrCreate(['slug' => 'daging-segar'], ['name' => 'Daging Segar']);
        $catPakan = ProductCategory::firstOrCreate(['slug' => 'pakan-silase'], ['name' => 'Pakan & Silase']);
        $catBibit = ProductCategory::firstOrCreate(['slug' => 'bibit-ternak'], ['name' => 'Bibit Ternak']);
        $catUnggas = ProductCategory::firstOrCreate(['slug' => 'olahan-telur-unggas'], ['name' => 'Olahan Telur & Unggas']);
        $catPupuk = ProductCategory::firstOrCreate(['slug' => 'pupuk-bio-organik'], ['name' => 'Pupuk & Bio-Organik']);

        // PRODUK RANDY ZIDAN (Nganjuk - Bebek & Telur)
        $prodRandy1 = Product::updateOrCreate(
            ['slug' => 'telur-bebek-asin-bakar-rempah-nganjuk-10-butir'],
            [
                'user_id' => $userRandy->id,
                'product_category_id' => $catUnggas->id,
                'region_id' => $regions['nganjuk']->id,
                'name' => 'Telur Bebek Asin Bakar Rempah Khas Nganjuk (Isi 10 Butir)',
                'description' => "Telur bebek asin bakar rempah kualitas premium khas peternakan milenial Berkah Tiripan, Berbek, Nganjuk. Dihasilkan dari telur bebek segar itik mojosari pilihan dengan pakan alami berprotein tinggi.\n\nMelalui proses pemeraman adonan bata merah dan garam beryodium selama 14 hari, kemudian diasap dan dibakar dengan arang batok kelapa pilihan menghasilkan aroma harum smokey yang menggugah selera. Kuning telur masir berminyak kemerahan, gurih nikmat, dan tidak amis sama sekali.\n\nSangat cocok untuk lauk harian, oleh-oleh khas Jawa Timur, maupun pendamping rawon dan soto. Tahan simpan hingga 3 minggu di suhu ruang.",
                'price' => 42000,
                'stock' => 85,
                'unit' => 'Kotak (10 Butir)',
                'image_path' => 'products/MRcsx5YRbyRohLHyEFoedcHqZ8Uj77NsoLVWBVOh.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodRandy2 = Product::updateOrCreate(
            ['slug' => 'telur-bebek-segar-grade-a-30-butir-tray'],
            [
                'user_id' => $userRandy->id,
                'product_category_id' => $catUnggas->id,
                'region_id' => $regions['nganjuk']->id,
                'name' => 'Telur Bebek Segar Grade A Berkualitas (1 Tray / 30 Butir)',
                'description' => "Telur bebek mentah segar grade A langsung dari kandang peternakan Berkah Tiripan Nganjuk. Diambil harian dengan cangkang tebal biru kehijauan bersih tanpa retak.\n\nKaya kandungan nutrisi protein hewani, omega-3, dan lecithin alami. Sangat cocok untuk bahan baku industri telur asin rumahan, jamu tradisional, martabak telur premium, maupun kue basah.\n\nDikemas aman dengan egg tray karton tebal berlapis pelindung anti-guncangan saat pengiriman.",
                'price' => 75000,
                'stock' => 50,
                'unit' => 'Tray (30 Butir)',
                'image_path' => 'products/MRcsx5YRbyRohLHyEFoedcHqZ8Uj77NsoLVWBVOh.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodRandy3 = Product::updateOrCreate(
            ['slug' => 'daging-bebek-karkas-bersih-siap-masak-1-ekor'],
            [
                'user_id' => $userRandy->id,
                'product_category_id' => $catDaging->id,
                'region_id' => $regions['nganjuk']->id,
                'name' => 'Daging Bebek Karkas Bersih Higienis (1 Ekor ~ 1.2 Kg)',
                'description' => "Karkas bebek potong bersih higienis siap olah hasil budidaya itik pedaging hibrida usia 45 hari. Dipotong secara syar'i di RPH unggas berstandar ASUH (Aman, Sehat, Utuh, Halal).\n\nDaging empuk tebal, bersih dari bulu halus dan tanpa jeroan. Dikemas higienis menggunakan plastik vacuum food-grade dan dibekukan cepat untuk mengunci kesegaran alami daging bebek.",
                'price' => 52000,
                'stock' => 35,
                'unit' => 'Ekor',
                'image_path' => 'products/daging_wagyu_malang.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodRandy4 = Product::updateOrCreate(
            ['slug' => 'pakan-konsentrat-itik-petelur-plus-probiotik-50kg'],
            [
                'user_id' => $userRandy->id,
                'product_category_id' => $catPakan->id,
                'region_id' => $regions['nganjuk']->id,
                'name' => 'Pakan Konsentrat Itik Petelur Plus Probiotik (50 Kg)',
                'description' => 'Ransum pakan konsentrat itik petelur terformulasi khusus hasil pelatihan bimtek Dinas Peternakan Jawa Timur. Mengandung protein kasar minimum 19%, kalsium, fosfor seimbang, dan mikroba probiotik asam laktat untuk memaksimalkan produksi telur harian hingga 85% serta memperkuat cangkang telur.',
                'price' => 340000,
                'stock' => 25,
                'unit' => 'Sak (50 Kg)',
                'image_path' => 'products/silase_fermentasi_batu.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        // Produk Randy Zidan STATUS PENDING VERIFIKASI (Untuk demo Admin memverifikasi produk baru!)
        Product::updateOrCreate(
            ['slug' => 'telur-bebek-asin-mentah-masir-tradisional-10-butir'],
            [
                'user_id' => $userRandy->id,
                'product_category_id' => $catUnggas->id,
                'region_id' => $regions['nganjuk']->id,
                'name' => 'Telur Bebek Asin Mentah Masir Tradisional Bata Merah (10 Butir)',
                'description' => 'Telur asin mentah berbalut pasta bata merah siap rebus atau kukus mandiri. Rasa asin gurih meresap sempurna.',
                'price' => 35000,
                'stock' => 60,
                'unit' => 'Kotak (10 Butir)',
                'image_path' => 'products/MRcsx5YRbyRohLHyEFoedcHqZ8Uj77NsoLVWBVOh.jpg',
                'is_verified' => false, // PENDING VERIFIKASI ADMIN!
                'status' => 'active',
            ]
        );

        // PRODUK SLAMET RAHARDJO (Pasuruan - Susu & Pakan)
        $prodSlamet1 = Product::updateOrCreate(
            ['slug' => 'susu-segar-pasteurisasi-kud-pandaan-1l'],
            [
                'user_id' => $userSlamet->id,
                'product_category_id' => $catSusu->id,
                'region_id' => $regions['pasuruan']->id,
                'name' => 'Susu Segar Pasteurisasi KUD Pandaan (1 L)',
                'description' => 'Susu segar murni pasteurisasi standar cold chain dari sapi perah FH binaan KUD Pandaan Pasuruan. Bebas bahan pengawet.',
                'price' => 18000,
                'stock' => 140,
                'unit' => 'Liter',
                'image_path' => 'products/MRcsx5YRbyRohLHyEFoedcHqZ8Uj77NsoLVWBVOh.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodSlamet2 = Product::updateOrCreate(
            ['slug' => 'daging-sapi-wagyu-lokal-malang-1kg'],
            [
                'user_id' => $userSlamet->id,
                'product_category_id' => $catDaging->id,
                'region_id' => $regions['malang']->id,
                'name' => 'Daging Sapi Wagyu Lokal Malang (1 Kg)',
                'description' => 'Daging sapi wagyu mutu prima hasil budidaya intensif peternak milenial lereng Bromo Tengger. Marbling halus lembut berstandar NKV.',
                'price' => 145000,
                'stock' => 40,
                'unit' => 'Kilogram',
                'image_path' => 'products/daging_wagyu_malang.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodSlamet3 = Product::updateOrCreate(
            ['slug' => 'silase-pakan-komplit-fermentasi-50kg'],
            [
                'user_id' => $userSlamet->id,
                'product_category_id' => $catPakan->id,
                'region_id' => $regions['batu']->id,
                'name' => 'Silase Pakan Komplit Fermentasi Tebon Jagung (50 Kg)',
                'description' => 'Pakan hijauan fermentasi anaerobik 21 hari dengan probiotik asam laktat unggul BBPP Batu. Siap saji menstabilkan laktasi sapi.',
                'price' => 85000,
                'stock' => 75,
                'unit' => 'Sak (50 Kg)',
                'image_path' => 'products/silase_fermentasi_batu.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        $prodSlamet4 = Product::updateOrCreate(
            ['slug' => 'keju-mozzarella-susu-sapi-murni-pasuruan-250gr'],
            [
                'user_id' => $userSlamet->id,
                'product_category_id' => $catSusu->id,
                'region_id' => $regions['pasuruan']->id,
                'name' => 'Keju Mozzarella Artisan Susu Sapi Pasuruan (250 gr)',
                'description' => 'Keju mozzarella segar buatan tangan dari 100% susu sapi murni lereng Pandaan. Lumer elastis sempurna untuk pizza dan roti bakar.',
                'price' => 38000,
                'stock' => 50,
                'unit' => 'Pcs (250 gr)',
                'image_path' => 'products/MRcsx5YRbyRohLHyEFoedcHqZ8Uj77NsoLVWBVOh.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        // PRODUK AHMAD FAUZAN (Malang - Sapi Potong)
        $prodFauzan1 = Product::updateOrCreate(
            ['slug' => 'daging-sapi-rawon-dan-rendang-segar-1kg'],
            [
                'user_id' => $userFauzan->id,
                'product_category_id' => $catDaging->id,
                'region_id' => $regions['malang']->id,
                'name' => 'Daging Sapi Segar Bagian Gandik & Sengkel (1 Kg)',
                'description' => 'Potongan daging sapi potong limousin segar higienis cocok untuk masakan rawon khas Jawa Timur dan rendang empuk.',
                'price' => 125000,
                'stock' => 30,
                'unit' => 'Kilogram',
                'image_path' => 'products/daging_wagyu_malang.jpg',
                'is_verified' => true,
                'status' => 'active',
            ]
        );

        // PESANAN TRANSAKSI REALISTIS (ORDERS & ORDER ITEMS)

        // ORDER 1: Budi Santoso membeli Telur Asin Randy + Susu Pasteurisasi Slamet (SELESAI)
        $order1 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0001'],
            [
                'buyer_id' => $pembeliBudi->id,
                'total_amount' => 120000,
                'status' => 'completed',
                'shipping_address' => 'Jl. Dharmawangsa No. 15, Gubeng, Kota Surabaya',
                'buyer_phone' => '085712345678',
                'notes' => 'Transfer Bank BCA • Pengiriman dengan kemasan insulasi pendingin. Paket telah diterima dalam kondisi sangat baik.',
                'created_at' => now()->subDays(4),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $prodRandy1->id],
            [
                'seller_id' => $userRandy->id,
                'quantity' => 2,
                'price_per_unit' => 42000,
                'subtotal' => 84000,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $prodSlamet1->id],
            [
                'seller_id' => $userSlamet->id,
                'quantity' => 2,
                'price_per_unit' => 18000,
                'subtotal' => 36000,
            ]
        );

        // ORDER 2: Budi Santoso membeli Daging Wagyu Lokal (DALAM PENGIRIMAN - RESI AKTIF)
        $order2 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0002'],
            [
                'buyer_id' => $pembeliBudi->id,
                'total_amount' => 290000,
                'status' => 'shipped',
                'shipping_address' => 'Jl. Dharmawangsa No. 15, Gubeng, Kota Surabaya',
                'buyer_phone' => '085712345678',
                'notes' => 'QRIS Instan • Resi JNE Cold Express: JNE-COLD-8829104. Sedang dalam perjalanan kurir pendingin ke Surabaya.',
                'created_at' => now()->subDays(2),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_id' => $prodSlamet2->id],
            [
                'seller_id' => $userSlamet->id,
                'quantity' => 2,
                'price_per_unit' => 145000,
                'subtotal' => 290000,
            ]
        );

        // ORDER 3: Siti Rahayu membeli Telur Bebek Segar Randy + Keju Mozzarella Slamet (DALAM PENGIRIMAN)
        $order3 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0003'],
            [
                'buyer_id' => $pembeliSiti->id,
                'total_amount' => 151000,
                'status' => 'shipped',
                'shipping_address' => 'Perumahan Ijen Nirwana Blok D-8, Klojen, Kota Malang',
                'buyer_phone' => '087812998877',
                'notes' => 'Transfer Bank Mandiri • Resi Paxel Sameday: PXL-MLG-771239. Garansi makanan beku dan telur anti-pecah.',
                'created_at' => now()->subDay(),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_id' => $prodRandy2->id],
            [
                'seller_id' => $userRandy->id,
                'quantity' => 1,
                'price_per_unit' => 75000,
                'subtotal' => 75000,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_id' => $prodSlamet4->id],
            [
                'seller_id' => $userSlamet->id,
                'quantity' => 2,
                'price_per_unit' => 38000,
                'subtotal' => 76000,
            ]
        );

        // ORDER 4: Siti Rahayu membeli Telur Bebek Asin Bakar Randy Zidan (SELESAI - RATING PUAS)
        $order4 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0004'],
            [
                'buyer_id' => $pembeliSiti->id,
                'total_amount' => 126000,
                'status' => 'completed',
                'shipping_address' => 'Perumahan Ijen Nirwana Blok D-8, Klojen, Kota Malang',
                'buyer_phone' => '087812998877',
                'notes' => 'QRIS Instan • Telur bebek asin bakar sangat gurih berminyak masir, kemasan kardus rapi dan aman.',
                'created_at' => now()->subDays(6),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order4->id, 'product_id' => $prodRandy1->id],
            [
                'seller_id' => $userRandy->id,
                'quantity' => 3,
                'price_per_unit' => 42000,
                'subtotal' => 126000,
            ]
        );

        // ORDER 5: Budi Santoso membeli Silase Tebon Jagung Slamet (DIPROSES PENJUAL)
        $order5 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0005'],
            [
                'buyer_id' => $pembeliBudi->id,
                'total_amount' => 170000,
                'status' => 'processing',
                'shipping_address' => 'Kandang Komunal Wonocolo, Kota Surabaya',
                'buyer_phone' => '085712345678',
                'notes' => 'Transfer BCA • Penjual sedang menyiapkan ikatan sak silase untuk dijemput armada pick-up.',
                'created_at' => now()->subHours(8),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order5->id, 'product_id' => $prodSlamet3->id],
            [
                'seller_id' => $userSlamet->id,
                'quantity' => 2,
                'price_per_unit' => 85000,
                'subtotal' => 170000,
            ]
        );

        // ORDER 6: Agus Prasetyo membeli Karkas Bebek Randy Zidan (MENUNGGU PEMBAYARAN)
        $order6 = Order::updateOrCreate(
            ['order_code' => 'ORD-202611-0006'],
            [
                'buyer_id' => $pembeliAgus->id,
                'total_amount' => 208000,
                'status' => 'pending',
                'shipping_address' => 'Perum Griya Cantik No. 22, Candi, Kab. Sidoarjo',
                'buyer_phone' => '081344556677',
                'notes' => 'Menunggu Pembayaran Transfer Virtual Account Bank Jatim.',
                'created_at' => now()->subHours(2),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order6->id, 'product_id' => $prodRandy3->id],
            [
                'seller_id' => $userRandy->id,
                'quantity' => 4,
                'price_per_unit' => 52000,
                'subtotal' => 208000,
            ]
        );

        // -------------------------------------------------------------
        // 7. PELATIHAN (BIMTEK), LMS, KUIS & E-SERTIFIKAT
        // -------------------------------------------------------------
        $t1 = Training::updateOrCreate(
            ['slug' => 'formulasi-pakan-ransum-silase'],
            [
                'title' => 'Formulasi Pakan Ransum & Silase Modern',
                'description' => 'Efisiensi biaya pakan mandiri dengan limbah pertanian lokal Jawa Timur dan probiotik anaerob.',
                'instructor' => 'Dr. Ir. Hendro Wibowo',
                'instructor_title' => 'Widyaiswara Ahli Utama BBPP Batu',
                'start_date' => now()->subDays(15)->toDateString(),
                'end_date' => now()->subDays(13)->toDateString(),
                'time_info' => '08:00 - 15:00 WIB',
                'location' => 'BBPP Songgoriti, Kota Batu',
                'is_online' => false,
                'quota' => 30,
                'remaining_quota' => 10,
                'cost_type' => 'gratis_apbd',
                'status' => 'open',
                'has_certificate' => true,
                'certificate_title' => 'Sertifikasi Formulasi Pakan Ransum & Silase Modern',
            ]
        );

        $t2 = Training::updateOrCreate(
            ['slug' => 'biosekuriti-pencegahan-penyakit'],
            [
                'title' => 'Biosekuriti & SOP Pencegahan Penyakit Menular PMK/LSD',
                'description' => 'SOP sterilisasi kandang, deteksi dini PMK/LSD, dan manajemen sanitasi peternakan komunal.',
                'instructor' => 'drh. Nur Cahyo, M.Vet',
                'instructor_title' => 'Koordinator Kesehatan Hewan Puskeswan Pare',
                'start_date' => now()->addDays(5)->toDateString(),
                'end_date' => now()->addDays(6)->toDateString(),
                'time_info' => '08:30 - 14:00 WIB',
                'location' => 'Puskeswan Pandaan, Pasuruan',
                'is_online' => false,
                'quota' => 35,
                'remaining_quota' => 18,
                'cost_type' => 'gratis_apbd',
                'status' => 'open',
                'has_certificate' => true,
                'certificate_title' => 'Sertifikasi Penerapan Biosekuriti Kandang & Keswan Terpadu',
            ]
        );

        $t3 = Training::updateOrCreate(
            ['slug' => 'pemasaran-digital-kur-peternakan'],
            [
                'title' => 'Pemasaran Digital & Akses KUR Peternakan Milenial Jatim',
                'description' => 'Branding produk olahan ternak, kurasi pasar modern, dan optimasi pembiayaan permodalan Bank Jatim.',
                'instructor' => 'Dr. Ir. Budi Santoso, M.Sc',
                'instructor_title' => 'Widyaiswara Ahli Utama BBPP Batu',
                'start_date' => now()->subDays(7)->toDateString(),
                'end_date' => now()->subDays(7)->toDateString(),
                'time_info' => '13:00 - 16:30 WIB',
                'location' => 'Zoom Cloud Meetings Disnak Jatim',
                'is_online' => true,
                'zoom_link' => 'https://zoom.us/j/88392182019?pwd=disnakjatim2026',
                'zoom_meeting_id' => '883 9218 2019',
                'zoom_passcode' => 'JATIM2026',
                'document_path' => 'materials/silabus-zoom-bimtek.pdf',
                'document_name' => 'Silabus-Bimtek-Pemasaran-KUR-2026.pdf',
                'quota' => 250,
                'remaining_quota' => 75,
                'cost_type' => 'daring',
                'status' => 'open',
                'has_certificate' => true,
                'certificate_title' => 'Sertifikasi Kompetensi Pemasaran Digital & Finansial Peternakan',
            ]
        );

        $t4 = Training::updateOrCreate(
            ['slug' => 'budidaya-unggas-air-hilirisasi-telur'],
            [
                'title' => 'Bimtek Agribisnis Bebek/Itik Petelur & Hilirisasi Telur Asin Masir',
                'description' => 'Tata kelola budidaya itik mojosari intensif, manajemen nutrisi ransum mandiri, dan teknik pengasapan telur asin bakar rempah berstandar mutu industri.',
                'instructor' => 'drh. Nur Cahyo, M.Vet & Ir. Bambang Supeno, MP',
                'instructor_title' => 'Tenaga Ahli Balai Pembibitan Ternak & Keswan Jatim',
                'start_date' => now()->subDays(10)->toDateString(),
                'end_date' => now()->subDays(9)->toDateString(),
                'time_info' => '08:30 - 15:30 WIB',
                'location' => 'Balai Diklat Pertanian & Peternakan Wilayah Nganjuk',
                'is_online' => false,
                'quota' => 40,
                'remaining_quota' => 12,
                'cost_type' => 'gratis_apbd',
                'status' => 'open',
                'has_certificate' => true,
                'certificate_title' => 'Sertifikasi Kompetensi Agribisnis Unggas Air & Hilirisasi Produk Telur Asin Jatim',
            ]
        );

        // PENDAFTARAN BIMTEK
        TrainingRegistration::updateOrCreate(
            ['training_id' => $t4->id, 'user_id' => $userRandy->id],
            [
                'registration_code' => 'REG-UNGGAS-2026-0049',
                'status' => 'confirmed',
                'registered_at' => now()->subDays(12),
                'notes' => 'Peserta asal Dusun Tiripan, Kec. Berbek, Nganjuk. Lulus uji kompetensi.',
            ]
        );

        TrainingRegistration::updateOrCreate(
            ['training_id' => $t3->id, 'user_id' => $userRandy->id],
            [
                'registration_code' => 'REG-ZOOM-2026-0188',
                'status' => 'confirmed',
                'registered_at' => now()->subDays(8),
            ]
        );

        TrainingRegistration::updateOrCreate(
            ['training_id' => $t1->id, 'user_id' => $userSlamet->id],
            [
                'registration_code' => 'REG-SILASE-2026-0024',
                'status' => 'confirmed',
                'registered_at' => now()->subDays(18),
            ]
        );

        TrainingRegistration::updateOrCreate(
            ['training_id' => $t3->id, 'user_id' => $userSlamet->id],
            [
                'registration_code' => 'REG-ZOOM-2026-0112',
                'status' => 'confirmed',
                'registered_at' => now()->subDays(8),
            ]
        );

        // Pendaftaran status PENDING (untuk demo Admin memverifikasi pendaftaran bimtek)
        TrainingRegistration::updateOrCreate(
            ['training_id' => $t2->id, 'user_id' => $userFauzan->id],
            [
                'registration_code' => 'REG-BIOSEK-2026-0091',
                'status' => 'pending',
                'registered_at' => now()->subHours(12),
                'notes' => 'Menunggu konfirmasi verifikasi dokumen administrasi oleh Admin Dinas.',
            ]
        );

        // MATERI PEMBELAJARAN (LMS), PROGRES BELAJAR & KUIS
        $m1 = LearningMaterial::firstOrCreate(
            ['slug' => 'teknologi-silase-hay-ternak'],
            [
                'title' => 'Teknologi Silase & Formulasi Hay Ternak Ruminansia',
                'description' => 'Panduan lengkap fermentasi hijauan pakan ternak (HPT) rumput odot & jagung secara anaerobik.',
                'category' => 'video_praktik',
                'topic' => 'Manajemen Pakan',
                'file_path' => 'materials/sop-formulasi-pakan.pdf',
                'file_size' => '3.8 MB',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'img/peternakan1.jpeg',
                'duration' => '24 Menit',
                'author_institution' => 'BBPP Batu & Disnak Jatim',
                'instructor_name' => 'Dr. Ir. Budi Santoso, M.Sc',
                'level' => 'Menengah',
                'downloads_count' => 540,
                'views_count' => 1580,
            ]
        );

        $m2 = LearningMaterial::firstOrCreate(
            ['slug' => 'video-pemerahan-higienis-menekan-tpc'],
            [
                'title' => 'SOP Pemerahan Higienis Menekan TPC & Standar Cold Chain',
                'description' => 'Tata cara sanitasi ambing, dipping puting pre & post milking, serta manajemen cooling tank.',
                'category' => 'video_praktik',
                'topic' => 'Produksi & Mutu Susu',
                'file_path' => 'materials/sop-formulasi-pakan.pdf',
                'file_size' => '4.2 MB',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'img/peternakan2.webp',
                'duration' => '18 Menit',
                'author_institution' => 'Dinas Peternakan Provinsi Jawa Timur',
                'instructor_name' => 'drh. Ratna Kusuma',
                'level' => 'Dasar',
                'downloads_count' => 920,
                'views_count' => 2240,
            ]
        );

        $m3 = LearningMaterial::firstOrCreate(
            ['slug' => 'manajemen-pemeliharaan-dan-nutrisi-itik-petelur-intensif'],
            [
                'title' => 'Manajemen Budidaya & Nutrisi Ransum Itik Petelur Intensif',
                'description' => 'SOP sanitasi kandang postal sekam, formula ransum tinggi protein, dan pencegahan snot/flu burung pada itik mojosari.',
                'category' => 'video_praktik',
                'topic' => 'Agribisnis Unggas Air',
                'file_path' => 'materials/sop-formulasi-pakan.pdf',
                'file_size' => '4.9 MB',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'img/peternakan1.jpeg',
                'duration' => '26 Menit',
                'author_institution' => 'Dinas Peternakan Jawa Timur & BPTU-HPT',
                'instructor_name' => 'drh. Nur Cahyo, M.Vet',
                'level' => 'Dasar',
                'downloads_count' => 780,
                'views_count' => 1930,
            ]
        );

        // Kuis untuk Materi Unggas (M3)
        $q3 = LearningQuiz::updateOrCreate(
            ['learning_material_id' => $m3->id],
            [
                'title' => 'Evaluasi Kompetensi: Agribisnis & Nutrisi Itik Petelur Modern',
                'description' => 'Uji pemahaman mandiri mengenai kadar protein ransum, biosekuriti kandang itik, dan penanganan telur segar.',
                'passing_score' => 70,
                'time_limit_minutes' => 15,
                'is_active' => true,
            ]
        );

        QuizQuestion::firstOrCreate(
            ['learning_quiz_id' => $q3->id, 'order' => 1],
            [
                'question' => 'Berapa kadar protein kasar (Crude Protein) yang ideal untuk pakan itik petelur fase produksi aktif?',
                'option_a' => '10% - 12%',
                'option_b' => '18% - 20%',
                'option_c' => '28% - 32%',
                'option_d' => 'Kurang dari 8%',
                'correct_answer' => 'b',
                'explanation' => 'Kebutuhan protein kasar untuk itik petelur periode layer adalah 18-20% guna menopang laju bertelur harian di atas 80%.',
            ]
        );

        QuizQuestion::firstOrCreate(
            ['learning_quiz_id' => $q3->id, 'order' => 2],
            [
                'question' => 'Tindakan utama untuk mencegah penularan penyakit Infectious Coryza (Snot) pada kandang itik adalah...',
                'option_a' => 'Membiarkan alas kandang selalu basah berlumpur',
                'option_b' => 'Menjaga sekam kandang tetap kering, ventilasi cukup, dan sanitasi berkala',
                'option_c' => 'Menutup rapat seluruh sirkulasi udara kandang 24 jam',
                'option_d' => 'Mengurangi jatah air minum itik',
                'correct_answer' => 'b',
                'explanation' => 'Sirkulasi udara lancar dan alas kandang kering mencegah kelembapan amonia tinggi pemicu radang pernapasan unggas.',
            ]
        );

        // Progres Belajar Randy Zidan (100% Selesai & Lulus Kuis)
        UserLearningProgress::updateOrCreate(
            ['user_id' => $userRandy->id, 'learning_material_id' => $m3->id],
            [
                'is_watched' => true,
                'watch_percentage' => 100,
                'last_watched_at' => now()->subDays(5),
            ]
        );

        QuizAttempt::updateOrCreate(
            ['learning_quiz_id' => $q3->id, 'user_id' => $userRandy->id],
            [
                'score' => 100,
                'total_questions' => 2,
                'correct_answers_count' => 2,
                'user_answers' => ['1' => 'b', '2' => 'b'],
                'passed' => true,
                'completed_at' => now()->subDays(5),
            ]
        );

        // E-SERTIFIKAT RESMI RANDY ZIDAN
        Certificate::updateOrCreate(
            ['certificate_number' => 'DISNAK-JATIM/2026/CERT-UNGGAS-049'],
            [
                'user_id' => $userRandy->id,
                'training_id' => $t4->id,
                'recipient_name' => 'Randy Zidan',
                'recipient_code' => '3578052209800026',
                'title' => 'Sertifikasi Kompetensi Agribisnis Unggas Air & Hilirisasi Produk Telur Asin Jatim',
                'issued_date' => now()->subDays(8)->toDateString(),
                'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
            ]
        );

        // E-SERTIFIKAT RESMI SLAMET RAHARDJO
        Certificate::updateOrCreate(
            ['certificate_number' => 'DISNAK-JATIM/2026/CERT-891'],
            [
                'user_id' => $userSlamet->id,
                'training_id' => $t1->id,
                'recipient_name' => 'Slamet Rahardjo',
                'recipient_code' => '3514081203760001',
                'title' => 'Sertifikasi Formulasi Pakan Ransum & Silase Modern',
                'issued_date' => now()->subDays(12)->toDateString(),
                'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
            ]
        );

        // -------------------------------------------------------------
        // 8. PAMERAN & KALENDER TERPADU (EXHIBITIONS & CALENDAR)
        // -------------------------------------------------------------
        $expo1 = Exhibition::firstOrCreate(
            ['slug' => 'jatim-dairy-livestock-expo-2026'],
            [
                'title' => 'Jatim Dairy & Livestock Expo 2026',
                'description' => 'Pameran teknologi budidaya ternak modern, lelang bibit unggul, temu bisnis buyer industri, dan festival produk olahan pangan asal hewan Jawa Timur.',
                'facilities' => 'Booth Stand 3x3m, Meja Display Kaca, Daya Listrik dan Chiller, Business Matching Buyer Modern, Sertifikat Resmi Disnak Jatim',
                'start_date' => now()->addDays(14)->toDateString(),
                'end_date' => now()->addDays(16)->toDateString(),
                'location' => 'Grand City Convex, Kota Surabaya',
                'stand_capacity' => 120,
                'registered_stands_count' => 96,
                'is_featured' => true,
            ]
        );

        $expo2 = Exhibition::firstOrCreate(
            ['slug' => 'agribisnis-fest-ternak-milenial-2026'],
            [
                'title' => 'Agribisnis Fest & Gelar Karya Peternak Milenial Jatim 2026',
                'description' => 'Ajang pameran etalase produk inovatif peternak muda se-Jawa Timur terintegrasi dengan pembiayaan perbankan dan investor agrikultur.',
                'facilities' => 'Stand Display 2x2m, Fasilitas Cold Storage Bersama, Liputan Media Massa, Free Workshop Pemasaran Digital',
                'start_date' => now()->addDays(28)->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'location' => 'Balaikota Among Tani, Kota Batu',
                'stand_capacity' => 60,
                'registered_stands_count' => 42,
                'is_featured' => true,
            ]
        );

        // Pendaftaran Stand Slamet Rahardjo (Disetujui)
        ExhibitionRegistration::updateOrCreate(
            ['exhibition_id' => $expo1->id, 'user_id' => $userSlamet->id],
            [
                'business_name' => 'Kelompok Peternak Sapi Perah Barokah Pandaan',
                'exhibited_products' => 'Susu Pasteurisasi Cold Chain, Keju Mozzarella Artisan, dan Pupuk Organik Bio-Slurry',
                'status' => 'approved',
                'stand_number' => 'B-14',
                'notes' => 'Stand Binaan Unggulan Dinas Peternakan Prov. Jatim',
            ]
        );

        // Pendaftaran Stand Randy Zidan (Disetujui)
        ExhibitionRegistration::updateOrCreate(
            ['exhibition_id' => $expo1->id, 'user_id' => $userRandy->id],
            [
                'business_name' => 'Peternakan Bebek Milenial Berkah Tiripan Nganjuk',
                'exhibited_products' => 'Telur Bebek Asin Bakar Rempah, Telur Bebek Segar Grade A, dan Olahan Bebek Karkas',
                'status' => 'approved',
                'stand_number' => 'C-07',
                'notes' => 'Kategori Produk Olahan Pangan Inovatif Daerah Nganjuk',
            ]
        );

        // Pendaftaran Stand Ahmad Fauzan (PENDING - untuk demo Admin menyetujui pendaftaran stand pameran)
        ExhibitionRegistration::updateOrCreate(
            ['exhibition_id' => $expo1->id, 'user_id' => $userFauzan->id],
            [
                'business_name' => 'Kandang Milenial Singosari Mandiri',
                'exhibited_products' => 'Daging Sapi Segar ASUH & Bibit Domba Dorper F2',
                'status' => 'pending',
                'stand_number' => 'A-09',
                'notes' => 'Menunggu verifikasi alokasi daya chiller listrik oleh panitia.',
            ]
        );

        // Agenda Kalender Kegiatan
        CalendarEvent::updateOrCreate(
            ['title' => 'Vaksinasi Massal PMK & LSD Serentak Jawa Timur'],
            [
                'event_type' => 'vaksinasi',
                'event_date' => now()->addDays(3)->toDateString(),
                'time_info' => '08:00 WIB - Selesai',
                'location' => 'Serentak Seluruh Puskeswan Kab/Kota Jawa Timur',
                'region_id' => $regions['pasuruan']->id,
                'is_mandatory' => true,
                'description' => 'Layanan jemput bola vaksinasi massal gratis booster PMK dan LSD bagi seluruh kelompok ternak rakyat.',
            ]
        );

        CalendarEvent::updateOrCreate(
            ['title' => 'Gelar Praktik Pembuatan Silase Jerami & Fermentasi BBPP Batu'],
            [
                'event_type' => 'pelatihan',
                'event_date' => now()->addDays(7)->toDateString(),
                'time_info' => '09:00 - 15:00 WIB',
                'location' => 'Laboratorium Pakan BBPP Songgoriti, Kota Batu',
                'region_id' => $regions['batu']->id,
                'is_mandatory' => false,
                'description' => 'Bimtek langsung teknik pencacahan dan penyimpanan silase drum anaerobik untuk cadangan pakan musim kemarau.',
            ]
        );

        CalendarEvent::updateOrCreate(
            ['title' => 'Temu Bisnis Buyer & Fasilitasi KUR Bank Jatim untuk Peternak'],
            [
                'event_type' => 'pameran',
                'event_date' => now()->addDays(12)->toDateString(),
                'time_info' => '10:00 - 16:00 WIB',
                'location' => 'Ballroom Grand City Surabaya',
                'region_id' => $regions['surabaya']->id,
                'is_mandatory' => false,
                'description' => 'Fasilitasi penandatanganan kontrak suplai susu dan telur ke hotel, restoran, katering (HOREKA) serta pengajuan KUR bunga ringan.',
            ]
        );

        // -------------------------------------------------------------
        // 9. PELAPORAN DARURAT & MITIGASI BENCANA
        // -------------------------------------------------------------
        $emReport1 = EmergencyReport::updateOrCreate(
            ['report_code' => 'EM-2026-081'],
            [
                'user_id' => $userSlamet->id,
                'region_id' => $regions['pasuruan']->id,
                'incident_type' => 'wabah',
                'livestock_type' => 'sapi_perah',
                'affected_count' => 4,
                'location_address' => 'Desa Durensewu, Kec. Pandaan, Kab. Pasuruan (-7.6521, 112.6983)',
                'latitude' => -7.6521,
                'longitude' => 112.6983,
                'description' => 'Sapi perah lesu sejak kemarin sore, demam tinggi 39.8°C, produksi susu anjlok.',
                'status' => 'in_progress',
                'officer_notes' => 'Petugas telah tiba di lokasi. Dilakukan isolasi kandang dan terapi antipiretik.',
                'assigned_officer_id' => $drhRatna->id,
                'officer_phone' => '08001347625',
                'verified_at' => now()->subHours(4),
            ]
        );

        EmergencyReportLog::firstOrCreate(
            ['emergency_report_id' => $emReport1->id, 'status' => 'received'],
            [
                'officer_id' => null,
                'note' => 'Laporan masuk dari peternak via sistem',
                'logged_at' => now()->subHours(5),
            ]
        );

        EmergencyReportLog::firstOrCreate(
            ['emergency_report_id' => $emReport1->id, 'status' => 'verified'],
            [
                'officer_id' => $admin->id,
                'note' => 'Diverifikasi oleh tim siaga darurat Disnak Prov. Jatim',
                'logged_at' => now()->subHours(4),
            ]
        );

        EmergencyReportLog::firstOrCreate(
            ['emergency_report_id' => $emReport1->id, 'status' => 'in_progress'],
            [
                'officer_id' => $drhRatna->id,
                'note' => 'drh. Ratna dan tim Puskeswan tiba di kandang peternak',
                'logged_at' => now()->subHours(2),
            ]
        );

        // Laporan Darurat 2: Waspada Wabah Unggas Nganjuk (Diverifikasi)
        $emReport2 = EmergencyReport::updateOrCreate(
            ['report_code' => 'EM-2026-094'],
            [
                'user_id' => $userRandy->id,
                'region_id' => $regions['nganjuk']->id,
                'incident_type' => 'wabah',
                'livestock_type' => 'unggas',
                'affected_count' => 8,
                'location_address' => 'Dusun Tiripan, Kec. Berbek, Kab. Nganjuk',
                'latitude' => -7.6432,
                'longitude' => 111.9056,
                'description' => 'Unggas bersin massal dan kelesuan pasca hujan lebat berkelanjutan.',
                'status' => 'verified',
                'officer_notes' => 'Laporan telah diverifikasi admin. Ditugaskan kepada drh. Nur Cahyo, M.Vet untuk penanganan lapangan.',
                'assigned_officer_id' => $drhNurCahyo->id,
                'officer_phone' => '081399887766',
                'verified_at' => now()->subHours(3),
            ]
        );

        EmergencyReportLog::firstOrCreate(
            ['emergency_report_id' => $emReport2->id, 'status' => 'received'],
            [
                'officer_id' => null,
                'note' => 'Laporan masuk dari peternak Randy Zidan',
                'logged_at' => now()->subHours(4),
            ]
        );

        EmergencyReportLog::firstOrCreate(
            ['emergency_report_id' => $emReport2->id, 'status' => 'verified'],
            [
                'officer_id' => $admin->id,
                'note' => 'Diverifikasi admin dan diteruskan ke drh. Nur Cahyo',
                'logged_at' => now()->subHours(3),
            ]
        );

        // Laporan Darurat 3: Laporan Baru Masuk (STATUS RECEIVED - Untuk demo Admin memverifikasi laporan darurat)
        EmergencyReport::updateOrCreate(
            ['report_code' => 'EM-2026-105'],
            [
                'user_id' => $userFauzan->id,
                'region_id' => $regions['tuban']->id,
                'incident_type' => 'wabah',
                'livestock_type' => 'sapi_potong',
                'affected_count' => 3,
                'location_address' => 'Desa Sugihwaras, Kec. Jenu, Kab. Tuban',
                'latitude' => -6.8972,
                'longitude' => 112.0649,
                'description' => 'Sapi potong PO mengalami kelesuan dan keluar air liur berbusa saat siang hari.',
                'status' => 'received', // PENDING VERIFIKASI ADMIN!
            ]
        );

        // -------------------------------------------------------------
        // 10. HARGA KOMODITAS TERBARU & SENTRA PRODUKSI
        // -------------------------------------------------------------
        $commSusu = Commodity::firstOrCreate(['slug' => 'susu-sapi-segar'], ['name' => 'Susu Sapi Segar', 'unit' => 'Liter']);
        $commDaging = Commodity::firstOrCreate(['slug' => 'daging-sapi-murni'], ['name' => 'Daging Sapi Murni', 'unit' => 'Kilogram']);
        $commAyam = Commodity::firstOrCreate(['slug' => 'daging-ayam-ras'], ['name' => 'Daging Ayam Ras', 'unit' => 'Kilogram']);
        $commTelur = Commodity::firstOrCreate(['slug' => 'telur-ayam-ras'], ['name' => 'Telur Ayam Ras', 'unit' => 'Kilogram']);
        $commTelurBebek = Commodity::firstOrCreate(['slug' => 'telur-bebek-segar'], ['name' => 'Telur Bebek Segar', 'unit' => 'Butir']);
        $commJagung = Commodity::firstOrCreate(['slug' => 'jagung-pakan-pipil'], ['name' => 'Jagung Pakan Pipil', 'unit' => 'Kilogram']);

        $prices = [
            ['comm' => $commSusu, 'region' => $regions['pasuruan'], 'f_price' => 7450, 'c_price' => 9500, 'chg' => 250, 'pct' => 3.4, 'status' => 'stabil', 'src' => 'KUD Pasuruan & Pasar Induk'],
            ['comm' => $commDaging, 'region' => $regions['tuban'], 'f_price' => 128500, 'c_price' => 135000, 'chg' => 0, 'pct' => 0.0, 'status' => 'stabil', 'src' => 'Pasar Hewan Tuban'],
            ['comm' => $commAyam, 'region' => $regions['blitar'], 'f_price' => 23400, 'c_price' => 34500, 'chg' => 400, 'pct' => 1.7, 'status' => 'stabil', 'src' => 'PINSAR Unggas Blitar'],
            ['comm' => $commTelur, 'region' => $regions['blitar'], 'f_price' => 25200, 'c_price' => 27000, 'chg' => 400, 'pct' => 1.6, 'status' => 'stabil', 'src' => 'Koperasi Peternak Unggas Blitar'],
            ['comm' => $commTelurBebek, 'region' => $regions['nganjuk'], 'f_price' => 2350, 'c_price' => 2800, 'chg' => 50, 'pct' => 2.1, 'status' => 'stabil', 'src' => 'Asosiasi Peternak Itik Nganjuk & Kediri'],
            ['comm' => $commJagung, 'region' => $regions['bojonegoro'], 'f_price' => 5100, 'c_price' => 5400, 'chg' => 100, 'pct' => 1.9, 'status' => 'stabil', 'src' => 'Pasar Agrobis Bojonegoro'],
        ];

        foreach ($prices as $p) {
            CommodityPrice::updateOrCreate(
                [
                    'commodity_id' => $p['comm']->id,
                    'region_id' => $p['region']->id,
                    'recorded_date' => now()->toDateString(),
                ],
                [
                    'farmer_price' => $p['f_price'],
                    'consumer_price' => $p['c_price'],
                    'price_change_7d' => $p['chg'],
                    'price_change_percentage' => $p['pct'],
                    'status' => $p['status'],
                    'source' => $p['src'],
                    'recorded_by' => $admin->id,
                ]
            );
        }

        // Sentra Budidaya Unggas Air Nganjuk
        ProductionCenter::firstOrCreate(
            ['name' => 'Sentra Budidaya Bebek & Itik Petelur Nganjuk'],
            [
                'region_id' => $regions['nganjuk']->id,
                'commodity_id' => $commTelurBebek->id,
                'description' => 'Sentra agribisnis itik mojosari terpadu, penetasan bibit DOD unggul, dan industri hilirisasi telur asin bakar khas Berbek Nganjuk.',
                'livestock_population' => 465000,
                'latitude' => -7.6041,
                'longitude' => 111.9015,
                'is_featured' => true,
            ]
        );

        // -------------------------------------------------------------
        // 11. BERSIHKAN CACHE APLIKASI
        // -------------------------------------------------------------
        Cache::forget('dashboard_public_metrics_v1');
    }
}

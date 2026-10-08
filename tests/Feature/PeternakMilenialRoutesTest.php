<?php

use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\EmergencyReport;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\HealthRecord;
use App\Models\Livestock;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('landing page renders as initial route with cta and login buttons', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Pemberdayaan Digital');
    $response->assertSee('Peternak Muda');
    $response->assertSee('nav-login-btn', false);
    $response->assertSee('nav-masuk-btn', false);
    $response->assertSee('hero-masuk-btn', false);
    $response->assertSee('hero-daftar-btn', false);
    $response->assertSee('Dinas Peternakan Provinsi Jawa Timur');
    $response->assertSee(route('login'));
    $response->assertSee(route('register'));
});

test('landing page displays dashboard shortcut when authenticated', function () {
    $user = User::first();

    $response = $this->actingAs($user)->get(route('landing'));

    $response->assertStatus(200);
    $response->assertSee('Buka Dashboard');
    $response->assertSee(route('dashboard'));
});

test('dashboard page renders successfully', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Peternak');
    $response->assertSee('Dinas Peternakan Provinsi Jawa Timur');
});

test('dashboard user count reflects exact dynamic registered accounts in database', function () {
    $initialCount = User::where('is_active', true)->count();

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
    $response->assertSee('id="total-user-count"', false);
    $response->assertSee((string) $initialCount);

    // Register a brand new user via registration submission
    $newEmail = 'peternak.dinamis.'.time().'@peternak.id';
    $this->post(route('register.submit'), [
        'name' => 'Peternak Realtime Baru',
        'email' => $newEmail,
        'phone_number' => '081234567899',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    expect(User::where('is_active', true)->count())->toBe($initialCount + 1);

    // Verify dashboard immediately reflects incremented count
    $afterRegisterResponse = $this->get(route('dashboard'));
    $afterRegisterResponse->assertSee((string) ($initialCount + 1));

    // Deactivate user and verify immediate decrease
    $newUser = User::where('email', $newEmail)->first();
    $newUser->update(['is_active' => false]);

    $afterDeactivateResponse = $this->get(route('dashboard'));
    $afterDeactivateResponse->assertSee((string) $initialCount);
});

test('pelatihan page renders successfully', function () {
    $response = $this->get(route('pelatihan'));

    $response->assertStatus(200);
    $response->assertSee('Pelatihan', false);
    $response->assertSee('Bimbingan Teknis', false);
});

test('marketplace page renders successfully', function () {
    $response = $this->get(route('marketplace'));

    $response->assertStatus(200);
    $response->assertSee('Marketplace Peternak Milenial');
});

test('harga komoditas page renders successfully', function () {
    $response = $this->get(route('harga-komoditas'));

    $response->assertStatus(200);
    $response->assertSee('Harga Komoditas', false);
    $response->assertSee('Sentra Produksi', false);
});

test('harga komoditas tabs render successfully according to active tab', function () {
    $respTren = $this->get(route('harga-komoditas', ['tab' => 'tren']));
    $respTren->assertStatus(200);
    $respTren->assertSee('Tren Harga Komoditas');
    $respTren->assertSee('Daftar Pantauan Harga Pasar');

    $respSentra = $this->get(route('harga-komoditas', ['tab' => 'sentra']));
    $respSentra->assertStatus(200);
    $respSentra->assertSee('Sentra Produksi Ternak');
    $respSentra->assertSee('Sentra Produksi Peternakan Jawa Timur');

    $respUnggulan = $this->get(route('harga-komoditas', ['tab' => 'unggulan']));
    $respUnggulan->assertStatus(200);
    $respUnggulan->assertSee('Komoditas Unggulan');
    $respUnggulan->assertSee('Daftar Komoditas Unggulan Jawa Timur');
});

test('layanan darurat page renders successfully', function () {
    $response = $this->get(route('darurat'));

    $response->assertStatus(200);
    $response->assertSee('Pelaporan Darurat', false);
    $response->assertSee('Kesejahteraan Hewan', false);
});

test('konsultasi dokter page renders successfully', function () {
    $response = $this->get(route('konsultasi'));

    $response->assertStatus(200);
    $response->assertSee('Konsultasi', false);
    $response->assertSee('Kesehatan Hewan', false);

    $this->get(route('konsultasi', ['tab' => 'rekam_medis']))
        ->assertStatus(200)
        ->assertSee('Rekam Medis &amp; E-Tag Ternak', false);

    $this->get(route('konsultasi', ['tab' => 'penyakit']))
        ->assertStatus(200)
        ->assertSee('Pedoman Penyakit Hewan', false);
});

test('pameran page renders successfully', function () {
    $response = $this->get(route('pameran'));

    $response->assertStatus(200);
    $response->assertSee('Pameran', false);
    $response->assertSee('Kalender Terpadu', false);

    $this->get(route('pameran', ['tab' => 'stand']))
        ->assertStatus(200)
        ->assertSee('Daftar Stand &amp; Pengajuan Peserta', false);

    $this->get(route('pameran', ['tab' => 'kalender']))
        ->assertStatus(200)
        ->assertSee('Kalender Terpadu Kegiatan', false);
});

test('flowbite dashboard includes poppins and layout controls', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Poppins');
    $response->assertDontSee('id="theme-toggle"', false);
    $response->assertSee('data-drawer-target="top-bar-sidebar"', false);
    $response->assertSee('data-drawer-toggle="top-bar-sidebar"', false);
    $response->assertSee('id="top-bar-sidebar"', false);
    $response->assertSee('id="main-content"', false);
    $response->assertSee('sm:ml-64');
    $response->assertSee('mt-14');
    $response->assertSee('id="dropdown-user"', false);
    $response->assertSee('id="sidebar-backdrop"', false);
    $response->assertSee('id="emergency-modal"', false);
});

test('dashboard has collapsible sidebar controls, kpi cards, and charts', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Dashboard');
    $response->assertSee('Dashboard Peternakan Provinsi Jawa Timur');
    $response->assertSee('id="desktop-sidebar-toggle"', false);
    $response->assertSee('id="masp"', false);
    $response->assertSee('MASP');
    $response->assertSee('id="masp-map-frame"', false);
    $response->assertSee('Pelaku Usaha Ternak');
    $response->assertSee('Produktivitas Hasil');
    $response->assertSee('Struktur Komoditas');
    $response->assertSee('MASP');
    $response->assertSee('id="chart-distribusi-ternak"', false);
    $response->assertSee('chart-produksi-komoditas', false);
    $response->assertSee('API Disnak Jatim');
    $response->assertSee('Ayam Ras Pedaging');
    $response->assertSee('Sapi Potong');
    $response->assertSee('Telur Ayam Ras');
    $response->assertSee('Susu Sapi Segar');
});

test('east java peternakan statistics api endpoint returns valid official data', function () {
    $response = $this->get(route('api.statistik-peternakan'));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'status',
        'source' => [
            'institution',
            'portal',
            'reference',
            'verified_at',
        ],
        'summary' => [
            'total_livestock_population',
            'display_total_population',
            'daily_total_production_ton',
            'display_daily_production',
            'national_rank',
        ],
        'populasi' => [
            'title',
            'unit',
            'categories',
            'data',
            'raw_data',
            'formatted_labels',
        ],
        'produksi' => [
            'title',
            'unit',
            'categories',
            'data',
            'annual_data',
            'formatted_labels',
        ],
    ]);

    $data = $response->json();
    expect($data['status'])->toBe('success')
        ->and($data['source']['institution'])->toContain('Dinas Peternakan Provinsi Jawa Timur')
        ->and($data['populasi']['categories'])->toContain('Sapi Potong')
        ->and($data['populasi']['categories'])->toContain('Ayam Ras Pedaging')
        ->and($data['produksi']['categories'])->toContain('Telur Ayam Ras')
        ->and($data['produksi']['categories'])->toContain('Susu Sapi Segar')
        ->and($data['summary']['daily_total_production_ton'])->toBeGreaterThan(1000);
});

test('east java sentra peternakan masp api endpoint returns official government data', function () {
    $response = $this->get(route('api.sentra-peternakan'));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'status',
        'source' => [
            'institution',
            'portal',
            'program',
            'reference',
            'verified_at',
        ],
        'total_sentra',
        'items' => [
            '*' => [
                'id',
                'key',
                'name',
                'kawasan',
                'kabupaten',
                'komoditas',
                'komoditas_icon',
                'subsektor',
                'populasi',
                'populasi_formatted',
                'kelompok_binaan',
                'latitude',
                'longitude',
                'deskripsi',
                'status_unggulan',
                'produksi_harian',
                'maps_query',
                'zoom',
            ],
        ],
    ]);

    $data = $response->json();
    expect($data['status'])->toBe('success')
        ->and($data['source']['institution'])->toContain('Dinas Peternakan Provinsi Jawa Timur')
        ->and($data['source']['program'])->toContain('MASP')
        ->and($data['total_sentra'])->toBe(10);

    // Verify key livestock hubs in East Java are present
    $hubNames = collect($data['items'])->pluck('name')->implode(' ');
    expect($hubNames)->toContain('Pasuruan')
        ->and($hubNames)->toContain('Blitar')
        ->and($hubNames)->toContain('Tuban')
        ->and($hubNames)->toContain('Malang')
        ->and($hubNames)->toContain('Bojonegoro')
        ->and($hubNames)->toContain('Lumajang');

    // Verify dashboard displays API Sentra Jatim shortcut button
    $dashboardResponse = $this->get(route('dashboard'));
    $dashboardResponse->assertStatus(200);
    $dashboardResponse->assertSee(route('api.sentra-peternakan'));
    $dashboardResponse->assertSee('API Sentra Jatim');
});

test('emergency report can be created, updated status, and deleted', function () {
    $postData = [
        'incident_type' => 'wabah',
        'livestock_type' => 'sapi_perah',
        'affected_count' => 5,
        'location_address' => 'Kec. Pujon, Kab. Malang',
        'description' => 'Demam tinggi dan lepuh pada mulut serta kuku',
    ];

    $response = $this->post(route('darurat.store'), $postData);
    $response->assertRedirect(route('darurat'));
    $response->assertSessionHas('success');

    $report = EmergencyReport::where('location_address', 'Kec. Pujon, Kab. Malang')->first();
    expect($report)->not->toBeNull();
    expect($report->livestock_type)->toBe('sapi_perah');

    // Update status
    $updateResponse = $this->patch(route('darurat.status', $report), [
        'status' => 'in_progress',
        'officer_notes' => 'Petugas medikvet telah meluncur ke lokasi',
    ]);
    $updateResponse->assertRedirect(route('darurat'));
    $report->refresh();
    expect($report->status)->toBe('in_progress');

    // Delete
    $deleteResponse = $this->delete(route('darurat.destroy', $report));
    $deleteResponse->assertRedirect(route('darurat'));
    expect(EmergencyReport::find($report->id))->toBeNull();
});

test('peternak can register and cancel training registration', function () {
    $training = Training::create([
        'title' => 'Bimtek Pakan Silase Baru',
        'slug' => 'bimtek-pakan-silase-baru',
        'description' => 'Pelatihan silase',
        'instructor' => 'Dr. Ir. Budi',
        'start_date' => now()->addDays(2),
        'end_date' => now()->addDays(3),
        'location' => 'Malang',
        'quota' => 20,
        'remaining_quota' => 20,
        'cost_type' => 'gratis_apbd',
        'status' => 'open',
    ]);
    $initialQuota = $training->remaining_quota;

    // Register
    $response = $this->post(route('pelatihan.register', $training));
    $response->assertRedirect(route('pelatihan'));
    $response->assertSessionHas('success');

    $training->refresh();
    expect($training->remaining_quota)->toBe($initialQuota - 1);

    $registration = TrainingRegistration::where('training_id', $training->id)->latest('id')->first();
    expect($registration)->not->toBeNull();

    // Cancel registration
    $cancelResponse = $this->delete(route('pelatihan.cancel', $registration));
    $cancelResponse->assertRedirect(route('pelatihan'));
    $cancelResponse->assertSessionHas('success');

    $training->refresh();
    expect($training->remaining_quota)->toBe($initialQuota);
    expect(TrainingRegistration::find($registration->id))->toBeNull();
});

test('admin can create and delete training program', function () {
    $data = [
        'title' => 'Bimtek Teknologi Fermentasi Pakan Modern',
        'description' => 'Pelatihan fermentasi pakan silase untuk peternak milenial.',
        'instructor' => 'Dr. Ir. Bambang Sutrisno, M.Sc',
        'start_date' => now()->addDays(5)->format('Y-m-d'),
        'end_date' => now()->addDays(6)->format('Y-m-d'),
        'time_info' => '08:00 - 15:00 WIB',
        'location' => 'Balai Benih Tuban',
        'quota' => 40,
        'cost_type' => 'gratis_apbd',
    ];

    $response = $this->post(route('pelatihan.store'), $data);
    $response->assertRedirect(route('pelatihan'));
    $response->assertSessionHas('success');

    $created = Training::where('title', 'Bimtek Teknologi Fermentasi Pakan Modern')->first();
    expect($created)->not->toBeNull();

    // Delete
    $del = $this->delete(route('pelatihan.destroy', $created));
    $del->assertRedirect(route('pelatihan'));
    expect(Training::find($created->id))->toBeNull();
});

test('marketplace allows adding products, buying products, and updating orders', function () {
    $category = ProductCategory::first();
    $region = Region::first();

    // Add product
    $prodData = [
        'name' => 'Susu Kambing Organik Super',
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'price' => 35000,
        'stock' => 50,
        'unit' => 'Liter',
        'description' => 'Susu kambing etawa segar higienis tanpa bahan pengawet.',
    ];

    $response = $this->post(route('marketplace.products.store'), $prodData);
    $response->assertRedirect(route('marketplace'));
    $response->assertSessionHas('success');

    $product = Product::where('name', 'Susu Kambing Organik Super')->first();
    expect($product)->not->toBeNull();
    expect((float) $product->price)->toBe(35000.0);

    // Buy product
    $buyResponse = $this->post(route('marketplace.products.buy', $product), [
        'quantity' => 5,
        'buyer_name' => 'Rini Astuti',
        'buyer_phone' => '08987654321',
        'shipping_address' => 'Jl. Ijen No. 12, Malang',
    ]);
    $buyResponse->assertRedirect(route('marketplace'));
    $buyResponse->assertSessionHas('success');

    $product->refresh();
    expect($product->stock)->toBe(45);

    $order = Order::where('buyer_phone', '08987654321')->latest('id')->first();
    expect($order)->not->toBeNull();
    expect((float) $order->total_amount)->toBe(175000.0);

    // Update order status
    $updateOrder = $this->patch(route('marketplace.orders.status', $order), [
        'status' => 'completed',
    ]);
    $updateOrder->assertRedirect(route('marketplace'));
    $order->refresh();
    expect($order->status)->toBe('completed');
});

test('commodity price can be submitted and saved to database', function () {
    $commodity = Commodity::first();
    $region = Region::first();

    $priceData = [
        'commodity_id' => $commodity->id,
        'region_id' => $region->id,
        'farmer_price' => 52000,
        'consumer_price' => 58000,
    ];

    $response = $this->post(route('harga-komoditas.store'), $priceData);
    $response->assertRedirect(route('harga-komoditas'));
    $response->assertSessionHas('success');

    $record = CommodityPrice::where('region_id', $region->id)
        ->where('commodity_id', $commodity->id)
        ->latest('id')
        ->first();
    expect($record)->not->toBeNull();
    expect((int) $record->farmer_price)->toBe(52000);
});

test('consultation message and animal health checkup can be stored', function () {
    $consultation = Consultation::first();

    // Send chat message
    $msgResponse = $this->post(route('konsultasi.message', $consultation), [
        'message' => 'Dok, nafsu makan sapi saya berkurang drastis sejak 2 hari lalu.',
    ]);
    $msgResponse->assertRedirect(route('konsultasi'));
    $msgResponse->assertSessionHas('success');

    $msg = ConsultationMessage::where('message', 'Dok, nafsu makan sapi saya berkurang drastis sejak 2 hari lalu.')->first();
    expect($msg)->not->toBeNull();

    // Add health record
    $livestock = Livestock::first();
    $healthData = [
        'livestock_id' => $livestock->id,
        'record_type' => 'pemeriksaan',
        'title' => 'Pemeriksaan Rutin Ternak Sehat',
        'diagnosis' => 'Kondisi fisik prima, nafsu makan normal',
        'treatment' => 'Pemberian vitamin B kompleks & mineral',
        'record_date' => now()->format('Y-m-d'),
    ];

    $healthResponse = $this->post(route('konsultasi.health-record.store'), $healthData);
    $healthResponse->assertRedirect(route('konsultasi'));
    $healthResponse->assertSessionHas('success');

    $record = HealthRecord::where('title', 'Pemeriksaan Rutin Ternak Sehat')->first();
    expect($record)->not->toBeNull();

    // Register livestock e-tag
    $etagResponse = $this->post(route('konsultasi.livestock.store'), [
        'tag_number' => 'ETAG-JTM-777',
        'livestock_type' => 'sapi_potong',
        'breed' => 'Limousin Cross',
        'gender' => 'jantan',
        'birth_date' => '2023-01-10',
    ]);
    $etagResponse->assertRedirect(route('konsultasi'));
    $etagResponse->assertSessionHas('success');

    $newLivestock = Livestock::where('e_tag_number', 'ETAG-JTM-777')->first();
    expect($newLivestock)->not->toBeNull();
});

test('admin can add, update, and delete veterinarian', function () {
    $admin = User::where('role', 'admin')->first();

    // 1. Admin adds new veterinarian
    $storeResponse = $this->actingAs($admin)->post(route('konsultasi.veterinarians.store'), [
        'name' => 'drh. Kusumo Wardoyo, M.Si',
        'specialization' => 'Spesialis Bedah Ternak Ruminansia',
        'puskeswan' => 'Puskeswan Mojosari, Kab. Mojokerto',
        'strv_number' => 'STRV-35.16.2026.009',
        'phone_number' => '081299887766',
        'email' => 'kusumo@disnak.jatimprov.go.id',
        'status' => 'online',
        'consultation_hours' => '08.00 - 16.00 WIB',
    ]);

    $storeResponse->assertRedirect(route('konsultasi', ['tab' => 'dokter']));
    $storeResponse->assertSessionHas('success');

    $vet = Veterinarian::where('name', 'drh. Kusumo Wardoyo, M.Si')->first();
    expect($vet)->not->toBeNull();
    expect($vet->specialization)->toBe('Spesialis Bedah Ternak Ruminansia');

    // 2. Admin updates veterinarian
    $updateResponse = $this->actingAs($admin)->put(route('konsultasi.veterinarians.update', $vet), [
        'name' => 'drh. Kusumo Wardoyo, Ph.D',
        'specialization' => 'Spesialis Bedah & Patologi Ternak',
        'puskeswan' => 'Puskeswan Mojosari, Kab. Mojokerto',
        'strv_number' => 'STRV-35.16.2026.009',
        'phone_number' => '081299887766',
        'email' => 'kusumo.phd@disnak.jatimprov.go.id',
        'status' => 'praktik_lapangan',
        'consultation_hours' => '09.00 - 15.00 WIB',
    ]);

    $updateResponse->assertRedirect(route('konsultasi', ['tab' => 'dokter']));
    expect($vet->fresh()->name)->toBe('drh. Kusumo Wardoyo, Ph.D');
    expect($vet->fresh()->status)->toBe('praktik_lapangan');

    // 3. Admin deletes veterinarian
    $deleteResponse = $this->actingAs($admin)->delete(route('konsultasi.veterinarians.destroy', $vet));
    $deleteResponse->assertRedirect(route('konsultasi', ['tab' => 'dokter']));
    expect(Veterinarian::where('id', $vet->id)->exists())->toBeFalse();
});

test('peternak can view veterinarians but is forbidden from mutating veterinarians', function () {
    $peternak = User::where('role', 'peternak')->first();

    // View consultation page
    $response = $this->actingAs($peternak)->get(route('konsultasi'));
    $response->assertOk();
    $response->assertSee('Dokter Hewan Jaga &amp; Telemedisin', false);
    $response->assertSee('drh. Ratna Kusuma');

    // Forbidden from adding
    $this->actingAs($peternak)->post(route('konsultasi.veterinarians.store'), [
        'name' => 'drh. Ilegal',
        'specialization' => 'Spesialis Palsu',
        'puskeswan' => 'Puskeswan Palsu',
        'phone_number' => '0811111111',
        'status' => 'online',
    ])->assertStatus(403);

    // Forbidden from deleting
    $vet = Veterinarian::first();
    $this->actingAs($peternak)->delete(route('konsultasi.veterinarians.destroy', $vet))
        ->assertStatus(403);
});

test('admin consultation page renders veterinarian cards and management modals', function () {
    $admin = User::where('role', 'admin')->first();

    $response = $this->actingAs($admin)->get(route('konsultasi', ['tab' => 'dokter']));
    $response->assertOk();
    $response->assertSee('+ Tambah Dokter Hewan');
    $response->assertSee('Dokter Hewan Jaga &amp; Telemedisin', false);
    $response->assertSee('modal-tambah-dokter');
    $response->assertSee('modal-edit-dokter');
    $response->assertSee('openEditVetModal');
    $response->assertSee('drh. Ratna Kusuma');
    $response->assertSee('drh. Bambang Trihatmojo');
});

test('exhibition booth can be registered and updated', function () {
    $exhibition = Exhibition::create([
        'title' => 'East Java Livestock Expo Baru',
        'slug' => 'east-java-livestock-expo-baru',
        'theme' => 'Inovasi Ternak',
        'description' => 'Pameran industri ternak',
        'location' => 'Grand City Convex Surabaya',
        'start_date' => now()->addDays(20),
        'end_date' => now()->addDays(22),
        'total_stands' => 50,
        'registered_stands_count' => 0,
        'status' => 'open',
    ]);

    $regData = [
        'exhibition_id' => $exhibition->id,
        'business_name' => 'CV Sumber Makmur Mandiri',
        'exhibited_products' => 'Produk Olahan Susu Pasteurisasi & Yogurt Probiotik',
        'notes' => 'Membutuhkan pasokan listrik chiller 1000W',
    ];

    $response = $this->post(route('pameran.register'), $regData);
    $response->assertRedirect(route('pameran'));
    $response->assertSessionHas('success');

    $registration = ExhibitionRegistration::where('business_name', 'CV Sumber Makmur Mandiri')->first();
    expect($registration)->not->toBeNull();
    expect($registration->stand_number)->toStartWith('STD-');

    // Update status to rejected
    $rejectResponse = $this->patch(route('pameran.status', $registration), [
        'status' => 'rejected',
    ]);
    $rejectResponse->assertRedirect(route('pameran'));
    $registration->refresh();
    expect($registration->status)->toBe('rejected');
});

test('admin can create exhibition and calendar event', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $peternak = User::factory()->create(['role' => 'peternak']);

    // Admin creates exhibition
    $exhibitionResponse = $this->actingAs($admin)->post(route('pameran.exhibition.store'), [
        'title' => 'Expo Ternak Milenial Jatim 2026',
        'description' => 'Ajang temu bisnis peternak muda Jawa Timur',
        'location' => 'Jatim Expo International Surabaya',
        'start_date' => now()->addDays(30)->toDateString(),
        'end_date' => now()->addDays(32)->toDateString(),
        'stand_capacity' => 80,
        'is_featured' => 1,
    ]);
    $exhibitionResponse->assertRedirect(route('pameran'));
    $this->assertDatabaseHas('exhibitions', [
        'title' => 'Expo Ternak Milenial Jatim 2026',
    ]);

    // Admin creates calendar event
    $calendarResponse = $this->actingAs($admin)->post(route('pameran.calendar.store'), [
        'title' => 'Vaksinasi Serentak Wilayah Tapal Kuda',
        'event_type' => 'vaksinasi',
        'event_date' => now()->addDays(15)->toDateString(),
        'location' => 'Kabupaten Pasuruan',
        'description' => 'Vaksinasi massal pencegahan PMK',
    ]);
    $calendarResponse->assertRedirect(route('pameran'));
    $this->assertDatabaseHas('calendar_events', [
        'title' => 'Vaksinasi Serentak Wilayah Tapal Kuda',
    ]);

    // Peternak cannot create exhibition
    $this->actingAs($peternak)->post(route('pameran.exhibition.store'), [
        'title' => 'Unauthorized Expo',
        'description' => 'Test',
        'location' => 'Surabaya',
        'start_date' => now()->toDateString(),
        'end_date' => now()->toDateString(),
        'stand_capacity' => 10,
    ])->assertStatus(403);
});

test('admin can update and delete exhibition while peternak cannot', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $peternak = User::factory()->create(['role' => 'peternak']);

    $expo = Exhibition::create([
        'title' => 'Expo Pangan Ternak 2026',
        'slug' => 'expo-pangan-ternak-2026',
        'description' => 'Pameran pangan dan industri ternak Jatim',
        'facilities' => 'Booth 3x3m, Listrik 900W, Meja Kursi, Sertifikat',
        'location' => 'Malang Expo Center',
        'start_date' => now()->addDays(20)->toDateString(),
        'end_date' => now()->addDays(22)->toDateString(),
        'stand_capacity' => 50,
        'registered_stands_count' => 5,
        'is_featured' => false,
    ]);

    // Peternak cannot update
    $this->actingAs($peternak)->put(route('pameran.exhibition.update', $expo), [
        'title' => 'Hacked Expo',
        'description' => 'Hacked',
        'location' => 'Malang',
        'start_date' => now()->addDays(20)->toDateString(),
        'end_date' => now()->addDays(22)->toDateString(),
        'stand_capacity' => 50,
    ])->assertStatus(403);

    // Admin can update
    $updateResponse = $this->actingAs($admin)->put(route('pameran.exhibition.update', $expo), [
        'title' => 'Expo Pangan Ternak Jatim Unggul 2026',
        'description' => 'Deskripsi kegiatan yang diperbarui oleh Admin Disnak',
        'facilities' => 'Booth 3x3m, Daya Listrik Chiller, Sertifikat Resmi Disnak Jatim',
        'location' => 'Graha Cakrawala Malang',
        'start_date' => now()->addDays(21)->toDateString(),
        'end_date' => now()->addDays(23)->toDateString(),
        'stand_capacity' => 60,
        'is_featured' => 1,
    ]);
    $updateResponse->assertRedirect(route('pameran'));

    $expo->refresh();
    expect($expo->title)->toBe('Expo Pangan Ternak Jatim Unggul 2026');
    expect($expo->location)->toBe('Graha Cakrawala Malang');
    expect($expo->stand_capacity)->toBe(60);
    expect($expo->is_featured)->toBeTrue();

    // Verify grid cards render exhibition with facilities and content
    $pageResponse = $this->get(route('pameran'));
    $pageResponse->assertStatus(200);
    $pageResponse->assertSee('Expo Pangan Ternak Jatim Unggul 2026');
    $pageResponse->assertSee('Lihat Fasilitas &amp; Isi', false);

    // Peternak cannot delete
    $this->actingAs($peternak)->delete(route('pameran.exhibition.destroy', $expo))->assertStatus(403);

    // Admin can delete
    $deleteResponse = $this->actingAs($admin)->delete(route('pameran.exhibition.destroy', $expo));
    $deleteResponse->assertRedirect(route('pameran'));
    expect(Exhibition::find($expo->id))->toBeNull();
});

test('peternak registers directly via card and sees dynamic registration status without header button', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $expo1 = Exhibition::create([
        'title' => 'Expo Sapi Perah Malang 2026',
        'slug' => 'expo-sapi-perah-malang-2026',
        'description' => 'Pameran sapi perah unggulan',
        'facilities' => 'Booth Stand 3x3m, Chiller, Listrik',
        'location' => 'Batu Malang',
        'start_date' => now()->addDays(10)->toDateString(),
        'end_date' => now()->addDays(12)->toDateString(),
        'stand_capacity' => 20,
        'registered_stands_count' => 0,
        'is_featured' => true,
    ]);

    // Initial view: Peternak sees 'Daftar Stand', does NOT see '+ Ajukan Stand Pameran' header button
    $response = $this->actingAs($peternak)->get(route('pameran'));
    $response->assertStatus(200);
    $response->assertDontSee('+ Ajukan Stand Pameran');
    $response->assertSee('Daftar Stand');

    // Peternak registers for expo
    $reg = ExhibitionRegistration::create([
        'exhibition_id' => $expo1->id,
        'user_id' => $peternak->id,
        'business_name' => 'Kandang Sapi Mandiri',
        'exhibited_products' => 'Susu Segar',
        'status' => 'pending',
        'stand_number' => 'STD-EXP-01',
    ]);

    // View after register: Button changes to 'Menunggu Verifikasi'
    $responseAfter = $this->actingAs($peternak)->get(route('pameran'));
    $responseAfter->assertStatus(200);
    $responseAfter->assertSee('Menunggu Verifikasi');

    // Admin approves
    $reg->update(['status' => 'approved']);

    // View after approval: Button changes to show approved stand number
    $responseApproved = $this->actingAs($peternak)->get(route('pameran'));
    $responseApproved->assertStatus(200);
    $responseApproved->assertSee('Stand: STD-EXP-01');
});

test('search query redirects correctly to target page', function () {
    $response = $this->get(route('search', ['query' => 'wabah']));
    $response->assertRedirect(route('darurat'));

    $response2 = $this->get(route('search', ['query' => 'pakan']));
    $response2->assertRedirect(route('pelatihan'));

    $response3 = $this->get(route('search', ['query' => 'keju artisan']));
    $response3->assertRedirect(route('marketplace', ['q' => 'keju artisan']));
});

test('login page renders with flowbite welcome back elements', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee('Welcome back');
    $response->assertSee('name@company.com');
    $response->assertDontSee('Akun Demo Cepat');
});

test('user can authenticate and logout successfully', function () {
    $user = User::first();

    $response = $this->post(route('login.submit'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);

    // Logout
    $logoutResponse = $this->post(route('logout'));
    $logoutResponse->assertRedirect(route('login'));
    $this->assertGuest();
});

test('invalid credentials returns error feedback', function () {
    $response = $this->from(route('login'))->post(route('login.submit'), [
        'email' => 'slamet@peternak.id',
        'password' => 'wrongpassword123',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('new user can register, persist to database, and auto-login', function () {
    $data = [
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad.dahlan@peternak.id',
        'phone_number' => '081233445566',
        'role' => 'peternak',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => '1',
    ];

    $response = $this->post(route('register.submit'), $data);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();

    $created = User::where('email', 'ahmad.dahlan@peternak.id')->first();
    expect($created)->not->toBeNull();
    expect($created->name)->toBe('Ahmad Dahlan');
    expect($created->role)->toBe('peternak');
});

test('register page renders all customized signup fields according to design specifications', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
    $response->assertSee('Sign up');
    $response->assertSee('Nama Lengkap');
    $response->assertSee('No Telpon (WA)');
    $response->assertSee('628xxxxxxxxxx');
    $response->assertSee('NIK');
    $response->assertSee('Tanggal Lahir');
    $response->assertSee('Kabupaten/Kota');
    $response->assertSee('Pilih Kabupaten...');
    $response->assertSee('Kecamatan');
    $response->assertSee('Pilih Kecamatan...');
    $response->assertSee('Kelurahan/Desa');
    $response->assertSee('Pilih Desa...');
    $response->assertSee('Password Baru');
    $response->assertSee('Konfirmasi Password');
    $response->assertSee('Jenis Ternak');
    $response->assertSee('Jumlah Ternak');
    $response->assertSee('Foto KTP');
    $response->assertSee('* Besar Max 10 MB');
    $response->assertSee('* Tipe: jpeg, png, dan jpg');
    $response->assertSee('Kabupaten Madiun');
    $response->assertSee('Mejayan');
    $response->assertDontSee('Madiun Utara');
    $response->assertDontSee('Desa Sukamaju');
    $response->assertSee('Sign Up');
});

test('user can register with full profile fields and ktp file upload', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ktp_user.jpg', 500, 'image/jpeg');

    $data = [
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@peternak.id',
        'phone_number' => '6281234567890',
        'nik' => '3507123456780001',
        'birth_date' => '1998-05-15',
        'kabupaten' => 'Kabupaten Malang',
        'kecamatan' => 'Kepanjen',
        'desa' => 'Ardirejo',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
        'livestock_type' => 'Sapi Potong',
        'livestock_count' => 12,
        'ktp_file' => $file,
    ];

    $response = $this->post(route('register.submit'), $data);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();

    $user = User::where('email', 'budi.santoso@peternak.id')->first();
    expect($user)->not->toBeNull();
    expect($user->nik)->toBe('3507123456780001');
    expect($user->kabupaten)->toBe('Kabupaten Malang');
    expect($user->kecamatan)->toBe('Kepanjen');
    expect($user->desa)->toBe('Ardirejo');
    expect($user->livestock_type)->toBe('Sapi Potong');
    expect($user->livestock_count)->toBe(12);
    expect($user->ktp_path)->not->toBeNull();

    Storage::disk('public')->assertExists($user->ktp_path);
});

test('login and register pages render in bright theme without preview toolbar and use images from img directory', function () {
    foreach ([route('login'), route('register')] as $url) {
        $response = $this->get($url);
        $response->assertStatus(200);

        // Preview toolbar elements removed
        $response->assertDontSee('title="Desktop view"');
        $response->assertDontSee('title="Tablet view"');
        $response->assertDontSee('title="Mobile view"');

        // Bright theme: no hardcoded dark class on html
        $response->assertDontSee('<html lang="id" class="dark">');

        // References logo in img folder
        $response->assertSee('img/logoaplikasi2.png');
    }

    // Login page uses single full hero image with gradient (hiasan baru 2.jpg)
    $loginResponse = $this->get(route('login'));
    $loginResponse->assertSee('img/hiasan baru 2.jpg');
    $loginResponse->assertDontSee('img/auth-illustration.jpg');

    // Register page uses single full hero image with gradient (hiasan baru 1.jpg)
    $registerResponse = $this->get(route('register'));
    $registerResponse->assertSee('img/hiasan baru 1.jpg');
    $registerResponse->assertDontSee('img/auth-illustration.jpg');
});

// =========================================================================
// SISTEM ROLE-BASED ACCESS CONTROL (RBAC) TESTS
// 1. Admin Dinas Peternakan Provinsi Jawa Timur
// 2. Peternak
// 3. Masyarakat Umum
// =========================================================================

test('admin has full administrative oversight and can verify products, reports, and trainings', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->create(['role' => 'peternak']);

    // Admin can access all pages
    foreach (['dashboard', 'darurat', 'pelatihan', 'marketplace', 'harga-komoditas', 'konsultasi', 'pameran'] as $routeName) {
        $this->actingAs($admin)->get(route($routeName))->assertStatus(200);
    }

    // Admin can verify emergency report status
    $report = EmergencyReport::first();
    $this->actingAs($admin)
        ->patch(route('darurat.status', $report), ['status' => 'verified'])
        ->assertRedirect(route('darurat'));
    expect($report->fresh()->status)->toBe('verified');

    // Admin receives, handles, and verifies reports, but does NOT create reports
    $daruratResponse = $this->actingAs($admin)->get(route('darurat'));
    $daruratResponse->assertStatus(200);
    $daruratResponse->assertDontSee('Buat Laporan Darurat');
    $daruratResponse->assertSee('Panel Pengawasan');

    $this->actingAs($admin)
        ->post(route('darurat.store'), [
            'incident_type' => 'wabah',
            'livestock_type' => 'sapi_potong',
            'affected_count' => 5,
            'location_address' => 'Bojonegoro',
        ])
        ->assertRedirect(route('darurat'))
        ->assertSessionHas('error');

    // Admin can verify marketplace products
    $product = Product::first();
    $product->update(['is_verified' => false]);
    $this->actingAs($admin)
        ->patch(route('marketplace.products.verify', $product))
        ->assertRedirect(route('marketplace'));
    expect($product->fresh()->is_verified)->toBeTrue();

    // Admin can store commodity prices
    $region = Region::first();
    $commodity = Commodity::first();
    $this->actingAs($admin)
        ->post(route('harga-komoditas.store'), [
            'region_id' => $region->id,
            'commodity_id' => $commodity->id,
            'farmer_price' => 25000,
            'consumer_price' => 30000,
        ])
        ->assertRedirect(route('harga-komoditas'));
});

test('peternak can access producer features but is blocked from admin mutations with 403', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->create(['role' => 'peternak']);
    $report = EmergencyReport::first();
    $product = Product::first();
    $region = Region::first();
    $commodity = Commodity::first();

    // Peternak can access allowed routes
    foreach (['dashboard', 'darurat', 'pelatihan', 'marketplace', 'harga-komoditas', 'konsultasi', 'pameran'] as $routeName) {
        $this->actingAs($peternak)->get(route($routeName))->assertStatus(200);
    }

    // Peternak CAN see "Buat Laporan Darurat"
    $peternakDarurat = $this->actingAs($peternak)->get(route('darurat'));
    $peternakDarurat->assertStatus(200);
    $peternakDarurat->assertSee('Buat Laporan Darurat');

    // Peternak CANNOT update emergency status (Admin only) -> 403 Forbidden
    $this->actingAs($peternak)
        ->patch(route('darurat.status', $report), ['status' => 'resolved'])
        ->assertStatus(403);

    // Peternak CANNOT verify products (Admin only) -> 403 Forbidden
    $this->actingAs($peternak)
        ->patch(route('marketplace.products.verify', $product))
        ->assertStatus(403);

    // Peternak CANNOT store commodity price (Admin only) -> 403 Forbidden
    $this->actingAs($peternak)
        ->post(route('harga-komoditas.store'), [
            'region_id' => $region->id,
            'commodity_id' => $commodity->id,
            'farmer_price' => 20000,
            'consumer_price' => 25000,
        ])
        ->assertStatus(403);

    // Peternak product upload defaults to unverified
    $cat = ProductCategory::first();
    $this->actingAs($peternak)
        ->post(route('marketplace.products.store'), [
            'name' => 'Susu Kambing Organik Peternak',
            'product_category_id' => $cat->id,
            'region_id' => $region->id,
            'price' => 35000,
            'stock' => 50,
            'unit' => 'Liter',
            'description' => 'Susu segar kambing etawa peternak',
        ])
        ->assertRedirect(route('marketplace'));

    $newProduct = Product::where('name', 'Susu Kambing Organik Peternak')->first();
    expect($newProduct)->not->toBeNull();
    expect($newProduct->is_verified)->toBeFalse();
});

test('masyarakat umum is restricted to public features and blocked with 403 on protected routes', function () {
    $umum = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);

    // Umum CAN access public routes
    $this->actingAs($umum)->get(route('dashboard'))->assertStatus(200);
    $this->actingAs($umum)->get(route('marketplace'))->assertStatus(200);
    $this->actingAs($umum)->get(route('harga-komoditas'))->assertStatus(200);
    $this->actingAs($umum)->get(route('pameran'))->assertStatus(200);

    // Umum CANNOT access internal features -> 403 Forbidden
    $this->actingAs($umum)->get(route('darurat'))->assertStatus(403);
    $this->actingAs($umum)->get(route('pelatihan'))->assertStatus(403);
    $this->actingAs($umum)->get(route('konsultasi'))->assertStatus(403);

    // Umum CAN perform purchasing in marketplace
    $product = Product::first();
    $this->actingAs($umum)
        ->post(route('marketplace.products.buy', $product), [
            'quantity' => 2,
            'buyer_name' => $umum->name,
            'buyer_phone' => '081234567899',
            'shipping_address' => 'Jl. Pemuda No. 10 Surabaya',
        ])
        ->assertRedirect(route('marketplace'));

    $order = Order::where('buyer_id', $umum->id)->latest()->first();
    expect($order)->not->toBeNull();
    expect($order->buyer?->name)->toBe($umum->name);
});

<?php

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportResponse;
use App\Models\AnimalHealthReportVisit;
use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

// Skenario 1 — Pembuatan akun dokter oleh Admin & Akses Role
test('admin can create a veterinarian account and doctor can login to dedicated dashboard', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('admin.veterinarians.store'), [
        'name' => 'drh. Siti Rahmawati, M.Si',
        'email' => 'drh.siti@disnak.jatimprov.go.id',
        'phone_number' => '081234567891',
        'strv_number' => 'STRV-35.07.2026.888',
        'specialization' => 'Kesehatan Sapi Perah & Mastitis',
        'puskeswan' => 'Puskeswan Pujon',
        'wilayah_penugasan' => 'Kabupaten Malang',
        'consultation_hours' => '08.00 - 15.00 WIB',
        'status' => 'online',
        'password' => 'DokterAman2026',
    ]);

    $response->assertRedirect();

    // Verify User in database
    $user = User::where('email', 'drh.siti@disnak.jatimprov.go.id')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe('dokter_hewan')
        ->and($user->isDokterHewan())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse()
        ->and($user->is_active)->toBeTrue();

    // Verify Veterinarian profile
    $vet = Veterinarian::where('user_id', $user->id)->first();
    expect($vet)->not->toBeNull()
        ->and($vet->specialization)->toBe('Kesehatan Sapi Perah & Mastitis')
        ->and($vet->puskeswan)->toBe('Puskeswan Pujon');

    // Doctor logs in
    $loginResponse = $this->post(route('login.submit'), [
        'email' => 'drh.siti@disnak.jatimprov.go.id',
        'password' => 'DokterAman2026',
    ]);
    $loginResponse->assertRedirect(route('dokter-hewan.dashboard'));

    // Doctor visits /dashboard and gets redirected to /dokter-hewan/dashboard
    $dashboardRedirect = $this->actingAs($user)->get(route('dashboard'));
    $dashboardRedirect->assertRedirect(route('dokter-hewan.dashboard'));

    // Doctor accesses their dashboard successfully
    $vetDashboard = $this->actingAs($user)->get(route('dokter-hewan.dashboard'));
    $vetDashboard->assertOk();
    $vetDashboard->assertSee('Dashboard Dokter Hewan Dinas');
    $vetDashboard->assertSee('Laporan Masuk');
    $vetDashboard->assertSee('Puskeswan Pujon');

    // Doctor CANNOT access admin-only routes
    $adminRestricted = $this->actingAs($user)->get(route('admin.veterinarians.index'));
    $adminRestricted->assertForbidden();
});

test('public registration forbids registering as dokter_hewan role', function () {
    $response = $this->post(route('register.submit'), [
        'name' => 'Calon Hacker Vet',
        'email' => 'fakevet@test.com',
        'phone_number' => '081234567899',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => 'dokter_hewan',
    ]);

    // Validation should reject 'dokter_hewan' (only 'peternak' and 'umum' permitted)
    $response->assertSessionHasErrors('role');
    expect(User::where('email', 'fakevet@test.com')->exists())->toBeFalse();
});

// Skenario 2 — Pelaporan Baru oleh Peternak
test('peternak can submit an animal health report and it appears with status menunggu_respons', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->peternak()->create();
    $dokter = User::factory()->dokterHewan()->create();
    $vetProfile = Veterinarian::factory()->create(['user_id' => $dokter->id]);

    $response = $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Sapi Potong',
        'affected_count' => 3,
        'symptoms' => 'Sapi mengalami hipersalivasi, lepuh di area kuku dan mulut, serta demam tinggi.',
        'symptoms_started_at' => now()->subDay()->toDateString(),
        'urgency' => 'kritis',
        'farm_name' => 'Peternakan Berkah Mandiri',
        'farm_address' => 'Desa Toyomarto, Kec. Singosari',
        'kabupaten' => 'Kabupaten Malang',
    ]);

    $report = AnimalHealthReport::where('user_id', $peternak->id)->latest()->first();
    expect($report)->not->toBeNull()
        ->and($report->status)->toBe('menunggu_respons')
        ->and($report->urgency)->toBe('kritis')
        ->and($report->report_number)->toStartWith('LKH-');

    $response->assertRedirect(route('kesehatan-hewan.show', $report));

    // Peternak sees the report in their list
    $peternakList = $this->actingAs($peternak)->get(route('kesehatan-hewan.index'));
    $peternakList->assertOk();
    $peternakList->assertSee($report->report_number);
    $peternakList->assertSee('Menunggu Respons');

    // Doctor sees the report in incoming reports
    $vetDashboard = $this->actingAs($dokter)->get(route('dokter-hewan.dashboard', ['tab' => 'masuk']));
    $vetDashboard->assertOk();
    $vetDashboard->assertSee($report->report_number);
    $vetDashboard->assertSee($peternak->name);
});

// Skenario 3 — Dokter Membalas Laporan (Respons & Rekomendasi)
test('doctor can respond with initial hypothesis and recommendations without jumping to selesai', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->peternak()->create();
    $dokter = User::factory()->dokterHewan()->create();
    $vetProfile = Veterinarian::factory()->create(['user_id' => $dokter->id]);

    $report = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'status' => 'menunggu_respons',
    ]);

    $response = $this->actingAs($dokter)->post(route('dokter-hewan.response.store', $report), [
        'message' => 'Laporan telah kami pelajari. Gejala yang Anda jelaskan mengindikasikan adanya infeksi vesikular.',
        'hypothesis' => 'Dugaan klinis awal: Suspek Penyakit Mulut dan Kuku (PMK)',
        'recommendations' => 'Segera lakukan isolasi ternak, semprot kandang dengan desinfektan klorin 1:10, berikan pakan lunak.',
        'follow_up_instructions' => 'Jangan memindahkan ternak ke luar kandang sebelum pemeriksaan dinas selesai.',
        'urgency_level' => 'kritis',
        'requires_visit' => 0,
        'target_status' => 'sudah_dijawab',
        'notes' => 'Tim Puskeswan memonitor perkembangan harian peternak.',
    ]);

    $response->assertRedirect(route('dokter-hewan.show', $report));

    $report->refresh();
    // Status must be updated to sudah_dijawab, NOT selesai
    expect($report->status)->toBe('sudah_dijawab')
        ->and($report->last_responded_at)->not->toBeNull()
        ->and($report->assigned_veterinarian_id)->toBe($vetProfile->id);

    // Response is persisted
    $savedResponse = AnimalHealthReportResponse::where('animal_health_report_id', $report->id)->first();
    expect($savedResponse)->not->toBeNull()
        ->and($savedResponse->user_id)->toBe($dokter->id)
        ->and($savedResponse->hypothesis)->toContain('Suspek Penyakit Mulut dan Kuku');

    // Peternak views the response on their report detail
    $peternakView = $this->actingAs($peternak)->get(route('kesehatan-hewan.show', $report));
    $peternakView->assertOk();
    $peternakView->assertSee('Dugaan klinis awal: Suspek Penyakit Mulut dan Kuku (PMK)');
    $peternakView->assertSee('Segera lakukan isolasi ternak');
    $peternakView->assertSee('Sudah Dijawab');

    // Reloading retains the response
    $reload = $this->actingAs($peternak)->get(route('kesehatan-hewan.show', $report));
    $reload->assertSee('Dugaan klinis awal: Suspek Penyakit Mulut dan Kuku (PMK)');
});

// Skenario 4 — Kunjungan Lapangan Dokter Hewan & Konfirmasi Peternak
test('doctor can propose a field visit and peternak can confirm schedule', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->peternak()->create();
    $dokter = User::factory()->dokterHewan()->create();
    $vetProfile = Veterinarian::factory()->create(['user_id' => $dokter->id]);

    $report = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'status' => 'sedang_ditangani',
    ]);

    $proposedTime = now()->addDays(1)->format('Y-m-d H:i:s');

    // Doctor proposes visit
    $proposeResponse = $this->actingAs($dokter)->post(route('dokter-hewan.visit.propose', $report), [
        'visit_reason' => 'Perlu injeksi antibiotik long-acting dan pengambilan sampel darah.',
        'proposed_date' => $proposedTime,
    ]);

    $proposeResponse->assertRedirect(route('dokter-hewan.show', $report));

    $report->refresh();
    expect($report->status)->toBe('menunggu_kunjungan');

    $visit = AnimalHealthReportVisit::where('animal_health_report_id', $report->id)->first();
    expect($visit)->not->toBeNull()
        ->and($visit->status)->toBe('menunggu_konfirmasi')
        ->and($visit->confirmed_date)->toBeNull();

    // Peternak confirms visit
    $confirmResponse = $this->actingAs($peternak)->post(route('kesehatan-hewan.visit.confirm', [$report, $visit]), [
        'farmer_notes' => 'Kandang siap dikunjungi, peternak stanby di lokasi.',
    ]);

    $confirmResponse->assertRedirect(route('kesehatan-hewan.show', $report));

    $report->refresh();
    $visit->refresh();

    expect($report->status)->toBe('kunjungan_terjadwal')
        ->and($visit->status)->toBe('terjadwal')
        ->and($visit->confirmed_date)->not->toBeNull();

    // Doctor completes visit examination
    $completeResponse = $this->actingAs($dokter)->post(route('dokter-hewan.visit.complete', [$report, $visit]), [
        'examination_notes' => 'Suhu rektal 39.8C. Diberikan injeksi antipiretik dan multivitamin. Lesi disemprot antiseptik.',
        'post_visit_recommendations' => 'Sanitasi kandang dua kali sehari, pakan konsentrat basah.',
        'next_report_status' => 'selesai',
    ]);

    $completeResponse->assertRedirect(route('dokter-hewan.show', $report));

    $report->refresh();
    $visit->refresh();

    expect($visit->status)->toBe('selesai')
        ->and($visit->examination_notes)->toContain('Suhu rektal 39.8C')
        ->and($report->status)->toBe('selesai');
});

// Skenario 5 — Isolasi Data Antar Peternak
test('peternak A cannot access or view health report of Peternak B', function () {
    $peternakA = User::factory()->peternak()->create();
    $peternakB = User::factory()->peternak()->create();

    $reportB = AnimalHealthReport::factory()->create([
        'user_id' => $peternakB->id,
        'symptoms' => 'Rahasia peternak B',
    ]);

    // Peternak A tries to access report of Peternak B
    $response = $this->actingAs($peternakA)->get(route('kesehatan-hewan.show', $reportB));
    $response->assertForbidden();

    // Peternak A tries to reply to Peternak B's report
    $replyResponse = $this->actingAs($peternakA)->post(route('kesehatan-hewan.reply', $reportB), [
        'message' => 'Mencoba meretas',
    ]);
    $replyResponse->assertForbidden();
});

// Skenario 6 — Konsistensi Status & Audit Trail
test('status changes maintain an audit trail and transitions are consistent', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->peternak()->create();
    $dokter = User::factory()->dokterHewan()->create();
    Veterinarian::factory()->create(['user_id' => $dokter->id]);

    $report = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'status' => 'menunggu_respons',
    ]);

    // Update status explicitly to sedang_ditangani
    $this->actingAs($dokter)->patch(route('dokter-hewan.status.update', $report), [
        'status' => 'sedang_ditangani',
        'notes' => 'Mulai memverifikasi data ternak dan puskeswan terdekat.',
    ]);

    $report->refresh();
    expect($report->status)->toBe('sedang_ditangani');

    // Check status histories audit trail
    $histories = $report->statusHistories;
    expect($histories)->not->toBeEmpty();
    $latestHistory = $histories->first();
    expect($latestHistory->new_status)->toBe('sedang_ditangani')
        ->and($latestHistory->changed_by_id)->toBe($dokter->id)
        ->and($latestHistory->notes)->toContain('Mulai memverifikasi');
});

// Skenario 7 — Kondisi Kosong dan Validasi Error
test('dashboard displays polite empty states and prevents invalid input', function () {
    AnimalHealthReport::truncate();

    $dokter = User::factory()->dokterHewan()->create();
    Veterinarian::factory()->create(['user_id' => $dokter->id]);

    $response = $this->actingAs($dokter)->get(route('dokter-hewan.dashboard'));
    $response->assertOk();
    $response->assertSee('Belum ada laporan kesehatan hewan yang perlu ditangani');

    // Validation error when submitting incomplete response
    $report = AnimalHealthReport::factory()->create();
    $failResponse = $this->actingAs($dokter)->post(route('dokter-hewan.response.store', $report), [
        'message' => '', // Required message is empty
    ]);
    $failResponse->assertSessionHasErrors('message');
});

// Skenario 8 — Isolasi Role Total: Admin Dilarang Mengakses Portal Medis Dokter Hewan
test('admin cannot access veterinarian medical dashboard routes', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('dokter-hewan.dashboard'));
    $response->assertForbidden();

    $visitResponse = $this->actingAs($admin)->get(route('dokter-hewan.kunjungan'));
    $visitResponse->assertForbidden();
});

// Skenario 9 — Alur Lengkap Permintaan Pengguna:
// Admin buatkan akun dokter (email + password) -> Dokter login -> Dokter lihat laporan masuk & langsung tangani -> Peternak langsung lihat hasilnya
test('complete workflow: admin creates doctor credentials, doctor logs in and handles report, farmer sees the result', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->peternak()->create();

    // 1. Admin membuatkan akun dokter (email & password)
    $createVetResponse = $this->actingAs($admin)->post(route('admin.veterinarians.store'), [
        'name' => 'drh. Hendra Wijaya',
        'email' => 'drh.hendra@disnak.jatimprov.go.id',
        'phone_number' => '082198765432',
        'strv_number' => 'STRV-35.09.2026.111',
        'specialization' => 'Penyakit Menular & Vaksinasi Ruminansia',
        'puskeswan' => 'Puskeswan Singosari',
        'wilayah_penugasan' => 'Kabupaten Malang',
        'consultation_hours' => '08.00 - 16.00 WIB',
        'status' => 'online',
        'password' => 'PassDokter123!',
    ]);

    $createVetResponse->assertRedirect();
    $createVetResponse->assertSessionHas('newly_created_vet');

    $dokterUser = User::where('email', 'drh.hendra@disnak.jatimprov.go.id')->first();
    expect($dokterUser)->not->toBeNull()
        ->and($dokterUser->role)->toBe('dokter_hewan');

    // 2. Peternak mengirim laporan kesehatan
    $report = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'livestock_type' => 'Sapi Perah',
        'affected_count' => 2,
        'symptoms' => 'Nafsu makan menurun drastis, puting susu bengkak dan kemerahan.',
        'status' => 'menunggu_respons',
    ]);

    // 3. Dokter login menggunakan email dan kata sandi dari admin
    $loginDoctor = $this->post(route('login.submit'), [
        'email' => 'drh.hendra@disnak.jatimprov.go.id',
        'password' => 'PassDokter123!',
    ]);
    $loginDoctor->assertRedirect(route('dokter-hewan.dashboard'));

    // 4. Dokter melihat laporan masuk di dashboard
    $incomingList = $this->actingAs($dokterUser)->get(route('dokter-hewan.dashboard', ['tab' => 'masuk']));
    $incomingList->assertOk();
    $incomingList->assertSee($report->report_number);
    $incomingList->assertSee('Nafsu makan menurun drastis');

    // 5. Dokter membuka detail laporan dan langsung menanganinya (ubah status ke sedang_ditangani, lalu kirim analisis)
    $doctorViewReport = $this->actingAs($dokterUser)->get(route('dokter-hewan.show', $report));
    $doctorViewReport->assertOk();
    $doctorViewReport->assertSee('Mulai Tangani Laporan');

    // Dokter mengklaim penanganan
    $claimResponse = $this->actingAs($dokterUser)->patch(route('dokter-hewan.status.update', $report), [
        'status' => 'sedang_ditangani',
        'notes' => 'Dokter mulai memeriksa gejala klinis.',
    ]);
    $claimResponse->assertRedirect();

    $report->refresh();
    expect($report->status)->toBe('sedang_ditangani');

    // Dokter memberikan tanggapan medis & instruksi
    $respondResponse = $this->actingAs($dokterUser)->post(route('dokter-hewan.response.store', $report), [
        'message' => 'Berdasarkan gejala klinis pada ambing, ini merupakan kasus radang ambing (mastitis).',
        'hypothesis' => 'Dugaan klinis: Mastitis Subklinis Akut',
        'recommendations' => 'Kompres ambing dengan air hangat suam-suam kuku, perah susu secara berkala dan buang susu yang terinfeksi.',
        'follow_up_instructions' => 'Jangan campurkan susu sapi sakit dengan tangki pendingin susu komunal.',
        'urgency_level' => 'sedang',
        'requires_visit' => 0,
        'target_status' => 'sudah_dijawab',
    ]);
    $respondResponse->assertRedirect(route('dokter-hewan.show', $report));

    $report->refresh();
    expect($report->status)->toBe('sudah_dijawab');

    // 6. Peternak langsung melihat hasil pemeriksaan & rekomendasi dokter
    $peternakView = $this->actingAs($peternak)->get(route('kesehatan-hewan.show', $report));
    $peternakView->assertOk();
    $peternakView->assertSee('Dugaan klinis: Mastitis Subklinis Akut');
    $peternakView->assertSee('Kompres ambing dengan air hangat');
    $peternakView->assertSee('drh. Hendra Wijaya');
    $peternakView->assertSee('Sudah Dijawab');
});

test('veterinarian sees KPI stat cards on dashboard but cards are hidden on laporan kesehatan menu', function () {
    $dokter = User::factory()->dokterHewan()->create();
    Veterinarian::factory()->create(['user_id' => $dokter->id]);

    // 1. On Dashboard: KPI cards are visible
    $dashboardResponse = $this->actingAs($dokter)->get(route('dokter-hewan.dashboard'));
    $dashboardResponse->assertOk();
    $dashboardResponse->assertSee('Dashboard Dokter Hewan Dinas');
    $dashboardResponse->assertSee('Laporan baru belum mendapat respons');

    // 2. On Laporan Kesehatan: KPI cards and horizontal tabs are hidden, dedicated status header is shown
    $laporanResponse = $this->actingAs($dokter)->get(route('dokter-hewan.laporan.index'));
    $laporanResponse->assertOk();
    $laporanResponse->assertSee('Laporan Kesehatan Hewan Ternak');
    $laporanResponse->assertSee('Laporan Masuk');
    $laporanResponse->assertDontSee('Laporan baru belum mendapat respons');

    // 3. On filtered tab: dedicated title for that status is shown without horizontal tabs
    $filteredResponse = $this->actingAs($dokter)->get(route('dokter-hewan.laporan.index', ['tab' => 'masuk']));
    $filteredResponse->assertOk();
    $filteredResponse->assertSee('Laporan Kesehatan Hewan Ternak');
    $filteredResponse->assertSee('Laporan Masuk');
    $filteredResponse->assertDontSee('Laporan baru belum mendapat respons');
    $filteredResponse->assertDontSee('Sedang Ditangani (');
});

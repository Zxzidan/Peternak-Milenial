<?php

use App\Models\AnimalHealthReport;
use App\Models\User;
use App\Models\Veterinarian;
use App\Services\HealthReportDistributionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    AnimalHealthReport::query()->delete();
    Veterinarian::query()->delete();
    User::query()->delete();
});

test('automatic distribution assigns new report to doctor with the lowest active workload', function () {
    // Clear out any existing reports for clean test state
    AnimalHealthReport::query()->delete();

    // Create 2 doctors
    $vetUserA = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter A']);
    $vetA = Veterinarian::factory()->create([
        'user_id' => $vetUserA->id,
        'name' => 'drh. Dokter A',
        'is_active' => true,
        'status' => 'online',
    ]);

    $vetUserB = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter B']);
    $vetB = Veterinarian::factory()->create([
        'user_id' => $vetUserB->id,
        'name' => 'drh. Dokter B',
        'is_active' => true,
        'status' => 'online',
    ]);

    // Give Doctor A 2 active reports
    AnimalHealthReport::factory()->count(2)->create([
        'assigned_veterinarian_id' => $vetA->id,
        'status' => 'menunggu_respons',
    ]);

    // Give Doctor B 0 active reports
    expect(app(HealthReportDistributionService::class)->getActiveWorkload($vetA))->toBe(2)
        ->and(app(HealthReportDistributionService::class)->getActiveWorkload($vetB))->toBe(0);

    // Peternak submits a new report
    $peternak = User::factory()->peternak()->create();
    $response = $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Sapi Perah',
        'affected_count' => 1,
        'symptoms' => 'Demam dan lesu pasca melahirkan.',
        'symptoms_started_at' => now()->subDay()->toDateString(),
        'urgency' => 'sedang',
        'farm_name' => 'Peternakan Uji',
        'farm_address' => 'Jl. Peternak No. 1',
        'kabupaten' => 'Kabupaten Malang',
    ]);

    $response->assertRedirect();

    $newReport = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    expect($newReport)->not->toBeNull()
        ->and($newReport->assigned_veterinarian_id)->toBe($vetB->id)
        ->and($newReport->status)->toBe('menunggu_respons');

    // Workload of Doctor B is now 1
    expect(app(HealthReportDistributionService::class)->getActiveWorkload($vetB))->toBe(1);
});

test('workload calculation excludes completed and answered reports', function () {
    AnimalHealthReport::query()->delete();

    $vetUserA = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter A']);
    $vetA = Veterinarian::factory()->create([
        'user_id' => $vetUserA->id,
        'name' => 'drh. Dokter A',
        'is_active' => true,
        'status' => 'online',
    ]);

    $vetUserB = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter B']);
    $vetB = Veterinarian::factory()->create([
        'user_id' => $vetUserB->id,
        'name' => 'drh. Dokter B',
        'is_active' => true,
        'status' => 'online',
    ]);

    // Doctor A has 1 active report (sedang_ditangani)
    AnimalHealthReport::factory()->create([
        'assigned_veterinarian_id' => $vetA->id,
        'status' => 'sedang_ditangani',
    ]);

    // Doctor B has 3 reports, but all are sudah_dijawab or selesai (active workload = 0)
    AnimalHealthReport::factory()->create([
        'assigned_veterinarian_id' => $vetB->id,
        'status' => 'sudah_dijawab',
    ]);
    AnimalHealthReport::factory()->create([
        'assigned_veterinarian_id' => $vetB->id,
        'status' => 'selesai',
    ]);

    expect(app(HealthReportDistributionService::class)->getActiveWorkload($vetA))->toBe(1)
        ->and(app(HealthReportDistributionService::class)->getActiveWorkload($vetB))->toBe(0);

    // New report should go to Doctor B because Doctor B has 0 active reports
    $peternak = User::factory()->peternak()->create();
    $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Kambing',
        'affected_count' => 2,
        'symptoms' => 'Batuk dan keluar lendir hidung.',
        'symptoms_started_at' => now()->subDay()->toDateString(),
        'urgency' => 'rendah',
        'farm_name' => 'Peternakan Kambing Mandiri',
        'farm_address' => 'Desa Pujon Kidul',
        'kabupaten' => 'Kabupaten Malang',
    ]);

    $newReport = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    expect($newReport->assigned_veterinarian_id)->toBe($vetB->id);
});

test('fair tie-breaking rotates between doctors with equal active workload', function () {
    AnimalHealthReport::query()->delete();

    $vetUserA = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter A']);
    $vetA = Veterinarian::factory()->create([
        'user_id' => $vetUserA->id,
        'name' => 'drh. Dokter A',
        'is_active' => true,
        'status' => 'online',
    ]);

    $vetUserB = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter B']);
    $vetB = Veterinarian::factory()->create([
        'user_id' => $vetUserB->id,
        'name' => 'drh. Dokter B',
        'is_active' => true,
        'status' => 'online',
    ]);

    $peternak = User::factory()->peternak()->create();

    // 1st report: assigned to one doctor (e.g. A)
    $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Sapi',
        'affected_count' => 1,
        'symptoms' => 'Kasus 1',
        'symptoms_started_at' => now()->toDateString(),
        'urgency' => 'sedang',
        'farm_name' => 'Peternakan 1',
        'farm_address' => 'Alamat 1',
        'kabupaten' => 'Malang',
    ]);

    $report1 = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    $firstDoctorId = $report1->assigned_veterinarian_id;
    $secondDoctorId = $firstDoctorId === $vetA->id ? $vetB->id : $vetA->id;

    // 2nd report: now the other doctor has 0 active workload, so it MUST go to the other doctor!
    $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Sapi',
        'affected_count' => 1,
        'symptoms' => 'Kasus 2',
        'symptoms_started_at' => now()->toDateString(),
        'urgency' => 'sedang',
        'farm_name' => 'Peternakan 2',
        'farm_address' => 'Alamat 2',
        'kabupaten' => 'Malang',
    ]);

    $report2 = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    expect($report2->assigned_veterinarian_id)->toBe($secondDoctorId);

    // Both doctors now have 1 active report each
    expect(app(HealthReportDistributionService::class)->getActiveWorkload($vetA))->toBe(1)
        ->and(app(HealthReportDistributionService::class)->getActiveWorkload($vetB))->toBe(1);
});

test('when no veterinarians are available, report is set to menunggu_penugasan', function () {
    AnimalHealthReport::query()->delete();

    // Set all existing veterinarians to offline or inactive
    Veterinarian::query()->update([
        'is_active' => false,
        'status' => 'offline',
    ]);

    $peternak = User::factory()->peternak()->create();
    $response = $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Ayam Broiler',
        'affected_count' => 50,
        'symptoms' => 'Mati mendadak beberapa ekor per hari.',
        'symptoms_started_at' => now()->toDateString(),
        'urgency' => 'kritis',
        'farm_name' => 'Kandang Unggas Jaya',
        'farm_address' => 'Kecamatan Gondanglegi',
        'kabupaten' => 'Kabupaten Malang',
    ]);

    $response->assertRedirect();

    $report = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    expect($report)->not->toBeNull()
        ->and($report->status)->toBe('menunggu_penugasan')
        ->and($report->assigned_veterinarian_id)->toBeNull();

    // Peternak views the report in the list and sees Menunggu Penugasan badge
    $listResponse = $this->actingAs($peternak)->get(route('kesehatan-hewan.index'));
    $listResponse->assertOk();
    $listResponse->assertSee('Menunggu Penugasan');
});

test('pending reports with status menunggu_penugasan are redistributed once a doctor becomes available', function () {
    AnimalHealthReport::query()->delete();

    // Disable all doctors initially
    Veterinarian::query()->update([
        'is_active' => false,
        'status' => 'offline',
    ]);

    $peternak = User::factory()->peternak()->create();
    $this->actingAs($peternak)->post(route('kesehatan-hewan.store'), [
        'livestock_type' => 'Domba Garut',
        'affected_count' => 3,
        'symptoms' => 'Lemas dan nafsu makan turun drastis.',
        'symptoms_started_at' => now()->toDateString(),
        'urgency' => 'sedang',
        'farm_name' => 'Peternakan Garut Berkah',
        'farm_address' => 'Kecamatan Tumpang',
        'kabupaten' => 'Kabupaten Malang',
    ]);

    $report = AnimalHealthReport::where('user_id', $peternak->id)->latest('id')->first();
    expect($report->status)->toBe('menunggu_penugasan')
        ->and($report->assigned_veterinarian_id)->toBeNull();

    // Admin creates or activates a doctor
    $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();
    $this->actingAs($admin)->post(route('admin.veterinarians.store'), [
        'name' => 'drh. Dokter Baru',
        'email' => 'drh.baru@disnak.jatimprov.go.id',
        'phone_number' => '081234567899',
        'strv_number' => 'STRV-35.00.2026.999',
        'specialization' => 'Kesehatan Ternak Umum',
        'puskeswan' => 'Puskeswan Malang',
        'wilayah_penugasan' => 'Kabupaten Malang',
        'status' => 'online',
        'password' => 'PasswordBaru123!',
    ]);

    $newVetUser = User::where('email', 'drh.baru@disnak.jatimprov.go.id')->first();
    $newVet = Veterinarian::where('user_id', $newVetUser->id)->first();

    // The pending report was automatically redistributed to the newly available doctor
    $report->refresh();
    expect($report->status)->toBe('menunggu_respons')
        ->and($report->assigned_veterinarian_id)->toBe($newVet->id);
});

test('strict data isolation: doctor only sees and handles their assigned reports', function () {
    AnimalHealthReport::query()->delete();

    $peternak = User::factory()->peternak()->create();

    $vetUserA = User::factory()->dokterHewan()->create(['name' => 'drh. Alpha']);
    $vetA = Veterinarian::factory()->create([
        'user_id' => $vetUserA->id,
        'name' => 'drh. Alpha',
        'is_active' => true,
        'status' => 'online',
    ]);

    $vetUserB = User::factory()->dokterHewan()->create(['name' => 'drh. Beta']);
    $vetB = Veterinarian::factory()->create([
        'user_id' => $vetUserB->id,
        'name' => 'drh. Beta',
        'is_active' => true,
        'status' => 'online',
    ]);

    $reportForA = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'assigned_veterinarian_id' => $vetA->id,
        'symptoms' => 'Kasus khusus untuk dokter Alpha',
        'status' => 'menunggu_respons',
    ]);

    $reportForB = AnimalHealthReport::factory()->create([
        'user_id' => $peternak->id,
        'assigned_veterinarian_id' => $vetB->id,
        'symptoms' => 'Kasus khusus untuk dokter Beta',
        'status' => 'menunggu_respons',
    ]);

    // Doctor Alpha accesses dashboard
    $responseAlpha = $this->actingAs($vetUserA)->get(route('dokter-hewan.dashboard'));
    $responseAlpha->assertOk();
    $responseAlpha->assertSee($reportForA->report_number);
    $responseAlpha->assertSee('Kasus khusus untuk dokter Alpha');
    // Doctor Alpha CANNOT see Doctor Beta's report in their list
    $responseAlpha->assertDontSee($reportForB->report_number);
    $responseAlpha->assertDontSee('Kasus khusus untuk dokter Beta');

    // Doctor Alpha tries to view report detail of Doctor Beta -> 403 Forbidden
    $unauthView = $this->actingAs($vetUserA)->get(route('dokter-hewan.show', $reportForB));
    $unauthView->assertForbidden();

    // Doctor Alpha tries to respond to Doctor Beta's report -> 403 Forbidden
    $unauthRespond = $this->actingAs($vetUserA)->post(route('dokter-hewan.response.store', $reportForB), [
        'message' => 'Mencoba merespons laporan dokter lain',
        'target_status' => 'sudah_dijawab',
    ]);
    $unauthRespond->assertForbidden();

    // Doctor Alpha tries to update status of Doctor Beta's report -> 403 Forbidden
    $unauthStatus = $this->actingAs($vetUserA)->patch(route('dokter-hewan.status.update', $reportForB), [
        'status' => 'sedang_ditangani',
    ]);
    $unauthStatus->assertForbidden();
});

test('admin can view all distributed reports and monitor veterinarian workloads', function () {
    AnimalHealthReport::query()->delete();

    $admin = User::where('role', 'admin')->first() ?? User::factory()->admin()->create();

    $vetUserA = User::factory()->dokterHewan()->create(['name' => 'drh. Dokter Pantau']);
    $vetA = Veterinarian::factory()->create([
        'user_id' => $vetUserA->id,
        'name' => 'drh. Dokter Pantau',
        'is_active' => true,
        'status' => 'online',
    ]);

    AnimalHealthReport::factory()->create([
        'assigned_veterinarian_id' => $vetA->id,
        'status' => 'menunggu_respons',
    ]);

    // Admin views veterinarians management index
    $response = $this->actingAs($admin)->get(route('admin.veterinarians.index'));
    $response->assertOk();
    $response->assertSee('drh. Dokter Pantau');
    $response->assertSee('Beban Laporan');
    $response->assertSee('1 aktif');
});

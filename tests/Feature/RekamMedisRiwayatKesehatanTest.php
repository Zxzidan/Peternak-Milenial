<?php

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportResponse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('rekam medis tab displays a simple 3-column table of animal health report history for logged-in peternak', function () {
    $peternak = User::factory()->peternak()->create([
        'name' => 'Budi Santoso Peternak',
        'email' => 'budi.santoso@peternak.test',
    ]);

    // Create report 1 with doctor response
    $report1 = AnimalHealthReport::create([
        'report_number' => 'LKH-20261020-0001-TEST',
        'user_id' => $peternak->id,
        'livestock_type' => 'Sapi Perah',
        'affected_count' => 1,
        'symptoms' => 'Sapi tidak nafsu makan dan ambing susu membengkak kemerahan',
        'symptoms_started_at' => now()->subDays(2),
        'urgency' => 'tinggi',
        'status' => 'sudah_dijawab',
        'created_at' => now()->subDays(2),
    ]);

    $vetUser = User::factory()->dokterHewan()->create([
        'name' => 'drh. Hendra Wijaya',
        'email' => 'drh.hendra@disnak.test',
    ]);

    AnimalHealthReportResponse::create([
        'animal_health_report_id' => $report1->id,
        'user_id' => $vetUser->id,
        'message' => 'Kemungkinan terindikasi mastitis akut pada kuartir ambing kanan depan.',
        'recommendations' => 'Kompres air hangat dan oleskan salep antibiotik mastitis khusus.',
        'urgency_level' => 'tinggi',
    ]);

    // Create report 2 without doctor response
    $report2 = AnimalHealthReport::create([
        'report_number' => 'LKH-20261020-0002-TEST',
        'user_id' => $peternak->id,
        'livestock_type' => 'Kambing Senduro',
        'affected_count' => 2,
        'symptoms' => 'Batuk pilek dan nafas tersengal-sengal di pagi hari',
        'symptoms_started_at' => now()->subDay(),
        'urgency' => 'sedang',
        'status' => 'menunggu_respons',
        'created_at' => now()->subDay(),
    ]);

    // Create another peternak's report (should NOT appear)
    $otherPeternak = User::factory()->peternak()->create([
        'name' => 'Peternak Lain',
        'email' => 'other@peternak.test',
    ]);
    AnimalHealthReport::create([
        'report_number' => 'LKH-20261020-9999-OTHER',
        'user_id' => $otherPeternak->id,
        'livestock_type' => 'Domba Garut',
        'affected_count' => 5,
        'symptoms' => 'Gejala rahasia milik peternak lain yang tidak boleh muncul',
        'status' => 'menunggu_respons',
    ]);

    // Peternak visits Rekam Medis tab
    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'rekam_medis']));

    $response->assertStatus(200);

    // 1. Assert exactly the 3 column headers exist
    $response->assertSee('Tanggal Pelaporan');
    $response->assertSee('Gejala');
    $response->assertSee('Hasil Balasan Dokter');

    // 2. Assert data from database is displayed correctly
    $response->assertSee('Sapi tidak nafsu makan dan ambing susu membengkak kemerahan');
    $response->assertSee('Kemungkinan terindikasi mastitis akut pada kuartir ambing kanan depan.');
    $response->assertSee('Kompres air hangat dan oleskan salep antibiotik mastitis khusus.');

    // 3. Assert "Belum ada balasan" is displayed when doctor has not answered
    $response->assertSee('Batuk pilek dan nafas tersengal-sengal di pagi hari');
    $response->assertSee('Belum ada balasan');

    // 4. Assert scoped strictly to current logged-in peternak
    $response->assertDontSee('Gejala rahasia milik peternak lain yang tidak boleh muncul');
});

<?php

use App\Models\Consultation;
use App\Models\ConsultationSchedule;
use App\Models\HealthRecord;
use App\Models\Livestock;
use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('rekam medis tab displays consultation reservation results and clinical health records for logged-in peternak', function () {
    $peternak = User::factory()->peternak()->create([
        'name' => 'Budi Santoso Peternak',
        'email' => 'budi.santoso@peternak.test',
    ]);

    $vetUser = User::factory()->dokterHewan()->create([
        'name' => 'drh. Hendra Wijaya',
        'email' => 'drh.hendra@disnak.test',
    ]);
    $veterinarian = Veterinarian::factory()->create([
        'user_id' => $vetUser->id,
        'name' => 'drh. Hendra Wijaya, M.Si',
        'puskeswan' => 'Puskeswan Malang Selatan',
        'is_active' => true,
    ]);

    $livestock = Livestock::create([
        'user_id' => $peternak->id,
        'e_tag_number' => 'ETAG-JTM-777',
        'name' => 'Si Hitam Manis',
        'type' => 'sapi_perah_fh',
        'gender' => 'betina',
        'health_status' => 'sehat',
    ]);

    $schedule = ConsultationSchedule::create([
        'veterinarian_id' => $veterinarian->id,
        'date' => now()->addDay()->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'quota' => 5,
        'booked_count' => 1,
        'status' => 'buka',
    ]);

    // Create consultation reservation with diagnosis and prescription
    Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $veterinarian->id,
        'consultation_schedule_id' => $schedule->id,
        'livestock_id' => $livestock->id,
        'subject' => 'Pemeriksaan Nafsu Makan Turun Pasca Melahirkan',
        'complaint_details' => 'Sapi tampak lesu sejak kemarin pagi dan produksi susu menurun drastis.',
        'consultation_type' => 'telemedisin',
        'status' => 'selesai',
        'doctor_notes' => 'Terindikasi ketosis subklinis ringan pasca laktasi awal. Suhu badan normal 38.6 C.',
        'prescription' => 'Berikan larutan propilen glikol 300ml per oral dan multivitamin B-kompleks.',
    ]);

    // Create clinical health record for the livestock
    HealthRecord::create([
        'livestock_id' => $livestock->id,
        'veterinarian_id' => $veterinarian->id,
        'record_type' => 'vaksinasi',
        'record_date' => now()->subDays(5)->toDateString(),
        'title' => 'Vaksinasi Booster PMK Dosis 2',
        'diagnosis' => 'Kondisi fisik prima untuk vaksinasi booster.',
        'treatment' => 'Injeksi vaksin Aftogen 2ml IM sisi leher kiri.',
        'notes' => 'Ternak istirahat selama 24 jam.',
    ]);

    // Other peternak consultation (should NOT be visible)
    $otherPeternak = User::factory()->peternak()->create([
        'name' => 'Peternak Lain',
        'email' => 'other@peternak.test',
    ]);
    Consultation::create([
        'user_id' => $otherPeternak->id,
        'veterinarian_id' => $veterinarian->id,
        'subject' => 'Rahasia Kasus Penyakit Milik Peternak Lain',
        'complaint_details' => 'Data sensitif yang tidak boleh muncul pada rekam medis pengguna lain.',
        'consultation_type' => 'telemedisin',
        'status' => 'menunggu',
    ]);

    // Visit rekam medis tab
    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'rekam_medis']));

    $response->assertStatus(200);

    // 1. Assert consultation reservation results are prominently displayed
    $response->assertSee('Rekam Medis', false);
    $response->assertSee('Pemeriksaan Nafsu Makan Turun Pasca Melahirkan');
    $response->assertSee('Sapi tampak lesu sejak kemarin pagi dan produksi susu menurun drastis.');
    $response->assertSee('Terindikasi ketosis subklinis ringan pasca laktasi awal.');
    $response->assertSee('Berikan larutan propilen glikol 300ml per oral dan multivitamin B-kompleks.');
    $response->assertSee('drh. Hendra Wijaya, M.Si');
    $response->assertSee('ETAG-JTM-777');

    // 2. Assert scoped strictly to current logged-in peternak
    $response->assertDontSee('Rahasia Kasus Penyakit Milik Peternak Lain');
    $response->assertDontSee('Data sensitif yang tidak boleh muncul pada rekam medis pengguna lain.');
});

test('dokter tab does not display rekam medis terkini ternak widget', function () {
    $peternak = User::factory()->peternak()->create();

    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'dokter']));

    $response->assertStatus(200);
    $response->assertSee('Dokter Hewan Jaga &amp; Telemedisin', false);
    // Ensure the recent medical records widget is removed from the doctor page
    $response->assertDontSee('Rekam Medis Terkini Ternak');
});

test('horizontal top navigation bar does not display rekam medis or balasan dokter tab buttons for peternak', function () {
    $peternak = User::factory()->peternak()->create();

    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'dokter']));

    $response->assertStatus(200);

    // Sidebar contains the navigation items
    $response->assertSee('id="dropdown-kesehatan"', false);
    $response->assertSee('/konsultasi?tab=rekam_medis', false);
    $response->assertSee('/konsultasi?tab=balasan_dokter', false);

    // In-page horizontal tab navigation should NOT display Rekam Medis or Balasan Dokter buttons
    $response->assertDontSee('<!-- Horizontal Tab Navigation Bar -->', false);
    $response->assertDontSee('<span>Rekam Medis (E-Tag)</span>', false);
});

test('balasan dokter tab is accessible via sidebar route and renders successfully', function () {
    $peternak = User::factory()->peternak()->create();

    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'balasan_dokter']));

    $response->assertStatus(200);
    $response->assertSee('Balasan &amp; Rekomendasi Dokter Hewan', false);
});

test('rekam medis cards feature download pdf buttons and link to official document', function () {
    $peternak = User::factory()->peternak()->create();
    $vetUser = User::factory()->dokterHewan()->create();
    $veterinarian = Veterinarian::factory()->create([
        'user_id' => $vetUser->id,
        'name' => 'drh. Siti Aminah, M.Vet',
        'puskeswan' => 'Puskeswan Pasuruan Barat',
    ]);

    $livestock = Livestock::create([
        'user_id' => $peternak->id,
        'e_tag_number' => 'ETAG-PAS-099',
        'name' => 'Lestari Ayu',
        'type' => 'sapi_perah_fh',
        'gender' => 'betina',
        'health_status' => 'sehat',
    ]);

    $consultation = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $veterinarian->id,
        'livestock_id' => $livestock->id,
        'subject' => 'Pemeriksaan Demam Transien',
        'complaint_details' => 'Sapi perah lesu nafsu makan berkurang pasca hujan deras.',
        'consultation_type' => 'telemedisin',
        'status' => 'selesai',
        'doctor_notes' => 'Demam ringan pasca cuaca ekstrem. Dianjurkan hidrasi elektrolit hangat.',
        'prescription' => 'Antipiretik injeksi + Vitamin B kompleks 10ml.',
    ]);

    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'rekam_medis']));
    $response->assertStatus(200);
    $response->assertSee('Download Hasil Rekam Medis (PDF)');
    $response->assertSee(route('konsultasi.rekam-medis.download', ['type' => 'consultation', 'id' => $consultation->id]));
});

test('peternak can view and download official medical record document with farmer care instructions', function () {
    $peternak = User::factory()->peternak()->create([
        'name' => 'Ahmad Santoso',
    ]);
    $vetUser = User::factory()->dokterHewan()->create();
    $veterinarian = Veterinarian::factory()->create([
        'user_id' => $vetUser->id,
        'name' => 'drh. Siti Aminah, M.Vet',
        'puskeswan' => 'Puskeswan Pasuruan Barat',
    ]);

    $livestock = Livestock::create([
        'user_id' => $peternak->id,
        'e_tag_number' => 'ETAG-PAS-099',
        'name' => 'Lestari Ayu',
        'type' => 'sapi_perah_fh',
        'gender' => 'betina',
        'health_status' => 'sehat',
    ]);

    $consultation = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $veterinarian->id,
        'livestock_id' => $livestock->id,
        'subject' => 'Pemeriksaan Demam Transien',
        'complaint_details' => 'Sapi perah lesu nafsu makan berkurang pasca hujan deras.',
        'consultation_type' => 'telemedisin',
        'status' => 'selesai',
        'doctor_notes' => 'Demam ringan pasca cuaca ekstrem. Dianjurkan hidrasi elektrolit hangat.',
        'prescription' => 'Antipiretik injeksi + Vitamin B kompleks 10ml.',
    ]);

    $response = $this->actingAs($peternak)->get(route('konsultasi.rekam-medis.download', [
        'type' => 'consultation',
        'id' => $consultation->id,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Lembar Hasil Rekam Medis &amp; Petunjuk Penanganan Ternak', false);
    $response->assertSee('Dinas Peternakan');
    $response->assertSee('ETAG-PAS-099');
    $response->assertSee('Lestari Ayu');
    $response->assertSee('Pemeriksaan Demam Transien');
    $response->assertSee('Demam ringan pasca cuaca ekstrem');
    $response->assertSee('Antipiretik injeksi + Vitamin B kompleks 10ml');
    $response->assertSee('Petunjuk &amp; Cara Penanganan Ternak untuk Peternak di Kandang', false);
    $response->assertSee('Isolasi &amp; Kenyamanan Kandang', false);
    $response->assertSee('Tata Cara Pemberian Obat &amp; Terapi', false);
    $response->assertSee('Manajemen Pakan &amp; Nutrisi Pemulihan', false);
    $response->assertSee('Biosecurity &amp; Sanitasi Kawanan', false);
    $response->assertSee('Pemantauan Suhu &amp; Tanda Vital Harian', false);
    $response->assertSee('Cetak / Simpan PDF');
    $response->assertSee('Unduh Dokumen (.doc)');
});

test('unauthorized peternak cannot access other users medical record document', function () {
    $peternakOwner = User::factory()->peternak()->create();
    $otherPeternak = User::factory()->peternak()->create();

    $consultation = Consultation::create([
        'user_id' => $peternakOwner->id,
        'subject' => 'Kasus Rahasia Sapi Pak Ahmad',
        'complaint_details' => 'Gejala sensitif',
        'status' => 'selesai',
    ]);

    $response = $this->actingAs($otherPeternak)->get(route('konsultasi.rekam-medis.download', [
        'type' => 'consultation',
        'id' => $consultation->id,
    ]));

    $response->assertStatus(403);
});

<?php

use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    Storage::fake('public');
});

test('peternak can view bimtek offline page with sop guidelines and training cards', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)
        ->get(route('pelatihan', ['tab' => 'bimtek_offline']));

    $response->assertStatus(200);
    $response->assertSee('Bimbingan Teknis (Bimtek) Tatap Muka Lapangan');
    $response->assertSee('BBPP Songgoriti');
    $response->assertSee('Daftar &amp; Unggah Persyaratan', false);
    $response->assertSee('mengunggah dokumen persyaratan terlebih dahulu', false);
    $response->assertSee('dicatat nomor registrasinya', false);
});

test('peternak cannot register bimtek offline without uploading requirement document', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $training = Training::where('is_online', false)->first();

    $response = $this->actingAs($peternak)
        ->from(route('pelatihan', ['tab' => 'bimtek_offline']))
        ->post(route('pelatihan.register.offline', $training), [
            'nik' => '3514081203760001',
            'phone_number' => '081234567890',
            // requirement_document omitted
        ]);

    $response->assertSessionHasErrors('requirement_document');
    expect(TrainingRegistration::where('user_id', $peternak->id)->where('training_id', $training->id)->count())->toBe(0);
});

test('peternak registers bimtek offline with document: records registration code, uploads file, and decrements quota', function () {
    $peternak = User::factory()->create([
        'name' => 'Ahmad Fauzi Peternak',
        'role' => 'peternak',
    ]);

    $training = Training::where('is_online', false)->first();
    $initialQuota = $training->remaining_quota;

    $file = UploadedFile::fake()->create('surat_keterangan_peternak.pdf', 500, 'application/pdf');

    $response = $this->actingAs($peternak)
        ->from(route('pelatihan', ['tab' => 'bimtek_offline']))
        ->post(route('pelatihan.register.offline', $training), [
            'nik' => '3514081203760001',
            'phone_number' => '081234567890',
            'farm_name' => 'Kelompok Ternak Sumber Makmur',
            'requirement_document' => $file,
            'notes' => 'Komoditas Sapi Perah 12 Ekor',
        ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'bimtek_offline']));
    $response->assertSessionHas('success');
    $response->assertSessionHas('registered_ticket');

    $registration = TrainingRegistration::where('user_id', $peternak->id)
        ->where('training_id', $training->id)
        ->first();

    expect($registration)->not->toBeNull();
    expect($registration->registration_code)->toStartWith('REG-BMTK-');
    expect($registration->nik)->toBe('3514081203760001');
    expect($registration->phone_number)->toBe('081234567890');
    expect($registration->farm_name)->toBe('Kelompok Ternak Sumber Makmur');
    expect($registration->requirement_document_name)->toBe('surat_keterangan_peternak.pdf');
    expect($registration->requirement_document_path)->not->toBeNull();

    // Verify file storage
    Storage::disk('public')->assertExists($registration->requirement_document_path);

    // Verify quota decremented
    expect($training->fresh()->remaining_quota)->toBe($initialQuota - 1);
});

test('peternak and admin can download uploaded requirement document securely while other peternak is forbidden', function () {
    $owner = User::factory()->create(['role' => 'peternak']);
    $otherPeternak = User::factory()->create(['role' => 'peternak']);
    $admin = User::where('role', 'admin')->first();

    $training = Training::where('is_online', false)->first();

    $filePath = 'persyaratan_bimtek/test_persyaratan_doc.pdf';
    Storage::disk('public')->put($filePath, 'konten berkas persyaratan peternak');

    $registration = TrainingRegistration::create([
        'training_id' => $training->id,
        'user_id' => $owner->id,
        'registration_code' => 'REG-BMTK-TEST-001',
        'status' => 'pending',
        'registered_at' => now(),
        'requirement_document_path' => $filePath,
        'requirement_document_name' => 'ktp_surat_ternak.pdf',
        'nik' => '3514081203760002',
    ]);

    // Owner peternak can download
    $ownerResponse = $this->actingAs($owner)
        ->get(route('pelatihan.registration.document', $registration));
    $ownerResponse->assertStatus(200);

    // Other peternak is forbidden (403)
    $otherResponse = $this->actingAs($otherPeternak)
        ->get(route('pelatihan.registration.document', $registration));
    $otherResponse->assertStatus(403);

    // Admin can download
    $adminResponse = $this->actingAs($admin)
        ->get(route('pelatihan.registration.document', $registration));
    $adminResponse->assertStatus(200);
});

test('admin can update peternak bimtek registration verification status', function () {
    $admin = User::where('role', 'admin')->first();
    $peternak = User::factory()->create(['role' => 'peternak']);
    $training = Training::where('is_online', false)->first();

    $registration = TrainingRegistration::create([
        'training_id' => $training->id,
        'user_id' => $peternak->id,
        'registration_code' => 'REG-BMTK-TEST-999',
        'status' => 'pending',
        'registered_at' => now(),
    ]);

    $response = $this->actingAs($admin)
        ->patch(route('pelatihan.registration.status', $registration), [
            'status' => 'confirmed',
            'tab' => 'bimtek_offline',
        ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'bimtek_offline']));
    expect($registration->fresh()->status)->toBe('confirmed');
});

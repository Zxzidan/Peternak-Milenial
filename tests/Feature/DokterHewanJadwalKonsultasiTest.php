<?php

use App\Models\Consultation;
use App\Models\ConsultationSchedule;
use App\Models\Livestock;
use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('dokter_hewan can view schedule and quota management page', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    expect($vetUser)->not->toBeNull();

    $response = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index'));
    $response->assertStatus(200);
    $response->assertSee('Kuota Layanan Konsultasi');
    $response->assertSee('Slot Jadwal Hari Ini');
    $response->assertSee('Total Kuota Hari Ini');
    $response->assertSee('Generate Slot Harian');
    $response->assertSee('Tambah Slot Jam Baru');
});

test('dokter_hewan can create a new consultation slot with hourly quota', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $vet = Veterinarian::where('user_id', $vetUser->id)->first() ?? Veterinarian::first();

    $targetDate = now()->addDays(2)->toDateString();

    $response = $this->actingAs($vetUser)->post(route('dokter-hewan.jadwal.store'), [
        'date' => $targetDate,
        'start_time' => '13:00',
        'end_time' => '14:00',
        'quota' => 6,
        'service_type' => 'konsultasi_online',
        'notes' => 'Sesi siang pemeriksaan telemedisin',
    ]);

    $response->assertRedirect(route('dokter-hewan.jadwal.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('consultation_schedules', [
        'veterinarian_id' => $vet->id,
        'start_time' => '13:00',
        'quota' => 6,
        'status' => 'buka',
    ]);
});

test('dokter_hewan can generate daily slots automatically from 08:00 to 15:00', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $vet = Veterinarian::where('user_id', $vetUser->id)->first() ?? Veterinarian::first();

    $targetDate = now()->addDays(5)->toDateString();

    $response = $this->actingAs($vetUser)->post(route('dokter-hewan.jadwal.generate'), [
        'date' => $targetDate,
        'default_quota' => 4,
        'service_type' => 'konsultasi_online',
    ]);

    $response->assertRedirect(route('dokter-hewan.jadwal.index'));
    $response->assertSessionHas('success');

    // Should create 7 hourly slots: 08-09, 09-10, 10-11, 11-12, 12-13, 13-14, 14-15
    $count = ConsultationSchedule::where('veterinarian_id', $vet->id)
        ->whereDate('date', $targetDate)
        ->count();

    expect($count)->toBe(7);
});

test('dokter_hewan can toggle slot status between buka and tutup', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $slot = ConsultationSchedule::first();
    expect($slot)->not->toBeNull();

    $originalStatus = $slot->status;
    $expectedStatus = $originalStatus === 'buka' ? 'tutup' : 'buka';

    $response = $this->actingAs($vetUser)->patch(route('dokter-hewan.jadwal.toggle', $slot));
    $response->assertRedirect();

    $slot->refresh();
    expect($slot->status)->toBe($expectedStatus);
});

test('dokter_hewan can update slot quota and notes', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $slot = ConsultationSchedule::first();

    $response = $this->actingAs($vetUser)->put(route('dokter-hewan.jadwal.update', $slot), [
        'quota' => 10,
        'service_type' => 'tatap_muka',
        'notes' => 'Diperluas untuk 10 pendaftar',
    ]);

    $response->assertRedirect();
    $slot->refresh();
    expect($slot->quota)->toBe(10)
        ->and($slot->notes)->toBe('Diperluas untuk 10 pendaftar');
});

test('peternak view replaces active chat box with consultation schedule booking section', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)->get(route('konsultasi'));
    $response->assertStatus(200);

    // Ensure the old active chat box has been removed
    $response->assertDontSee('Konsultasi Medis Aktif:');
    $response->assertDontSee('Ketik balasan untuk dokter hewan...');

    // Ensure consultation booking modal has been removed
    $response->assertDontSee('id="modal-atur-jadwal"', false);
    $response->assertDontSee('Atur Jadwal Konsultasi Dokter Hewan');
});

test('peternak can query doctor available slots with quota JSON', function () {
    $peternak = User::where('role', 'peternak')->first();
    $vet = Veterinarian::first();

    $response = $this->actingAs($peternak)->getJson(route('konsultasi.veterinarians.slots', [
        'veterinarian' => $vet->id,
        'date' => now()->toDateString(),
    ]));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'doctor_name',
        'date',
        'slots' => [
            '*' => ['id', 'time_label', 'quota', 'booked_count', 'remaining_quota', 'is_full', 'service_type'],
        ],
    ]);
});

test('peternak can book an available consultation slot and lock quota', function () {
    $peternak = User::where('role', 'peternak')->first();
    $vet = Veterinarian::first();
    $livestock = Livestock::where('user_id', $peternak->id)->first();

    // Create a slot with quota 2
    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(3)->toDateString(),
        'start_time' => '10:00',
        'end_time' => '11:00',
        'quota' => 2,
        'status' => 'buka',
        'service_type' => 'konsultasi_online',
    ]);

    expect($slot->remaining_quota)->toBe(2);

    $response = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slot->id,
        'livestock_id' => $livestock?->id,
        'consultation_date' => $slot->date->toDateString(),
        'consultation_type' => 'konsultasi_online',
        'subject' => 'Sapi perah nafsu makan turun drastis',
        'complaint_details' => 'Suhu 39.5, tidak mau makan konsentrat sejak tadi pagi.',
    ]);

    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('success');

    $slot->refresh();
    expect($slot->remaining_quota)->toBe(1)
        ->and($slot->booked_count)->toBe(1)
        ->and($slot->is_full)->toBeFalse();

    $this->assertDatabaseHas('consultations', [
        'user_id' => $peternak->id,
        'consultation_schedule_id' => $slot->id,
        'status' => 'menunggu_konfirmasi',
    ]);
});

test('peternak cannot book a slot when quota is already full', function () {
    $peternak = User::where('role', 'peternak')->first();
    $vet = Veterinarian::first();

    // Create a slot with quota 1 and already booked
    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(4)->toDateString(),
        'start_time' => '09:00',
        'end_time' => '10:00',
        'quota' => 1,
        'status' => 'buka',
        'service_type' => 'konsultasi_online',
    ]);

    Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slot->id,
        'booking_code' => 'TEST-001',
        'consultation_date' => $slot->date->toDateString(),
        'consultation_time' => '09:00 - 10:00 WIB',
        'subject' => 'Booking 1',
        'complaint_details' => 'Keluhan 1',
        'consultation_type' => 'konsultasi_online',
        'status' => 'menunggu_konfirmasi',
    ]);

    $slot->refresh();
    expect($slot->is_full)->toBeTrue();

    // Try booking again
    $response = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slot->id,
        'consultation_date' => $slot->date->toDateString(),
        'consultation_type' => 'konsultasi_online',
        'subject' => 'Booking Kedua Gagal',
        'complaint_details' => 'Harus ditolak karena kuota penuh.',
    ]);

    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('error');
});

test('peternak can cancel booking and quota is restored', function () {
    $peternak = User::where('role', 'peternak')->first();
    $vet = Veterinarian::first();

    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(6)->toDateString(),
        'start_time' => '11:00',
        'end_time' => '12:00',
        'quota' => 1,
        'status' => 'buka',
        'service_type' => 'konsultasi_online',
    ]);

    $booking = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slot->id,
        'booking_code' => 'CANCEL-001',
        'consultation_date' => $slot->date->toDateString(),
        'consultation_time' => '11:00 - 12:00 WIB',
        'subject' => 'Akan Dibatalkan',
        'complaint_details' => 'Peternak membatalkan janji temu',
        'consultation_type' => 'konsultasi_online',
        'status' => 'menunggu_konfirmasi',
    ]);

    $slot->refresh();
    expect($slot->is_full)->toBeTrue();

    // Peternak cancels booking
    $response = $this->actingAs($peternak)->delete(route('konsultasi.cancel', $booking));
    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('success');

    $booking->refresh();
    expect($booking->status)->toBe('dibatalkan');

    // Quota should be available again!
    $slot->refresh();
    expect($slot->remaining_quota)->toBe(1)
        ->and($slot->is_full)->toBeFalse();
});

test('dokter_hewan can confirm and complete consultation with doctor notes and prescription', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $booking = Consultation::where('status', '!=', 'dibatalkan')->first();
    expect($booking)->not->toBeNull();

    // Confirm booking
    $response1 = $this->actingAs($vetUser)->patch(route('dokter-hewan.jadwal.booking.status', $booking), [
        'status' => 'dikonfirmasi',
    ]);
    $response1->assertRedirect();

    $booking->refresh();
    expect($booking->status)->toBe('dikonfirmasi');

    // Complete booking with medical notes
    $response2 = $this->actingAs($vetUser)->patch(route('dokter-hewan.jadwal.booking.status', $booking), [
        'status' => 'selesai',
        'doctor_notes' => 'Pasien telah sembuh setelah injeksi vitamin & istirahat pakan.',
        'prescription' => 'Berikan multivitamin oral 1x sehari selama 3 hari.',
    ]);
    $response2->assertRedirect();

    $booking->refresh();
    expect($booking->status)->toBe('selesai')
        ->and($booking->doctor_notes)->toContain('Pasien telah sembuh')
        ->and($booking->prescription)->toContain('Berikan multivitamin');
});

test('peternak can immediately retrieve slots added by drh fauzi without date format mismatch', function () {
    $vet = Veterinarian::where('name', 'like', '%Fauzi%')->first();
    expect($vet)->not->toBeNull();

    $peternak = User::where('role', 'peternak')->first();
    $targetDate = now()->addDays(1)->toDateString();

    // Doctor Fauzi creates a slot
    ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => $targetDate,
        'start_time' => '08:00',
        'end_time' => '09:00',
        'quota' => 5,
        'status' => 'buka',
        'service_type' => 'konsultasi_online',
    ]);

    // Peternak queries slots for that date
    $response = $this->actingAs($peternak)->getJson(route('konsultasi.veterinarians.slots', [
        'veterinarian' => $vet->id,
        'date' => $targetDate,
    ]));

    $response->assertStatus(200);
    $response->assertJson([
        'doctor_name' => $vet->name,
        'date' => $targetDate,
    ]);

    $data = $response->json();
    expect($data['slots'])->toHaveCount(1)
        ->and($data['slots'][0]['time_label'])->toBe('08:00 - 09:00 WIB')
        ->and($data['slots'][0]['quota'])->toBe(5)
        ->and($data['available_dates'])->toContain($targetDate);
});

test('peternak can book consultation using online or offline method', function () {
    $peternak = User::where('role', 'peternak')->first();
    $vet = Veterinarian::first();

    $slotOnline = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(5)->toDateString(),
        'start_time' => '10:00',
        'end_time' => '11:00',
        'quota' => 2,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    $resOnline = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slotOnline->id,
        'consultation_date' => $slotOnline->date->toDateString(),
        'consultation_type' => 'online',
        'subject' => 'Konsultasi Online Ternak',
        'complaint_details' => 'Nafsu makan menurun.',
    ]);

    $resOnline->assertRedirect(route('konsultasi'));
    $this->assertDatabaseHas('consultations', [
        'consultation_schedule_id' => $slotOnline->id,
        'consultation_type' => 'online',
    ]);

    $slotOffline = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(6)->toDateString(),
        'start_time' => '13:00',
        'end_time' => '14:00',
        'quota' => 2,
        'status' => 'buka',
        'service_type' => 'offline',
    ]);

    $resOffline = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'veterinarian_id' => $vet->id,
        'consultation_schedule_id' => $slotOffline->id,
        'consultation_date' => $slotOffline->date->toDateString(),
        'consultation_type' => 'offline',
        'subject' => 'Konsultasi Offline Tatap Muka',
        'complaint_details' => 'Vaksinasi booster.',
    ]);

    $resOffline->assertRedirect(route('konsultasi'));
    $this->assertDatabaseHas('consultations', [
        'consultation_schedule_id' => $slotOffline->id,
        'consultation_type' => 'offline',
    ]);
});

test('dokter_hewan can view registered patients per slot and sees whatsapp link for online consultations', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $vet = Veterinarian::where('user_id', $vetUser->id)->first() ?? Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $peternak->update(['phone_number' => '08123456789']);

    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(3)->toDateString(),
        'start_time' => '14:00',
        'end_time' => '15:00',
        'quota' => 4,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vetUser->id,
        'consultation_schedule_id' => $slot->id,
        'booking_code' => 'BOOK-TEST-WA',
        'consultation_date' => $slot->date->toDateString(),
        'consultation_time' => $slot->time_slot_label,
        'subject' => 'Pemeriksaan Online Sapi Batuk',
        'complaint_details' => 'Batuk pilek sejak 2 hari.',
        'consultation_type' => 'online',
        'status' => 'menunggu_konfirmasi',
    ]);

    $response = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index'));
    $response->assertStatus(200);

    // Verify slot table contains Pasien button
    $response->assertSee('Pasien (1)');
    $response->assertSee("openSlotPatientsModal({$slot->id})", false);

    // Verify modal contains patient details, Online badge and WhatsApp redirect link
    $response->assertSee("modal-pasien-slot-{$slot->id}");
    $response->assertSee('BOOK-TEST-WA');
    $response->assertSee('Konsultasi Online');
    $response->assertSee('Arahkan ke WhatsApp');
    $response->assertSee('https://wa.me/628123456789', false);
});

test('peternak can book consultation slot without complaint_details and livestock_id', function () {
    $vet = Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(2)->toDateString(),
        'start_time' => '14:00',
        'end_time' => '15:00',
        'quota' => 3,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    $response = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'consultation_schedule_id' => $slot->id,
        'consultation_type' => 'online',
        'subject' => 'Konsultasi Nafsu Makan',
    ]);

    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('consultations', [
        'user_id' => $peternak->id,
        'consultation_schedule_id' => $slot->id,
        'subject' => 'Konsultasi Nafsu Makan',
        'complaint_details' => null,
        'livestock_id' => null,
        'status' => 'menunggu_konfirmasi',
    ]);
});

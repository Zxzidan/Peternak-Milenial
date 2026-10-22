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
    $response->assertSee('<span>Edit</span>', false);
    $response->assertDontSee('<span>Edit Kuota</span>', false);
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

test('dokter_hewan can update slot time, quota, and notes', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $slot = ConsultationSchedule::first();

    $response = $this->actingAs($vetUser)->put(route('dokter-hewan.jadwal.update', $slot), [
        'start_time' => '07:30',
        'end_time' => '08:45',
        'quota' => 10,
        'service_type' => 'tatap_muka',
        'notes' => 'Diperluas untuk 10 pendaftar',
    ]);

    $response->assertRedirect();
    $slot->refresh();
    expect($slot->quota)->toBe(10)
        ->and(substr((string) $slot->start_time, 0, 5))->toBe('07:30')
        ->and(substr((string) $slot->end_time, 0, 5))->toBe('08:45')
        ->and($slot->notes)->toBe('Diperluas untuk 10 pendaftar');
});

test('peternak view replaces active chat box with consultation schedule booking section', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)->get(route('konsultasi'));
    $response->assertStatus(200);

    // Ensure the old active chat box has been removed
    $response->assertDontSee('Konsultasi Medis Aktif:');
    $response->assertDontSee('Ketik balasan untuk dokter hewan...');

    // Ensure consultation booking modal and appointment system is present
    $response->assertSee('id="modal-atur-jadwal"', false);
    $response->assertSee('Atur Jadwal Konsultasi Dokter Hewan');
    $response->assertSee('Pilih Jam Konsultasi');
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

test('dokter_hewan cannot edit diagnosis once consultation is already selesai', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $booking = Consultation::where('status', '!=', 'dibatalkan')->first();
    expect($booking)->not->toBeNull();

    $booking->update([
        'status' => 'selesai',
        'doctor_notes' => 'Diagnosis awal sebelum dikunci.',
        'prescription' => 'Resep awal sebelum dikunci.',
    ]);

    $originalNotes = $booking->doctor_notes;
    $originalPrescription = $booking->prescription;

    $response = $this->actingAs($vetUser)->patch(route('dokter-hewan.jadwal.booking.status', $booking), [
        'status' => 'selesai',
        'doctor_notes' => 'Mencoba mengubah diagnosis yang sudah selesai.',
        'prescription' => 'Mencoba resep baru yang diubah.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    $booking->refresh();
    expect($booking->doctor_notes)->toBe($originalNotes)
        ->and($booking->prescription)->toBe($originalPrescription);
});

test('dokter_hewan cannot delete consultation that is already selesai', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $booking = Consultation::where('status', '!=', 'dibatalkan')->first();
    expect($booking)->not->toBeNull();

    $booking->update([
        'status' => 'selesai',
        'doctor_notes' => 'Diagnosis tuntas.',
    ]);

    $response = $this->actingAs($vetUser)->delete(route('dokter-hewan.jadwal.booking.destroy', $booking));

    $response->assertRedirect();
    $response->assertSessionHas('error');

    $booking->refresh();
    expect($booking->status)->toBe('selesai');
});

test('completed consultation view in rekam medis tab does not show edit diagnosis button and shows diagnosis terkunci', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $vet = Veterinarian::where('user_id', $vetUser->id)->first() ?? Veterinarian::first();
    $booking = Consultation::where('status', '!=', 'dibatalkan')->first();
    expect($booking)->not->toBeNull();

    $booking->update([
        'veterinarian_id' => $vetUser->id,
        'status' => 'selesai',
        'doctor_notes' => 'Diagnosis resmi tercatat.',
    ]);

    $response = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis']));
    $response->assertOk();
    $response->assertDontSee('Edit Diagnosis');
    $response->assertSee('Diagnosis Terkunci');
    $response->assertSee('Selesai pukul');
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

test('peternak can book consultation slot without subject input (defaults to complaint_details or fallback)', function () {
    $vet = Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => now()->addDays(3)->toDateString(),
        'start_time' => '10:00',
        'end_time' => '11:00',
        'quota' => 2,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    $response = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'consultation_schedule_id' => $slot->id,
        'consultation_type' => 'online',
        'complaint_details' => 'Sapi perah tampak lemas dan tidak mau berdiri sejak kemarin sore.',
    ]);

    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('consultations', [
        'user_id' => $peternak->id,
        'consultation_schedule_id' => $slot->id,
        'complaint_details' => 'Sapi perah tampak lemas dan tidak mau berdiri sejak kemarin sore.',
        'livestock_id' => null,
        'status' => 'menunggu_konfirmasi',
    ]);
});

test('getDoctorSlots excludes slots whose end time has already passed for today', function () {
    $vet = Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $today = now('Asia/Jakarta')->toDateString();

    // Expired slot (00:00 - 00:01)
    $expiredSlot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => $today,
        'start_time' => '00:00',
        'end_time' => '00:01',
        'quota' => 5,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    // Future slot (23:50 - 23:59)
    $futureSlot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => $today,
        'start_time' => '23:50',
        'end_time' => '23:59',
        'quota' => 5,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    $response = $this->actingAs($peternak)->getJson(route('konsultasi.veterinarians.slots', [
        'veterinarian' => $vet->id,
        'date' => $today,
    ]));

    $response->assertStatus(200);
    $slotIds = collect($response->json('slots'))->pluck('id')->all();

    expect($slotIds)->not->toContain($expiredSlot->id)
        ->and($slotIds)->toContain($futureSlot->id);
});

test('peternak cannot book a consultation slot whose end time has already passed', function () {
    $vet = Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $today = now('Asia/Jakarta')->toDateString();

    $expiredSlot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => $today,
        'start_time' => '00:00',
        'end_time' => '00:01',
        'quota' => 5,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    $response = $this->actingAs($peternak)->post(route('konsultasi.book'), [
        'consultation_schedule_id' => $expiredSlot->id,
        'consultation_type' => 'online',
        'complaint_details' => 'Mencoba memesan slot yang sudah lewat batas waktu.',
    ]);

    $response->assertRedirect(route('konsultasi'));
    $response->assertSessionHas('error');

    $this->assertDatabaseMissing('consultations', [
        'consultation_schedule_id' => $expiredSlot->id,
        'user_id' => $peternak->id,
    ]);
});

test('dokter_hewan can delete a consultation booking and it is retained as cancelled history', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $consultation = Consultation::first();
    expect($consultation)->not->toBeNull();

    $response = $this->actingAs($vetUser)->delete(route('dokter-hewan.jadwal.booking.destroy', $consultation));
    $response->assertRedirect(route('dokter-hewan.jadwal.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('consultations', [
        'id' => $consultation->id,
        'status' => 'dibatalkan',
        'consultation_schedule_id' => null,
    ]);
});

test('dokter_hewan can delete a schedule slot and attached bookings are retained as cancelled history', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $slot = ConsultationSchedule::has('consultations')->first();
    expect($slot)->not->toBeNull();

    $bookingIds = $slot->consultations->pluck('id')->all();
    expect($bookingIds)->not->toBeEmpty();

    $response = $this->actingAs($vetUser)->delete(route('dokter-hewan.jadwal.destroy', $slot));
    $response->assertRedirect(route('dokter-hewan.jadwal.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('consultation_schedules', [
        'id' => $slot->id,
    ]);

    foreach ($bookingIds as $bId) {
        $this->assertDatabaseHas('consultations', [
            'id' => $bId,
            'status' => 'dibatalkan',
            'consultation_schedule_id' => null,
        ]);
    }
});

test('peternak sees cancellation history and prompt to select a new doctor when booking is deleted by doctor', function () {
    $peternak = User::where('role', 'peternak')->first();
    expect($peternak)->not->toBeNull();

    $vet = Veterinarian::first();
    $vetUser = $vet->user ?? User::where('role', 'dokter_hewan')->first();

    $consultation = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vetUser->id,
        'booking_code' => 'TEST-CANCELLED-DOC-01',
        'subject' => 'Pemeriksaan Kambing Demam',
        'complaint_details' => 'Suhu tubuh panas sejak kemarin',
        'consultation_date' => now()->toDateString(),
        'consultation_time' => '09:00 - 10:00 WIB',
        'status' => 'dibatalkan',
        'doctor_notes' => 'Jadwal reservasi konsultasi ini telah dihapus oleh dokter hewan. Anda diminta untuk memilih dokter hewan yang baru atau mengatur ulang jadwal konsultasi.',
    ]);

    $response = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'jadwal']));
    $response->assertOk();
    $response->assertSee('TEST-CANCELLED-DOC-01');
    $response->assertSee('Riwayat Jadwal Dihapus / Dibatalkan');
    $response->assertSee('Jadwal Dihapus Dokter');
    $response->assertSee('Pilih Dokter yang Baru');
});

test('completed consultation is not shown in reservation section but appears in rekam medis', function () {
    $peternak = User::where('role', 'peternak')->first();
    expect($peternak)->not->toBeNull();

    $vet = Veterinarian::first();
    $vetUser = $vet->user ?? User::where('role', 'dokter_hewan')->first();

    $completedBooking = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vetUser->id,
        'booking_code' => 'TEST-COMPLETED-RM-01',
        'subject' => 'Pemeriksaan Sapi Bunting',
        'complaint_details' => 'Cek kebuntingan trimester 2',
        'doctor_notes' => 'Kondisi janin ternak sehat dan aktif.',
        'prescription' => 'Vitamin ADE 10ml, suplemen kalsium pakan.',
        'consultation_date' => now()->toDateString(),
        'consultation_time' => '10:00 - 11:00 WIB',
        'status' => 'selesai',
    ]);

    // In reservation tab (jadwal), completed consultation MUST NOT be displayed
    $resResponse = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'jadwal']));
    $resResponse->assertOk();
    $resResponse->assertDontSee('TEST-COMPLETED-RM-01');

    // In rekam_medis tab, completed consultation MUST be displayed
    $rmResponse = $this->actingAs($peternak)->get(route('konsultasi', ['tab' => 'rekam_medis']));
    $rmResponse->assertOk();
    $rmResponse->assertSee('TEST-COMPLETED-RM-01');
    $rmResponse->assertSee('Kondisi janin ternak sehat dan aktif.');
    $rmResponse->assertSee('Vitamin ADE 10ml, suplemen kalsium pakan.');
});

test('dokter_hewan schedule excludes completed consultations from slot patient modal and displays them in rekam medis section with filter', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();
    $vet = Veterinarian::where('user_id', $vetUser->id)->first() ?? Veterinarian::first();
    $peternak = User::where('role', 'peternak')->first();

    $today = now()->toDateString();
    $slot = ConsultationSchedule::create([
        'veterinarian_id' => $vet->id,
        'date' => $today,
        'start_time' => '10:00',
        'end_time' => '11:00',
        'quota' => 5,
        'status' => 'buka',
        'service_type' => 'online',
    ]);

    // Active consultation (still waiting for examination)
    $activeConsultation = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vetUser->id,
        'consultation_schedule_id' => $slot->id,
        'booking_code' => 'TEST-ACTIVE-PATIENT-99',
        'subject' => 'Pemeriksaan Demam Ternak',
        'complaint_details' => 'Suhu tinggi belum sembuh',
        'consultation_date' => $today,
        'consultation_time' => '10:00 - 11:00 WIB',
        'status' => 'dikonfirmasi',
    ]);

    // Completed consultation (already finished by doctor)
    $completedConsultation = Consultation::create([
        'user_id' => $peternak->id,
        'veterinarian_id' => $vetUser->id,
        'consultation_schedule_id' => $slot->id,
        'booking_code' => 'TEST-FINISHED-PATIENT-88',
        'subject' => 'Pemeriksaan Sapi Mastitis',
        'complaint_details' => 'Puting bengkak dan susu menggumpal',
        'doctor_notes' => 'Mastitis subklinis kuadran kanan depan.',
        'prescription' => 'Intramammary antibiotik 1 syringe + antiinflamasi.',
        'consultation_date' => $today,
        'consultation_time' => '10:00 - 11:00 WIB',
        'status' => 'selesai',
    ]);

    $response = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index'));
    $response->assertOk();

    // 1. The modal for the slot must contain the active patient
    $response->assertSee('TEST-ACTIVE-PATIENT-99');
    $response->assertSee('Daftar Pasien Menunggu Pemeriksaan');

    // 2. The modal's patient table list must NOT contain the finished patient as an active row
    // We check that in modal-pasien-slot-$slot->id, only active patients are listed
    $content = $response->getContent();
    $modalStart = strpos($content, "id=\"modal-pasien-slot-{$slot->id}\"");
    $modalEnd = strpos($content, '<!-- Modal Footer -->', $modalStart);
    $modalHtml = substr($content, $modalStart, $modalEnd - $modalStart);

    expect($modalHtml)->toContain('TEST-ACTIVE-PATIENT-99');
    expect($modalHtml)->not->toContain('TEST-FINISHED-PATIENT-88');

    // 3. The dedicated Rekam Medis section MUST contain the completed consultation
    $response->assertSee('Riwayat Pemeriksaan & Rekam Medis Pasien', false);
    $response->assertSee('TEST-FINISHED-PATIENT-88');
    $response->assertSee('Mastitis subklinis kuadran kanan depan.');
    $response->assertSee('Intramammary antibiotik 1 syringe + antiinflamasi.', false);
    $response->assertSee('Selesai Ditangani');
    $response->assertSee(route('konsultasi.rekam-medis.download', ['type' => 'consultation', 'id' => $completedConsultation->id]));

    // 4. Test date filter for Rekam Medis
    $filterMatchResponse = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', [
        'filter_rm_date' => $today,
    ]));
    $filterMatchResponse->assertOk();
    $filterMatchResponse->assertSee('TEST-FINISHED-PATIENT-88');

    $yesterday = now()->subDays(10)->toDateString();
    $filterMismatchResponse = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', [
        'filter_rm_date' => $yesterday,
    ]));
    $filterMismatchResponse->assertOk();
    $filterMismatchResponse->assertDontSee('TEST-FINISHED-PATIENT-88');
    $filterMismatchResponse->assertSee('Tidak ada riwayat rekam medis yang sesuai filter');

    // 5. Test search filter for Rekam Medis
    $searchMatchResponse = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', [
        'search_rm' => 'Mastitis',
    ]));
    $searchMatchResponse->assertOk();
    $searchMatchResponse->assertSee('TEST-FINISHED-PATIENT-88');

    $searchMismatchResponse = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', [
        'search_rm' => 'NonExistentKeywordXYZ123',
    ]));
    $searchMismatchResponse->assertOk();
    $searchMismatchResponse->assertDontSee('TEST-FINISHED-PATIENT-88');
});

test('dokter_hewan schedule page renders navbar tabs and switches between slot and rekam medis views', function () {
    $vetUser = User::where('role', 'dokter_hewan')->first();

    // Default view: tab is slot
    $responseDefault = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index'));
    $responseDefault->assertOk();
    $responseDefault->assertSee('id="tab-btn-slot"', false);
    $responseDefault->assertSee('id="tab-btn-rekam-medis"', false);
    $responseDefault->assertSee('Daftar Slot Jam Layanan');
    $responseDefault->assertSee('Riwayat Pemeriksaan & Rekam Medis', false);
    $responseDefault->assertSee('id="tab-pane-slot" class=""', false);
    $responseDefault->assertSee('id="tab-pane-rekam-medis" class="hidden"', false);

    // Rekam medis tab view
    $responseRm = $this->actingAs($vetUser)->get(route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis']));
    $responseRm->assertOk();
    $responseRm->assertSee('id="tab-pane-slot" class="hidden"', false);
    $responseRm->assertSee('id="tab-pane-rekam-medis" class=""', false);
});

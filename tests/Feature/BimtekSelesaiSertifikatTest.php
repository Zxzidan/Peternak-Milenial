<?php

use App\Models\Certificate;
use App\Models\LearningMaterial;
use App\Models\LearningQuiz;
use App\Models\QuizAttempt;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Models\UserLearningProgress;
use Database\Seeders\BimtekSelesaiSertifikatSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->seed(BimtekSelesaiSertifikatSeeder::class);
});

test('dummy data verifies peternak has completed bimtek registrations and received certificates for online and offline bimtek', function () {
    $peternak = User::where('email', 'slamet@peternak.id')->first();
    expect($peternak)->not->toBeNull();
    expect($peternak->role)->toBe('peternak');

    $trainingOffline = Training::where('slug', 'formulasi-pakan-ransum-silase')->first();
    expect($trainingOffline)->not->toBeNull();
    expect($trainingOffline->has_certificate)->toBeTrue();

    $trainingOnline = Training::where('slug', 'pemasaran-digital-kur-peternakan')->first();
    expect($trainingOnline)->not->toBeNull();
    expect($trainingOnline->has_certificate)->toBeTrue();

    // 1. Verifikasi video pembelajaran selesai ditonton 100%
    $material = LearningMaterial::where('slug', 'teknologi-silase-hay-ternak')->first();
    expect($material)->not->toBeNull();
    $progress = UserLearningProgress::where('user_id', $peternak->id)
        ->where('learning_material_id', $material->id)
        ->first();
    expect($progress)->not->toBeNull();
    expect($progress->is_watched)->toBeTrue();
    expect($progress->watch_percentage)->toBe(100);

    // 2. Verifikasi kuis dan soal selesai dikerjakan untuk evaluasi pemahaman
    $quiz = LearningQuiz::where('learning_material_id', $material->id)->first();
    expect($quiz)->not->toBeNull();

    $attempt = QuizAttempt::where('user_id', $peternak->id)
        ->where('learning_quiz_id', $quiz->id)
        ->first();
    expect($attempt)->not->toBeNull();
    expect($attempt->passed)->toBeTrue();
    expect($attempt->score)->toBe(100);

    // 3. Verifikasi pendaftaran Bimtek Offline & E-Sertifikat terbit
    $regOffline = TrainingRegistration::where('user_id', $peternak->id)
        ->where('training_id', $trainingOffline->id)
        ->first();
    expect($regOffline)->not->toBeNull();

    $certOffline = Certificate::where('user_id', $peternak->id)
        ->where('training_id', $trainingOffline->id)
        ->first();
    expect($certOffline)->not->toBeNull();
    expect($certOffline->certificate_number)->toBe('DISNAK-JATIM/2026/CERT-891');
    expect($certOffline->recipient_name)->toBe($peternak->name);

    // 4. Verifikasi pendaftaran Bimtek Online Zoom & E-Sertifikat terbit
    $regOnline = TrainingRegistration::where('user_id', $peternak->id)
        ->where('training_id', $trainingOnline->id)
        ->first();
    expect($regOnline)->not->toBeNull();

    $certOnline = Certificate::where('user_id', $peternak->id)
        ->where('training_id', $trainingOnline->id)
        ->first();
    expect($certOnline)->not->toBeNull();
    expect($certOnline->certificate_number)->toBe('DISNAK-JATIM/2026/CERT-892');
});

test('peternak can view and download official digital certificate in pelatihan tab sertifikat', function () {
    $peternak = User::where('email', 'slamet@peternak.id')->first();
    $training = Training::where('slug', 'formulasi-pakan-ransum-silase')->first();

    // Peternak mengakses tab sertifikat
    $response = $this->actingAs($peternak)->get(route('pelatihan', ['tab' => 'sertifikat']));
    $response->assertOk();
    $response->assertSee('Sertifikat Kompetensi Digital Saya');
    $response->assertSee('DISNAK-JATIM/2026/CERT-891');
    $response->assertSee($training->title);
    $response->assertSee('Download Sertifikat');

    // Peternak mengunduh / membuka e-sertifikat resmi
    $downloadResponse = $this->actingAs($peternak)->get(route('pelatihan.certificates.download', $training));
    $downloadResponse->assertOk();
    $downloadResponse->assertSee('Sertifikat Kelulusan &amp; Kompetensi', false);
    $downloadResponse->assertSee($peternak->name);
    $downloadResponse->assertSee('DISNAK-JATIM/2026/CERT-891');
    $downloadResponse->assertSee('Dinas Peternakan');
    $downloadResponse->assertSee('Pemerintah Provinsi Jawa Timur');
});

test('submitting quiz answers does NOT generate certificate because quizzes are strictly for evaluation', function () {
    $peternak = User::where('email', 'slamet@peternak.id')->first();
    $training = Training::where('slug', 'formulasi-pakan-ransum-silase')->first();

    // Hapus seluruh sertifikat peternak untuk membuktikan kuis tidak membuat sertifikat
    Certificate::where('user_id', $peternak->id)->delete();

    $quiz = LearningQuiz::where('title', 'like', '%Silase%')->first();
    $questions = $quiz->questions;

    $answers = [];
    foreach ($questions as $q) {
        $answers[$q->id] = $q->correct_answer;
    }

    $response = $this->actingAs($peternak)->post(route('pelatihan.quiz.submit', $quiz), [
        'answers' => $answers,
    ], [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json',
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
        'passed' => true,
        'score' => 100,
    ]);

    // Verifikasi TIDAK ADA sertifikat yang dibuat saat kuis diselesaikan
    $certificatesCount = Certificate::where('user_id', $peternak->id)->count();
    expect($certificatesCount)->toBe(0);
});

test('unregistered peternak cannot download certificate for bimtek they did not join', function () {
    $unregisteredUser = User::factory()->create([
        'name' => 'Peternak Tanpa Bimtek',
        'role' => 'peternak',
    ]);

    $training = Training::where('slug', 'formulasi-pakan-ransum-silase')->first();

    // Pastikan user tidak terdaftar
    TrainingRegistration::where('user_id', $unregisteredUser->id)->delete();
    Certificate::where('user_id', $unregisteredUser->id)->delete();

    $response = $this->actingAs($unregisteredUser)->get(route('pelatihan.certificates.download', $training));

    $response->assertRedirect(route('pelatihan', ['tab' => 'sertifikat']));
    $response->assertSessionHas('error', 'E-Sertifikat hanya diberikan kepada peserta yang terdaftar dan mengikuti program Bimbingan Teknis (Bimtek Online maupun Offline).');
});

test('registered peternak for online zoom bimtek can download certificate', function () {
    $peternak = User::where('email', 'slamet@peternak.id')->first();
    $trainingOnline = Training::where('slug', 'pemasaran-digital-kur-peternakan')->first();

    $response = $this->actingAs($peternak)->get(route('pelatihan.certificates.download', $trainingOnline));
    $response->assertOk();
    $response->assertSee($peternak->name);
    $response->assertSee('DISNAK-JATIM/2026/CERT-892');
});

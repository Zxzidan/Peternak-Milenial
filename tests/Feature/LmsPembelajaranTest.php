<?php

use App\Models\LearningMaterial;
use App\Models\LearningQuiz;
use App\Models\QuizAttempt;
use App\Models\Training;
use App\Models\User;
use App\Models\UserLearningProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('peternak can view LMS learning dashboard with video courses, zoom schedules, and quizzes', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)->get(route('pelatihan'));

    $response->assertOk();
    $response->assertSee('Video Pembelajaran Mandiri (Continue Watching)');
    $response->assertSee('Teknologi Silase &amp; Formulasi Hay Ternak Ruminansia', false);
    $response->assertSee('Jadwal Zoom');
    $response->assertSee('Dr. Ir. Budi Santoso, M.Sc');
});

test('learning route alias /pembelajaran works seamlessly', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)->get(route('pembelajaran'));

    $response->assertOk();
    $response->assertSee('E-Learning Peternak Milenial Jatim');
});

test('peternak can track video watch progress', function () {
    $peternak = User::where('role', 'peternak')->first();
    $material = LearningMaterial::first();

    $response = $this->actingAs($peternak)->post(route('pelatihan.materials.progress', $material), [], [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json',
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
    ]);

    $progress = UserLearningProgress::where('user_id', $peternak->id)
        ->where('learning_material_id', $material->id)
        ->first();

    expect($progress)->not->toBeNull();
    expect($progress->is_watched)->toBeTrue();
    expect($progress->watch_percentage)->toBe(100);
});

test('peternak can submit quiz answers and receive score and pass status', function () {
    $peternak = User::where('role', 'peternak')->first();
    $quiz = LearningQuiz::with('questions')->first();

    // Prepare answers: answering all correctly
    $answers = [];
    foreach ($quiz->questions as $q) {
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
        'score' => 100,
        'passed' => true,
    ]);

    $attempt = QuizAttempt::where('user_id', $peternak->id)
        ->where('learning_quiz_id', $quiz->id)
        ->latest('id')
        ->first();

    expect($attempt)->not->toBeNull();
    expect($attempt->score)->toBe(100);
    expect($attempt->passed)->toBeTrue();
});

test('admin can create video learning module with document upload', function () {
    Storage::fake('public');
    $admin = User::where('role', 'admin')->first();

    $dummyFile = UploadedFile::fake()->create('panduan-nutrisi.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($admin)->post(route('pelatihan.materials.store'), [
        'title' => 'Teknik Manajemen Pakan Konsentrat Berimbang',
        'category' => 'video_praktik',
        'topic' => 'Manajemen Pakan',
        'instructor_name' => 'Dr. Ir. Budi Santoso, M.Sc',
        'author_institution' => 'BBPP Batu',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'duration' => '25 Menit',
        'level' => 'Menengah',
        'description' => 'Panduan formulasi konsentrat menggunakan bahan lokal Jawa Timur.',
        'document_file' => $dummyFile,
    ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'pembelajaran']));

    $created = LearningMaterial::where('title', 'Teknik Manajemen Pakan Konsentrat Berimbang')->first();
    expect($created)->not->toBeNull();
    expect($created->topic)->toBe('Manajemen Pakan');
    expect($created->instructor_name)->toBe('Dr. Ir. Budi Santoso, M.Sc');
});

test('admin can schedule Zoom session with credentials and document', function () {
    Storage::fake('public');
    $admin = User::where('role', 'admin')->first();

    $dummyFile = UploadedFile::fake()->create('silabus-zoom-bimtek.pdf', 512, 'application/pdf');

    $response = $this->actingAs($admin)->post(route('pelatihan.zoom.store'), [
        'title' => 'Webinar Nasional: Ketahanan Pangan Ternak Ruminansia',
        'instructor' => 'Prof. Dr. Ir. Hendrawan, MS',
        'instructor_title' => 'Guru Besar Nutrisi Ternak Fapet UB',
        'start_date' => '2026-11-12',
        'end_date' => '2026-11-12',
        'time_info' => '09:00 - 12:30 WIB',
        'zoom_link' => 'https://zoom.us/j/88392182019?pwd=test',
        'zoom_meeting_id' => '883 9218 2019',
        'zoom_passcode' => 'JATIM2026',
        'quota' => 200,
        'description' => 'Webinar interaktif daring peningkatan ketahanan ternak.',
        'document_upload' => $dummyFile,
    ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'zoom']));

    $created = Training::where('title', 'Webinar Nasional: Ketahanan Pangan Ternak Ruminansia')->first();
    expect($created)->not->toBeNull();
    expect($created->is_online)->toBeTrue();
    expect($created->zoom_meeting_id)->toBe('883 9218 2019');
    expect($created->zoom_passcode)->toBe('JATIM2026');
});

test('admin can add question to an existing quiz', function () {
    $admin = User::where('role', 'admin')->first();
    $quiz = LearningQuiz::first();

    $initialCount = $quiz->questions()->count();

    $response = $this->actingAs($admin)->post(route('pelatihan.quiz.question.store', $quiz), [
        'question' => 'Berapa persentase ideal pemberian konsentrat harian terhadap bobot badan sapi perah?',
        'option_a' => '1% - 2%',
        'option_b' => '5% - 10%',
        'option_c' => '15% - 20%',
        'option_d' => '25% - 30%',
        'correct_answer' => 'a',
        'explanation' => 'Pemberian konsentrat umumnya berkisar antara 1-2% dari bobot badan ternak untuk menjaga keseimbangan rumen.',
    ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'kuis']));

    expect($quiz->questions()->count())->toBe($initialCount + 1);
});

test('peternak can download learning document', function () {
    $peternak = User::where('role', 'peternak')->first();
    $material = LearningMaterial::first();

    $response = $this->actingAs($peternak)->get(route('pelatihan.document.download', [
        'type' => 'material',
        'id' => $material->id,
    ]));

    $response->assertOk();
});

test('admin is prohibited from submitting quiz answers and role is strictly manager', function () {
    $admin = User::where('role', 'admin')->first();
    $quiz = LearningQuiz::first();

    $response = $this->actingAs($admin)->post(route('pelatihan.quiz.submit', $quiz), [
        'answers' => [1 => 'a'],
    ], [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(403);
    $response->assertJson([
        'error' => 'Akun Admin Dinas berfungsi sebagai pengelola pelatihan dan pembuat bank soal, bukan peserta yang mengerjakan kuis evaluasi.',
    ]);
});

test('admin sees trainer management controls and does not see quiz taking button', function () {
    $admin = User::where('role', 'admin')->first();

    $response = $this->actingAs($admin)->get(route('pelatihan', ['tab' => 'kuis']));

    $response->assertOk();
    $response->assertSee('Panel Pengelola Pelatihan');
    $response->assertSee('+ Butir Soal');
    $response->assertDontSee('Kerjakan Soal');
});

test('peternak sees quiz taking button and does not see admin creation controls', function () {
    $peternak = User::where('role', 'peternak')->first();

    $response = $this->actingAs($peternak)->get(route('pelatihan', ['tab' => 'kuis']));

    $response->assertOk();
    $response->assertSee('Kerjakan Soal');
    $response->assertDontSee('+ Tambah Butir Soal Baru');
});

test('admin can create a new quiz for a learning material', function () {
    $admin = User::where('role', 'admin')->first();
    $material = LearningMaterial::create([
        'title' => 'Modul Budidaya Kambing PE Super',
        'slug' => 'modul-kambing-pe',
        'category' => 'video_praktik',
        'topic' => 'Bibit & Budidaya',
        'instructor_name' => 'Dr. Ir. Budi Santoso',
        'author_institution' => 'BBPP Batu',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'is_published' => true,
    ]);

    $response = $this->actingAs($admin)->post(route('pelatihan.quiz.store', $material), [
        'title' => 'Kuis Pemahaman Budidaya Kambing PE',
        'passing_score' => 75,
        'time_limit_minutes' => 20,
        'description' => 'Evaluasi kompetensi bibit kambing PE super.',
    ]);

    $response->assertRedirect(route('pelatihan', ['tab' => 'kuis']));

    $createdQuiz = LearningQuiz::where('learning_material_id', $material->id)->first();
    expect($createdQuiz)->not->toBeNull();
    expect($createdQuiz->title)->toBe('Kuis Pemahaman Budidaya Kambing PE');
    expect($createdQuiz->passing_score)->toBe(75);
});

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom ke learning_materials untuk video & LMS
        Schema::table('learning_materials', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->string('topic')->nullable()->after('category');
            $table->string('video_url')->nullable()->after('file_path');
            $table->string('thumbnail')->nullable()->after('video_url');
            $table->string('instructor_name')->nullable()->after('duration');
            $table->string('level')->default('Dasar')->after('instructor_name');
            $table->integer('views_count')->default(0)->after('downloads_count');
        });

        // 2. Tambah kolom ke trainings untuk integrasi Bimtek via Zoom & materi
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('zoom_link')->nullable()->after('location');
            $table->string('zoom_meeting_id')->nullable()->after('zoom_link');
            $table->string('zoom_passcode')->nullable()->after('zoom_meeting_id');
            $table->string('document_path')->nullable()->after('banner_image');
            $table->string('document_name')->nullable()->after('document_path');
            $table->string('instructor_title')->nullable()->after('instructor');
        });

        // 3. Tabel Kuis Pembelajaran (Quiz Evaluasi per Modul)
        Schema::create('learning_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_material_id')->constrained('learning_materials')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('passing_score')->default(70);
            $table->integer('time_limit_minutes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Tabel Butir Pertanyaan Kuis (Pilihan Ganda A, B, C, D)
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_quiz_id')->constrained('learning_quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('correct_answer'); // 'a', 'b', 'c', 'd'
            $table->text('explanation')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        // 5. Tabel Riwayat Pengerjaan Kuis oleh Peternak (Hasil & Skor)
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_quiz_id')->constrained('learning_quizzes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('score');
            $table->integer('total_questions');
            $table->integer('correct_answers_count');
            $table->json('user_answers')->nullable();
            $table->boolean('passed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 6. Tabel Progres Belajar / Menonton Video Peternak
        Schema::create('user_learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('learning_material_id')->constrained('learning_materials')->cascadeOnDelete();
            $table->boolean('is_watched')->default(false);
            $table->integer('watch_percentage')->default(0);
            $table->timestamp('last_watched_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'learning_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_learning_progress');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('learning_quizzes');

        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn([
                'zoom_link',
                'zoom_meeting_id',
                'zoom_passcode',
                'document_path',
                'document_name',
                'instructor_title',
            ]);
        });

        Schema::table('learning_materials', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'topic',
                'video_url',
                'thumbnail',
                'instructor_name',
                'level',
                'views_count',
            ]);
        });
    }
};

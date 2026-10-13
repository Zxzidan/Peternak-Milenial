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
        // 1. Add wilayah_penugasan to veterinarians if not exists
        if (Schema::hasTable('veterinarians') && ! Schema::hasColumn('veterinarians', 'wilayah_penugasan')) {
            Schema::table('veterinarians', function (Blueprint $table) {
                $table->string('wilayah_penugasan')->nullable()->after('puskeswan');
            });
        }

        // 2. Animal Health Reports (Laporan Kesehatan Hewan oleh Peternak)
        Schema::create('animal_health_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_veterinarian_id')->nullable()->constrained('veterinarians')->nullOnDelete();
            $table->string('livestock_type');
            $table->unsignedInteger('affected_count')->default(1);
            $table->text('symptoms');
            $table->date('symptoms_started_at')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('urgency')->default('sedang'); // rendah, sedang, tinggi, kritis
            $table->string('farm_name')->nullable();
            $table->text('farm_address')->nullable();
            $table->string('kabupaten')->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('status')->default('menunggu_respons')->index();
            $table->timestamp('last_responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        // 3. Animal Health Report Responses (Tanggapan Dokter & Balasan Peternak)
        Schema::create('animal_health_report_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_health_report_id')->constrained('animal_health_reports')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->text('hypothesis')->nullable(); // Dugaan awal
            $table->text('recommendations')->nullable(); // Rekomendasi penanganan
            $table->text('follow_up_instructions')->nullable(); // Instruksi tindak lanjut
            $table->string('urgency_level')->nullable(); // Tingkat urgensi tindak lanjut
            $table->boolean('requires_visit')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Animal Health Report Visits (Kunjungan Lapangan Dokter Hewan)
        Schema::create('animal_health_report_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_health_report_id')->constrained('animal_health_reports')->cascadeOnDelete();
            $table->foreignId('veterinarian_id')->nullable()->constrained('veterinarians')->nullOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->text('visit_reason');
            $table->dateTime('proposed_date');
            $table->dateTime('confirmed_date')->nullable();
            $table->string('status')->default('menunggu_konfirmasi')->index(); // menunggu_konfirmasi, terjadwal, sedang_berlangsung, selesai, dibatalkan
            $table->text('farmer_notes')->nullable();
            $table->text('examination_notes')->nullable();
            $table->text('post_visit_recommendations')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 5. Animal Health Report Status Histories (Audit Trail Perubahan Status)
        Schema::create('animal_health_report_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_health_report_id')->constrained('animal_health_reports')->cascadeOnDelete();
            $table->foreignId('changed_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('previous_status')->nullable();
            $table->string('new_status');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_health_report_status_histories');
        Schema::dropIfExists('animal_health_report_visits');
        Schema::dropIfExists('animal_health_report_responses');
        Schema::dropIfExists('animal_health_reports');

        if (Schema::hasTable('veterinarians') && Schema::hasColumn('veterinarians', 'wilayah_penugasan')) {
            Schema::table('veterinarians', function (Blueprint $table) {
                $table->dropColumn('wilayah_penugasan');
            });
        }
    }
};

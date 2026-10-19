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
        Schema::table('consultations', function (Blueprint $table) {
            $table->foreignId('consultation_schedule_id')->nullable()->after('veterinarian_id')->constrained('consultation_schedules')->nullOnDelete();
            $table->string('booking_code')->nullable()->unique()->after('id');
            $table->foreignId('livestock_id')->nullable()->after('consultation_schedule_id')->constrained('livestock')->nullOnDelete();
            $table->date('consultation_date')->nullable()->after('livestock_id');
            $table->string('consultation_time')->nullable()->after('consultation_date');
            $table->text('complaint_details')->nullable()->after('subject');
            $table->text('doctor_notes')->nullable()->after('complaint_details');
            $table->text('prescription')->nullable()->after('doctor_notes');
            $table->string('consultation_type', 30)->default('telemedisin')->after('prescription');
            $table->string('status', 30)->default('menunggu_konfirmasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['consultation_schedule_id']);
            $table->dropForeign(['livestock_id']);
            $table->dropColumn([
                'consultation_schedule_id',
                'booking_code',
                'livestock_id',
                'consultation_date',
                'consultation_time',
                'complaint_details',
                'doctor_notes',
                'prescription',
                'consultation_type',
            ]);
        });
    }
};

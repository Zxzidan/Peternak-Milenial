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
            $table->foreignId('animal_health_report_id')->nullable()->after('livestock_id')->constrained('animal_health_reports')->nullOnDelete();
        });

        Schema::table('animal_health_reports', function (Blueprint $table) {
            $table->foreignId('consultation_id')->nullable()->after('assigned_veterinarian_id')->constrained('consultations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['animal_health_report_id']);
            $table->dropColumn('animal_health_report_id');
        });

        Schema::table('animal_health_reports', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
            $table->dropColumn('consultation_id');
        });
    }
};

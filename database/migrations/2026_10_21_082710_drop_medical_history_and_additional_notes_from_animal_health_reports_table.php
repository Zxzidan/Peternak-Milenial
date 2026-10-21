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
        Schema::table('animal_health_reports', function (Blueprint $table) {
            $table->dropColumn(['medical_history', 'additional_notes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animal_health_reports', function (Blueprint $table) {
            $table->text('medical_history')->nullable();
            $table->text('additional_notes')->nullable();
        });
    }
};

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
            $table->text('hypothesis')->nullable()->after('doctor_notes');
            $table->string('urgency_level', 30)->nullable()->after('hypothesis');
            $table->text('recommendations')->nullable()->after('prescription');
            $table->text('follow_up_instructions')->nullable()->after('recommendations');
            $table->boolean('requires_visit')->default(false)->after('follow_up_instructions');
            $table->text('doctor_additional_notes')->nullable()->after('requires_visit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'hypothesis',
                'urgency_level',
                'recommendations',
                'follow_up_instructions',
                'requires_visit',
                'doctor_additional_notes',
            ]);
        });
    }
};

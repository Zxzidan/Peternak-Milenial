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
        Schema::create('consultation_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veterinarian_id')->constrained('veterinarians')->cascadeOnDelete();
            $table->date('date');
            $table->string('start_time', 10);
            $table->string('end_time', 10);
            $table->unsignedInteger('quota')->default(3);
            $table->string('status', 20)->default('buka'); // buka, tutup
            $table->string('service_type', 30)->default('semua'); // telemedisin, tatap_muka, semua
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_schedules');
    }
};

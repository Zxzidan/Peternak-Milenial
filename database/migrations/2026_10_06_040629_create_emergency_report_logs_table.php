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
        Schema::create('emergency_report_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_report_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['received', 'verified', 'in_progress', 'resolved']);
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_report_logs');
    }
};

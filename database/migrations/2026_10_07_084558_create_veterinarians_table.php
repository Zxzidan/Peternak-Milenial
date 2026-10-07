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
        Schema::create('veterinarians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('specialization');
            $table->string('puskeswan');
            $table->string('strv_number')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('status')->default('online'); // online, praktik_lapangan, siaga, offline
            $table->string('consultation_hours')->default('08.00 - 16.00 WIB');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinarians');
    }
};

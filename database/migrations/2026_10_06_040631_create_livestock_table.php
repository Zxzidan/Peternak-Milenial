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
        Schema::create('livestock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('e_tag_number')->unique();
            $table->string('name');
            $table->enum('type', ['sapi_perah_fh', 'sapi_potong', 'kambing_senduro', 'domba', 'unggas', 'lainnya'])->default('sapi_perah_fh');
            $table->enum('gender', ['betina', 'jantan'])->default('betina');
            $table->date('birth_date')->nullable();
            $table->string('reproductive_status')->nullable();
            $table->enum('health_status', ['sehat', 'perawatan', 'karantina', 'mati'])->default('sehat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock');
    }
};

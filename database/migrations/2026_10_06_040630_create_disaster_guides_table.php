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
        Schema::create('disaster_guides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('disaster_type', ['erupsi', 'banjir_longsor', 'biosekuriti', 'kekeringan']);
            $table->text('summary');
            $table->longText('content');
            $table->string('sop_document_path')->nullable();
            $table->string('partner_agency')->default('BPBD Jawa Timur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_guides');
    }
};

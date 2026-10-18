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
        Schema::table('training_registrations', function (Blueprint $table) {
            $table->string('requirement_document_path')->nullable()->after('notes');
            $table->string('requirement_document_name')->nullable()->after('requirement_document_path');
            $table->string('nik', 30)->nullable()->after('requirement_document_name');
            $table->string('farm_name')->nullable()->after('nik');
            $table->string('phone_number', 30)->nullable()->after('farm_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'requirement_document_path',
                'requirement_document_name',
                'nik',
                'farm_name',
                'phone_number',
            ]);
        });
    }
};

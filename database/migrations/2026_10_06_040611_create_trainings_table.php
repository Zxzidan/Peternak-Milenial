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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('instructor');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('time_info')->nullable();
            $table->string('location');
            $table->boolean('is_online')->default(false);
            $table->integer('quota')->default(0);
            $table->integer('remaining_quota')->default(0);
            $table->enum('cost_type', ['gratis_apbd', 'daring', 'mandiri'])->default('gratis_apbd');
            $table->enum('status', ['open', 'closed', 'ongoing', 'completed'])->default('open');
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};

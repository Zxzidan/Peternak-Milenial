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
        Schema::create('commodity_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->date('recorded_date');
            $table->decimal('farmer_price', 12, 2);
            $table->decimal('consumer_price', 12, 2);
            $table->decimal('price_change_7d', 12, 2)->default(0);
            $table->decimal('price_change_percentage', 5, 2)->default(0);
            $table->enum('status', ['stabil', 'fluktuatif', 'naik', 'turun'])->default('stabil');
            $table->string('source')->default('KUD & Pasar Induk');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['commodity_id', 'region_id', 'recorded_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_prices');
    }
};

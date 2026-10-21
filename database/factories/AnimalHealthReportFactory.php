<?php

namespace Database\Factories;

use App\Models\AnimalHealthReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnimalHealthReport>
 */
class AnimalHealthReportFactory extends Factory
{
    protected $model = AnimalHealthReport::class;

    public function definition(): array
    {
        return [
            'report_number' => AnimalHealthReport::generateReportNumber(),
            'user_id' => User::factory()->peternak(),
            'assigned_veterinarian_id' => null,
            'livestock_type' => fake()->randomElement(['Sapi Potong', 'Sapi Perah', 'Kambing Etawa', 'Domba Texel', 'Ayam Broiler']),
            'affected_count' => fake()->numberBetween(1, 10),
            'symptoms' => fake()->sentence(8),
            'symptoms_started_at' => now()->subDays(2),
            'urgency' => fake()->randomElement(['rendah', 'sedang', 'tinggi']),
            'farm_name' => 'Peternakan '.fake()->company(),
            'farm_address' => fake()->address(),
            'kabupaten' => 'Kabupaten Malang',
            'photo_path' => null,
            'status' => 'menunggu_respons',
        ];
    }
}

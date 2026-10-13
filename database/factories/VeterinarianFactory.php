<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Veterinarian>
 */
class VeterinarianFactory extends Factory
{
    protected $model = Veterinarian::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->dokterHewan(),
            'name' => 'drh. '.fake()->name(),
            'specialization' => fake()->randomElement(['Kesehatan Sapi Perah & Potong', 'Kesehatan Ruminansia Kecil', 'Kesehatan Unggas & Avian']),
            'puskeswan' => 'Puskeswan '.fake()->city(),
            'wilayah_penugasan' => fake()->randomElement(['Kabupaten Malang', 'Kabupaten Pasuruan', 'Kabupaten Blitar', 'Kabupaten Jombang']),
            'strv_number' => 'STRV-'.fake()->numerify('####/VET/####'),
            'phone_number' => '0812'.fake()->numerify('########'),
            'email' => fake()->safeEmail(),
            'status' => 'online',
            'consultation_hours' => '08.00 - 16.00 WIB',
            'is_active' => true,
        ];
    }
}

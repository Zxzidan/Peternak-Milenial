<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Database\Seeder;

class VeterinarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drhRatnaUser = User::where('name', 'like', '%Ratna%')->first();
        $drhBambangUser = User::where('name', 'like', '%Bambang%')->first();

        $vets = [
            [
                'user_id' => $drhRatnaUser?->id,
                'name' => 'drh. Ratna Kusuma',
                'specialization' => 'Spesialis Sapi Perah & Reproduksi',
                'puskeswan' => 'Puskeswan Disnak Prov. Jatim - Surabaya',
                'strv_number' => 'STRV-35.78.2023.001',
                'phone_number' => '08001347625',
                'email' => 'ratna.kusuma@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => $drhBambangUser?->id,
                'name' => 'drh. Bambang Trihatmojo',
                'specialization' => 'Spesialis Ruminansia Besar & Bedah',
                'puskeswan' => 'Puskeswan Purwosari, Kab. Pasuruan',
                'strv_number' => 'STRV-35.14.2022.042',
                'phone_number' => '081234567800',
                'email' => 'bambang@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.30 - 15.30 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => null,
                'name' => 'drh. Nur Cahyo, M.Vet',
                'specialization' => 'Spesialis Unggas, Domba & Biosekuriti',
                'puskeswan' => 'Puskeswan Pare, Kab. Kediri',
                'strv_number' => 'STRV-35.06.2024.118',
                'phone_number' => '081399887766',
                'email' => 'nurcahyo@disnak.jatimprov.go.id',
                'status' => 'praktik_lapangan',
                'consultation_hours' => '09.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => null,
                'name' => 'drh. Siti Aminah, M.Si',
                'specialization' => 'Spesialis Sapi Potong & Nutrisi Ternak',
                'puskeswan' => 'Puskeswan Dander, Kab. Bojonegoro',
                'strv_number' => 'STRV-35.22.2023.077',
                'phone_number' => '081255443322',
                'email' => 'siti.aminah@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 15.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => null,
                'name' => 'drh. Ahmad Fauzi',
                'specialization' => 'Spesialis Penyakit Menular & Vaksinasi',
                'puskeswan' => 'Puskeswan Pandaan, Kab. Pasuruan',
                'strv_number' => 'STRV-35.14.2024.088',
                'phone_number' => '081322334455',
                'email' => 'ahmad.fauzi@disnak.jatimprov.go.id',
                'status' => 'siaga',
                'consultation_hours' => '08.00 - 16.00 WIB',
                'is_active' => true,
            ],
            [
                'user_id' => null,
                'name' => 'drh. Dewi Sartika',
                'specialization' => 'Spesialis Inseminasi Buatan & Kebuntingan',
                'puskeswan' => 'Puskeswan Sukorejo, Kab. Pasuruan',
                'strv_number' => 'STRV-35.14.2025.105',
                'phone_number' => '081377889900',
                'email' => 'dewi.sartika@disnak.jatimprov.go.id',
                'status' => 'online',
                'consultation_hours' => '08.00 - 15.30 WIB',
                'is_active' => true,
            ],
        ];

        foreach ($vets as $vetData) {
            Veterinarian::updateOrCreate(
                ['name' => $vetData['name']],
                $vetData
            );
        }
    }
}

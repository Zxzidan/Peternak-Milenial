<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\LearningMaterial;
use App\Models\LearningQuiz;
use App\Models\PeternakProfile;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\Region;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Models\UserLearningProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BimtekSelesaiSertifikatSeeder extends Seeder
{
    /**
     * Run the database seeds to provide a complete dummy scenario:
     * Peternak finishes Bimtek video module and quiz, and receives/can download an official certificate.
     */
    public function run(): void
    {
        // 1. Pastikan Wilayah Pasuruan tersedia
        $region = Region::firstOrCreate(
            ['code' => 'JTM-PAS'],
            [
                'name' => 'Kabupaten Pasuruan',
                'type' => 'kabupaten',
                'latitude' => -7.6521,
                'longitude' => 112.6983,
            ]
        );

        // 2. Pastikan Akun Peternak Milenial tersedia
        $peternak = User::firstOrCreate(
            ['email' => 'slamet@peternak.id'],
            [
                'name' => 'Slamet Rahardjo',
                'phone_number' => '081234567890',
                'role' => 'peternak',
                'is_active' => true,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Pastikan role peternak dan password aktif
        if ($peternak->role !== 'peternak') {
            $peternak->update(['role' => 'peternak']);
        }

        // Pastikan Profil Peternak lengkap
        PeternakProfile::updateOrCreate(
            ['user_id' => $peternak->id],
            [
                'region_id' => $region->id,
                'farm_name' => 'Kelompok Peternak Sapi Perah Pasuruan',
                'nik' => '3514081203760001',
                'nib' => '1203760001928374',
                'address' => 'Desa Durensewu, Pandaan, Kab. Pasuruan',
                'latitude' => -7.6521,
                'longitude' => 112.6983,
                'verification_status' => 'verified',
                'verified_at' => now()->subMonths(3),
            ]
        );

        // 3. Pastikan Program Pelatihan / Bimtek memiliki E-Sertifikat Aktif
        $training = Training::updateOrCreate(
            ['slug' => 'formulasi-pakan-ransum-silase'],
            [
                'title' => 'Formulasi Pakan Ransum & Silase',
                'description' => 'Efisiensi biaya pakan mandiri dengan limbah pertanian lokal dan probiotik.',
                'instructor' => 'Dr. Ir. Hendro Wibowo',
                'instructor_title' => 'Widyaiswara Ahli Utama BBPP Batu',
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date' => now()->subDays(3)->toDateString(),
                'time_info' => '08:00 - 15:00 WIB',
                'location' => 'BBPP Songgoriti, Batu',
                'is_online' => false,
                'quota' => 25,
                'remaining_quota' => 12,
                'cost_type' => 'gratis_apbd',
                'status' => 'open',
                'has_certificate' => true,
                'certificate_title' => 'Sertifikasi Formulasi Pakan Ransum & Silase Modern',
            ]
        );

        // Aktifkan juga template sertifikat pada Bimtek Zoom Pemasaran Digital
        Training::where('slug', 'pemasaran-digital-kur-peternakan')->update([
            'has_certificate' => true,
            'certificate_title' => 'Sertifikasi Kompetensi Pemasaran Digital & Finansial Peternakan',
        ]);

        // 4. Pastikan Peternak Terdaftar Resmi pada Bimtek Offline & Bimtek Online (Zoom)
        TrainingRegistration::updateOrCreate(
            [
                'training_id' => $training->id,
                'user_id' => $peternak->id,
            ],
            [
                'registration_code' => 'REG-SILASE-0024',
                'status' => 'confirmed',
                'registered_at' => now()->subDays(5),
                'notes' => 'Pendaftaran Bimtek Offline Formulasi Pakan Ransum & Silase melalui portal Peternak Milenial Jatim',
                'nik' => '3514081203760001',
                'phone_number' => $peternak->phone_number,
                'farm_name' => 'Kelompok Peternak Sapi Perah Pasuruan',
            ]
        );

        $onlineTraining = Training::where('slug', 'pemasaran-digital-kur-peternakan')->first();
        if ($onlineTraining) {
            TrainingRegistration::updateOrCreate(
                [
                    'training_id' => $onlineTraining->id,
                    'user_id' => $peternak->id,
                ],
                [
                    'registration_code' => 'REG-ZOOM-0112',
                    'status' => 'confirmed',
                    'registered_at' => now()->subDays(3),
                    'notes' => 'Pendaftaran Bimtek Online Zoom Pemasaran Digital & KUR Peternakan',
                    'nik' => '3514081203760001',
                    'phone_number' => $peternak->phone_number,
                    'farm_name' => 'Kelompok Peternak Sapi Perah Pasuruan',
                ]
            );
        }

        // 5. Pastikan Modul Video Pembelajaran LMS tersedia
        $material = LearningMaterial::updateOrCreate(
            ['slug' => 'teknologi-silase-hay-ternak'],
            [
                'title' => 'Teknologi Silase & Formulasi Hay Ternak Ruminansia',
                'description' => 'Panduan lengkap fermentasi hijauan pakan ternak (HPT) rumput odot & jagung secara anaerobik untuk menjamin ketersediaan pakan berkualitas di musim kemarau.',
                'category' => 'video_praktik',
                'topic' => 'Manajemen Pakan',
                'file_path' => 'materials/sop-formulasi-pakan.pdf',
                'file_size' => '3.8 MB',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'img/bestseller/1.png',
                'duration' => '24 Menit',
                'author_institution' => 'BBPP Batu & Disnak Jatim',
                'instructor_name' => 'Dr. Ir. Budi Santoso, M.Sc',
                'level' => 'Menengah',
                'downloads_count' => 520,
                'views_count' => 1435,
            ]
        );

        // 6. Pastikan Kuis Evaluasi Pemahaman dan Butir Soal tersedia
        $quiz = LearningQuiz::updateOrCreate(
            ['learning_material_id' => $material->id],
            [
                'title' => 'Evaluasi Pemahaman: Teknologi Silase & Hay Ternak',
                'description' => 'Kuis evaluasi mandiri untuk menguji pemahaman teknis fermentasi silase, kadar air optimal, dan deteksi kualitas pakan hijauan.',
                'passing_score' => 70,
                'time_limit_minutes' => 15,
                'is_active' => true,
            ]
        );

        $soalList = [
            [
                'question' => 'Berapa kadar air hijauan yang paling ideal sebelum dicacah dan dipadatkan ke dalam drum/silo silase?',
                'option_a' => '20% - 30%',
                'option_b' => '60% - 70%',
                'option_c' => '85% - 95%',
                'option_d' => 'Kurang dari 10%',
                'correct_answer' => 'b',
                'explanation' => 'Kadar air optimal untuk fermentasi silase anaerobik adalah 60-70%. Kadar air terlalu tinggi dapat memicu pembusukan clostridia, sedangkan terlalu rendah menyulitkan pemadatan.',
                'order' => 1,
            ],
            [
                'question' => 'Mikroorganisme yang berperan mengonversi gula terlarut menjadi asam pengawet pada proses silase adalah...',
                'option_a' => 'Bakteri Asam Laktat (BAL)',
                'option_b' => 'Escherichia coli',
                'option_c' => 'Bacillus anthracis',
                'option_d' => 'Aspergillus flavus',
                'correct_answer' => 'a',
                'explanation' => 'Bakteri Asam Laktat (Lactobacillus sp.) menghasilkan asam laktat yang menurunkan pH silo hingga 3.8-4.2 sehingga pakan awet dan tidak busuk.',
                'order' => 2,
            ],
            [
                'question' => 'Ciri fisik silase yang berhasil dengan kualitas sangat baik saat wadah dibuka adalah...',
                'option_a' => 'Berbau busuk menyengat dan berlendir hitam',
                'option_b' => 'Berbau asam harum buah segar dan berwarna hijau kekuningan',
                'option_c' => 'Ditumbuhi jamur putih tebal dan bersuhu panas',
                'option_d' => 'Hitam kecokelatan basah berlumpur',
                'correct_answer' => 'b',
                'explanation' => 'Silase berkualitas baik beraroma harum asam segar (seperti tape/buah), tidak berlendir, dan warnanya tetap cerah hijau kekuningan.',
                'order' => 3,
            ],
            [
                'question' => 'Berapa lama waktu minimal penyimpanan anaerobik sebelum silase matang sempurna dan aman diberikan ke ternak?',
                'option_a' => '2 hari',
                'option_b' => '7 hari',
                'option_c' => '21 hari (3 minggu)',
                'option_d' => '6 bulan',
                'correct_answer' => 'c',
                'explanation' => 'Proses fermentasi asam laktat stabil sempurna berlangsung dalam rentang 21 hari (3 minggu) dalam kondisi kedap udara (anaerobik).',
                'order' => 4,
            ],
        ];

        foreach ($soalList as $soalData) {
            QuizQuestion::updateOrCreate(
                [
                    'learning_quiz_id' => $quiz->id,
                    'order' => $soalData['order'],
                ],
                $soalData
            );
        }

        // 7. Dummy Data 1: Peternak Menyelesaikan Video Pembelajaran (Progres 100%)
        UserLearningProgress::updateOrCreate(
            [
                'user_id' => $peternak->id,
                'learning_material_id' => $material->id,
            ],
            [
                'is_watched' => true,
                'watch_percentage' => 100,
                'last_watched_at' => now()->subDay(),
            ]
        );

        // 8. Dummy Data 2: Peternak Mengerjakan & Menyelesaikan Soal Kuis (Skor 100 - Lulus)
        QuizAttempt::updateOrCreate(
            [
                'learning_quiz_id' => $quiz->id,
                'user_id' => $peternak->id,
            ],
            [
                'score' => 100,
                'total_questions' => 4,
                'correct_answers_count' => 4,
                'user_answers' => [
                    '1' => 'b',
                    '2' => 'a',
                    '3' => 'b',
                    '4' => 'c',
                ],
                'passed' => true,
                'completed_at' => now()->subHours(6),
            ]
        );

        // 9. Dummy Data 3: Peternak Mendapatkan E-Sertifikat Resmi Ber-Barcode untuk Keikutsertaan Bimtek
        Certificate::updateOrCreate(
            [
                'user_id' => $peternak->id,
                'training_id' => $training->id,
            ],
            [
                'certificate_number' => 'DISNAK-JATIM/2026/CERT-891',
                'recipient_name' => $peternak->name,
                'recipient_code' => '3514081203760001',
                'title' => $training->certificate_title ?? ('Sertifikasi Pelatihan: '.$training->title),
                'issued_date' => now()->subDays(2)->toDateString(),
                'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
            ]
        );

        if ($onlineTraining) {
            Certificate::updateOrCreate(
                [
                    'user_id' => $peternak->id,
                    'training_id' => $onlineTraining->id,
                ],
                [
                    'certificate_number' => 'DISNAK-JATIM/2026/CERT-892',
                    'recipient_name' => $peternak->name,
                    'recipient_code' => '3514081203760001',
                    'title' => $onlineTraining->certificate_title ?? ('Sertifikasi Pelatihan: '.$onlineTraining->title),
                    'issued_date' => now()->subDay()->toDateString(),
                    'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
                ]
            );
        }
    }
}

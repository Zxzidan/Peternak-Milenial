<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class AnimalHealthReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'user_id',
        'assigned_veterinarian_id',
        'livestock_type',
        'affected_count',
        'symptoms',
        'symptoms_started_at',
        'urgency',
        'farm_name',
        'farm_address',
        'kabupaten',
        'photo_path',
        'status',
        'last_responded_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'affected_count' => 'integer',
            'symptoms_started_at' => 'date',
            'last_responded_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public static function generateReportNumber(): string
    {
        $prefix = 'LKH-'.now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;

        return sprintf('%s-%04d-%s', $prefix, $count, $random);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedVeterinarian(): BelongsTo
    {
        return $this->belongsTo(Veterinarian::class, 'assigned_veterinarian_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AnimalHealthReportResponse::class, 'animal_health_report_id')->oldest();
    }

    public function visits(): HasMany
    {
        return $this->hasMany(AnimalHealthReportVisit::class, 'animal_health_report_id')->latest();
    }

    public function latestVisit(): HasOne
    {
        return $this->hasOne(AnimalHealthReportVisit::class, 'animal_health_report_id')->latestOfMany();
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(AnimalHealthReportStatusHistory::class, 'animal_health_report_id')->latest('created_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_respons' => 'Menunggu Respons',
            'sedang_ditangani' => 'Sedang Ditangani',
            'sudah_dijawab' => 'Sudah Dijawab',
            'menunggu_kunjungan' => 'Menunggu Kunjungan',
            'kunjungan_terjadwal' => 'Kunjungan Terjadwal',
            'menunggu_tindak_lanjut' => 'Menunggu Tindak Lanjut',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'menunggu_respons' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'sedang_ditangani' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'sudah_dijawab' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-950/60 dark:text-indigo-300 dark:border-indigo-800',
            'menunggu_kunjungan' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-950/60 dark:text-orange-300 dark:border-orange-800',
            'kunjungan_terjadwal' => 'bg-cyan-100 text-cyan-800 border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-300 dark:border-cyan-800',
            'menunggu_tindak_lanjut' => 'bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match ($this->urgency) {
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'kritis' => 'Kritis (Darurat)',
            default => ucfirst((string) $this->urgency),
        };
    }

    public function getUrgencyBadgeClassesAttribute(): string
    {
        return match ($this->urgency) {
            'rendah' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
            'sedang' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
            'tinggi' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:border-orange-800',
            'kritis' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function transitionTo(string $newStatus, ?int $changedById = null, ?string $notes = null): void
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;

        if ($newStatus === 'selesai') {
            if (! $this->resolved_at) {
                $this->resolved_at = now();
            }
            $this->save();
            $this->syncMedicalRecord($changedById);
        } else {
            $this->save();
        }

        $this->statusHistories()->create([
            'changed_by_id' => $changedById,
            'previous_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
        ]);
    }

    /**
     * Synchronize and record official medical record (HealthRecord) upon report completion.
     */
    public function syncMedicalRecord(?int $changedById = null): ?HealthRecord
    {
        // 1. Resolve veterinarian user id
        $vetUserId = null;
        if ($this->assignedVeterinarian?->user_id) {
            $vetUserId = $this->assignedVeterinarian->user_id;
        } elseif ($changedById && User::where('id', $changedById)->whereIn('role', ['dokter_hewan', 'admin'])->exists()) {
            $vetUserId = $changedById;
        } else {
            $latestResponseVetId = $this->responses()
                ->whereHas('user', fn ($q) => $q->whereIn('role', ['dokter_hewan', 'admin']))
                ->latest()
                ->value('user_id');
            $vetUserId = $latestResponseVetId ?? User::where('role', 'dokter_hewan')->value('id') ?? User::where('role', 'admin')->value('id');
        }

        // 2. Associate or create livestock record for peternak
        $typeMapping = match (strtolower(trim($this->livestock_type))) {
            'sapi perah', 'sapi perah (fh)' => 'sapi_perah_fh',
            'sapi potong', 'sapi potong (limousin/simental/po)' => 'sapi_potong',
            'kambing', 'kambing (senduro/pe)' => 'kambing_senduro',
            'domba', 'domba (sapudi/garut)' => 'domba',
            'unggas' => 'unggas',
            default => 'sapi_potong',
        };

        $livestock = Livestock::where('user_id', $this->user_id)
            ->where('type', $typeMapping)
            ->first();

        if (! $livestock) {
            $livestock = Livestock::where('user_id', $this->user_id)->first();
        }

        if (! $livestock) {
            $livestock = Livestock::create([
                'user_id' => $this->user_id,
                'e_tag_number' => 'ETAG-'.strtoupper(Str::random(6)),
                'name' => $this->livestock_type,
                'type' => $typeMapping,
                'gender' => 'betina',
                'health_status' => 'sehat',
            ]);
        }

        // 3. Extract clinical diagnosis and therapeutic recommendations
        $latestVisit = $this->latestVisit;
        $latestResponse = $this->responses()
            ->whereHas('user', fn ($q) => $q->whereIn('role', ['dokter_hewan', 'admin']))
            ->latest()
            ->first();

        $diagnosis = $latestVisit?->examination_notes
            ?: ($latestResponse?->hypothesis ?: 'Pemeriksaan klinis tuntas terhadap gejala: '.$this->symptoms);

        $treatment = $latestVisit?->post_visit_recommendations
            ?: ($latestResponse?->recommendations ?: ($latestResponse?->message ?: 'Perawatan pemulihan dan pemantauan kondisi ternak.'));

        $notes = $latestResponse?->follow_up_instructions
            ?: ($latestResponse?->notes ?: ('Tercatat resmi dari Laporan Kesehatan '.$this->report_number));

        $title = 'Laporan Kesehatan: '.$this->report_number.' ('.$this->livestock_type.')';

        return HealthRecord::updateOrCreate(
            [
                'livestock_id' => $livestock->id,
                'title' => $title,
            ],
            [
                'veterinarian_id' => $vetUserId,
                'record_type' => 'pemeriksaan',
                'diagnosis' => $diagnosis,
                'treatment' => $treatment,
                'notes' => $notes,
                'record_date' => $this->resolved_at ? $this->resolved_at->toDateString() : now()->toDateString(),
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\Disease;
use App\Models\HealthRecord;
use App\Models\Livestock;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display veterinary consultations, digital health records, and disease guidance.
     */
    public function index(): View
    {
        $consultation = Consultation::with(['messages.sender', 'veterinarian', 'user'])->first();

        // If no consultation exists in database yet, create an initial one
        if (! $consultation) {
            $user = User::where('role', 'peternak')->first() ?? User::first();
            $vet = User::where('email', 'ratna.kusuma@disnak.jatimprov.go.id')->first() ?? User::where('role', 'admin')->first();

            $consultation = Consultation::create([
                'user_id' => $user->id,
                'veterinarian_id' => $vet?->id,
                'subject' => 'Konsultasi Gejala Sapi Perah Lesu & Suhu Tinggi',
                'status' => 'answered',
            ]);

            ConsultationMessage::create([
                'consultation_id' => $consultation->id,
                'sender_id' => $user->id,
                'message' => 'Selamat pagi Dokter Ratna. Sapi perah no. 14 terlihat lesu sejak kemarin sore, suhu 39.8°C dan nafsu makan berkurang. Mohon arahannya.',
            ]);

            if ($vet) {
                ConsultationMessage::create([
                    'consultation_id' => $consultation->id,
                    'sender_id' => $vet->id,
                    'message' => 'Selamat pagi Pak Slamet. Pisahkan sapi ke kandang karantina, beri air hangat + molase. Petugas lapangan sedang menuju lokasi membawa antipiretik.',
                ]);
            }

            $consultation->load(['messages.sender', 'veterinarian', 'user']);
        }

        $healthRecords = HealthRecord::with(['livestock', 'veterinarian'])
            ->latest('record_date')
            ->get();

        $livestocks = Livestock::all();
        $diseases = Disease::all();

        return view('konsultasi', [
            'consultation' => $consultation,
            'healthRecords' => $healthRecords,
            'livestocks' => $livestocks,
            'diseases' => $diseases,
        ]);
    }

    /**
     * Send a consultation chat message.
     */
    public function sendMessage(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $sender = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();

        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => $sender->id,
            'message' => $validated['message'],
        ]);

        $consultation->touch();

        return redirect()->route('konsultasi')
            ->with('success', 'Pesan konsultasi berhasil dikirim ke dokter hewan!');
    }

    /**
     * Store new health record / vaccination / inspection.
     */
    public function storeHealthRecord(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'livestock_id' => ['required', 'exists:livestock,id'],
            'record_type' => ['required', 'in:pemeriksaan,vaksinasi,pengobatan,inseminasi_buatan'],
            'title' => ['required', 'string', 'max:255'],
            'diagnosis' => ['nullable', 'string', 'max:500'],
            'treatment' => ['nullable', 'string', 'max:500'],
            'record_date' => ['required', 'date'],
        ]);

        $vet = auth()->user() ?? User::where('email', 'ratna.kusuma@disnak.jatimprov.go.id')->first() ?? User::first();

        HealthRecord::create([
            'livestock_id' => $validated['livestock_id'],
            'veterinarian_id' => $vet->id,
            'record_type' => $validated['record_type'],
            'title' => $validated['title'],
            'diagnosis' => $validated['diagnosis'] ?? 'Kondisi stabil dalam pemantauan rutin',
            'treatment' => $validated['treatment'] ?? 'Vitamin & multivitamin support',
            'notes' => 'Tercatat otomatis melalui Buku Rekam Medis Digital Dinas',
            'record_date' => $validated['record_date'],
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "Rekam medis '{$validated['title']}' berhasil disimpan ke e-record ternak!");
    }

    /**
     * Register a new e-tag livestock.
     */
    public function storeLivestock(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tag_number' => ['required', 'string', 'max:50', 'unique:livestock,e_tag_number'],
            'livestock_type' => ['nullable', 'string', 'max:50'],
            'breed' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:jantan,betina'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $user = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();

        $type = match ($validated['livestock_type'] ?? '') {
            'sapi_perah' => 'sapi_perah_fh',
            'sapi_potong' => 'sapi_potong',
            'kambing' => 'kambing_senduro',
            'domba' => 'domba',
            default => 'sapi_perah_fh',
        };

        $name = ! empty($validated['breed']) ? $validated['breed'] : 'Ternak Milenial Jatim';

        $livestock = Livestock::create([
            'user_id' => $user->id,
            'e_tag_number' => strtoupper($validated['tag_number']),
            'name' => $name,
            'type' => $type,
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'] ?? now()->subYears(2),
            'reproductive_status' => 'produktif',
            'health_status' => 'sehat',
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "E-Tag Ternak {$livestock->e_tag_number} ({$livestock->name}) berhasil didaftarkan ke sistem Dinas!");
    }

    /**
     * Delete a health record.
     */
    public function destroyHealthRecord(HealthRecord $record): RedirectResponse
    {
        $title = $record->title;
        $record->delete();

        return redirect()->route('konsultasi')
            ->with('success', "Rekam medis '{$title}' berhasil dihapus.");
    }
}

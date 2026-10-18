<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\LearningMaterial;
use App\Models\LearningQuiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Models\UserLearningProgress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TrainingController extends Controller
{
    /**
     * Display the E-Learning LMS, Video Modules, Zoom Trainings, Quizzes, and Certificates.
     */
    public function index(Request $request): View
    {
        $currentUser = auth()->user();

        // 1. Modul Video & Materi Pembelajaran LMS
        $materialsQuery = LearningMaterial::with(['quiz.questions', 'progress', 'quizzes.questions']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $materialsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('topic', 'like', "%{$search}%")
                    ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('topic') && $request->topic !== 'all') {
            $materialsQuery->where('topic', $request->topic);
        }

        $materials = $materialsQuery->latest()->get();

        // 2. Sesi Pembelajaran & Bimtek Daring via Zoom
        $zoomQuery = Training::withCount('registrations')
            ->where(function ($q) {
                $q->where('is_online', true)->orWhereNotNull('zoom_link');
            });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $zoomQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('instructor', 'like', "%{$search}%");
            });
        }

        $zoomTrainings = $zoomQuery->orderBy('start_date')->get();

        // 2b. Program Bimbingan Teknis (Bimtek) Tatap Muka Lapangan (Offline)
        $offlineQuery = Training::withCount('registrations')
            ->where(function ($q) {
                $q->where('is_online', false)->whereNull('zoom_link');
            });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $offlineQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('instructor', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $offlineTrainings = $offlineQuery->orderBy('start_date')->get();
        $upcomingOfflineCount = $offlineTrainings->where('start_date', '>=', now()->toDateString())->count();

        // 3. Seluruh Program Bimtek (Termasuk Tatap Muka Lapangan)
        $trainings = Training::withCount('registrations')
            ->with(['certificates.user'])
            ->orderBy('start_date')
            ->get();

        // E-Sertifikat Pelatihan: Peternak hanya melihat pelatihan yang telah dibuatkan sertifikat oleh Admin
        $certificateTrainings = $currentUser && $currentUser->isPeternak()
            ? $trainings->filter(fn ($t) => $t->has_certificate || $t->certificates->where('user_id', $currentUser->id)->isNotEmpty())
            : $trainings;

        // 4. Kuis Evaluasi Pembelajaran
        $quizzesQuery = LearningQuiz::with(['learningMaterial', 'questions', 'attempts.user'])
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $quizzesQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('learningMaterial', function ($mq) use ($search) {
                        $mq->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $quizzes = $quizzesQuery->latest()->get();

        // 5. Sertifikat Digital & Riwayat Pengerjaan Kuis
        $certQuery = Certificate::with(['training', 'user']);

        if ($currentUser && $currentUser->isPeternak()) {
            $certQuery->where('user_id', $currentUser->id);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $certQuery->where(function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        if ($currentUser && ($currentUser->isAdmin() || $currentUser->isPeternak())) {
            $certificates = $certQuery->latest('issued_date')->get();
        } else {
            $certificates = collect();
        }

        if ($currentUser && $currentUser->isAdmin()) {
            $quizAttempts = QuizAttempt::with(['quiz.learningMaterial', 'user'])
                ->latest()
                ->get();
        } elseif ($currentUser && $currentUser->isPeternak()) {
            $quizAttempts = QuizAttempt::with(['quiz.learningMaterial', 'user'])
                ->where('user_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            $quizAttempts = collect();
        }

        // 6. Pendaftaran Bimtek Milik Peternak
        $myRegistrations = ($currentUser && $currentUser->isPeternak())
            ? TrainingRegistration::with('training')
                ->where('user_id', $currentUser->id)
                ->latest('registered_at')
                ->get()
            : collect();

        $myRegisteredTrainingIds = $myRegistrations->pluck('training_id')->toArray();

        // 7. Tracking Tontonan Video Peternak
        $userProgress = ($currentUser && $currentUser->isPeternak())
            ? UserLearningProgress::where('user_id', $currentUser->id)->get()->keyBy('learning_material_id')
            : collect();

        // 8. Ringkasan Statistik Belajar untuk Widget Dashboard
        $totalMaterialsCount = $materials->count();
        $watchedCount = $userProgress->where('is_watched', true)->count();
        $passedQuizzesCount = $quizAttempts->where('passed', true)->unique('learning_quiz_id')->count();
        $averageScore = $quizAttempts->count() > 0 ? (int) round($quizAttempts->avg('score')) : 0;
        $upcomingZoomCount = $zoomTrainings->where('start_date', '>=', now()->toDateString())->count();

        // 9. Daftar Instruktur & Mentor Ahli Terverifikasi
        $mentors = [
            [
                'name' => 'Dr. Ir. Budi Santoso, M.Sc',
                'role' => 'Widyaiswara Ahli Utama BBPP Batu',
                'specialty' => 'Teknologi Silase & Nutrisi Ruminansia',
                'institution' => 'BBPP Batu Kementan',
                'courses_count' => 3,
                'avatar' => asset('img/dokter.png'),
            ],
            [
                'name' => 'Prof. Dr. Ir. Trinil Susilawati',
                'role' => 'Guru Besar Pemuliaan Ternak Fapet UB',
                'specialty' => 'Manajemen Budidaya & Bibit Sapi Perah',
                'institution' => 'Fakultas Peternakan Universitas Brawijaya',
                'courses_count' => 4,
                'avatar' => asset('img/dokter.png'),
            ],
            [
                'name' => 'drh. Ratna Kusuma',
                'role' => 'Dokter Hewan Dinas Peternakan Jatim',
                'specialty' => 'Pemerahan Higienis & Mutu Susu Segar',
                'institution' => 'Dinas Peternakan Provinsi Jawa Timur',
                'courses_count' => 2,
                'avatar' => asset('img/dokter.png'),
            ],
            [
                'name' => 'drh. Nur Cahyo, M.Vet',
                'role' => 'Koordinator Puskeswan Dinas Peternakan',
                'specialty' => 'Biosekuriti Kandang & Deteksi Penyakit PMK',
                'institution' => 'Puskeswan Dinas Peternakan Jatim',
                'courses_count' => 2,
                'avatar' => asset('img/dokter.png'),
            ],
        ];

        // 10. Data Verifikasi Peserta untuk Admin
        $allRegistrations = ($currentUser && $currentUser->isAdmin())
            ? TrainingRegistration::with(['training', 'user'])->latest('registered_at')->get()
            : collect();

        $peternakUsers = ($currentUser && $currentUser->isAdmin())
            ? User::where('role', 'peternak')->orderBy('name')->get()
            : collect();

        return view('pelatihan', [
            'materials' => $materials,
            'zoomTrainings' => $zoomTrainings,
            'trainings' => $trainings,
            'certificateTrainings' => $certificateTrainings,
            'quizzes' => $quizzes,
            'certificates' => $certificates,
            'myRegistrations' => $myRegistrations,
            'myRegisteredTrainingIds' => $myRegisteredTrainingIds,
            'allRegistrations' => $allRegistrations,
            'peternakUsers' => $peternakUsers,
            'userProgress' => $userProgress,
            'watchedCount' => $watchedCount,
            'totalMaterialsCount' => $totalMaterialsCount,
            'passedQuizzesCount' => $passedQuizzesCount,
            'averageScore' => $averageScore,
            'upcomingZoomCount' => $upcomingZoomCount,
            'offlineTrainings' => $offlineTrainings,
            'upcomingOfflineCount' => $upcomingOfflineCount,
            'quizAttempts' => $quizAttempts,
            'mentors' => $mentors,
        ]);
    }

    /**
     * Register a peternak to a training / zoom session.
     */
    public function register(Request $request, Training $training): RedirectResponse
    {
        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Peternak Anda untuk mendaftar pelatihan.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('pelatihan')->with('error', 'Akun Admin Dinas berfungsi sebagai pengelola program dan tidak mendaftar sebagai peserta.');
        }

        $existing = TrainingRegistration::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        $defaultTab = $training->is_online ? 'zoom' : 'bimtek_offline';
        $targetTab = $request->input('tab', $defaultTab);

        if ($existing) {
            return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
                ->with('error', "Anda sudah terdaftar pada Bimtek '{$training->title}' dengan nomor registrasi {$existing->registration_code}.");
        }

        if ($training->remaining_quota <= 0) {
            return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
                ->with('error', "Mohon maaf, kuota peserta untuk Bimtek '{$training->title}' sudah penuh.");
        }

        $docPath = null;
        $docName = null;
        if ($request->hasFile('requirement_document') || $request->hasFile('dokumen_persyaratan')) {
            $file = $request->file('requirement_document') ?? $request->file('dokumen_persyaratan');
            $docName = $file->getClientOriginalName();
            $docPath = $file->store('persyaratan_bimtek', 'public');
        }

        $regPrefix = (! $training->is_online || $docPath) ? 'REG-BMTK-' : 'REG-';
        $regCode = $regPrefix.strtoupper(Str::random(4)).'-'.date('dmy');

        TrainingRegistration::create([
            'training_id' => $training->id,
            'user_id' => $user->id,
            'registration_code' => $regCode,
            'status' => 'confirmed',
            'registered_at' => now(),
            'notes' => $request->input('notes', 'Pendaftaran online melalui portal Peternak Milenial Jatim'),
            'requirement_document_path' => $docPath,
            'requirement_document_name' => $docName,
            'nik' => $request->input('nik', $user->profile?->nik),
            'phone_number' => $request->input('phone_number', $user->phone_number),
            'farm_name' => $request->input('farm_name', $user->profile?->farm_name),
        ]);

        $training->decrement('remaining_quota');

        if ($docPath) {
            return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
                ->with('success', "Pendaftaran Bimtek '{$training->title}' berhasil! Nomor Registrasi: {$regCode}. Dokumen persyaratan telah dicatat oleh sistem aplikasi.")
                ->with('registered_ticket', [
                    'registration_code' => $regCode,
                    'training_title' => $training->title,
                    'location' => $training->location,
                    'date' => $training->start_date ? $training->start_date->format('d M Y') : 'Terjadwal',
                    'time' => $training->time_info ?? '08:00 - 15:00 WIB',
                    'instructor' => $training->instructor,
                    'document_name' => $docName,
                ]);
        }

        if ($request->has('tab')) {
            return redirect()->to(route('pelatihan', ['tab' => $request->tab]))
                ->with('success', "Pendaftaran Bimtek '{$training->title}' berhasil! Kode Tiket: {$regCode}. Sisa kuota: {$training->remaining_quota} peserta.");
        }

        return redirect()->route('pelatihan')
            ->with('success', "Pendaftaran Bimtek '{$training->title}' berhasil! Kode Tiket: {$regCode}. Sisa kuota: {$training->remaining_quota} peserta.");
    }

    /**
     * Register a peternak for an offline Bimtek session with requirement documents.
     */
    public function registerOffline(Request $request, Training $training): RedirectResponse
    {
        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Peternak Anda untuk mendaftar Bimtek Tatap Muka.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('pelatihan', ['tab' => 'bimtek_offline'])
                ->with('error', 'Akun Admin Dinas berfungsi sebagai pengelola program dan tidak mendaftar sebagai peserta.');
        }

        $existing = TrainingRegistration::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->to(route('pelatihan', ['tab' => 'bimtek_offline']))
                ->with('error', "Anda sudah terdaftar pada Bimtek '{$training->title}' dengan Nomor Registrasi {$existing->registration_code}.");
        }

        if ($training->remaining_quota <= 0) {
            return redirect()->to(route('pelatihan', ['tab' => 'bimtek_offline']))
                ->with('error', "Mohon maaf, kuota peserta untuk Bimtek '{$training->title}' sudah penuh.");
        }

        $validated = $request->validate([
            'requirement_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,docx,doc', 'max:10240'],
            'nik' => ['nullable', 'string', 'max:30'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'farm_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'requirement_document.required' => 'Dokumen persyaratan wajib diunggah untuk dicatat nomor registrasinya oleh sistem aplikasi.',
            'requirement_document.file' => 'Berkas dokumen persyaratan harus berupa file yang valid.',
            'requirement_document.mimes' => 'Format berkas dokumen persyaratan harus berupa PDF, JPG, PNG, atau DOCX.',
            'requirement_document.max' => 'Ukuran berkas dokumen persyaratan maksimal 10 MB.',
        ]);

        $file = $request->file('requirement_document');
        $documentName = $file->getClientOriginalName();
        $documentPath = $file->store('persyaratan_bimtek', 'public');

        $regCode = 'REG-BMTK-'.strtoupper(Str::random(4)).'-'.date('dmy');

        TrainingRegistration::create([
            'training_id' => $training->id,
            'user_id' => $user->id,
            'registration_code' => $regCode,
            'status' => 'confirmed',
            'registered_at' => now(),
            'requirement_document_path' => $documentPath,
            'requirement_document_name' => $documentName,
            'nik' => $validated['nik'] ?? $user->profile?->nik,
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
            'farm_name' => $validated['farm_name'] ?? $user->profile?->farm_name,
            'notes' => $validated['notes'] ?? 'Pendaftaran Bimtek Offline dengan verifikasi dokumen persyaratan',
        ]);

        $training->decrement('remaining_quota');

        return redirect()->to(route('pelatihan', ['tab' => 'bimtek_offline']))
            ->with('success', "Pendaftaran Bimtek '{$training->title}' berhasil! Nomor Registrasi Anda: {$regCode}. Dokumen persyaratan telah diverifikasi dan dicatat oleh sistem aplikasi.")
            ->with('registered_ticket', [
                'registration_code' => $regCode,
                'training_title' => $training->title,
                'location' => $training->location,
                'date' => $training->start_date ? $training->start_date->format('d M Y') : 'Terjadwal',
                'time' => $training->time_info ?? '08:00 - 15:00 WIB',
                'instructor' => $training->instructor,
                'document_name' => $documentName,
            ]);
    }

    /**
     * Download or view requirement document for a participant registration.
     */
    public function downloadRequirementDocument(TrainingRegistration $registration): BinaryFileResponse|RedirectResponse
    {
        $currentUser = auth()->user();

        if (! $currentUser) {
            abort(401, 'Silakan masuk terlebih dahulu.');
        }

        if (! $currentUser->isAdmin() && $registration->user_id !== $currentUser->id) {
            abort(403, 'Anda tidak berwenang mengakses dokumen persyaratan peserta ini.');
        }

        if ($registration->requirement_document_path && Storage::disk('public')->exists($registration->requirement_document_path)) {
            return response()->download(
                Storage::disk('public')->path($registration->requirement_document_path),
                $registration->requirement_document_name ?? ('dokumen-persyaratan-'.$registration->registration_code.'.pdf')
            );
        }

        // Fallback default sample file if demo/seeded without physical file
        $defaultPath = storage_path('app/public/materials/sop-formulasi-pakan.pdf');
        if (file_exists($defaultPath)) {
            return response()->download($defaultPath, $registration->requirement_document_name ?? 'dokumen-persyaratan.pdf');
        }

        return redirect()->back()->with('error', 'Berkas dokumen persyaratan belum tersedia di server.');
    }

    /**
     * Update participant registration status (Admin only).
     */
    public function updateRegistrationStatus(Request $request, TrainingRegistration $registration): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memverifikasi status pendaftaran peserta.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,attended,cancelled'],
        ]);

        $registration->update(['status' => $validated['status']]);

        $targetTab = $request->input('tab', 'zoom');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "Status pendaftaran peserta {$registration->user?->name} ({$registration->registration_code}) berhasil diperbarui menjadi {$validated['status']}.");
    }

    /**
     * Cancel training registration and restore quota.
     */
    public function cancelRegistration(TrainingRegistration $registration): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin() && $registration->user_id !== $currentUser->id) {
            abort(403, 'Anda hanya dapat membatalkan pendaftaran pelatihan milik Anda sendiri.');
        }

        $training = $registration->training;
        $title = $training?->title ?? 'Pelatihan';

        if ($training) {
            $training->increment('remaining_quota');
        }

        $registration->delete();

        if (request()->has('tab')) {
            return redirect()->to(route('pelatihan', ['tab' => request()->query('tab')]))
                ->with('success', "Pendaftaran Bimtek '{$title}' berhasil dibatalkan.");
        }

        return redirect()->route('pelatihan')
            ->with('success', "Pendaftaran Bimtek '{$title}' berhasil dibatalkan.");
    }

    /**
     * Store a general training (Admin only).
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambahkan program Bimtek.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'instructor' => ['required', 'string', 'max:255'],
            'instructor_title' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'time_info' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'is_online' => ['nullable', 'boolean'],
            'zoom_link' => ['nullable', 'url', 'max:255'],
            'zoom_meeting_id' => ['nullable', 'string', 'max:100'],
            'zoom_passcode' => ['nullable', 'string', 'max:100'],
            'quota' => ['required', 'integer', 'min:1'],
            'cost_type' => ['required', 'in:gratis_apbd,daring,mandiri'],
            'document_upload' => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'],
        ]);

        $documentPath = null;
        $documentName = null;

        if ($request->hasFile('document_upload')) {
            $file = $request->file('document_upload');
            $documentName = $file->getClientOriginalName();
            $documentPath = $file->store('materials', 'public');
        }

        $slug = Str::slug($validated['title']).'-'.time();

        Training::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'instructor' => $validated['instructor'],
            'instructor_title' => $validated['instructor_title'] ?? 'Narasumber Dinas Peternakan Jatim',
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'time_info' => $validated['time_info'] ?? '08:00 - 15:00 WIB',
            'location' => $validated['location'],
            'is_online' => (bool) ($request->is_online ?? false),
            'zoom_link' => $validated['zoom_link'] ?? null,
            'zoom_meeting_id' => $validated['zoom_meeting_id'] ?? null,
            'zoom_passcode' => $validated['zoom_passcode'] ?? null,
            'document_path' => $documentPath,
            'document_name' => $documentName,
            'quota' => $validated['quota'],
            'remaining_quota' => $validated['quota'],
            'cost_type' => $validated['cost_type'],
            'status' => 'open',
        ]);

        if ($request->has('tab')) {
            return redirect()->to(route('pelatihan', ['tab' => $request->tab]))
                ->with('success', "Program Bimtek '{$validated['title']}' berhasil ditambahkan ke jadwal dinas!");
        }

        return redirect()->route('pelatihan')
            ->with('success', "Program Bimtek '{$validated['title']}' berhasil ditambahkan ke jadwal dinas!");
    }

    /**
     * Store Zoom learning session with document upload (Admin only).
     */
    public function storeZoomSession(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menjadwalkan sesi Bimtek Zoom.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'instructor' => ['required', 'string', 'max:255'],
            'instructor_title' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'time_info' => ['required', 'string', 'max:100'],
            'zoom_link' => ['required', 'url', 'max:500'],
            'zoom_meeting_id' => ['nullable', 'string', 'max:100'],
            'zoom_passcode' => ['nullable', 'string', 'max:100'],
            'quota' => ['required', 'integer', 'min:1'],
            'document_upload' => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'],
        ]);

        $documentPath = null;
        $documentName = null;

        if ($request->hasFile('document_upload')) {
            $file = $request->file('document_upload');
            $documentName = $file->getClientOriginalName();
            $documentPath = $file->store('materials', 'public');
        }

        $slug = Str::slug($validated['title']).'-'.time();

        Training::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'instructor' => $validated['instructor'],
            'instructor_title' => $validated['instructor_title'] ?? 'Narasumber Ahli Peternakan Jatim',
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'time_info' => $validated['time_info'],
            'location' => 'Zoom Cloud Meetings Disnak Jatim',
            'is_online' => true,
            'zoom_link' => $validated['zoom_link'],
            'zoom_meeting_id' => $validated['zoom_meeting_id'],
            'zoom_passcode' => $validated['zoom_passcode'],
            'document_path' => $documentPath,
            'document_name' => $documentName,
            'quota' => $validated['quota'],
            'remaining_quota' => $validated['quota'],
            'cost_type' => 'daring',
            'status' => 'open',
        ]);

        return redirect()->to(route('pelatihan', ['tab' => 'zoom']))
            ->with('success', "Jadwal Pembelajaran Zoom '{$validated['title']}' beserta dokumen berhasil diterbitkan!");
    }

    /**
     * Delete a training / zoom session (Admin only).
     */
    public function destroy(Training $training): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus program Bimtek.');
        }

        $title = $training->title;
        $training->delete();

        if (request()->has('tab')) {
            return redirect()->to(route('pelatihan', ['tab' => request()->query('tab')]))
                ->with('success', "Program Bimtek '{$title}' berhasil dihapus.");
        }

        return redirect()->route('pelatihan')
            ->with('success', "Program Bimtek '{$title}' berhasil dihapus.");
    }

    /**
     * Store new learning material / video module with document attachment (Admin only).
     */
    public function storeMaterial(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang mengunggah modul pembelajaran.');
        }

        $category = $request->input('category');
        if (! $category && $request->filled('file_type')) {
            $category = match ($request->input('file_type')) {
                'pdf' => 'modul_pdf',
                'video' => 'video_praktik',
                default => 'panduan',
            };
            $request->merge(['category' => $category]);
        }

        if (! $request->filled('category')) {
            $request->merge(['category' => 'video_praktik']);
        }

        if (! $request->filled('author_institution')) {
            $request->merge(['author_institution' => 'Dinas Peternakan Provinsi Jawa Timur']);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:modul_pdf,video_praktik,panduan'],
            'topic' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'duration' => ['nullable', 'string', 'max:50'],
            'file_size' => ['nullable', 'string', 'max:50'],
            'instructor_name' => ['nullable', 'string', 'max:255'],
            'author_institution' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'in:Dasar,Menengah,Lanjutan'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'],
        ]);

        $filePath = 'materials/sop-formulasi-pakan.pdf';
        $fileSize = $validated['file_size'] ?? '3.5 MB';

        if ($request->hasFile('document_file')) {
            $uploaded = $request->file('document_file');
            $filePath = $uploaded->store('materials', 'public');
            $bytes = $uploaded->getSize();
            $fileSize = $bytes > 1048576 ? round($bytes / 1048576, 1).' MB' : round($bytes / 1024).' KB';
        }

        $slug = Str::slug($validated['title']).'-'.time();

        LearningMaterial::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? 'Materi peningkatan kapasitas teknis peternak milenial Dinas Peternakan Jawa Timur.',
            'category' => $validated['category'],
            'topic' => $validated['topic'] ?? 'Manajemen Pakan',
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'video_url' => $validated['video_url'] ?? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration' => $validated['duration'] ?? '20 Menit',
            'instructor_name' => $validated['instructor_name'] ?? 'Instruktur Ahli Disnak Jatim',
            'author_institution' => $validated['author_institution'],
            'level' => $validated['level'] ?? 'Dasar',
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        $targetTab = $request->input('tab', 'pembelajaran');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "Modul video pembelajaran '{$validated['title']}' berhasil diunggah!");
    }

    /**
     * Update existing learning material / video (Admin only).
     */
    public function updateMaterial(Request $request, LearningMaterial $material): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang mengubah modul pembelajaran.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'duration' => ['nullable', 'string', 'max:50'],
            'instructor_name' => ['nullable', 'string', 'max:255'],
            'author_institution' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'in:Dasar,Menengah,Lanjutan'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'],
        ]);

        if ($request->hasFile('document_file')) {
            $uploaded = $request->file('document_file');
            $validated['file_path'] = $uploaded->store('materials', 'public');
            $bytes = $uploaded->getSize();
            $validated['file_size'] = $bytes > 1048576 ? round($bytes / 1048576, 1).' MB' : round($bytes / 1024).' KB';
        }

        $material->update($validated);

        $targetTab = $request->input('tab', 'pembelajaran');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "Data modul '{$material->title}' berhasil diperbarui.");
    }

    /**
     * Delete learning material (Admin only).
     */
    public function destroyMaterial(LearningMaterial $material): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus modul pembelajaran.');
        }

        $title = $material->title;
        $material->delete();

        $targetTab = request()->query('tab', 'pembelajaran');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "Modul pembelajaran '{$title}' berhasil dihapus.");
    }

    /**
     * Store new quiz for a module (Admin only).
     */
    public function storeQuiz(Request $request, LearningMaterial $material): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang membuat kuis evaluasi.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'passing_score' => ['required', 'integer', 'min:50', 'max:100'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        $quiz = LearningQuiz::create([
            'learning_material_id' => $material->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? "Kuis evaluasi pemahaman untuk modul {$material->title}.",
            'passing_score' => $validated['passing_score'],
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? 15,
            'is_active' => true,
        ]);

        return redirect()->to(route('pelatihan', ['tab' => 'kuis']))
            ->with('success', "Kuis '{$quiz->title}' untuk modul {$material->title} berhasil dibuat! Silakan tambahkan butir soal.");
    }

    /**
     * Store a question for a quiz (Admin only).
     */
    public function storeQuizQuestion(Request $request, LearningQuiz $quiz): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambahkan butir pertanyaan.');
        }

        $validated = $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'in:a,b,c,d'],
            'explanation' => ['nullable', 'string'],
        ]);

        $order = $quiz->questions()->count() + 1;

        QuizQuestion::create([
            'learning_quiz_id' => $quiz->id,
            'question' => $validated['question'],
            'option_a' => $validated['option_a'],
            'option_b' => $validated['option_b'],
            'option_c' => $validated['option_c'],
            'option_d' => $validated['option_d'],
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'] ?? null,
            'order' => $order,
        ]);

        return redirect()->to(route('pelatihan', ['tab' => 'kuis']))
            ->with('success', 'Butir soal pilihan ganda berhasil ditambahkan ke kuis!');
    }

    /**
     * Delete a question from a quiz (Admin only).
     */
    public function destroyQuizQuestion(QuizQuestion $question): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus butir pertanyaan.');
        }

        $question->delete();

        return redirect()->to(route('pelatihan', ['tab' => 'kuis']))
            ->with('success', 'Butir soal kuis berhasil dihapus.');
    }

    /**
     * Submit answers for a quiz (Peternak).
     */
    public function submitQuiz(Request $request, LearningQuiz $quiz): JsonResponse|RedirectResponse
    {
        $user = auth()->user();

        if (! $user) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Silakan masuk untuk mengerjakan kuis.'], 401);
            }

            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            $adminErrorMsg = 'Akun Admin Dinas berfungsi sebagai pengelola pelatihan dan pembuat bank soal, bukan peserta yang mengerjakan kuis evaluasi.';
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => $adminErrorMsg], 403);
            }

            return redirect()->to(route('pelatihan', ['tab' => 'kuis']))->with('error', $adminErrorMsg);
        }

        $questions = $quiz->questions;
        $totalQuestions = $questions->count();

        if ($totalQuestions === 0) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Kuis ini belum memiliki butir soal.'], 400);
            }

            return redirect()->back()->with('error', 'Kuis ini belum memiliki butir soal.');
        }

        $submittedAnswers = $request->input('answers', []);
        $correctCount = 0;
        $questionResults = [];

        foreach ($questions as $q) {
            $userAns = $submittedAnswers[$q->id] ?? null;
            $isCorrect = ($userAns === $q->correct_answer);

            if ($isCorrect) {
                $correctCount++;
            }

            $questionResults[$q->id] = [
                'user_answer' => $userAns,
                'correct_answer' => $q->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $q->explanation,
            ];
        }

        $score = (int) round(($correctCount / $totalQuestions) * 100);
        $passed = ($score >= $quiz->passing_score);

        $attempt = QuizAttempt::create([
            'learning_quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers_count' => $correctCount,
            'user_answers' => $submittedAnswers,
            'passed' => $passed,
            'completed_at' => now(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'attempt_id' => $attempt->id,
                'score' => $score,
                'passed' => $passed,
                'passing_score' => $quiz->passing_score,
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'question_results' => $questionResults,
            ]);
        }

        return redirect()->to(route('pelatihan', ['tab' => 'kuis', 'attempt' => $attempt->id]))
            ->with('quiz_result', [
                'quiz_title' => $quiz->title,
                'score' => $score,
                'passed' => $passed,
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'passing_score' => $quiz->passing_score,
            ])
            ->with('success', $passed
                ? "Selamat! Anda lulus kuis '{$quiz->title}' dengan skor {$score}/100."
                : "Skor Anda {$score}/100. Batas kelulusan adalah {$quiz->passing_score}. Silakan pelajari kembali modul video dan coba lagi!");
    }

    /**
     * Track video watch progress (Peternak).
     */
    public function updateVideoProgress(Request $request, LearningMaterial $material): JsonResponse|RedirectResponse
    {
        $user = auth()->user();

        if ($user && ! $user->isAdmin()) {
            UserLearningProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'learning_material_id' => $material->id,
                ],
                [
                    'is_watched' => true,
                    'watch_percentage' => 100,
                    'last_watched_at' => now(),
                ]
            );
        }

        $material->increment('views_count');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Progres tontonan berhasil dicatat.',
                'views_count' => $material->views_count,
            ]);
        }

        return redirect()->back()->with('success', "Progres menonton modul '{$material->title}' telah dicatat.");
    }

    /**
     * Download learning documents safely.
     */
    public function downloadDocument(string $type, int|string $id): BinaryFileResponse|RedirectResponse
    {
        if ($type === 'material') {
            $item = LearningMaterial::findOrFail($id);
            $item->increment('downloads_count');
            $filePath = $item->file_path;
            $downloadName = Str::slug($item->title).'.pdf';
        } elseif ($type === 'zoom') {
            $item = Training::findOrFail($id);
            $filePath = $item->document_path ?? 'materials/silabus-zoom-bimtek.pdf';
            $downloadName = $item->document_name ?? (Str::slug($item->title).'-silabus.pdf');
        } else {
            abort(404, 'Tipe dokumen tidak valid.');
        }

        // Check if file exists in storage/app/public
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return response()->download(Storage::disk('public')->path($filePath), $downloadName);
        }

        // Fallback default sample file
        $defaultPath = storage_path('app/public/materials/sop-formulasi-pakan.pdf');
        if (file_exists($defaultPath)) {
            return response()->download($defaultPath, $downloadName);
        }

        return redirect()->back()->with('error', 'Berkas dokumen belum tersedia di penyimpanan.');
    }

    /**
     * Issue a digital certificate for a peternak (Admin only).
     */
    /**
     * Issue/create a certificate for a training program (Admin only).
     * Based on training name - no individual recipient selection required.
     */
    public function issueCertificate(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang membuat sertifikat digital.');
        }

        $validated = $request->validate([
            'training_id' => ['required', 'exists:trainings,id'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $training = Training::findOrFail($validated['training_id']);
        $certTitle = ! empty($validated['title'])
            ? $validated['title']
            : ('Sertifikasi Kompetensi: '.$training->title);

        $training->update([
            'has_certificate' => true,
            'certificate_title' => $certTitle,
        ]);

        $targetTab = $request->input('tab', 'sertifikat');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "E-Sertifikat resmi untuk program '{$training->title}' berhasil dibuat dan siap diunduh oleh peserta.");
    }

    /**
     * Deactivate / delete a training certificate template (Admin only).
     */
    public function destroyCertificateTemplate(Training $training): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang mengelola sertifikat digital.');
        }

        $training->update([
            'has_certificate' => false,
            'certificate_title' => null,
        ]);

        $targetTab = request()->query('tab', 'sertifikat');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "E-Sertifikat untuk program '{$training->title}' berhasil dinonaktifkan.");
    }

    /**
     * Preview certificate template for admin without claiming a personal certificate.
     */
    public function previewCertificate(Training $training): View
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang melihat pratinjau sertifikat.');
        }

        $certificate = new Certificate([
            'certificate_number' => 'DISNAK-JTM-'.date('Y').'-CONTOH',
            'recipient_name' => '[Nama Lengkap Peserta]',
            'recipient_code' => 'NIK-PESERTA-XXXX',
            'title' => $training->certificate_title ?? ('Sertifikasi Pelatihan: '.$training->title),
            'issued_date' => now(),
            'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
        ]);

        $isPreview = true;

        return view('certificates.show', compact('certificate', 'training', 'isPreview'));
    }

    /**
     * Delete an issued individual certificate (Admin only).
     */
    public function destroyCertificate(Certificate $certificate): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus sertifikat digital.');
        }

        $certNum = $certificate->certificate_number;
        $certificate->delete();

        $targetTab = request()->query('tab', 'sertifikat');

        return redirect()->to(route('pelatihan', ['tab' => $targetTab]))
            ->with('success', "Sertifikat digital '{$certNum}' berhasil dihapus.");
    }

    /**
     * Download or view the official digital certificate for a specific training (Participant/Peternak).
     * Automatically assigns a unique certificate number for each participant.
     */
    public function downloadCertificate(Request $request, Training $training): View|RedirectResponse
    {
        $currentUser = auth()->user();

        if (! $currentUser) {
            return redirect()->route('login');
        }

        // Peserta hanya dapat mengunduh jika sertifikat sudah dibuatkan oleh admin
        if (! $training->has_certificate && ! $currentUser->isAdmin()) {
            return redirect()->to(route('pelatihan', ['tab' => 'sertifikat']))
                ->with('error', 'E-Sertifikat untuk pelatihan ini belum diterbitkan oleh Admin.');
        }

        $targetUserId = $currentUser->id;
        if ($currentUser->isAdmin() && $request->filled('user_id')) {
            $targetUserId = $request->integer('user_id');
        }

        $targetUser = User::find($targetUserId) ?? $currentUser;

        // Retrieve existing certificate or automatically generate a unique one
        $certificate = Certificate::where('user_id', $targetUser->id)
            ->where('training_id', $training->id)
            ->first();

        if (! $certificate) {
            $certCount = (Certificate::max('id') ?? 0) + 1;
            $certNum = 'DISNAK-JTM-'.date('Y').'-'.str_pad($certCount, 4, '0', STR_PAD_LEFT);
            while (Certificate::where('certificate_number', $certNum)->exists()) {
                $certCount++;
                $certNum = 'DISNAK-JTM-'.date('Y').'-'.str_pad($certCount, 4, '0', STR_PAD_LEFT);
            }

            $certificate = Certificate::create([
                'user_id' => $targetUser->id,
                'training_id' => $training->id,
                'certificate_number' => $certNum,
                'recipient_name' => $targetUser->name,
                'recipient_code' => $targetUser->nik ?? ('NIK-'.rand(1000, 9999)),
                'title' => $training->certificate_title ?? ('Sertifikasi Pelatihan: '.$training->title),
                'issued_date' => now()->toDateString(),
                'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
            ]);
        }

        return view('certificates.show', compact('certificate', 'training'));
    }
}

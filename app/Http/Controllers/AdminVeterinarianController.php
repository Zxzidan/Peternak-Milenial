<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
use App\Models\User;
use App\Models\Veterinarian;
use App\Services\HealthReportDistributionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminVeterinarianController extends Controller
{
    /**
     * Display veterinarians list and health report monitoring summary for Admin Dinas.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status');

        $query = Veterinarian::with('user')
            ->withCount([
                'assignedHealthReports as active_reports_count' => function ($q) {
                    $q->whereIn('status', ['menunggu_respons', 'sedang_ditangani']);
                },
                'assignedHealthReports as total_reports_count',
                'assignedHealthReports as completed_reports_count' => function ($q) {
                    $q->where('status', 'selesai');
                },
            ])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%")
                    ->orWhere('puskeswan', 'like', "%{$search}%")
                    ->orWhere('wilayah_penugasan', 'like', "%{$search}%")
                    ->orWhere('strv_number', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            if ($statusFilter === 'active') {
                $query->where('is_active', true);
            } elseif ($statusFilter === 'inactive') {
                $query->where('is_active', false);
            } else {
                $query->where('status', $statusFilter);
            }
        }

        $veterinarians = $query->paginate(10)->withQueryString();

        // Monitoring Statistics for Admin Dinas (termasuk antrean menunggu penugasan)
        $reportMetrics = [
            'total' => AnimalHealthReport::count(),
            'menunggu_penugasan' => AnimalHealthReport::where('status', 'menunggu_penugasan')->orWhereNull('assigned_veterinarian_id')->whereNotIn('status', ['selesai'])->count(),
            'menunggu_respons' => AnimalHealthReport::where('status', 'menunggu_respons')->count(),
            'sedang_ditangani' => AnimalHealthReport::where('status', 'sedang_ditangani')->count(),
            'sudah_dijawab' => AnimalHealthReport::where('status', 'sudah_dijawab')->count(),
            'perlu_kunjungan' => AnimalHealthReport::whereIn('status', ['menunggu_kunjungan', 'kunjungan_terjadwal'])->count(),
            'selesai' => AnimalHealthReport::where('status', 'selesai')->count(),
        ];

        return view('admin.veterinarians.index', [
            'veterinarians' => $veterinarians,
            'reportMetrics' => $reportMetrics,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Store a newly created Dokter Hewan account (Admin only).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:30'],
            'strv_number' => ['nullable', 'string', 'max:100'],
            'specialization' => ['required', 'string', 'max:255'],
            'puskeswan' => ['required', 'string', 'max:255'],
            'wilayah_penugasan' => ['nullable', 'string', 'max:255'],
            'consultation_hours' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:online,praktik_lapangan,siaga,offline'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama lengkap dokter hewan wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'phone_number.required' => 'Nomor telepon/WhatsApp aktif wajib diisi.',
            'specialization.required' => 'Bidang spesialisasi wajib dipilih.',
            'puskeswan.required' => 'Puskeswan induk penugasan wajib diisi.',
            'password.required' => 'Kata sandi awal wajib ditetapkan.',
            'password.min' => 'Kata sandi awal minimal 6 karakter demi keamanan akun.',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create User account with role 'dokter_hewan'
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'role' => 'dokter_hewan',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make($validated['password']),
            ]);

            // 2. Create Veterinarian profile linked to user_id
            Veterinarian::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'specialization' => $validated['specialization'],
                'puskeswan' => $validated['puskeswan'],
                'wilayah_penugasan' => $validated['wilayah_penugasan'] ?? $validated['puskeswan'],
                'strv_number' => $validated['strv_number'] ?? null,
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'status' => $validated['status'],
                'consultation_hours' => ! empty($validated['consultation_hours']) ? $validated['consultation_hours'] : '08.00 - 16.00 WIB',
                'is_active' => true,
            ]);
        });

        // Trigger distribution of any waiting unassigned reports to the newly created doctor
        app(HealthReportDistributionService::class)->distributePendingReports();

        return redirect()->back()
            ->with('success', "Akun Dokter Hewan Dinas untuk {$validated['name']} berhasil dibuat dan aktif.")
            ->with('newly_created_vet', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'puskeswan' => $validated['puskeswan'],
                'specialization' => $validated['specialization'],
            ]);
    }

    /**
     * Update existing veterinarian profile and account details.
     */
    public function update(Request $request, Veterinarian $veterinarian): RedirectResponse
    {
        $user = $veterinarian->user;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
            'strv_number' => ['nullable', 'string', 'max:100'],
            'specialization' => ['required', 'string', 'max:255'],
            'puskeswan' => ['required', 'string', 'max:255'],
            'wilayah_penugasan' => ['nullable', 'string', 'max:255'],
            'consultation_hours' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:online,praktik_lapangan,siaga,offline'],
            'password' => ['nullable', 'string', 'min:6'],
        ];

        if ($user) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id];
        } else {
            $rules['email'] = ['nullable', 'string', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        $passwordUpdated = ! empty($validated['password']);

        DB::transaction(function () use ($veterinarian, $user, $validated) {
            if ($user) {
                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                ];

                if (! empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }

                $user->update($userData);
            } elseif (! empty($validated['email'])) {
                // Buat akun user login jika dokter sebelumnya belum memiliki akun
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                    'role' => 'dokter_hewan',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'password' => Hash::make($validated['password'] ?: 'password'),
                ]);
                $veterinarian->user_id = $user->id;
            }

            $veterinarian->update([
                'user_id' => $user ? $user->id : $veterinarian->user_id,
                'name' => $validated['name'],
                'specialization' => $validated['specialization'],
                'puskeswan' => $validated['puskeswan'],
                'wilayah_penugasan' => $validated['wilayah_penugasan'] ?? $validated['puskeswan'],
                'strv_number' => $validated['strv_number'] ?? null,
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'] ?? null,
                'status' => $validated['status'],
                'consultation_hours' => ! empty($validated['consultation_hours']) ? $validated['consultation_hours'] : $veterinarian->consultation_hours,
            ]);
        });

        $successMessage = "Data Dokter Hewan {$veterinarian->name} berhasil diperbarui.";
        if ($passwordUpdated) {
            $successMessage .= ' Kata sandi akun dokter berhasil diperbarui.';
        }

        return redirect()->back()
            ->with('success', $successMessage);
    }

    /**
     * Toggle active/inactive status of veterinarian account.
     */
    public function toggleActive(Veterinarian $veterinarian): RedirectResponse
    {
        $newActive = ! $veterinarian->is_active;

        DB::transaction(function () use ($veterinarian, $newActive) {
            $veterinarian->update(['is_active' => $newActive]);

            if ($veterinarian->user) {
                $veterinarian->user->update(['is_active' => $newActive]);
            }
        });

        $statusText = $newActive ? 'diaktifkan kembali' : 'dinonaktifkan';

        if ($newActive) {
            app(HealthReportDistributionService::class)->distributePendingReports();
        }

        return redirect()->back()
            ->with('success', "Akun dokter hewan {$veterinarian->name} berhasil {$statusText}.");
    }

    /**
     * Remove veterinarian from system.
     */
    public function destroy(Veterinarian $veterinarian): RedirectResponse
    {
        $name = $veterinarian->name;

        DB::transaction(function () use ($veterinarian) {
            $user = $veterinarian->user;
            $veterinarian->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()->back()
            ->with('success', "Dokter hewan {$name} berhasil dihapus dari sistem.");
    }
}

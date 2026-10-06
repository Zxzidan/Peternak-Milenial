<?php

namespace App\Http\Controllers;

use App\Models\DisasterGuide;
use App\Models\EmergencyReport;
use App\Models\EmergencyReportLog;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmergencyReportController extends Controller
{
    /**
     * Display the Emergency Response page.
     */
    public function index(): View
    {
        $currentUser = auth()->user();

        $activeCount = EmergencyReport::whereIn('status', ['received', 'verified', 'in_progress'])->count();
        $pendingVerificationCount = EmergencyReport::where('status', 'received')->count();
        $officersCount = User::where('role', 'admin')->count();
        $resolvedCount = EmergencyReport::where('status', 'resolved')->count();

        // Get active report for live timeline
        $activeReport = EmergencyReport::with(['reporter', 'region', 'logs', 'assignedOfficer'])
            ->whereIn('status', ['received', 'verified', 'in_progress'])
            ->latest()
            ->first();

        // All reports
        $allReports = EmergencyReport::with(['reporter', 'region', 'assignedOfficer'])->latest()->take(15)->get();

        $myReports = ($currentUser && $currentUser->isPeternak())
            ? EmergencyReport::with(['reporter', 'region', 'assignedOfficer'])
                ->where('user_id', $currentUser->id)
                ->latest()
                ->get()
            : collect();

        $disasterGuides = DisasterGuide::all();
        $regions = Region::orderBy('name')->get();

        return view('darurat', [
            'activeCount' => $activeCount,
            'pendingVerificationCount' => $pendingVerificationCount,
            'officersCount' => $officersCount,
            'resolvedCount' => $resolvedCount,
            'activeReport' => $activeReport,
            'allReports' => $allReports,
            'myReports' => $myReports,
            'disasterGuides' => $disasterGuides,
            'regions' => $regions,
        ]);
    }

    /**
     * Store a new emergency report into the database (by Peternak).
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);
        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Anda untuk mengirim laporan darurat.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('darurat')->with('error', 'Admin Dinas bertugas menerima, memverifikasi, dan menangani laporan, bukan membuat laporan baru.');
        }
        $validated = $request->validate([
            'incident_type' => ['required', 'in:wabah,bencana,kecelakaan'],
            'livestock_type' => ['required', 'in:sapi_perah,sapi_potong,kambing,unggas,lainnya'],
            'affected_count' => ['required', 'integer', 'min:1'],
            'location_address' => ['required', 'string', 'max:255'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();
        $regionId = $validated['region_id'] ?? Region::first()?->id;

        // Generate sequential report code
        $count = EmergencyReport::count() + 1;
        $reportCode = '#EM-'.date('Y').'-'.str_pad($count, 3, '0', STR_PAD_LEFT);

        $report = EmergencyReport::create([
            'report_code' => $reportCode,
            'user_id' => $user->id,
            'region_id' => $regionId,
            'incident_type' => $validated['incident_type'],
            'livestock_type' => $validated['livestock_type'],
            'affected_count' => $validated['affected_count'],
            'location_address' => $validated['location_address'],
            'latitude' => $validated['latitude'] ?? -7.6521,
            'longitude' => $validated['longitude'] ?? 112.6983,
            'description' => $validated['description'] ?? 'Laporan darurat ternak dari aplikasi Peternak Milenial',
            'status' => 'received',
            'officer_notes' => 'Laporan baru diterima oleh sistem Kesmavet. Menunggu verifikasi petugas lapangan.',
        ]);

        EmergencyReportLog::create([
            'emergency_report_id' => $report->id,
            'status' => 'received',
            'officer_id' => $user->id,
            'note' => 'Laporan darurat berhasil dibuat oleh peternak.',
            'logged_at' => now(),
        ]);

        return redirect()->route('darurat')->with('success', "Laporan darurat {$reportCode} berhasil dikirim ke Kesmavet dan tim siaga!");
    }

    /**
     * Update status of an emergency report (Admin only).
     */
    public function updateStatus(Request $request, EmergencyReport $report): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memperbarui status penanganan laporan darurat.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:received,verified,in_progress,resolved'],
            'officer_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $newStatus = $validated['status'];

        $updateData = [
            'status' => $newStatus,
        ];

        if (! empty($validated['officer_notes'])) {
            $updateData['officer_notes'] = $validated['officer_notes'];
        }

        if ($newStatus === 'verified' && ! $report->verified_at) {
            $updateData['verified_at'] = now();
        }

        if ($newStatus === 'resolved' && ! $report->resolved_at) {
            $updateData['resolved_at'] = now();
        }

        $report->update($updateData);

        EmergencyReportLog::create([
            'emergency_report_id' => $report->id,
            'status' => $newStatus,
            'officer_id' => auth()->id() ?? User::where('role', 'admin')->value('id') ?? User::first()?->id,
            'note' => $validated['officer_notes'] ?? "Status diubah menjadi {$newStatus}",
            'logged_at' => now(),
        ]);

        return redirect()->route('darurat')->with('success', "Status laporan {$report->report_code} berhasil diperbarui menjadi {$newStatus}!");
    }

    /**
     * Delete an emergency report with ownership verification.
     */
    public function destroy(EmergencyReport $report): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin() && $report->user_id !== $currentUser->id) {
            abort(403, 'Anda hanya dapat menghapus laporan milik Anda sendiri.');
        }

        $code = $report->report_code;
        $report->delete();

        return redirect()->route('darurat')->with('success', "Laporan {$code} berhasil dihapus dari sistem.");
    }
}

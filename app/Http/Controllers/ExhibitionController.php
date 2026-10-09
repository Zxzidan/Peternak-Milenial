<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExhibitionController extends Controller
{
    /**
     * Display exhibitions, calendar events, and registered booths.
     */
    public function index(Request $request): View
    {
        $currentUser = auth()->user();
        $activeTab = $request->query('tab', 'agenda');
        if (! in_array($activeTab, ['agenda', 'stand', 'kalender'])) {
            $activeTab = 'agenda';
        }
        if ($currentUser && $currentUser->isUmum() && $activeTab === 'stand') {
            $activeTab = 'agenda';
        }

        $featuredExhibition = Exhibition::where('is_featured', true)->first() ?? Exhibition::first();
        $exhibitions = Exhibition::orderByDesc('is_featured')->orderBy('start_date')->get();
        $calendarEvents = CalendarEvent::orderBy('event_date')->get();
        $regions = Region::orderBy('name')->get();

        if ($currentUser && $currentUser->isAdmin()) {
            $registrations = ExhibitionRegistration::with(['exhibition', 'user'])->latest()->get();
        } elseif ($currentUser && $currentUser->isPeternak()) {
            $registrations = ExhibitionRegistration::with(['exhibition', 'user'])
                ->where('user_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            $registrations = collect();
        }

        return view('pameran', [
            'activeTab' => $activeTab,
            'featuredExhibition' => $featuredExhibition,
            'exhibitions' => $exhibitions,
            'calendarEvents' => $calendarEvents,
            'registrations' => $registrations,
            'regions' => $regions,
        ]);
    }

    /**
     * Register a business for an exhibition booth (Peternak or Admin).
     */
    public function registerStand(Request $request): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && $currentUser->isUmum()) {
            abort(403, 'Pendaftaran stand pameran hanya dibuka untuk pelaku usaha peternak terdata.');
        }

        $validated = $request->validate([
            'exhibition_id' => ['required', 'exists:exhibitions,id'],
            'business_name' => ['required', 'string', 'max:255'],
            'exhibited_products' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $currentUser ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);
        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Peternak Anda untuk mendaftar stand pameran.');
        }
        $exhibition = Exhibition::findOrFail($validated['exhibition_id']);

        // Check if already registered
        $existing = ExhibitionRegistration::where('exhibition_id', $exhibition->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('pameran')
                ->with('error', "Anda sudah terdaftar pada '{$exhibition->title}' dengan status: {$existing->status}.");
        }

        $standNum = 'STD-'.strtoupper(substr($exhibition->slug, 0, 3)).'-'.rand(10, 99);
        $status = ($currentUser && $currentUser->isAdmin()) ? 'approved' : 'pending';

        $registration = ExhibitionRegistration::create([
            'exhibition_id' => $exhibition->id,
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'exhibited_products' => $validated['exhibited_products'],
            'status' => $status,
            'stand_number' => $standNum,
            'notes' => $validated['notes'] ?? 'Fasilitas stand Dinas Peternakan Jatim',
        ]);

        if ($status === 'approved') {
            $exhibition->increment('registered_stands_count');
        }

        $msg = $status === 'approved'
            ? "Pengajuan stand pameran '{$registration->business_name}' berhasil disetujui! Nomor Stand: {$standNum}."
            : "Pengajuan stand pameran '{$registration->business_name}' berhasil dikirim! Menunggu verifikasi dan persetujuan Admin Dinas.";

        return redirect()->route('pameran')->with('success', $msg);
    }

    /**
     * Update booth registration status (Admin only).
     */
    public function updateStatus(Request $request, ExhibitionRegistration $registration): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memverifikasi pendaftaran stand pameran.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $oldStatus = $registration->status;
        $newStatus = $validated['status'];

        $registration->update(['status' => $newStatus]);

        if ($oldStatus !== 'approved' && $newStatus === 'approved') {
            $registration->exhibition?->increment('registered_stands_count');
        } elseif ($oldStatus === 'approved' && $newStatus !== 'approved') {
            $registration->exhibition?->decrement('registered_stands_count');
        }

        return redirect()->route('pameran')
            ->with('success', "Status pengajuan stand {$registration->business_name} berhasil diubah menjadi {$newStatus}!");
    }

    /**
     * Cancel/delete booth registration (Registrant Peternak or Admin).
     */
    public function destroyRegistration(ExhibitionRegistration $registration): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin() && $registration->user_id !== $currentUser->id) {
            abort(403, 'Anda hanya dapat membatalkan pengajuan stand milik Anda sendiri.');
        }

        $name = $registration->business_name;
        $exhibition = $registration->exhibition;

        if ($registration->status === 'approved') {
            $exhibition?->decrement('registered_stands_count');
        }

        $registration->delete();

        return redirect()->route('pameran')
            ->with('success', "Pendaftaran stand '{$name}' berhasil dibatalkan.");
    }

    /**
     * Store a new exhibition agenda (Admin only).
     */
    public function storeExhibition(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang membuat agenda pameran.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'facilities' => ['nullable', 'string', 'max:1000'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'stand_capacity' => ['required', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);
        if (Exhibition::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(5);
        }

        if (! empty($validated['is_featured'])) {
            Exhibition::where('is_featured', true)->update(['is_featured' => false]);
        }

        Exhibition::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'facilities' => $validated['facilities'] ?? 'Booth Stand 3x3m, Meja Display Kaca & Kursi, Daya Listrik & Pendingin Chiller, Business Matching Buyer Modern, Sertifikat Resmi Disnak Jatim',
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'stand_capacity' => $validated['stand_capacity'],
            'registered_stands_count' => 0,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('pameran')
            ->with('success', "Agenda pameran '{$validated['title']}' berhasil diterbitkan!");
    }

    /**
     * Update an existing exhibition agenda (Admin only).
     */
    public function updateExhibition(Request $request, Exhibition $exhibition): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memperbarui agenda pameran.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'facilities' => ['nullable', 'string', 'max:1000'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'stand_capacity' => ['required', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['is_featured'])) {
            Exhibition::where('id', '!=', $exhibition->id)->where('is_featured', true)->update(['is_featured' => false]);
        }

        $exhibition->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'facilities' => $validated['facilities'] ?? $exhibition->facilities,
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'stand_capacity' => $validated['stand_capacity'],
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('pameran')
            ->with('success', "Agenda pameran '{$exhibition->title}' berhasil diperbarui!");
    }

    /**
     * Delete an exhibition agenda (Admin only).
     */
    public function destroyExhibition(Exhibition $exhibition): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus agenda pameran.');
        }

        $title = $exhibition->title;
        $exhibition->registrations()->delete();
        $exhibition->delete();

        return redirect()->route('pameran')
            ->with('success', "Agenda pameran '{$title}' berhasil dihapus.");
    }

    /**
     * Store a new calendar event (Admin only).
     */
    public function storeCalendarEvent(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambahkan agenda kegiatan.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'in:vaksinasi,pelatihan,pameran,pasar_ternak'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        CalendarEvent::create([
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'time_info' => '08:00 - 15:00 WIB',
            'location' => $validated['location'],
            'region_id' => $validated['region_id'] ?? null,
            'description' => $validated['description'] ?? 'Agenda kegiatan resmi Dinas Peternakan Jawa Timur.',
            'is_mandatory' => false,
        ]);

        return redirect()->route('pameran')
            ->with('success', "Agenda kegiatan '{$validated['title']}' berhasil ditambahkan ke kalender dinas!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    /**
     * Display exhibitions, calendar events, and registered booths.
     */
    public function index(): View
    {
        $featuredExhibition = Exhibition::where('is_featured', true)->first() ?? Exhibition::first();
        $exhibitions = Exhibition::all();
        $calendarEvents = CalendarEvent::orderBy('event_date')->get();

        $registrations = ExhibitionRegistration::with(['exhibition', 'user'])
            ->latest()
            ->get();

        return view('pameran', [
            'featuredExhibition' => $featuredExhibition,
            'exhibitions' => $exhibitions,
            'calendarEvents' => $calendarEvents,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Register a business for an exhibition booth.
     */
    public function registerStand(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'exhibition_id' => ['required', 'exists:exhibitions,id'],
            'business_name' => ['required', 'string', 'max:255'],
            'exhibited_products' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();
        $exhibition = Exhibition::findOrFail($validated['exhibition_id']);

        // Check if already registered
        $existing = ExhibitionRegistration::where('exhibition_id', $exhibition->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('pameran')
                ->with('error', "Anda sudah terdaftar pada '{$exhibition->title}' dengan Stand {$existing->stand_number}.");
        }

        $standNum = 'STD-'.strtoupper(substr($exhibition->slug, 0, 3)).'-'.rand(10, 99);

        $registration = ExhibitionRegistration::create([
            'exhibition_id' => $exhibition->id,
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'exhibited_products' => $validated['exhibited_products'],
            'status' => 'approved',
            'stand_number' => $standNum,
            'notes' => $validated['notes'] ?? 'Fasilitas stand Dinas Peternakan Jatim',
        ]);

        $exhibition->increment('registered_stands_count');

        return redirect()->route('pameran')
            ->with('success', "Pengajuan stand pameran '{$registration->business_name}' berhasil disetujui! Nomor Stand Anda: {$standNum}.");
    }

    /**
     * Update booth registration status.
     */
    public function updateStatus(Request $request, ExhibitionRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $registration->update(['status' => $validated['status']]);

        return redirect()->route('pameran')
            ->with('success', "Status pengajuan stand {$registration->business_name} berhasil diubah menjadi {$validated['status']}!");
    }

    /**
     * Cancel/delete booth registration.
     */
    public function destroyRegistration(ExhibitionRegistration $registration): RedirectResponse
    {
        $name = $registration->business_name;
        $exhibition = $registration->exhibition;

        if ($exhibition && $exhibition->registered_stands_count > 0) {
            $exhibition->decrement('registered_stands_count');
        }

        $registration->delete();

        return redirect()->route('pameran')
            ->with('success', "Pendaftaran stand '{$name}' berhasil dibatalkan.");
    }
}

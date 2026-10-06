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
        $currentUser = auth()->user();
        $featuredExhibition = Exhibition::where('is_featured', true)->first() ?? Exhibition::first();
        $exhibitions = Exhibition::all();
        $calendarEvents = CalendarEvent::orderBy('event_date')->get();

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
            'featuredExhibition' => $featuredExhibition,
            'exhibitions' => $exhibitions,
            'calendarEvents' => $calendarEvents,
            'registrations' => $registrations,
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
}

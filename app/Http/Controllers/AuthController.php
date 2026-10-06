<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $targetRoute = $user->isUmum() ? route('marketplace') : route('dashboard');

            return redirect()->intended($targetRoute)
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
            ]);
    }

    /**
     * Display the registration page.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $regions = Region::orderBy('name')->get();

        return view('auth.register', compact('regions'));
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'nik' => ['nullable', 'string', 'max:25'],
            'birth_date' => ['nullable', 'date'],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'desa' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'livestock_type' => ['nullable', 'string', 'max:100'],
            'livestock_count' => ['nullable', 'numeric', 'min:0'],
            'ktp_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:10240'],
            'role' => ['nullable', 'in:peternak,umum'],
            'terms' => ['nullable'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'ktp_file.max' => 'Ukuran berkas KTP maksimal 10 MB.',
            'ktp_file.mimes' => 'Format berkas KTP harus jpeg, png, atau jpg.',
        ]);

        $role = $validated['role'] ?? 'peternak';

        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $ktpPath = $request->file('ktp_file')->store('ktp_documents', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? $request->input('phone') ?? null,
            'nik' => $validated['nik'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'kabupaten' => $validated['kabupaten'] ?? null,
            'kecamatan' => $validated['kecamatan'] ?? null,
            'desa' => $validated['desa'] ?? null,
            'livestock_type' => $validated['livestock_type'] ?? null,
            'livestock_count' => isset($validated['livestock_count']) ? (int) $validated['livestock_count'] : null,
            'ktp_path' => $ktpPath,
            'role' => $role,
            'is_active' => true,
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $targetRoute = $user->isUmum() ? route('marketplace') : route('dashboard');

        return redirect($targetRoute)
            ->with('success', "Pendaftaran berhasil! Selamat datang di Peternak Milenial Jatim, {$user->name}.");
    }

    /**
     * Handle logging out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

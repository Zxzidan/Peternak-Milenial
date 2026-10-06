<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Training;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle global search across products, commodities, and bimtek.
     */
    public function search(Request $request): RedirectResponse
    {
        $query = trim((string) $request->input('query', $request->input('q', '')));

        if (empty($query)) {
            return redirect()->route('dashboard');
        }

        $lower = strtolower($query);

        if (str_contains($lower, 'darurat') || str_contains($lower, 'wabah') || str_contains($lower, 'kesmavet') || str_contains($lower, 'bencana')) {
            return redirect()->route('darurat')->with('success', "Menampilkan hasil pencarian untuk: '{$query}'");
        }

        if (str_contains($lower, 'bimtek') || str_contains($lower, 'latih') || str_contains($lower, 'sertifikat') || str_contains($lower, 'modul')) {
            return redirect()->route('pelatihan')->with('success', "Menampilkan hasil pencarian untuk: '{$query}'");
        }

        if (str_contains($lower, 'pameran') || str_contains($lower, 'expo') || str_contains($lower, 'stand') || str_contains($lower, 'agenda')) {
            return redirect()->route('pameran')->with('success', "Menampilkan hasil pencarian untuk: '{$query}'");
        }

        if (str_contains($lower, 'dokter') || str_contains($lower, 'obat') || str_contains($lower, 'medis') || str_contains($lower, 'konsul')) {
            return redirect()->route('konsultasi')->with('success', "Menampilkan hasil pencarian untuk: '{$query}'");
        }

        // Check if matching training
        $trainingExists = Training::where('title', 'like', "%{$query}%")->exists();
        if ($trainingExists) {
            return redirect()->route('pelatihan')->with('success', "Ditemukan pelatihan terkait: '{$query}'");
        }

        // Check if matching commodity
        $commodityExists = Commodity::where('name', 'like', "%{$query}%")->exists();
        if ($commodityExists) {
            return redirect()->route('harga-komoditas')->with('success', "Ditemukan komoditas terkait: '{$query}'");
        }

        // Default: Marketplace search
        return redirect()->route('marketplace', ['q' => $query]);
    }
}

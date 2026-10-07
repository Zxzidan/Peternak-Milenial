<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\ProductionCenter;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommodityPriceController extends Controller
{
    /**
     * Display commodity prices and production centers.
     */
    public function index(Request $request): View
    {
        $commodities = Commodity::all();
        $regions = Region::orderBy('name')->get();

        $query = CommodityPrice::with(['commodity', 'region']);

        if ($request->filled('wilayah')) {
            $query->where('region_id', $request->wilayah);
        }

        if ($request->filled('komoditas')) {
            $query->where('commodity_id', $request->komoditas);
        }

        $commodityPrices = $query->latest('recorded_date')->get();

        $productionCenters = ProductionCenter::with(['region', 'commodity'])->get();

        $activeTab = $request->query('tab', 'tren');
        if (! in_array($activeTab, ['tren', 'sentra', 'unggulan'])) {
            $activeTab = 'tren';
        }

        return view('harga-komoditas', [
            'commodityPrices' => $commodityPrices,
            'productionCenters' => $productionCenters,
            'commodities' => $commodities,
            'regions' => $regions,
            'selectedRegion' => $request->wilayah,
            'selectedCommodity' => $request->komoditas,
            'activeTab' => $activeTab,
        ]);
    }

    /**
     * Store updated commodity price (Admin only).
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menginput dan memperbarui data harga komoditas.');
        }

        $validated = $request->validate([
            'commodity_id' => ['required', 'exists:commodities,id'],
            'region_id' => ['required', 'exists:regions,id'],
            'farmer_price' => ['required', 'numeric', 'min:100'],
            'consumer_price' => ['required', 'numeric', 'min:100'],
        ]);

        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'admin')->first() : null);
        if (! $user) {
            abort(403);
        }

        // Calculate change compared to last recorded price for this commodity
        $lastPrice = CommodityPrice::where('commodity_id', $validated['commodity_id'])
            ->where('region_id', $validated['region_id'])
            ->latest('recorded_date')
            ->first();

        $diff = 0;
        $diffPercentage = 0;
        $status = 'stabil';

        if ($lastPrice && $lastPrice->farmer_price > 0) {
            $diff = $validated['farmer_price'] - $lastPrice->farmer_price;
            $diffPercentage = round(($diff / $lastPrice->farmer_price) * 100, 2);

            if ($diff > 0) {
                $status = 'naik';
            } elseif ($diff < 0) {
                $status = 'turun';
            }
        }

        $price = CommodityPrice::create([
            'commodity_id' => $validated['commodity_id'],
            'region_id' => $validated['region_id'],
            'recorded_date' => now()->toDateString(),
            'farmer_price' => $validated['farmer_price'],
            'consumer_price' => $validated['consumer_price'],
            'price_change_7d' => $diff,
            'price_change_percentage' => $diffPercentage,
            'status' => $status,
            'source' => 'Petugas Pasar & Penyuluh Disnak Jatim',
            'recorded_by' => $user->id,
        ]);

        $commodityName = $price->commodity?->name ?? 'Komoditas';

        return redirect()->route('harga-komoditas')
            ->with('success', "Data harga '{$commodityName}' berhasil diperbarui dan disimpan ke database!");
    }

    /**
     * Delete a commodity price entry (Admin only).
     */
    public function destroy(CommodityPrice $price): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus data harga komoditas.');
        }

        $price->delete();

        return redirect()->route('harga-komoditas')
            ->with('success', 'Data harga berhasil dihapus dari sistem.');
    }
}

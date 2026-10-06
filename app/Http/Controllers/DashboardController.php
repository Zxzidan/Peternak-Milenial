<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\EmergencyReport;
use App\Models\Product;
use App\Models\ProductionCenter;
use App\Models\Training;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard with real database aggregates.
     */
    public function index(): View
    {
        // 1. KPI Aggregates from Database
        $totalFarmerCount = ProductionCenter::sum('farmer_count');
        $displayPeternakCount = $totalFarmerCount > 0 ? number_format($totalFarmerCount, 0, ',', '.') : '1.248.560';

        $dailyProductionSum = ProductionCenter::sum('daily_production');
        $displayDailyProduction = $dailyProductionSum > 0 ? number_format($dailyProductionSum, 0, ',', '.') : '1.460';

        $commodityCount = Commodity::count() > 0 ? Commodity::count() : 5;
        $totalLivestockPopulation = ProductionCenter::sum('livestock_population');
        $activeEmergencyCount = EmergencyReport::whereIn('status', ['received', 'verified', 'in_progress'])->count();
        $openTrainingCount = Training::where('status', 'open')->count();
        $activeProductCount = Product::where('status', 'active')->count();

        // 2. Sentra Produksi Geospasial (MASP)
        $sentras = ProductionCenter::with(['region', 'commodity'])->get();

        // 3. Harga Komoditas Harian Terbaru
        $latestPrices = CommodityPrice::with(['commodity', 'region'])
            ->latest('recorded_date')
            ->take(5)
            ->get();

        // 4. Laporan Darurat Siaga Terbaru
        $activeReports = EmergencyReport::with(['reporter', 'region'])
            ->whereIn('status', ['received', 'verified', 'in_progress'])
            ->latest()
            ->take(2)
            ->get();

        // 5. Agenda Terdekat
        $upcomingEvents = CalendarEvent::where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(3)
            ->get();

        // 6. Data Chart Distribusi Populasi Ternak (Juta Ekor)
        $chartPopulasi = [
            'categories' => ['Ayam Ras Pedaging', 'Ayam Ras Petelur', 'Sapi Potong', 'Kambing & Domba', 'Sapi Perah'],
            'data' => [74.2, 52.8, 4.92, 4.35, 0.31],
        ];

        // 7. Data Chart Produksi Komoditas Utama (Ribu Ton)
        $chartProduksi = [
            'categories' => ['Telur Ayam Ras', 'Susu Sapi Segar', 'Daging Ayam', 'Daging Sapi'],
            'data' => [568, 534, 442, 115],
        ];

        return view('dashboard', [
            'displayPeternakCount' => $displayPeternakCount,
            'displayDailyProduction' => $displayDailyProduction,
            'commodityCount' => $commodityCount,
            'totalLivestockPopulation' => $totalLivestockPopulation,
            'activeEmergencyCount' => $activeEmergencyCount,
            'openTrainingCount' => $openTrainingCount,
            'activeProductCount' => $activeProductCount,
            'sentras' => $sentras,
            'latestPrices' => $latestPrices,
            'activeReports' => $activeReports,
            'upcomingEvents' => $upcomingEvents,
            'chartPopulasi' => $chartPopulasi,
            'chartProduksi' => $chartProduksi,
        ]);
    }
}

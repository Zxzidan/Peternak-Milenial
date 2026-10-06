<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Certificate;
use App\Models\Commodity;
use App\Models\CommodityPrice;
use App\Models\EmergencyReport;
use App\Models\Exhibition;
use App\Models\ExhibitionRegistration;
use App\Models\Livestock;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductionCenter;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard adapted to user role.
     */
    public function index(): View
    {
        $user = auth()->user();
        $userRole = $user?->role ?? 'umum';

        // 1. KPI Pengguna Terdaftar (100% Real-time Berdasarkan Tabel users Authentication)
        $totalUserCount = User::where('is_active', true)->count();
        $displayUserCount = number_format($totalUserCount, 0, ',', '.');
        $displayPeternakCount = $displayUserCount;

        $dailyProductionSum = ProductionCenter::sum('daily_production');
        $displayDailyProduction = number_format($dailyProductionSum, 0, ',', '.');

        $commodityCount = Commodity::count();
        $totalLivestockPopulation = ProductionCenter::sum('livestock_population') + Livestock::count();
        $activeEmergencyCount = EmergencyReport::whereIn('status', ['received', 'verified', 'in_progress'])->count();
        $openTrainingCount = Training::where('status', 'open')->count();
        $activeProductCount = Product::where('status', 'active')->where('is_verified', true)->count();

        // 2. Metrik Khusus Sesuai Role Pengguna
        $adminMetrics = [
            'pendingProductsCount' => Product::where('is_verified', false)->count(),
            'pendingExhibitionsCount' => ExhibitionRegistration::where('status', 'pending')->count(),
            'pendingTrainingsCount' => TrainingRegistration::where('status', 'pending')->count(),
            'activeEmergencyCount' => $activeEmergencyCount,
        ];

        $peternakMetrics = [
            'myLivestockCount' => $user ? Livestock::where('user_id', $user->id)->count() : 0,
            'myProductsCount' => $user ? Product::where('user_id', $user->id)->count() : 0,
            'myUnverifiedProductsCount' => $user ? Product::where('user_id', $user->id)->where('is_verified', false)->count() : 0,
            'myEmergencyReportsCount' => $user ? EmergencyReport::where('user_id', $user->id)->count() : 0,
            'myTrainingsCount' => $user ? TrainingRegistration::where('user_id', $user->id)->count() : 0,
            'myCertificatesCount' => $user ? Certificate::where('user_id', $user->id)->count() : 0,
        ];

        $umumMetrics = [
            'availableProductsCount' => Product::where('is_verified', true)->where('status', 'active')->count(),
            'myOrdersCount' => $user ? Order::where('buyer_id', $user->id)->count() : 0,
            'exhibitionsCount' => Exhibition::count(),
            'commoditiesCount' => $commodityCount,
        ];

        // 3. Sentra Produksi Geospasial (MASP)
        $sentras = ProductionCenter::with(['region', 'commodity'])->get();

        // 4. Harga Komoditas Harian Terbaru
        $latestPrices = CommodityPrice::with(['commodity', 'region'])
            ->latest('recorded_date')
            ->take(5)
            ->get();

        // 5. Laporan Darurat Siaga Terbaru
        $activeReports = EmergencyReport::with(['reporter', 'region'])
            ->whereIn('status', ['received', 'verified', 'in_progress'])
            ->latest()
            ->take(2)
            ->get();

        // 6. Agenda Terdekat
        $upcomingEvents = CalendarEvent::where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(3)
            ->get();

        // 7. Data Chart Distribusi Populasi Ternak (Dari Database Aktual)
        $chartPopulasi = [
            'categories' => [],
            'data' => [],
        ];
        $sentraPopulasi = ProductionCenter::where('livestock_population', '>', 0)->get();
        if ($sentraPopulasi->isNotEmpty()) {
            foreach ($sentraPopulasi as $sp) {
                $chartPopulasi['categories'][] = $sp->name;
                $chartPopulasi['data'][] = round($sp->livestock_population / 1000000, 2);
            }
        } elseif (Livestock::exists()) {
            $lsGroups = Livestock::selectRaw('type, count(*) as total')->groupBy('type')->get();
            foreach ($lsGroups as $ls) {
                $chartPopulasi['categories'][] = ucwords(str_replace('_', ' ', $ls->type));
                $chartPopulasi['data'][] = $ls->total;
            }
        }

        // 8. Data Chart Produksi Komoditas Utama (Dari Database Aktual)
        $chartProduksi = [
            'categories' => [],
            'data' => [],
        ];
        $sentraProduksi = ProductionCenter::with('commodity')->where('daily_production', '>', 0)->get();
        if ($sentraProduksi->isNotEmpty()) {
            foreach ($sentraProduksi as $sp) {
                $chartProduksi['categories'][] = $sp->commodity?->name ?? $sp->name;
                $chartProduksi['data'][] = round($sp->daily_production, 2);
            }
        }

        // 9. Data Khusus Pengguna Masyarakat (Marketplace Focus)
        $buyerFeaturedProducts = Product::with(['category', 'region', 'seller'])
            ->where('status', 'active')
            ->where('is_verified', true)
            ->latest()
            ->take(6)
            ->get();

        $buyerOrders = ($user && $user->isUmum())
            ? Order::where('buyer_id', $user->id)
                ->with(['items.product.category', 'items.seller'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('dashboard', [
            'userRole' => $userRole,
            'totalUserCount' => $totalUserCount,
            'displayUserCount' => $displayUserCount,
            'displayPeternakCount' => $displayPeternakCount,
            'displayDailyProduction' => $displayDailyProduction,
            'commodityCount' => $commodityCount,
            'totalLivestockPopulation' => $totalLivestockPopulation,
            'activeEmergencyCount' => $activeEmergencyCount,
            'openTrainingCount' => $openTrainingCount,
            'activeProductCount' => $activeProductCount,
            'adminMetrics' => $adminMetrics,
            'peternakMetrics' => $peternakMetrics,
            'umumMetrics' => $umumMetrics,
            'sentras' => $sentras,
            'latestPrices' => $latestPrices,
            'activeReports' => $activeReports,
            'upcomingEvents' => $upcomingEvents,
            'chartPopulasi' => $chartPopulasi,
            'chartProduksi' => $chartProduksi,
            'buyerFeaturedProducts' => $buyerFeaturedProducts,
            'buyerOrders' => $buyerOrders,
        ]);
    }
}

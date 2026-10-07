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
use App\Services\JatimLivestockDataService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected JatimLivestockDataService $livestockDataService = new JatimLivestockDataService
    ) {}

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

        // Ambil Data Statistik Resmi Provinsi Jawa Timur (Disnak Jatim & BPS)
        $jatimStats = $this->livestockDataService->getStatistics();
        $displayDailyProduction = number_format($jatimStats['summary']['daily_total_production_ton'] ?? 8348, 0, ',', '.');

        $commodityCount = Commodity::count();
        $totalLivestockPopulation = $jatimStats['summary']['total_livestock_population'];
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

        // 7. Data Chart Distribusi Populasi Ternak Jawa Timur (Valid dari Disnak Jatim & BPS)
        $chartPopulasi = $jatimStats['populasi'];

        // 8. Data Chart Produksi Komoditas Utama Jawa Timur (Valid dari Disnak Jatim & BPS)
        $chartProduksi = $jatimStats['produksi'];

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
            'sentraData' => $this->livestockDataService->getSentraData(),
            'latestPrices' => $latestPrices,
            'activeReports' => $activeReports,
            'upcomingEvents' => $upcomingEvents,
            'chartPopulasi' => $chartPopulasi,
            'chartProduksi' => $chartProduksi,
            'buyerFeaturedProducts' => $buyerFeaturedProducts,
            'buyerOrders' => $buyerOrders,
            'jatimStats' => $jatimStats,
        ]);
    }

    /**
     * API Data Valid Statistik Peternakan Milik Provinsi Jawa Timur.
     * Sumber: Dinas Peternakan Jawa Timur & BPS (Satu Data Jatim).
     */
    public function apiStatistikPeternakan(): JsonResponse
    {
        return response()->json($this->livestockDataService->getStatistics());
    }

    /**
     * API Resmi Sebaran Kawasan Sentra Peternakan (MASP) Dinas Peternakan Jawa Timur.
     * Sumber: Dinas Peternakan Jawa Timur (disnak.jatimprov.go.id) & Satu Data Jatim.
     */
    public function apiSentraPeternakan(): JsonResponse
    {
        return response()->json($this->livestockDataService->getSentraData());
    }
}

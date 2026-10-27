<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(
        protected JatimLivestockDataService $livestockDataService = new JatimLivestockDataService
    ) {}

    /**
     * Display the application dashboard adapted to user role.
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->isDokterHewan()) {
            return redirect()->route('dokter-hewan.dashboard');
        }

        $userRole = $user?->role ?? 'umum';

        $publicData = Cache::remember('dashboard_public_metrics_v1', 60, function () {
            $totalUserCount = User::where('is_active', true)->count();
            $commodityCount = Commodity::count();
            $activeEmergencyCount = EmergencyReport::whereIn('status', ['received', 'verified', 'in_progress'])->count();
            $openTrainingCount = Training::where('status', 'open')->count();
            $activeProductCount = Product::where('status', 'active')->where('is_verified', true)->count();

            $adminMetrics = [
                'pendingProductsCount' => Product::where('is_verified', false)->count(),
                'pendingExhibitionsCount' => ExhibitionRegistration::where('status', 'pending')->count(),
                'pendingTrainingsCount' => TrainingRegistration::where('status', 'pending')->count(),
                'activeEmergencyCount' => $activeEmergencyCount,
                'healthReportsTotal' => AnimalHealthReport::count(),
                'healthReportsWaiting' => AnimalHealthReport::where('status', 'menunggu_respons')->count(),
                'healthReportsInProgress' => AnimalHealthReport::whereIn('status', ['sedang_ditangani', 'menunggu_kunjungan', 'kunjungan_terjadwal', 'menunggu_tindak_lanjut'])->count(),
                'healthReportsAnswered' => AnimalHealthReport::where('status', 'sudah_dijawab')->count(),
                'healthReportsResolved' => AnimalHealthReport::where('status', 'selesai')->count(),
            ];

            $sentras = ProductionCenter::with(['region', 'commodity'])->get();
            $latestPrices = CommodityPrice::with(['commodity', 'region'])
                ->latest('recorded_date')
                ->take(5)
                ->get();
            $activeReports = EmergencyReport::with(['reporter', 'region'])
                ->whereIn('status', ['received', 'verified', 'in_progress'])
                ->latest()
                ->take(2)
                ->get();
            $upcomingEvents = CalendarEvent::where('event_date', '>=', now()->toDateString())
                ->orderBy('event_date')
                ->take(3)
                ->get();
            $buyerFeaturedProducts = Product::with(['category', 'region', 'seller'])
                ->where('status', 'active')
                ->where('is_verified', true)
                ->latest()
                ->take(6)
                ->get();
            $exhibitionsCount = Exhibition::count();

            return compact(
                'totalUserCount',
                'commodityCount',
                'activeEmergencyCount',
                'openTrainingCount',
                'activeProductCount',
                'adminMetrics',
                'sentras',
                'latestPrices',
                'activeReports',
                'upcomingEvents',
                'buyerFeaturedProducts',
                'exhibitionsCount'
            );
        });

        $totalUserCount = $publicData['totalUserCount'];
        $displayUserCount = number_format($totalUserCount, 0, ',', '.');
        $displayPeternakCount = $displayUserCount;

        // Ambil Data Statistik Resmi Provinsi Jawa Timur (Disnak Jatim & BPS)
        $jatimStats = $this->livestockDataService->getStatistics();
        $displayDailyProduction = number_format($jatimStats['summary']['daily_total_production_ton'] ?? 8348, 0, ',', '.');
        $totalLivestockPopulation = $jatimStats['summary']['total_livestock_population'];

        $commodityCount = $publicData['commodityCount'];
        $activeEmergencyCount = $publicData['activeEmergencyCount'];
        $openTrainingCount = $publicData['openTrainingCount'];
        $activeProductCount = $publicData['activeProductCount'];
        $adminMetrics = $publicData['adminMetrics'];

        $peternakMetrics = [
            'myLivestockCount' => $user ? Livestock::where('user_id', $user->id)->count() : 0,
            'myProductsCount' => $user ? Product::where('user_id', $user->id)->count() : 0,
            'myUnverifiedProductsCount' => $user ? Product::where('user_id', $user->id)->where('is_verified', false)->count() : 0,
            'myEmergencyReportsCount' => $user ? EmergencyReport::where('user_id', $user->id)->count() : 0,
            'myTrainingsCount' => $user ? TrainingRegistration::where('user_id', $user->id)->count() : 0,
            'myCertificatesCount' => $user ? Certificate::where('user_id', $user->id)->count() : 0,
            'myHealthReportsCount' => $user ? AnimalHealthReport::where('user_id', $user->id)->count() : 0,
            'myHealthReportsWaiting' => $user ? AnimalHealthReport::where('user_id', $user->id)->where('status', 'menunggu_respons')->count() : 0,
            'myHealthReportsInProgress' => $user ? AnimalHealthReport::where('user_id', $user->id)->whereIn('status', ['sedang_ditangani', 'menunggu_kunjungan', 'kunjungan_terjadwal', 'menunggu_tindak_lanjut'])->count() : 0,
            'myHealthReportsAnswered' => $user ? AnimalHealthReport::where('user_id', $user->id)->where('status', 'sudah_dijawab')->count() : 0,
            'myHealthReportsResolved' => $user ? AnimalHealthReport::where('user_id', $user->id)->where('status', 'selesai')->count() : 0,
        ];

        $umumMetrics = [
            'availableProductsCount' => $activeProductCount,
            'myOrdersCount' => $user ? Order::where('buyer_id', $user->id)->count() : 0,
            'exhibitionsCount' => $publicData['exhibitionsCount'],
            'commoditiesCount' => $commodityCount,
        ];

        $sentras = $publicData['sentras'];
        $latestPrices = $publicData['latestPrices'];
        $activeReports = $publicData['activeReports'];
        $upcomingEvents = $publicData['upcomingEvents'];
        $buyerFeaturedProducts = $publicData['buyerFeaturedProducts'];

        $chartPopulasi = $jatimStats['populasi'];
        $chartProduksi = $jatimStats['produksi'];

        $buyerOrders = ($user && $user->isUmum())
            ? Order::where('buyer_id', $user->id)
                ->with(['items.product.category', 'items.seller'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $peternakHealthReports = ($user && $user->isPeternak())
            ? AnimalHealthReport::where('user_id', $user->id)
                ->with(['assignedVeterinarian', 'latestVisit'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $adminHealthReports = ($user && $user->isAdmin())
            ? AnimalHealthReport::with(['user', 'assignedVeterinarian', 'latestVisit'])
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
            'peternakHealthReports' => $peternakHealthReports,
            'adminHealthReports' => $adminHealthReports,
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

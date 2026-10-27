<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\ProductionCenter;
use App\Models\Region;
use App\Models\Training;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    /**
     * Display the official landing page of Peternak Milenial Jatim.
     */
    public function index(): View
    {
        $metrics = Cache::remember('landing_metrics_v1', 60, function () {
            return [
                'regionCount' => Region::count(),
                'commodityCount' => Commodity::count(),
                'centerCount' => ProductionCenter::count(),
                'activeTrainingsCount' => Training::where('status', 'open')->count(),
            ];
        });

        return view('landing', $metrics);
    }

    /**
     * Display the FAQ help-center page.
     */
    public function faq(): View
    {
        return view('faq');
    }
}

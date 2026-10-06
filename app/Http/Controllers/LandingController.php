<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\ProductionCenter;
use App\Models\Region;
use App\Models\Training;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    /**
     * Display the official landing page of Peternak Milenial Jatim.
     */
    public function index(): View
    {
        $regionCount = Region::count();
        if ($regionCount === 0) {
            $regionCount = 38;
        }

        $commodityCount = Commodity::count();
        if ($commodityCount === 0) {
            $commodityCount = 5;
        }

        $centerCount = ProductionCenter::count();
        if ($centerCount === 0) {
            $centerCount = 8;
        }

        $activeTrainingsCount = Training::where('status', 'open')->count();
        if ($activeTrainingsCount === 0) {
            $activeTrainingsCount = 3;
        }

        return view('landing', [
            'regionCount' => $regionCount,
            'commodityCount' => $commodityCount,
            'centerCount' => $centerCount,
            'activeTrainingsCount' => $activeTrainingsCount,
        ]);
    }
}

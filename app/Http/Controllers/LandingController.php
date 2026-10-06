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
        $commodityCount = Commodity::count();
        $centerCount = ProductionCenter::count();
        $activeTrainingsCount = Training::where('status', 'open')->count();

        return view('landing', [
            'regionCount' => $regionCount,
            'commodityCount' => $commodityCount,
            'centerCount' => $centerCount,
            'activeTrainingsCount' => $activeTrainingsCount,
        ]);
    }
}

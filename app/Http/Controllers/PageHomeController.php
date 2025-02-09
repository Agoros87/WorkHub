<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $workerAdvertisements = Advertisement::ofType('worker')->latest()->paginate(5);

        $employerAdvertisements = Advertisement::ofType('employer')->latest()->paginate(5);

        return view('welcome', compact('workerAdvertisements', 'employerAdvertisements'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Support\Str;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $workerAdvertisements = Advertisement::ofType('worker')->latest()->paginate(3);

        $employerAdvertisements = Advertisement::ofType('employer')->latest()->paginate(3);

        $workerAdvertisements->each(function ($advertisement) {
            $advertisement->description = Str::limit($advertisement->description, 100);
        });

        $employerAdvertisements->each(function ($advertisement) {
            $advertisement->description = Str::limit($advertisement->description, 100);
        });

        return view('welcome', compact('workerAdvertisements', 'employerAdvertisements'));
    }
}

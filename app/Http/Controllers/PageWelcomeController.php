<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Support\Str;

class PageWelcomeController extends Controller
{
    public function __invoke()
    {
        $workerAdvertisements = Advertisement::OfType('worker')->latest()->paginate(3);

        $employerAdvertisements = Advertisement::OfType('employer')->latest()->paginate(3);

        $workerAdvertisements->each(function ($advertisement) {
            $advertisement->description = Str::limit($advertisement->description, 100);
        });

        $employerAdvertisements->each(function ($advertisement) {
            $advertisement->description = Str::limit($advertisement->description, 100);
        });

        return view('welcome', compact('workerAdvertisements', 'employerAdvertisements'));
    }
}

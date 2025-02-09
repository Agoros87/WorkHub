<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalAds = $user->advertisements()->count();
        $dependsOfTypeText = $user->type == 'employer' ? 'Encuentra camareros' : 'Encuentra trabajo';

        return view('dashboard', compact('totalAds', 'dependsOfTypeText'));
    }
}

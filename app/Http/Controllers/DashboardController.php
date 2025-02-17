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

        // Obtener aplicaciones recibidas y enviadas
        $receivedApplications = $user->receivedApplications()->with(['user', 'messages'])->latest()->take(5)->get();
        $sentApplications = $user->jobApplications()->with(['advertisement.user', 'messages'])->latest()->take(5)->get();
        
        $totalReceivedApplications = $user->receivedApplications()->count();
        $totalSentApplications = $user->jobApplications()->count();
        $totalFavorites = $user->favoriteAdvertisements()->count();

        return view('dashboard', compact(
            'totalAds',
            'dependsOfTypeText',
            'receivedApplications',
            'sentApplications',
            'totalReceivedApplications',
            'totalSentApplications',
            'totalFavorites'
        ));
    }
}

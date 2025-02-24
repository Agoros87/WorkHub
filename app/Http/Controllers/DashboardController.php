<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.admin-dashboard');
        }

        return view('dashboard', [
            'totalAds' => $this->getTotalAds($user),
            'dependsOfTypeText' => $this->getTypeText($user),
            'receivedApplications' => $this->getReceivedApplications($user),
            'sentApplications' => $this->getSentApplications($user),
            'totalReceivedApplications' => $this->getTotalReceivedApplications($user),
            'totalSentApplications' => $this->getTotalSentApplications($user),
            'totalFavorites' => $this->getTotalFavorites($user),
        ]);
    }

    private function getTotalAds($user)
    {
        return $user->advertisements()->count();
    }

    private function getTypeText($user)
    {
        return $user->type == 'employer' ? 'Encuentra camareros' : 'Encuentra trabajo';
    }

    private function getReceivedApplications($user)
    {
        return $user->receivedApplications()->with(['user', 'messages'])->latest()->take(5)->get();
    }

    private function getSentApplications($user)
    {
        return $user->jobApplications()->with(['advertisement.user', 'messages'])->latest()->take(5)->get();
    }

    private function getTotalReceivedApplications($user)
    {
        return $user->receivedApplications()->count();
    }

    private function getTotalSentApplications($user)
    {
        return $user->jobApplications()->count();
    }

    private function getTotalFavorites($user)
    {
        return $user->favoriteAdvertisements()->count();
    }
}

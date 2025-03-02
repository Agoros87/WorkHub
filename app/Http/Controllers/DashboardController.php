<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.admin-dashboard');
        }

        return view('dashboard', [//cada clave del array se convierte en una variable en la vista
            'totalAds' => $this->getTotalAds($user), //total de anuncios
            'dependsOfTypeText' => $this->getTypeText($user), //dependiendo del tipo de usuario muestro un texto u otro
            'receivedApplications' => $this->getReceivedApplications($user), //aplicaciones recibidas
            'sentApplications' => $this->getSentApplications($user), //aplicaciones enviadas
            'totalReceivedApplications' => $this->getTotalReceivedApplications($user), //numero total de aplicaciones recibidas
            'totalSentApplications' => $this->getTotalSentApplications($user), //numero total de aplicaciones enviadas
            'totalFavorites' => $this->getTotalFavorites($user), //numero total de favoritos
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
    { //carga anticipada de las 5 ultimas aplicaciones recibidas con los usuarios y mensajes relacionados
        return $user->receivedApplications()->with(['user', 'messages'])->latest()->take(5)->get();
    }

    private function getSentApplications($user)
    {//carga anticipada de las 5 ultimas aplicaciones enviadas con los anuncios y usuario que lo publico y mensajes relacionados
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

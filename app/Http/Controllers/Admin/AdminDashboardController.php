<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::latest()->paginate(10); //carga anticipada de anuncios con sus usuarios
        $advertisements = Advertisement::with('user')->latest()->paginate(10);
//muestro la vista con los usuarios y anuncios
        return view('admin-dashboard', compact('users', 'advertisements'));
    }

    public function deleteUser(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente');
    }

    public function deleteAdvertisement(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return back()->with('success', 'Anuncio eliminado correctamente');
    }
}

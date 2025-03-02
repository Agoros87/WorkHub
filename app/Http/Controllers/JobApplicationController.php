<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\JobApplication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobApplicationController extends Controller
{
    use AuthorizesRequests;

    public function store(Advertisement $advertisement)
    { //Almacena la aplicacion del aplicante en el modelo JobApplication y lo manda al chat
        $hasApplied = $advertisement->applications()->where('user_id', auth()->id())->exists();
        $this->authorize('apply', [$advertisement, $hasApplied]);

        $jobApplication = JobApplication::create([
            'user_id' => auth()->id(),
            'advertisement_id' => $advertisement->id,
        ]);

        return to_route('job-applications.show', $jobApplication);
    }

    public function show(JobApplication $jobApplication)
    { //Muestra la aplicacion del aplicante el chat
        $this->authorize('view', $jobApplication);

        return view('job-applications.show', compact('jobApplication'));
    }

    public function destroy(JobApplication $jobApplication)
    {//Elimina la aplicacion del aplicante del dashboard
        $this->authorize('delete', $jobApplication);

        $jobApplication->delete();

        return to_route('dashboard')->with('success', 'Aplicación eliminada correctamente');
    }
}

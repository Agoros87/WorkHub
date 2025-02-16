<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobApplicationController extends Controller
{
    use AuthorizesRequests;

    public function store(Advertisement $advertisement)
    {
        $hasApplied = $advertisement->applications()->where('user_id', auth()->id())->exists();
        $this->authorize('apply', [$advertisement, $hasApplied]);

        $jobApplication = JobApplication::create([
            'user_id' => auth()->id(),
            'advertisement_id' => $advertisement->id,
        ]);

        return redirect()->route('job-applications.show', $jobApplication);
    }

    public function show(JobApplication $jobApplication)
    {
        $this->authorize('view', $jobApplication);

        return view('job-applications.show', compact('jobApplication'));
    }

    public function destroy(JobApplication $jobApplication)
    {
        $this->authorize('delete', $jobApplication);

        $jobApplication->delete();

        return redirect()->route('dashboard')->with('success', 'Aplicación eliminada correctamente');
    }
}

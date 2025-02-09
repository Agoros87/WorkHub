<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\AdvertisementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdvertisementController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $advertisements = Advertisement::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('advertisements.create');
    }

    public function store(AdvertisementRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['skills']) && is_string($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title'] . '-' . \Illuminate\Support\Str::random(6));

        $advertisement = new Advertisement($validated);
        $advertisement->user_id = Auth::id();
        $advertisement->save();

        return redirect()
            ->route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio creado correctamente');
    }

    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', compact('advertisement'));
    }

    public function edit(Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        if (is_array($advertisement->skills)) {
            $advertisement->skills = implode(',', $advertisement->skills);
        }

        return view('advertisements.edit', compact('advertisement'));
    }

    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        $validated = $request->validated();

        if (isset($validated['skills']) && is_string($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        $advertisement->update($validated);

        return redirect()
            ->route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio actualizado correctamente');
    }

    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return redirect()
            ->route('welcome')
            ->with('success', 'Anuncio eliminado correctamente');
    }
}

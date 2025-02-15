<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\AdvertisementRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{

    public function index()
    {
        $advertisements = Advertisement::where('user_id', Auth::id())
            ->latest()
            ->paginate(3);

        return view('advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('advertisements.create');
    }

    public function store(AdvertisementRequest $request)
    {
        $validated = $request->validated();
        $validated['type'] = auth()->user()->type;
        $validated['slug'] = Str::slug($validated['title'] . '-' . Str::random(6));

        $advertisement = new Advertisement($validated);
        $advertisement->user_id = Auth::id();
        $advertisement->save();

        return to_route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio creado correctamente');
    }

    public function show(Advertisement $advertisement)
    {
        $hasApplied = auth()->check() ?
            $advertisement->applications()->where('user_id', auth()->id())->exists() :
            false;

        return view('advertisements.show', compact('advertisement', 'hasApplied'));
    }

    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit', compact('advertisement'));
    }

    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $validated = $request->validated();

        // Si es admin dejo el type del anuncio o del usuario
        $validated['type'] = auth()->user()->hasRole('admin')
            ? $advertisement->type
            : auth()->user()->type;

        if ($validated['title'] !== $advertisement->title) {
            $validated['slug'] = Str::slug($validated['title'] . '-' . Str::random(6));
        }

        $advertisement->update($validated);

        return to_route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio actualizado correctamente');
    }

    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);
        $advertisement->delete();

        return to_route('welcome')
            ->with('success', 'Anuncio eliminado correctamente');
    }
}

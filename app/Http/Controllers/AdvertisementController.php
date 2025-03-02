<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $advertisement = auth()->user()->advertisements()->make($request->validated());
        $advertisement['type'] = auth()->user()->type;
        $advertisement['slug'] = Str::slug($advertisement['title'].'-'.Str::random(6));

        $advertisement->save();

        return to_route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio creado correctamente');
    }

    public function show(Advertisement $advertisement)
    {
        $hasApplied = false;

        if (auth()->check()) {
            $hasApplied = $advertisement->applications()->where('user_id', auth()->id())->exists();
        }

        return view('advertisements.show', compact('advertisement', 'hasApplied'));
    }

    public function edit(Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        return view('advertisements.edit', compact('advertisement'));
    }

    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $validated = $request->validated();

        // Si es admin dejo el type del anuncio o del usuario (puedo ahorrarmelo xk el admin no tiene type
        $validated['type'] = auth()->user()->hasRole('admin')
            ? $advertisement->type
            : auth()->user()->type;
        // Si el título cambia, actualizo el slug
        if ($validated['title'] !== $advertisement->title) {
            $validated['slug'] = Str::slug($validated['title'].'-'.Str::random(6));
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

    public function downloadPdf(Advertisement $advertisement)
    {
        $pdf = PDF::loadView('advertisements.pdf', compact('advertisement'));

        return $pdf->download($advertisement->slug.'.pdf');
    }
}

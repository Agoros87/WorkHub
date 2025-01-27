<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\AdvertisementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::with('user')
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
        $advertisement = new Advertisement($request->validated());
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

        return view('advertisements.edit', compact('advertisement'));
    }


    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        $advertisement->update($request->validated());

        return redirect()
            ->route('advertisements.show', $advertisement)
            ->with('success', 'Anuncio actualizado correctamente');
    }


    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return redirect()
            ->route('advertisements.index')
            ->with('success', 'Anuncio eliminado correctamente');
    }
}

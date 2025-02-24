<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFavoriteRequest;
use App\Models\Advertisement;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favoriteAdvertisements()->paginate(6);

        return view('favorites.index', compact('favorites'));
    }

    public function update(UpdateFavoriteRequest $request, $slug)
    {
        $advertisement = Advertisement::where('slug', $slug)->firstOrFail();
        auth()->user()->favoriteAdvertisements()
            ->updateExistingPivot($advertisement->id, $request->validated());

        return back()->with('success', 'Favorito actualizado');
    }

    public function destroy($slug)
    {
        $advertisement = Advertisement::where('slug', $slug)->firstOrFail();
        auth()->user()->favoriteAdvertisements()->detach($advertisement->id);

        return back()->with('success', 'Anuncio eliminado de favoritos con éxito');
    }
}

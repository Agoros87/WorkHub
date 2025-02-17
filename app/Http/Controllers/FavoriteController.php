<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\UpdateFavoriteRequest;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favoriteAdvertisements()->paginate(6);

        return view('favorites.index', compact('favorites'));
    }

    public function update(UpdateFavoriteRequest $request, $slug)
    {
        $data = $request->validated();

        $advertisement = Advertisement::where('slug', $slug)->firstOrFail();
        auth()->user()->favoriteAdvertisements()
            ->updateExistingPivot($advertisement->id, $data);

        return back()->with('success', 'Favorito actualizado');
    }

    public function destroy($slug)
    {
        $advertisement = Advertisement::where('slug', $slug)->firstOrFail();
        auth()->user()->favoriteAdvertisements()->detach($advertisement->id);
        return back()->with('success', 'Anuncio eliminado de favoritos con éxito');
    }
}

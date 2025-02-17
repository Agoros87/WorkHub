<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Http\Resources\AdvertisementResource;
use App\Http\Requests\Api\AdvertisementRequest;
use App\Http\Requests\AdvertisementRequest as WebAdvertisementRequest;
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {

        $advertisements = Advertisement::query()
            ->OfType($request->query('type'))
            ->inLocation($request->query('location'))
            ->withSkills($request->query('skills', []))
            ->searchKeyword($request->query('keyword'))
            ->latest()
            ->paginate(10);

        return AdvertisementResource::collection($advertisements);
    }

    public function store(AdvertisementRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $data['user_id'] = $user->id;
        $data['type'] = $user->type;
        $data['slug'] = Str::slug($data['title'] . '-' . Str::random(6));

        $advertisement = Advertisement::create($data);

        return new AdvertisementResource($advertisement);
    }

    public function show(Advertisement $advertisement)
    {
        return new AdvertisementResource($advertisement);
    }

    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        $advertisement->update($data);

        return new AdvertisementResource($advertisement);
    }

    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return response()->json(['message' => 'Anuncio eliminado correctamente']);
    }
}

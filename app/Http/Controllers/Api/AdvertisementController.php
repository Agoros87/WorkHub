<?php

namespace App\Http\Controllers\Api;

/**
 * @group Advertisement Management
 *
 * APIs para gestionar anuncios de trabajo
 */
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdvertisementRequest;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{
    /**
     * Listar Anuncios
     *
     * Obtiene una lista paginada de anuncios que puede ser filtrada por varios criterios.
     *
     * @queryParam type string Filtrar por tipo de anuncio (employer/worker). Example: worker
     * @queryParam location string Filtrar por ubicación. Example: Madrid
     * @queryParam skills array Filtrar por habilidades requeridas. Example: ["Camarero de barra","Camarero de sala"]
     * @queryParam keyword string Buscar por palabra clave en título o descripción. Example: Barista
     *
     * @response scenario="success" status=200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "type": "employer",
     *             "title": "Se busca camarero de barra",
     *             "description": "Buscamos camarero de barra con experiencia en coctelería",
     *             "slug": "se-busca-camarero-de-barra",
     *             "skills": ["Camarero de barra", "Camarero de sala"],
     *             "experience": "3-5 años",
     *             "schedule": "Tiempo completo",
     *             "contract_type": "Indefinido",
     *             "salary": 35000,
     *             "availability": "Inmediata",
     *             "salary_expectation": null,
     *             "location": "Madrid",
     *             "user_id": 1,
     *             "user": {
     *                 "id": 1,
     *                 "name": "Pepito S.L.",
     *                 "email": "rrhh@empresa.com"
     *             },
     *             "created_at": "2025-02-17T23:26:05.000000Z",
     *             "updated_at": "2025-02-17T23:26:05.000000Z"
     *         }
     *     ],
     *     "links": {
     *         "first": "http://workhub.test/api/advertisements?page=1",
     *         "last": "http://workhub.test/api/advertisements?page=1",
     *         "prev": null,
     *         "next": null
     *     },
     *     "meta": {
     *         "current_page": 1,
     *         "from": 1,
     *         "last_page": 1,
     *         "path": "http://workhub.test/api/advertisements",
     *         "per_page": 10,
     *         "to": 1,
     *         "total": 1
     *     }
     * }
     */
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

    /**
     * Crear Anuncio
     *
     * Crea un nuevo anuncio de trabajo.
     *
     * @authenticated
     *
     * @bodyParam title string required Título del anuncio. Example: Camarero de barra con experiencia en coctelería
     * @bodyParam description string required Descripción detallada del anuncio. Example: Buscamos camarero de barra con experiencia en coctelería
     * @bodyParam location string required Ubicación del trabajo. Example: Madrid
     * @bodyParam skills array required Lista de habilidades requeridas. Example: ["Camarero de barra","Camarero de sala"]
     * @bodyParam experience string required Experiencia requerida. Example: 3-5 años
     * @bodyParam schedule string Horario de trabajo. Example: Tiempo completo
     * @bodyParam contract_type string Tipo de contrato. Example: Indefinido
     * @bodyParam availability string Disponibilidad. Example: Inmediata
     * @bodyParam salary numeric Salario ofrecido (para empresas). Example: 35000
     * @bodyParam salary_expectation numeric Expectativa salarial (para candidatos). Example: 40000
     *
     * @response scenario="success" status=201 {
     *     "data": {
     *         "id": 1,
     *         "type": "employer",
     *         "title": "Se busca camarero de barra con experiencia en coctelería",
     *         "description": "Buscamos camarero de barra con experiencia en coctelería. Se valorará experiencia en coctelería",
     *         "slug": "se-busca-camarero-de-barra-con-experiencia-en-cocteleria",
     *         "skills": ["Camarero de barra", "Camarero de sala"],
     *         "experience": "3-5 años",
     *         "schedule": "Tiempo completo",
     *         "contract_type": "Indefinido",
     *         "salary": 35000,
     *         "availability": "Inmediata",
     *         "salary_expectation": null,
     *         "location": "Madrid",
     *         "user_id": 1,
     *         "user": {
     *             "id": 1,
     *             "name": "Empresa Tech",
     *             "email": "rrhh@empresa.com"
     *         },
     *         "created_at": "2025-02-17T23:26:05.000000Z",
     *         "updated_at": "2025-02-17T23:26:05.000000Z"
     *     }
     * }
     * @response status=422 scenario="validation error" {
     *     "message": "Los datos proporcionados no son válidos.",
     *     "errors": {
     *         "title": ["El título es obligatorio"],
     *         "skills": ["Las habilidades son obligatorias"]
     *     }
     * }
     */
    public function store(AdvertisementRequest $request)
    {
        $advertisement = auth()->user()->advertisements()->make($request->validated());
        $advertisement['type'] = auth()->user()->type;
        $advertisement['slug'] = Str::slug($advertisement['title'].'-'.Str::random(6));

        $advertisement->save();

        return new AdvertisementResource($advertisement);
    }

    /**
     * Ver Anuncio
     *
     * Obtiene los detalles de un anuncio específico.
     *
     * @urlParam advertisement required El ID del anuncio. Example: 1
     *
     * @response scenario="success" status=200 {
     *     "data": {
     *         "id": 1,
     *         "type": "employer",
     *         "title": "Se busca camarero de sala",
     *         "description": "Buscamos camarero de sala con experiencia en servicio de mesas",
     *         "slug": "se-busca-camarero-de-sala",
     *         "skills": ["Camarero de sala", "Servicio de mesas"],
     *         "experience": "3-5 años",
     *         "schedule": "Tiempo completo",
     *         "contract_type": "Indefinido",
     *         "salary": 35000,
     *         "availability": "Inmediata",
     *         "salary_expectation": null,
     *         "location": "Madrid",
     *         "user_id": 1,
     *         "user": {
     *             "id": 1,
     *             "name": "Empresa Tech",
     *             "email": "rrhh@empresa.com"
     *         },
     *         "created_at": "2025-02-17T23:26:05.000000Z",
     *         "updated_at": "2025-02-17T23:26:05.000000Z"
     *     }
     * }
     * @response status=404 scenario="not found" {
     *     "message": "No se encontró el anuncio"
     * }
     */
    public function show(Advertisement $advertisement)
    {
        return new AdvertisementResource($advertisement);
    }

    /**
     * Actualizar Anuncio
     *
     * Actualiza un anuncio existente.
     *
     * @authenticated
     *
     * @urlParam advertisement required El ID del anuncio. Example: 1
     *
     * @bodyParam title string required Título del anuncio. Example: Camarero de barra con experiencia en coctelería
     * @bodyParam description string required Descripción detallada del anuncio. Example: Se ofrece camarero de barra con experiencia en coctelería
     * @bodyParam location string required Ubicación del trabajo. Example: Madrid
     * @bodyParam skills array required Lista de habilidades requeridas. Example: ["Camarero de barra","Camarero de sala"]
     * @bodyParam experience string required Experiencia requerida. Example: 5+ años
     * @bodyParam schedule string Horario de trabajo. Example: Tiempo completo
     * @bodyParam contract_type string Tipo de contrato. Example: Indefinido
     * @bodyParam availability string Disponibilidad. Example: Inmediata
     * @bodyParam salary numeric Salario ofrecido (para empresas). Example: 40000
     * @bodyParam salary_expectation numeric Expectativa salarial (para candidatos). Example: 45000
     *
     * @response scenario="success" status=200 {
     *     "data": {
     *         "id": 1,
     *         "type": "employer",
     *         "title": "Se busca camarero de barra",
     *         "description": "Se busca camarero de barra con experiencia en coctelería",
     *         "slug": "se-busca-camarero-de-barra",
     *         "skills": ["Camarero de barra", "Camarero de sala"],
     *         "experience": "5+ años",
     *         "schedule": "Tiempo completo",
     *         "contract_type": "Indefinido",
     *         "salary": 40000,
     *         "availability": "Inmediata",
     *         "salary_expectation": null,
     *         "location": "Madrid",
     *         "user_id": 1,
     *         "user": {
     *             "id": 1,
     *             "name": "Empresa Tech",
     *             "email": "rrhh@empresa.com"
     *         },
     *         "created_at": "2025-02-17T23:26:05.000000Z",
     *         "updated_at": "2025-02-17T23:26:05.000000Z"
     *     }
     * }
     * @response status=403 scenario="unauthorized" {
     *     "message": "No está autorizado para actualizar este anuncio"
     * }
     * @response status=404 scenario="not found" {
     *     "message": "No se encontró el anuncio"
     * }
     */
    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);

        $validated = $request->validated();

        // Si es admin dejo el type del anuncio o del usuario
        $validated['type'] = auth()->user()->hasRole('admin')
            ? $advertisement->type
            : auth()->user()->type;

        if ($validated['title'] !== $advertisement->title) {
            $validated['slug'] = Str::slug($validated['title'].'-'.Str::random(6));
        }

        $advertisement->update($validated);

        return new AdvertisementResource($advertisement);
    }

    /**
     * Eliminar Anuncio
     *
     * Elimina un anuncio existente.
     *
     * @authenticated
     *
     * @urlParam advertisement required El ID del anuncio. Example: 1
     *
     * @response scenario="success" status=200 {
     *     "message": "Anuncio eliminado correctamente"
     * }
     * @response status=403 scenario="unauthorized" {
     *     "message": "No está autorizado para eliminar este anuncio"
     * }
     * @response status=404 scenario="not found" {
     *     "message": "No se encontró el anuncio"
     * }
     */
    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return response()->json(['message' => 'Anuncio eliminado correctamente']);
    }
}

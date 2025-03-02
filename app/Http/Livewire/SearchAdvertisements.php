<?php

namespace App\Http\Livewire;

use App\Models\Advertisement;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAdvertisements extends Component
{
    use WithPagination;

    public $keyword = '';

    public $locations = [];

    public $location = '';

    public $selectedCategories = [];

    public $type;

    protected $queryString = [ // Para que los parametros de la URL sean persistentes y visibles
        'keyword' => ['except' => ''],
        'location' => ['except' => ''],
        'selectedCategories' => ['except' => []], //COn except si esta vacio no se muestra en la URL
    ];

    public function mount() // Guardo el type del usuario autenticado y cargo las ubicaciones
    {
        if (auth()->check()) {
            $this->type = auth()->user()->type;
        }
        $this->locations = config('locations');
    }

    public function render() // hago la consulta a la base de datos con los filtros seleccionados
    {
        $query = Advertisement::query()
            ->returnOppositeType(auth()->check() ? $this->type : null) //busca anuncios del tipo contrario al del usuario autenticado
            ->inLocation($this->location)
            ->withSkills($this->selectedCategories)
            ->searchKeyword($this->keyword)
            ->latest();

        return view('livewire.search-advertisements', [
            'results' => $query->paginate(4), // Pagino los resultados de la consulta a la base de datos con 4 anuncios por página
            'total' => $query->count(), // Cuento el total de anuncios
        ])->layout('layouts.app'); // Indico que use el layout app.blade.php para renderizar la vista de livewire
    }
}

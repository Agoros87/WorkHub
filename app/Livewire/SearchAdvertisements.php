<?php

namespace App\Livewire;

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
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [ // Para que los parametros de la URL sean persistentes y visibles
        'keyword' => ['except' => ''],
        'location' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount() //Guardo el type del usuario autenticado y cargo las ubicaciones
    {
        if (auth()->check()) {
            $this->type = auth()->user()->type;
        }
        $this->locations = config('locations');
    }

    public function updated($property) //Para que la paginación se reinicie al cambiar los filtros
    {
        $this->resetPage();
    }

    public function render() //hago la consulta a la base de datos con los filtros seleccionados
    {
        $query = Advertisement::query()
            ->returnOppositeType(auth()->check() ? $this->type : null)
            ->inLocation($this->location)
            ->withSkills($this->selectedCategories)
            ->searchKeyword($this->keyword);

        $total = $query->count();
        $results = $query->orderBy($this->sortField, $this->sortDirection)->paginate(4);

        return view('livewire.search-advertisements', [
            'results' => $results,
            'total' => $total
        ]);
    }
}

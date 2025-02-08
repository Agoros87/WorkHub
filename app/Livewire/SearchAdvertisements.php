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

    protected $queryString = [
        'keyword' => ['except' => ''],
        'location' => ['except' => ''],
        'selectedCategories' => ['except' => []],
    ];

    protected $listeners = ['search' => 'performSearch'];

    public function mount()
    {
        // Solo asignar el tipo si el usuario está logueado
        if (auth()->check()) {
            $this->type = auth()->user()->role === 'employer' ? 'worker' : 'employer';
        }
        $this->locations = config('locations');
    }

    public function updated($property)
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Advertisement::query()
            ->ofType(auth()->check() ? $this->type : null)
            ->inLocation($this->location)
            ->withSkills($this->selectedCategories)
            ->searchKeyword($this->keyword);

        $total = $query->count();
        $perPage = 4;
        $results = $query->latest()->paginate($perPage);

        return view('livewire.search-advertisements', [
            'results' => $results,
            'total' => $total
        ]);
    }

}

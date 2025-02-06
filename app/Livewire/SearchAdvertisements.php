<?php

namespace App\Livewire;

use App\Models\Advertisement;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAdvertisements extends Component
{
    use WithPagination;

    public $keyword = '';
    public $location = '';
    public $selectedCategories = [];
    public $locations = [
        'Ávila', 'Alicante', 'Albacete', 'Almería', 'Barcelona',
        'Badajoz', 'Bilbao', 'Burgos', 'Cádiz', 'Castellón de la Plana',
        'Ceuta', 'Córdoba', 'Cuenca', 'Granada', 'Gijón',
        'Guadalajara', 'Huesca', 'Huelva', 'Jaén', 'Lleida',
        'Lugo', 'Las Palmas de Gran Canaria', 'Lorca', 'Logroño', 'Madrid',
        'Málaga', 'Melilla', 'Mérida', 'Murcia', 'Palma de Mallorca',
        'Pontevedra', 'Palencia', 'Ronda', 'Salamanca', 'San Sebastián',
        'Segovia', 'Santiago de Compostela', 'Sevilla', 'Soria', 'Tarragona',
        'Teruel', 'Toledo', 'Valladolid', 'Valencia', 'Vigo',
        'Zaragoza'
    ];
    public $type;

    protected $queryString = [
        'keyword' => ['except' => ''],
        'location' => ['except' => ''],
        'selectedCategories' => ['except' => []],
    ];

    public function mount()
    {
        $this->type = auth()->check() && auth()->user()->role === 'employer' ? 'worker' : 'job';
    }

    public function updating($property)
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Advertisement::query()->ofType($this->type);

        if ($this->keyword) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->keyword}%")
                  ->orWhere('description', 'like', "%{$this->keyword}%");
            });
        }

        if ($this->location) {
            $query->inLocation($this->location);
        }

        if (!empty($this->selectedCategories)) {
            $query->where(function ($q) {
                foreach ($this->selectedCategories as $category) {
                    $q->orWhereJsonContains('skills', $category);
                }
            });
        }

        return view('livewire.search-advertisements', [
            'results' => $query->latest()->paginate(10),
        ]);
    }
}

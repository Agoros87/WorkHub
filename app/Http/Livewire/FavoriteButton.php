<?php

namespace App\Http\Livewire;

use App\Models\Advertisement;
use Livewire\Component;

class FavoriteButton extends Component
{
    public Advertisement $advertisement;

    public $isFavorite = false;

    public function mount(Advertisement $advertisement)
    {
        $this->advertisement = $advertisement;
        if (auth()->check()) {
            $this->isFavorite = auth()->user()->favoriteAdvertisements()
                ->where('advertisement_id', $advertisement->id)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        if ($this->isFavorite) {
            auth()->user()->favoriteAdvertisements()->detach($this->advertisement->id);
        } else {
            auth()->user()->favoriteAdvertisements()->attach($this->advertisement->id, [
                'notes' => null,
                'priority' => 'medium',
            ]);
        }

        $this->isFavorite = ! $this->isFavorite;
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}

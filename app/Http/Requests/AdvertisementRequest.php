<?php

namespace App\Http\Requests;

use App\Models\Advertisement;
use App\Rules\ValidAdvertisement;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Si hay un advertisement en la ruta
        if ($advertisement = $this->route('advertisement')) {
            // Si el método es DELETE, verificar permiso de eliminación
            if ($this->method() === 'DELETE') {
                return auth()->user()->can('delete', $advertisement);
            }
            // Si no, es una actualización
            return auth()->user()->can('update', $advertisement);
        }
        
        // Si no hay advertisement, es una creación
        return auth()->user()->can('create', Advertisement::class);
    }
    public function rules(): array
    {

        return [
            'title' => [new ValidAdvertisement(),'required','string','max:255'],
            'description' => [new ValidAdvertisement(),'required','string'],
            'location' => [new ValidAdvertisement(),'required','string','max:255'],
            'skills' => [new ValidAdvertisement(),'required','array'],
            'skills.*' => [new ValidAdvertisement(),'string','max:255'],
            'experience' => [new ValidAdvertisement(),'required','string','max:255'],
            'schedule' => [new ValidAdvertisement(),'string', 'max:255'],
            'contract_type' => [new ValidAdvertisement(),'string', 'max:255'],
            'availability' => [new ValidAdvertisement(),'string', 'max:255'],
            'salary' => [new ValidAdvertisement(),'numeric', 'min:0'],
            'salary_expectation' => [new ValidAdvertisement(),'numeric', 'min:0'],
        ];
    }

}

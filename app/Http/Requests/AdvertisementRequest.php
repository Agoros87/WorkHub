<?php

namespace App\Http\Requests;

use App\Rules\ValidAdvertisement;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
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

    public function authorize(): bool
    {
        return true;
    }
}

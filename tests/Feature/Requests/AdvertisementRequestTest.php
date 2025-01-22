<?php

use App\Http\Requests\AdvertisementRequest;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->request = new AdvertisementRequest();
});

it('validates required fields for employer advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'employer',
        'title' => 'Buscamos camarero',
        'description' => 'Se busca camarero con experiencia',
        'location' => 'Madrid',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido'
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates required fields for worker advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'worker',
        'title' => 'Camarero disponible',
        'description' => 'Camarero con experiencia',
        'location' => 'Barcelona',
        'availability' => 'Inmediata'
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates optional fields for employer advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'employer',
        'title' => 'Buscamos camarero',
        'description' => 'Se busca camarero con experiencia',
        'location' => 'Madrid',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'skills' => ['inglés', 'coctelería'],
        'experience' => '2 años',
        'salary' => 2000.00
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates optional fields for worker advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'worker',
        'title' => 'Camarero disponible',
        'description' => 'Camarero con experiencia',
        'location' => 'Barcelona',
        'availability' => 'Inmediata',
        'skills' => ['inglés', 'coctelería'],
        'experience' => '5 años',
        'salary_expectation' => 2500.00
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('fails validation when required fields are missing for employer', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'employer',
        'title' => 'Buscamos camarero'

    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('description')
        ->and($validator->errors()->keys())->toContain('location')
        ->and($validator->errors()->keys())->toContain('schedule')
        ->and($validator->errors()->keys())->toContain('contract_type');
});

it('fails validation when required fields are missing for worker', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'worker',
        'title' => 'Camarero disponible'

    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('description')
        ->and($validator->errors()->keys())->toContain('location')
        ->and($validator->errors()->keys())->toContain('availability');
});

it('validates salary is numeric and positive for employer', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'employer',
        'title' => 'Buscamos camarero',
        'description' => 'Se busca camarero con experiencia',
        'location' => 'Madrid',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => -100
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary');
});

it('validates salary expectation is numeric and positive for worker', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = [
        'type' => 'worker',
        'title' => 'Camarero disponible',
        'description' => 'Camarero con experiencia',
        'location' => 'Barcelona',
        'availability' => 'Inmediata',
        'salary_expectation' => -100
    ];

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary_expectation');
});

it('fails validation if type is invalid', function () {
    $rules = $this->request->rules();
    $data = [
        'type' => 'invalid-type',
        'title' => 'Camarero disponible',
        'description' => 'Con experiencia',
        'location' => 'Madrid'
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('type');
});


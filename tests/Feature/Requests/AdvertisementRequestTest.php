<?php

use App\Http\Requests\AdvertisementRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertisement;

beforeEach(function () {
    $this->request = new AdvertisementRequest();
});

it('validates required fields for employer advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->employer()
        ->make()
        ->only(['type', 'title', 'description', 'location', 'schedule', 'contract_type']);

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates required fields for worker advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->worker()
        ->make()
        ->only(['type', 'title', 'description', 'location', 'availability']);

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates optional fields for employer advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->employer()
        ->make()
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates optional fields for worker advertisement', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->worker()
        ->make()
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('fails validation when required fields are missing for employer', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->employer()
        ->make()
        ->only(['type', 'title']);

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
    $data = Advertisement::factory()
        ->worker()
        ->make()
        ->only(['type', 'title']);

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
    $data = Advertisement::factory()
        ->employer()
        ->make(['salary' => -100])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary');
});

it('validates salary expectation is numeric and positive for worker', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->worker()
        ->make(['salary_expectation' => -100])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary_expectation');
});

it('validates max length for string fields', function () {
    //Arrange
    $rules = $this->request->rules();
    $tooLongString = str_repeat('a', 256);

    $data = Advertisement::factory()
        ->employer()
        ->make([
            'title' => $tooLongString,
            'location' => $tooLongString,
            'skills' => [$tooLongString],
            'experience' => $tooLongString,
            'schedule' => $tooLongString,
            'contract_type' => $tooLongString
        ])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('title')
        ->and($validator->errors()->keys())->toContain('location')
        ->and($validator->errors()->keys())->toContain('skills.0')
        ->and($validator->errors()->keys())->toContain('experience')
        ->and($validator->errors()->keys())->toContain('schedule')
        ->and($validator->errors()->keys())->toContain('contract_type');
});

it('validates max length for worker specific fields', function () {
    //Arrange
    $rules = $this->request->rules();
    $tooLongString = str_repeat('a', 256);

    $data = Advertisement::factory()
        ->worker()
        ->make(['availability' => $tooLongString])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('availability');
});

it('validates salary is prohibited for worker type', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->worker()
        ->make(['salary' => 2000.00])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary');
});

it('validates salary_expectation is prohibited for employer type', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->employer()
        ->make(['salary_expectation' => 2000.00])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary_expectation');
});

it('fails validation if type is invalid', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->make(['type' => 'invalid-type'])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('type');
});

it('fails validation if skills contains non-string values', function () {
    //Arrange
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->employer()
        ->make(['skills' => ['inglés', 123]])
        ->toArray();

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('skills.1');
});

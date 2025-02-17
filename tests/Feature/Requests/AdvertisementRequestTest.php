<?php

use App\Http\Requests\AdvertisementRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertisement;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->request = new AdvertisementRequest();
    
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'employer']);
    Role::create(['name' => 'worker']);
    
    $this->employer = User::factory()->create(['type' => 'employer']);
    $this->worker = User::factory()->create(['type' => 'worker']);
    $this->admin = User::factory()->create(['type' => 'admin']);
    
    $this->employer->assignRole('employer');
    $this->worker->assignRole('worker');
    $this->admin->assignRole('admin');
});

it('validates required fields', function () {
    //Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->make()
        ->only(['title', 'description', 'location', 'skills', 'experience']);

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('validates all fields for admin', function () {
    //Arrange
    auth()->login($this->admin);
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->make()
        ->only(['title', 'description', 'location', 'skills', 'experience']);

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeTrue();
});

it('fails validation when required fields are missing', function () {
    //Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = Advertisement::factory()
        ->make()
        ->only(['title']);

    //Act
    $validator = Validator::make($data, $rules);

    //Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('description')
        ->and($validator->errors()->keys())->toContain('location')
        ->and($validator->errors()->keys())->toContain('skills')
        ->and($validator->errors()->keys())->toContain('experience');
});

it('validates salary is numeric and positive', function () {
    //Arrange
    auth()->login($this->employer);
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

it('validates salary_expectation is numeric and positive', function () {
    //Arrange
    auth()->login($this->worker);
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
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $tooLongString = str_repeat('a', 256);

    $data = Advertisement::factory()
        ->make([
            'title' => $tooLongString,
            'location' => $tooLongString,
            'skills' => [$tooLongString],
            'experience' => $tooLongString,
            'schedule' => $tooLongString,
            'contract_type' => $tooLongString,
            'availability' => $tooLongString
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
        ->and($validator->errors()->keys())->toContain('contract_type')
        ->and($validator->errors()->keys())->toContain('availability');
});

it('fails validation if skills contains non-string values', function () {
    //Arrange
    auth()->login($this->employer);
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

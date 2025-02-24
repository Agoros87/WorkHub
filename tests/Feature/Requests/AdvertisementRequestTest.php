<?php

use App\Http\Requests\AdvertisementRequest;
use App\Models\User;
use Database\Factories\EmployerAdvertisementFactory;
use Database\Factories\WorkerAdvertisementFactory;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->request = new AdvertisementRequest;

    $adminRole = Role::create(['name' => 'admin']);
    $creatorRole = Role::create(['name' => 'creator']);

    $this->employer = User::factory()->create(['type' => 'employer']);
    $this->worker = User::factory()->create(['type' => 'worker']);
    $this->admin = User::factory()->create(['type' => 'admin']);

    $this->employer->assignRole('creator');
    $this->worker->assignRole('creator');
    $this->admin->assignRole('admin');
});

it('validates required fields', function () {
    // Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = EmployerAdvertisementFactory::new()
        ->make()
        ->only(['title', 'description', 'location', 'skills', 'experience']);

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeTrue();
});

it('validates all fields for admin', function () {
    // Arrange
    auth()->login($this->admin);
    $rules = $this->request->rules();
    $data = EmployerAdvertisementFactory::new()
        ->make()
        ->only(['title', 'description', 'location', 'skills', 'experience']);

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeTrue();
});

it('fails validation when required fields are missing', function () {
    // Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = EmployerAdvertisementFactory::new()
        ->make()
        ->only(['title']);

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('description')
        ->and($validator->errors()->keys())->toContain('location')
        ->and($validator->errors()->keys())->toContain('skills')
        ->and($validator->errors()->keys())->toContain('experience');
});

it('validates salary is numeric and positive', function () {
    // Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = EmployerAdvertisementFactory::new()
        ->make(['salary' => -100])
        ->toArray();

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary');
});

it('validates salary_expectation is numeric and positive', function () {
    // Arrange
    auth()->login($this->worker);
    $rules = $this->request->rules();
    $data = WorkerAdvertisementFactory::new()
        ->make(['salary_expectation' => -100])
        ->toArray();

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('salary_expectation');
});

it('validates max length for string fields', function () {
    // Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $tooLongString = str_repeat('a', 256);

    $data = EmployerAdvertisementFactory::new()
        ->make([
            'title' => $tooLongString,
            'location' => $tooLongString,
            'skills' => [$tooLongString],
            'experience' => $tooLongString,
            'schedule' => $tooLongString,
            'contract_type' => $tooLongString,
            'availability' => $tooLongString,
        ])
        ->toArray();

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
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
    // Arrange
    auth()->login($this->employer);
    $rules = $this->request->rules();
    $data = EmployerAdvertisementFactory::new()
        ->make(['skills' => ['inglés', 123]])
        ->toArray();

    // Act
    $validator = Validator::make($data, $rules);

    // Assert
    expect($validator->passes())->toBeFalse()
        ->and($validator->errors()->keys())->toContain('skills.1');
});

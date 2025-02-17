<?php

use App\Models\Advertisement;
use App\Models\User;
use App\Models\JobApplication;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'creator']);
    $this->user = User::factory()->create();
});

it('allows admin to create employer advertisement', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);

    // Act
    $ad = Advertisement::factory()
        ->employer()
        ->create([
            'user_id' => $this->user->id,
            'schedule' => 'Jornada completa',
            'contract_type' => 'Indefinido',
            'salary' => 1500.00
        ]);

    // Assert
    expect($ad)
        ->user_id->toBe($this->user->id)
        ->type->toBe('employer')
        ->title->not->toBeEmpty()
        ->description->not->toBeEmpty()
        ->location->not->toBeEmpty()
        ->slug->not->toBeEmpty()
        ->skills->toBeArray()
        ->experience->not->toBeEmpty()
        ->schedule->toBe('Jornada completa')
        ->contract_type->toBe('Indefinido')
        ->salary->toEqual(1500.00)
        ->created_at->not->toBeNull()
        ->updated_at->not->toBeNull();
});

it('allows creator to create worker advertisement', function () {
    // Arrange
    $this->user->assignRole('creator');
    $this->actingAs($this->user);

    // Act
    $ad = Advertisement::factory()
        ->worker()
        ->create([
            'user_id' => $this->user->id,
            'availability' => 'Inmediata',
            'salary_expectation' => 1500.00
        ]);

    // Assert
    expect($ad)
        ->user_id->toBe($this->user->id)
        ->type->toBe('worker')
        ->title->not->toBeEmpty()
        ->description->not->toBeEmpty()
        ->location->not->toBeEmpty()
        ->slug->not->toBeEmpty()
        ->skills->toBeArray()
        ->experience->not->toBeEmpty()
        ->availability->toBe('Inmediata')
        ->salary_expectation->toEqual(1500.00)
        ->created_at->not->toBeNull()
        ->updated_at->not->toBeNull();
});

it('prevents non-creator users from creating advertisements', function () {
    // Arrange
    $this->actingAs($this->user);
    $data = Advertisement::factory()->employer()->make([
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ])->toArray();

    // Act & Assert
    $this->post(route('advertisements.store'), $data)
        ->assertForbidden();
});

it('allows worker to apply to employer advertisement', function () {
    // Arrange
    $employer = User::factory()->create();
    $employer->assignRole('creator');
    $this->user->assignRole('creator');
    $this->user->type = 'worker';
    $this->user->save();

    $ad = Advertisement::factory()
        ->employer()
        ->create([
            'user_id' => $employer->id,
            'schedule' => 'Jornada completa',
            'contract_type' => 'Indefinido',
            'salary' => 1500.00
        ]);

    // Act & Assert
    expect($this->user->can('apply', [$ad, false]))->toBeTrue();
});

it('prevents employer from applying to employer advertisement', function () {
    // Arrange
    $employer = User::factory()->create();
    $employer->assignRole('creator');
    $this->user->assignRole('creator');
    $this->user->type = 'employer';
    $this->user->save();

    $ad = Advertisement::factory()
        ->employer()
        ->create([
            'user_id' => $employer->id,
            'schedule' => 'Jornada completa',
            'contract_type' => 'Indefinido',
            'salary' => 1500.00
        ]);

    // Act & Assert
    expect($this->user->can('apply', [$ad, false]))->toBeFalse();
});

it('allows employer to apply to worker advertisement', function () {
    // Arrange
    $worker = User::factory()->create();
    $worker->assignRole('creator');
    $this->user->assignRole('creator');
    $this->user->type = 'employer';
    $this->user->save();

    $ad = Advertisement::factory()
        ->worker()
        ->create([
            'user_id' => $worker->id,
            'availability' => 'Inmediata',
            'salary_expectation' => 1500.00
        ]);

    // Act & Assert
    expect($this->user->can('apply', [$ad, false]))->toBeTrue();
});

it('prevents worker from applying to worker advertisement', function () {
    // Arrange
    $worker = User::factory()->create();
    $worker->assignRole('creator');
    $this->user->assignRole('creator');
    $this->user->type = 'worker';
    $this->user->save();

    $ad = Advertisement::factory()
        ->worker()
        ->create([
            'user_id' => $worker->id,
            'availability' => 'Inmediata',
            'salary_expectation' => 1500.00
        ]);

    // Act & Assert
    expect($this->user->can('apply', [$ad, false]))->toBeFalse();
});

it('prevents non-creator from applying to advertisements', function () {
    // Arrange
    $employer = User::factory()->create();
    $employer->assignRole('creator');

    $ad = Advertisement::factory()
        ->employer()
        ->create([
            'user_id' => $employer->id,
            'schedule' => 'Jornada completa',
            'contract_type' => 'Indefinido',
            'salary' => 1500.00
        ]);

    // Act & Assert
    expect($this->user->can('apply', [$ad, false]))->toBeFalse();
});

it('filters advertisements by type', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
    
    Advertisement::factory()->employer()->create([
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ]);
    Advertisement::factory()->worker()->create([
        'availability' => 'Inmediata',
        'salary_expectation' => 1500.00
    ]);
    Advertisement::factory()->worker()->create([
        'availability' => 'En 15 días',
        'salary_expectation' => 1800.00
    ]);

    // Act
    $employerAds = Advertisement::ofType('employer')->count();
    $workerAds = Advertisement::ofType('worker')->count();

    // Assert
    expect($employerAds)->toBe(1)
        ->and($workerAds)->toBe(2);
});

it('finds advertisements by location', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
    
    Advertisement::factory()->employer()->create([
        'location' => 'Madrid Centro',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ]);
    Advertisement::factory()->employer()->create([
        'location' => 'Madrid Norte',
        'schedule' => 'Media jornada',
        'contract_type' => 'Temporal',
        'salary' => 1200.00
    ]);
    Advertisement::factory()->employer()->create([
        'location' => 'Barcelona',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1800.00
    ]);

    // Act
    $madridAds = Advertisement::inLocation('Madrid')->count();
    $barcelonaAds = Advertisement::inLocation('Barcelona')->count();

    // Assert
    expect($madridAds)->toBe(2)
        ->and($barcelonaAds)->toBe(1);
});

it('finds advertisements with specific skills', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
    
    Advertisement::factory()->employer()->create([
        'skills' => ['inglés', 'coctelería'],
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ]);
    Advertisement::factory()->employer()->create([
        'skills' => ['inglés'],
        'schedule' => 'Media jornada',
        'contract_type' => 'Temporal',
        'salary' => 1200.00
    ]);
    Advertisement::factory()->employer()->create([
        'skills' => ['coctelería', 'vinos'],
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1800.00
    ]);

    // Act
    $englishAds = Advertisement::withSkills(['inglés'])->count();
    $cocktailAds = Advertisement::withSkills(['coctelería'])->count();
    $bothSkills = Advertisement::withSkills(['inglés', 'coctelería'])->count();

    // Assert
    expect($englishAds)->toBe(2)
        ->and($cocktailAds)->toBe(2)
        ->and($bothSkills)->toBe(1);
});

it('orders advertisements by creation date', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
    
    $oldest = Advertisement::factory()->employer()->create([
        'created_at' => now()->subDays(2),
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ]);
    $newest = Advertisement::factory()->employer()->create([
        'created_at' => now(),
        'schedule' => 'Media jornada',
        'contract_type' => 'Temporal',
        'salary' => 1200.00
    ]);
    $middle = Advertisement::factory()->employer()->create([
        'created_at' => now()->subDay(),
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1800.00
    ]);

    // Act
    $ads = Advertisement::latest()->get();

    // Assert
    expect($ads->first()->id)->toBe($newest->id)
        ->and($ads->last()->id)->toBe($oldest->id);
});

it('belongs to a user', function () {
    // Arrange
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
    
    $ad = Advertisement::factory()->employer()->create([
        'user_id' => $this->user->id,
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ]);

    // Act
    $user = $ad->user;

    // Assert
    expect($user)
        ->toBeInstanceOf(User::class)
        ->id->toBe($this->user->id);
});

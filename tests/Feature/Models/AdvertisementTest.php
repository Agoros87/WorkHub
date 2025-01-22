<?php

use App\Models\Advertisement;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('creates an employer advertisement', function () {
    //Arrange
    $adData = [
        'user_id' => $this->user->id,
        'type' => 'employer',
        'title' => 'Buscamos camarero',
        'description' => 'Se busca camarero con experiencia',
        'location' => 'Madrid',
        'slug' => 'buscamos-camarero',
        'skills' => ['inglés', 'coctelería'],
        'experience' => '2 años',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 2000.00
    ];

    //Act
    $ad = Advertisement::factory()->create($adData);

    //Assert
    expect($ad)
        ->user_id->toBe($this->user->id)
        ->type->toBe('employer')
        ->title->toBe('Buscamos camarero')
        ->description->toBe('Se busca camarero con experiencia')
        ->location->toBe('Madrid')
        ->slug->toBe('buscamos-camarero')
        ->skills->toBe(['inglés', 'coctelería'])
        ->experience->toBe('2 años')
        ->schedule->toBe('Jornada completa')
        ->contract_type->toBe('Indefinido')
        ->salary->toEqual(2000.00)
        ->created_at->not->toBeNull()
        ->updated_at->not->toBeNull();
});

it('creates a worker advertisement', function () {
    //Arrange
    $adData = [
        'user_id' => $this->user->id,
        'type' => 'worker',
        'title' => 'Camarero disponible',
        'description' => 'Camarero con 5 años de experiencia',
        'location' => 'Barcelona',
        'slug' => 'camarero-disponible',
        'skills' => ['inglés', 'coctelería'],
        'experience' => '5 años',
        'availability' => 'Inmediata',
        'salary_expectation' => 2500.00
    ];

    //Act
    $ad = Advertisement::factory()->create($adData);

    //Assert
    expect($ad)
        ->user_id->toBe($this->user->id)
        ->type->toBe('worker')
        ->title->toBe('Camarero disponible')
        ->description->toBe('Camarero con 5 años de experiencia')
        ->location->toBe('Barcelona')
        ->slug->toBe('camarero-disponible')
        ->skills->toBe(['inglés', 'coctelería'])
        ->experience->toBe('5 años')
        ->availability->toBe('Inmediata')
        ->salary_expectation->toEqual(2500.00)
        ->created_at->not->toBeNull()
        ->updated_at->not->toBeNull();
});

it('filters advertisements by type', function () {
    //Arrange
    Advertisement::factory()->create(['type' => 'employer']);
    Advertisement::factory()->create(['type' => 'worker']);
    Advertisement::factory()->create(['type' => 'worker']);

    //Act
    $employerAds = Advertisement::ofType('employer')->count();
    $workerAds = Advertisement::ofType('worker')->count();

    //Assert
    expect($employerAds)->toBe(1)
        ->and($workerAds)->toBe(2);
});

it('finds advertisements by location', function () {
    //Arrange
    Advertisement::factory()->create(['location' => 'Madrid Centro']);
    Advertisement::factory()->create(['location' => 'Madrid Norte']);
    Advertisement::factory()->create(['location' => 'Barcelona']);

    //Act
    $madridAds = Advertisement::inLocation('Madrid')->count();
    $barcelonaAds = Advertisement::inLocation('Barcelona')->count();

    //Assert
    expect($madridAds)->toBe(2)
        ->and($barcelonaAds)->toBe(1);
});

it('finds advertisements with specific skills', function () {
    //Arrange
    Advertisement::factory()->create(['skills' => ['inglés', 'coctelería']]);
    Advertisement::factory()->create(['skills' => ['inglés']]);
    Advertisement::factory()->create(['skills' => ['coctelería', 'vinos']]);

    //Act
    $englishAds = Advertisement::withSkills(['inglés'])->count();
    $cocktailAds = Advertisement::withSkills(['coctelería'])->count();
    $bothSkills = Advertisement::withSkills(['inglés', 'coctelería'])->count();

    //Assert
    expect($englishAds)->toBe(2)
        ->and($cocktailAds)->toBe(2)
        ->and($bothSkills)->toBe(1);
});

it('orders advertisements by creation date', function () {
    //Arrange
    $oldest = Advertisement::factory()->create([
        'created_at' => now()->subDays(2)
    ]);
    $newest = Advertisement::factory()->create([
        'created_at' => now()
    ]);
    $middle = Advertisement::factory()->create([
        'created_at' => now()->subDay()
    ]);

    //Act
    $ads = Advertisement::latest()->get();

    //Assert
    expect($ads->first()->id)->toBe($newest->id)
        ->and($ads->last()->id)->toBe($oldest->id);
});

it('belongs to a user', function () {
    //Arrange
    $ad = Advertisement::factory()->create([
        'user_id' => $this->user->id
    ]);

    //Act
    $user = $ad->user;

    //Assert
    expect($user)
        ->toBeInstanceOf(User::class)
        ->id->toBe($this->user->id);
});

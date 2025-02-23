<?php

use Database\Factories\WorkerAdvertisementFactory;
use Database\Factories\EmployerAdvertisementFactory;
use Database\Seeders\RoleSeeder;
use function Pest\Laravel\get;

beforeEach(function() {
    $this->seed(RoleSeeder::class);
});

it('shows worker advertisements overview', function () {
    //Arrange
    $firstAds = WorkerAdvertisementFactory::new()->create();
    $secondAds = WorkerAdvertisementFactory::new()->create();
    $thirdAds = WorkerAdvertisementFactory::new()->create();

    //Act

    $response = get(route('welcome'));

    // Verificar los títulos
    $response->assertSeeText([
        $firstAds->title,
        $secondAds->title,
        $thirdAds->title,
    ]);

    // Verificar las descripciones limitadas
    $response->assertSeeText([
        \Illuminate\Support\Str::limit($firstAds->description, 100),
        \Illuminate\Support\Str::limit($secondAds->description, 100),
        \Illuminate\Support\Str::limit($thirdAds->description, 100),
    ]);
});

it('shows employer advertisements overview', function () {
    // Arrange
    $firstAds = EmployerAdvertisementFactory::new()->create();
    $secondAds = EmployerAdvertisementFactory::new()->create();
    $thirdAds = EmployerAdvertisementFactory::new()->create();

    // Act
    $response = get(route('welcome'));

    // Assert
    $response->assertSeeText([
        $firstAds->title,
        $secondAds->title,
        $thirdAds->title,
    ]);

    $response->assertSeeText([
        \Illuminate\Support\Str::limit($firstAds->description, 100),
        \Illuminate\Support\Str::limit($secondAds->description, 100),
        \Illuminate\Support\Str::limit($thirdAds->description, 100),
    ]);
});

it('paginates advertisements to show only 3 per type', function () {
    // Arrange
    WorkerAdvertisementFactory::new()->count(4)->create();
    EmployerAdvertisementFactory::new()->count(4)->create();

    // Act
    $response = get(route('welcome'));

    // Assert
    $response->assertViewHas('workerAdvertisements', function ($advertisements) {
        return $advertisements->count() === 3;
    });

    $response->assertViewHas('employerAdvertisements', function ($advertisements) {
        return $advertisements->count() === 3;
    });
});

it('shows advertisements in latest order', function () {
    // Arrange
    $oldAd = WorkerAdvertisementFactory::new()->create([
        'created_at' => now()->subDays(2)
    ]);

    $newAd = WorkerAdvertisementFactory::new()->create([
        'created_at' => now()
    ]);

    // Act
    $response = get(route('welcome'));

    // Assert
    $response->assertViewHas('workerAdvertisements', function ($advertisements) use ($newAd, $oldAd) {
        return $advertisements->first()->id === $newAd->id &&
               $advertisements->last()->id === $oldAd->id;
    });
});

it('returns welcome view', function () {
    // Act
    $response = get(route('welcome'));

    // Assert
    $response->assertViewIs('welcome');
});

it('handles empty advertisements gracefully', function () {
    // Act
    $response = get(route('welcome'));

    // Assert
    $response->assertViewHas('workerAdvertisements', function ($advertisements) {
        return $advertisements->isEmpty();
    });

    $response->assertViewHas('employerAdvertisements', function ($advertisements) {
        return $advertisements->isEmpty();
    });

    $response->assertOk();
});

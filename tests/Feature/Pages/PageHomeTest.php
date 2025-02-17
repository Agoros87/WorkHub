<?php

use App\Models\Advertisement;
use function Pest\Laravel\get;

it('shows worker advertisements overview', function () {
    //Arrange
    $firstAds = Advertisement::factory()->create(['type' => 'worker']);
    $secondAds = Advertisement::factory()->create(['type' => 'worker']);
    $thirdAds = Advertisement::factory()->create(['type' => 'worker']);

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
    $firstAds = Advertisement::factory()->create(['type' => 'employer']);
    $secondAds = Advertisement::factory()->create(['type' => 'employer']);
    $thirdAds = Advertisement::factory()->create(['type' => 'employer']);

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
    Advertisement::factory(4)->create(['type' => 'worker']);
    Advertisement::factory(4)->create(['type' => 'employer']);

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
    $oldAd = Advertisement::factory()->create([
        'type' => 'worker',
        'created_at' => now()->subDays(2)
    ]);
    
    $newAd = Advertisement::factory()->create([
        'type' => 'worker',
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

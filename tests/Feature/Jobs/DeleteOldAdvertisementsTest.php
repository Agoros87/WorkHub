<?php

use App\Jobs\DeleteOldAdvertisements;
use App\Models\Advertisement;
use Carbon\Carbon;
use Database\Factories\WorkerAdvertisementFactory;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    Log::spy();
});

it('deletes advertisements older than specified days', function () {
    // Arrange
    $oldAd = WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(40),
    ]);

    $recentAd = WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(20),
    ]);

    // Act
    (new DeleteOldAdvertisements(30))->handle();

    // Assert
    expect(Advertisement::find($oldAd->id))->toBeNull();
    expect(Advertisement::find($recentAd->id))->not->toBeNull();

    Log::shouldHaveReceived('info')
        ->with('Eliminando 1 anuncios antiguos de más de 30 días')
        ->once();

    Log::shouldHaveReceived('info')
        ->with('Proceso de eliminación de anuncios antiguos completado')
        ->once();
});

it('uses default value of 35 days when not specified', function () {
    // Arrange
    $ad36DaysOld = WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(36),
    ]);

    $ad34DaysOld = WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(34),
    ]);

    // Act
    (new DeleteOldAdvertisements)->handle();

    // Assert
    expect(Advertisement::find($ad36DaysOld->id))->toBeNull();
    expect(Advertisement::find($ad34DaysOld->id))->not->toBeNull();
});

it('handles empty result set gracefully', function () {
    // Arrange
    WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(20),
    ]);

    // Act
    (new DeleteOldAdvertisements(30))->handle();

    // Assert
    Log::shouldHaveReceived('info')
        ->with('Eliminando 0 anuncios antiguos de más de 30 días')
        ->once();

    Log::shouldHaveReceived('info')
        ->with('Proceso de eliminación de anuncios antiguos completado')
        ->once();
});

it('deletes multiple old advertisements', function () {
    // Arrange
    $oldAds = WorkerAdvertisementFactory::new()->count(3)->create([
        'updated_at' => Carbon::now()->subDays(40),
    ]);

    $recentAd = WorkerAdvertisementFactory::new()->create([
        'updated_at' => Carbon::now()->subDays(20),
    ]);

    // Act
    (new DeleteOldAdvertisements(30))->handle();

    // Assert
    foreach ($oldAds as $oldAd) {
        expect(Advertisement::find($oldAd->id))->toBeNull();
    }
    expect(Advertisement::find($recentAd->id))->not->toBeNull();

    Log::shouldHaveReceived('info')
        ->with('Eliminando 3 anuncios antiguos de más de 30 días')
        ->once();
});

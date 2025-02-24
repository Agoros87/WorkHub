<?php

use App\Jobs\DeleteOldAdvertisements;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    Queue::fake();
});

it('queues the job to delete old advertisements with default days', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old')
        ->expectsOutput('Job encolado: se eliminarán anuncios de más de 35 días')
        ->assertSuccessful();

    // Assert
    Queue::assertPushed(DeleteOldAdvertisements::class);
});

it('queues the job to delete old advertisements with specified days', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old', ['days' => '50'])
        ->expectsOutput('Job encolado: se eliminarán anuncios de más de 50 días')
        ->assertSuccessful();

    // Assert
    Queue::assertPushed(DeleteOldAdvertisements::class);
});

it('verifies job receives correct days parameter', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old', ['days' => '45']);

    // Assert
    Queue::assertPushed(DeleteOldAdvertisements::class, function ($job) {
        $reflection = new ReflectionClass($job);
        $property = $reflection->getProperty('daysOld');
        $property->setAccessible(true);

        return $property->getValue($job) === 45;
    });
});

it('verifies job receives default days when not specified', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old');

    // Assert
    Queue::assertPushed(DeleteOldAdvertisements::class, function ($job) {
        $reflection = new ReflectionClass($job);
        $property = $reflection->getProperty('daysOld');
        $property->setAccessible(true);

        return $property->getValue($job) === 35;
    });
});

it('fails with negative days value', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old', ['days' => '-10'])
        ->expectsOutput('El número de días debe ser un valor positivo mayor a 0 y menor que 7300')
        ->assertFailed();

    // Assert
    Queue::assertNotPushed(DeleteOldAdvertisements::class);
});

it('fails when days exceed maximum limit', function () {
    // Act
    $this->artisan('ads:enqueue-delete-old', ['days' => '7301'])
        ->expectsOutput('El número de días debe ser un valor positivo mayor a 0 y menor que 7300')
        ->assertFailed();

    // Assert
    Queue::assertNotPushed(DeleteOldAdvertisements::class);
});

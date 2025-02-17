<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Advertisement;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    if (!Role::where('name', 'creator')->exists()) {
        Role::create(['name' => 'creator']);
    }

    $this->creator = User::factory()->create(['type' => 'employer']);
    $this->creator->assignRole('creator');

    $this->admin = User::factory()->create(['type' => 'worker']);
});

it('lists advertisements without authentication', function () {
    // Arrange
    Advertisement::factory()->count(3)->create();

    // Act
    $response = $this->getJson('/api/advertisements');

    // Assert
    $response->assertOk()
        ->assertJsonCount(3, 'data');
});


it('creates a new advertisement with sanctum authentication', function () {
    // Arrange
    $data = [
        'title' => 'Test Advertisement',
        'description' => 'This is a test advertisement.',
        'location' => 'Madrid',
        'skills' => ['PHP', 'Laravel', 'Vue.js'],
        'experience' => '2-3 años',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ];

    // Act
    $token = $this->creator->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/advertisements', $data);

    // Assert
    $response->assertCreated()
        ->assertJsonStructure(['data' => ['id', 'title', 'description', 'user_id', 'type', 'slug']]);

    expect(Advertisement::where('title', 'Test Advertisement')->exists())->toBeTrue();
});

it('shows a specific advertisement without authentication', function () {
    // Arrange
    $advertisement = Advertisement::factory()->create();

    // Act
    $response = $this->getJson("/api/advertisements/{$advertisement->slug}");

    // Assert
    $response->assertOk()
        ->assertJsonFragment(['id' => $advertisement->id]);
});

it('updates an advertisement with sanctum authentication', function () {
    // Arrange
    $advertisement = Advertisement::factory()->create(['user_id' => $this->creator->id]);
    $data = [
        'title' => 'Updated Advertisement',
        'description' => 'This is an updated test advertisement.',
        'location' => 'Madrid',
        'skills' => ['PHP', 'Laravel', 'Vue.js'],
        'experience' => '2-3 años',
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00
    ];

    // Act
    $token = $this->creator->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson("/api/advertisements/{$advertisement->slug}", $data);

    // Assert
    $response->assertOk()
        ->assertJsonFragment(['title' => 'Updated Advertisement']);
});

it('prevents non-owner from updating advertisement with sanctum authentication', function () {
    // Arrange
    $advertisement = Advertisement::factory()->create(['user_id' => $this->creator->id]);
    $data = [
        'title' => 'Updated Advertisement',
        'description' => 'This is an updated test advertisement.',
        'location' => 'Madrid',
        'skills' => ['PHP', 'Laravel', 'Vue.js'],
        'experience' => '2-3 años',
        'availability' => 'Inmediata',
        'salary_expectation' => 2000.00
    ];

    // Act
    $token = $this->admin->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson("/api/advertisements/{$advertisement->slug}", $data);

    // Assert
    $response->assertForbidden();
});

it('deletes an advertisement with sanctum authentication', function () {
    // Arrange
    $advertisement = Advertisement::factory()->create(['user_id' => $this->creator->id]);

    // Act
    $token = $this->creator->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson("/api/advertisements/{$advertisement->slug}");

    // Assert
    $response->assertJson(['message' => 'Anuncio eliminado correctamente']);
    expect(Advertisement::find($advertisement->id))->toBeNull();
});

it('prevents non-owner from deleting advertisement with sanctum authentication', function () {
    // Arrange
    $advertisement = Advertisement::factory()->create(['user_id' => $this->creator->id]);

    // Act
    $token = $this->admin->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson("/api/advertisements/{$advertisement->slug}");

    // Assert
    $response->assertForbidden();
});

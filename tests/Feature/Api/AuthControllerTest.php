<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);
});

it('logs in successfully with valid credentials', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    // Act
    $response = $this->postJson('/api/login', $credentials);

    // Assert
    $response->assertOk()
        ->assertJsonStructure([
            'token',
            'user',
            'message',
        ])
        ->assertJson([
            'message' => 'Login exitoso',
        ]);
});

it('fails to login with incorrect credentials', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ];

    // Act
    $response = $this->postJson('/api/login', $credentials);

    // Assert
    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
});

it('fails to login with validation errors', function () {
    // Arrange
    $credentials = [
        'email' => 'not-an-email',
        'password' => '',
    ];

    // Act
    $response = $this->postJson('/api/login', $credentials);

    // Assert
    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'password',
            ],
        ]);
});

it('fails to login with non-existent user', function () {
    // Arrange
    $credentials = [
        'email' => 'nonexistent@example.com',
        'password' => 'password123',
    ];

    // Act
    $response = $this->postJson('/api/login', $credentials);

    // Assert
    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
});

it('logs out successfully', function () {
    // Arrange
    $token = $this->user->createToken('api-token')->plainTextToken;

    // Act
    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/logout');

    // Assert
    $response->assertOk()
        ->assertJson([
            'message' => 'Logout exitoso',
        ]);

    expect($this->user->tokens()->count())->toBe(0);
});

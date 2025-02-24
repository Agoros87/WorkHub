<?php

use Database\Seeders\RoleSeeder;
use Laravel\Jetstream\Jetstream;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('worker registration screen can be rendered', function () {
    $response = $this->get('/register/worker');
    $response->assertStatus(200);
});

test('employer registration screen can be rendered', function () {
    $response = $this->get('/register/employer');
    $response->assertStatus(200);
});

test('workers can register', function () {
    $this->get('/register/worker')->assertStatus(200);

    $response = $this->post('/register', [
        'type' => 'worker',
        'name' => 'Test Worker',
        'lastname' => 'Test Lastname',
        'email' => 'worker@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '123456789',
        'location' => 'Test Location',
        'date_of_birth' => now()->subYears(20)->format('Y-m-d'),
        'gender' => 'other',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticated();

    $user = \App\Models\User::where('email', 'worker@example.com')->first();
    $this->assertEquals('worker', $user->type);
    $this->assertTrue($user->hasRole('creator'));
});

test('employers can register', function () {
    $this->get('/register/employer')->assertStatus(200);

    $response = $this->post('/register', [
        'type' => 'employer',
        'company_name' => 'Test Company',
        'tax_id' => '123456789',
        'email' => 'employer@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '123456789',
        'location' => 'Test Location',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticated();

    $user = \App\Models\User::where('email', 'employer@example.com')->first();
    $this->assertEquals('employer', $user->type);
    $this->assertTrue($user->hasRole('creator'));
});

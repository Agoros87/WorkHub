<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'admin']);
});

it('creates an admin user', function () {
    $this->artisan('admin:create')
        ->expectsQuestion('Nombre del administrador', 'Test Admin')
        ->expectsQuestion('Email del administrador', 'admin@example.com')
        ->expectsQuestion('Contraseña', 'password')
        ->expectsQuestion('Confirmar contraseña', 'password')
        ->expectsOutput('Usuario administrador creado exitosamente')
        ->assertExitCode(0);

    expect(User::where('email', 'admin@example.com')->exists())->toBeTrue();

    $user = User::where('email', 'admin@example.com')->first();
    expect($user->hasRole('admin'))->toBeTrue();
});

it('fails when passwords do not match', function () {
    $this->artisan('admin:create')
        ->expectsQuestion('Nombre del administrador', 'Test Admin')
        ->expectsQuestion('Email del administrador', 'admin@example.com')
        ->expectsQuestion('Contraseña', 'password')
        ->expectsQuestion('Confirmar contraseña', 'different-password')
        ->expectsOutput('Las contraseñas deben de ser iguales')
        ->assertExitCode(1);
});


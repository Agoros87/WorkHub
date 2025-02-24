<?php

use App\Models\Advertisement;
use App\Models\User;
use Database\Factories\EmployerAdvertisementFactory;
use Database\Factories\WorkerAdvertisementFactory;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'creator']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');

    $this->employer = User::factory()->create([
        'type' => 'employer',
        'company_name' => 'Test Company',
    ]);
    $this->employer->assignRole('creator');

    $this->worker = User::factory()->create([
        'type' => 'worker',
        'name' => 'Test Worker',
    ]);
    $this->worker->assignRole('creator');
});

it('requires authentication for admin dashboard', function () {
    $response = $this->get(route('admin.admin-dashboard'));

    $response->assertRedirect(route('login'));
});

it('shows admin dashboard to admin users', function () {
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
        'title' => 'Test Advertisement',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.admin-dashboard'));

    $response->assertOk()
        ->assertViewIs('admin-dashboard')
        ->assertViewHas('users')
        ->assertViewHas('advertisements');

});

it('denies access to non-admin users', function () {
    $response = $this->actingAs($this->employer)
        ->get(route('admin.admin-dashboard'));

    $response->assertStatus(403);
});

it('allows admin to delete non-admin user', function () {
    $response = $this->actingAs($this->admin)
        ->delete(route('admin.users.delete', $this->worker));

    $response->assertRedirect()
        ->assertSessionHas('success', 'Usuario eliminado correctamente');

    expect(User::find($this->worker->id))->toBeNull();
});

it('prevents admin from deleting other admin', function () {
    $otherAdmin = User::factory()->create();
    $otherAdmin->assignRole('admin');

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.users.delete', $otherAdmin));

    $response->assertStatus(403);
    expect(User::find($otherAdmin->id))->not->toBeNull();
});

it('denies user deletion to non-admin users', function () {
    $response = $this->actingAs($this->employer)
        ->delete(route('admin.users.delete', $this->worker));

    $response->assertStatus(403);
    expect(User::find($this->worker->id))->not->toBeNull();
});

it('allows admin to delete worker advertisement', function () {
    $advertisement = WorkerAdvertisementFactory::new()->create([
        'user_id' => $this->worker->id,
        'title' => 'Worker Ad to Delete',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.advertisements.delete', $advertisement));

    $response->assertRedirect()
        ->assertSessionHas('success', 'Anuncio eliminado correctamente');

    expect(Advertisement::find($advertisement->id))->toBeNull();
});

it('allows admin to delete employer advertisement', function () {
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
        'title' => 'Employer Ad to Delete',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.advertisements.delete', $advertisement));

    $response->assertRedirect()
        ->assertSessionHas('success', 'Anuncio eliminado correctamente');

    expect(Advertisement::find($advertisement->id))->toBeNull();
});

it('denies advertisement deletion to non-admin users', function () {
    $advertisement = WorkerAdvertisementFactory::new()->create([
        'user_id' => $this->worker->id,
        'title' => 'Worker Ad',
    ]);

    $response = $this->actingAs($this->employer)
        ->delete(route('admin.advertisements.delete', $advertisement));

    $response->assertStatus(403);
    expect(Advertisement::find($advertisement->id))->not->toBeNull();
});

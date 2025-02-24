<?php

use App\Models\Advertisement;
use App\Models\User;
use Database\Factories\EmployerAdvertisementFactory;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'creator']);

    $this->employer = User::factory()->create(['type' => 'employer']);
    $this->employer->assignRole('creator');

    $this->worker = User::factory()->create(['type' => 'worker']);
    $this->worker->assignRole('creator');

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

it('requires authentication for index', function () {
    $response = $this->get(route('advertisements.index'));

    $response->assertRedirect(route('login'));
});

it('shows only user advertisements in index', function () {
    // Arrange
    $userAds = EmployerAdvertisementFactory::new()->count(3)->create([
        'user_id' => $this->employer->id,
    ]);
    EmployerAdvertisementFactory::new()->count(2)->create();

    // Act
    $response = $this->actingAs($this->employer)
        ->get(route('advertisements.index'));

    // Assert
    $response->assertOk()
        ->assertViewIs('advertisements.index')
        ->assertViewHas('advertisements');

    expect($response->viewData('advertisements')->count())->toBe(3);
    foreach ($userAds as $ad) {
        $response->assertSee($ad->title);
    }
});

it('requires authentication for create', function () {
    $response = $this->get(route('advertisements.create'));

    $response->assertRedirect(route('login'));
});

it('shows create form', function () {
    $response = $this->actingAs($this->employer)
        ->get(route('advertisements.create'));

    $response->assertOk()
        ->assertViewIs('advertisements.create');
});

it('stores new advertisement', function () {
    // Arrange
    $adData = EmployerAdvertisementFactory::new()->make([
        'title' => 'Test Advertisement',
    ])->toArray();

    // Act
    $response = $this->actingAs($this->employer)
        ->post(route('advertisements.store'), $adData);

    // Assert
    $advertisement = Advertisement::where('title', 'Test Advertisement')->first();

    expect($advertisement)->not->toBeNull()
        ->and($advertisement->user_id)->toBe($this->employer->id)
        ->and($advertisement->type)->toBe('employer');

    $response->assertRedirect(route('advertisements.show', $advertisement))
        ->assertSessionHas('success', 'Anuncio creado correctamente');
});

it('validates required fields on store', function () {
    $response = $this->actingAs($this->employer)
        ->post(route('advertisements.store'), []);

    $response->assertSessionHasErrors(['title', 'description', 'location', 'skills', 'experience']);
});

it('shows advertisement details', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);

    // Act
    $response = $this->get(route('advertisements.show', $advertisement));

    // Assert
    $response->assertOk()
        ->assertViewIs('advertisements.show')
        ->assertViewHas('advertisement', $advertisement)
        ->assertSee($advertisement->title);
});

it('requires authorization for edit', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);

    // Act & Assert - Otro usuario no puede editar
    $response = $this->actingAs($this->worker)
        ->get(route('advertisements.edit', $advertisement));
    $response->assertStatus(403);

    // Act & Assert - Propietario puede editar
    $response = $this->actingAs($this->employer)
        ->get(route('advertisements.edit', $advertisement));
    $response->assertOk()
        ->assertViewIs('advertisements.edit')
        ->assertViewHas('advertisement', $advertisement);
});

it('requires authorization for update', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);
    $updateData = EmployerAdvertisementFactory::new()->make([
        'title' => 'Updated Title',
    ])->toArray();

    // Act & Assert - Otro usuario no puede actualizar
    $response = $this->actingAs($this->worker)
        ->put(route('advertisements.update', $advertisement), $updateData);
    $response->assertStatus(403);

    // Act & Assert - Propietario puede actualizar
    $this->actingAs($this->employer)
        ->put(route('advertisements.update', $advertisement), $updateData);

    $advertisement->refresh();
    expect($advertisement)
        ->title->toBe('Updated Title')
        ->slug->toContain('updated-title-');
});

it('allows admin to update any advertisement', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);
    $updateData = EmployerAdvertisementFactory::new()->make([
        'title' => 'Admin Updated',
    ])->toArray();

    // Act
    $response = $this->actingAs($this->admin)
        ->put(route('advertisements.update', $advertisement), $updateData);

    // Assert
    $advertisement->refresh();

    expect($advertisement)
        ->title->toBe('Admin Updated')
        ->type->toBe('employer'); // El tipo se mantiene

    $response->assertRedirect(route('advertisements.show', $advertisement))
        ->assertSessionHas('success', 'Anuncio actualizado correctamente');
});

it('requires authorization for delete', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);

    // Act & Assert - Otro usuario no puede eliminar
    $response = $this->actingAs($this->worker)
        ->delete(route('advertisements.destroy', $advertisement), [
            'title' => $advertisement->title,
            'description' => $advertisement->description,
            'location' => $advertisement->location,
            'skills' => $advertisement->skills,
            'experience' => $advertisement->experience,
        ]);
    $response->assertStatus(403);

    // Act & Assert - Propietario puede eliminar
    $response = $this->actingAs($this->employer)
        ->delete(route('advertisements.destroy', $advertisement), [
            'title' => $advertisement->title,
            'description' => $advertisement->description,
            'location' => $advertisement->location,
            'skills' => $advertisement->skills,
            'experience' => $advertisement->experience,
        ]);

    $response->assertRedirect(route('welcome'))
        ->assertSessionHas('success', 'Anuncio eliminado correctamente');
});

it('allows admin to delete any advertisement', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);

    // Act
    $response = $this->actingAs($this->admin)
        ->delete(route('advertisements.destroy', $advertisement), [
            'title' => $advertisement->title,
            'description' => $advertisement->description,
            'location' => $advertisement->location,
            'skills' => $advertisement->skills,
            'experience' => $advertisement->experience,
        ]);

    // Assert
    $response->assertRedirect(route('welcome'))
        ->assertSessionHas('success', 'Anuncio eliminado correctamente');
    expect(Advertisement::find($advertisement->id))->toBeNull();
});

it('generates pdf download', function () {
    // Arrange
    $advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
    ]);

    // Act
    $response = $this->get(route('advertisements.pdf', $advertisement));

    // Assert
    $response->assertOk()
        ->assertHeader('content-type', 'application/pdf')
        ->assertHeader('content-disposition', 'attachment; filename='.$advertisement->slug.'.pdf');
});

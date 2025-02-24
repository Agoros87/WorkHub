<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Factories\EmployerAdvertisementFactory;

beforeEach(function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'creator']);

    $this->user = User::factory()->create(['type' => 'worker']);
    $this->user->assignRole('creator');

    $this->otherUser = User::factory()->create(['type' => 'worker']);
    $this->otherUser->assignRole('creator');

    $this->advertisement = EmployerAdvertisementFactory::new()->create();
});

it('index requires authentication', function () {
    // Index requiere autenticación
    $response = $this->get(route('favorites.index'));
    $response->assertRedirect(route('login'));
});

it('updates requires authentication', function () {

    $response = $this->put(route('favorites.update', 'test-slug'), [
        'notes' => 'Test note',
        'priority' => 'high'
    ]);
    $response->assertRedirect(route('login'));
});

it('deletes requires authentication', function () {

    $response = $this->delete(route('favorites.destroy', 'test-slug'));
    $response->assertRedirect(route('login'));
});


it('validates favorite update data', function () {
    // Arrange
    $this->user->favoriteAdvertisements()->attach($this->advertisement->id);
    $tooLongNote = str_repeat('a', 151);

    // Act & Assert  Nota demasiado larga
    $response = $this->actingAs($this->user)
        ->put(route('favorites.update', $this->advertisement->slug), [
            'notes' => $tooLongNote
        ]);
    $response->assertSessionHasErrors('notes');

});


it('deletes favorite', function () {
    // Arrange
    $this->user->favoriteAdvertisements()->attach($this->advertisement->id, [
        'notes' => 'Test note',
        'priority' => 'high'
    ]);

    // Act
    $response = $this->actingAs($this->user)
        ->delete(route('favorites.destroy', $this->advertisement->slug));

    // Assert
    $response->assertRedirect()
        ->assertSessionHas('success', 'Anuncio eliminado de favoritos con éxito');

    expect($this->user->favoriteAdvertisements()->count())->toBe(0);
});

it('returns 404 for non-existent advertisement', function () {
    // Arrange
    $nonExistentSlug = 'non-existent-slug';

    // Act & Assert - Update
    $response = $this->actingAs($this->user)
        ->put(route('favorites.update', $nonExistentSlug), [
            'notes' => 'Test note'
        ]);
    $response->assertNotFound();

    // Act & Assert - Delete
    $response = $this->actingAs($this->user)
        ->delete(route('favorites.destroy', $nonExistentSlug));
    $response->assertNotFound();
});

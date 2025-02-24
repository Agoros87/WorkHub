<?php

use App\Models\JobApplication;
use App\Models\User;
use Database\Factories\EmployerAdvertisementFactory;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'creator']);
    $this->user = User::factory()->create();
    $this->user->assignRole('creator');
    $this->user->type = 'worker';
    $this->user->save();

    $this->employer = User::factory()->create();
    $this->employer->assignRole('creator');
    $this->employer->type = 'employer';
    $this->employer->save();

    $this->advertisement = EmployerAdvertisementFactory::new()->create([
        'user_id' => $this->employer->id,
        'schedule' => 'Jornada completa',
        'contract_type' => 'Indefinido',
        'salary' => 1500.00,
    ]);
});

it('allows worker to create job application', function () {
    // Arrange
    $this->actingAs($this->user);

    // Act
    $response = $this->post(route('advertisements.apply', $this->advertisement));

    // Assert
    $response->assertRedirect();
    $this->assertDatabaseHas('job_applications', [
        'user_id' => $this->user->id,
        'advertisement_id' => $this->advertisement->id,
    ]);
});

it('prevents duplicate job applications', function () {
    // Arrange
    $this->actingAs($this->user);
    JobApplication::create([
        'user_id' => $this->user->id,
        'advertisement_id' => $this->advertisement->id,
    ]);

    // Act
    $response = $this->post(route('advertisements.apply', $this->advertisement));

    // Assert
    $response->assertForbidden();
    $this->assertDatabaseCount('job_applications', 1);
});

it('prevents employer from applying to employer advertisement', function () {
    // Arrange
    $this->actingAs($this->employer);

    // Act
    $response = $this->post(route('advertisements.apply', $this->advertisement));

    // Assert
    $response->assertForbidden();
    $this->assertDatabaseCount('job_applications', 0);
});

it('allows user to view own job application', function () {
    // Arrange
    $this->actingAs($this->user);
    $jobApplication = JobApplication::create([
        'user_id' => $this->user->id,
        'advertisement_id' => $this->advertisement->id,
    ]);

    // Act
    $response = $this->get(route('job-applications.show', $jobApplication));

    // Assert
    $response->assertOk()
        ->assertViewIs('job-applications.show')
        ->assertViewHas('jobApplication');
});

it('prevents user from viewing other user job application', function () {
    // Arrange
    $otherUser = User::factory()->create();
    $otherUser->assignRole('creator');
    $jobApplication = JobApplication::create([
        'user_id' => $otherUser->id,
        'advertisement_id' => $this->advertisement->id,
    ]);
    $this->actingAs($this->user);

    // Act
    $response = $this->get(route('job-applications.show', $jobApplication));

    // Assert
    $response->assertForbidden();
});

it('allows advertisement owner to view job application', function () {
    // Arrange
    $jobApplication = JobApplication::create([
        'user_id' => $this->user->id,
        'advertisement_id' => $this->advertisement->id,
    ]);
    $this->actingAs($this->employer);

    // Act
    $response = $this->get(route('job-applications.show', $jobApplication));

    // Assert
    $response->assertOk()
        ->assertViewIs('job-applications.show')
        ->assertViewHas('jobApplication');
});

it('allows user to delete own job application', function () {
    // Arrange
    $this->actingAs($this->user);
    $jobApplication = JobApplication::create([
        'user_id' => $this->user->id,
        'advertisement_id' => $this->advertisement->id,
    ]);

    // Act
    $response = $this->delete(route('job-applications.destroy', $jobApplication));

    // Assert
    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseMissing('job_applications', ['id' => $jobApplication->id]);
});

it('prevents user from deleting other user job application', function () {
    // Arrange
    $otherUser = User::factory()->create();
    $otherUser->assignRole('creator');
    $jobApplication = JobApplication::create([
        'user_id' => $otherUser->id,
        'advertisement_id' => $this->advertisement->id,
    ]);
    $this->actingAs($this->user);

    // Act
    $response = $this->delete(route('job-applications.destroy', $jobApplication));

    // Assert
    $response->assertForbidden();
    $this->assertDatabaseHas('job_applications', ['id' => $jobApplication->id]);
});

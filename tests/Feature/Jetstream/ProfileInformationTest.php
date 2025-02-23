<?php

use App\Models\User;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::create(['name' => 'creator']);
});

test('current profile information is available', function () {
    $user = User::factory()->worker()->create([
        'name' => 'Original Name',
        'phone' => '987654321',
        'location' => 'Test City',
        'lastname' => 'Test Lastname',
        'date_of_birth' => now()->subYears(20),
        'gender' => 'male'
    ]);

    $this->actingAs($user);

    $component = Livewire::test(UpdateProfileInformationForm::class);

    expect($component->state['name'])->toEqual($user->name);
    expect($component->state['email'])->toEqual($user->email);
    expect($component->state['phone'])->toEqual($user->phone);
    expect($component->state['location'])->toEqual($user->location);
    expect($component->state['lastname'])->toEqual($user->lastname);

    expect(Carbon\Carbon::parse($component->state['date_of_birth'])->toDateString())
        ->toEqual($user->date_of_birth->toDateString());

    expect($component->state['gender'])->toEqual($user->gender);
});


test('profile information can be updated', function () {
    $user = User::factory()->worker()->create([
        'name' => 'Original Name',
        'phone' => '987654321',
        'location' => 'New City',
        'lastname' => 'New Lastname',
        'date_of_birth' => now()->subYears(20)->format('Y-m-d'),
        'gender' => 'male'
    ]);

    $this->actingAs($user);

    $newDate = now()->subYears(25)->format('Y-m-d');
    $component = Livewire::test(UpdateProfileInformationForm::class);
    $component->set('state.date_of_birth', $newDate);
    $component->call('updateProfileInformation');
    $user->refresh();
    expect($user->date_of_birth->toDateString())->toEqual($newDate);
});

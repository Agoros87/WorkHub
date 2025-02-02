<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        @if (auth()->user()->type === 'employer')

            <!-- Company Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="company_name" value="{{ __('Company Name') }}" />
                <x-input id="company_name" type="text" class="mt-1 block w-full" wire:model="state.company_name" required autocomplete="company_name" />
                <x-input-error for="company_name" class="mt-2" />
            </div>

            <!-- Tax ID -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="tax_id" value="{{ __('Tax ID') }}" />
                <x-input id="tax_id" type="text" class="mt-1 block w-full" wire:model="state.tax_id" required autocomplete="tax_id" />
                <x-input-error for="tax_id" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="phone" value="{{ __('Phone') }}" />
                <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" required autocomplete="phone" />
                <x-input-error for="phone" class="mt-2" />
            </div>

            <!-- City -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="city" value="{{ __('City') }}" />
                <x-input id="city" type="text" class="mt-1 block w-full" wire:model="state.city" required autocomplete="city" />
                <x-input-error for="city" class="mt-2" />
            </div>
        @elseif (auth()->user()->type === 'worker')
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="lastname" value="{{ __('Last Name') }}" />
                <x-input id="lastname" type="text" class="mt-1 block w-full" wire:model="state.lastname" required autocomplete="lastname" />
                <x-input-error for="lastname" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="phone" value="{{ __('Phone') }}" />
                <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" required autocomplete="phone" />
                <x-input-error for="phone" class="mt-2" />
            </div>

            <!-- Gender (Select) -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="gender" value="{{ __('Gender') }}" />
                <select id="gender" class="mt-1 block w-full" wire:model="state.gender" required>
                    <option value="">{{ __('Select Gender') }}</option>
                    <option value="male">{{ __('Male') }}</option>
                    <option value="female">{{ __('Female') }}</option>
                    <option value="other">{{ __('Other') }}</option>
                </select>
                <x-input-error for="gender" class="mt-2" />
            </div>

            <!-- Date of Birth -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                <x-input id="date_of_birth" type="date" class="mt-1 block w-full" wire:model="state.date_of_birth" required autocomplete="date_of_birth" />
                <x-input-error for="date_of_birth" class="mt-2" />
            </div>

            <!-- City -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="city" value="{{ __('City') }}" />
                <x-input id="city" type="text" class="mt-1 block w-full" wire:model="state.city" required autocomplete="city" />
                <x-input-error for="city" class="mt-2" />
            </div>
        @endif

        <!-- Email (Campo común, al final) -->
        <div class="col-span-6 sm:col-span-6">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
        </div>


    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        $rules = [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
        ];

        // Reglas específicas según el tipo de usuario
        if ($user->type === 'worker') {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['lastname'] = ['required', 'string', 'max:255'];
            $rules['date_of_birth'] = ['required', 'date', 'before_or_equal:' . now()->subYears(16)->toDateString()];
            $rules['gender'] = ['required', 'string', 'in:male,female,other'];
        } else {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['tax_id'] = ['required', 'string', 'max:20'];
        }

        Validator::make($input, $rules)->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $userData = [
                'email' => $input['email'],
                'phone' => $input['phone'],
                'city' => $input['city'],
            ];

            if ($user->type === 'worker') {
                $userData = array_merge($userData, [
                    'name' => $input['name'],
                    'lastname' => $input['lastname'],
                    'date_of_birth' => $input['date_of_birth'],
                    'gender' => $input['gender'],
                ]);
            } else {
                $userData = array_merge($userData, [
                    'company_name' => $input['company_name'],
                    'tax_id' => $input['tax_id'],
                ]);
            }

            $user->forceFill($userData)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}

<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Str;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id), false],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'bio' => ['nullable', 'max:255', 'string'],
        ])->validateWithBag('updateProfileInformation');

        $this->validateUrlProfile($user, $input['name']);

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'bio' => $input['bio'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'bio' => $input['bio'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    /**
     * Validate that the new nickname is abailable to generate url slug to the user's profile.
     */
    protected function validateUrlProfile(User $user, string $inputName): void
    {
        $slug = Str::slug($inputName);
        $url = url("/users/$slug");

        try {
            $profile = $user->profile;
            $profile->url = $url;
            $profile->save();

        } catch (QueryException $e) {
            throw ValidationException::withMessages(
                [
                    'name' => "The name has already been taken. This is showed as your main page nickname."
                ]
            );
        }
    }
}

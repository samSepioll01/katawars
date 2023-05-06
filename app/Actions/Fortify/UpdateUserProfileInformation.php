<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use Exception;

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
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'bio' => ['nullable', 'max:255', 'string'],
        ])->validateWithBag('updateProfileInformation');

        Profile::validateUrlProfile($input['name'], $user);

        if (isset($input['photo'])) {

            // Handler if try upload image to S3 without internet conexion.
            try {

                $previous = $user->profile_photo_path;

                $user->updateProfilePhoto($input['photo']);

                $filePath = $user->profile_photo_path;
                $file = Storage::disk('public')->get($filePath);

                // Can fail if external service is offline.
                Storage::disk('s3')->put('/' . $filePath, $file);

                if ($previous) {
                    Storage::disk('s3')->delete($previous);
                }

                $user->profile_photo_path = $filePath;
                $user->save();

                Storage::disk('public')->delete($filePath);

            } catch (Exception $e) {

                // Undo the update for profile photo.
                $user->profile_photo_path = $previous;
                $user->save();

                session()->flash('syncStatus', 'error');
                session()->flash('syncMessage', 'Oops! Some was wrong. Try upload profile photo later.');
                return redirect()->back();
            }

            session()->flash('syncStatus', 'success');
            session()->flash('syncMessage', 'Profile Photo Updated Successfully!');

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
}

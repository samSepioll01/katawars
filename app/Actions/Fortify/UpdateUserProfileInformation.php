<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use App\CustomClasses\S3;

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

            $user->updateProfilePhoto($input['photo']);

            $filePath = $user->profile_photo_path;
            $file = Storage::disk('public')->get($filePath);
            $S3photos = S3::getProfilePhotos(true);

            if (count($S3photos) === 5) {

                $S3path = S3::filterPath(
                    $S3photos->sortBy('lastModified')->first()['path']
                );

                Storage::disk('s3')->delete($S3path);
            }

            // Can fail if external service is offline.
            Storage::disk('s3')->put('/' . $filePath, $file);

            $user->profile_photo_path = $filePath;
            $user->save();

            Storage::disk('public')->delete($filePath);

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

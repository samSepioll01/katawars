<?php

namespace App\Actions\Jetstream;

use App\Models\Profile;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        $profile = Profile::find($user->id);
        $profile->is_deleted = true;
        $profile->updated_at = now();
        $profile->slug = null;
        $profile->url = null;
        $profile->save();
        //$user->deleteProfilePhoto();
        //$user->tokens->each->delete();

        if ($user->email_verified_at) {
            $user->delete();
        } else {
            $profile->delete();
            $user->forceDelete();
        }
    }
}

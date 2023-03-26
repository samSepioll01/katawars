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
        $profile->save();
        //$user->deleteProfilePhoto();
        //$user->tokens->each->delete();
        $user->delete();
    }
}

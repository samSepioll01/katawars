<?php

namespace App\Policies;

use App\Models\Solution;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolutionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Solution  $solution
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Solution $solution)
    {
        return $user->hasRole(['admin', 'superadmin']);
    }
}

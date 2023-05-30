<?php

namespace App\Http\Livewire;

use App\Jobs\ReportNewFollower;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowButton extends Component
{

    /**
     * The profile to follow/unfollow.
     * @var Profile $profile
     */
    public $profile;

    /**
     * This set whether the profile follow or unfollow action.
     *
     * @return void
     */
    public function follow(): void
    {
        $userProfile = Auth::user()->profile;

        if ($userProfile->id !== $this->profile->id) {

            $userProfile->following()->toggle($this->profile);

            if ($userProfile->isFollowing($this->profile) ) {

                ReportNewFollower::dispatch($userProfile, $this->profile)
                    ->onQueue('sendMailQueue');
            }

            $this->dispatchBrowserEvent('followersupdated', [
                'followers' => $this->profile->followers()->count(),
            ]);

        }

    }

    /**
     * Render the view of Follow Button component.
     */
    public function render()
    {
        return view('livewire.follow-button');
    }
}

<?php

namespace App\Http\Livewire;

use App\Jobs\NewFollowerJob;
use App\Jobs\ReportNewFollower;
use App\Mail\NewFollower;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $userProfile->following()->toggle($this->profile);

        if ($userProfile->isFollowing($this->profile) ) {

            //Mail::send(new NewFollower($userProfile, $this->profile));

            ReportNewFollower::dispatch($userProfile, $this->profile)
                ->onQueue('sendMailQueue');
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

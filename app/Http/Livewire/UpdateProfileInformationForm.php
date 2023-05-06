<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The position for x edge of the crop image.
     */
    public $x;

    /**
     * The position for y edge of the crop image.
     */
    public $y;

    /**
     * The width of the crop image.
     */
    public $width;

    /**
     * The height of the crop image.
     */
    public $height;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Determine if the verification email was sent.
     *
     * @var bool
     */
    public $verificationLinkSent = false;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Set the values for the crop image.
     *
     * @param array $cropperData
     * @return void
     */
    public function setCropperValues($cropperData)
    {
        $this->x = $cropperData['x'];
        $this->y = $cropperData['y'];
        $this->width = $cropperData['width'];
        $this->height = $cropperData['height'];
    }

    /**
     * Reset photo value.
     *
     * @return void
     */
    public function resetPhoto()
    {
        $this->photo = null;
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return void
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        if (isset($this->photo)) {
            Image::load($this->photo->path())
                ->manualCrop($this->width, $this->height, $this->x, $this->y)
                ->save();
        }

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        $user = Auth::user();
        $user->deleteProfilePhoto('s3');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Sent the email verification.
     *
     * @return void
     */
    public function sendEmailVerification()
    {
        Auth::user()->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.update-profile-information-form');
    }
}

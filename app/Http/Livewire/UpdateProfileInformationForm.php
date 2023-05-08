<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\AuxiliarFunctions;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;
use Illuminate\Support\Str;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads, AuxiliarFunctions;

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


    public $selectedPhoto;

    /**
     * The url of the user's thumbnails selected to be new avatar.
     *
     * @var string
     */
    public $photoUrl;

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
        $this->selectedPhoto = Auth::user()->profile_photo_url;
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
     * Set the new avatar between user's profile photos.
     *
     * @param string $photoUrl
     * @return void
     */
    public function choosePhoto(string $photoUrl)
    {
        if (Auth::user()->profile_photo_url !== $photoUrl) {

            $this->photoUrl = $photoUrl;
            $message = 'Oops! Some was wrong. Please, try later.';

            $this->resetErrorBag();
            $this->validate([
                'photoUrl' => [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) use ($message) {

                        if (!Str::contains($value, env('AWS_PROFILE_URL'))) {
                            $fail($message);

                        } else if (!Str::contains($value, auth()->user()->id)) {
                            $fail($message);
                        }
                    },
                ],
            ]);

            $user = User::find(Auth::user()->id);
            $user->profile_photo_path = $photoUrl;
            $user->save();

            $this->selectedPhoto = $photoUrl;

            $this->dispatchBrowserEvent('update-profile-photo', $photoUrl);

            $this->emit('refresh-navigation-menu');
        }
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

        $photos = $this->getProfilePhotos(true)->sortByDesc('lastModified');

        count($photos)
            ? $user->profile_photo_path = $photos->first()['path']
            : $user->profile_photo_path = null;

        $user->save();

        $this->selectedPhoto = $user->profile_photo_url;

        $this->dispatchBrowserEvent(
            'update-profile-photo',
            $user->profile_photo_url
        );
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
        $photos = $this->getProfilePhotos(true);
        return view('livewire.update-profile-information-form', [
            'profilePhotos' => $photos->sortByDesc('lastModified'),
        ]);
    }
}

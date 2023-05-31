<x-jet-form-section submit="updateProfileInformation" id="profileInformationForm">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && auth()->user()->email_verified_at)

            <div
                x-data="{photoName: null, photoPreview: null}"
                x-init="
                    iodine = new Iodine();
                    iodine.rule('fileType', (type) => {
                        return ['image/png', 'image/jpeg'].includes(type);
                    });
                    iodine.rule('fileMaxSize', (size) => {
                        return parseInt(size) < 1000000;
                    });

                    iodine.setErrorMessages({
                        fileType: `The [FIELD] must be a valid image format (png, jpeg, jpg).`,
                        fileMaxSize: `The [FIELD] must not be greater than 1024 kilobytes.`,
                    });
                    iodine.setDefaultFieldName('photo');

                    cropper = new Cropper(
                        document.getElementById('cropperimage'),
                        {
                            aspectRatio: 1,
                            viewMode: 2,
                            preview: '.preview',
                        }
                    );
                "
                class="col-span-6 xl:col-span-4"
            >
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model.defer="photo"
                            x-ref="photo"
                            x-on:change="
                                validations = {
                                    'type': iodine.assert($refs.photo.files[0].type, ['fileType']),
                                    'size': iodine.assert($refs.photo.files[0].size, ['fileMaxSize']),
                                };

                                if (validations.type.valid && validations.size.valid) {
                                    photoName = $refs.photo.files[0].name;
                                    reader = new FileReader();
                                    reader.onload = (e) => {
                                        cropper.replace(e.target.result);
                                        $modals.show('cropper-modal');
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                }
                            "
                />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <div class="flex justify-center">
                    <!-- Current Profile Photo -->
                    <div class="p-2" x-show="! photoPreview">
                        <img
                            src="{{ $this->user->profile_photo_url }}"
                            x-ref="profilephoto"
                            alt="{{ $this->user->name }}"
                            class="rounded-full h-32 w-32 xl:h-40 xl:w-40 2xl:h-44 2xl:w-44 object-cover transition-all duration-500"
                            x-on:update-profile-photo.window="
                                $el.src = $event.detail;
                                $el.style.opacity = 100;
                            "
                            style=""
                        >
                    </div>
                </div>

                {{-- Cropper Modal --}}
                <div wire:ignore>
                    <x-layout.modal name="cropper-modal" maxWidth="4xl" display="justify-evenly">
                        <x-slot name="title">
                            {{ __('Crop Image Area') }}
                        </x-slot>

                        <x-slot name="body">
                            <div class="flex justify-center">
                                <div class="flex flex-col md:flex-row justify-between items-center">
                                    <div class="">
                                        <img id="cropperimage" src="" alt="" class="block h-[300px]">
                                    </div>

                                    <div class="">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="footer">

                            <x-jet-danger-button class="focus:ring-0" @click.prevent="show = false; $wire.resetPhoto()">
                                Cancel
                            </x-jet-danger-button>

                            <x-jet-button
                                @click.prevent="
                                    canvas = cropper.getCroppedCanvas({
                                        width: 160,
                                        height: 160,
                                    });
                                    cropperData = cropper.getData();
                                    canvas.toBlob((blob) => {
                                        reader = new FileReader();
                                        reader.readAsDataURL(blob);
                                        reader.onloadend = function(e) {
                                            photoPreview = e.target.result;
                                        }
                                    });
                                    $wire.setCropperValues(cropperData);
                                    show = false;
                                "
                            >
                                Accept
                            </x-jet-button>
                        </x-slot>
                    </x-layout.modal>
                </div>

                <div class="flex justify-center">
                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full h-32 w-32 xl:h-40 xl:w-40 2xl:h-44 2xl:w-44 bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                </div>

                <div class="p-2 flex justify-center">
                    <div class="w-full flex justify-evenly xl:flex xl:justify-between">
                        <x-jet-secondary-button
                            type="button"
                            class="mr-2 w-48 hover:shadow-md"
                            x-on:click.prevent="$refs.photo.click()"
                        >
                            {{ __('Select A New Photo') }}
                        </x-jet-secondary-button>

                        @if ($this->user->profile_photo_path)
                            <x-jet-secondary-button
                                type="button"
                                class="w-48 flex justify-center hover:shadow-md"
                                x-on:click="
                                    $refs.profilephoto.opacity = 0;
                                    thumbnail = document.querySelector('.thumbnail-selected');
                                    thumbnail.classList.remove('thumbnail-selected');
                                    setTimeout(() => thumbnail.style.opacity = 0, 400);
                                    $wire.deleteProfilePhoto();
                                "
                            >
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                        @endif
                    </div>
                </div>

                <x-jet-input-error for="photo" class="mt-2" />

                @if (count($profilePhotos) >= 1)

                    <div class="max-h-44 w-full py-5 flex flex-col">
                        <div class="p-2">
                            <x-jet-label value="{{ __('Last Photos') }}" />
                        </div>
                        <div class="flex flex-row justify-evenly items-center py-2" x-ref="conthumbnails">
                            @foreach ($profilePhotos as $photo)
                                <div class="rounded-md">
                                    <img
                                        src="{{ env('AWS_PROFILE_URL') . '/' . $photo['path'] }}"
                                        x-on:click="
                                            $refs.profilephoto.style.opacity = 0;
                                            $wire.choosePhoto($event.target.src);
                                        "
                                        class="w-20 h-20 cursor-pointer rounded-md transition-all duration-500"
                                        :class="{'thumbnail-selected': $el.src === @this.selectedPhoto,}"
                                        alt="Thumbnail"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <x-jet-input-error for="photoUrl" class="mt-2" />
            </div>

        @endif

        <!-- Name -->
        <div class="col-span-6 xl:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 xl:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 dark:text-slate-100">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-violet-700 dark:text-cyan-700 dark:hover:text-cyan-400" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        @if (auth()->user()->email_verified_at)
            <!-- Bio -->
            <div class="col-span-6 xl:col-span-4">
                <x-jet-label for="bio" value="{{ __('Bio') }}" />

                <x-profile.bio>
                    {{ auth()->user()->bio }}
                </x-profile.bio>

                <x-jet-input-error for="bio" class="mt-2" />

            </div>
        @endif

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 dark:text-slate-100" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>

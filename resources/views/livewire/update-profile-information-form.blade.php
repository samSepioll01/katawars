<x-jet-form-section submit="updateProfileInformation" id="profileInformationForm">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())

            <div
                x-data="{photoName: null, photoPreview: null}"
                x-init="
                    cropper = new Cropper(
                        document.getElementById('cropperimage'),
                        {
                            aspectRatio: 1,
                            viewMode: 2,
                            preview: '.preview',
                        }
                    );

                    iodine = new Iodine();
                    iodine.rule('fileType', (type) => {
                        return ['image/png', 'image/jpeg'].includes(type);
                    });
                    iodine.rule('fileMaxSize', (size) => {
                        return parseInt(size) < 1000000;
                    });
                    iodine.setErrorMessages({
                        fileType: `[FIELD] must be a valid image format (png, jpeg, jpg).`,
                        fileMaxSize: `[FIELD] must be less than 1M.`,
                    });
                    iodine.setDefaultFieldName('File');
                "
                class="col-span-6 xl:col-span-4"
            >

                <!-- Profile Photo File Input -->
                <input type="file" class="hidden imageinput"
                            wire:model.defer="photo"
                            x-ref="photo"
                            x-on:change="
                                validations = [
                                    iodine.assert($refs.photo.files[0].type, ['fileType']),
                                    iodine.assert($refs.photo.files[0].size, ['fileMaxSize']),
                                ];

                                $refs.conterror.innerHTML = '';

                                validations.forEach(validation => {
                                    if (!validation.valid) {
                                        $refs.conterror.appendChild(
                                            $aux.createElement(
                                                'p',
                                                {
                                                    class: ['text-red-600', 'text-sm', 'p-2'],
                                                },
                                                validation.error,
                                            )
                                        );
                                    }
                                });

                                if (validations.every(validation => validation.valid)) {
                                    $refs.conterror.innerHTML = '';
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
                            alt="{{ $this->user->name }}"
                            class="rounded-full h-32 w-32 object-cover"
                        >
                    </div>
                </div>

                {{-- Cropper Modal --}}
                <div wire:ignore>
                    <x-layout.modal name="cropper-modal" maxWidth="4xl">
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
                        <span class="block rounded-full w-32 h-32 bg-cover bg-no-repeat bg-center"
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
                            <x-jet-secondary-button type="button" class="w-48 flex justify-center hover:shadow-md" wire:click="deleteProfilePhoto">
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                        @endif
                    </div>
                </div>

                <x-jet-input-error for="photo" class="mt-2" />
                <div x-ref="conterror" wire:ignore>
                    {{-- <p x-ref="errorfile" class="text-red-600 text-sm p-2" wire:ignore></p> --}}
                </div>

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

        <!-- Bio -->
        <div class="col-span-6 xl:col-span-4">
            <x-jet-label for="bio" value="{{ __('Bio') }}" />

            <x-profile.bio>
                {{ auth()->user()->bio }}
            </x-profile.bio>

            <x-jet-input-error for="bio" class="mt-2" />

        </div>
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

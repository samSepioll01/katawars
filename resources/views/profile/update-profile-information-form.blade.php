<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null, photoCropper: null}" class="col-span-6 xl:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden imageinput"
                            wire:model.defer="photo"
                            x-ref="photo"
                            {{-- x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoCropper = e.target.result;
                                        $modals.show('cropper-modal');
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " --}}
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
                <p id="error-file" class="text-red-600 text-sm p-2" wire:ignore></p>
            </div>

            {{-- Cropper Modal --}}
            <div wire:ignore>
                <x-layout.modal name="cropper-modal">
                    <x-slot name="title">
                        {{ __('Modal 1') }}
                    </x-slot>

                    <x-slot name="body">
                        {{ __('If you proceed, your account will be deleted entirely.') }}
                        <div class="flex justify-center">

                            <div class="flex flex-col md:flex-row justify-between items-center border border-blue-600">
                                <div class="border border-blue-600">
                                    <img id="cropperimage" src="" alt="" class="block h-[500px]" wire:ignore>
                                </div>

                                <div class="">
                                    <div class="preview"></div>
                                </div>
                            </div>

                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-danger-button class="focus:ring-0" @click.prevent="show = false">Cancel</x-jet-danger-button>
                        <x-jet-button @click.prevent="show = false">Accept</x-jet-button>
                    </x-slot>
                </x-layout.modal>

            </div>

            @vite(['resources/js/cropperprofilephoto.js'])

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

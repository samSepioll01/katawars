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
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 xl:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

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
                    <div class="w-full flex justify-center xl:flex xl:justify-between">
                        <x-jet-secondary-button type="button" class="mr-2 w-48 hover:shadow-md" x-on:click.prevent="$refs.photo.click()">
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

    <x-slot name="modal">

        <x-layout.modal>
            <x-slot name="title">
                {{ __('Are you sure?') }}
            </x-slot>

            <x-slot name="body">
                {{ __('If you proceed, your account will be deleted entirely.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-danger-button class="focus:ring-0">Cancel</x-jet-danger-button>
                <x-jet-button class="dark:bg-violet-800/90">Accept</x-jet-button>
            </x-slot>

        </x-layout.modal>

    </x-slot>

</x-jet-form-section>

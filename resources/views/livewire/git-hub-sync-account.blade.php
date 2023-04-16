<x-jet-action-section>
    <x-slot name="title">
        {{ __('GitHub Sync Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Synchronize the data from your GitHub account as an external provider to your local account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('By syncing with your GitHub account you will be able to share your solutions in your public Katawars repository on your GitHub account. In addition, you will be able to log in alternatively quickly and securely. You must make sure that your GitHub account shares the same email with your local account, otherwise synchronization will not be possible. Your local user data will be updated with your GitHub data so your nickname will be replaced by the one from GitHub or a derived one if it is not available.') }}
        </div>

        <div class="flex items-center mt-5">
            <x-jet-button wire:click="confirmSync" wire:loading.attr="disabled">
                {{ __('Sync With GitHub') }}
            </x-jet-button>

            <x-jet-action-message class="ml-3" on="loggedOut">
                {{ __('Done.') }}
            </x-jet-action-message>
        </div>

        <!-- Log Out Other Devices Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingSync" class="flex items-center">
            <x-slot name="title">
                {{ __('Sync With GitHub') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="syncWithGitHub" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingSync')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3"
                            wire:click="syncWithGitHub"
                            wire:loading.attr="disabled">
                    {{ __('Sync With GitHub') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>

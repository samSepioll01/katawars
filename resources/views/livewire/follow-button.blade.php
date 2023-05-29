<div class="absolute top-3 right-3">
    @if (auth()->user()->profile->isFollowing($profile))
        <x-jet-button class="w-28" wire:click.prevent="follow">Unfollow</x-jet-button>
    @else
        <x-layout.follow-btn class="w-28" wire:click.prevent="follow">Follow</x-layout.follow-btn>
    @endif
</div>

<div>
    <button wire:click="toggleLike" class="flex items-center">
        <svg class="{{ $liked ? 'text-violet-600 dark:text-cyan-600' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20" width="20" height="20">
            <path d="M10.173 3.393C9.817 1.756 8.41.5 6.5.5 4.263.5 2.5 2.263 2.5 4.5c0 3.422 3.04 6.055 7.524 9.736l1.423 1.204a1 1 0 001.106 0l1.423-1.204C14.46 10.555 17.5 7.922 17.5 4.5c0-2.237-1.763-4-4-4-1.91 0-3.317 1.256-3.673 2.893a1 1 0 00-.654-.393z"></path>
        </svg>
        <span class="ml-2 text-slate-700 dark:text-slate-100">{{ $likesCount }}</span>
    </button>
</div>

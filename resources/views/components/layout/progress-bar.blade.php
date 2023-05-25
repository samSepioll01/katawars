@props([
    'size' => '',
    'progress' => '',
    'title' => '',
    'sidebar' => '',
])

@php
    $sidebar = $sidebar ?? false;
    $bgColor = $sidebar ? 'dark:bg-gray-700/40' : 'dark:bg-gray-900/40';
    $textSize = $sidebar ? 'text-sm' : 'text-md';
    $progress = $progress ?: auth()->user()->profile->getProfileProgress();

    if ($sidebar && !$progress) {

        $profile = auth()->user()->profile;

        $lastLevelUp = $profile->rank->id === 1 ? 0 : App\Models\Rank::find($profile->rank_id - 1)->level_up;
        $actualLevelUp = $profile->rank->level_up;

        $progress = ($profile->exp - $lastLevelUp) / ($actualLevelUp - $lastLevelUp) * 100;

        $previousRank = App\Models\Rank::where('id', '<', auth()->user()->profile->rank_id)->orderBy('id')->first();

        if ($progress === $previousRank->level_up) {
            $progress = 0;
        }

        if (App\Models\Rank::all()->count() === $profile->rank_id
            && $profile->exp > $profile->rank->level_up
        ) {
            $progress = 100;
        }

    }

@endphp

<div class="w-full flex flex-col justify-center md:py-0 px-1 overflow-hidden">
    @if ($title)
        <span class="dark:text-slate-200 {{ $textSize }} ">{{ $title }}</span>
    @endif

    <div class="w-full mt-2 rounded-md bg-gray-900/10 {{ $bgColor }} saturate-150"
         style="height: {{ $size }}px"
    >
        <div style="width: {{ $progress }}%" class="h-full bg-green-600 dark:bg-[#0bec7c]
                    animation-progress-bar rounded-md transition-all duration-500
                    dark:shadow-outter-md dark:shadow-green-400"
        ></div>
    </div>
</div>

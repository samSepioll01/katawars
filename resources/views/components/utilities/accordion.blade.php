<div {{ $attributes->merge(['class' => '']) }}>
    <div
        x-data="{ open : false }"
        class="w-full bg-white dark:bg-gray-900/70 shadow-md dark:shadow-gray-900/70 rounded-md"
    >
        <div
            @click="open = !open"
            @click.outside="open = false"
            class="flex flex-row justify-between items-center shadow-md cursor-pointer rounded-md
                text-gray-800 hover:text-violet-800 dark:text-slate-300 dark:hover:text-violet-600 h-16
                transition-colors duration-300"
        >
            <div class="w-11/12 flex item-center px-4">
                <p class="w-full text-md md:text-lg 2xl:text-xl">
                    {{ $title }}
                </p>
            </div>

            <div class="px-4">
                <img
                    src="{{ env('AWS_APP_URL') . '/icons/chevron-down2.png' }}"
                    :class="{ 'rotate-180' : open , 'rotate-0' : !open }"
                    class="transition-all duration-200 w-8 h-8"
                />
            </div>
        </div>
        <div
            class="max-h-0 overflow-hidden transition-all duration-200"
            x-ref="tab"
            :style=" open ? 'max-height: ' + $refs.tab.scrollHeight + 'px;' : '' "
        >
            <div class="text-justify dark:text-slate-300 py-5 px-10">
                {{ $description }}
            </div>
        </div>
    </div>
</div>

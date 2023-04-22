<x-guest-layout>
    <div class="sm:py-16">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div
                class="w-full sm:max-w-4xl mt-6 p-6 px-12 border dark:text-slate-100 border-gray-300 dark:border-gray-800/40 bg-slate-50 dark:bg-[rgb(31,31,31)]/30 border-slate-800/20 shadow-lg overflow-hidden sm:rounded-lg prose">

                <header class="text-center">
                    <h1 class="dark:text-tomato">Help</h1>
                    <p class="text-slate-600 dark:text-slate-400">Last updated: {{ $updatedAt->toDateString() }}.</p>
                </header>

                <div class="text-justify text-rich-text text-size-medium w-richtext">

                    @foreach ($sections as $section)

                        <div name="section" class="py-5">
                            <div name="section__title">
                                <h1 class="text-slate-200">{{ Str::title($section) }}</h1>
                            </div>

                            @foreach ($helps->where('section', $section) as $help)

                                <x-utilities.accordion class="py-2">
                                    <x-slot name="title">
                                        {{ __($help->title) }}
                                    </x-slot>
                                    <x-slot name="description">
                                        {!! __($help->description) !!}
                                    </x-slot>
                                </x-utilities.accordion>

                            @endforeach

                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

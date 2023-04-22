<x-guest-layout>
    <x-layout.wrapper-secondary-panel>

        <header class="text-center">
            <h1 class="dark:text-tomato">Help</h1>
            <p class="text-slate-600 dark:text-slate-200">Last updated: {{ $updatedAt->toDateString() }}.</p>
        </header>

        <div class="text-justify text-rich-text text-size-medium w-richtext">

            @foreach ($sections as $section)

                <div class="section py-5">
                    <div class="section__title">
                        <h1 class="dark:text-slate-200">{{ Str::title($section) }}</h1>
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

    </x-layout.wrapper-secondary-panel>


</x-guest-layout>

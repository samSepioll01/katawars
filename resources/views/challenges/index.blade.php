<x-app-layout>
    <x-layout.wrapped-main-section>

        <div id="title" class="pb-8">
            <h3>Training Section</h3>
        </div>

        <header class="">

            <div id="searcher" class="h-8 rounded-l-full rounded-r-full flex justify-center card-panel">
                Buscador
            </div>
        </header>

        <main class="sm:card-panel sm:mt-8">


            <div>
                @foreach ($challenges as $challenge)
                    <a href="{{ $challenge->url }}">
                        <div class="">{{ $challenge->title }}</div>
                    </a>
                @endforeach
            </div>
        </main>

    </x-layout.wrapped-main-section>
</x-app-layout>

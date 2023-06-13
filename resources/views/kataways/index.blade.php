<x-app-layout>
    <div class="flex flex-col items-center justify-center card-challenge rounded-none">
        <h1 class="text-slate-800 dark:text-slate-100 font-semibold text-4xl">The KataWays</h1>
        <p class="text-sm text-slate-800 dark:text-slate-100">{{ $kataways->count() }} Kataways Availables</p>
    </div>

    <x-layout.searcher-sync route="{{ route('kataways.index') }}" />

    <div class="w-full inline-flex justify-end items-center pr-5 lg:pr-20 py-10">
        <form action="{{ route('kataways.create') }}" method="get">
            <x-jet-button>Create</x-jet-button>
        </form>
    </div>

    <section class="xl:my-24 relative flex justify-center items-center">

        <div class="relative p-5 md:px-12 lg:px-36 grid grid-cols-1 gap-5 md:grid-cols-2 lg:max-w-none xl:grid-cols-3">

            <x-utilities.bg-fluor-backmenu />

            @if (!$kataways->count())
                <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">No kataways founded.</h1>
            @endif
            @foreach ($kataways as $kataway)
                <a href="{{ route('kataways.show', $kataway) }}">
                    <div class="card-info h-48 relative">
                        <div class="flex flex-row gap-1 text-slate-800 dark:text-slate-100 absolute top-4 left-4">
                            <img src="{{ $kataway->createdByProfile->user->profile_photo_url }}" class="rounded-full h-6 w-6" alt="">
                            <span>{{ $kataway->createdByProfile->user->name }}</span>
                        </div>

                        <h3 class="card-info-title">{{ $kataway->title }}</h3>
                        <p class="card-info-text text-ellipsis-2">
                            {{ $kataway->description }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

</x-app-layout>

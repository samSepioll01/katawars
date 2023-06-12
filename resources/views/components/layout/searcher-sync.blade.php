@props([
    'route' => '',
])

<div x-data="{write: false}" id="cont-searcher" class="relative flex lg:inline-flex items-center h-8 w-full">
    <form action="{{ $route }}" method="get" x-ref="searchform" class="w-full flex flex-row justify-center">
        <div class="w-full sm:w-3/4 xl:w-1/2 relative transtion-all duration-200">
            <x-jet-input
                type="text"
                id="search"
                x-init="$el.value ? write = true : write = false;"
                x-ref="search"
                name="search"
                placeholder="Search..."
                class="search-input rounded-l-full w-full"
                x-on:keyup="
                    $event.target.value ? write = true : write = false;
                "
                value="{{ old('search', request()->query('search')) }}"
            />

                <span class="w-10 absolute top-[3px] right-1 text-center text-3xl text-slate-400 cursor-pointer transition-all duration-300 hover:text-slate-700"
                  x-show="write"
                  x-on:click.prevent="
                    write = false;
                    $refs.search.value = '';
                    $refs.formcross.submit();
                  "
                  style="display: none;"
                >&times;</span>


        </div>

        <button type="submit" class="search-btn">
            <img src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/search.png"
                class="h-6 w-6" alt="">
        </button>
    </form>
    <form action="{{ $route }}" method="get" x-ref="formcross" class="hidden"></form>
</div>


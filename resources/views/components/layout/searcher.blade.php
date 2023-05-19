@props([
    'action' => '',
])

@php
    $action = $action ?? '#';
@endphp


<div class="w-full">
    <div id="cont-searcher" class="relative flex lg:inline-flex items-center h-8 w-full">
        <form x-ref="searchform" method="get" action="{{$action}}" class="w-full flex justify-center">
            <x-jet-input type="text" id="search" x-ref="search" name="search" placeholder="Search..." class="w-full sm:w-3/4 xl:w-1/2 transition-all duration-300 bg-slate-50 border-slate-400 dark:border-slate-700 shadow-lg rounded-l-full dark:dark-placeholder" />
            <div class="search-btn"
                 x-on:click="$refs.searchform.submit()"
            >
                <img src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/search.png"
                 class="h-6 w-6" alt="">
            </div>
        </form>
    </div>
</div>

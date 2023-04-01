<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-[rgb(31,31,31)]/30 border border-slate-800/20 rounded-md shadow-xl">
            <div class="overflow-hidden sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>

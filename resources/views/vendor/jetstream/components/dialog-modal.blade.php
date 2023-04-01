@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg text-violet-600 dark:text-slate-100">
            {{ $title }}
        </div>

        <div class="mt-4 text-slate-700 dark:text-slate-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-right bg-transparent">
        {{ $footer }}
    </div>
</x-jet-modal>

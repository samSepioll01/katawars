@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 rounded-md border-l-4 border-indigo-400 dark:border-[#ff01c2ff] text-base font-medium text-indigo-700 dark:text-slate-800 bg-indigo-50 dark:bg-slate-200 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition'
            : 'block pl-3 pr-4 py-2 rounded-md text-base font-medium text-slate-700 dark:text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-700 dark:hover:text-slate-300 transition';

//text-slate-600v dark:text-slate-500v hover:bg-slate-100 dark:hover:bg-slate-700 dark:hover:text-slate-300
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border border-gray-300 rounded-md transition
                dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100 dark:dark-placeholder
                focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                dark:focus:shadow-outter-lg dark:focus:ring-transparent
                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'
    ])
!!}>

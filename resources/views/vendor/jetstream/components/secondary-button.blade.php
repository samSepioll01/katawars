<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold
                text-xs text-gray-500 uppercase tracking-widest shadow-sm hover:text-gray-700 active:text-gray-800
                active:bg-gray-50 active:translate-y-1 disabled:opacity-25 dark:bg-violet-800/50 dark:border-violet-900/70
                dark:hover:bg-gradient-to-r dark:hover:from-violet-700 dark:hover:to-cyan-400/30 dark:text-slate-100/70
                dark:hover:text-slate-100/100 transition'
])
}}>
{{ $slot }}
</button>

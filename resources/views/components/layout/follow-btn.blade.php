<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-4 py-2 bg-gray-300/70 border border-transparent rounded-md
                font-semibold text-xs text-slate-700 uppercase tracking-widest transition disabled:opacity-50
                hover:bg-gradient-to-r hover:from-gray-500 hover:to-cyan-900/30 hover:text-slate-50 active:bg-gray-900
                active:scale-95 dark:bg-violet-600/90 dark:border-violet-900/70 dark:hover:bg-gradient-to-r
                dark:hover:from-violet-700 dark:hover:to-cyan-400/30 dark:text-slate-100/100 dark:hover:text-slate-100/100'
    ])
}}>
    {{ $slot }}
</button>

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md
                font-semibold text-xs text-slate-300 uppercase tracking-widest transition disabled:opacity-50
                hover:bg-gradient-to-r hover:from-gray-800 hover:to-cyan-900/30 hover:text-slate-50 active:bg-gray-900 active:translate-y-1 dark:bg-violet-800/50 dark:border-violet-900/70
                dark:hover:bg-gradient-to-r dark:hover:from-violet-700 dark:hover:to-cyan-400/30 dark:text-slate-100/70
                dark:hover:text-slate-100/100'
    ])
}}>
    {{ $slot }}
</button>

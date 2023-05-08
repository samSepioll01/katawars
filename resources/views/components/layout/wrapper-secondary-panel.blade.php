<div {{ $attributes->merge(['class' => 'sm:py-16']) }} >
    <div class="min-h-screen flex flex-col items-center sm:pt-0">
        <div
            class="w-full sm:max-w-4xl sm:mt-6 sm:p-6 px-6 sm:px-12 border dark:text-slate-100 border-gray-300
                dark:border-gray-800/40 @if(Request::routeIs('help')) bg-slate-50/50 @else bg-slate-50 @endif dark:bg-[rgb(31,31,31)]/30 border-slate-800/20
                shadow-lg overflow-hidden sm:rounded-lg prose"
        >
            {{ $slot }}
        </div>
    </div>
</div>

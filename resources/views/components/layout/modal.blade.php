@props(['name', 'maxWidth', 'display' => '', 'heigth' => ''])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
    ][$maxWidth ?? '7xl'];
@endphp

<div id="{{ $name }}"
    x-data="{
        show: false,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    @modal.window="
            show = ($event.detail === $el.id);
    "
    @keydown.escape.window="show = false"
    class="{{ $attributes['class'] }}"
    style="display: none;"
>
    <div
        class="min-h-screen z-10 w-full fixed inset-0 bg-gray-700/30 dark:bg-gray-400/30 transition-all
               backdrop-blur-sm transform"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >

    </div>

    <div
        class="bg-white/90 dark:bg-gray-900/90 shadow-md p-4 {{ $heigth }} scrollbar-inner-menu xl:max-h-[500px] 2xl:max-h-[700px] overflow-y-auto m-auto rounded-md fixed inset-0 z-10 {{ $maxWidth }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.away ="show = false"
    >
        <div class="flex flex-col {{ $display ?: 'justify-evenly' }} min-h-[300px] sm:h-full">
            <header class="relative">
                <h3 class="font-bold text-lg dark:text-slate-50 p-5">
                    {{ $title }}
                </h3>
            </header>

            <main class=" text-slate-50">
                {{ $body }}
            </main>

            <footer class="flex flex-row justify-evenly items-center p-5">
                {{ $footer }}
            </footer>
        </div>
    </div>
</div>

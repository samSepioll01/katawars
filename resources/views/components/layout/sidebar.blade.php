<div
    x-data="{
        hub: DOMelems.sidebarHub,
    }"
    x-init="$watch('sidebarOpen', value => {
        if (value) {
            document.body.classList.add('overflow-hidden');
        } else {
            document.body.classList.remove('overflow-hidden');
        }
    })"
    @resize.window="
            width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (width < 640 && sidebarOpen) {
                sidebarOpen = false;
                transformHub(hub, sidebarOpen);
            }
    "
    x-show="sidebarOpen"
    class=""
    style="display: none;"
>
    <div
        x-show="sidebarOpen"
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
        x-show="sidebarOpen"
        x-on:click.outside="
            if (!$event.target.classList.contains('hub') && !$event.target.classList.contains('hub-bar')) {
                transformHub(hub, sidebarOpen = false);
            }
        "
        x-on:close.stop="sidebarOpen = false"
        x-on:keydown.escape.window="sidebarOpen = false"
        class="sidebar h-screen overflow-y-auto scrollbar-inner-menu moz-scrollbar-light dark:moz-scrollbar-dark w-64 z-10 p-4 fixed pt-10 pb-20
             bg-slate-50 dark:bg-gray-900 transform shadow-outter-sm shadow-gray-400 dark:shadow-gray-700 transition-all"
        x-transition:enter="ease-fast-slide duration-800"
        x-transition:enter-start="-translate-x-64"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="ease-fast-slide duration-800"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-64"
    >
        {{ $slot }}
    </div>
</div>

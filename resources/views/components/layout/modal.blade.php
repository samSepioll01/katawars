<div
    @hashchange.window="
        show = (location.hash === '#cropper-modal-on')
    "
    x-data="{ show: false }"
    x-show="show"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-hidden');
        } else {
            document.body.classList.remove('overflow-hidden');
        }
    })"
    @resize.window="
            width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (width < 640 && sidebarOpen) {
                show = false;
            }
    "
    class=""
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

    <div class="bg-white shadow-md p-4 max-w-md h-48 m-auto rounded-md fixed inset-0 z-10">
        <div class="flex flex-col justify-between h-full">
            <header>
                <h3 class="font-bold text-lg">
                    {{ $title }}
                </h3>
            </header>

            <main class="my-4">
                {{ $body }}
            </main>

            <footer class="flex flex-row justify-evenly items-center">
                {{ $footer }}
            </footer>
        </div>

    </div>

</div>

<x-app-layout>
    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-10">
                <img src="{{ env('AWS_APP_URL') }}/images/katawy.png" alt="">
            </div>
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0">

                <div class="px-4 text-lg text-gray-700 dark:text-slate-200 tracking-wider">
                    <p>{{__('Esta página no está disponible.')}}</p>
                    <p>{{__('Disculpa las molestias.')}}</p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

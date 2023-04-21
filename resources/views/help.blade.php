<x-guest-layout>
    <div class="sm:py-16">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-4xl mt-6 p-6 px-12 rounded-2xl border dark:text-slate-100 border-gray-300 dark:border-gray-700 bg-slate-50 dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose">

                <header class="text-center">
                    <h1 class="dark:text-tomato">Help</h1>
                    <p class="text-slate-600 dark:text-slate-400">Last updated: {{ $updatedAt->toDateString() }}.</p>
                </header>

                <div class="text-justify text-rich-text text-size-medium w-richtext">

                    AQUÍ VA EL MENÚ ACORDEÓN CON TAILWINDCSS Y ALPINE.JS CON TANTAS ENTRADAS COMO REGISTROS HAYA EN LA TABLA AYUDAS.

                    @foreach ($sections as $section)

                        <div name="section">
                            <div name="section__title">
                                <h1>{{ Str::title($section) }}</h1>
                            </div>

                            @foreach ($helps->where('section', $section) as $help)

                                <div name="section__help">
                                    <div name="section__help-title">
                                        <h3>{{ $help->title }}</h3>
                                    </div>
                                    <div name="section__help-description">
                                        <p>{!! $help->description !!}</p>
                                    </div>
                                </div>

                            @endforeach

                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

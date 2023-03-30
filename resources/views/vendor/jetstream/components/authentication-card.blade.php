@php
    Request::routeIs('login') ? $url = '/storage/images/login.webp' : null;
    Request::routeIs('register') ? $url = '/storage/images/pinkmeduse.webp' : null;
    Request::routeIs('password.request') ? $url = '/storage/images/interestellar.webp' : null;
    $url = $url ?? false;
@endphp

<div class="min-h-screen flex justify-center 2xl:items-center pt-0 sm:pt-6 transition-all">

    <div class="max-w-7xl md:h-[530px] 2xl:h-[650px] @if($url) lg:w-5/6 @else lg:w-1/2 @endif flex flex-col justify-center md:flex-row border border-gray-200
              dark:border-gray-800 rounded-lg sm:shadow-md bg-slate-50 dark:bg-slate-900"
    >
        @if ($url)
            <div class="w-full md:w-1/2 md:py-4 md:pl-4 md:pr-5 overflow-hidden text-slate-100 bg-slate-50 dark:bg-slate-900">
                <div class="w-full h-full md:h-full md:rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ url($url) }}" alt=""
                        class="md:h-full animation-shining hover:scale-125 hover:saturate-150 hover:shadow transition-all duration-500"
                    />
                </div>
            </div>
        @endif

        <div class="@if($url) md:w-1/2 @endif my-4 md:mr-4 flex flex-col sm:justify-evenly items-center bg-slate-50 dark:bg-slate-900 border border-transparent @if($url) md:border-l-gray-200 md:dark:border-l-gray-600 @endif">

            <div class="w-full flex flex-row justify-center items-end">
                <div class="transition-all px-5">
                    {{ $logo }}
                </div>

                @if ($url ?? false)
                    <div class="p-2 sm:p-0 text-2xl tracking-wide uppercase text-slate-700 dark:text-slate-100">
                        @if(Request::routeIs('login'))
                            login account
                        @endif
                        @if (Request::routeIs('register'))
                            register account
                        @endif
                        @if(Request::routeIs('password.request'))
                            password recover
                        @endif
                    </div>

                @endif
            </div>


            <div class="w-full max-w-lg mt-6 px-6 py-4 bg-slate-50 dark:bg-slate-900 sm:rounded-lg md:overflow-y-auto 2xl:overflow-hidden scrollbar-inner-menu">
                {{ $slot }}
            </div>
        </div>

    </div>
</div>

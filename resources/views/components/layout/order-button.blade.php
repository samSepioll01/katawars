@props([
    'route' => '',
])

<div class="pb-8">
    <x-jet-dropdown align="left" width="64">
        <x-slot name="trigger">
            <div
                class="w-fit p-2 cursor-pointer active:scale-90 hover:bg-slate-200/70 dark:hover:bg-slate-800/50 rounded-full transform transition-all duration-100"
                :class="{'shadow-lg bg-slate-200/70 dark:bg-slate-800/50': open, 'bg-transparent': !open}"
            >
                <img class="hidden sm:block h-8 w-8 rounded-full object-cover" src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/hub-menu1.png" alt="">
            </div>
        </x-slot>

        <x-slot name="content">
            <div>
                <x-jet-dropdown-link :button="true"
                    x-on:click="
                        axios({
                            method: 'get',
                            url: '{{ $route }}?ord=asc',
                            responseType: 'json',
                        })
                        .then(response => {
                            if (response.data.success) {
                                $refs.list.innerHTML = response.data.html;
                                console.log(response.data.html);
                            }
                        })
                        .catch(errors => console.log(errors));
                    "
                    class="cursor-pointer"
                >
                    {{ __('Ascending (from less to more)') }}
                </x-jet-dropdown-link>

                <x-jet-dropdown-link
                    :button="true"
                    x-on:click="
                        axios({
                            method: 'get',
                            url: '{{ $route }}?ord=desc',
                            responseType: 'json',
                        })
                        .then(response => {
                            if (response.data.success) {
                                $refs.list.innerHTML = response.data.html;
                            }
                        })
                        .catch(errors => console.log(errors));
                    "
                    class="cursor-pointer">
                    {{ __('Descending (from more to less)') }}
                </x-jet-dropdown-link>
            </div>
        </x-slot>
    </x-jet-dropdown>
</div>

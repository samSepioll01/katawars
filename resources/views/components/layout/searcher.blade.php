@props([
    'route' => '',
])

<div x-data="{write: false}" id="cont-searcher" class="relative flex lg:inline-flex items-center h-8 w-full">
    <div x-ref="searchform" class="w-full flex flex-row justify-center">
        <div class="w-full sm:w-3/4 xl:w-1/2 relative transtion-all duration-200">
            <input
                type="text"
                id="search"
                x-ref="search"
                name="search"
                placeholder="Search..."
                class="search-input rounded-l-full w-full"
                x-on:keydown.enter.prevent=""
                x-on:keyup="
                    $event.target.value ? write = true : write = false;

                    axios({
                        method: 'get',
                        url: '{{$route}}?search=' + $event.target.value + '&searcher=true',
                        responseType: 'json',
                    })
                    .then(response => {
                        if (response.data.success) {
                            if ($refs?.users) $refs.users.innerHTML = response.data.users;
                            if ($refs?.challenges) $refs.challenges.innerHTML = response.data.challenges;
                        }
                    })
                    .catch(error => console.log(error));
                "
            />
            <span class="w-10 absolute top-[3px] right-1 text-center text-3xl text-slate-400 cursor-pointer trasition-all duration-300 hover:text-slate-700"
                  x-show="write"
                  x-on:click.prevent="
                    write = false;
                    $refs.search.value = '';
                    axios({
                        method: 'get',
                        url: '{{$route}}?search=' + $refs.search.value + '&searcher=true',
                        responseType: 'json',
                    })
                    .then(response => {
                        if (response.data.success) {
                            if ($refs?.users) $refs.users.innerHTML = response.data.users;
                            if ($refs?.challenges) $refs.challenges.innerHTML = response.data.challenges;
                        }
                    })
                    .catch(error => console.log(error));
                  "
                  style="display: none;"
            >&times;</span>
        </div>

        <div class="search-btn"
                x-on:click="
                axios({
                    method: 'get',
                    url: '{{$route}}?search=' + $refs.search.value + '&searcher=true',
                    responseType: 'json',
                })
                .then(response => {
                    if (response.data.success) {
                        if ($refs?.users) $refs.users.innerHTML = response.data.users;
                        if ($refs?.challenges) $refs.challenges.innerHTML = response.data.challenges;
                    }
                })
                .catch(error => console.log(error));
                "
        >
            <img src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/search.png"
                class="h-6 w-6" alt="">
        </div>
    </div>
</div>


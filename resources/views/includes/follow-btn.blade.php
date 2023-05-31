@if (auth()->user()->profile->isFollowing($profile))
    <x-jet-button class="w-28"
        x-on:click="
            $event.stopImmediatePropagation();
            $event.preventDefault();
            axios({
                method: 'post',
                url: location.origin + '/user/' + '{{ $profile->slug }}' + '/change-follow',
                responseType: 'json',
            })
            .then(response => {
                if (response.data.success) {

                    $refresh.follows(
                        response.data.followers,
                        response.data.following,
                    );
                    $el.parentNode.innerHTML = response.data.refreshbutton;
                }
            })
            .catch(errors => console.log(errors));
        "
    >
        Unfollow
    </x-jet-button>
@else
    <x-layout.follow-btn class="w-28"
        x-on:click="
            $event.stopImmediatePropagation();
            $event.preventDefault();
            axios({
                method: 'post',
                url: location.origin + '/user/' + '{{ $profile->slug }}' + '/change-follow',
                responseType: 'json',
            })
            .then(response => {
                if (response.data.success) {
                    $refresh.follows(
                        response.data.followers,
                        response.data.following,
                    );
                    $el.parentNode.innerHTML = response.data.refreshbutton;
                }
            })
            .catch(errors => console.log(errors));
        "
    >
        Follow
    </x-layout.follow-btn>
@endif

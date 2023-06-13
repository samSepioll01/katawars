<x-app-layout>
        <div class="flex justify-center pt-20">
            <h1 class="text-slate-800 dark:text-slate-100 font-semibold text-4xl">Admin Panel</h1>
        </div>
        <section class="xl:my-24 relative flex justify-center items-center">

            <div class="relative p-5 md:px-12 lg:px-36 grid grid-cols-1 gap-5 md:grid-cols-2 lg:max-w-none xl:grid-cols-3">

                <x-utilities.bg-fluor-backmenu />

                <a href="{{ route('users.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Users</h3>
                        <p class="card-info-text">
                            Management Users
                        </p>
                    </div>
                </a>


                @superadmin
                    <a href="{{ route('challenges.index') }}">
                        <div class="card-info w-96 h-44">
                            <h3 class="card-info-title">Challenges</h3>
                            <p class="card-info-text">
                                Management Challenges
                            </p>
                        </div>
                    </a>
                @endsuperadmin

                <a href="{{ route('admin.kataways.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Kataways</h3>
                        <p class="card-info-text">
                            Management Kataways
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Categories</h3>
                        <p class="card-info-text">
                            Management Categories
                        </p>
                    </div>
                </a>

                <a href="{{ route('ranks.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Ranks</h3>
                        <p class="card-info-text">
                            Management Ranks
                        </p>
                    </div>
                </a>

                <a href="{{ route('scores.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Scores</h3>
                        <p class="card-info-text">
                            Management Scores
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.helps.index') }}">
                    <div class="card-info w-96 h-44">
                        <h3 class="card-info-title">Helps</h3>
                        <p class="card-info-text">
                            Management Helps
                        </p>
                    </div>
                </a>


            </div>
        </section>

</x-app-layout>

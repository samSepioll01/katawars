<x-guest-layout>
    <x-utilities.bg-fluor-main />

    <div class="relative flex items-top flex-col justify-center min-h-screen sm:items-center pt-4 sm:pt-0">

        <section class="relative w-full 2xl:mt-28 transition-all">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 text-center lg:pt-32">
                <x-utilities.bg-fluor-main />
                <h1 class="mx-auto max-w-4xl font-bold text-5xl tracking-tight text-black dark:text-slate-100 sm:text-7xl">
                    Improve your coding skills with less effort, in less time.
                </h1>
                <p class="mx-auto mt-6 max-w-xl text-lg text-blue-900 dark:text-blue-100">
                    Easily achieve through challenges the mastery needed to take your programming skills to a higher level.
                </p>

                <x-utilities.btn-fluor class="lg:mt-12 2xl:mt-24" route="login">Get Started</x-utilities.btn-fluor>
            </div>
        </section>

        <section class="xl:my-24 relative flex justify-center items-center">

            <div class="relative p-5 md:px-12 lg:px-36 grid grid-cols-1 gap-5 md:grid-cols-2 lg:max-w-none xl:grid-cols-3">

                <x-utilities.bg-fluor-backmenu />

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/codificacion.png') }}" alt="Coding icon">
                    </div>
                    <h3 class="card-info-title">Sharpen your coding skills</h3>
                    <p class="card-info-text">
                        Challenge yourself on small coding exercises called "kata". Each kata is crafted by the community to help you strengthen different coding skills. Master programming techniques in different languages.
                    </p>
                </div>

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/medalla-de-oro.png') }}" alt="Rank and Honor">
                    </div>
                    <h3 class="card-info-title">Earn ranks and honor</h3>
                    <p class="card-info-text">
                        Kata code challenges are ranked just like belts in martial arts. As you complete higher-ranked katas, you level up your profile and push your software development skills to your highest potential.
                    </p>
                </div>

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/interpersonales.png') }}" alt="Feedback icon">
                    </div>
                    <h3 class="card-info-title">Get community feedback</h3>
                    <p class="card-info-text">
                        Review resources contributed by other users or add them yourself to help others. Solve kata and see the solutions provided by users to learn new approaches to overcoming challenges.
                    </p>
                </div>

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/pensamiento-critico.png') }}" alt="Perspectives icon">
                    </div>
                    <h3 class="card-info-title">Get new perspectives</h3>
                    <p class="card-info-text">
                        Solve challenges then view how others solved the same challenge. Pickup new techniques from some of the most skilled developers in the world.
                    </p>
                </div>

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/gestion-del-tiempo.png') }}" alt="Coding time icon">
                    </div>
                    <h3 class="card-info-title">Increase your coding speed</h3>
                    <p class="card-info-text">
                        Perform the katas in Blitz mode and try to validate your code in the shortest time possible to get a better ranking, as well as get more honor and experience.
                    </p>
                </div>

                <div class="card-info">
                    <div class="card-info-icon">
                        <img src="{{ url('/storage/icons/disputar.png') }}" alt="Clashes icon">
                    </div>
                    <h3 class="card-info-title">Compete throught clashes</h3>
                    <p class="card-info-text">
                        Compete against your friends, colleagues, and the community at large. Allow competition to motivate you  towards mastering your craft.
                    </p>
                </div>
            </div>
        </section>

        <section class="min-h-screen w-full mt-16 py-16 parallax-bluegirl">
            <div class="parallax-inner-container">
                <h1 class="parallax-header">
                    An engaged software development community
                </h1>
                <p class="parallax-text my-8">
                    Katawars is a collective effort by its users. They are creators—authoring kata to teach various techniques, solving kata with solutions that enlighten others, and commenting with constructive feedback.
                </p>

                <div class="w-full grid grid-cols-1 md:grid-cols-3 backdrop-blur-sm rounded 2xl:py-20 transition-all duration-500">
                    <div class="parallax-grid-cell">
                        <h3 class="parallax-grid-title">75K+</h3>
                        <p class="parallax-grid-text">Community members added every month</p>
                    </div>
                    <div class="parallax-grid-cell">
                        <h3 class="parallax-grid-title">1MM+</h3>
                        <p class="parallax-grid-text">Kata completed every month</p>
                    </div>
                    <div class="parallax-grid-cell">
                        <h3 class="parallax-grid-title">9K+</h3>
                        <p class="parallax-grid-text">Kata created by our community</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="min-h-screen w-full py-16 parallax-hexagon">
            <div class="parallax-inner-container">
                <h1 class="parallax-header">
                    Create your own kata
                </h1>
                <div class="parallax-text">
                   Author kata that focus on your interests and train specific skill sets. Challenge the community with your insight and code understanding. Create challenges that push the limits of your creativity. Katas can be grouped into Paths, set of challenges that share the same category across differents levels.<span class="xl:block"> Gain honor within the coding Dojo.</span>
                </div>

                <div class="parallax-code-container">
                    <div class="parallax-code-inner-cont">
                        <div class="parallax-code-header">
                            <div class="parallax-code-tab_1">Code</div>
                            <div class="parallax-code-tab_2">Diff</div>
                        </div>

                        <div class="parallax-code-body">
                            <img src="{{ url('/storage/images/knightsofniclass.png') }}" alt="Code Kata - Knights Of Ni! Test" />
                        </div>
                    </div>

                    <div class="parallax-code-inner-cont">
                        <div class="parallax-code-header">
                            <div class="parallax-code-tab_1">Test Cases</div>
                            <div class="parallax-code-tab_2">Diff</div>
                        </div>

                        <div class="parallax-code-body">
                            <img src="{{ url('/storage/images/knightsofnitest.png') }}" alt="Code Kata - Knights Of Ni! Class" />
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</x-guest-layout>

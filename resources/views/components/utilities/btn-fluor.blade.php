@props(['route'])

<div {{ $attributes->merge(['class' => "flex justify-center items-center flex-col m-12"]) }}>
    <a href="{{ route($route ?? 'home') }}"
      class="relative w-40 h-12 inline-block bg-slate-100 m-5 hover:scale-105 transition-all duration-500
             before:absolute before:inset-0  before:transition-all before:ease-in before:duration-300
             before:bg-[linear-gradient(45deg,#00b6e0ff,#7f5bd1ff,#ff01c2ff)]
             dark:before:bg-[linear-gradient(45deg,#00b6e0ff,transparent,transparent,#ff01c2ff)]
             after:absolute after:inset-0 after:transition-all after:ease-in after:duration-300
             after:bg-[linear-gradient(45deg,#00b6e0ff,#7f5bd1ff,#ff01c2ff)]
             dark:after:bg-[linear-gradient(45deg,#00b6e0ff,transparent,transparent,#ff01c2ff)]
             hover:before:-inset-[4px] dark:hover:before:-inset-[3px] hover:before:transition-all
             hover:before:ease-in hover:before:duration-300
             hover:after:-inset-[4px] dark:hover:after:-inset-[3px] hover:after:blur-md hover:after:transition-all
             hover:after:ease-in hover:after:duration-300"
    >
        <span class="absolute top-0 left-0 w-full h-full bg-[#0e1538] z-10 flex justify-center items-center text-slate-100
                     border border-[#040a29] tracking-widest overflow-hidden
                     before:absolute before:top-0 before:-left-1/2 before:w-full before:h-full before:-z-10 before:skew-x-[25deg]
                   hover:before:bg-[_rgba(255,_255,_255,0.075)] hover:before:transition-all hover:before:ease-in
                     hover:before:duration-300"
        >
            {{ $slot }}
        </span>
    </a>
</div>

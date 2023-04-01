<footer class="@if(Auth::check()) pt-5 @else py-5 @endif w-full dark:bg-slate-900/70">

    @guest
        <div class="flex flex-row justify-center">
            <x-logo type="icon" class="rounded w-16 transparent transition duration-300" />
            <p class="px-5 flex flex-col justify-center">
                <span class="text-xl text-slate-700 dark:text-slate-100 tracking-wide">Improve your coding skills</span>
                <span class="text-xl text-slate-700 dark:text-slate-100 tracking-wide">with less effort, in less time.</sp>
            </p>
        </div>
    @endguest


    <div class="py-5 md:pb-2 flex flex-col md:flex-row justify-evenly items-center text-slate-700 dark:text-slate-400">
        <a href="{{ route('privacy-policy') }}" class="py-2 dark:hover:text-slate-100 hover:text-violet-700 transition-colors duration-300">Privacy Policy</a>
        <a href="{{ route('terms-service') }}" class="py-2 dark:hover:text-slate-100 hover:text-violet-700 transition-colors duration-300">Term of Service</a>
        <a href="https://github.com/samSepioll01/katawars" target="_blank" class="py-2 hover:scale-125 transition-all duration-300">
            <div class="">
                <svg class="dark:hover:text-slate-100 hover:text-slate-900" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_236_3359)">
                        <path d="M12 0.296875C5.37 0.296875 0 5.66988 0 12.2969C0 17.5999 3.438 22.0969 8.205 23.6819C8.805 23.7949 9.025 23.4239 9.025 23.1049C9.025 22.8199 9.015 22.0649 9.01 21.0649C5.672 21.7889 4.968 19.4549 4.968 19.4549C4.422 18.0699 3.633 17.6999 3.633 17.6999C2.546 16.9559 3.717 16.9709 3.717 16.9709C4.922 17.0549 5.555 18.2069 5.555 18.2069C6.625 20.0419 8.364 19.5119 9.05 19.2049C9.158 18.4289 9.467 17.8999 9.81 17.5999C7.145 17.2999 4.344 16.2679 4.344 11.6699C4.344 10.3599 4.809 9.28988 5.579 8.44988C5.444 8.14688 5.039 6.92688 5.684 5.27388C5.684 5.27388 6.689 4.95188 8.984 6.50388C9.944 6.23688 10.964 6.10488 11.984 6.09888C13.004 6.10488 14.024 6.23688 14.984 6.50388C17.264 4.95188 18.269 5.27388 18.269 5.27388C18.914 6.92688 18.509 8.14688 18.389 8.44988C19.154 9.28988 19.619 10.3599 19.619 11.6699C19.619 16.2799 16.814 17.2949 14.144 17.5899C14.564 17.9499 14.954 18.6859 14.954 19.8099C14.954 21.4159 14.939 22.7059 14.939 23.0959C14.939 23.4109 15.149 23.7859 15.764 23.6659C20.565 22.0919 24 17.5919 24 12.2969C24 5.66988 18.627 0.296875 12 0.296875Z" fill="currentcolor"></path>
                    </g>
                </svg>
            </div>
          </a>
    </div>

</footer>

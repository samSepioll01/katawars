<textarea name="bio" id="bio" type="bio" cols="30" rows="5" maxlength="158"
          class="w-full block mt-1 rounded-md transition border border-gray-300
               dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                 focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                dark:focus:shadow-outter-lg dark:focus:ring-transparent
                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
          wire:model.defer="state.bio"
>
    {{ $slot }}
</textarea>

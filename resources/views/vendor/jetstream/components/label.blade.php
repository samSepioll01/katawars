@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-violet-700 dark:text-slate-100 tracking-wide']) }}>
    {{ $value ?? $slot }}
</label>

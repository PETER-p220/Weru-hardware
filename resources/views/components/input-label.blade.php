@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm md:text-base text-gray-800']) }}>
    {{ $value ?? $slot }}
</label>

@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm text-sm md:text-base']) }}>

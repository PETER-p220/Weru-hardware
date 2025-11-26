<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-3 md:px-4 py-2 md:py-2.5 bg-white border border-gray-300 rounded-md font-semibold text-sm md:text-base text-gray-700 tracking-wide shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

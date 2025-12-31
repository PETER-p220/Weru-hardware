<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-3 md:px-4 py-2 md:py-2.5 bg-primary-700 border border-transparent rounded-md font-semibold text-sm md:text-base text-white tracking-wide hover:bg-primary-600 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

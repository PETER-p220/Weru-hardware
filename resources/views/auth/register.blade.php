{{-- resources/views/auth/register.blade.php --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ showRole: false }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="John Doe"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="tel" :value="__('Phone Number (TZ)')" />
            <div class="flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    +255
                </span>
                <x-text-input
                    id="tel"
                    class="rounded-l-none block w-full"
                    type="text"
                    name="tel"
                    :value="old('tel')"
                    required
                    autocomplete="tel"
                    placeholder="712 345 678"
                    x-mask="999 999 999"
                />
            </div>
            <p class="mt-1 text-xs text-gray-500">Format: 712 345 678</p>
            <x-input-error :messages="$errors->get('tel')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection (Admin Toggle – Optional) -->
        @if(config('app.debug') || auth()->check()) {{-- Show only in dev or to admins --}}
            <div class="mt-4" x-show="showRole">
                <x-input-label for="role" :value="__('Account Type')" />
                <select
                    id="role"
                    name="role"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="user" selected>Regular User</option>
                    <option value="admin">Administrator</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            <div class="mt-2 text-right">
                <button type="button" @click="showRole = !showRole" class="text-xs text-indigo-600 hover:text-indigo-500">
                    <span x-show="!showRole">Show advanced options</span>
                    <span x-show="showRole">Hide</span>
                </button>
            </div>
        @else
            <input type="hidden" name="role" value="user">
        @endif

        <!-- Submit -->
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
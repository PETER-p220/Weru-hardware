<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in • Weru Hardware Tanzania</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-gradient-to-br from-orange-50 via-white to-orange-50">

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="flex justify-center">
            <div class="relative">
                <div class="w-24 h-24 bg-gradient-to-br from-primary to-primary-dark rounded-3xl shadow-2xl flex items-center justify-center transform hover:scale-105 transition">
                    <i class="fa-solid fa-hard-hat text-white text-4xl"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-yellow-400 rounded-full shadow-lg flex items-center justify-center">
                    <span class="text-xs font-black text-gray-900">TZ</span>
                </div>
            </div>
        </div>

        <h2 class="mt-10 text-center text-4xl font-black tracking-tight text-gray-900">
            Welcome Back!
        </h2>
        <p class="mt-3 text-center text-lg text-gray-600 font-medium">
            Sign in to your <span class="text-primary">Weru Hardware</span> account
        </p>
    </div>

    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-12 px-8 shadow-2xl rounded-3xl border border-orange-100">

            <!-- Success / Info Message -->
            @if (session('status'))
                <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-7">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-800">
                        Email Address
                    </label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus
                               value="{{ old('email') }}"
                               class="block w-full rounded-2xl border px-5 py-4 text-gray-900 placeholder-gray-400 shadow-inner focus:ring-4 focus:ring-primary/20 focus:border-primary transition {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-800">
                        Password
                    </label>
                    <div class="mt-2 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full rounded-2xl border px-5 py-4 pr-14 text-gray-900 placeholder-gray-400 shadow-inner focus:ring-4 focus:ring-primary/20 focus:border-primary transition {{ $errors->has('password') || $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                        
                        <button type="button" onclick="togglePasswordVisibility()"
                                class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-500 hover:text-primary transition">
                            <svg id="eye-open" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @elseif($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600 font-medium">Wrong email or password. Try again.</p>
                    @enderror
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <label for="remember" class="ml-3 block text-sm font-semibold text-gray-700">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm font-bold text-primary hover:text-primary-dark transition">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full flex justify-center py-5 px-4 rounded-2xl shadow-2xl text-lg font-black text-white bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-red-600 focus:outline-none focus:ring-4 focus:ring-primary/30 transition-all transform hover:scale-[1.02] active:scale-100">
                        Sign In Now
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-10">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-orange-100"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-6 bg-white text-gray-500 font-bold">New here?</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-base text-gray-700">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                       class="font-black text-primary hover:text-primary-dark text-lg transition">
                        Create Free Account
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-center">
            <p class="text-sm text-gray-600 font-medium">
                © {{ date('Y') }} <span class="text-primary font-black">Weru Hardware</span> Tanzania
            </p>
            <p class="text-xs text-gray-500 mt-2">
                Your trusted building materials partner in Dar es Salaam & beyond
            </p>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        if (password.type === 'password') {
            password.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            password.type = 'password';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
    }
</script>

<!-- Font Awesome for hard hat icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html>
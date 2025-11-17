<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Weru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 antialiased">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                <p class="text-gray-600">Sign in to your Weru Hardware account</p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
                
                <!-- Session Status (Success Messages) -->
                <div id="sessionStatus" class="hidden mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    <!-- Success message will appear here -->
                </div>

                <!-- Error Messages -->
                <div id="errorMessages" class="hidden mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside text-sm" id="errorList">
                        <!-- Errors will appear here -->
                    </ul>
                </div>

                <form method="POST" action="#" id="loginForm">
                    
                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="you@example.com">
                        <p id="emailError" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-10"
                                placeholder="••••••••">
                            <button 
                                type="button" 
                                onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p id="passwordError" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login Buttons (Optional) -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </button>
                    
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{route('register')}}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            Sign up for free
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    By signing in, you agree to our 
                    <a href="#" class="text-blue-600 hover:text-blue-700">Terms of Service</a> 
                    and 
                    <a href="#" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form submission handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            document.getElementById('errorMessages').classList.add('hidden');
            document.getElementById('emailError').classList.add('hidden');
            document.getElementById('passwordError').classList.add('hidden');
            
            // Get form data
            const formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                remember: document.getElementById('remember_me').checked
            };
            
            // Basic validation
            let hasError = false;
            
            if (!formData.email || !formData.email.includes('@')) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                document.getElementById('emailError').classList.remove('hidden');
                hasError = true;
            }
            
            if (!formData.password || formData.password.length < 6) {
                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters';
                document.getElementById('passwordError').classList.remove('hidden');
                hasError = true;
            }
            
            if (hasError) return;
            
            // In production, send to server
            console.log('Login data:', formData);
            
            // Simulate successful login
            alert('Login successful! (This is a demo)');
            
            // In production, redirect after successful login:
            // window.location.href = '/dashboard';
        });
    </script>

</body>
</html>
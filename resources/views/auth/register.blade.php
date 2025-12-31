<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oweru Hardware - Register Account</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'primary': '#d97706', // amber-600 (Weru Hardware primary color)
                    }
                }
            }
        }
    </script>
    <style>
        /* Base input styling */
        .custom-input {
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: 0.375rem; /* rounded-md */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            padding: 0.65rem 0.85rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .custom-input:focus {
            border-color: #f97316; /* primary color */
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.25); /* primary ring */
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white p-8 sm:p-10 rounded-xl shadow-2xl border border-gray-100">

            <div class="text-center mb-10">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <span class="text-3xl font-extrabold text-gray-900">Oweru<span class="text-primary">Hardware</span></span>
                </div>
                <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">
                    Create Your Account
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Join us for your next building project.
                </p>
            </div>

            <!-- Form -->
            <form action="/register" method="POST" x-data="{ showRole: false, errors: {} }">
                @csrf
                
                <!-- Display general errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Full Name</label>
                    <input
                        id="name"
                        class="custom-input block mt-1 w-full @error('name') border-red-500 @enderror"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="John Doe"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>
                    <input
                        id="email"
                        class="custom-input block mt-1 w-full @error('email') border-red-500 @enderror"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="you@example.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mt-4">
                    <label for="tel" class="block font-medium text-sm text-gray-700 mb-1">Phone Number (TZ)</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 text-sm text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                            +255
                        </span>
                        <input
                            id="tel"
                            class="custom-input rounded-l-none block w-full @error('tel') border-red-500 @enderror"
                            type="text"
                            name="tel"
                            value="{{ old('tel') }}"
                            required
                            placeholder="712345678"
                            maxlength="11"
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Format: 712345678 or 712 345 678 (9 digits)</p>
                    @error('tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        class="custom-input block mt-1 w-full @error('password') border-red-500 @enderror"
                        type="password"
                        name="password"
                        required
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700 mb-1">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        class="custom-input block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                </div>
                <input type="hidden" name="role" value="user">
                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                        href="/login">
                        Already registered?
                    </a>

                    <button type="submit" class="ms-4 inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weru Hardware - Register Account</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js and Alpine Mask for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'primary': '#f97316', // orange-600 (Weru Hardware primary color)
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
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-gray-900">Weru<span class="text-primary">Hardware</span></span>
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
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Full Name</label>
                    <input
                        id="name"
                        class="custom-input block mt-1 w-full"
                        type="text"
                        name="name"
                        required
                        autofocus
                        placeholder="John Doe"
                    />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>
                    <input
                        id="email"
                        class="custom-input block mt-1 w-full"
                        type="email"
                        name="email"
                        required
                        placeholder="you@example.com"
                    />
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
                            class="custom-input rounded-l-none block w-full"
                            type="text"
                            name="tel"
                            required
                            placeholder="712 345 678"
                            x-mask="999 999 999"
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Format: 712 345 678</p>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        class="custom-input block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                    />
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

                <!-- Role Selection (Advanced/Admin Toggle) -->
                <!-- Note: This would typically be secured server-side, this is just for UI demonstration -->
                <div class="mt-4 border-t pt-4 border-gray-200">
                    <div x-show="showRole" x-collapse.duration.500ms>
                        <label for="role" class="block font-medium text-sm text-gray-700 mb-1">Account Type (Advanced Option)</label>
                        <select
                            id="role"
                            name="role"
                            class="custom-input block mt-1 w-full"
                        >
                            <option value="user" selected>Regular Customer/User</option>
                            <option value="admin">Administrator (Restricted Access)</option>
                        </select>
                    </div>

                    <div class="mt-2 text-right">
                        <button type="button" @click="showRole = !showRole" class="text-xs text-primary hover:text-orange-700 font-semibold transition">
                            <span x-show="!showRole">Show account settings</span>
                            <span x-show="showRole">Hide account settings</span>
                        </button>
                    </div>
                    <input type="hidden" x-show="!showRole" name="role" value="user">
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                        href="/login">
                        Already registered?
                    </a>

                    <button type="submit" class="ms-4 inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
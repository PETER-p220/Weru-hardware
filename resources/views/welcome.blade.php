<?php
use App\Models\Advertisement;
use App\Models\Categories;
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oweru Hardware Quality Building Materials in Tanzania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                    },
                    colors: {
                        'primary': '#d97706',
                        'secondary': '#f59e0b',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary: #d97706;
            --secondary: #f59e0b;
            --dark-bg: #0f172a;
            --card-light: #ffffff;
            --card-dark: #1e293b;
            --text-light: #111827;
            --text-dark: #f1f5f9;
            --muted-light: #4b5563;
            --muted-dark: #94a3b8;
            --gray-light: #f3f4f6;
            --gray-dark: #111827;
        }

        html.light {
            --bg-body: var(--gray-light);
            --text-primary: var(--text-light);
            --text-secondary: var(--muted-light);
            --card-bg: var(--card-light);
        }

        html.dark {
            --bg-body: var(--dark-bg);
            --text-primary: var(--text-dark);
            --text-secondary: var(--muted-dark);
            --card-bg: var(--card-dark);
        }

        body {
            background: var(--bg-body);
            color: var(--text-primary);
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('images/hero-construction.jpg') center/cover no-repeat;
        }

        html.dark .hero-bg {
            background: linear-gradient(rgba(15,23,42,0.85), rgba(15,23,42,0.95)), url('images/hero-construction.jpg') center/cover no-repeat;
        }

        .glass-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.15);
        }

        html.dark .glass-card {
            background: rgba(30,41,59,0.7);
            border-color: rgba(218,165,32,0.3);
        }

        .category-card {
            background: var(--card-bg);
            border-color: rgba(218,165,32,0.15);
        }

        html.dark .category-card {
            border-color: rgba(218,165,32,0.35);
        }

        .gradient-text {
            background: linear-gradient(to right, #fde047, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        #theme-toggle-btn {
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        #theme-toggle-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-16px); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="antialiased min-h-screen">

    <!-- Theme Toggle Button -->
    <button id="theme-toggle-btn"
            onclick="toggleDarkMode()"
            class="fixed top-4 right-4 sm:top-6 sm:right-6 z-[9999] w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center rounded-full bg-white/90 dark:bg-slate-800/90 shadow-lg backdrop-blur-sm border border-gray-200 dark:border-slate-600 text-amber-600 dark:text-amber-400 hover:shadow-xl transition-all">
        <i id="theme-icon" class="fa-solid fa-moon text-xl"></i>
    </button>

    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark ? 'dark' : 'light');

            const icon = document.getElementById('theme-icon');
            icon.className = isDark ? 'fa-solid fa-sun text-xl' : 'fa-solid fa-moon text-xl';
        }

        // Load saved or system preference
        (function initTheme() {
            const saved = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
                document.getElementById('theme-icon').className = 'fa-solid fa-sun text-xl';
            }
        })();

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('darkMode')) {
                document.documentElement.classList.toggle('dark', e.matches);
                document.getElementById('theme-icon').className = e.matches ? 'fa-solid fa-sun text-xl' : 'fa-solid fa-moon text-xl';
            }
        });
    </script>

    <!-- Navigation -->
    <nav class="bg-white/95 dark:bg-[#001529]/95 backdrop-blur-lg border-b border-gray-200 dark:border-white/10 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-white">
                            Oweru<span class="text-amber-600">Hardware</span>
                        </span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="/" class="text-amber-600 font-bold transition">Home</a>
                        <a href="/products" class="text-gray-600 dark:text-slate-300 hover:text-amber-600 font-medium transition">Products</a>
                        <a href="/about" class="text-gray-600 dark:text-slate-300 hover:text-amber-600 font-medium transition">About Us</a>
                        <a href="/contactUs" class="text-gray-600 dark:text-slate-300 hover:text-amber-600 font-medium transition">Contact</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/login" class="text-white font-semibold bg-amber-600 px-4 py-2 rounded-lg transition hover:bg-amber-700">
                        Sign In
                    </a>
                    <a href="{{ route('cart') }}" class="relative bg-slate-800 dark:bg-slate-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg hover:shadow-xl transition transform hover:scale-105">
                        <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 bg-amber-400 text-black text-xs font-extrabold rounded-full h-6 w-6 flex items-center justify-center ring-2 ring-white">
                            {{ \App\Models\Cart::current()->totalItems() }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-bg min-h-[90vh] flex items-center justify-center text-white relative py-20">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="mb-10 animate-slide-up">
                <div class="inline-flex items-center justify-center glass-card rounded-[3rem] p-6 shadow-2xl">
                    <img src="\images\IMG-20251117-WA0002.jpg" alt="Oweru Hardware Logo" class="h-32 w-auto rounded"/>
                </div>
            </div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight animate-slide-up animation-delay-200">
                Your Trusted Partner for<br>
                <span class="gradient-text text-6xl md:text-8xl">Quality Building Materials</span><br>in Tanzania
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-4xl mx-auto font-light animate-fade-in animation-delay-400">
                Over <strong class="font-extrabold text-white">500+ certified products</strong> – Cement, Steel, Paint, Roofing, Plumbing & more.<br>
                Reliable & Fast Delivery across Dar es Salaam and all regions.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-in animation-delay-600">
                <a href="/products" class="bg-gradient-to-r from-secondary to-amber-600 text-gray-900 px-12 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-amber-500/50 transform hover:scale-105 transition duration-300">
                    Browse Our Full Catalogue <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Advertisements -->
    @php
        $ads = Advertisement::where('is_active', true)->orderBy('sort_order')->get();
    @endphp
    @if($ads->count() > 0)
    <section class="py-20 bg-white dark:bg-gray-900 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Current <span class="text-amber-600">Promotions</span>
                </h2>
                <span class="inline-block px-6 py-2 bg-amber-600 text-white rounded-full font-bold text-sm tracking-wider shadow-lg">
                    DON'T MISS OUT ON GREAT DEALS!
                </span>
            </div>
            <div class="swiper mySwiper rounded-3xl shadow-2xl overflow-hidden border-4 border-white/50 dark:border-gray-800" id="ad-slider">
                <div class="swiper-wrapper">
                    @foreach($ads as $ad)
                    <div class="swiper-slide relative group cursor-pointer">
                        @if($ad->media_type === 'video')
                            <video autoplay muted loop playsinline class="w-full h-96 md:h-[560px] object-cover brightness-90 group-hover:brightness-100 transition duration-500">
                                <source src="{{ Storage::url($ad->media_path) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ Storage::url($ad->media_path) }}" alt="{{ $ad->title }}" class="w-full h-96 md:h-[560px] object-cover brightness-90 group-hover:brightness-100 transition duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex items-end">
                            <div class="p-8 md:p-16 max-w-4xl text-white transform translate-y-6 group-hover:translate-y-0 transition-all duration-500">
                                @if($ad->title)
                                    <h2 class="text-4xl md:text-6xl font-black mb-4 drop-shadow-2xl">{{ $ad->title }}</h2>
                                @endif
                                @if($ad->description)
                                    <p class="text-lg md:text-2xl mb-8 opacity-95 drop-shadow-lg font-medium">{{ $ad->description }}</p>
                                @endif
                                @if($ad->link)
                                    <a href="{{ $ad->link }}" class="inline-flex items-center gap-4 bg-amber-600 hover:bg-amber-700 px-10 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-amber-600/50 transform hover:scale-105 transition duration-300">
                                        Shop This Offer Now
                                        <i class="fa-solid fa-bolt text-amber-300"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next text-white/90 hover:text-secondary drop-shadow-2xl after:text-4xl"></div>
                <div class="swiper-button-prev text-white/90 hover:text-secondary drop-shadow-2xl after:text-4xl"></div>
                <div class="swiper-pagination !bottom-6"></div>
            </div>
        </div>
    </section>
    @endif

    <!-- Categories -->
    @php
        $categories = Categories::orderBy('order')->get();
    @endphp
    <section id="categories" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                Explore Our <span class="text-amber-600">Top Categories</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-12 max-w-3xl mx-auto">
                Find exactly what you need for your construction project. Quality assured, from foundation to finish.
            </p>
            @if($categories->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <a href="/products?cat={{ $category->slug }}" 
                           class="category-card block rounded-2xl p-6 shadow-lg hover:border-amber-600/50 transition duration-300 group border border-gray-200 dark:border-gray-700">
                            <div class="w-14 h-14 mb-3 mx-auto bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center text-2xl group-hover:bg-amber-600 group-hover:text-white transition duration-300">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-3">{{ Str::limit($category->description, 60) }}</p>
                            @endif
                            <span class="inline-block text-sm text-amber-600 dark:text-amber-400 font-semibold group-hover:text-amber-700 dark:group-hover:text-amber-300">
                                View Products →
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-lg py-10">No categories available at the moment.</p>
            @endif
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-gray-900 text-white" id="about">
        <div class="max-w-7xl mx-auto px-6">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0">
                    <span class="inline-block px-6 py-2 bg-secondary text-gray-900 rounded-full font-bold text-sm tracking-wider mb-4">OUR PROMISE</span>
                    <h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight">
                        Why Developers and Builders <span class="text-amber-400">Choose Oweru Hardware</span>
                    </h2>
                    <p class="text-lg text-gray-300 mb-8">
                        We understand the demands of construction in Tanzania. We provide more than just materials — we deliver reliability, competitive pricing, and local expertise.
                    </p>
                    <a href="/contactUs" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg transform hover:scale-[1.02] transition duration-300">
                        Start Your Project Today <i class="fa-solid fa-truck-fast ml-2"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-certificate text-amber-400 text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Certified Quality</h3>
                        <p class="text-gray-400">All products meet TZS & ISO standards</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-tag text-amber-400 text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                        <p class="text-gray-400">Direct from manufacturers — no middlemen</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-amber-400">
                        <i class="fa-solid fa-map-location-dot text-amber-400 text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Nationwide Delivery</h3>
                        <p class="text-gray-400">Same-day in Dar, 1–3 days nationwide</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-amber-400">
                        <i class="fa-solid fa-headset text-amber-400 text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Expert Support</h3>
                        <p class="text-gray-400">Free quantity estimation & consultation</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800" id="contact">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Get In <span class="text-amber-600">Touch</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Have a question or need a quote? We're here to help!
                </p>
            </div>
            <div class="grid lg:grid-cols-2 gap-12">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                        Contact Information
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-xl hover:bg-orange-100 dark:hover:bg-orange-900/30 transition">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 dark:text-white block mb-1">Our Location</strong>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Tancot House, Posta-Dar es Salaam<br>
                                    Tanzania<br>
                                    P.O. Box: 7563, Dar es Salaam
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 transition">
                            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 dark:text-white block mb-1">Phone</strong>
                                <p class="text-gray-600 dark:text-gray-400">+255 711 890 764</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 transition">
                            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 dark:text-white block mb-1">Email</strong>
                                <a href="mailto:info@oweru.com" class="text-gray-600 dark:text-gray-400 hover:text-amber-600">info@oweru.com</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 transition">
                            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 dark:text-white block mb-1">Business Hours</strong>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Monday - Saturday: 8:00 AM - 17:00 PM<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send Us a Message</h3>

                    @if(session('success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-200 px-4 py-3 flex items-start gap-3">
                            <i class="fa-solid fa-check-circle mt-0.5"></i>
                            <span class="flex-1 text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-4 py-3">
                            <p class="font-semibold text-sm mb-2">Please fix the errors below:</p>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-6" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Your name"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-600 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="your@email.com"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-600 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+255 XXX XXX XXX"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-600 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                            <select id="subject" name="subject" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-600 focus:outline-none transition bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select a subject</option>
                                <option value="Request a Quote" {{ old('subject') === 'Request a Quote' ? 'selected' : '' }}>Request a Quote</option>
                                <option value="Product Inquiry" {{ old('subject') === 'Product Inquiry' ? 'selected' : '' }}>Product Inquiry</option>
                                <option value="Delivery Question" {{ old('subject') === 'Delivery Question' ? 'selected' : '' }}>Delivery Question</option>
                                <option value="Customer Support" {{ old('subject') === 'Customer Support' ? 'selected' : '' }}>Customer Support</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Message *</label>
                            <textarea id="message" name="message" required placeholder="Tell us about your project or inquiry..." rows="5"
                                      class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-600 focus:outline-none transition resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]">
                            Send Message <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold">Oweru<span class="text-amber-500">Hardware</span></span>
                    </div>
                    <p class="text-gray-400 dark:text-gray-500 mb-6">
                        Your trusted partner for quality building materials in Tanzania. We deliver excellence from foundation to finish.
                    </p>
                    <div class="mb-4">
                        <h4 class="text-sm font-bold text-amber-500 mb-3 uppercase tracking-wider">Follow Us</h4>
                        <div class="flex gap-3">
                            <a href="https://facebook.com/oweruinternational" target="_blank" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="https://instagram.com/oweru.official" target="_blank" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-pink-600 transition">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="https://linkedin.com/company/oweruinternational" target="_blank" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-700 transition">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                            <a href="https://wa.me/255711890764" target="_blank" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-500 transition">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-amber-500">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Home</a></li>
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Products</a></li>
                        <li><a href="/about" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> About Us</a></li>
                        <li><a href="/contactUs" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-amber-500">Product Categories</h3>
                    <ul class="space-y-3">
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Cement & Concrete</a></li>
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Steel & Iron</a></li>
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Paints & Coatings</a></li>
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Roofing Materials</a></li>
                        <li><a href="/products" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Plumbing Supplies</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-amber-500">Customer Service</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Delivery Information</a></li>
                        <li><a href="#" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Returns Policy</a></li>
                        <li><a href="#" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Terms & Conditions</a></li>
                        <li><a href="/privacy" class="text-gray-400 dark:text-gray-500 hover:text-amber-500 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-800 dark:border-gray-700 my-8">

            <div class="text-center md:flex md:items-center md:justify-between">
                <p class="text-gray-500 dark:text-gray-400 text-sm">© {{ date('Y') }} Oweru Hardware. All rights reserved.</p>
                <div class="flex justify-center mt-4 md:mt-0 space-x-6">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-amber-500 text-sm transition">Legal</a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-amber-500 text-sm transition">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Swiper for ads
        if (document.getElementById('ad-slider')) {
            new Swiper("#ad-slider", {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: ".swiper-pagination", clickable: true },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }
    </script>
</body>
</html>
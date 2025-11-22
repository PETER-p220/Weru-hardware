<?php
use App\Models\Advertisement;
use App\Models\Categories;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weru Hardware – Quality Building Materials in Tanzania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                    },
                    colors: {
                        'primary': '#f97316',   // orange-600
                        'secondary': '#fbbf24', // amber-400
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-16px); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('images/hero-construction.jpg') center/cover no-repeat;
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 15% 45%, rgba(251, 191, 36, 0.25) 0%, transparent 60%),
                        radial-gradient(circle at 85% 75%, rgba(249, 115, 22, 0.2) 0%, transparent 60%);
            animation: float 20s ease-in-out infinite;
        }

        .glass-card { background: rgba(255,255,255,0.1); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.15); }
        .gradient-text { background: linear-gradient(to right, #fde047, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .category-card { transition: all 0.3s ease; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-white/95 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-gray-900">Weru<span class="text-primary">Hardware</span></span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="/" class="text-primary font-bold transition">Home</a>
                        <a href="/indexCategory" class="text-gray-600 hover:text-primary font-medium transition">Categories</a>
                        <a href="/products" class="text-gray-600 hover:text-primary font-medium transition">Products</a>
                        <a href="#about" class="text-gray-600 hover:text-primary font-medium transition">About Us</a>
                        <a href="#contact" class="text-gray-600 hover:text-primary font-medium transition">Contact</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/login" class="hidden lg:block text-primary font-semibold hover:bg-orange-50 px-4 py-2 rounded-lg transition">Sign In</a>
                    <a href="/cart" class="relative bg-gradient-to-r from-primary to-orange-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg hover:shadow-xl transition transform hover:scale-105">
                        <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                        Cart <span class="absolute -top-2 -right-2 bg-secondary text-black text-xs font-extrabold rounded-full h-6 w-6 flex items-center justify-center ring-2 ring-white">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-bg min-h-[90vh] flex items-center justify-center text-white relative py-20">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="mb-10 animate-slide-up">
                <div class="inline-flex items-center justify-center glass-card rounded-[3rem] p-6 shadow-2xl">
                    <img src="images/IMG-20251114-WA0007.jpg" alt="Weru Hardware Logo" class="h-32 w-auto object-contain"/>
                </div>
            </div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight animate-slide-up animation-delay-200">
                Your Trusted Partner for<br>
                <span class="gradient-text text-6xl md:text-8xl">Quality Building Materials</span><br>in Tanzania
            </h1>
            <p class="text-xl md:text-2xl text-orange-100 mb-12 max-w-4xl mx-auto font-light animate-fade-in animation-delay-400">
                Over <strong class="font-extrabold text-white">500+ certified products</strong> – Cement, Steel, Paint, Roofing, Plumbing & more.<br>
                Reliable & Fast Delivery across Dar es Salaam and all regions.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-in animation-delay-600">
                <a href="/products" class="bg-gradient-to-r from-secondary to-yellow-600 text-gray-900 px-12 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-yellow-500/50 transform hover:scale-105 transition duration-300">
                    Browse Our Full Catalogue <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
                <a href="#contact" class="bg-white/20 backdrop-blur-md border-2 border-white/40 text-white px-12 py-5 rounded-xl font-bold text-xl hover:bg-white/30 transition duration-300">
                    Get a Project Quote <i class="fa-solid fa-calculator ml-2"></i>
                </a>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    @php
        $ads = Advertisement::where('is_active', true)->orderBy('sort_order')->get();
    @endphp

    @if($ads->count() > 0)
    <section class="py-20 bg-gradient-to-br from-orange-50 via-yellow-50 to-amber-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-extrabold text-gray-900 mb-4">Current <span class="text-primary">Promotions</span></h2>
                <span class="inline-block px-6 py-2 bg-primary text-white rounded-full font-bold text-sm tracking-wider shadow-lg">DON'T MISS OUT ON GREAT DEALS!</span>
            </div>

            <div class="swiper mySwiper rounded-3xl shadow-2xl overflow-hidden border-4 border-white/50" id="ad-slider">
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
                                    <a href="{{ $ad->link }}" class="inline-flex items-center gap-4 bg-primary hover:bg-orange-700 px-10 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-primary/50 transform hover:scale-105 transition duration-300">
                                        Shop This Offer Now
                                        <i class="fa-solid fa-bolt text-secondary"></i>
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
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

    @php
        $categories = Categories::orderBy('order')->get();
    @endphp

    <section id="categories" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Explore Our <span class="text-primary">Top Categories</span>
            </h2>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">
                Find exactly what you need for your construction project. Quality assured, from foundation to finish.
            </p>

            @if($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <a href="/products?cat={{ $category->slug }}" 
                           class="category-card block bg-white border border-gray-100 rounded-2xl p-8 shadow-lg hover:border-primary/50 transition duration-300 group">
                            <div class="w-16 h-16 mb-4 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition duration-300">
                                <i class="{{ $category->icon }}">{{ $category->icon }}</i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-gray-500 font-medium">{{ Str::limit($category->description, 80) }}</p>
                            @endif
                            <span class="mt-4 inline-block text-primary font-semibold group-hover:text-orange-700">
                                View Products &rarr;
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-lg py-10">No categories available at the moment.</p>
            @endif
        </div>
    </section>

    <section class="py-20 bg-gray-900 text-white" id="about">
        <div class="max-w-7xl mx-auto px-6">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0">
                    <span class="inline-block px-6 py-2 bg-secondary text-gray-900 rounded-full font-bold text-sm tracking-wider mb-4">OUR PROMISE</span>
                    <h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight">
                        Why Developers and Builders <span class="text-primary">Choose Weru Hardware</span>
                    </h2>
                    <p class="text-lg text-gray-300 mb-8">
                        We understand the demands of construction in Tanzania. We provide more than just materials — we deliver reliability, competitive pricing, and local expertise.
                    </p>
                    <a href="#contact" class="bg-primary hover:bg-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg transform hover:scale-[1.02] transition duration-300">
                        Start Your Project Today <i class="fa-solid fa-truck-fast ml-2"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-certificate text-secondary text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Certified Quality</h3>
                        <p class="text-gray-400">All products meet TZS & ISO standards</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-tag text-secondary text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                        <p class="text-gray-400">Direct from manufacturers — no middlemen</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-map-location-dot text-secondary text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Nationwide Delivery</h3>
                        <p class="text-gray-400">Same-day in Dar, 1–3 days nationwide</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl shadow-xl border-l-4 border-primary">
                        <i class="fa-solid fa-headset text-secondary text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Expert Support</h3>
                        <p class="text-gray-400">Free quantity estimation & consultation</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100" id="contact">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Get In <span class="text-primary">Touch</span></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Have a question or need a quote? We're here to help!</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-12">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-address-book text-white"></i>
                        </div>
                        Contact Information
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 block mb-1">Our Location</strong>
                                <p class="text-gray-600">Kisutu Street, Dar es Salaam<br>Tanzania</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 block mb-1">Phone</strong>
                                <p class="text-gray-600">+255 123 456 789<br>+255 987 654 321</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 block mb-1">Email</strong>
                                <p class="text-gray-600">info@weruhardware.co.tz<br>sales@weruhardware.co.tz</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 block mb-1">Business Hours</strong>
                                <p class="text-gray-600">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 8:00 AM - 4:00 PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h3>
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                            <input type="text" id="name" required placeholder="Your name" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" required placeholder="your@email.com" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" placeholder="+255 XXX XXX XXX" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                            <select id="subject" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition">
                                <option value="">Select a subject</option>
                                <option value="quote">Request a Quote</option>
                                <option value="product">Product Inquiry</option>
                                <option value="delivery">Delivery Question</option>
                                <option value="support">Customer Support</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                            <textarea id="message" required placeholder="Tell us about your project or inquiry..." rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-primary to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]">
                            Send Message <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold">Weru<span class="text-primary">Hardware</span></span>
                    </div>
                    <p class="text-gray-400 mb-6">Your trusted partner for quality building materials in Tanzania. We deliver excellence from foundation to finish.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-primary">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Home</a></li>
                        <li><a href="category" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Categories</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Products</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> About Us</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-primary">Product Categories</h3>
                    <ul class="space-y-3">
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Cement & Concrete</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Steel & Iron</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Paints & Coatings</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Roofing Materials</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Plumbing Supplies</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Electrical Supplies</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-primary">Customer Service</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Delivery Information</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Returns Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-800 my-8">

            <div class="text-center md:flex md:items-center md:justify-between">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Weru Hardware. All rights reserved.</p>
                <div class="flex justify-center mt-4 md:mt-0 space-x-6">
                    <a href="#" class="text-gray-500 hover:text-primary text-sm">Legal</a>
                    <a href="#" class="text-gray-500 hover:text-primary text-sm">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper for the advertisements slider
        if (document.getElementById('ad-slider')) {
            new Swiper("#ad-slider", {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }
    </script>
</body>
</html>
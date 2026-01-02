<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Oweru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Prevent theme flicker -->
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'light' || (!saved && window.matchMedia('(prefers-color-scheme: light)').matches)) {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#DAA520',
                            goldhover: '#B8860B',
                            dark: '#001529',
                            midnight: '#0b0f1a'
                        }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }

        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                icon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                icon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
            }
        }

        window.addEventListener('load', () => {
            const icon = document.getElementById('theme-icon');
            if (document.documentElement.classList.contains('dark')) {
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    </script>

    <style>
        body { transition: background-color 0.4s ease, color 0.4s ease; }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }
        .dark .glass-card {
            background: rgba(0, 21, 41, 0.45);
            border-color: rgba(218, 165, 32, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .contact-item {
            transition: all 0.3s ease;
        }
        .contact-item:hover {
            transform: translateY(-4px);
            background: rgba(255, 165, 0, 0.08);
        }
        .dark .contact-item:hover {
            background: rgba(218, 165, 32, 0.15);
        }

        .form-input {
            @apply w-full px-5 py-4 bg-white dark:bg-white/5 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/30 transition;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-brand-midnight text-slate-900 dark:text-slate-200 min-h-screen">

    <!-- Header -->
    <header class="bg-white/90 dark:bg-brand-dark/90 backdrop-blur-lg border-b border-gray-200 dark:border-white/10 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-4 group">
                    <div class="w-11 h-11 bg-brand-gold rounded-xl flex items-center justify-center shadow-xl shadow-brand-gold/40 transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-hard-hat text-brand-dark text-2xl"></i>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        OWERU<span class="text-brand-gold">HARDWARE</span>
                    </span>
                </a>

                <div class="flex items-center gap-8">
                    <nav class="hidden md:flex items-center gap-10">
                        <a href="/products" class="text-slate-600 dark:text-slate-400 hover:text-brand-gold transition font-medium">Products</a>
                        <a href="/about" class="text-slate-600 dark:text-slate-400 hover:text-brand-gold transition font-medium">About</a>
                        <a href="/contact" class="text-brand-gold font-bold border-b-2 border-brand-gold pb-1">Contact</a>
                    </nav>

                    <button onclick="toggleTheme()" class="w-11 h-11 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center hover:bg-brand-gold hover:text-brand-dark transition-all shadow-md">
                        <i id="theme-icon" class="fa-solid fa-moon text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative py-24 lg:py-32 overflow-hidden bg-gradient-to-br from-slate-50 to-gray-100 dark:from-brand-midnight dark:to-brand-dark">
        <div class="absolute inset-0 bg-gradient-to-tr from-brand-gold/5 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl lg:text-7xl font-black mb-6 leading-tight">
                Get In <span class="text-brand-gold">Touch</span>
            </h1>
            <p class="text-xl lg:text-2xl text-slate-600 dark:text-slate-400 max-w-4xl mx-auto leading-relaxed">
                Have a question or need a quote? Our Tanzania team is ready to assist you with expert advice and fast responses.
            </p>
        </div>
    </section>

    <!-- Main Contact Section -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid lg:grid-cols-2 gap-16 items-start">

            <!-- Contact Information -->
            <div class="space-y-12">
                <div>
                    <h2 class="text-4xl font-black mb-10 text-slate-900 dark:text-white">Contact Information</h2>
                    <div class="space-y-6">

                        <div class="contact-item glass-card rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="w-14 h-14 bg-brand-gold/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-location-dot text-brand-gold text-2xl"></i>
                                </div>
                                <div>
                                    <strong class="text-lg font-bold block mb-2 text-slate-900 dark:text-white">Our Location</strong>
                                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                        Tancot House, Posta<br>
                                        Dar es Salaam, Tanzania<br>
                                        P.O. Box 7563, Dar es Salaam
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item glass-card rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="w-14 h-14 bg-green-500/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-phone text-green-600 dark:text-green-400 text-2xl"></i>
                                </div>
                                <div>
                                    <strong class="text-lg font-bold block mb-2 text-slate-900 dark:text-white">Phone</strong>
                                    <a href="tel:+255711890764" class="text-2xl font-black text-brand-gold hover:text-brand-goldhover transition">+255 711 890 764</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item glass-card rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="w-14 h-14 bg-blue-500/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-envelope text-blue-600 dark:text-blue-400 text-2xl"></i>
                                </div>
                                <div>
                                    <strong class="text-lg font-bold block mb-2 text-slate-900 dark:text-white">Email</strong>
                                    <a href="mailto:info@oweru.com" class="text-xl font-bold text-brand-gold hover:text-brand-goldhover transition">info@oweru.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item glass-card rounded-2xl p-6">
                            <div class="flex items-start gap-5">
                                <div class="w-14 h-14 bg-purple-500/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-clock text-purple-600 dark:text-purple-400 text-2xl"></i>
                                </div>
                                <div>
                                    <strong class="text-lg font-bold block mb-2 text-slate-900 dark:text-white">Business Hours</strong>
                                    <p class="text-slate-600 dark:text-slate-400">
                                        Monday - Saturday: 8:00 AM - 5:00 PM<br>
                                        <span class="text-brand-gold font-semibold">Sunday: Closed</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <div class="glass-card rounded-3xl p-10 lg:p-14 shadow-2xl">
                    <h2 class="text-4xl font-black mb-10 text-slate-900 dark:text-white">Send Us a Message</h2>

                    <!-- Success Message -->
                    <!-- Replace with real session logic in Laravel -->
                    <!-- <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 dark:bg-green-950/20 text-green-800 dark:text-green-400 px-6 py-4 flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-2xl"></i>
                        <span class="font-bold">Your message has been sent successfully!</span>
                    </div> -->

                    <form class="space-y-12" method="POST" action="#">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 mb-3">Full Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Your full name" class="form-input">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 mb-3">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.co.tz" class="form-input">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 mb-3">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+255 ..." class="form-input">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 mb-3">Subject *</label>
                            <select id="subject" name="subject" required class="form-input">
                                <option value="">Choose a subject</option>
                                <option>Request a Quote</option>
                                <option>Product Inquiry</option>
                                <option>Delivery Question</option>
                                <option>Technical Support</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold uppercase tracking-widest text-gray-100 dark:text-slate-400 mb-3">Your Message *</label>
                            <textarea id="message" name="message" required rows="6" placeholder="Tell us how we can help you..." class="form-input resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-brand-gold to-brand-goldhover text-brand-dark font-black uppercase tracking-widest py-5 rounded-xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all text-lg">
                            Send Message <i class="fa-solid fa-paper-plane ml-3"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-brand-dark border-t border-gray-200 dark:border-white/10 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-8">
                <p class="text-3xl font-black text-slate-900 dark:text-white mb-2">
                    OWERU <span class="text-brand-gold">HARDWARE</span>
                </p>
                <p class="text-slate-600 dark:text-slate-400 text-lg">Premium Building Materials • Tanzania</p>
            </div>

            <div class="flex justify-center gap-8 mb-10">
                <a href="https://www.instagram.com/oweru.Official" class="text-slate-500 dark:text-slate-400 hover:text-brand-gold transition text-2xl">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/oweruinternational" class="text-slate-500 dark:text-slate-400 hover:text-brand-gold transition text-2xl">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.linkedin.com/company/oweruInternational" class="text-slate-500 dark:text-slate-400 hover:text-brand-gold transition text-2xl">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </div>

            <p class="text-sm text-slate-500 dark:text-slate-500 font-medium">
                &copy; {{ date('Y') }} Oweru Hardware. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
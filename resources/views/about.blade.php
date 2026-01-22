<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Oweru Real Estate & Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { gold: '#DAA520', dark: '#001529', slate: '#0F172A' }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .hero-mask {
            background: linear-gradient(rgba(0, 21, 41, 0.7), rgba(0, 21, 41, 0.85)), 
                        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-white dark:bg-[#0b0f1a] text-slate-700 dark:text-slate-200 antialiased transition-colors duration-300">
<nav class="bg-white/95 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-extrabold text-gray-900">Oweru<span class="text-amber-600">Hardware</span></span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="/" class="text-amber-600 font-bold transition">Home</a>
                        <a href="/products" class="text-gray-600 hover:text-amber-600 font-medium transition">Products</a>
                        <a href="/about" class="text-gray-600 hover:text-amber-600 font-medium transition">About Us</a>
                        <a href="/contactUs" class="text-gray-600 hover:text-amber-600 font-medium transition">Contact</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Sign In button - now visible on all screen sizes -->
                    <a href="/login" class="text-white font-semibold bg-amber-600 px-4 py-2 rounded-lg transition hover:bg-amber-700">Sign In</a>
                    <a href="/cart" class="relative bg-slate-800 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg hover:shadow-xl transition transform hover:scale-105">
                        <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 bg-amber-400 text-black text-xs font-extrabold rounded-full h-6 w-6 flex items-center justify-center ring-2 ring-white">{{ \App\Models\Cart::current()->totalItems() }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <button onclick="toggleTheme()" class="fixed bottom-6 right-6 z-[100] bg-brand-gold text-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center hover:scale-110 transition-transform">
        <i id="theme-icon" class="fa-solid fa-moon"></i>
    </button>

    <section class="hero-mask pt-32 pb-24 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <span class="text-brand-gold font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Established 2016</span>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">Our Journey & <span class="text-brand-gold">Vision</span></h1>
            <p class="text-slate-300 max-w-2xl mx-auto text-lg">A decade of building trust, transforming landscapes, and creating lifelong partnerships in the property industry.</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 -mt-12 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/10 p-6 rounded-2xl text-center stat-card shadow-xl">
                <p class="text-3xl font-black text-brand-gold">8+</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold mt-1">Years Experience</p>
            </div>
            <div class="bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/10 p-6 rounded-2xl text-center stat-card shadow-xl">
                <p class="text-3xl font-black text-brand-gold">350+</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold mt-1">Expert Employees</p>
            </div>
            <div class="bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/10 p-6 rounded-2xl text-center stat-card shadow-xl">
                <p class="text-3xl font-black text-brand-gold">100+</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold mt-1">Awards Gained</p>
            </div>
            <div class="bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/10 p-6 rounded-2xl text-center stat-card shadow-xl">
                <p class="text-3xl font-black text-brand-gold">2.5K+</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold mt-1">Listing for Sale</p>
            </div>
        </div>
    </div>

    <section class="py-24 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="space-y-4">
                <div class="w-12 h-12 bg-brand-gold/10 flex items-center justify-center rounded-xl mb-6">
                    <i class="fa-solid fa-handshake text-brand-gold text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Creating Lifelong Partnerships</h3>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Fostering trust and strong relationships for long-term success in real estate.</p>
            </div>
            <div class="space-y-4">
                <div class="w-12 h-12 bg-brand-gold/10 flex items-center justify-center rounded-xl mb-6">
                    <i class="fa-solid fa-lightbulb text-brand-gold text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Empowering Real Estate Decisions</h3>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Providing expert insights to help you make confident, informed property choices.</p>
            </div>
            <div class="space-y-4">
                <div class="w-12 h-12 bg-brand-gold/10 flex items-center justify-center rounded-xl mb-6">
                    <i class="fa-solid fa-earth-africa text-brand-gold text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Innovating For A Better Tomorrow</h3>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed">Driving change and sustainable solutions for a brighter, more accessible real estate future.</p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-50 dark:bg-brand-dark/30 border-y border-slate-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative order-2 lg:order-1">
                <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=800&q=80" alt="Team Unity" class="rounded-3xl shadow-2xl transition-all duration-700">
                <div class="absolute -bottom-10 -right-10 hidden lg:block">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=400&q=80" class="w-64 rounded-2xl border-8 border-white dark:border-[#0b0f1a] shadow-2xl" alt="Office">
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-8">Our Story</h2>
                <div class="space-y-6 text-slate-500 dark:text-slate-400 text-lg leading-relaxed">
                    <p>Oweru is proud to be a trusted leader in real estate, offering comprehensive solutions and professional services in the property industry. With over 10 years of experience, we continue to grow and innovate.</p>
                    <p>At Oweru, we are committed to putting clients first, dedicated to helping them find their dream homes or valuable investment opportunities.</p>
                </div>
                <div class="mt-12">
                    <a href="#" class="inline-flex items-center gap-3 bg-brand-gold text-white px-8 py-4 rounded-full font-bold hover:bg-brand-dark transition-colors">
                        Explore Properties <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-4">Meet The Team</h2>
            <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto">The dedicated professionals passionate about guiding you through every step of your real estate journey.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/5 p-4 rounded-3xl hover:border-brand-gold transition-all">
                <div class="aspect-square rounded-2xl overflow-hidden mb-6 bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                </div>
                <h4 class="text-xl font-bold text-slate-900 dark:text-white">Mrs Pendo</h4>
                <p class="text-brand-gold text-sm font-medium mb-4 uppercase ">CEO - Chief Executive Officer</p>
                <a href="https://www.linkedin.com/company/oweruinternational/" class="text-slate-400 hover:text-brand-gold"><i class="fa-brands fa-linkedin text-xl"></i></a>
            </div>
            <div class="group bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/5 p-4 rounded-3xl hover:border-brand-gold transition-all">
                <div class="aspect-square rounded-2xl overflow-hidden mb-6 bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                </div>
                <h4 class="text-xl font-bold text-slate-900 dark:text-white">Rachel Dan</h4>
                <p class="text-brand-gold text-sm font-medium mb-4 uppercase tracking-tighter">CEO - Chief Executive Officer</p>
                <a href="#" class="text-slate-400 hover:text-brand-gold"><i class="fa-brands fa-linkedin text-xl"></i></a>
            </div>
            <div class="group bg-white dark:bg-brand-dark border border-slate-200 dark:border-white/5 p-4 rounded-3xl hover:border-brand-gold transition-all">
                <div class="aspect-square rounded-2xl overflow-hidden mb-6 bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                </div>
                <h4 class="text-xl font-bold text-slate-900 dark:text-white">Rachel Dan</h4>
                <p class="text-brand-gold text-sm font-medium mb-4 uppercase tracking-tighter">Sales Director</p>
                <a href="#" class="text-slate-400 hover:text-brand-gold"><i class="fa-brands fa-linkedin text-xl"></i></a>
            </div>
        </div>
    </section>

    <footer class="bg-white dark:bg-brand-dark py-12 border-t border-slate-200 dark:border-white/5 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <span class="text-2xl font-black text-brand-dark dark:text-white">OWERU</span>
            <div class="flex gap-8 text-sm text-slate-500">
                <a href="#" class="hover:text-brand-gold transition">Terms of Use</a>
                <a href="/privacy" class="hover:text-brand-gold transition">Privacy Policy</a>
            </div>
            <p class="text-sm text-slate-500">© 2026 Oweru. All rights reserved.</p>
        </div>
    </footer>

    <script>
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

        // Apply theme on load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const icon = document.getElementById('theme-icon');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        })();
    </script>
</body>
</html>
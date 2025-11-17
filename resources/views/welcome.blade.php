<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Weru Hardware - Premium Construction Materials & Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        float: 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 },
                        },
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 },
                        },
                    },
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
        }
        .bg-gradient-secondary {
            background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #3b82f6, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-effect {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.1);
        }
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.25);
        }
        .mesh-gradient {
            background: 
                radial-gradient(at 40% 20%, rgba(59, 130, 246, 0.3) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(245, 158, 11, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(139, 92, 246, 0.2) 0px, transparent 50%),
                radial-gradient(at 80% 50%, rgba(239, 68, 68, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(34, 211, 238, 0.2) 0px, transparent 50%),
                radial-gradient(at 80% 100%, rgba(236, 72, 153, 0.2) 0px, transparent 50%);
        }
        .construction-pattern {
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px);
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased construction-pattern">
    
    <!-- Logo Top Left -->
    <div class="absolute top-6 left-6 z-50">
        <img src="/images/logo-dark.png" alt="Weru Hardware Logo" class="h-14 w-auto drop-shadow-xl" />
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-slate-700/50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 rotate-45">
                        <svg class="w-7 h-7 text-white -rotate-45" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.71 11.29l-9-9c-.39-.39-1.02-.39-1.41 0l-9 9c-.39.39-.39 1.02 0 1.41l9 9c.39.39 1.02.39 1.41 0l9-9c.39-.38.39-1.01 0-1.41zM14 14.5V12h-4v3H8v-4c0-.55.45-1 1-1h5V7.5l3.5 3.5-3.5 3.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Weru Hardware</h1>
                        <p class="text-xs text-slate-400">Premium Construction Solutions</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#products" class="text-slate-300 hover:text-white font-medium transition-colors">Products</a>
                    <a href="#services" class="text-slate-300 hover:text-white font-medium transition-colors">Services</a>
                    <a href="#projects" class="text-slate-300 hover:text-white font-medium transition-colors">Projects</a>
                    <a href="#contact" class="text-slate-300 hover:text-white font-medium transition-colors">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-slate-300 hover:text-white font-medium transition-colors">
                        Sign In
                    </a>
                    <a href="/register" class="inline-flex items-center px-6 py-2.5 bg-gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden mesh-gradient">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-slide-up">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></span>
                        <span class="text-sm text-blue-400 font-medium">Trusted by 500+ Construction Companies in Tanzania</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-black mb-6 leading-tight">
                        <span class="text-white">Premium</span>
                        <br/>
                        <span class="text-gradient">Construction Hardware</span>
                        <br/>
                        <span class="text-white">Delivered Fast</span>
                    </h1>
                    
                    <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                        Your one-stop solution for industrial-grade building materials, power tools, safety equipment, and construction machinery across Tanzania.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-8">
                        <a href="catalog" class="group inline-flex items-center px-8 py-4 bg-gradient-primary text-white font-bold rounded-xl shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300">
                            Browse Catalog
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#quote" class="inline-flex items-center px-8 py-4 bg-slate-800 border border-slate-700 text-white font-bold rounded-xl hover:bg-slate-700 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Request Quote
                        </a>
                    </div>

                    <div class="flex items-center space-x-8 text-sm text-slate-400">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            ISO 9001 Certified
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            Same-Day Delivery (DSM)
                        </div>
                    </div>
                </div>

                <div class="relative lg:block animate-fade-in">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <div class="aspect-[4/3] bg-gradient-to-br from-slate-800 to-slate-900 p-8">
                            <div class="grid grid-cols-2 gap-6 h-full">
                                <div class="glass-effect rounded-2xl p-6 hover-lift">
                                    <div class="w-16 h-16 bg-blue-500/20 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H4v-4h4v4zm0-6H4v-4h4v4zm0-6H4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">15,000+</h4>
                                    <p class="text-slate-400 text-sm">Building Materials</p>
                                </div>
                                
                                <div class="glass-effect rounded-2xl p-6 hover-lift">
                                    <div class="w-16 h-16 bg-orange-500/20 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">2,500+</h4>
                                    <p class="text-slate-400 text-sm">Power Tools</p>
                                </div>
                                
                                <div class="glass-effect rounded-2xl p-6 hover-lift">
                                    <div class="w-16 h-16 bg-purple-500/20 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">1,200+</h4>
                                    <p class="text-slate-400 text-sm">Safety Equipment</p>
                                </div>
                                
                                <div class="glass-effect rounded-2xl p-6 hover-lift">
                                    <div class="w-16 h-16 bg-red-500/20 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">24/7</h4>
                                    <p class="text-slate-400 text-sm">Fleet Delivery</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-gradient-primary rounded-full blur-3xl opacity-30 animate-float"></div>
                    <div class="absolute -top-6 -left-6 w-40 h-40 bg-gradient-secondary rounded-full blur-3xl opacity-20 animate-float" style="animation-delay: 3s;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Categories -->
    <section id="products" class="py-24 bg-slate-900/50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
                    Complete Construction Solutions
                </h2>
                <p class="text-xl text-slate-400 max-w-3xl mx-auto">
                    From foundation to finishing, we supply everything your project needs
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Category 1 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Building Materials</h3>
                    <p class="text-slate-400 mb-6">Cement, bricks, blocks, aggregates, reinforcement steel, timber, roofing sheets, and insulation materials.</p>
                    <div class="flex items-center text-blue-400 font-semibold group-hover:text-blue-300">
                        View Products
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Category 2 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Power Tools & Machinery</h3>
                    <p class="text-slate-400 mb-6">Industrial drills, saws, grinders, mixers, excavators, cranes, generators, and welding equipment.</p>
                    <div class="flex items-center text-orange-400 font-semibold group-hover:text-orange-300">
                        View Equipment
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Category 3 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Safety Equipment</h3>
                    <p class="text-slate-400 mb-6">Helmets, harnesses, boots, gloves, eye protection, scaffolding, barriers, and first aid supplies.</p>
                    <div class="flex items-center text-purple-400 font-semibold group-hover:text-purple-300">
                        View Safety Gear
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Category 4 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Electrical & Plumbing</h3>
                    <p class="text-slate-400 mb-6">Cables, switches, fixtures, pipes, fittings, pumps, water tanks, and HVAC systems.</p>
                    <div class="flex items-center text-green-400 font-semibold group-hover:text-green-300">
                        View Products
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Category 5 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM5 10h14v3H5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Finishing Materials</h3>
                    <p class="text-slate-400 mb-6">Paints, tiles, flooring, doors, windows, fixtures, adhesives, and decorative elements.</p>
                    <div class="flex items-center text-red-400 font-semibold group-hover:text-red-300">
                        View Finishes
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Category 6 -->
                <div class="group glass-effect rounded-3xl p-8 hover-lift cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Logistics & Delivery</h3>
                    <p class="text-slate-400 mb-6">Equipment rental, bulk material transport, crane services, and on-site delivery across Tanzania.</p>
                    <div class="flex items-center text-cyan-400 font-semibold group-hover:text-cyan-300">
                        View Services
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Services -->
    <section id="services" class="py-24 bg-slate-800/30">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
                    Professional Services
                </h2>
                <p class="text-xl text-slate-400 max-w-3xl mx-auto">
                    Beyond products - we provide end-to-end construction support
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <div class="glass-effect rounded-3xl p-10 border-l-4 border-blue-500">
                    <div class="flex items-start mb-6">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center mr-5 flex-shrink-0">
                            <svg class="w-9 h-9 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-3">Project Consultation</h3>
                            <p class="text-slate-300 leading-relaxed">Expert advice on material selection, quantity estimation, cost optimization, and project timelines. Our certified engineers provide on-site assessments and detailed reports.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-3xl p-10 border-l-4 border-orange-500">
                    <div class="flex items-start mb-6">
                        <div class="w-16 h-16 bg-orange-500/20 rounded-2xl flex items-center justify-center mr-5 flex-shrink-0">
                            <svg class="w-9 h-9 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-3">Bulk Order Management</h3>
                            <p class="text-slate-300 leading-relaxed">Streamlined procurement for large-scale projects. Volume discounts, scheduled deliveries, inventory tracking, and dedicated account managers for enterprise clients.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-3xl p-10 border-l-4 border-purple-500">
                    <div class="flex items-start mb-6">
                        <div class="w-16 h-16 bg-purple-500/20 rounded-2xl flex items-center justify-center mr-5 flex-shrink-0">
                            <svg class="w-9 h-9 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-3">Quality Assurance</h3>
                            <p class="text-slate-300 leading-relaxed">All products undergo rigorous testing and certification. TBS-compliant materials with full documentation, warranties, and technical support throughout your project lifecycle.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-3xl p-10 border-l-4 border-green-500">
                    <div class="flex items-start mb-6">
                        <div class="w-16 h-16 bg-green-500/20 rounded-2xl flex items-center justify-center mr-5 flex-shrink-0">
                            <svg class="w-9 h-9 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
                        </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-3">Equipment Rental</h3>
                            <p class="text-slate-300 leading-relaxed">Flexible rental options for excavators, cranes, concrete mixers, scaffolding, and more. Daily, weekly, or monthly rates with operator training and maintenance included.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-24 bg-slate-900/50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-black text-white mb-6">
                        Why Tanzania's Top Builders Choose Weru
                    </h2>
                    <p class="text-xl text-slate-300 mb-8 leading-relaxed">
                        Over 15 years of excellence in construction supply chain management, serving projects from residential homes to major infrastructure developments.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Comprehensive Inventory</h4>
                                <p class="text-slate-400">19,000+ SKUs in stock across 6 warehouses in Dar es Salaam, Arusha, and Mwanza. Never experience project delays due to material shortages.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Competitive Pricing</h4>
                                <p class="text-slate-400">Direct manufacturer partnerships and bulk purchasing power translate to 15-30% savings compared to retail. Volume discounts available for contractors.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Rapid Delivery Network</h4>
                                <p class="text-slate-400">Own fleet of 45+ delivery trucks ensures same-day delivery in Dar es Salaam and 48-hour delivery nationwide. Real-time GPS tracking on all shipments.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Technical Support</h4>
                                <p class="text-slate-400">In-house team of civil engineers, architects, and quantity surveyors provide free consultation. 24/7 emergency hotline for urgent project needs.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="glass-effect rounded-3xl p-8 space-y-6">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-8 text-white">
                            <div class="text-6xl font-black mb-2">500+</div>
                            <p class="text-xl opacity-90">Active Construction Projects</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-slate-800 rounded-2xl p-6">
                                <div class="text-4xl font-bold text-blue-400 mb-2">15+</div>
                                <p class="text-slate-300">Years Experience</p>
                            </div>
                            <div class="bg-slate-800 rounded-2xl p-6">
                                <div class="text-4xl font-bold text-orange-400 mb-2">45</div>
                                <p class="text-slate-300">Delivery Trucks</p>
                            </div>
                            <div class="bg-slate-800 rounded-2xl p-6">
                                <div class="text-4xl font-bold text-purple-400 mb-2">98%</div>
                                <p class="text-slate-300">Customer Retention</p>
                            </div>
                            <div class="bg-slate-800 rounded-2xl p-6">
                                <div class="text-4xl font-bold text-green-400 mb-2">6</div>
                                <p class="text-slate-300">Warehouse Locations</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-80 mb-1">Average Delivery Time</p>
                                    <div class="text-3xl font-bold">4.2 Hours</div>
                                </div>
                                <svg class="w-16 h-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-24 bg-slate-800/30">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">
                    Trusted by Industry Leaders
                </h2>
                <p class="text-xl text-slate-400">
                    See what our clients say about their experience
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-effect rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-primary rounded-full mr-4"></div>
                        <div>
                            <h4 class="text-white font-bold">Juma Mwangi</h4>
                            <p class="text-slate-400 text-sm">Managing Director, Skyline Builders Ltd</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"Weru has been our primary supplier for 3 years. Their consistent quality, competitive pricing, and reliable delivery have been instrumental in completing our projects on time. Highly recommended for serious contractors."</p>
                </div>

                <div class="glass-effect rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-secondary rounded-full mr-4"></div>
                        <div>
                            <h4 class="text-white font-bold">Amina Hassan</h4>
                            <p class="text-slate-400 text-sm">Project Manager, TanzBuild Infrastructure</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"The technical consultation service saved us thousands. Their quantity surveyor helped optimize our material orders, and the engineering support was invaluable. This is what professional service looks like."</p>
                </div>

                <div class="glass-effect rounded-3xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full mr-4"></div>
                        <div>
                            <h4 class="text-white font-bold">Richard Mollel</h4>
                            <p class="text-slate-400 text-sm">Site Engineer, Mollel Construction Co.</p>
                        </div>
                    </div>
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-slate-300 leading-relaxed">"We rely on BuildPro for all our safety gear and finishing materials. Their team is responsive, and the quality assurance process gives us peace of mind. Fast delivery and great after-sales support!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-slate-900/60">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-black text-white mb-4">Contact Us</h2>
                <p class="text-xl text-slate-400">Ready to start your next project? Get in touch today.</p>
            </div>
            <div class="max-w-2xl mx-auto">
                <form action="/contact" method="POST" class="glass-effect rounded-3xl p-8 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full p-4 text-slate-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="John Doe"/>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full p-4 text-slate-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="you@example.com"/>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required class="w-full p-4 text-slate-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="+255 123 456 789"/>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-300 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" required class="w-full p-4 text-slate-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Your message..."></textarea>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-primary text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300">
                            Send Message
                        </button>
                        <button type="button" class="w-full sm:w-auto px-6 py-3 bg-slate-800 border border-slate-700 text-white font-semibold rounded-lg hover:bg-slate-700 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 12h18M3 21h18"/>
                            </svg>
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-slate-800">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <a href="#" class="text-2xl font-bold text-white">
                        Weru Hardware
                    </a>
                </div>

                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8">
                    <a href="#products" class="text-slate-300 hover:text-white transition-colors">Products</a>
                    <a href="#services" class="text-slate-300 hover:text-white transition-colors">Services</a>
                    <a href="#projects" class="text-slate-300 hover:text-white transition-colors">Projects</a>
                    <a href="#contact" class="text-slate-300 hover:text-white transition-colors">Contact</a>
                </div>

                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="/login" class="text-slate-300 hover:text-white transition-colors">
                        Sign In
                    </a>
                    <a href="/register" class="inline-flex items-center px-4 py-2 bg-gradient-primary text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300">
                        Get Started
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-700 mt-8 pt-4 text-center">
                <p class="text-sm text-slate-400">
                    &copy; 2025 Weru Hardware. All rights reserved. | Designed by Peter Patrick
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
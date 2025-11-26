<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Materials Store - Professional Grade Supplies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-mesh {
            background: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
        }
        
        .icon-wrapper {
            transition: transform 0.3s ease;
        }
        
        .card-hover:hover .icon-wrapper {
            transform: scale(1.05) rotate(3deg);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 backdrop-blur-lg bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Weru Hardware</h1>
                        <p class="text-xs text-gray-500">Professional Supplies</p>
                    </div>
                </div>
                
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Products</a>
                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Projects</a>
                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Support</a>
                </nav>
                
                <a href="/dashboard" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-mesh relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center max-w-4xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full mb-6">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-blue-900">TBS Certified • Same-Day Delivery Available</span>
                </div>
                
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Premium Building Materials
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Delivered On Time</span>
                </h2>
                
                <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                    Access 15,000+ certified construction products with expert support and reliable logistics across Tanzania.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-3xl mx-auto">
                    <form class="relative">
                        <div class="flex items-center bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden hover:shadow-2xl transition-shadow">
                            <div class="pl-6 pr-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="search"
                                placeholder="Search cement, steel, roofing, electrical..."
                                class="flex-1 py-5 text-base text-gray-900 bg-transparent outline-none placeholder-gray-400"
                            />
                            <button type="submit" class="px-8 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all">
                                Search
                            </button>
                        </div>
                    </form>
                    
                    <!-- Quick Links -->
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-6">
                        <span class="text-sm text-gray-500 font-medium">Popular:</span>
                        <a href="#" class="px-3 py-1.5 bg-white text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">Cement 50kg</a>
                        <a href="#" class="px-3 py-1.5 bg-white text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">TMT Bars</a>
                        <a href="#" class="px-3 py-1.5 bg-white text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">Roofing Sheets</a>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-16 max-w-5xl mx-auto">
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                    <div class="text-4xl font-bold text-gray-900 mb-1">15K+</div>
                    <div class="text-sm text-gray-600 font-medium">Products</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                    <div class="text-4xl font-bold text-gray-900 mb-1">24/7</div>
                    <div class="text-sm text-gray-600 font-medium">Support</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                    <div class="text-4xl font-bold text-gray-900 mb-1">Same Day</div>
                    <div class="text-sm text-gray-600 font-medium">Delivery</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                    <div class="text-4xl font-bold text-gray-900 mb-1">500+</div>
                    <div class="text-sm text-gray-600 font-medium">Projects</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-900 mb-4">Browse by Category</h3>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Professional-grade materials trusted by contractors and builders across Tanzania.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Cement & Concrete -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-200">
                <div class="icon-wrapper w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                    Cement & Concrete
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    OPC, masonry, and fast-setting concrete solutions.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">250+ Items</span>
                    <svg class="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Steel & Rebar -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-gray-300">
                <div class="icon-wrapper w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V13H5V6.3l7-3.11v9.8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                    Steel & Rebar
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    TMT bars, weld mesh, and structural beams.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">320+ Items</span>
                    <svg class="w-5 h-5 text-gray-700 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Bricks & Blocks -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-orange-200">
                <div class="icon-wrapper w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm15 0h3v3h-3v-3zm0 5h3v3h-3v-3zm-5-5h3v3h-3v-3zm0 5h3v3h-3v-3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">
                    Bricks & Blocks
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Clay bricks, concrete blocks, and pavers.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">180+ Items</span>
                    <svg class="w-5 h-5 text-orange-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Roofing -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-amber-200">
                <div class="icon-wrapper w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">
                    Roofing
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Iron sheets, tiles, and gutter systems.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">200+ Items</span>
                    <svg class="w-5 h-5 text-amber-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Plumbing -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-cyan-200">
                <div class="icon-wrapper w-14 h-14 bg-cyan-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">
                    Plumbing
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Pipes, fittings, pumps, and storage.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">280+ Items</span>
                    <svg class="w-5 h-5 text-cyan-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Electrical -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-yellow-200">
                <div class="icon-wrapper w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors">
                    Electrical
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Wiring, switches, breakers, and fixtures.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">350+ Items</span>
                    <svg class="w-5 h-5 text-yellow-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Paints & Finishing -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-200">
                <div class="icon-wrapper w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 4V3c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h12c.55 0 1-.45 1-1V6h1v4H9v11c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-9h8V4h-3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                    Paints & Finishing
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Paints, sealants, and waterproofing.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">300+ Items</span>
                    <svg class="w-5 h-5 text-purple-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Tools & Equipment -->
            <a href="#" class="group card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-200">
                <div class="icon-wrapper w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                    Tools & Equipment
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Power tools, safety gear, and machinery.
                </p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-500">400+ Items</span>
                    <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </section>

    <!-- Featured Deals -->
    <section class="bg-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Featured Offers</h3>
                <p class="text-lg text-gray-600">Special deals and partnerships for your projects</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm border-l-4 border-blue-500">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Seasonal Cement Offer</h4>
                    <p class="text-gray-600 leading-relaxed">Save 10% on all 50kg bags of premium OPC cement this month.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border-l-4 border-green-500">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">New Brand Partner</h4>
                    <p class="text-gray-600 leading-relaxed">Now offering complete range of premium German power tools.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border-l-4 border-indigo-500">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Free Consultation</h4>
                    <p class="text-gray-600 leading-relaxed">Orders over TZS 5M receive complimentary site materials consulting.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-12 text-center shadow-xl">
            <h3 class="text-3xl font-bold text-white mb-4">Need Help With Your Order?</h3>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">Our sales team is ready to assist with bulk orders, quotes, and project planning.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="tel:+255712345678" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Call Sales Now
                </a>
                <a href="#" class="inline-flex items-center gap-3 px-8 py-4 bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Live Chat Support
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Weru Hardware</span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Your trusted partner for premium building materials across Tanzania.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Products</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Cement & Concrete</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Steel & Rebar</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Roofing Materials</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tools & Equipment</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Our Projects</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Certifications</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Delivery Info</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Returns Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm">© 2025 Weru Hardware. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
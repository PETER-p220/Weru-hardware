<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Building Materials – BuildPro Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%); }
        .bg-gradient-secondary { background: linear-gradient(135deg, #dc2626 0%, #f97316 100%); }
        .text-gradient { background: linear-gradient(135deg, #3b82f6, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-effect { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(148, 163, 184, 0.1); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.25); }
        .mesh-gradient { background: 
                radial-gradient(at 40% 20%, rgba(59, 130, 246, 0.3) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(245, 158, 11, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(139, 92, 246, 0.2) 0px, transparent 50%),
                radial-gradient(at 80% 50%, rgba(239, 68, 68, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(34, 211, 238, 0.2) 0px, transparent 50%),
                radial-gradient(at 80% 100%, rgba(236, 72, 153, 0.2) 0px, transparent 50%);
        }
        .construction-pattern { background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px); }
        .cart-badge { animation: bounceIn 0.5s ease-out; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased construction-pattern">

<!-- ==================== NAVIGATION ==================== -->
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
                    <h1 class="text-2xl font-bold text-white">BuildPro Hardware</h1>
                    <p class="text-xs text-slate-400">Premium Construction Solutions</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button onclick="toggleCart()" class="relative p-2 text-slate-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center cart-badge hidden">0</span>
                </button>
                <a href="/login" class="text-slate-300 hover:text-white font-medium transition-colors hidden md:block">Sign In</a>
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

<!-- ==================== SHOPPING CART SIDEBAR ==================== -->
<div id="cart-sidebar" class="fixed top-0 right-0 h-full w-96 bg-slate-800 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Shopping Cart</h2>
            <button onclick="toggleCart()" class="text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div id="cart-items" class="space-y-4 mb-6">
            <!-- Cart items will be inserted here -->
        </div>
        
        <div class="border-t border-slate-700 pt-4 mt-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-slate-400">Subtotal:</span>
                <span id="cart-subtotal" class="text-xl font-bold text-white">TZS 0</span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-slate-400">Tax (18%):</span>
                <span id="cart-tax" class="text-lg font-semibold text-slate-300">TZS 0</span>
            </div>
            <div class="flex justify-between items-center mb-6 text-xl">
                <span class="font-bold text-white">Total:</span>
                <span id="cart-total" class="font-black text-blue-400">TZS 0</span>
            </div>
            
            <button onclick="proceedToCheckout()" class="w-full py-3 bg-gradient-primary text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/50 transition-all mb-2">
                Proceed to Checkout
            </button>
            <button onclick="clearCart()" class="w-full py-2 bg-slate-700 text-slate-300 font-medium rounded-xl hover:bg-slate-600 transition-all">
                Clear Cart
            </button>
        </div>
    </div>
</div>

<!-- Cart Overlay -->
<div id="cart-overlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="toggleCart()"></div>

<!-- ==================== HERO / PAGE TITLE ==================== -->
<section class="relative pt-32 pb-20 overflow-hidden mesh-gradient">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl lg:text-7xl font-black mb-4">
            <span class="text-white">Building</span> <span class="text-gradient">Materials</span>
        </h1>
        <p class="text-xl text-slate-300 max-w-2xl mx-auto">
            Premium construction materials for all your building projects – from foundation to finishing.
        </p>
    </div>
</section>

<!-- ==================== FILTER BAR ==================== -->
<section class="py-8 bg-slate-900/50 border-b border-slate-700/50">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search -->
            <div class="relative w-full md:w-80">
                <input type="text" id="search-input" placeholder="Search materials…" class="w-full pl-12 pr-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Category Pills -->
            <div class="flex flex-wrap gap-2" id="category-pills">
                <button onclick="filterCategory('all')" class="category-btn px-5 py-2 bg-gradient-primary text-white rounded-full text-sm font-medium" data-category="all">All</button>
                <button onclick="filterCategory('cement')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="cement">Cement & Concrete</button>
                <button onclick="filterCategory('steel')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="steel">Steel & Rebar</button>
                <button onclick="filterCategory('blocks')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="blocks">Blocks & Bricks</button>
                <button onclick="filterCategory('roofing')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="roofing">Roofing</button>
                <button onclick="filterCategory('timber')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="timber">Timber & Wood</button>
                <button onclick="filterCategory('finishing')" class="category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700" data-category="finishing">Finishing Materials</button>
            </div>

            <!-- Sort -->
            <select id="sort-select" class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="relevance">Sort by: Relevance</option>
                <option value="price-low">Price: Low → High</option>
                <option value="price-high">Price: High → Low</option>
                <option value="name">Name: A → Z</option>
            </select>
        </div>
    </div>
</section>

<!-- ==================== PRODUCT GRID ==================== -->
<section id="catalog" class="py-16 bg-slate-900/50">
    <div class="container mx-auto px-6">
        <div id="product-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Products will be inserted here by JavaScript -->
        </div>

        <!-- ==================== PAGINATION ==================== -->
        <div class="flex justify-center mt-12 space-x-2">
            <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-300 hover:bg-slate-700">Prev</button>
            <button class="px-4 py-2 bg-gradient-primary text-white rounded-lg">1</button>
            <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-300 hover:bg-slate-700">2</button>
            <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-300 hover:bg-slate-700">3</button>
            <span class="px-4 py-2 text-slate-500">...</span>
            <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-300 hover:bg-slate-700">8</button>
            <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-300 hover:bg-slate-700">Next</button>
        </div>
    </div>
</section>

<!-- ==================== FOOTER ==================== -->
<footer class="py-12 bg-slate-800">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <a href="#" class="text-2xl font-bold text-white">BuildPro Hardware</a>
            </div>

            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8">
                <a href="#products" class="text-slate-300 hover:text-white transition-colors">Products</a>
                <a href="#services" class="text-slate-300 hover:text-white transition-colors">Services</a>
                <a href="#projects" class="text-slate-300 hover:text-white transition-colors">Projects</a>
                <a href="#contact" class="text-slate-300 hover:text-white transition-colors">Contact</a>
            </div>

            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <a href="/login" class="text-slate-300 hover:text-white transition-colors">Sign In</a>
                <a href="/register" class="inline-flex items-center px-4 py-2 bg-gradient-primary text-white font-semibold rounded-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300">
                    Get Started
                </a>
            </div>
        </div>

        <div class="border-t border-slate-700 mt-8 pt-4 text-center">
            <p class="text-sm text-slate-400">
                © 2025 BuildPro Hardware. All rights reserved. | Designed for Tanzania
            </p>
        </div>
    </div>
</footer>

<script>
// Product Database
const products = [
    // Cement & Concrete
    { id: 1, name: 'Portland Cement OPC 42.5R', category: 'cement', price: 18500, oldPrice: 21000, unit: '50 kg bag', description: 'High-strength OPC 42.5R, TBS certified, ideal for structural concrete and masonry.', stock: 500, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z' },
    { id: 2, name: 'Ready-Mix Concrete Grade 20', category: 'cement', price: 145000, unit: 'per m³', description: 'Factory-mixed, quality-controlled concrete. Minimum order 3 m³. Delivery included.', stock: 100, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z' },
    { id: 3, name: 'Building Sand (Fine)', category: 'cement', price: 45000, unit: 'per truck (7 m³)', description: 'Washed fine sand for plastering, rendering, and bricklaying. Clean and sieved.', stock: 50, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z' },
    { id: 4, name: 'Crushed Stone Aggregate (20mm)', category: 'cement', price: 55000, unit: 'per truck (7 m³)', description: 'Clean granite aggregate for concrete mixing. Ideal for foundations and slabs.', stock: 40, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z' },
    
    // Steel & Rebar
    { id: 5, name: 'Steel Reinforcement Bar Y12 (12mm)', category: 'steel', price: 28500, unit: 'per 12m bar', description: 'High-tensile deformed steel bar. Grade 500, TBS 369 certified.', stock: 300, icon: 'M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z' },
    { id: 6, name: 'Steel Reinforcement Bar Y16 (16mm)', category: 'steel', price: 42000, unit: 'per 12m bar', description: 'Heavy-duty rebar for columns and beams. Grade 500 standard.', stock: 250, icon: 'M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z' },
    { id: 7, name: 'Binding Wire (Black)', category: 'steel', price: 2800, unit: 'per kg', description: 'Annealed black iron wire for tying reinforcement. 1.6mm thickness.', stock: 500, icon: 'M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z' },
    { id: 8, name: 'Steel I-Beam 150x150mm', category: 'steel', price: 185000, unit: 'per 6m length', description: 'Structural steel I-beam for heavy loads. S275 grade, hot-rolled.', stock: 80, icon: 'M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z' },
    
    // Blocks & Bricks
    { id: 9, name: 'Concrete Hollow Blocks 6"', category: 'blocks', price: 850, unit: 'per block', description: 'Load-bearing concrete blocks (150x200x400mm). High compressive strength.', stock: 5000, icon: 'M3 3v18h18V3H3zm16 16H5V5h14v14z' },
    { id: 10, name: 'Concrete Hollow Blocks 9"', category: 'blocks', price: 1200, unit: 'per block', description: 'Heavy-duty blocks (225x200x400mm) for structural walls.', stock: 3000, icon: 'M3 3v18h18V3H3zm16 16H5V5h14v14z' },
    { id: 11, name: 'Red Clay Bricks', category: 'blocks', price: 450, unit: 'per brick', description: 'Traditional fired clay bricks. Size: 220x110x75mm. Weather resistant.', stock: 8000, icon: 'M3 3v18h18V3H3zm16 16H5V5h14v14z' },
    { id: 12, name: 'Interlocking Paving Blocks', category: 'blocks', price: 3500, unit: 'per m²', description: 'Decorative concrete pavers for driveways and walkways. Various colors available.', stock: 400, icon: 'M3 3v18h18V3H3zm16 16H5V5h14v14z' },
    
    // Roofing
    { id: 13, name: 'Corrugated Iron Sheets (Mabati) 30G', category: 'roofing', price: 18500, unit: 'per 3.6m sheet', description: 'Galvanized corrugated roofing sheets. Gauge 30, zinc-coated.', stock: 600, icon: 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z' },
    { id: 14, name: 'Box Profile Roofing Sheets', category: 'roofing', price: 22000, unit: 'per 3.6m sheet', description: 'Pre-painted box profile sheets. Available in red, green, blue. 0.45mm thickness.', stock: 450, icon: 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z' },
    { id: 15, name: 'Roofing Timber (2x3")', category: 'roofing', price: 3500, unit: 'per 3.6m length', description: 'Treated softwood for roof framing. Kiln-dried, termite-resistant.', stock: 800, icon: 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z' },
    { id: 16, name: 'Clay Roof Tiles', category: 'roofing', price: 8500, unit: 'per m² (12 tiles)', description: 'Premium terracotta roofing tiles. Durable, heat-resistant, traditional style.', stock: 300, icon: 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z' },
    
    // Timber & Wood
    { id: 17, name: 'Mvule Hardwood Timber (4x2")', category: 'timber', price: 12500, unit: 'per 3.6m length', description: 'Premium Mvule hardwood for door frames and structural support.', stock: 250, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z' },
    { id: 18, name: 'Pine Timber (6x2")', category: 'timber', price: 5800, unit: 'per 3.6m length', description: 'Treated pine for general carpentry and roofing. Smooth finish.', stock: 500, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z' },
    { id: 19, name: 'Plywood Sheets 18mm', category: 'timber', price: 38000, unit: 'per 8x4 ft sheet', description: 'Marine-grade plywood. Water-resistant, ideal for formwork and shuttering.', stock: 180, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z' },
    { id: 20, name: 'Chipboard Sheets 16mm', category: 'timber', price: 15000, unit: 'per 8x4 ft sheet', description: 'Particle board for interior applications. Smooth surface, easy to paint.', stock: 220, icon: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z' },
    
    // Finishing Materials
    { id: 21, name: 'Wall Paint (Acrylic) - 20L', category: 'finishing', price: 45000, unit: 'per 20L bucket', description: 'Premium acrylic emulsion paint. Washable, durable finish. Multiple colors.', stock: 150, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 22, name: 'Floor Tiles (Ceramic) 40x40cm', category: 'finishing', price: 12500, unit: 'per m² (7 tiles)', description: 'Glazed ceramic floor tiles. Non-slip, easy to clean. Various designs.', stock: 400, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 23, name: 'Wall Tiles (Ceramic) 30x60cm', category: 'finishing', price: 18500, unit: 'per m² (6 tiles)', description: 'Glossy wall tiles for bathrooms and kitchens. Water-resistant.', stock: 350, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 24, name: 'Tile Adhesive (25kg)', category: 'finishing', price: 18000, unit: 'per 25kg bag', description: 'Polymer-modified tile cement. Covers 5-7 m². Interior/exterior use.', stock: 200, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 25, name: 'Grout (10kg)', category: 'finishing', price: 8500, unit: 'per 10kg bag', description: 'Waterproof tile grout. Available in white, grey, beige. Flexible formula.', stock: 180, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 26, name: 'PVC Ceiling Boards', category: 'finishing', price: 2800, unit: 'per 3m length', description: 'Lightweight PVC ceiling panels. White finish, easy installation.', stock: 600, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 27, name: 'Gypsum Boards (Drywall) 12mm', category: 'finishing', price: 5500, unit: 'per 8x4 ft sheet', description: 'Fire-resistant gypsum plasterboard for partitions and ceilings.', stock: 280, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
    { id: 28, name: 'Skim Coat Plaster (25kg)', category: 'finishing', price: 12000, unit: 'per 25kg bag', description: 'Fine finishing plaster for smooth walls. White powder, ready-mix.', stock: 220, icon: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' },
];

// Shopping cart
let cart = [];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    renderProducts(products);
    updateCartUI();
    
    // Search functionality
    document.getElementById('search-input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = products.filter(p => 
            p.name.toLowerCase().includes(searchTerm) || 
            p.description.toLowerCase().includes(searchTerm)
        );
        renderProducts(filtered);
    });
    
    // Sort functionality
    document.getElementById('sort-select').addEventListener('change', function(e) {
        const sortValue = e.target.value;
        let sorted = [...products];
        
        switch(sortValue) {
            case 'price-low':
                sorted.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                sorted.sort((a, b) => b.price - a.price);
                break;
            case 'name':
                sorted.sort((a, b) => a.name.localeCompare(b.name));
                break;
        }
        
        renderProducts(sorted);
    });
});

// Render products
function renderProducts(productList) {
    const grid = document.getElementById('product-grid');
    grid.innerHTML = productList.map(product => `
        <div class="group glass-effect rounded-3xl overflow-hidden hover-lift cursor-pointer" data-category="${product.category}">
            <div class="aspect-[4/3] bg-gradient-to-br from-slate-800 to-slate-900 p-6 flex items-center justify-center relative">
                <div class="bg-slate-700 border-2 border-dashed border-slate-600 rounded-xl w-full h-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${product.icon}"/>
                    </svg>
                </div>
                ${product.stock < 50 ? '<span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Low Stock</span>' : ''}
                ${product.oldPrice ? '<span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">SALE</span>' : ''}
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-xl font-bold text-white mb-1">${product.name}</h3>
                    <button onclick="toggleFavorite(${product.id})" class="text-slate-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-blue-400 font-medium mb-2">${product.unit}</p>
                <p class="text-slate-400 text-sm mb-4 line-clamp-2">${product.description}</p>
                
                <div class="flex items-center gap-2 mb-4 text-sm">
                    <span class="flex items-center text-slate-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Stock: ${product.stock}
                    </span>
                </div>
                
                <div class="flex items-end justify-between">
                    <div>
                        <span class="text-2xl font-black text-white">TZS ${product.price.toLocaleString()}</span>
                        ${product.oldPrice ? `<span class="text-sm text-slate-500 line-through ml-2">TZS ${product.oldPrice.toLocaleString()}</span>` : ''}
                    </div>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <button onclick="addToCart(${product.id})" class="flex-1 px-4 py-2.5 bg-gradient-primary text-white rounded-lg font-medium hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Add to Cart
                    </button>
                    <button onclick="quickView(${product.id})" class="px-4 py-2.5 bg-slate-700 text-white rounded-lg font-medium hover:bg-slate-600 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Filter by category
function filterCategory(category) {
    const buttons = document.querySelectorAll('.category-btn');
    buttons.forEach(btn => {
        if (btn.dataset.category === category) {
            btn.className = 'category-btn px-5 py-2 bg-gradient-primary text-white rounded-full text-sm font-medium';
        } else {
            btn.className = 'category-btn px-5 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm font-medium hover:bg-slate-700';
        }
    });
    
    if (category === 'all') {
        renderProducts(products);
    } else {
        const filtered = products.filter(p => p.category === category);
        renderProducts(filtered);
    }
}

// Add to cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    
    updateCartUI();
    showNotification(`${product.name} added to cart!`);
}

// Update cart quantity
function updateQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            updateCartUI();
        }
    }
}

// Remove from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartUI();
    showNotification('Item removed from cart');
}

// Clear cart
function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        cart = [];
        updateCartUI();
        showNotification('Cart cleared');
    }
}

// Update cart UI
function updateCartUI() {
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartTax = document.getElementById('cart-tax');
    const cartTotal = document.getElementById('cart-total');
    
    // Update count badge
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    if (totalItems > 0) {
        cartCount.textContent = totalItems;
        cartCount.classList.remove('hidden');
    } else {
        cartCount.classList.add('hidden');
    }
    
    // Update cart items
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-slate-400 text-center py-8">Your cart is empty</p>';
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="bg-slate-700/50 rounded-xl p-4">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold text-white text-sm flex-1">${item.name}</h4>
                    <button onclick="removeFromCart(${item.id})" class="text-red-400 hover:text-red-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-slate-400 mb-3">${item.unit}</p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity(${item.id}, -1)" class="w-7 h-7 bg-slate-600 rounded-lg flex items-center justify-center hover:bg-slate-500 transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="text-white font-semibold w-8 text-center">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)" class="w-7 h-7 bg-slate-600 rounded-lg flex items-center justify-center hover:bg-slate-500 transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                    <span class="font-bold text-white">TZS ${(item.price * item.quantity).toLocaleString()}</span>
                </div>
            </div>
        `).join('');
    }
    
    // Update totals
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.18;
    const total = subtotal + tax;
    
    cartSubtotal.textContent = `TZS ${subtotal.toLocaleString()}`;
    cartTax.textContent = `TZS ${tax.toLocaleString()}`;
    cartTotal.textContent = `TZS ${total.toLocaleString()}`;
}

// Toggle cart sidebar
function toggleCart() {
    const sidebar = document.getElementById('cart-sidebar');
    const overlay = document.getElementById('cart-overlay');
    
    sidebar.classList.toggle('translate-x-full');
    overlay.classList.toggle('hidden');
}

// Quick view
function quickView(productId) {
    const product = products.find(p => p.id === productId);
    alert(`Quick View: ${product.name}\n\n${product.description}\n\nPrice: TZS ${product.price.toLocaleString()} ${product.unit}\nStock: ${product.stock} units available`);
}

// Toggle favorite
function toggleFavorite(productId) {
    showNotification('Added to favorites!');
}

// Proceed to checkout
function proceedToCheckout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    alert('Proceeding to checkout...\n\nTotal Items: ' + cart.reduce((sum, item) => sum + item.quantity, 0) + '\nTotal Amount: TZS ' + (cart.reduce((sum, item) => sum + (item.price * item.quantity), 0) * 1.18).toLocaleString());
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-24 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-slide-up';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

</body>
</html>
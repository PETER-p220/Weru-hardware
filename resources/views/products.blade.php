<!DOCTYPE html>
<html lang="en" class="">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Premium Building Materials | Oweru Hardware</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<script>
tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          gold: '#DAA520',
          dark: '#001529'
        }
      },
      fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
    }
  }
}

function toggleDarkMode() {
  const html = document.documentElement;
  const isDark = html.classList.toggle('dark');
  localStorage.setItem('darkMode', isDark);
  document.getElementById('theme-icon').className =
    isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
}

function toggleMobileMenu() {
  document.getElementById('mobile-category-menu').classList.toggle('hidden');
  document.body.classList.toggle('overflow-hidden');
}
</script>
</head>

<body class="bg-gray-50 dark:bg-[#0b0f1a] text-gray-900 dark:text-slate-200 font-sans pb-20 lg:pb-0">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-white/95 dark:bg-[#001529]/95 backdrop-blur border-b border-gray-200 dark:border-white/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-16 lg:h-20">

      <span class="text-xl lg:text-2xl font-extrabold">
        Oweru<span class="text-amber-600">Hardware</span>
      </span>

      <nav class="hidden lg:flex gap-8 font-medium">
        <a href="/" class="text-amber-600 font-bold">Home</a>
        <a href="/products" class="hover:text-amber-600">Products</a>
        <a href="/about" class="hover:text-amber-600">About</a>
        <a href="/contact" class="hover:text-amber-600">Contact</a>
      </nav>

      <div class="flex items-center gap-4">
        <button onclick="toggleDarkMode()">
          <i id="theme-icon" class="fa-solid fa-moon"></i>
        </button>

        <a href="{{ route('cart') }}" class="relative">
          <i class="fa-solid fa-cart-shopping text-lg"></i>
          <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">
            {{ \App\Models\Cart::current()->totalItems() }}
          </span>
        </a>

        <a href="/login" class="hidden lg:inline bg-amber-600 text-white px-4 py-2 rounded-lg font-semibold">
          Sign In
        </a>

        <button onclick="toggleMobileMenu()" class="lg:hidden text-xl">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="bg-gradient-to-b from-gray-100 to-gray-200 dark:from-[#001529] dark:to-[#0b0f1a] py-12 lg:py-20">
  <div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl lg:text-6xl font-extrabold mb-4">
      Premium Inventory for <span class="text-amber-600">Master Builders</span>
    </h1>
    <p class="max-w-xl text-gray-600 dark:text-slate-400">
      Sourcing high quality steel, cement, and electrical supplies across Tanzania.
    </p>
  </div>
</section>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-4 py-8">
<div class="flex gap-8">

<!-- SIDEBAR -->
<aside class="hidden lg:block w-64">
  <div class="bg-white dark:bg-[#001529] p-6 rounded-xl border">
    <h3 class="font-bold mb-4">Categories</h3>
    <a href="{{ route('products') }}" class="block p-3 rounded bg-amber-600 text-black font-bold mb-2">
      All Inventory
    </a>
    @foreach($categories as $category)
    <a href="{{ route('products',['category'=>$category->slug]) }}"
       class="block p-3 rounded hover:bg-gray-100 dark:hover:bg-white/10">
      {{ $category->name }}
    </a>
    @endforeach
  </div>
</aside>

<!-- PRODUCTS -->
<section class="flex-1">

<!-- SEARCH -->
<div class="flex gap-4 mb-6">
  <input type="text" placeholder="Search..."
    class="flex-1 p-3 rounded border dark:bg-slate-900">
  <button onclick="toggleMobileMenu()" class="lg:hidden p-3 bg-amber-600 rounded text-black">
    <i class="fa-solid fa-filter"></i>
  </button>
</div>

<!-- GRID -->
<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
@foreach($products as $product)
<div class="bg-white dark:bg-[#001529] rounded-xl border overflow-hidden flex flex-col">

  <img src="{{ asset('storage/'.$product->image) }}"
       alt="{{ $product->name }}"
       class="w-full aspect-square object-cover">

  <div class="p-4 flex flex-col flex-1">
    <h3 class="font-bold mb-1">{{ $product->name }}</h3>

    <p class="text-sm text-gray-500 dark:text-slate-400 line-clamp-2 mb-3">
      {{ $product->description }}
    </p>

    <div class="mt-auto flex items-center justify-between">
      <span class="font-extrabold">
        <span class="text-amber-600 text-sm">TZS</span>
        {{ number_format($product->price) }}
      </span>

      <!-- ✅ ADD TO CART (FIXED) -->
      <form method="POST" action="{{ route('cart.add', $product->id) }}">
        @csrf
        <button type="submit"
          class="bg-amber-600 text-black px-3 py-2 rounded font-bold active:scale-95 transition">
          <i class="fa-solid fa-plus"></i>
        </button>
      </form>
    </div>
  </div>
</div>
@endforeach
</div>

<!-- PAGINATION -->
<div class="mt-10">
  {{ $products->links() }}
</div>

</section>
</div>
</main>

<!-- MOBILE CATEGORY MENU -->
<div id="mobile-category-menu"
 class="fixed inset-0 bg-white dark:bg-[#001529] z-50 hidden overflow-y-auto p-6">
  <div class="flex justify-between mb-6">
    <h3 class="font-bold text-lg">Categories</h3>
    <button onclick="toggleMobileMenu()">
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>
  </div>
  <a href="{{ route('products') }}" class="block p-4 bg-amber-600 text-black rounded mb-2">
    All Inventory
  </a>
  @foreach($categories as $category)
  <a href="{{ route('products',['category'=>$category->slug]) }}"
     class="block p-4 border rounded mb-2">
    {{ $category->name }}
  </a>
  @endforeach
</div>

<!-- MOBILE BOTTOM NAV -->
<div class="lg:hidden fixed bottom-0 inset-x-0 bg-white dark:bg-[#001529] border-t flex justify-around py-2">
  <a href="/" class="flex flex-col items-center text-xs">
    <i class="fa-solid fa-house"></i> Home
  </a>
  <button onclick="toggleMobileMenu()" class="flex flex-col items-center text-xs text-amber-600">
    <i class="fa-solid fa-layer-group"></i> Filter
  </button>
  <a href="{{ route('cart') }}" class="flex flex-col items-center text-xs">
    <i class="fa-solid fa-cart-shopping"></i> Cart
  </a>
</div>

<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-400 text-center py-8 mt-16">
  <p class="text-white font-bold">Oweru Hardware</p>
  <p>Tanzania's Premier Building Materials Supplier</p>
</footer>

</body>
</html>

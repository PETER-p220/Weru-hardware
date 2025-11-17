<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::with('categories')
            ->latest()
            ->paginate(20);

        return view('indexProduct', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Categories::orderBy('order')->get();
        return view('createProduct', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0|gt:price',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);
        // Handle checkbox values (they won't be present if unchecked)
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product = Product::create($validated);

        return redirect()
            ->route('indexProduct')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load('categories');
        return view('show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $categories = Categories::orderBy('order')->get();
        return view('editProduct', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0|gt:price',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()
            ->route('indexProduct')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('indexProduct')
            ->with('success', 'Product deleted successfully!');
    }
    public function products()
    {
        $products = Product::where('is_active', true)
            ->with('categories')
            ->latest()
            ->paginate(12);

        return view('products', compact('products'));
    }   
}
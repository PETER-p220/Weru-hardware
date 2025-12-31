<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Categories::withCount([
            'products as products_count', // Total
            'products as active_products_count' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
        ->orderBy('order')
        ->paginate(15);

        // Calculate totals for stats cards
        $totalCategories = Categories::count();
        $totalProducts = Categories::withCount('products')->get()->sum('products_count');
        $avgProductsPerCategory = $totalCategories > 0 ? round($totalProducts / $totalCategories, 1) : 0;

        return view('indexCategory', compact('categories', 'totalCategories', 'totalProducts', 'avgProductsPerCategory'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('createCategory');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Categories::create($validated);

        return redirect()
            ->route('indexCategory')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category with its products
     */
    public function show(Categories $category)
    {
        $category->load(['products' => function($query) {
            $query->active()->latest();
        }]);

        return view('showCategory', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Categories $category)
    {
        return view('editCategory', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Categories $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()
            ->route('indexCategory')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Categories $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()
                ->route('indexCategory')
                ->with('error', 'Cannot delete category with existing products!');
        }

        $category->delete();

        return redirect()
            ->route('indexCategory')
            ->with('success', 'Category deleted successfully!');
    }
}
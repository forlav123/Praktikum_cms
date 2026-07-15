<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $categoryId = $request->category_id;
        
        if ($request->filled('new_category')) {
            $category = Category::firstOrCreate(
                ['slug' => str($request->new_category)->slug()],
                ['name' => $request->new_category]
            );
            $categoryId = $category->id;
        }

        if (!$categoryId) {
            return back()->withErrors(['category_id' => 'Silakan pilih kategori atau buat baru.'])->withInput();
        }

        Product::create([
            'name' => $request->name,
            'slug' => str($request->name)->slug(),
            'category_id' => $categoryId,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $categoryId = $request->category_id;
        
        if ($request->filled('new_category')) {
            $category = Category::firstOrCreate(
                ['slug' => str($request->new_category)->slug()],
                ['name' => $request->new_category]
            );
            $categoryId = $category->id;
        }

        if (!$categoryId) {
            return back()->withErrors(['category_id' => 'Silakan pilih kategori atau buat baru.'])->withInput();
        }

        $product->update([
            'name' => $request->name,
            'slug' => str($request->name)->slug(),
            'category_id' => $categoryId,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

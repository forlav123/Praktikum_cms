<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        return view('product-show', compact('product'));
    }

    public function shop()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(12)
            ->get();

        $mappedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category ? $product->category->name : 'Umum',
                'price' => (float) $product->price,
                'stock' => (int) $product->stock,
                'rating' => 4.5, // nilai default untuk rating
                'reviewsCount' => 15, // nilai default untuk jumlah ulasan
                'image' => $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x300?text=No+Image',
                'description' => $product->description,
            ];
        });

        return view('shop', ['productsJson' => $mappedProducts]);
    }

    public function products(Request $request)
    {
        $page = max(1, (int) $request->input('page', 1));
        $perPage = min(12, max(1, (int) $request->input('per_page', 6)));

        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $mappedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category ? $product->category->name : 'Umum',
                'price' => (float) $product->price,
                'stock' => (int) $product->stock,
                'rating' => 4.5,
                'reviewsCount' => 15,
                'image' => $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x300?text=No+Image',
                'description' => $product->description,
            ];
        });

        $totalProducts = Product::where('is_active', true)->count();
        $hasMore = ($page * $perPage) < $totalProducts;

        return response()->json([
            'products' => $mappedProducts,
            'hasMore' => $hasMore,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }
}

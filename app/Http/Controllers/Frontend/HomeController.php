<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('status', 'active')
            ->whereHas('products', function($q) {
                $q->where('status', 'active');
            })
            ->withCount(['products' => function($q) {
                $q->where('status', 'active');
            }])
            ->get();
            
        // Load first 8 products for each category
        foreach($categories as $category) {
            $category->home_products = \App\Models\Product::where('category_id', $category->id)
                ->where('status', 'active')
                ->with(['product_images', 'manufacturer', 'generic', 'brand'])
                ->limit(8)
                ->get();
        }

        $maxDiscount = \App\Models\Product::where('status', 'active')->max('discount') ?? 0;
        $discountedProducts = \App\Models\Product::with(['product_images', 'manufacturer', 'generic', 'brand'])
            ->where('status', 'active')
            ->where('discount', '>', 0)
            ->orderByDesc('discount')
            ->limit(10)
            ->get();
        $sliders = \App\Models\Slider::where('status', 'active')->orderBy('order')->get();

        return view('frontend.home.index', compact('categories', 'maxDiscount', 'discountedProducts', 'sliders'));
    }

    public function categoryProducts(\App\Models\Category $category)
    {
        $query = \App\Models\Product::where('category_id', $category->id)
            ->where('status', 'active');

        // Apply search if present
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('strength', 'like', "%{$search}%")
                  ->orWhere('dosage_form', 'like', "%{$search}%");
            });
        }

        $products = $query->with(['brand', 'generic', 'manufacturer', 'product_images'])->paginate(8);

        // Return JSON for AJAX requests (infinite scroll or live search)
        if (request()->ajax()) {
            return response()->json([
                'html' => view('frontend.category._product_grid', compact('products'))->render(),
                'count' => $products->total(),
            ]);
        }

        return view('frontend.category.products', compact('category', 'products'));
    }

    public function productDetail(\App\Models\Product $product)
    {
        $product->load(['brand', 'generic', 'manufacturer', 'category', 'sub_category', 'unit', 'product_images', 'product_reviews']);

        // Related products from same category
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with(['product_images', 'manufacturer'])
            ->limit(4)
            ->get();

        return view('frontend.product.detail', compact('product', 'relatedProducts'));
    }

    public function loadMoreCategoryProducts(Request $request, \App\Models\Category $category)
    {
        $skip = $request->input('skip', 8);
        $products = \App\Models\Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['product_images', 'manufacturer', 'generic', 'brand'])
            ->skip($skip)
            ->take(8)
            ->get();

        $html = view('frontend.home._product_cards', compact('products'))->render();

        return response()->json([
            'html' => $html,
            'count' => $products->count(),
        ]);
    }
}

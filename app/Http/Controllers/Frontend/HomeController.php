<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('status', 'active')->withCount('products')->get();
        $maxDiscount = \App\Models\Product::where('status', 'active')->max('discount') ?? 0;
        return view('frontend.home.index', compact('categories', 'maxDiscount'));
    }

    public function categoryProducts(\App\Models\Category $category)
    {
        $query = \App\Models\Product::where('category_id', $category->id)
            ->where('status', 'active');

        // Live search via AJAX
        if (request()->ajax() && request('search')) {
            $search = request('search');
            $products = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('strength', 'like', "%{$search}%")
                  ->orWhere('dosage_form', 'like', "%{$search}%");
            })->with(['brand', 'generic', 'manufacturer', 'product_images'])->paginate(24);

            return response()->json([
                'html' => view('frontend.category._product_grid', compact('products'))->render(),
                'count' => $products->total(),
            ]);
        }

        $products = $query->with(['brand', 'generic', 'manufacturer', 'product_images'])->paginate(24);

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
}

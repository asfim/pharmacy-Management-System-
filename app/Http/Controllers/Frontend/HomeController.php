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
            })->with(['brand', 'generic', 'manufacturer'])->paginate(20);

            return response()->json([
                'html' => view('frontend.category._product_grid', compact('products'))->render(),
                'count' => $products->total(),
            ]);
        }

        $products = $query->with(['brand', 'generic', 'manufacturer'])->paginate(20);
        $allCategories = \App\Models\Category::where('status', 'active')->withCount('products')->get();

        return view('frontend.category.products', compact('category', 'products', 'allCategories'));
    }
}

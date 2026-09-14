<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Generic;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $generics = Generic::where('status', 'active')->orderBy('name')->get();
        $manufacturers = Manufacturer::where('status', 'active')->orderBy('company_name')->get();

        $query = Product::with(['product_images', 'manufacturer', 'generic', 'brand'])
            ->where('status', 'active');

        // Apply filters if present in request
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->whereIn('category_id', explode(',', $request->category));
        }
        if ($request->filled('generic')) {
            $query->whereIn('generic_id', explode(',', $request->generic));
        }
        if ($request->filled('manufacturer')) {
            $query->whereIn('manufacturer_id', explode(',', $request->manufacturer));
        }
        if ($request->filled('discount')) {
            $query->where('discount', '>', 0);
        }

        $products = $query->take(16)->get();
        $isFlashSale = $request->filled('discount');

        return view('frontend.product.index', compact('products', 'categories', 'generics', 'manufacturers', 'isFlashSale'));
    }

    public function fetchProducts(Request $request)
    {
        $skip = $request->input('skip', 0);
        $take = $request->input('take', 8);

        $query = Product::with(['product_images', 'manufacturer', 'generic', 'brand'])
            ->where('status', 'active');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }
        if ($request->filled('generic')) {
            $query->whereIn('generic_id', $request->generic);
        }
        if ($request->filled('manufacturer')) {
            $query->whereIn('manufacturer_id', $request->manufacturer);
        }
        if ($request->filled('discount')) {
            $query->where('discount', '>', 0);
        }

        $products = $query->skip($skip)->take($take)->get();

        $html = view('frontend.home._product_cards', compact('products'))->render();

        return response()->json([
            'html' => $html,
            'count' => $products->count(),
        ]);
    }
}

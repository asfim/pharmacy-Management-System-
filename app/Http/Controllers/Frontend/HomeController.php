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
}

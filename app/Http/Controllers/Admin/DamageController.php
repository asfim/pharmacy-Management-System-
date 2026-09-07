<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DamageWastage;
use Illuminate\Http\Request;

class DamageController extends Controller
{
    public function index()
    {
        $damages = DamageWastage::with('product')->latest()->paginate(20);
        return view('admin.damages.index', compact('damages'));
    }
}

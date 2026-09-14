<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = \App\Models\Cms::where('section', 'feature_strip')->orderBy('order')->get();
        return view('admin.cms.index', compact('features'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer',
        ]);

        $data = $request->all();
        $data['section'] = 'feature_strip';
        
        \App\Models\Cms::create($data);

        return redirect()->route('admin.cms.index')->with('success', 'Feature created successfully.');
    }

    public function edit(\App\Models\Cms $cm) // the variable is $cm because of route model binding guessing singular of cms
    {
        return view('admin.cms.edit', compact('cm'));
    }

    public function update(Request $request, \App\Models\Cms $cm)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer',
        ]);

        $cm->update($request->all());

        return redirect()->route('admin.cms.index')->with('success', 'Feature updated successfully.');
    }

    public function destroy(\App\Models\Cms $cm)
    {
        $cm->delete();
        return redirect()->route('admin.cms.index')->with('success', 'Feature deleted successfully.');
    }
}

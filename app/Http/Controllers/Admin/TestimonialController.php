<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Cms::where('section', 'testimonials')->orderBy('order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|integer|min:1|max:5', // rating
            'color' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer',
        ]);

        $data = $request->all();
        $data['section'] = 'testimonials';

        Cms::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Cms $testimonial)
    {
        // verify section
        if ($testimonial->section !== 'testimonials') {
            abort(404);
        }
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Cms $testimonial)
    {
        if ($testimonial->section !== 'testimonials') {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|integer|min:1|max:5', // rating
            'color' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer',
        ]);

        $testimonial->update($request->all());

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Cms $testimonial)
    {
        if ($testimonial->section !== 'testimonials') {
            abort(404);
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}

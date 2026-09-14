<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
        ]);

        if ($request->has('site_title')) {
            Setting::updateOrCreate(['key' => 'site_title'], ['value' => $request->site_title]);
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $path]);
        }

        // Hero Settings
        $heroFields = [
            'hero_badge_text', 'hero_title', 'hero_highlight', 'hero_desc',
            'hero_btn1_text', 'hero_btn1_link', 'hero_btn2_text', 'hero_btn2_link',
            'hero_stat1_num', 'hero_stat1_label', 'hero_stat2_num', 'hero_stat2_label',
            'hero_stat3_num', 'hero_stat3_label'
        ];

        foreach ($heroFields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(['key' => $field], ['value' => $request->$field]);
            }
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'hero_image'], ['value' => $path]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }

    public function invoice()
    {
        return view('admin.settings.index');
    }

    public function pos()
    {
        return view('admin.settings.index');
    }
}

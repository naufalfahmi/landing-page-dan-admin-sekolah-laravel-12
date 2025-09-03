<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'site_title' => Setting::getValue('site_title', ''),
            'site_icon' => Setting::getValue('site_icon', ''),
            'favicon' => Setting::getValue('favicon', ''),
            'meta_keywords' => Setting::getValue('meta_keywords', ''),
            'meta_description' => Setting::getValue('meta_description', ''),
        ];

        return view('admin.settings.index', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_title' => ['nullable','string','max:255'],
            'meta_keywords' => ['nullable','string','max:500'],
            'meta_description' => ['nullable','string'],
            'site_icon' => ['nullable','image','max:2048'],
            'favicon' => ['nullable','image','max:1024'],
        ]);

        // Text values
        Setting::setValue('site_title', $validated['site_title'] ?? '', 'seo');
        Setting::setValue('meta_keywords', $validated['meta_keywords'] ?? '', 'seo');
        Setting::setValue('meta_description', $validated['meta_description'] ?? '', 'seo');

        // Uploads
        if ($request->hasFile('site_icon')) {
            $path = $request->file('site_icon')->store('images/settings', 'public');
            Setting::setValue('site_icon', asset('storage/' . $path), 'seo');
        }
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('images/settings', 'public');
            Setting::setValue('favicon', asset('storage/' . $path), 'seo');
        }

        return back()->with('success', 'Pengaturan berhasil disimpan');
    }
}



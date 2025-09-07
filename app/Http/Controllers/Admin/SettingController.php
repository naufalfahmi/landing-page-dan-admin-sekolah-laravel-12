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
            'site_subtitle' => Setting::getValue('site_subtitle', 'Berita dan Artikel Islami'),
            'site_logo' => Setting::getValue('site_logo', ''),
            'site_icon' => Setting::getValue('site_icon', ''),
            'favicon' => Setting::getValue('favicon', ''),
            'meta_keywords' => Setting::getValue('meta_keywords', ''),
            'meta_description' => Setting::getValue('meta_description', ''),
            'contact_email' => Setting::getValue('contact_email', ''),
            'contact_phone' => Setting::getValue('contact_phone', ''),
            'contact_address' => Setting::getValue('contact_address', ''),
            'contact_address_link' => Setting::getValue('contact_address_link', ''),
            'contact_whatsapp' => Setting::getValue('contact_whatsapp', ''),
            'contact_map_embed' => Setting::getValue('contact_map_embed', ''),
            'operational_hours_weekdays' => Setting::getValue('operational_hours_weekdays', '07:00 - 15:00 WIB'),
            'operational_hours_saturday' => Setting::getValue('operational_hours_saturday', '07:00 - 12:00 WIB'),
            'operational_hours_sunday' => Setting::getValue('operational_hours_sunday', 'Libur'),
            'google_analytics' => Setting::getValue('google_analytics', ''),
            'facebook_pixel' => Setting::getValue('facebook_pixel', ''),
        ];

        return view('admin.settings.index', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_title' => ['nullable','string','max:255'],
            'site_subtitle' => ['nullable','string','max:255'],
            'meta_keywords' => ['nullable','string','max:500'],
            'meta_description' => ['nullable','string'],
            'site_logo' => ['nullable','image','max:2048'],
            'site_icon' => ['nullable','image','max:1024'],
            'favicon' => ['nullable','image','max:512'],
            'contact_email' => ['nullable','email','max:255'],
            'contact_phone' => ['nullable','string','max:50'],
            'contact_address' => ['nullable','string'],
            'contact_address_link' => ['nullable','url','max:500'],
            'contact_whatsapp' => ['nullable','string','max:50'],
            'contact_map_embed' => ['nullable','string','max:2000'],
            'operational_hours_weekdays' => ['nullable','string','max:100'],
            'operational_hours_saturday' => ['nullable','string','max:100'],
            'operational_hours_sunday' => ['nullable','string','max:100'],
            'google_analytics' => ['nullable','string','max:500'],
            'facebook_pixel' => ['nullable','string','max:500'],
        ]);

        // SEO Settings
        Setting::setValue('site_title', $validated['site_title'] ?? '', 'seo');
        Setting::setValue('site_subtitle', $validated['site_subtitle'] ?? '', 'seo');
        Setting::setValue('meta_keywords', $validated['meta_keywords'] ?? '', 'seo');
        Setting::setValue('meta_description', $validated['meta_description'] ?? '', 'seo');

        // Contact Settings
        Setting::setValue('contact_email', $validated['contact_email'] ?? '', 'contact');
        Setting::setValue('contact_phone', $validated['contact_phone'] ?? '', 'contact');
        Setting::setValue('contact_address', $validated['contact_address'] ?? '', 'contact');
        Setting::setValue('contact_address_link', $validated['contact_address_link'] ?? '', 'contact');
        Setting::setValue('contact_whatsapp', $validated['contact_whatsapp'] ?? '', 'contact');
        Setting::setValue('contact_map_embed', $validated['contact_map_embed'] ?? '', 'contact');

        // Operational Hours
        Setting::setValue('operational_hours_weekdays', $validated['operational_hours_weekdays'] ?? '', 'operational');
        Setting::setValue('operational_hours_saturday', $validated['operational_hours_saturday'] ?? '', 'operational');
        Setting::setValue('operational_hours_sunday', $validated['operational_hours_sunday'] ?? '', 'operational');

        // Analytics
        Setting::setValue('google_analytics', $validated['google_analytics'] ?? '', 'analytics');
        Setting::setValue('facebook_pixel', $validated['facebook_pixel'] ?? '', 'analytics');

        // Uploads
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('images/settings', 'public');
            Setting::setValue('site_logo', asset('storage/' . $path), 'seo');
        }
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




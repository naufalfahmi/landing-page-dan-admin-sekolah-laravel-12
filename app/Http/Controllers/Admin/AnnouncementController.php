<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Models\Shortlink;
use App\Models\AnnouncementAttachment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::with('category')->latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AnnouncementCategory::active()->ordered()->get()->pluck('name', 'id');

        $priorities = [
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ];

        return view('admin.announcements.create', compact('categories', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:announcement_categories,id',
            'priority' => 'required|in:low,normal,high,urgent',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->except('attachment');
        $data['slug'] = Str::slug($request->title);
        $data['published_at'] = $request->is_published ? now() : null;

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('announcements', $filename, 'public');
            
            $data['attachment'] = asset('storage/' . $path);
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $announcement = Announcement::create($data);

        // Handle multiple attachments (optional)
        if ($request->hasFile('attachments')) {
            $sortOrder = 0;
            foreach ($request->file('attachments') as $file) {
                if (!$file) { continue; }
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('announcements', $filename, 'public');
                AnnouncementAttachment::create([
                    'announcement_id' => $announcement->id,
                    'file_url' => asset('storage/' . $path),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => strtolower($file->getClientOriginalExtension()),
                    'file_size' => $file->getSize(),
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['category', 'attachments']);
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $categories = AnnouncementCategory::active()->ordered()->get()->pluck('name', 'id');
        $announcement->load('attachments');

        $priorities = [
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ];

        return view('admin.announcements.edit', compact('announcement', 'categories', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:announcement_categories,id',
            'priority' => 'required|in:low,normal,high,urgent',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->except('attachment');
        $data['slug'] = Str::slug($request->title);
        
        // Update published_at if status changed
        if ($request->is_published && !$announcement->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('announcements', $filename, 'public');
            
            $data['attachment'] = asset('storage/' . $path);
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $announcement->update($data);

        // Handle multiple attachments addition (optional)
        if ($request->hasFile('attachments')) {
            $currentMax = (int) ($announcement->attachments()->max('sort_order') ?? 0);
            $sortOrder = $currentMax + 1;
            foreach ($request->file('attachments') as $file) {
                if (!$file) { continue; }
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('announcements', $filename, 'public');
                AnnouncementAttachment::create([
                    'announcement_id' => $announcement->id,
                    'file_url' => asset('storage/' . $path),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => strtolower($file->getClientOriginalExtension()),
                    'file_size' => $file->getSize(),
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * Delete a specific attachment from an announcement
     */
    public function destroyAttachment(Announcement $announcement, AnnouncementAttachment $attachment)
    {
        // Ensure attachment belongs to the announcement
        if ($attachment->announcement_id !== $announcement->id) {
            abort(404);
        }

        // Try to delete physical file if it's within storage path
        $pathPart = parse_url($attachment->file_url, PHP_URL_PATH);
        if ($pathPart) {
            $publicPath = public_path(ltrim($pathPart, '/'));
            if (is_file($publicPath)) {
                @unlink($publicPath);
            }
        }

        $attachment->delete();

        return back()->with('success', 'Lampiran berhasil dihapus');
    }

    /**
     * Store a new category via AJAX
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:announcement_categories,name',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        $category = AnnouncementCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#007bff',
            'is_active' => true,
            'sort_order' => AnnouncementCategory::max('sort_order') + 1,
        ]);

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'message' => 'Kategori berhasil ditambahkan!'
        ]);
    }

    /**
     * Share announcement to WhatsApp using shortlink
     */
    public function shareWhatsapp(Announcement $announcement)
    {
        // Build public target URL for the announcement detail page
        $targetUrl = route('announcements.show', $announcement->slug);

        // Reuse existing shortlink by target_url or create a new one
        $shortlink = Shortlink::where('target_url', $targetUrl)->first();
        if (!$shortlink) {
            $shortlink = Shortlink::create([
                'short_code' => Shortlink::generateShortCode(),
                'target_url' => $targetUrl,
                'clicks' => 0,
            ]);
        }

        $siteTitle = Setting::getValue('site_title', config('app.name', '')); 
        $shareText = trim($announcement->title . ' - ' . $shortlink->full_url . ($siteTitle ? ' - ' . $siteTitle : ''));
        $waUrl = 'https://wa.me/?text=' . urlencode($shareText);

        return redirect()->away($waUrl);
    }
}
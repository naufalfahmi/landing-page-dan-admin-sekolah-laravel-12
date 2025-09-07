<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact messages list
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'messages' => $messages,
            'unreadCount' => ContactMessage::unread()->count(),
            'totalCount' => ContactMessage::count(),
        ];

        return view('admin.contact.index', $data);
    }

    /**
     * Show specific contact message
     */
    public function show(ContactMessage $contact)
    {
        // Mark as read if not already read
        if ($contact->status === 'unread') {
            $contact->markAsRead();
        }

        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Mark message as replied
     */
    public function markAsReplied(ContactMessage $contact)
    {
        $contact->markAsReplied();
        
        return back()->with('success', 'Pesan telah ditandai sebagai sudah dibalas');
    }

    /**
     * Delete contact message
     */
    public function destroy(ContactMessage $contact)
    {
        $contact->delete();
        
        return back()->with('success', 'Pesan kontak berhasil dihapus');
    }

}

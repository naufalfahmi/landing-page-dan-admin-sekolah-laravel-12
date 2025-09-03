<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount('articles')
            ->latest()
            ->paginate(10);

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = [
            'Al-Quran', 'Hadis', 'Riwayat', 'Fikih', 'Tokoh', 
            'Adab', 'Opini', 'Perempuan', 'Amaliyah', 'Ibadah', 
            'Sejarah', 'Akhlak', 'Tafsir', 'Kajian', 'Shalat', 
            'Nabi', 'Sahabat', 'Ramadhan', 'Sosial', 'Teknologi', 
            'Modernitas', 'Umum'
        ];

        return view('admin.authors.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|url',
            'specialization' => 'nullable|string',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8',
        ]);

        $author = Author::create([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'avatar' => $request->avatar,
            'specialization' => $request->specialization,
            'is_active' => $request->has('is_active'),
        ]);

        // Create or update login user for this author if password provided
        if ($request->filled('password')) {
            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                ]
            );
        }

        return redirect()->route('admin.authors.index')
            ->with('success', 'Penulis berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load(['articles' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $specializations = [
            'Al-Quran', 'Hadis', 'Riwayat', 'Fikih', 'Tokoh', 
            'Adab', 'Opini', 'Perempuan', 'Amaliyah', 'Ibadah', 
            'Sejarah', 'Akhlak', 'Tafsir', 'Kajian', 'Shalat', 
            'Nabi', 'Sahabat', 'Ramadhan', 'Sosial', 'Teknologi', 
            'Modernitas', 'Umum'
        ];

        return view('admin.authors.edit', compact('author', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email,' . $author->id,
            'bio' => 'nullable|string',
            'avatar' => 'nullable|url',
            'specialization' => 'nullable|string',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8',
        ]);

        $author->update([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'avatar' => $request->avatar,
            'specialization' => $request->specialization,
            'is_active' => $request->has('is_active'),
        ]);

        // Sync related user record for login
        $user = User::where('email', $author->getOriginal('email'))->first();
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        } elseif ($request->filled('password')) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.authors.index')
            ->with('success', 'Penulis berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if ($author->articles()->count() > 0) {
            return redirect()->route('admin.authors.index')
                ->with('error', 'Tidak dapat menghapus penulis yang memiliki artikel!');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Penulis berhasil dihapus!');
    }
}

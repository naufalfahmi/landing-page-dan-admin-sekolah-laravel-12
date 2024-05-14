<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('artikel.index');
    }

    public function data(Request $request)
    {
        $query = Post::with(['category_post'])
            ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                function ($query) use ($request) {
                    $query->whereBetween('publish_date', [
                        $request->input('start_date'),
                        $request->input('end_date')
                    ]);
                }
            )->orderBy('publish_date', 'desc');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('title', function ($query) {
                return substr($query->title, 0, 50) . '...';
            })
            ->editColumn('status', function ($query) {
                return $query->status();
            })
            ->editColumn('tanggal_publish', function ($query) {
                return $query->publish_date;
            })
            ->editColumn('penulis', function ($query) {
                return $query->user->name;
            })
            ->editColumn('kategori', function ($query) {
                return $query->category_post->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($query) {
                $aksi = '';

                if (Auth::user()->hasPermissionTo('Artikel Show')) {
                    $aksi .= '<button onclick="editData(`' . route('articles.show', $query->id) . '`)" class="btn btn-sm mr-1 btn-warning"><i class="fas fa-pencil-alt"></i></button>';
                }

                if (Auth::user()->hasPermissionTo('Artikel Delete')) {
                    $aksi .= '<button onclick="deleteData(`' . route('articles.destroy', $query->id) . '`, `' . $query->title . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>';
                }

                return $aksi;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'body'  => 'required',
            'publish_date' => 'required|date_format:Y-m-d H:i:s',
            'categories' => 'required',
            'path_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:publish,draft',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        try {
            DB::beginTransaction();
            $data = [
                'user_id'       => Auth::user()->id,
                'title'         => $request->title,
                'slug'          => Str::slug($request->title),
                'body'          => $request->body,
                'publish_date'  => $request->publish_date,
                'status'        => $request->status,
            ];

            $data['path_image'] = upload('post', $request->file('path_image'), 'post');

            $post = Post::create($data);

            $post->category_post()->attach($request->categories);

            DB::commit();

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Maaf terjadi kesalahan pada server'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $posts = Post::with(['category_post'])->find($id);
        $posts->path_image = Storage::url($posts->path_image);
        return response()->json(['data' => $posts]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrfail($id);

        $rules = [
            'title' => 'required',
            'body'  => 'required',
            'publish_date' => 'required|date_format:Y-m-d H:i:s',
            'categories' => 'required',
            'path_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:publish,draft',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        try {
            DB::beginTransaction();
            $data = $request->except('path_image', 'categories');
            $data['slug'] = Str::slug($request->title);

            if ($request->hasFile('path_image')) {
                if (Storage::disk('public')->exists($post->path_image)) {
                    Storage::disk('public')->delete($post->path_image);
                }

                $data['path_image'] = upload('post', $request->file('path_image'), 'post');
            }

            $post->update($data);
            $post->category_post()->sync($request->categories);

            DB::commit();

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Maaf terjadi kesalahan pada server'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        if (Storage::disk('public')->exists($post->path_image)) {
            Storage::disk('public')->delete($post->path_image);
        }

        $post->delete();
        $post->category_post()->detach();

        return response()->json(['message' => 'Data berhasil di hapus'], 200);
    }

    public function categorySearch()
    {
        $keyword = request()->get('q');

        $result = Category::where('name', "LIKE", "%$keyword%")->get();

        return $result;
    }
}

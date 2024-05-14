<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    public function data()
    {
        $query = Category::all();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status', function ($query) {
                return $query->status();
            })
            ->addColumn('action', function ($query) {
                $aksi = '';

                if (Auth::user()->hasPermissionTo('Kategori Show')) {
                    $aksi .= '<button onclick="editData(`' . route('category.show', $query->id) . '`)" class="btn btn-sm mr-1 btn-warning"><i class="fas fa-pencil-alt"></i></button>';
                }

                if (Auth::user()->hasPermissionTo('Kategori Delete')) {
                    $aksi .= '<button onclick="deleteData(`' . route('category.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>';
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
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        Category::create($data);

        return response()->json(['message' => 'Kategori berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Maaf inputan yang anda masukan salah, silahkan periksa kembali dan coba lagi'], 422);
        }

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $category->update($data);

        return response()->json(['message' => 'Kategori berhasil disimpan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}

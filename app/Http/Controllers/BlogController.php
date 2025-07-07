<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('blog.index');
    }

    protected function getDataTable()
    {
        $blogs = Blog::with('user');

        return DataTables::of($blogs)
            ->addIndexColumn()
            ->editColumn('image', function ($blog) {
                return '<img src="' . asset($blog->image) . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
            })
            ->addColumn('action', function ($blog) {
                $html = '<a href="' . route('blog.edit', $blog->id) . '" class="btn btn-warning me-2 btn-sm"><i class="icon-base ti tabler-edit"></i></a>';
                $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $blog->id . '"> <i class="icon-base ti tabler-trash"></i></button>';

                return $html;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/file-upload', 'public');
            $url = url('storage/' . $path); // gunakan `url()` bukan `asset()` untuk hasil yang bersih
            // saya tidak ingin mengembalikan path, tapi URL yang bisa diakses env('APP_URL')/storage/uploads/file-upload/filename.ext
            $url_public = '../storage/' . $path;
            return response()->json(['location' => $url_public]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $request->validate([
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('blog', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        $request->merge([
            'user_id' => auth()->id(),
            'status' => $request->status ? '1' : '0', // 1 for published, 0 for draft/archive
        ]);

        Blog::create($request->all());
        return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $request->validate([
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('blog', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        $request->merge([
            'user_id' => auth()->id(),
            'status' => $request->status ? '1' : '0', // 1 for published, 0 for draft/archive
        ]);

        $blog->update($request->all());
        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return response()->json(['success' => 'Blog deleted successfully.']);
    }
}

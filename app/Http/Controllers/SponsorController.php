<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('sponsor.index');
    }

    protected function getDataTable()
    {
        $users = Sponsor::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('image', function ($sponsor) {
                return '<img src="' . asset($sponsor->image) . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
            })
            ->addColumn('action', function ($sponsor) {
                $html = '<a href="' . route('sponsor.edit', $sponsor->id) . '" class="btn btn-warning me-2 btn-sm"><i class="icon-base ti tabler-edit"></i></a>';
                $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $sponsor->id . '"> <i class="icon-base ti tabler-trash"></i></button>';

                return $html;
            })
            ->rawColumns(['image', 'venue', 'price', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sponsor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sponsor = new Sponsor();
        $sponsor->name = $request->name;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('sponsor', 'public');
            $url = Storage::url($path);
            $sponsor->image = $url;
        }
        $sponsor->save();

        return redirect()->route('sponsor.index')->with('success', 'Sponsor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('sponsor.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sponsor->name = $request->name;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('sponsor', 'public');
            $url = Storage::url($path);
            $sponsor->image = $url;
        }
        $sponsor->save();

        return redirect()->route('sponsor.index')->with('success', 'Sponsor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sponsor deleted successfully.',
        ]);
    }
}

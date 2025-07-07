<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class OrganizationalStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('organizational.index');
    }

    protected function getDataTable()
    {
        $users = OrganizationalStructure::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('image', function ($organizational) {
                return '<img src="' . asset($organizational->image) . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
            })
            ->addColumn('action', function ($organizational) {
                $html = '<a href="' . route('organizational-structure.edit', $organizational->id) . '" class="btn btn-warning me-2 btn-sm"><i class="icon-base ti tabler-edit"></i></a>';
                // detail
                $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $organizational->id . '"> <i class="icon-base ti tabler-trash"></i></button>';
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
        return view('organizational.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('org', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        OrganizationalStructure::create($request->all());

        Alert::success('Success', 'Organizational Structure created successfully');
        return redirect()->route('organizational-structure.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationalStructure $organizational) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationalStructure $organizational_structure)
    {

        return view('organizational.edit', compact('organizational_structure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizationalStructure $organizational_structure)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('org', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        $organizational_structure->update($request->all());

        Alert::success('Success', 'Organizational Structure updated successfully');
        return redirect()->route('organizational-structure.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationalStructure $organizational_structure)
    {
        $organizational_structure->delete();
        return response()->json(['status' => 'success']);
    }
}

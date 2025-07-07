<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('admin.index');
    }

    /**
     * Get the data for the DataTable.
     */
    protected function getDataTable()
    {
        $users = User::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('phone', function ($user) {
                return '+62' . $user->phone;
            })
            ->editColumn('status', function ($user) {
                return $user->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($user) {
                $html = '<a href="' . route('admin.edit', $user->id) . '" class="btn btn-warning me-2 btn-sm">Edit</a>';
                $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $user->id . '">Delete</button>';
                return $html;
            })
            ->rawColumns(['phone', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status ? 1 : 0,
            'password' => bcrypt('password'),
            'phone' => $request->phone,
            'role' => 1,
        ]);

        return redirect()->route('admin.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',

        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status ? 1 : 0,
        ]);

        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }
}

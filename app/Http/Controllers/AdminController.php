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
                $html = '<button class="btn btn-warning btn-sm me-2 btn-edit" data-id="' . $user->id . '" data-name="' . $user->name . '" data-email="' . $user->email . '" data-phone="' . $user->phone . '" data-status="' . $user->status . '" >Edit</button>';
                $html .= '<form action="' . route('admin.destroy', $user->id) . '" method="POST" style="display:inline;">';
                $html .= csrf_field();
                $html .= method_field('DELETE');
                $html .= '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                $html .= '</form>';
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

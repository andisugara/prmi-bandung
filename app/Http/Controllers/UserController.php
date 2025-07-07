<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('user.index');
    }

    protected function getDataTable()
    {
        $users = User::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('image', function ($user) {
                if (!$user->image) {
                    return '<img src="' . asset('images/prmi-logo.webp') . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
                }
                return '<img src="' . asset($user->image) . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
            })
            ->addColumn('is_member', function ($user) {
                return $user->userMember ? '<span class="badge badge-primary">Member</span>' : '<span class="badge badge-secondary">Non Member</span>';
            })

            ->rawColumns(['image', 'is_member'])
            ->make(true);
    }
}

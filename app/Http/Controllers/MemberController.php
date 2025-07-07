<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('member.index');
    }

    protected function getDataTable()
    {
        $users = Member::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('price', function ($member) {
                return formatRupiah($member->price);
            })
            ->editColumn('benefits', function ($member) {
                if ($member->memberBenefits->isEmpty()) {
                    return '-';
                }
                $html = '<ul class="">';
                foreach ($member->memberBenefits as $benefit) {
                    $html .= '<li class="">' . $benefit->benefit->name . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('action', function ($sponsor) {
                $html = '<a href="' . route('member.edit', $sponsor->id) . '" class="btn btn-warning me-2 btn-sm"><i class="icon-base ti tabler-edit"></i></a>';
                $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $sponsor->id . '"> <i class="icon-base ti tabler-trash"></i></button>';

                return $html;
            })
            ->rawColumns(['benefits', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $benefits = Benefit::all();
        return view('member.create', compact('benefits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'price' => 'required|min:0',
            'color' => 'required|string',
            'benefits' => 'nullable|array',
            'benefits.*' => 'exists:benefits,id',
            'slug' => 'required|string|max:255|unique:members,slug',

        ]);

        $member = Member::create([
            'name' => $request->name,
            'badge' => $request->badge,
            'price' => rupiahToNumber($request->price),
            'color' => $request->color,
        ]);

        // Simpan relasi benefits
        if ($request->has('benefits')) {
            foreach ($request->benefits as $benefitId) {
                $member->memberBenefits()->create([
                    'benefit_id' => $benefitId,
                ]);
            }
        }

        return redirect()->route('member.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $benefits = Benefit::all();
        $memberBenefits = $member->memberBenefits->pluck('benefit_id')->toArray();
        return view('member.edit', compact('member', 'benefits', 'memberBenefits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'price' => 'required|min:0',
            'color' => 'required|string',
            'benefits' => 'nullable|array',
            'benefits.*' => 'exists:benefits,id',
            'slug' => 'required|string|max:255|unique:members,slug,' . $member->id,
        ]);

        $member->update([
            'name' => $request->name,
            'badge' => $request->badge,
            'price' => rupiahToNumber($request->price),
            'color' => $request->color,
        ]);

        // Hapus relasi benefits yang tidak ada di request
        $member->memberBenefits()->whereNotIn('benefit_id', $request->benefits)->delete();

        // Simpan relasi benefits yang baru
        if ($request->has('benefits')) {
            foreach ($request->benefits as $benefitId) {
                $member->memberBenefits()->updateOrCreate(
                    ['benefit_id' => $benefitId],
                    []
                );
            }
        }

        return redirect()->route('member.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Member deleted successfully.',
        ]);
    }
}

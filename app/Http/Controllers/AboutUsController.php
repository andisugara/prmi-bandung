<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting as AboutUs;
use RealRashid\SweetAlert\Facades\Alert;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about_us = AboutUs::first() ?? new AboutUs();
        return view('about-us.index', compact('about_us'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $about_us = AboutUs::first() ?? new AboutUs();
        $about_us->fill(array_merge(
            $about_us->toArray(), // Data lama
            $request->all() // Data baru dari request
        ));

        $about_us->save();

        Alert::success('Success', 'AboutUss updated successfully.');

        return redirect()->route('about-us.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutUs $about_us)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutUs $about_us)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutUs $about_us)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutUs $about_us)
    {
        //
    }
}

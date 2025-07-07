<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('event.index');
    }

    protected function getDataTable()
    {
        $users = Event::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('image', function ($event) {
                return '<img src="' . asset($event->image) . '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">';
            })
            ->editColumn('status', function ($event) {
                // upcoming, ongoing, completed, cancelled, closed
                switch ($event->status) {
                    case 'upcoming':
                        return '<span class="badge badge-primary">Upcoming</span>';
                    case 'ongoing':
                        return '<span class="badge badge-success">Ongoing</span>';
                    case 'completed':
                        return '<span class="badge badge-info">Completed</span>';
                    case 'cancelled':
                        return '<span class="badge badge-danger">Cancelled</span>';
                    case 'closed':
                        return '<span class="badge badge-secondary">Closed</span>';
                    default:
                        return '<span class="badge badge-warning">Unknown</span>';
                }
            })
            ->editColumn('venue', function ($event) {
                // location
                // tanggal mulai
                // tanggal selesai
                $html = '<i class="icon-base ti tabler-map-pin"></i> ' . $event->location . '<br>';
                $html .= '<i class="icon-base ti tabler-calendar"></i> ' . \Carbon\Carbon::parse($event->start_date)->translatedFormat('d-m-Y H:i') . ' sd';
                $html .= '<br>';
                $html .= '<i class="icon-base ti tabler-calendar"></i> ' . \Carbon\Carbon::parse($event->end_date)->translatedFormat('d-m-Y H:i');
                // quota
                $html .= '<br>';
                $html .= '<i class="icon-base ti tabler-users"></i> ' . $event->quota . ' Kuota';
                return $html;
            })
            ->editColumn('price', function ($event) {
                $html = '<i class="icon-base ti tabler-user"></i> ' . 'Member: Rp ' . number_format($event->member_price, 0, ',', '.') . '<br>';
                $html .= '<i class="icon-base ti tabler-user"></i> ' . 'Non Member: Rp ' . number_format($event->non_member_price, 0, ',', '.') . '<br>';
                $html .= '<i class="icon-base ti tabler-user"></i> ' . 'Normal: Rp ' . number_format($event->normal_price, 0, ',', '.') . '<br>';
                return $html;
            })
            ->addColumn('action', function ($event) {
                $html = '<a href="' . route('event.edit', $event->id) . '" class="btn btn-warning me-2 btn-sm"><i class="icon-base ti tabler-edit"></i></a>';
                // detail
                $html .= '<a href="' . route('event.show', $event->id) . '" class="btn btn-info me-2 btn-sm"><i class="icon-base ti tabler-eye"></i></a>';
                if ($event->status == 'upcoming') {
                    $html .= '<button type="button" class="btn btn-danger btn-sm delete-user" data-id="' . $event->id . '"> <i class="icon-base ti tabler-trash"></i></button>';
                }
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
        return view('event.create');
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
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:upcoming,ongoing,completed,cancelled,closed',
            'thumbnail' => 'nullable|max:5120', // 5MB
            'member_price' => 'required',
            'non_member_price' => 'required',
            'normal_price' => 'required',
            'quota' => 'required|integer|min:1',
            'slug' => 'required|string|max:255|unique:events,slug',
        ]);

        // check if slug already exists


        $request->merge([
            'start_date' => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->end_date)->format('Y-m-d H:i:s'),
            'member_price' => str_replace(',', '', str_replace('Rp ', '', $request->member_price)),
            'non_member_price' => str_replace(',', '', str_replace('Rp ', '', $request->non_member_price)),
            'normal_price' => str_replace(',', '', str_replace('Rp ', '', $request->normal_price))
        ]);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('events', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        Event::create($request->all());

        Alert::success('Success', 'Event created successfully.');
        return redirect()->route('event.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // Format the date indonesian style
        $event->start_date = \Carbon\Carbon::parse($event->start_date)->translatedFormat('d-m-Y H:i');
        $event->end_date = \Carbon\Carbon::parse($event->end_date)->translatedFormat('d-m-Y H:i');
        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Format the date indonesian style
        $event->start_date = \Carbon\Carbon::parse($event->start_date)->translatedFormat('d-m-Y H:i');
        $event->end_date = \Carbon\Carbon::parse($event->end_date)->translatedFormat('d-m-Y H:i');
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:upcoming,ongoing,completed,cancelled,closed',
            'thumbnail' => 'nullable|max:5120', // 5MB
            'member_price' => 'required',
            'non_member_price' => 'required',
            'normal_price' => 'required',
            'quota' => 'required|integer|min:1',
            'slug' => 'required|string|max:255|unique:events,slug,' . $event->id,

        ]);

        $request->merge([
            'start_date' => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->end_date)->format('Y-m-d H:i:s'),
            'member_price' => str_replace(',', '', str_replace('Rp ', '', $request->member_price)),
            'non_member_price' => str_replace(',', '', str_replace('Rp ', '', $request->non_member_price)),
            'normal_price' => str_replace(',', '', str_replace('Rp ', '', $request->normal_price))
        ]);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('events', 'public');
            $url = Storage::url($path);
            $request->merge(['image' => $url]);
        }

        $event->update($request->all());

        Alert::success('Success', 'Event updated successfully.');
        return redirect()->route('event.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['status' => 'success']);
    }
}

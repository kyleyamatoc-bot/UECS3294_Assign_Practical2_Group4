<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventBookingRequest;
use App\Http\Requests\Event\UpdateEventBookingRequest;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    private $catalog = [
        'Bowling Championship 2025' => ['date' => '2026-10-01', 'venue' => 'BowlZone, Sungai Long', 'price' => 50.00, 'img' => 'bowlingtour1.jpg'],
        'Family Bowling Day' => ['date' => '2026-10-10', 'venue' => 'BowlZone, Sungai Long', 'price' => 5.00, 'img' => 'bowlingtour2ex.jpg'],
        'Junior Bowling Cup' => ['date' => '2026-10-13', 'venue' => 'BowlZone, Sungai Long', 'price' => 15.00, 'img' => 'Junior1.jpg'],
        'GITD Bowling' => ['date' => '2026-10-25', 'venue' => 'BowlZone, Sungai Long', 'price' => 25.00, 'img' => 'glowbowling.jpg'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $bookings = $user->events()->latest('event_date')->get();
        $catalog = $this->catalog;

        return view('events.index', compact('bookings', 'catalog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalog = $this->catalog;
        $selected = request('name');

        return view('events.create', compact('catalog', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventBookingRequest $request)
    {
        $eventName = $request->event_name;
        if (!isset($this->catalog[$eventName])) {
            return back()->withInput()->withErrors(['event_name' => 'Invalid event selection.']);
        }

        $eventData = $this->catalog[$eventName];
        $participants = (int) $request->participants;

        /** @var User $user */
        $user = auth()->user();

        $user->events()->create([
            'event_name' => $eventName,
            'event_date' => $eventData['date'],
            'venue' => $eventData['venue'],
            'price_per_pax' => $eventData['price'],
            'phone' => $request->phone,
            'participants' => $participants,
            'total_paid' => $participants * $eventData['price'],
        ]);

        return redirect()->route('events.index')->with('status', 'Event booking created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('events.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $event = $user->events()->findOrFail($id);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventBookingRequest $request, $id)
    {
        /** @var User $user */
        $user = auth()->user();
        $event = $user->events()->findOrFail($id);

        $participants = (int) $request->participants;
        $event->update([
            'phone' => $request->phone,
            'participants' => $participants,
            'total_paid' => $participants * $event->price_per_pax,
        ]);

        return redirect()->route('events.index')->with('status', 'Event booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $event = $user->events()->findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('status', 'Event booking cancelled.');
    }
}

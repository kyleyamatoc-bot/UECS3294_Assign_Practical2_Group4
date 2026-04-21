<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $bookings = $user->bookings()->latest('booking_date')->latest('booking_time')->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $bookingAt = Carbon::parse($request->booking_date . ' ' . $request->booking_time);
        if ($bookingAt->isPast()) {
            return back()->withInput()->withErrors(['booking_date' => 'You cannot book a past date/time.']);
        }

        $exists = Booking::whereDate('booking_date', $request->booking_date)
            ->whereTime('booking_time', $request->booking_time)
            ->where('lane', $request->lane)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['lane' => 'This lane and timeslot is already taken.']);
        }

        $players = (int) $request->players;
        $total = $players * 15;

        /** @var User $user */
        $user = auth()->user();

        $user->bookings()->create([
            'name' => $user->full_name,
            'email' => $user->email,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'lane' => $request->lane,
            'players' => $players,
            'total_amount' => $total,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('status', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('bookings.index');
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
        $booking = $user->bookings()->findOrFail($id);

        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.index')->withErrors(['booking' => 'Paid bookings cannot be modified.']);
        }

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, $id)
    {
        /** @var User $user */
        $user = auth()->user();
        $booking = $user->bookings()->findOrFail($id);

        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.index')->withErrors(['booking' => 'Paid bookings cannot be modified.']);
        }

        $bookingAt = Carbon::parse($request->booking_date . ' ' . $request->booking_time);
        if ($bookingAt->isPast()) {
            return back()->withInput()->withErrors(['booking_date' => 'You cannot book a past date/time.']);
        }

        $exists = Booking::whereDate('booking_date', $request->booking_date)
            ->whereTime('booking_time', $request->booking_time)
            ->where('lane', $request->lane)
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['lane' => 'This lane and timeslot is already taken.']);
        }

        $players = (int) $request->players;
        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'lane' => $request->lane,
            'players' => $players,
            'total_amount' => $players * 15,
        ]);

        return redirect()->route('bookings.index')->with('status', 'Booking updated successfully.');
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
        $booking = $user->bookings()->findOrFail($id);

        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.index')->withErrors(['booking' => 'Paid bookings cannot be cancelled.']);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('status', 'Booking cancelled successfully.');
    }
}

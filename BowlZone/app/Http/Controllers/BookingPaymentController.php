<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\ProcessBookingPaymentRequest;
use App\Models\Booking;
use Illuminate\Support\Carbon;

class BookingPaymentController extends Controller
{
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.index')->withErrors(['booking' => 'This booking is already paid.']);
        }

        return view('bookings.payment', compact('booking'));
    }

    public function process(ProcessBookingPaymentRequest $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.index')->withErrors(['booking' => 'This booking is already paid.']);
        }

        $method = $request->payment_method;
        $reference = null;

        if ($method === 'Card') {
            $reference = 'CARD-' . substr($request->card_number, -4);
        }
        if ($method === 'FPX') {
            $reference = 'FPX-' . strtoupper(substr($request->bank, 0, 3)) . rand(1000, 9999);
        }
        if ($method === 'E-Wallet') {
            $reference = 'WALLET-' . substr($request->wallet_phone, -4);
        }

        $booking->update([
            'payment_status' => 'paid',
            'payment_method' => $method,
            'payment_reference' => $reference,
            'paid_at' => Carbon::now(),
        ]);

        return redirect()->route('bookings.index')->with('status', 'Booking payment successful. Ref: ' . $reference);
    }
}

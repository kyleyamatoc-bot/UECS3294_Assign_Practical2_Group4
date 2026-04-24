<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Models\ContactMessage;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access to admin dashboard');
        }

        $totalMessages = ContactMessage::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalBookings = Booking::count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact('totalMessages', 'totalUsers', 'totalBookings', 'totalOrders'));
    }

    /**
     * Show all contact messages
     */
    public function contactMessages()
    {
        // Check authorization
        if (!Gate::allows('view-contact-messages')) {
            abort(403, 'Unauthorized access to contact messages');
        }

        $messages = ContactMessage::with('user')
            ->latest('created_at')
            ->paginate(15);

        return view('admin.contact-messages', compact('messages'));
    }

    /**
     * Show single contact message
     */
    public function showContactMessage(ContactMessage $contactMessage)
    {   // Check authorization
        if (!Gate::allows('view-contact-messages')) abort(403);

        $contactMessage->load('replies.admin');
        return view('admin.contact-message-detail', ['message' => $contactMessage]);
    }

    /**
     * Reply to contact message
     */
    public function replyContactMessage(Request $request, ContactMessage $contactMessage)
    {   // Check authorization
        if (!Gate::allows('view-contact-messages')) abort(403);
        // Validate input
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'min:10'],
            'status' => ['required', 'in:pending,read,solved'],
        ]);
        // Create reply
        $contactMessage->replies()->create([
            'admin_id' => auth()->id(),
            'reply_message' => $validated['reply_message'],
        ]);
        // Update message status
        $contactMessage->update(['status' => $validated['status'], 'is_read' => true]);

        return redirect()->route('admin.contact-message.show', $contactMessage)
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Delete contact message
     */
    public function deleteContactMessage(ContactMessage $contactMessage)
    {   // Check authorization
        if (!Gate::allows('delete-contact-message')) abort(403);

        $contactMessage->delete();

        return redirect()->route('admin.contact-messages')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Show all bookings
     */
    public function bookings()
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $bookings = Booking::with('user')
            ->latest('created_at')
            ->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Show edit form for a booking.
     */
    public function editBooking(Booking $booking)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('admin.bookings')->withErrors(['booking' => 'Paid bookings cannot be modified.']);
        }

        return view('admin.booking-edit', compact('booking'));
    }

    /**
     * Update a booking.
     */
    public function updateBooking(UpdateBookingRequest $request, Booking $booking)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('admin.bookings')->withErrors(['booking' => 'Paid bookings cannot be modified.']);
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

        return redirect()->route('admin.bookings')->with('success', 'Booking updated successfully.');
    }

    /**
     * Delete a booking.
     */
    public function deleteBooking(Booking $booking)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('admin.bookings')->withErrors(['booking' => 'Paid bookings cannot be deleted.']);
        }

        $booking->delete();

        return redirect()->route('admin.bookings')->with('success', 'Booking deleted successfully.');
    }

    /**
     * Show all orders
     */
    public function orders()
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $orders = Order::with('user', 'items')
            ->latest('created_at')
            ->paginate(15);

        return view('admin.orders', compact('orders'));
    }

    /**
     * Show all users
     */
    public function users()
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $users = User::where('is_admin', false)
            ->latest('created_at')
            ->paginate(15);

        return view('admin.users', compact('users'));
    }
}

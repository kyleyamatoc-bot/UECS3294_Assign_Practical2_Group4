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
    public function contactMessages(Request $request)
    {
        // Check authorization
        if (!Gate::allows('view-contact-messages')) {
            abort(403, 'Unauthorized access to contact messages');
        }

        $query = ContactMessage::with('user');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('inquiry_type', $request->input('type'));
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Sort
        $sort = $request->input('sort', 'date_latest');
        switch($sort) {
            case 'name_asc':
                $query->orderBy('first_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('first_name', 'desc');
                break;
            case 'date_earliest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $messages = $query->paginate(15);

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
    public function bookings(Request $request)
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $query = Booking::with('user');

        // Search by user name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->input('sort', 'date_latest');
        switch($sort) {
            case 'name_asc':
                $query->join('users', 'bookings.user_id', '=', 'users.id')
                      ->orderBy('users.first_name', 'asc');
                break;
            case 'name_desc':
                $query->join('users', 'bookings.user_id', '=', 'users.id')
                      ->orderBy('users.first_name', 'desc');
                break;
            case 'date_earliest':
                $query->orderBy('bookings.created_at', 'asc');
                break;
            case 'date_latest':
            default:
                $query->orderBy('bookings.created_at', 'desc');
                break;
        }

        $bookings = $query->paginate(15);

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
    public function users(Request $request)
    {
        // Check authorization
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $query = User::where('is_admin', false);

        // Search by name, email, or username
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->input('sort', 'date_latest');
        switch($sort) {
            case 'name_asc':
                $query->orderBy('first_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('first_name', 'desc');
                break;
            case 'date_earliest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $users = $query->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($user->is_admin) {
            abort(403, 'Cannot edit admin users');
        }

        return view('admin.users-edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($user->is_admin) {
            abort(403, 'Cannot edit admin users');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser(Request $request, User $user)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        if ($user->is_admin) {
            abort(403, 'Cannot delete admin users');
        }

        $deleteOption = $request->input('delete_option', 'soft'); // 'soft' or 'hard'

        if ($deleteOption === 'hard') {
            // Hard delete - cascade delete related data
            $user->delete();
            return redirect()->route('admin.users')
                ->with('success', 'User and all associated data deleted permanently.');
        } else {
            // Soft delete - just remove account but keep data for records
            $user->update([
                'username' => 'deleted_' . $user->id . '_' . time(),
                'email' => 'deleted_' . $user->id . '@deleted.local',
                'password' => null,
            ]);

            return redirect()->route('admin.users')
                ->with('success', 'User account deactivated. Data retained for records.');
        }
    }
}

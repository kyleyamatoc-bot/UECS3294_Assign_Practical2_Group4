<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

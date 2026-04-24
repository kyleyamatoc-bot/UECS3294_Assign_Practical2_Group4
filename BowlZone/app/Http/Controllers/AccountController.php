<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = $user->bookings()->latest('booking_date')->paginate(5, ['*'], 'bookings_page');
        $orders = $user->orders()->with('items')->latest()->paginate(5, ['*'], 'orders_page');
        $messages = $user->contactMessages()->with('replies.admin', 'replies.user')->latest()->paginate(5, ['*'], 'messages_page');

        return view('account.index', compact('user', 'bookings', 'orders', 'messages'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'alpha_dash', 'unique:users,username,' . $request->user()->id],
        ]);

        $request->user()->update($validated);

        return back()->with('status', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[^A-Za-z0-9]/'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password changed successfully.');
    }
}

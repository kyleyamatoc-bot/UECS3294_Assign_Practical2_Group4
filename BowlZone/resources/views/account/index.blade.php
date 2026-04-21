@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="my-account-page">
    <h2>My Account</h2>

    <div class="account-container">
        <div class="profile-info">
            <h3>Profile Information</h3>
            <p><strong>First Name:</strong> {{ $user->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $user->last_name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Member Since:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
        </div>

        <div class="profile-actions">
            <div class="edit-profile form-box">
                <h3>Edit Profile</h3>
                <form method="POST" action="{{ route('account.profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <input name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="First Name" required>
                    <br><br>
                    <input name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name" required>
                    <br><br>
                    <input name="username" value="{{ old('username', $user->username) }}" placeholder="Username" required>
                    <br><br>
                    <button type="submit">Update Profile</button>
                </form>
            </div>

            <div class="reset-password form-box">
                <h3>Change Password</h3>
                <form method="POST" action="{{ route('account.password.update') }}">
                    @csrf
                    @method('PATCH')
                    <input type="password" name="current_password" placeholder="Current Password" required>
                    <br><br>
                    <input type="password" name="password" placeholder="New Password" required>
                    <br><br>
                    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                    <br><br>
                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-container">
        <h3>My Bowling Bookings</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Lane</th>
                <th>Players</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
            @forelse($bookings as $b)
            <tr>
                <td>{{ $b->booking_date->format('Y-m-d') }}</td>
                <td>{{ $b->booking_time }}</td>
                <td>{{ $b->lane }}</td>
                <td>{{ $b->players }}</td>
                <td>RM {{ number_format((float)$b->total_amount, 2) }}</td>
                <td>{{ ucfirst($b->payment_status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No bookings.</td>
            </tr>
            @endforelse
        </table>
        {{ $bookings->links() }}
    </div>

    <div class="table-container">
        <h3>My Event Bookings</h3>
        <table>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Participants</th>
                <th>Total</th>
            </tr>
            @forelse($events as $e)
            <tr>
                <td>{{ $e->event_name }}</td>
                <td>{{ $e->event_date->format('Y-m-d') }}</td>
                <td>{{ $e->participants }}</td>
                <td>RM {{ number_format((float)$e->total_paid, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No event bookings.</td>
            </tr>
            @endforelse
        </table>
        {{ $events->links() }}
    </div>

    <div class="table-container">
        <h3>My Purchased Items</h3>
        <table>
            <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Total</th>
                <th>Payment Ref</th>
            </tr>
            @forelse($orders as $o)
            <tr>
                <td>#{{ $o->id }}</td>
                <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
                <td>RM {{ number_format((float)$o->total_amount, 2) }}</td>
                <td>{{ $o->payment_reference }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No purchase records.</td>
            </tr>
            @endforelse
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection
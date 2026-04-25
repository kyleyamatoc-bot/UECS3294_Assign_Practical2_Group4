@extends('layouts.app')

@section('title', 'My Account')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection

@section('content')
<div class="my-account-page">
    <h2>My Account</h2>

    @if (session('success'))
    <div class="message success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="message error">{{ session('error') }}</div>
    @endif

    <div class="account-container">
        <!-- Profile Info -->
        <div class="profile-info">
            <h3>Profile Information</h3>
            <p><strong>First Name:</strong> {{ $user->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $user->last_name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Member Since:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
        </div>

        <div class="profile-actions">
            <!-- Edit Profile Form -->
            <div class="form-box" id="editProfileForm">
                <h3>Edit Profile</h3>
                @if ($errors->hasBag('profile') || (!$errors->hasBag('password') && $errors->any()))
                <div class="message error">Please fix the errors below.</div>
                @endif
                <form method="POST" action="{{ route('account.profile.update') }}" id="editProfileFormElement" novalidate>
                    @csrf
                    @method('PATCH')

                    <input type="text" id="firstName" name="first_name"
                        value="{{ old('first_name', $user->first_name) }}"
                        placeholder="First Name" required>
                    <span class="error" id="firstNameError">
                        @error('first_name'){{ $message }}@enderror
                    </span>

                    <input type="text" id="lastName" name="last_name"
                        value="{{ old('last_name', $user->last_name) }}"
                        placeholder="Last Name" required>
                    <span class="error" id="lastNameError">
                        @error('last_name'){{ $message }}@enderror
                    </span>

                    <input type="text" id="username" name="username"
                        value="{{ old('username', $user->username) }}"
                        placeholder="Username" required>
                    <span class="error" id="usernameError">
                        @error('username'){{ $message }}@enderror
                    </span>

                    <button type="submit">Update Profile</button>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="form-box">
                <h3>Change Password</h3>
                <form method="POST" action="{{ route('account.password.update') }}" id="resetPasswordForm" novalidate>
                    @csrf
                    @method('PATCH')

                    <input type="password" id="currentPassword" name="current_password"
                        placeholder="Current Password" required>
                    <span class="error" id="currentPasswordError">
                        @error('current_password'){{ $message }}@enderror
                    </span>

                    <input type="password" id="newPassword" name="password"
                        placeholder="New Password" required>
                    <span class="error" id="newPasswordError">
                        @error('password'){{ $message }}@enderror
                    </span>

                    <input type="password" id="confirmPassword" name="password_confirmation"
                        placeholder="Confirm New Password" required>
                    <span class="error" id="confirmPasswordError"></span>

                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
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
        @if($bookings->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>

    <!-- Orders Table -->
    <div class="table-container">
        <h3>My Purchased Items</h3>
        @forelse($orders as $order)
        <div class="order-section">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h4>Order #{{ $order->id }}</h4>
                    <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>Payment:</strong> {{ ucfirst($order->payment_status) }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 1.3rem; color: #dc3545; font-weight: bold; margin: 0;">
                        RM {{ number_format((float)$order->total_amount, 2) }}
                    </p>
                    <p style="color: #666; font-size: 0.85rem; margin-top: 0.5rem;">
                        Ref: {{ $order->payment_reference }}
                    </p>
                </div>
            </div>

            <div style="border-top: 2px solid #ddd; padding-top: 1rem;">
                @forelse($order->items as $item)
                <div class="order-item">
                    <div style="flex-shrink: 0;">
                        @if($item->product && $item->product->image_path)
                        <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product_name }}">
                        @else
                        <div style="width:100px;height:100px;background:#e9ecef;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999;border:2px solid #dc3545;">
                            No Image
                        </div>
                        @endif
                    </div>
                    <div class="order-item-details">
                        <h5>{{ $item->product_name }}</h5>
                        @if($item->variant)
                        <p><strong>Variant:</strong> {{ $item->variant }}</p>
                        @endif
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:0.5rem;">
                            <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                            <p><strong>Unit Price:</strong> RM {{ number_format((float)$item->unit_price, 2) }}</p>
                        </div>
                    </div>
                    <div class="order-item-total">
                        <p>RM {{ number_format((float)$item->total_price, 2) }}</p>
                    </div>
                </div>
                @empty
                <p style="color:#666;font-style:italic;text-align:center;padding:1rem;">No items in this order.</p>
                @endforelse
            </div>
        </div>
        @empty
        <p style="text-align:center;color:#666;padding:2rem;">No purchase records.</p>
        @endforelse

        @if($orders->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Include Messages Section -->
@include('account.messages-section')

@endsection
@extends('layouts.app')

@section('title', 'Bookings - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>
        <h1>Bookings</h1>
        <p class="admin-subtitle">Manage all bowling lane bookings</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('admin.bookings') }}" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="search-input">
            </div>

            <div class="filter-dropdown">
                <select name="sort" class="filter-select">
                    <option value="date_latest" {{ request('sort') === 'date_latest' ? 'selected' : '' }}>Date: Latest</option>
                    <option value="date_earliest" {{ request('sort') === 'date_earliest' ? 'selected' : '' }}>Date: Earliest</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A - Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z - A</option>
                </select>
            </div>

            <button type="submit" class="search-btn">Search</button>
            <div style="text-align: center; margin-top: 0.5rem;">
                <a href="{{ route('admin.bookings') }}" class="reset-filter">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Booking Date</th>
                    <th>Time</th>
                    <th>Lane</th>
                    <th>Players</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Booked Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                <tr>
                    <td><strong>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</strong></td>
                    <td>{{ $booking->booking_date->format('M d, Y') }}</td>
                    <td>{{ $booking->booking_time }}</td>
                    <td>{{ $booking->lane }}</td>
                    <td>{{ $booking->players }}</td>
                    <td><strong>RM {{ number_format($booking->total_amount, 2) }}</strong></td>
                    <td><span class="badge badge-{{ strtolower($booking->payment_status) }}">{{ ucfirst($booking->payment_status) }}</span></td>
                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                    <td>
                        @if ($booking->payment_status !== 'paid')
                        <div class="booking-actions">
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="table-action-btn table-action-btn-edit">Modify</a>
                        <form method="POST" action="{{ route('admin.bookings.delete', $booking) }}" class="booking-actions-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="table-action-btn table-action-btn-delete" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                        </form>
                        </div>
                        @else
                        <span class="text-muted">Locked</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($bookings->hasPages())
    <div class="pagination-wrapper">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection

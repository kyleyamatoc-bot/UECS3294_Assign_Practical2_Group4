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
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No bookings found.</td>
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
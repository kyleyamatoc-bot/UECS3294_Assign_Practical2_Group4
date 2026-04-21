@extends('layouts.app')

@section('title', 'My Bookings')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

@section('content')
<div class="card" id="BookingHeadTop">
    <h2 class="section-title">My Bookings</h2>
    <a class="btn" href="{{ route('bookings.create') }}">Book New Lane</a>
</div>

<div class="card table-container">
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Lane</th>
            <th>Players</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
        @forelse($bookings as $booking)
        <tr>
            <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
            <td>{{ $booking->booking_time }}</td>
            <td>{{ $booking->lane }}</td>
            <td>{{ $booking->players }}</td>
            <td>RM {{ number_format((float)$booking->total_amount, 2) }}</td>
            <td>
                <span class="{{ $booking->payment_status === 'paid' ? 'paid' : 'unpaid' }}">{{ ucfirst($booking->payment_status) }}</span>
            </td>
            <td>
                @if($booking->payment_status === 'pending')
                <a class="btn btn-modify" href="{{ route('bookings.edit', $booking->id) }}">Edit</a>
                <a class="btn success" href="{{ route('bookings.payment.show', $booking->id) }}">Pay</a>
                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-cancel" type="submit">Cancel</button>
                </form>
                @else
                <span>Paid ({{ $booking->payment_reference }})</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No bookings found.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection
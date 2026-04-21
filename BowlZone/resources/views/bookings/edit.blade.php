@extends('layouts.app')

@section('title', 'Edit Booking')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

@section('content')
<div class="card" style="max-width:680px; margin:0 auto;">
    <h2 class="section-title">Edit Booking</h2>
    <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
        @csrf
        @method('PUT')

        <label>Booking Date</label>
        <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>

        <label>Booking Time</label>
        <input type="time" name="booking_time" value="{{ old('booking_time', substr($booking->booking_time,0,5)) }}" required>

        <label>Lane (1-10)</label>
        <input type="number" name="lane" min="1" max="10" value="{{ old('lane', $booking->lane) }}" required>

        <label>Players (1-6)</label>
        <input type="number" name="players" min="1" max="6" value="{{ old('players', $booking->players) }}" required>

        <button class="btn" type="submit">Update Booking</button>
    </form>
</div>
@endsection
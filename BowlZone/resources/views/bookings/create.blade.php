@extends('layouts.app')

@section('title', 'Book a Lane')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

@section('content')
<div class="card" style="max-width:680px; margin:0 auto;">
    <h2 class="section-title">Book a Lane</h2>
    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf
        <label>Booking Date</label>
        <input type="date" name="booking_date" value="{{ old('booking_date') }}" required>

        <label>Booking Time</label>
        <input type="time" name="booking_time" value="{{ old('booking_time') }}" required>

        <label>Lane (1-10)</label>
        <input type="number" name="lane" min="1" max="10" value="{{ old('lane') }}" required>

        <label>Players (1-6)</label>
        <input type="number" name="players" min="1" max="6" value="{{ old('players', 1) }}" required>

        <button class="btn" type="submit">Confirm Booking</button>
    </form>
</div>
@endsection
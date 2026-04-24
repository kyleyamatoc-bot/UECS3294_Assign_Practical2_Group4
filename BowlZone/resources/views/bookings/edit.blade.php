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
<div class="booking-page booking-enhanced">
    <div class="booking-shell">
        <div class="booking-hero">
            <h2 class="section-title">Edit Booking</h2>
            <p class="booking-subtitle">Adjust your lane reservation quickly with a clearer, more visual booking flow.</p>
        </div>

        <div class="card booking-card">
        <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
            @csrf
            @method('PUT')

            <label><span class="field-icon">&#x1F4C5;</span> Booking Date</label>
            <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>

            <label><span class="field-icon">&#x23F0;</span> Booking Time</label>
            <select name="booking_time" required>
                <option value="">Select Time</option>
                @php $selectedTime = old('booking_time', substr($booking->booking_time, 0, 5)); @endphp
                @for($hour = 0; $hour <= 23; $hour++)
                @php
                $timeValue = sprintf('%02d:00', $hour);
                $displayHour = $hour % 12 === 0 ? 12 : $hour % 12;
                $displayMeridiem = $hour >= 12 ? 'PM' : 'AM';
                @endphp
                <option value="{{ $timeValue }}" {{ $selectedTime === $timeValue ? 'selected' : '' }}>
                    {{ $displayHour }}:00 {{ $displayMeridiem }}
                </option>
                @endfor
            </select>

            <label><span class="field-icon">&#x1F3B3;</span> Choose Lane</label>
            <div class="lane-options">
                @for($lane = 1; $lane <= 10; $lane++)
                <div class="lane-option">
                    <label>
                        <input type="radio" name="lane" value="{{ $lane }}" {{ (string) old('lane', $booking->lane) === (string) $lane ? 'checked' : '' }} required>
                        <span class="lane-card">Lane {{ $lane }}</span>
                    </label>
                </div>
                @endfor
            </div>

            <label><span class="field-icon">&#x1F465;</span> Number of Players</label>
            <div class="player-options">
                @for($players = 1; $players <= 6; $players++)
                <div class="player-option">
                    <label>
                        <input type="radio" name="players" value="{{ $players }}" {{ (string) old('players', $booking->players) === (string) $players ? 'checked' : '' }} required>
                        <span class="player-card">{{ $players }} {{ $players === 1 ? 'Player' : 'Players' }}</span>
                    </label>
                </div>
                @endfor
            </div>

            <button class="btn booking-cta" type="submit">Update Booking</button>
        </form>
        </div>
    </div>
</div>
@endsection

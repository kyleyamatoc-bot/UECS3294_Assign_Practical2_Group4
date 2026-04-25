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
        <form method="POST" action="{{ route('bookings.update', $booking->id) }}" data-booking-form novalidate>
            @csrf
            @method('PUT')

            <label>
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M3 10H21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M8 3V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 3V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                Booking Date
            </label>
            <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>
            <div class="form-error" data-error-for="booking_date">@error('booking_date'){{ $message }}@enderror</div>

            <label>
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M12 7V12L15.5 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                Booking Time
            </label>
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
            <div class="form-error" data-error-for="booking_time">@error('booking_time'){{ $message }}@enderror</div>

            <label>
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="3.5" width="14" height="17" rx="3" stroke="currentColor" stroke-width="1.8"/>
                        <circle cx="9" cy="8" r="1" fill="currentColor"/>
                        <circle cx="12" cy="8" r="1" fill="currentColor"/>
                        <circle cx="15" cy="8" r="1" fill="currentColor"/>
                    </svg>
                </span>
                Choose Lane
            </label>
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
            <div class="form-error" data-error-for="lane">@error('lane'){{ $message }}@enderror</div>

            <label>
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="9" cy="9" r="3" stroke="currentColor" stroke-width="1.8"/>
                        <circle cx="16" cy="10" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M4.5 19.5C5.3 16.9 7.2 15.5 9.5 15.5C11.8 15.5 13.7 16.9 14.5 19.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M14 18.5C14.6 16.9 15.9 16 17.4 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                Number of Players
            </label>
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
            <div class="form-error" data-error-for="players">@error('players'){{ $message }}@enderror</div>

            <button class="btn booking-cta" type="submit">Update Booking</button>
        </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Booking - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.bookings') }}" class="back-link">← Back to Bookings</a>
        <h1>Edit Booking</h1>
        <p class="admin-subtitle">Modify the selected booking details</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-error">
        <ul class="alert-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="detail-container">
        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="admin-form-grid" data-booking-form novalidate>
            @csrf
            @method('PUT')

            <div class="form-field">
                <label for="booking_date">Booking Date</label>
                <input id="booking_date" type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>
                <div class="form-error" data-error-for="booking_date">@error('booking_date'){{ $message }}@enderror</div>
            </div>

            <div class="form-field">
                <label for="booking_time">Booking Time</label>
                <select id="booking_time" name="booking_time" required>
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
            </div>

            <div class="form-field">
                <label>Lane Choice</label>
                <div class="choice-grid">
                    @for($lane = 1; $lane <= 10; $lane++)
                    <label class="choice-pill">
                        <input type="radio" name="lane" value="{{ $lane }}" {{ (string) old('lane', $booking->lane) === (string) $lane ? 'checked' : '' }} required>
                        <span>Lane {{ $lane }}</span>
                    </label>
                    @endfor
                </div>
                <div class="form-error" data-error-for="lane">@error('lane'){{ $message }}@enderror</div>
            </div>

            <div class="form-field">
                <label>Player Amount</label>
                <div class="choice-grid choice-grid-players">
                    @for($players = 1; $players <= 6; $players++)
                    <label class="choice-pill">
                        <input type="radio" name="players" value="{{ $players }}" {{ (string) old('players', $booking->players) === (string) $players ? 'checked' : '' }} required>
                        <span>{{ $players }} {{ $players === 1 ? 'Player' : 'Players' }}</span>
                    </label>
                    @endfor
                </div>
                <div class="form-error" data-error-for="players">@error('players'){{ $message }}@enderror</div>
            </div>

            <div class="form-actions">
                <button class="action-btn action-btn-primary" type="submit">Update Booking</button>
            </div>
        </form>
    </div>
</div>
@endsection

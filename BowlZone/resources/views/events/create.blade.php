@extends('layouts.app')

@section('title', 'Book Event')

@section('bodyClass', 'event-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/event.js') }}"></script>
@endsection

@section('content')
<div class="card" style="max-width:700px; margin:0 auto;">
    <h2 class="section-title">Book Event</h2>
    <form method="POST" action="{{ route('events.store') }}">
        @csrf

        <label>Event</label>
        <select name="event_name" required>
            <option value="">Select Event</option>
            @foreach($catalog as $name => $event)
            <option value="{{ $name }}" @if(old('event_name', $selected)===$name) selected @endif>
                {{ $name }} ({{ $event['date'] }}) - RM {{ number_format((float)$event['price'], 2) }}
            </option>
            @endforeach
        </select>

        <label>Phone</label>
        <input name="phone" value="{{ old('phone') }}" required>

        <label>Participants</label>
        <input type="number" name="participants" min="1" max="30" value="{{ old('participants', 1) }}" required>

        <button class="btn" type="submit">Confirm Event Booking</button>
    </form>
</div>
@endsection
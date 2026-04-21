@extends('layouts.app')

@section('title', 'Modify Event Booking')

@section('bodyClass', 'event-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/event.js') }}"></script>
@endsection

@section('content')
<div class="card" style="max-width:700px; margin:0 auto;">
    <h2 class="section-title">Modify Event Booking</h2>
    <p><strong>{{ $event->event_name }}</strong> | {{ $event->event_date->format('Y-m-d') }} | {{ $event->venue }}</p>

    <form method="POST" action="{{ route('events.update', $event->id) }}">
        @csrf
        @method('PUT')

        <label>Phone</label>
        <input name="phone" value="{{ old('phone', $event->phone) }}" required>

        <label>Participants</label>
        <input type="number" name="participants" min="1" max="30" value="{{ old('participants', $event->participants) }}" required>

        <button class="btn" type="submit">Update Booking</button>
    </form>
</div>
@endsection
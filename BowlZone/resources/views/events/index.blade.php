@extends('layouts.app')

@section('title', 'Events')

@section('bodyClass', 'event-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/event.js') }}"></script>
@endsection

@section('content')
<h1 class="events-header">Upcoming Events</h1>

<div class="events-page">
    <div class="events-layout">
        <div class="event-list">
            @foreach($catalog as $name => $event)
            <article class="event-card">
                <div class="event-thumb">
                    <img src="{{ asset('images/events/' . $event['img']) }}" alt="{{ $name }}">
                    <div class="event-date">
                        <span class="day">{{ \Illuminate\Support\Carbon::parse($event['date'])->format('d') }}</span>
                        <span class="mon">{{ \Illuminate\Support\Carbon::parse($event['date'])->format('M') }}</span>
                    </div>
                </div>
                <div class="event-body">
                    <h2>{{ $name }}</h2>
                    <p class="meta">Date: {{ $event['date'] }}</p>
                    <p class="meta">Venue: {{ $event['venue'] }}</p>
                    <p class="price">RM {{ number_format((float)$event['price'], 2) }} / pax</p>
                    <a class="btn" href="{{ route('events.create', ['name' => $name]) }}">Join Now</a>
                </div>
            </article>
            @endforeach
        </div>
        <aside class="card">
            <h3>Ready to join?</h3>
            <a class="btn" href="{{ route('events.create') }}">Book Event</a>
            <div style="margin-top:16px; display:grid; gap:12px;">
                <img src="{{ asset('images/events/ads1.jpg') }}" alt="Event ad 1" style="width:100%; border-radius:10px;">
                <img src="{{ asset('images/events/ads2.jpg') }}" alt="Event ad 2" style="width:100%; border-radius:10px;">
                <img src="{{ asset('images/events/ads3.jpg') }}" alt="Event ad 3" style="width:100%; border-radius:10px;">
                <img src="{{ asset('images/events/ads4.jpg') }}" alt="Event ad 4" style="width:100%; border-radius:10px;">
            </div>
        </aside>
    </div>
</div>

<div class="card table-container">
    <h3>My Event Bookings</h3>
    <table>
        <tr>
            <th>Event</th>
            <th>Date</th>
            <th>Pax</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        @forelse($bookings as $event)
        <tr>
            <td>{{ $event->event_name }}</td>
            <td>{{ $event->event_date->format('Y-m-d') }}</td>
            <td>{{ $event->participants }}</td>
            <td>RM {{ number_format((float)$event->total_paid, 2) }}</td>
            <td>
                <a class="btn" href="{{ route('events.edit', $event->id) }}">Modify</a>
                <form method="POST" action="{{ route('events.destroy', $event->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn danger" type="submit">Cancel</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No event bookings yet.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Contact Us')

@section('bodyClass', 'contact-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/contact.js') }}"></script>
@endsection

@section('content')
<div class="contact-container">
    <div class="contact-form-wrapper">
        <h2>Contact Us</h2>
        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            <label>First Name</label>
            <input name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>

            <label>Last Name</label>
            <input name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>

            <label>Phone</label>
            <input name="phone" value="{{ old('phone') }}">

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>

            <label>Message</label>
            <textarea name="message" rows="6" required>{{ old('message') }}</textarea>

            <input type="submit" value="Send Message">
        </form>
    </div>
    <aside class="contact-info">
        <h2>Visit BowlZone</h2>
        <p>Need help with bookings, events, or orders? Reach out and we will assist quickly.</p>
        <p>Email: <a href="mailto:support@bowlzone.com">support@bowlzone.com</a></p>
        <p>Phone: <a href="tel:+60312345678">+60 3-1234 5678</a></p>
    </aside>
</div>
@endsection
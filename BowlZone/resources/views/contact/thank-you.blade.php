@extends('layouts.app')

@section('title', 'Contact Submitted')

@section('bodyClass', 'contact-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
<style>
    /* Hide top success messages on thank-you page */
    .message.success {
        display: none !important;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/contact.js') }}"></script>
@endsection

@section('content')
<div class="contact-wrapper">
    <div class="thank-you-container">
        <div class="thank-you-content">
            <div class="thank-you-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="38" stroke="#dc3545" stroke-width="2" />
                    <path d="M25 42L35 52L55 32" stroke="#dc3545" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                </svg>
            </div>

            <h2>Thank You!</h2>

            <p class="thank-you-message">Your message has been sent successfully.</p>

            <p class="thank-you-description">
                We appreciate you reaching out to us. Our team will review your inquiry and get back to you as soon as possible.
            </p>

            <div class="thank-you-actions">
                <a href="{{ route('contact.create') }}" class="btn-secondary">Send Another Message</a>
                <a href="{{ route('home') }}" class="btn-primary">Return Home</a>
            </div>
        </div>
    </div>
</div>
@endsection
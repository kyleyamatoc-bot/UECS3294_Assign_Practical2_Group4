@extends('layouts.app')

@section('title', 'Booking Payment')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

@section('content')
<div class="card payment-form" style="max-width:680px; margin:0 auto;">
    <h2 class="section-title">Booking Payment</h2>
    <p>Booking #{{ $booking->id }} | Total: RM {{ number_format((float)$booking->total_amount, 2) }}</p>

    <form method="POST" action="{{ route('bookings.payment.process', $booking->id) }}">
        @csrf
        <label>Payment Method</label>
        <select name="payment_method" required>
            <option value="">Select</option>
            <option value="Card">Card</option>
            <option value="FPX">FPX</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>

        <label>Card Number (for Card)</label>
        <input name="card_number" placeholder="16 digits">

        <label>Bank (for FPX)</label>
        <input name="bank" placeholder="Bank Name">

        <label>Wallet Phone (for E-Wallet)</label>
        <input name="wallet_phone" placeholder="10-11 digits">

        <button class="btn success" type="submit">Pay Now</button>
    </form>
</div>
@endsection
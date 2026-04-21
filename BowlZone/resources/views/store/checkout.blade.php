@extends('layouts.app')

@section('title', 'Checkout')

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')
@include('partials.store-header')

<div class="card">
    <h2 class="section-title">Checkout</h2>
    <p>Total: <strong>RM {{ number_format((float)$cart->grand_total, 2) }}</strong></p>
</div>

<div class="card" style="max-width:760px; margin:0 auto;">
    <form method="POST" action="{{ route('checkout.process') }}" class="checkout-form">
        @csrf

        <label>Full Name</label>
        <input name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>

        <label>Phone</label>
        <input name="phone" value="{{ old('phone') }}" required>

        <label>Payment Method</label>
        <select name="payment_method" required>
            <option value="">Select</option>
            <option value="Credit/Debit Card">Credit/Debit Card</option>
            <option value="FPX Online Banking">FPX Online Banking</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>

        <label>Card Number (for Credit/Debit Card)</label>
        <input name="card_number" placeholder="16 digits">

        <label>Bank (for FPX)</label>
        <input name="bank" placeholder="Bank Name">

        <label>Wallet Phone (for E-Wallet)</label>
        <input name="wallet_phone" placeholder="10-11 digits">

        <button class="btn success" type="submit">Complete Payment</button>
    </form>
</div>
@endsection
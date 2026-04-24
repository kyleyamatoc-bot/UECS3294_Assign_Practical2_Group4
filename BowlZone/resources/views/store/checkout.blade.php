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

<div style="max-width: 860px; margin: 2rem auto; padding: 0 1.5rem;">
    <h2 class="section-title">Checkout</h2>
    <p>Order Total: RM {{ number_format((float)$cart->grand_total, 2) }}</p>

    <div class="payment-form" style="max-width: 100%; padding: 2rem;">
        <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" style="max-width:none; width:100%; margin:0; padding:0; background:transparent; border:none; box-shadow:none;">
            @csrf

            <label>Full Name</label>
            <input id="full_name" name="full_name" type="text" value="{{ old('full_name', auth()->user()->full_name) }}" placeholder="Full Name" required>

            <label>Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Email Address" required>

            <label>Phone</label>
            <input id="phone" name="phone" type="tel" inputmode="numeric" value="{{ old('phone') }}" placeholder="10-11 digits" required>

            <label>Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">Select</option>
                <option value="Card" {{ old('payment_method') === 'Card' ? 'selected' : '' }}>Credit/Debit Card</option>
                <option value="FPX" {{ old('payment_method') === 'FPX' ? 'selected' : '' }}>FPX</option>
                <option value="E-Wallet" {{ old('payment_method') === 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
            </select>
            <span id="payment_method_error" class="form-error"></span>

            <div id="card-field" style="display:none;">
                <label>Cardholder Name</label>
                <input id="cardholder_name" name="cardholder_name" type="text" value="{{ old('cardholder_name') }}" placeholder="Name on card">
                <span id="cardholder_name_error" class="form-error"></span>

                <label>Card Number</label>
                <input id="card_number" name="card_number" type="tel" inputmode="numeric" value="{{ old('card_number') }}" placeholder="16 digits">
                <span id="card_number_error" class="form-error"></span>

                <label>Expiry Date (MM/YY)</label>
                <input id="expiry_date" name="expiry_date" type="text" value="{{ old('expiry_date') }}" placeholder="MM/YY">
                <span id="expiry_date_error" class="form-error"></span>

                <label>CVV</label>
                <input id="cvv" name="cvv" type="tel" inputmode="numeric" value="{{ old('cvv') }}" placeholder="3 digits">
                <span id="cvv_error" class="form-error"></span>
            </div>

            <div id="bank-field" style="display:none;">
                <label>Full Name</label>
                <input id="fpx_full_name" name="fpx_full_name" type="text" value="{{ old('fpx_full_name') }}" placeholder="Full Name">
                <span id="fpx_full_name_error" class="form-error"></span>

                <label>Bank Name</label>
                <select id="bank" name="bank">
                    <option value="">Select Bank</option>
                    <option value="Maybank" {{ old('bank') === 'Maybank' ? 'selected' : '' }}>Maybank</option>
                    <option value="CIMB" {{ old('bank') === 'CIMB' ? 'selected' : '' }}>CIMB</option>
                    <option value="Public Bank" {{ old('bank') === 'Public Bank' ? 'selected' : '' }}>Public Bank</option>
                    <option value="RHB" {{ old('bank') === 'RHB' ? 'selected' : '' }}>RHB</option>
                    <option value="Hong Leong Bank" {{ old('bank') === 'Hong Leong Bank' ? 'selected' : '' }}>Hong Leong Bank</option>
                    <option value="AmBank" {{ old('bank') === 'AmBank' ? 'selected' : '' }}>AmBank</option>
                    <option value="Bank Islam" {{ old('bank') === 'Bank Islam' ? 'selected' : '' }}>Bank Islam</option>
                    <option value="Bank Rakyat" {{ old('bank') === 'Bank Rakyat' ? 'selected' : '' }}>Bank Rakyat</option>
                    <option value="BSN" {{ old('bank') === 'BSN' ? 'selected' : '' }}>BSN</option>
                    <option value="Affin Bank" {{ old('bank') === 'Affin Bank' ? 'selected' : '' }}>Affin Bank</option>
                </select>
                <span id="bank_error" class="form-error"></span>

                <label>Account Number</label>
                <input id="account_number" name="account_number" type="tel" inputmode="numeric" value="{{ old('account_number') }}" placeholder="10-16 digits">
                <span id="account_number_error" class="form-error"></span>
            </div>

            <div id="wallet-field" style="display:none;">
                <label>Wallet Provider</label>
                <select id="wallet_provider" name="wallet_provider">
                    <option value="">Select Provider</option>
                    <option value="Touch 'n Go" {{ old('wallet_provider') === "Touch 'n Go" ? 'selected' : '' }}>Touch 'n Go</option>
                    <option value="GrabPay" {{ old('wallet_provider') === 'GrabPay' ? 'selected' : '' }}>GrabPay</option>
                    <option value="Boost" {{ old('wallet_provider') === 'Boost' ? 'selected' : '' }}>Boost</option>
                    <option value="ShopeePay" {{ old('wallet_provider') === 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                    <option value="MAE" {{ old('wallet_provider') === 'MAE' ? 'selected' : '' }}>MAE</option>
                </select>
                <span id="wallet_provider_error" class="form-error"></span>

                <label>Registered Phone Number</label>
                <input id="wallet_phone" name="wallet_phone" type="tel" inputmode="numeric" value="{{ old('wallet_phone') }}" placeholder="10-11 digits">
                <span id="wallet_phone_error" class="form-error"></span>

                <label>Full Name</label>
                <input id="wallet_full_name" name="wallet_full_name" type="text" value="{{ old('wallet_full_name') }}" placeholder="Full Name">
                <span id="wallet_full_name_error" class="form-error"></span>
            </div>

            <button class="btn btn-pay" type="submit">Complete Payment</button>
        </form>
    </div>
</div>
@endsection
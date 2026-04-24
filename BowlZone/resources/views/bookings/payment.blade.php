@extends('layouts.app')

@section('title', 'Booking Payment')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const methodSelect = document.getElementById('payment_method');
    const paymentForm = document.getElementById('booking-payment-form');

    const cardField = document.getElementById('card-field');
    const bankField = document.getElementById('bank-field');
    const walletField = document.getElementById('wallet-field');

    const cardholderName = document.getElementById('cardholder_name');
    const cardNumber = document.getElementById('card_number');
    const expiryDate = document.getElementById('expiry_date');
    const cvv = document.getElementById('cvv');

    const fpxFullName = document.getElementById('fpx_full_name');
    const bankName = document.getElementById('bank');
    const accountNumber = document.getElementById('account_number');

    const walletProvider = document.getElementById('wallet_provider');
    const walletPhone = document.getElementById('wallet_phone');
    const walletFullName = document.getElementById('wallet_full_name');

    const cardholderNameError = document.getElementById('cardholder_name_error');
    const cardNumberError = document.getElementById('card_number_error');
    const expiryDateError = document.getElementById('expiry_date_error');
    const cvvError = document.getElementById('cvv_error');

    const fpxFullNameError = document.getElementById('fpx_full_name_error');
    const bankError = document.getElementById('bank_error');
    const accountNumberError = document.getElementById('account_number_error');

    const walletProviderError = document.getElementById('wallet_provider_error');
    const walletPhoneError = document.getElementById('wallet_phone_error');
    const walletFullNameError = document.getElementById('wallet_full_name_error');

    function clearErrors() {
        [
            cardholderNameError,
            cardNumberError,
            expiryDateError,
            cvvError,
            fpxFullNameError,
            bankError,
            accountNumberError,
            walletProviderError,
            walletPhoneError,
            walletFullNameError
        ].forEach(function (el) {
            el.textContent = '';
        });
    }

    function setError(errorEl, message) {
        errorEl.textContent = message;
    }

    function isValidExpiry(value) {
        if (!/^\d{2}\/\d{2}$/.test(value)) {
            return false;
        }

        const parts = value.split('/');
        const month = parseInt(parts[0], 10);
        const yearTwoDigit = parseInt(parts[1], 10);
        if (Number.isNaN(month) || Number.isNaN(yearTwoDigit) || month < 1 || month > 12) {
            return false;
        }

        const now = new Date();
        const currentYearTwoDigit = now.getFullYear() % 100;
        const currentMonth = now.getMonth() + 1;

        if (yearTwoDigit < currentYearTwoDigit) {
            return false;
        }
        if (yearTwoDigit === currentYearTwoDigit && month < currentMonth) {
            return false;
        }

        return true;
    }

    function toggleFields() {
        const val = methodSelect.value;
        cardField.style.display = (val === 'Card') ? 'block' : 'none';
        bankField.style.display = (val === 'FPX') ? 'block' : 'none';
        walletField.style.display = (val === 'E-Wallet') ? 'block' : 'none';
    }

    toggleFields();
    methodSelect.addEventListener('change', function () {
        clearErrors();
        toggleFields();
    });

    paymentForm.addEventListener('submit', function (event) {
        clearErrors();
        const val = methodSelect.value;
        let hasError = false;

        if (!val) {
            hasError = true;
            setError(bankError, 'Please select a payment method.');
        }

        if (val === 'Card') {
            if (!/^[A-Za-z ]+$/.test(cardholderName.value.trim())) {
                hasError = true;
                setError(cardholderNameError, 'Cardholder name is required and must contain letters/spaces only.');
            }

            if (!/^\d{16}$/.test(cardNumber.value.trim())) {
                hasError = true;
                setError(cardNumberError, 'Card number must be exactly 16 digits.');
            }

            if (!isValidExpiry(expiryDate.value.trim())) {
                hasError = true;
                setError(expiryDateError, 'Expiry must be MM/YY and not in the past.');
            }

            if (!/^\d{3}$/.test(cvv.value.trim())) {
                hasError = true;
                setError(cvvError, 'CVV must be exactly 3 digits.');
            }
        }

        if (val === 'FPX') {
            if (fpxFullName.value.trim() === '') {
                hasError = true;
                setError(fpxFullNameError, 'Full name is required.');
            }

            if (!bankName.value.trim()) {
                hasError = true;
                setError(bankError, 'Please select a bank name.');
            }

            if (!/^\d{10,16}$/.test(accountNumber.value.trim())) {
                hasError = true;
                setError(accountNumberError, 'Account number must be 10 to 16 digits.');
            }
        }

        if (val === 'E-Wallet') {
            if (!walletProvider.value.trim()) {
                hasError = true;
                setError(walletProviderError, 'Please select a wallet provider.');
            }

            if (!/^01\d{8,9}$/.test(walletPhone.value.trim())) {
                hasError = true;
                setError(walletPhoneError, 'Phone number must be 10-11 digits and start with 01.');
            }

            if (walletFullName.value.trim() === '') {
                hasError = true;
                setError(walletFullNameError, 'Full name is required.');
            }
        }

        if (hasError) {
            event.preventDefault();
        }
    });
});
</script>
@endsection

@section('content')
<div class="booking-page">
    <div style="max-width: 860px; margin: 2rem auto; padding: 0 1.5rem;">
        <h2 class="section-title">Booking Payment</h2>
        <p>Booking #{{ $booking->id }} | Total: RM {{ number_format((float)$booking->total_amount, 2) }}</p>

        <div class="payment-form" style="max-width: 100%; padding: 2rem;">
            <form id="booking-payment-form" method="POST" action="{{ route('bookings.payment.process', $booking->id) }}" style="max-width:none; width:100%; margin:0; padding:0; background:transparent; border:none; box-shadow:none;">
                @csrf
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

                <button class="btn btn-pay" type="submit">Pay Now</button>
            </form>
        </div>
    </div>
</div>
@endsection

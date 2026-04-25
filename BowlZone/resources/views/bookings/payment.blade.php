@extends('layouts.app')

@section('title', 'Booking Payment')

@section('bodyClass', 'booking-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentForm = document.getElementById('booking-payment-form');
        const paymentInput = document.getElementById('payment_method');
        const methodBtns = document.querySelectorAll('.payment-method-btn');

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
        const paymentMethodError = document.getElementById('payment_method_error');

        function clearErrors() {
            [cardholderNameError, cardNumberError, expiryDateError, cvvError,
                fpxFullNameError, bankError, accountNumberError,
                walletProviderError, walletPhoneError, walletFullNameError, paymentMethodError
            ].forEach(el => {
                if (el) el.textContent = '';
            });
        }

        function setError(el, msg) {
            if (el) el.textContent = msg;
        }

        function isValidExpiry(value) {
            if (!/^\d{2}\/\d{2}$/.test(value)) return false;
            const [month, year] = value.split('/').map(Number);
            if (month < 1 || month > 12) return false;
            const now = new Date();
            const curYear = now.getFullYear() % 100;
            const curMonth = now.getMonth() + 1;
            if (year < curYear) return false;
            if (year === curYear && month < curMonth) return false;
            return true;
        }

        function toggleFields(val) {
            cardField.style.display = val === 'Card' ? 'block' : 'none';
            bankField.style.display = val === 'FPX' ? 'block' : 'none';
            walletField.style.display = val === 'E-Wallet' ? 'block' : 'none';
        }

        // Payment method button click
        methodBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                methodBtns.forEach(b => b.classList.remove('is-active'));
                this.classList.add('is-active');
                const val = this.dataset.value;
                paymentInput.value = val;
                clearErrors();
                toggleFields(val);
            });
        });

        // Init on load (for old() values)
        toggleFields(paymentInput.value);

        paymentForm.addEventListener('submit', function(event) {
            clearErrors();
            const val = paymentInput.value;
            let hasError = false;

            if (!val) {
                hasError = true;
                setError(paymentMethodError, 'Please select a payment method.');
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
                if (!fpxFullName.value.trim()) {
                    hasError = true;
                    setError(fpxFullNameError, 'Full name is required.');
                }
                if (!bankName.value.trim()) {
                    hasError = true;
                    setError(bankError, 'Please select a bank.');
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
                if (!walletFullName.value.trim()) {
                    hasError = true;
                    setError(walletFullNameError, 'Full name is required.');
                }
            }

            if (hasError) event.preventDefault();
        });
    });
</script>
@endsection

@section('content')
<div class="booking-page">
    <div style="max-width: 860px; margin: 2rem auto; padding: 0 1.5rem;">
        <h2 class="section-title">Booking Payment</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">
            Booking <strong>#{{ $booking->id }}</strong> &nbsp;|&nbsp;
            Total: <strong style="color: #dc3545;">RM {{ number_format((float)$booking->total_amount, 2) }}</strong>
        </p>

        <div class="payment-form" style="max-width: 100%; padding: 2rem;">
            <form id="booking-payment-form" method="POST"
                action="{{ route('bookings.payment.process', $booking->id) }}"
                style="max-width:none; width:100%; margin:0; padding:0; background:transparent; border:none; box-shadow:none;">
                @csrf

                <div class="checkout-payment-separator">
                    <span>How would you like to pay?</span>
                </div>

                {{-- Hidden input holds the selected method --}}
                <input id="payment_method" name="payment_method" type="hidden" value="{{ old('payment_method') }}">

                <div class="payment-method-buttons" role="group" aria-label="Select Payment Method">
                    <button type="button"
                        class="payment-method-btn payment-method-card-btn{{ old('payment_method') === 'Card' ? ' is-active' : '' }}"
                        data-value="Card">
                        <span class="payment-method-card-label">Credit/Debit Card</span>
                        <span class="card-payment-logos">
                            <img src="{{ asset('images/store/visa_logo.gif') }}" alt="Visa" loading="lazy">
                            <img src="{{ asset('images/store/mastercard_logo.png') }}" alt="Mastercard" loading="lazy">
                        </span>
                    </button>

                    <button type="button"
                        class="payment-method-btn{{ old('payment_method') === 'FPX' ? ' is-active' : '' }}"
                        data-value="FPX">
                        <span class="payment-method-card-label">Online Banking</span>
                        <span class="card-payment-logos">
                            <img src="{{ asset('images/store/fpx_logo.jpg') }}" alt="FPX" loading="lazy">
                        </span>
                    </button>

                    <button type="button"
                        class="payment-method-btn{{ old('payment_method') === 'E-Wallet' ? ' is-active' : '' }}"
                        data-value="E-Wallet">
                        <span class="payment-method-card-label">E-Wallet</span>
                        <span class="card-payment-logos">
                            <img src="{{ asset('images/store/tng_logo.png') }}" alt="Touch 'n Go" loading="lazy">
                            <img src="{{ asset('images/store/grabpay_logo.png') }}" alt="GrabPay" loading="lazy">
                            <img src="{{ asset('images/store/boost_logo.png') }}" alt="Boost" loading="lazy">
                            <img src="{{ asset('images/store/shopeepay_logo.png') }}" alt="ShopeePay" loading="lazy">
                            <img src="{{ asset('images/store/mae_logo.webp') }}" alt="MAE" loading="lazy">
                        </span>
                    </button>
                </div>
                <span id="payment_method_error" class="form-error"></span>

                {{-- Card Fields --}}
                <div id="card-field" style="display:none;">
                    <label>Cardholder Name</label>
                    <input id="cardholder_name" name="cardholder_name" type="text"
                        value="{{ old('cardholder_name') }}" placeholder="Name on card">
                    <span id="cardholder_name_error" class="form-error"></span>

                    <label>Card Number</label>
                    <input id="card_number" name="card_number" type="tel" inputmode="numeric"
                        value="{{ old('card_number') }}" placeholder="16 digits">
                    <span id="card_number_error" class="form-error"></span>

                    <label>Expiry Date (MM/YY)</label>
                    <input id="expiry_date" name="expiry_date" type="text"
                        value="{{ old('expiry_date') }}" placeholder="MM/YY">
                    <span id="expiry_date_error" class="form-error"></span>

                    <label>CVV</label>
                    <input id="cvv" name="cvv" type="tel" inputmode="numeric"
                        value="{{ old('cvv') }}" placeholder="3 digits">
                    <span id="cvv_error" class="form-error"></span>
                </div>

                {{-- FPX Fields --}}
                <div id="bank-field" style="display:none;">
                    <label>Full Name</label>
                    <input id="fpx_full_name" name="fpx_full_name" type="text"
                        value="{{ old('fpx_full_name') }}" placeholder="Full Name">
                    <span id="fpx_full_name_error" class="form-error"></span>

                    <label>Bank Name</label>
                    <select id="bank" name="bank">
                        <option value="">Select Bank</option>
                        @foreach(['Maybank','CIMB','Public Bank','RHB','Hong Leong Bank','AmBank','Bank Islam','Bank Rakyat','BSN','Affin Bank'] as $b)
                        <option value="{{ $b }}" {{ old('bank') === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    <span id="bank_error" class="form-error"></span>

                    <label>Account Number</label>
                    <input id="account_number" name="account_number" type="tel" inputmode="numeric"
                        value="{{ old('account_number') }}" placeholder="10-16 digits">
                    <span id="account_number_error" class="form-error"></span>
                </div>

                {{-- E-Wallet Fields --}}
                <div id="wallet-field" style="display:none;">
                    <label>Wallet Provider</label>
                    <select id="wallet_provider" name="wallet_provider">
                        <option value="">Select Provider</option>
                        @foreach(["Touch 'n Go", 'GrabPay', 'Boost', 'ShopeePay', 'MAE'] as $w)
                        <option value="{{ $w }}" {{ old('wallet_provider') === $w ? 'selected' : '' }}>{{ $w }}</option>
                        @endforeach
                    </select>
                    <span id="wallet_provider_error" class="form-error"></span>

                    <label>Registered Phone Number</label>
                    <input id="wallet_phone" name="wallet_phone" type="tel" inputmode="numeric"
                        value="{{ old('wallet_phone') }}" placeholder="10-11 digits">
                    <span id="wallet_phone_error" class="form-error"></span>

                    <label>Full Name</label>
                    <input id="wallet_full_name" name="wallet_full_name" type="text"
                        value="{{ old('wallet_full_name') }}" placeholder="Full Name">
                    <span id="wallet_full_name_error" class="form-error"></span>
                </div>

                <button class="btn btn-pay" type="submit">Pay Now</button>
            </form>
        </div>
    </div>
</div>
@endsection
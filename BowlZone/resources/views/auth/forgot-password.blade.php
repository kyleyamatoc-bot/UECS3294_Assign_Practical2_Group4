@extends('layouts.app')

@section('title', 'Forgot Password')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection

@section('content')
<div class="forgot-page">
    <div class="forgot-container">
        <h2>Forgot Password</h2>
        <form method="POST" action="{{ route('auth.forgot') }}" class="forgot-form" id="forgotEmailForm" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Enter your registered email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <div id="emailError" class="error"></div>
            </div>
            <button type="submit" class="btn-forgot">Continue</button>
        </form>
        <div class="back-to-login">
            <a href="{{ route('auth.login.show') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection
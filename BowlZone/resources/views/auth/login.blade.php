@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection

@section('content')
<div class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="{{ route('auth.login') }}" class="login-form" novalidate>
            @csrf
            <div class="form-group">
                <label>Email or Username:</label>
                <input type="text" id="loginInput" name="login" value="{{ old('login') }}" required>
                <div id="loginInputError" class="error">@error('login'){{ $message }}@enderror</div>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" id="loginPassword" name="password" required>
                <div id="loginPasswordError" class="error">@error('password'){{ $message }}@enderror</div>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="forgot-password">
            <a href="{{ route('auth.forgot.show') }}">Forgot your password?</a>
        </div>
        <div class="signup-link">
            Don’t have an account? <a href="{{ route('auth.register.show') }}">Register here</a>
        </div>
    </div>
</div>
@endsection

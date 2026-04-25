@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection

@section('content')
<main class="register-page">
    <div class="register-container">
        <h2>Create Your BowlZone Account</h2>
        <form id="registerForm" method="POST" action="{{ route('auth.register') }}" class="register-form" novalidate>
            @csrf
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="first_name" value="{{ old('first_name') }}" required>
                <div id="firstNameError" class="error">@error('first_name'){{ $message }}@enderror</div>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="last_name" value="{{ old('last_name') }}" required>
                <div id="lastNameError" class="error">@error('last_name'){{ $message }}@enderror</div>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                <div id="usernameError" class="error">@error('username'){{ $message }}@enderror</div>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <div id="emailError" class="error">@error('email'){{ $message }}@enderror</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div id="passwordError" class="error">@error('password'){{ $message }}@enderror</div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="password_confirmation" required>
                <div id="confirmPasswordError" class="error">@error('password_confirmation'){{ $message }}@enderror</div>
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
        <p class="login-link">Already have an account? <a href="{{ route('auth.login.show') }}">Login here</a></p>
    </div>
</main>
@endsection

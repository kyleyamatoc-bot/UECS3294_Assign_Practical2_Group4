@extends('layouts.app')

@section('title', 'Reset Password')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endsection

@section('content')
<div class="forgot-page">
    <div class="forgot-container">
        <h2>Reset Password</h2>
        <p>Email: <strong>{{ $email }}</strong></p>
        <form method="POST" action="{{ route('auth.reset') }}" class="forgot-form" id="resetForm" novalidate>
            @csrf
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
                <div id="passwordError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="password_confirmation" required>
                <div id="confirmPasswordError" class="error"></div>
            </div>
            <button class="btn-forgot" type="submit">Reset Password</button>
        </form>
    </div>
</div>
@endsection
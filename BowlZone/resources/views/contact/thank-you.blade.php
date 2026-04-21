@extends('layouts.app')

@section('title', 'Contact Submitted')

@section('bodyClass', 'contact-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/contact.js') }}"></script>
@endsection

@section('content')
<div class="card" style="max-width:600px; margin:0 auto; text-align:center;">
    <h2 class="section-title">Thank You</h2>
    <p>Your message has been sent successfully.</p>
    <a class="btn" href="{{ route('home') }}">Return Home</a>
</div>
@endsection
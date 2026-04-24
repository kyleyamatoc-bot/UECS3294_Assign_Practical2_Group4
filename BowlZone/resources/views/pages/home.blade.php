@extends('layouts.app')

@section('title', 'BowlZone Home')

@section('bodyClass', 'home-page')

@section('content')
<main class="home-page">
    <br>
    <section class="hero">
        <div class="hero-content">
            @auth
            <h1>Welcome back, {{ auth()->user()->username }}!</h1>
            <p>Your ultimate destination for bowling fun and shopping.</p>
            <a href="{{ route('bookings.create') }}" class="btn-primary">Book Now</a>
            <a href="{{ route('store.index') }}" class="btn-primary">Visit Store</a>
            @else
            <h1>Welcome to BowlZone!</h1>
            <p>Your ultimate destination for bowling fun and shopping.</p>
            <a href="{{ route('auth.login.show') }}" class="btn-primary">Log In to Start</a><br><br>
            <p class="hint">Don't have an account? <a href="{{ route('auth.register.show') }}">Register here</a>.</p>
            @endauth
        </div>
        <img src="{{ asset('images/home/HomePageTop.jpeg') }}" alt="Bowling fun at BowlZone" class="hero-image" />
    </section>

    <section class="features">
        <h2>Our Services</h2><br><br>
        <div class="feature-cards">
            <div class="feature-card">
                <img src="{{ asset('images/home/bowlingIcon.png') }}" alt="Book a lane icon">
                <h3>Book a Lane</h3>
                <p>Reserve your bowling lane online quickly and easily.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/home/storeIcon.png') }}" alt="Store icon">
                <h3>Shop Bowling Gear</h3>
                <p>Find shoes, balls, and accessories in our online store.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Ready to Bowl?</h2>
        @guest
        <a href="{{ route('auth.login.show') }}" class="btn-primary">Log In Now</a>
        @else
        <a href="{{ route('bookings.create') }}" class="btn-primary">Book Now</a>
        @endguest
    </section>
</main>
@endsection
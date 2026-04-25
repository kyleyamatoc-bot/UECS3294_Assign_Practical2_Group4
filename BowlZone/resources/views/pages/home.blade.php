@extends('layouts.app')

@section('title', 'BowlZone Home')

@section('bodyClass', 'home-page')

@section('content')
<main class="home-page">

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            @auth
            <h1>Welcome back, {{ auth()->user()->username }}!</h1>
            <p>Your ultimate destination for bowling fun and shopping.</p>
            <a href="{{ route('bookings.create') }}" class="btn-primary">Book a Lane</a>
            <a href="{{ route('store.index') }}" class="btn-primary">Visit Store</a>
            @else
            <h1>Welcome to BowlZone!</h1>
            <p>Your ultimate destination for bowling fun and shopping.</p>
            <a href="{{ route('auth.login.show') }}" class="btn-primary">Log In to Start</a>
            <span class="hint">Don't have an account? <a href="{{ route('auth.register.show') }}">Register here</a>.</span>
            @endauth
        </div>
        <img src="{{ asset('images/home/HomePageTop.jpeg') }}" alt="Bowling fun at BowlZone" class="hero-image" />
    </section>

    <!-- Features / Our Services -->
    <section class="features">
        <h2>Our Services</h2>
        <div class="feature-cards">
            <div class="feature-card">
                <img src="{{ asset('images/home/bowlingIcon.png') }}" alt="Book a lane">
                <h3>Book a Lane</h3>
                <p>Reserve your bowling lane online quickly and easily — no queues, no hassle.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/home/storeIcon.png') }}" alt="Store">
                <h3>Shop Bowling Gear</h3>
                <p>Find shoes, balls, bags, and accessories in our fully stocked online store.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/home/24-hours-support.png') }}" alt="Support">
                <h3>24/7 Support</h3>
                <p>Got questions? Our support team is always ready to help you out.</p>
            </div>
        </div>
    </section>

    <!-- Explore Services -->
    <div class="section-container">
        <h2>Explore What We Offer</h2>

        <div class="service-card">
            <div class="service-image">
                <img src="{{ asset('images/home/OurServiceBook.png') }}" alt="Book a Lane">
            </div>
            <div class="service-info" style="padding: 0 2rem;">
                <h3>Bowl Your Way</h3>
                <p>
                    Whether you're here for a casual game with friends or a competitive match,
                    our state-of-the-art lanes are ready for you. Book in advance and guarantee
                    your spot — it only takes a minute.
                </p>
                <a href="{{ route('bookings.create') }}" class="btn-primary">Book a Lane</a>
            </div>
        </div>

        <div class="service-card" style="flex-direction: row-reverse;">
            <div class="service-image">
                <img src="{{ asset('images/home/OurServiceStore.jpeg') }}" alt="Online Store">
            </div>
            <div class="service-info" style="padding: 0 2rem;">
                <h3>Gear Up at Our Store</h3>
                <p>
                    Browse our curated selection of bowling balls, shoes, bags, and accessories.
                    Everything you need to bowl your best — delivered right to your door.
                </p>
                <a href="{{ route('store.index') }}" class="btn-primary">Visit Store</a>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <section class="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <h3>1. Create an Account</h3>
                <p>Sign up for free in seconds and get instant access to bookings and our store.</p>
            </div>
            <div class="step">
                <h3>2. Book Your Lane</h3>
                <p>Pick your date, time, and number of players — we'll handle the rest.</p>
            </div>
            <div class="step">
                <h3>3. Show Up & Bowl</h3>
                <p>Arrive at BowlZone, show your booking, and enjoy the game!</p>
            </div>
        </div>
    </section>

    <!-- Call To Action -->
    <section class="cta">
        <h2>Ready to Bowl?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Join hundreds of bowlers who trust BowlZone for their game day.
        </p>
        @guest
        <a href="{{ route('auth.register.show') }}" class="btn-primary">Get Started Free</a>
        @else
        <a href="{{ route('bookings.create') }}" class="btn-primary">Book a Lane Now</a>
        @endguest
    </section>

</main>
@endsection
@extends('layouts.app')

@section('title', 'About BowlZone')

@section('bodyClass', 'page-about')

@section('content')

<div class="about-page">
    <h1>About BowlZone</h1>

    <!-- Who We Are -->
    <section class="about-section">
        <h2>Who We Are</h2>
        <p>
            BowlZone is your ultimate destination for bowling fun, whether for casual games,
            special events, or team competitions. Our mission is to bring people together
            through the excitement of bowling and create lasting memories with friends and family.
        </p>
    </section>

    <!-- What We Offer -->
    <section class="about-section">
        <h2>What We Offer</h2>
        <ul>
            <li>State-of-the-art bowling lanes for all skill levels</li>
            <li>Easy online booking system for hassle-free reservations</li>
            <li>Online store with quality bowling gear and accessories</li>
            <li>Cozy café and lounge area to relax and refuel</li>
        </ul>
    </section>

    <!-- Our Vision -->
    <section class="about-section">
        <h2>Our Vision</h2>
        <p>
            We aim to be more than just a bowling alley — BowlZone is a community hub where fun,
            competition, and friendship thrive. Whether you're rolling your first strike or chasing
            a perfect 300, we're here to make every visit unforgettable.
        </p>
    </section>

    <!-- Our History -->
    <section class="about-section">
        <h2>Our History</h2>
        <p>
            BowlZone began as a prototype for our <strong>Human-Computer Interaction (HCI) assignment in 2024</strong>,
            where we designed the concept and user experience from scratch. Building on that foundation,
            we brought it to life as a fully functioning website using <strong>PHP</strong> for our
            <strong>Web Application Development</strong> assignment — complete with an online booking system
            and store. Most recently, BowlZone was rebuilt using <strong>Laravel</strong> for our
            <strong>Advanced Web Application Development</strong> assignment, introducing a
            modern MVC architecture, authentication, database migrations, and a complete e-commerce experience.
        </p>
    </section>

    <!-- Logo Evolution -->
    <section class="about-section">
        <h2>Our Logo Evolution</h2>
        <div class="logo-timeline">
            <div class="logo-item">
                <h3>2024 — HCI Prototype</h3>
                <img src="{{ asset('images/BowlZone_logo_rectangle.png') }}" alt="BowlZone Logo 2024">
                <p class="logo-desc">Designed by <em>Kxen</em> for our HCI assignment, this first logo established BowlZone's original visual identity.</p>
            </div>
            <div class="logo-item">
                <h3>2025 — Web & Laravel</h3>
                <img src="{{ asset('images/BowlZone_logo(2025)_rectangle.png') }}" alt="BowlZone Logo 2025">
                <p class="logo-desc">Refreshed by <em>Kxen</em> for our Web Application Development project and carried forward into our Advanced Web Application Development rebuild with Laravel.</p>
            </div>
        </div>
    </section>
</div>

@endsection
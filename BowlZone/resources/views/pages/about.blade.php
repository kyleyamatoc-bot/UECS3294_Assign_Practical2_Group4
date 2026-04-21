@extends('layouts.app')

@section('title', 'About BowlZone')

@section('bodyClass', 'page-about')

@section('content')

<div class="about-page">
    <h1>About BowlZone</h1>

    <section class="about-section">
        <h2>Who We Are</h2>
        <p>
            BowlZone is your ultimate destination for bowling fun, whether for casual games,
            special events, or team competitions.
        </p>
    </section>

    <section class="about-section">
        <h2>What We Offer</h2>
        <ul>
            <li>State-of-the-art bowling lanes</li>
            <li>Easy online booking system</li>
            <li>Exciting events and tournaments</li>
            <li>Online store with bowling gear</li>
        </ul>
    </section>

    <section class="about-section">
        <h2>Our Vision</h2>
        <p>
            We aim to be a community hub where fun, competition, and friendship thrive.
        </p>
    </section>
</div>

@endsection
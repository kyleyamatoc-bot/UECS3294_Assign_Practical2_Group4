@extends('layouts.app')

@section('title', 'Contact Us')

@section('bodyClass', 'contact-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
<style>
    /* Hide top error messages on contact page */
    .message.error {
        display: none !important;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/contact.js') }}"></script>
@endsection

@section('content')
<div class="contact-wrapper">
    <div class="contact-container">
        <!-- Left Side: Contact Form -->
        <div class="contact-form-wrapper">
            <h2>Send us a Message</h2>
            <form method="POST" action="{{ route('contact.store') }}">
                @csrf

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name"
                        placeholder="First Name"
                        value="{{ old('first_name', auth()->user()->first_name ?? '') }}"
                        required>
                    @error('first_name')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name"
                        placeholder="Last Name"
                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                        required>
                    @error('last_name')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        placeholder="example@email.com"
                        value="{{ old('email', auth()->user()->email ?? '') }}"
                        required>
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject"
                        placeholder="What is your inquiry about?"
                        value="{{ old('subject') }}"
                        required>
                    @error('subject')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="inquiry_type">Inquiry Type</label>
                    <select id="inquiry_type" name="inquiry_type" required>
                        <option value="">Select an inquiry type</option>
                        <option value="general" {{ old('inquiry_type') === 'general' ? 'selected' : '' }}>General Inquiry</option>
                        <option value="booking" {{ old('inquiry_type') === 'booking' ? 'selected' : '' }}>Booking Question</option>
                        <option value="complaint" {{ old('inquiry_type') === 'complaint' ? 'selected' : '' }}>Complaint</option>
                        <option value="suggestion" {{ old('inquiry_type') === 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                    </select>
                    @error('inquiry_type')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="priority">Priority Level</label>
                    <select id="priority" name="priority" required>
                        <option value="">Select priority level</option>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message"
                        rows="6"
                        placeholder="Type your message here..."
                        required>{{ old('message') }}</textarea>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>

        <!-- Right Side: Contact Info -->
        <aside class="contact-info">
            <h2>Contact Info</h2>

            <div class="info-section">
                <h3>Address</h3>
                <p>
                    BowlZone<br>
                    Bandar Sungai Long<br>
                    Selangor, Malaysia
                </p>
            </div>

            <div class="info-section">
                <h3>Email</h3>
                <p><a href="mailto:support@bowlzone.com">support@bowlzone.com</a></p>
            </div>

            <div class="info-section">
                <h3>Phone</h3>
                <p><a href="tel:+60312345678">+60 3-1234 5678</a></p>
            </div>

            <div class="info-section">
                <h3>Office Hours</h3>
                <p>
                    Monday – Friday: 9am – 6pm<br>
                    Saturday: 10am – 5pm<br>
                    Sunday: Closed
                </p>
            </div>

            <div class="info-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com" target="_blank" title="Facebook">
                        <img src="{{ asset('images/Facebook.png') }}" alt="Facebook">
                    </a>
                    <a href="https://www.instagram.com" target="_blank" title="Instagram">
                        <img src="{{ asset('images/Instagram.png') }}" alt="Instagram">
                    </a>
                    <a href="https://www.twitter.com" target="_blank" title="Twitter">
                        <img src="{{ asset('images/X.png') }}" alt="Twitter">
                    </a>
                </div>
            </div>

            <div class="info-section about">
                <h3>About BowlZone</h3>
                <p>
                    BowlZone is your go-to destination for fun and competitive bowling in Selangor.
                    Whether you're a casual player or a pro, we provide top-notch lanes and events for all skill levels.
                </p>
            </div>
        </aside>
    </div>

    <!-- Google Maps Section -->
    <section class="contact-map">
        <h2>Visit Us</h2>
        <div class="map-container">
            <iframe
                class="map-frame"
                frameborder="0"
                marginheight="0"
                marginwidth="0"
                src="https://maps.google.com/maps?hl=en&q=bandar%20sungai%20long&t=&z=14&ie=UTF8&iwloc=B&output=embed">
            </iframe>
        </div>
    </section>
</div>
@endsection
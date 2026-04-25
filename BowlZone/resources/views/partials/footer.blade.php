<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-column">
            <h4>About Us</h4>
            <p>
                BowlZone is your go-to destination for fun and competitive bowling in Selangor.
                Whether you are a casual player or a pro, we provide top-notch lanes and events for all skill levels.
            </p>
        </div>

        <div class="footer-column">
            <h4>Useful Links</h4>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>

                <li class="dropdown-footer">
                    <a href="#">Booking <span class="arrow">&#9662;</span></a>
                    <ul class="dropdown-content-footer">
                        <li><a href="{{ route('bookings.create') }}">Book a Lane</a></li>
                        @auth
                        <li><a href="{{ route('bookings.index') }}">View Bookings</a></li>
                        @endauth
                    </ul>
                </li>

                <li class="dropdown-footer">
                    <a href="#">Store <span class="arrow">&#9662;</span></a>
                    <ul class="dropdown-content-footer">
                        <li><a href="{{ route('store.index') }}">Browse Store</a></li>
                        @auth
                        <li><a href="{{ route('cart.index') }}">My Cart</a></li>
                        @endauth
                    </ul>
                </li>

                <li><a href="{{ route('contact.create') }}">Contact</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Contact Info</h4>
            <p><strong>Email:</strong> <a href="mailto:support@bowlzone.my">support@bowlzone.my</a></p>
            <p><strong>Phone:</strong> +60 12-345 6789</p>
            <p><strong>Location:</strong> Bandar Sungai Long, Selangor</p>
        </div>
    </div>

    <hr class="footer-divider">

    <div class="footer-bottom">
        <div class="footer-bottom-top">
            <a href="{{ route('about') }}">
                <img src="{{ asset('images/BowlZone_Logo(2025)_round.png') }}" alt="BowlZone Logo" class="footer-logo">
            </a>
            <div class="social-icons">
                <a href="https://www.facebook.com/" target="_blank" rel="noreferrer">
                    <img src="{{ asset('images/Facebook.png') }}" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/" target="_blank" rel="noreferrer">
                    <img src="{{ asset('images/Instagram.png') }}" alt="Instagram">
                </a>
                <a href="https://twitter.com/" target="_blank" rel="noreferrer">
                    <img src="{{ asset('images/X.png') }}" alt="X">
                </a>
            </div>
        </div>
        <div class="footer-bottom-bottom">
            <p>&copy; {{ date('Y') }} BowlZone. All rights reserved. | <a href="{{ route('terms') }}">Terms & Conditions</a></p>
        </div>
    </div>
</footer>
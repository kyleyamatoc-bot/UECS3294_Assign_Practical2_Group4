<div class="naviOverlay"></div>

<nav class="navbar">
    <div class="nav-container">
        <ul class="nav-left">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About</a></li>

            <li class="dropdown">
                <a class="dropbtn">Booking <span class="arrow">&#9662;</span></a>
                <div class="dropdown-content">
                    <a href="{{ route('bookings.create') }}">Book a Lane</a>
                    @auth
                    <a href="{{ route('bookings.index') }}">View Booking</a>
                    @endauth
                </div>
            </li>

            <li class="dropdown">
                <a class="dropbtn">Store <span class="arrow">&#9662;</span></a>
                <div class="dropdown-content">
                    <a href="{{ route('store.index') }}">Store</a>
                    @auth
                    <a href="{{ route('cart.index') }}">Cart</a>
                    @endauth
                </div>
            </li>

            <li><a href="{{ route('contact.create') }}">Contact</a></li>
        </ul>

        <ul class="nav-right">
            @auth
            @if(auth()->user()->is_admin)
            <li><a class="btn-admin" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
            @endif
            <li><a class="btn-account" href="{{ route('account.index') }}">My Account</a></li>
            <li><a class="btn-log-out" href="#" onclick="confirmLogout(event)">Logout</a></li>
            @else
            <li><a class="btn-log-in" href="{{ route('auth.login.show') }}">Login</a></li>
            @endauth
        </ul>
    </div>
</nav>

@auth
<form id="logout-form" method="POST" action="{{ route('auth.logout') }}" style="display:none;">
    @csrf
</form>
@endauth

<script>
    function confirmLogout(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to log out?')) {
            const form = document.getElementById('logout-form');
            if (form) form.submit();
        }
    }
</script>
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
                    <a href="{{ route('bookings.index') }}">View Bookings</a>
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
            <li class="cart-icon">@include('partials.store-header')</li>
            <li class="dropdown user-dropdown">
                <a class="dropbtn user-dropbtn">
                    <span class="user-avatar">{{ strtoupper(substr(auth()->user()->username, 0, 1)) }}</span>
                    <span class="user-name">{{ auth()->user()->username }}</span>
                    <span class="arrow">&#9662;</span>
                </a>
                <div class="dropdown-content user-dropdown-content">
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item-admin">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                            <path d="M12 2v2M12 20v2M2 12h2M20 12h2" />
                        </svg>
                        Admin Panel
                    </a>
                    <div class="dropdown-divider"></div>
                    @endif
                    <a href="{{ route('account.index') }}" class="dropdown-item-account">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        My Account
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" onclick="confirmLogout(event)" class="dropdown-item-logout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Logout
                    </a>
                </div>
            </li>
            @else
            <li>
                <a class="btn-log-in" href="{{ route('auth.login.show') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Login
                </a>
            </li>
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
            document.getElementById('logout-form').submit();
        }
    }
</script>
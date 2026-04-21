<div class="top-bar">
    <div class="left-links">
        <a href="{{ route('home') }}" class="link-item">Home</a>
        <span class="slash">/</span>
        <a href="{{ route('store.index') }}" class="link-item">BowlZone Store</a>
    </div>

    @auth
    <div class="cart-icon">
        <a href="{{ route('cart.index') }}" class="my-cart">
            <div class="cart-wrapper">
                <img src="{{ asset('images/Store/cart_logo.png') }}" alt="Cart Icon" />
                <span>MY CART</span>
            </div>
        </a>
    </div>
    @endauth
</div>
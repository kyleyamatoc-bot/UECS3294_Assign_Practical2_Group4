<div class="top-bar">
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
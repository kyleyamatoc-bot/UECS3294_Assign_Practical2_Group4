@extends('layouts.app')

@section('title', $product->name)

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')

<div class="card pdp-shell">
    <div class="pdp pdp-screen">
        <div class="pdp-media">
            <img src="{{ asset(str_replace('Store/', 'store/', $product->image_path)) }}" alt="{{ $product->name }}">
        </div>
        <div class="pdp-info">
            <h2 class="pdp-screen-title" @if($product->name === "Dexter Power Frame (Women's)") style="white-space: nowrap; overflow: visible; text-overflow: unset;" @endif>{{ $product->name }}</h2>
            <p class="pdp-screen-price">RM{{ number_format((float)$product->price, 2) }}</p>

            @auth
            <form class="pdp-screen-form" method="POST" action="{{ route('cart.items.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($product->variant_type && $product->variant_options)
                <label for="variant">Select {{ ucfirst($product->variant_type) }}:</label>
                <select id="variant" name="variant" required>
                    <option value="">Select</option>
                    @foreach($product->variant_options as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @endif

                <div class="pdp-screen-qty-group">
                    <label for="quantity">Quantity</label>
                    <div class="quantity pdp-screen-qty">
                        <button type="button" class="minus" aria-label="Decrease quantity">-</button>
                        <input
                            id="quantity"
                            class="quantity-input"
                            type="number"
                            name="quantity"
                            min="1"
                            max="10"
                            value="1"
                            required
                        >
                        <button type="button" class="plus" aria-label="Increase quantity">+</button>
                    </div>
                </div>

                <button class="btn pdp-screen-cta" type="submit">ADD TO CART</button>
            </form>
            @else
            <p><a href="{{ route('auth.login.show') }}">Login</a> to purchase this product.</p>
            @endauth
        </div>
    </div>
</div>
@endsection
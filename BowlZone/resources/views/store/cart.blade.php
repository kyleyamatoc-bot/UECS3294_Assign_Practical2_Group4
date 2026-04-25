@extends('layouts.app')

@section('title', 'Cart')

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')
@include('partials.store-header')

<div class="cart-page-layout">
    <div class="cart-container cart-main">
        <h1>MY CART</h1>

        @if($items->isEmpty())
        <p style="text-align:center; margin: 24px 0;">Your cart is empty.</p>
        <div class="cart-actions">
            <a class="btn primary" href="{{ route('store.index') }}">CONTINUE SHOPPING</a>
        </div>
        @else
    @php
    $toCanonicalCategory = function ($rawCategory) {
    $normalized = strtolower(trim((string) $rawCategory));
    $normalized = str_replace([' ', '-'], '_', $normalized);

    if (in_array($normalized, ['shoe', 'shoes'], true)) {
    return 'shoes';
    }

    if (in_array($normalized, ['bowling_ball', 'bowling_balls'], true)) {
    return 'bowling_ball';
    }

    if (in_array($normalized, ['accessory', 'accessories'], true)) {
    return 'accessories';
    }

    return $normalized ?: 'other_items';
    };

    $categoryLabels = [
    'shoes' => 'Bowling Shoes',
    'bowling_ball' => 'Bowling Ball',
    'accessories' => 'Accessories',
    ];

    $categoryOrder = [
    'shoes' => 1,
    'bowling_ball' => 2,
    'accessories' => 3,
    ];

    $groupedItems = $items
    ->groupBy(function ($item) use ($toCanonicalCategory) {
    return $toCanonicalCategory($item->product->category);
    })
    ->sortBy(function ($categoryItems, $categoryKey) use ($categoryOrder) {
    return $categoryOrder[$categoryKey] ?? 99;
    });
    @endphp

        @foreach($groupedItems as $category => $categoryItems)
        <section class="cart-section">
            <h2>{{ $categoryLabels[$category] ?? ucwords(str_replace('_', ' ', $category)) }}</h2>

            @foreach($categoryItems as $item)
            <div class="cart-item">
                <div class="cart-item-media">
                    <img src="{{ asset(str_replace('Store/', 'store/', $item->product->image_path)) }}" alt="{{ $item->product->name }}">
                </div>

                <div class="cart-item-details">
                    <p><strong>{{ $item->product->name }}</strong></p>
                    @if($item->variant)
                    <p>{{ ucfirst($item->product->variant_type ?: 'Variant') }}: {{ $item->variant }}</p>
                    @endif
                    <p>Qty: {{ $item->quantity }}</p>
                    <p>Price: RM{{ number_format((float)$item->total_price, 2) }}</p>
                </div>
            </div>
            @endforeach
        </section>
        @endforeach

        <div class="cart-actions">
            <a class="btn edit-cart" href="{{ route('cart.modify') }}">MODIFY CART</a>
            <a class="btn primary" href="{{ route('store.index') }}">CONTINUE SHOPPING</a>
        </div>
        @endif
    </div>

    @php
    $summaryItemCount = $items->sum('quantity');
    $summaryAmount = $items->isEmpty() ? 0 : (float) $cart->grand_total;
    @endphp
    <aside class="checkout-summary-card cart-summary-card">
        <h3>Order Summary</h3>
        <div class="checkout-summary-row">
            <span>Total Items</span>
            <strong>{{ $summaryItemCount }}</strong>
        </div>
        <div class="checkout-summary-row">
            <span>Subtotal</span>
            <strong>RM {{ number_format($summaryAmount, 2) }}</strong>
        </div>
        <div class="checkout-summary-row checkout-summary-total-row">
            <span>Total</span>
            <strong>RM {{ number_format($summaryAmount, 2) }}</strong>
        </div>
        @if(!$items->isEmpty())
        <div class="checkout-summary-action">
            <a class="btn btn-pay" href="{{ route('checkout.show') }}">� Proceed to Payment</a>
        </div>
        @endif
    </aside>
</div>
@endsection
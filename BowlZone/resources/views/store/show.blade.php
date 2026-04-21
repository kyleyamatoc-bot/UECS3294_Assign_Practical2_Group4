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
@include('partials.store-header')

<div class="card" style="max-width:860px; margin:0 auto;">
    <div class="pdp">
        <div class="pdp-media">
            <img src="{{ asset(str_replace('Store/', 'store/', $product->image_path)) }}" alt="{{ $product->name }}">
        </div>
        <div class="pdp-info">
            <h2 class="section-title">{{ $product->name }}</h2>
            <p><strong>Category:</strong> {{ ucwords(str_replace('_', ' ', $product->category)) }}</p>
            <p><strong>Price:</strong> RM {{ number_format((float)$product->price, 2) }}</p>
            @if($product->description)
            <p>{{ $product->description }}</p>
            @endif

            @auth
            <form method="POST" action="{{ route('cart.items.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($product->variant_type && $product->variant_options)
                <label>Select {{ ucfirst($product->variant_type) }}</label>
                <select name="variant" required>
                    <option value="">Select</option>
                    @foreach($product->variant_options as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @endif

                <label>Quantity</label>
                <input type="number" name="quantity" min="1" max="5" value="1" required>

                <button class="btn" type="submit">Add to Cart</button>
                <a class="btn secondary" href="{{ route('store.index') }}">Back</a>
            </form>
            @else
            <p><a href="{{ route('auth.login.show') }}">Login</a> to purchase this product.</p>
            @endauth
        </div>
    </div>
</div>
@endsection
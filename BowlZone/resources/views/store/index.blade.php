@extends('layouts.app')

@section('title', 'Store')

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')
@include('partials.store-header')

<div class="text-center">
    <h1 class="title_store">BowlZone Store</h1>
    <p>Browse shoes, bowling balls, and accessories.</p>
</div>

@foreach($grouped as $category => $products)
<div class="card">
    <h3 class="title_equipment">{{ ucwords(str_replace('_', ' ', $category)) }}</h3>
    <div class="item_container">
        @foreach($products as $product)
        @php
        $imagePath = str_replace('Store/', 'store/', $product->image_path);
        $linkClass = $product->category === 'shoes' ? 'shoe_link' : ($product->category === 'bowling_ball' ? 'ball_link' : 'accessories_link');
        @endphp
        <a href="{{ route('store.products.show', $product->slug) }}" class="{{ $linkClass }}">
            <div class="store-item-card">
                <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}" width="290" height="165">
                <p class="text-lg">{{ $product->name }}</p>
                <br>
                <p class="price_bold">RM {{ number_format((float)$product->price, 2) }}</p>
            </div>
        </a>
        @endforeach

        @if($category === 'bowling_ball')
        <div class="Yellow_Bowling">
            <img src="{{ asset('images/store/yellow_bowling.png') }}" alt="Yellow Bowling" width="290" height="165">
            <p class="text-lg">Yellow Bowling</p>
            <br>
            <p class="Out_of_stock">OUT OF STOCK</p>
            <br>
        </div>
        @endif
    </div>
</div>
@endforeach
@endsection
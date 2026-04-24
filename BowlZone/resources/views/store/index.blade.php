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

<div class="store-content-width">
    <div class="store-hero-wrap">
        <div class="store-hero">
            <img src="{{ asset('images/store/equipment_scene.png') }}" alt="BowlZone Store Banner">
            <h1 class="store-hero-title">BowlZone Store</h1>
        </div>
    </div>

    @php
        $categoryLabels = [
            'shoes' => 'BOWLING SHOES',
            'bowling_ball' => 'BOWLING BALL',
            'accessory' => 'ACCESSORIES',
        ];
    @endphp

    @php
        // Force display order: top shoes, then bowling ball, bottom accessories
        $displayOrder = ['shoes', 'bowling_ball', 'accessory'];

        // Add any unexpected categories at the end (if they exist)
        $existingCategories = $grouped->keys()->all(); // <- fix for Collection
        $remainingCategories = array_values(array_diff($existingCategories, $displayOrder));
        $finalOrder = array_merge($displayOrder, $remainingCategories);
    @endphp

    @foreach($finalOrder as $category)
        @continue(!isset($grouped[$category]))
        @php $products = $grouped[$category]; @endphp

        <div class="card store-category-section">
            <h3 class="title_equipment">{{ $categoryLabels[$category] ?? ucwords(str_replace('_', ' ', $category)) }}</h3>
            @if(in_array($category, ['accessory', 'bowling_ball', 'shoes']))
                <br>
            @endif

            <div class="item_container">
                @foreach($products as $product)
                    @php
                        $imagePath = str_replace('Store/', 'store/', $product->image_path);
                        $linkClass = $product->category === 'shoes'
                            ? 'shoe_link'
                            : ($product->category === 'bowling_ball' ? 'ball_link' : 'accessories_link');
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
            </div>
        </div>
    @endforeach
</div>
@endsection
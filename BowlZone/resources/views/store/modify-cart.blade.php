@extends('layouts.app')

@section('title', 'Modify Cart')

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')
@include('partials.store-header')

<div class="modify-cart-shell">
    <h2 class="section-title modify-cart-title">Modify Cart</h2>

    @if($items->isEmpty())
    <div class="card" style="text-align:center;">
        <p>Your cart is empty.</p>
        <a class="btn primary" href="{{ route('store.index') }}">Continue Shopping</a>
    </div>
    @else
    <div class="card table-container modify-cart-table-container">
        <table class="modify-cart-table">
            <tr>
                <th>Item</th>
                <th>Variant</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            @foreach($items as $item)
            <tr>
                <td>
                    <div class="modify-cart-item-cell">
                        <img src="{{ asset(str_replace('Store/', 'store/', $item->product->image_path)) }}" alt="{{ $item->product->name }}">
                        <span>{{ $item->product->name }}</span>
                    </div>
                </td>
                <td>{{ $item->variant ?: '-' }}</td>
                <td>
                    <form method="POST" action="{{ route('cart.items.update', $item->id) }}" style="display:flex; gap:8px; align-items:center; justify-content:center;">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="quantity" min="1" max="10" value="{{ $item->quantity }}" style="width:80px; margin:0;">
                        <button class="btn btn-modify" type="submit">Update</button>
                    </form>
                </td>
                <td>RM {{ number_format((float)$item->unit_price, 2) }}</td>
                <td>RM {{ number_format((float)$item->total_price, 2) }}</td>
                <td>
                    <form method="POST" action="{{ route('cart.items.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-cancel" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="cart-actions modify-cart-actions">
        <a class="btn primary" href="{{ route('cart.index') }}">Back to My Cart</a>
        <a class="btn primary" href="{{ route('store.index') }}">Continue Shopping</a>
    </div>
    @endif
</div>
@endsection

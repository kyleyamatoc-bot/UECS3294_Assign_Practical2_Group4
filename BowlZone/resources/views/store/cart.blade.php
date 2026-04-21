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

<div class="card">
    <h2 class="section-title">My Cart</h2>
</div>

<div class="card table-container">
    <table>
        <tr>
            <th>Item</th>
            <th>Variant</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        @forelse($items as $item)
        <tr>
            <td>
                <div style="display:flex; align-items:center; gap:12px; justify-content:center;">
                    <img src="{{ asset(str_replace('Store/', 'store/', $item->product->image_path)) }}" alt="{{ $item->product->name }}" style="width:72px; height:auto; border-radius:8px;">
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
        @empty
        <tr>
            <td colspan="6">Your cart is empty.</td>
        </tr>
        @endforelse
    </table>
</div>

@if($items->count())
<div class="card">
    <p><strong>Grand Total:</strong> RM {{ number_format((float)$cart->grand_total, 2) }}</p>
    <a class="btn success" href="{{ route('checkout.show') }}">Proceed to Checkout</a>
</div>
@endif
@endsection
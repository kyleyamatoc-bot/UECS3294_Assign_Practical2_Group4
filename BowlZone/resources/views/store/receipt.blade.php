@extends('layouts.app')

@section('title', 'Order Receipt')

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
    <h2 class="section-title">Order Receipt</h2>
    <p><strong>Order:</strong> #{{ $order->id }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    <p><strong>Reference:</strong> {{ $order->payment_reference }}</p>
    <p><strong>Total Paid:</strong> RM {{ number_format((float)$order->total_amount, 2) }}</p>

    <table>
        <tr>
            <th>Item</th>
            <th>Variant</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Total</th>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->variant ?: '-' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>RM {{ number_format((float)$item->unit_price, 2) }}</td>
            <td>RM {{ number_format((float)$item->total_price, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <a class="btn" href="{{ route('store.index') }}">Back to Store</a>
</div>
@endsection
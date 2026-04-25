@extends('layouts.app')

@section('title', 'Order Receipt')

@section('bodyClass', 'store-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/store.css') }}">
<style>
    .receipt-details {
        text-align: center;
        max-width: 520px;
        margin: 0 auto 3rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .receipt-details p {
        margin: 1.5rem 0;
        font-size: 1.1rem;
        font-weight: 550;
    }
    .section-title {
        font-size: 2.5rem;
        text-transform: uppercase;
        text-decoration:underline;
        letter-spacing: 0.05em;
        margin-bottom: 3rem;
    }
    .receipt-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1.5rem;
        border: 1px solid #e4e4e4;
        border-radius: 10px;
        overflow: hidden;
    }
    .receipt-table th,
    .receipt-table td {
        padding: 0.85rem 0.9rem;
        border-bottom: 1px solid #e4e4e4;
        vertical-align: middle;
    }
    .receipt-table thead th {
        text-align: center;
        font-weight: 600;
        color: #fff;
        background-color: #007bff;
        border-bottom: 1px solid #0056b3;
    }
    .receipt-product-cell {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .receipt-product-image {
        width: 60px;
        height: 60px;
        min-width: 60px;
        min-height: 60px;
        max-width: 60px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #fff;
        display: block;
    }
    .receipt-order-card {
        max-width: 920px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #fffbf8;
        border: 1px solid #ffd8c2;
        border-radius: 14px;
    }
    .receipt-card-actions {
        margin-top: 2.5rem;
        text-align: center;
    }
    .receipt-card-actions .btn {
        background-color: #d63447;
        color: #fff;
        border: 1px solid #c1273c;
        padding: 0.9rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .receipt-card-actions .btn:hover {
        background-color: #9c1d2f;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endsection

@section('content')

<div class="card receipt-order-card">
    <h2 class="section-title" style="text-align:center;">Order Receipt</h2>

    <div class="receipt-details">
        <p><strong>Order:</strong> #{{ $order->id }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
        <p><strong>Reference:</strong> {{ $order->payment_reference }}</p>
        <p><strong>Total Paid:</strong> RM {{ number_format((float)$order->total_amount, 2) }}</p>
    </div>

    <table class="receipt-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Variant</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <div class="receipt-product-cell">
                        @if($item->product && $item->product->image_path)
                            <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product_name }}" class="receipt-product-image">
                        @endif
                        <span>{{ $item->product_name }}</span>
                    </div>
                </td>
                <td>{{ $item->variant ?: '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>RM {{ number_format((float)$item->unit_price, 2) }}</td>
                <td>RM {{ number_format((float)$item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="receipt-card-actions">
        <a class="btn" href="{{ route('store.index') }}">Back to Store</a>
    </div>
</div>
@endsection
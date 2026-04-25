@extends('layouts.app')

@section('title', 'Orders - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>
        <h1>Orders</h1>
        <p class="admin-subtitle">Manage all store orders with detailed information</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('admin.orders') }}" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="search-input">
            </div>

            <div class="filter-dropdown">
                <select name="sort" class="filter-select">
                    <option value="date_latest" {{ request('sort') === 'date_latest' ? 'selected' : '' }}>Date: Latest</option>
                    <option value="date_earliest" {{ request('sort') === 'date_earliest' ? 'selected' : '' }}>Date: Earliest</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A - Z</option>
                    <option value="product_asc" {{ request('sort') === 'product_asc' ? 'selected' : '' }}>Product: A - Z</option>
                </select>
            </div>

            <button type="submit" class="search-btn">Search</button>
            <div style="text-align: center; margin-top: 0.5rem;">
                <a href="{{ route('admin.orders') }}" class="reset-filter">Reset</a>
            </div>
        </form>
    </div>

    <div class="orders-container">
        @forelse ($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Order #{{ $order->id }}</h3>
                        <p class="order-customer"><strong>Customer:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                        <p class="order-email"><strong>Email:</strong> {{ $order->email }}</p>
                        <p class="order-phone"><strong>Phone:</strong> {{ $order->phone }}</p>
                    </div>
                    <div class="order-meta">
                        <p class="order-date">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        <span class="badge badge-{{ strtolower($order->payment_status) }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="order-items">
                    <h4>Items</h4>
                    @forelse($order->items as $item)
                        <div class="order-item">
                            <div class="item-image">
                                @if($item->product && $item->product->image_path)
                                    <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product_name }}">
                                @else
                                    <div class="no-image">
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="item-details">
                                <h5>{{ $item->product_name }}</h5>
                                @if($item->variant)
                                    <p class="variant"><strong>Variant:</strong> {{ $item->variant }}</p>
                                @endif
                                <div class="item-specs">
                                    <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                                    <p><strong>Unit Price:</strong> RM {{ number_format((float)$item->unit_price, 2) }}</p>
                                </div>
                            </div>

                            <div class="item-total">
                                <p class="total-price">RM {{ number_format((float)$item->total_price, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="no-items">No items in this order.</p>
                    @endforelse
                </div>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>Total Amount:</span>
                        <strong>RM {{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Payment Method:</span>
                        <span>{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    @if($order->paid_at)
                    <div class="summary-row">
                        <span>Paid Date:</span>
                        <span>{{ $order->paid_at->format('M d, Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>No orders found.</p>
            </div>
        @endforelse
    </div>

    @if ($orders->hasPages())
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

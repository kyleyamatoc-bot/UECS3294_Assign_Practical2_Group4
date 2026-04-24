@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <p class="admin-subtitle">Welcome, {{ auth()->user()->first_name }}! Manage your bowling center from here.</p>
    </div>

    <div class="dashboard-grid">
        <!-- Users Card -->
        <div class="dashboard-card">
            <div class="card-icon">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 20C23.866 20 27 16.866 27 13C27 9.13401 23.866 6 20 6C16.134 6 13 9.13401 13 13C13 16.866 16.134 20 20 20ZM20 20C14.4772 20 10 24.4772 10 30V34H30V30C30 24.4772 25.5228 20 20 20Z" stroke="#dc3545" stroke-width="2" fill="none" />
                </svg>
            </div>
            <div class="card-content">
                <h3>Users</h3>
                <p class="card-number">{{ $totalUsers }}</p>
                <p class="card-label">Total Users</p>
            </div>
            <a href="{{ route('admin.users') }}" class="card-link">View All →</a>
        </div>

        <!-- Contact Messages Card -->
        <div class="dashboard-card">
            <div class="card-icon">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 8C5 6.89543 5.89543 6 7 6H33C34.1046 6 35 6.89543 35 8V28C35 29.1046 34.1046 30 33 30H10L5 35V8Z" stroke="#dc3545" stroke-width="2" fill="none" />
                </svg>
            </div>
            <div class="card-content">
                <h3>Contact Messages</h3>
                <p class="card-number">{{ $totalMessages }}</p>
                <p class="card-label">Total Messages</p>
            </div>
            <a href="{{ route('admin.contact-messages') }}" class="card-link">View All →</a>
        </div>

        <!-- Bookings Card -->
        <div class="dashboard-card">
            <div class="card-icon">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 6H30C31.1046 6 32 6.89543 32 8V32C32 33.1046 31.1046 34 30 34H10C8.89543 34 8 33.1046 8 32V8C8 6.89543 8.89543 6 10 6ZM14 12H16V14H14V12ZM20 12H22V14H20V12ZM26 12H28V14H26V12Z" stroke="#dc3545" stroke-width="2" fill="none" />
                </svg>
            </div>
            <div class="card-content">
                <h3>Bookings</h3>
                <p class="card-number">{{ $totalBookings }}</p>
                <p class="card-label">Total Bookings</p>
            </div>
            <a href="{{ route('admin.bookings') }}" class="card-link">View All →</a>
        </div>

        <!-- Orders Card -->
        <div class="dashboard-card">
            <div class="card-icon">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 6H32C33.1046 6 34 6.89543 34 8V30C34 31.1046 33.1046 32 32 32H8C6.89543 32 6 31.1046 6 30V8C6 6.89543 6.89543 6 8 6ZM8 12V30H32V12H8ZM10 16H30V18H10V16ZM10 22H30V24H10V22Z" stroke="#dc3545" stroke-width="2" fill="none" />
                </svg>
            </div>
            <div class="card-content">
                <h3>Orders</h3>
                <p class="card-number">{{ $totalOrders }}</p>
                <p class="card-label">Total Orders</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="card-link">View All →</a>
        </div>
    </div>

    <div class="admin-section">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('admin.users') }}" class="action-btn action-btn-primary">
                👥 Manage Users
            </a>
            <a href="{{ route('admin.contact-messages') }}" class="action-btn action-btn-primary">
                📧 View Contact Messages
            </a>
            <a href="{{ route('admin.bookings') }}" class="action-btn action-btn-primary">
                📅 Manage Bookings
            </a>
            <a href="{{ route('admin.orders') }}" class="action-btn action-btn-primary">
                📦 Manage Orders
            </a>
        </div>
    </div>
</div>
@endsection
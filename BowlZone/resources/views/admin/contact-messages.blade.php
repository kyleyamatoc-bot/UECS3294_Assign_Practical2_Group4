@extends('layouts.app')

@section('title', 'Contact Messages - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>
        <h1>Contact Messages</h1>
        <p class="admin-subtitle">Manage and review customer contact messages</p>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('admin.contact-messages') }}" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="search-input">
            </div>

            <div class="filter-dropdown">
                <select name="sort" class="filter-select">
                    <option value="date_latest" {{ request('sort') === 'date_latest' ? 'selected' : '' }}>Date: Latest</option>
                    <option value="date_earliest" {{ request('sort') === 'date_earliest' ? 'selected' : '' }}>Date: Earliest</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A - Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z - A</option>
                </select>
            </div>

            <div class="filter-dropdown">
                <select name="type" class="filter-select">
                    <option value="">All Types</option>
                    <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                    <option value="booking" {{ request('type') === 'booking' ? 'selected' : '' }}>Booking</option>
                    <option value="complaint" {{ request('type') === 'complaint' ? 'selected' : '' }}>Complaint</option>
                    <option value="suggestion" {{ request('type') === 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                </select>
            </div>

            <div class="filter-dropdown">
                <select name="priority" class="filter-select">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <button type="submit" class="search-btn">Search</button>
            <div style="text-align: center; margin-top: 0.5rem;">
                <a href="{{ route('admin.contact-messages') }}" class="reset-filter">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Priority</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                <tr>
                    <td><strong>{{ $message->first_name }} {{ $message->last_name }}</strong></td>
                    <td>{{ $message->email }}</td>
                    <td>
                        <span class="badge badge-{{ $message->inquiry_type }}">
                            {{ ucfirst($message->inquiry_type) }}
                        </span>
                    </td>
                    <td>
                        <span class="priority priority-{{ $message->priority }}">
                            {{ ucfirst($message->priority) }}
                        </span>
                    </td>
                    <td>{{ substr($message->subject, 0, 30) }}{{ strlen($message->subject) > 30 ? '...' : '' }}</td>
                    <td>{{ $message->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="booking-actions">
                            <a href="{{ route('admin.contact-message.show', $message) }}" class="table-action-btn table-action-btn-edit">View</a>
                            <form method="POST" action="{{ route('admin.contact-message.delete', $message) }}" class="booking-actions-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-action-btn table-action-btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No contact messages found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
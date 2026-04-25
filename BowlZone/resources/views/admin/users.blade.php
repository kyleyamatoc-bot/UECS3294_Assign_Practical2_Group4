@extends('layouts.app')

@section('title', 'Users - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>
        <h1>Users</h1>
        <p class="admin-subtitle">Manage registered users</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('admin.users') }}" class="search-form">
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

            <button type="submit" class="search-btn">Search</button>
            <div style="text-align: center; margin-top: 0.5rem;">
                <a href="{{ route('admin.users') }}" class="reset-filter">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>
                        <span class="badge badge-general">Active</span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="booking-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="table-action-btn table-action-btn-edit">Edit</a>
                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="booking-actions-form" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-action-btn table-action-btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
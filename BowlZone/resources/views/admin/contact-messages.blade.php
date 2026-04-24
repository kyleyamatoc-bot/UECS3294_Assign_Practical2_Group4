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
                        <a href="{{ route('admin.contact-message.show', $message) }}" class="action-link">View</a>
                        <form method="POST" action="{{ route('admin.contact-message.delete', $message) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link action-link-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
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

    @if ($messages->hasPages())
    <div class="pagination-wrapper">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.users') }}" class="back-link">← Back to Users</a>
        <h1>Edit User</h1>
        <p class="admin-subtitle">Modify user information or delete account</p>
    </div>

    <div class="detail-container">
        <div class="detail-card">
            <!-- Edit Form -->
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PATCH')

                <div class="detail-section">
                    <h3>User Information</h3>

                    <div class="detail-row">
                        <div class="detail-col">
                            <h4>First Name</h4>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required class="form-input">
                            @error('first_name')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="detail-col">
                            <h4>Last Name</h4>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required class="form-input">
                            @error('last_name')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-col">
                            <h4>Username</h4>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="form-input">
                            @error('username')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="detail-col">
                            <h4>Email</h4>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                            @error('email')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-col">
                            <h4>Member Since</h4>
                            <p>{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="detail-col">
                            <h4>Last Updated</h4>
                            <p>{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="detail-actions">
                    <button type="submit" class="btn-danger">Save Changes</button>
                    <a href="{{ route('admin.users') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>

            <!-- Delete Section -->
            <div class="detail-section" style="margin-top: 3rem; padding-top: 3rem; border-top: 3px solid #eee;">
                <h3 style="color: #dc3545;">Danger Zone</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">Delete this user account. Choose how to handle associated data:</p>

                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" id="deleteForm">
                    @csrf
                    @method('DELETE')

                    <div class="delete-options" style="margin-bottom: 1.5rem; gap: 1rem; display: flex; flex-direction: column;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; border: 2px solid #ddd; border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                            <input type="radio" name="delete_option" value="soft" checked style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <strong>Soft Delete (Recommended)</strong>
                                <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.9rem;">Deactivate account but keep all data and records. Can be restored if needed.</p>
                            </div>
                        </label>

                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; border: 2px solid #ffcdd2; border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                            <input type="radio" name="delete_option" value="hard" style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <strong style="color: #dc3545;">Hard Delete (Permanent)</strong>
                                <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.9rem;">Permanently delete account and ALL associated data (bookings, orders, messages). This cannot be undone.</p>
                            </div>
                        </label>
                    </div>

                    <div class="detail-actions">
                        <button type="button" class="btn-danger" onclick="confirmDelete()">Delete User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .error-text {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 0;
        border-bottom: none;
    }

    .detail-col h4 {
        margin-top: 0;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .detail-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .delete-options {
            flex-direction: column;
        }
    }
</style>

<script>
    function confirmDelete() {
        const deleteOption = document.querySelector('input[name="delete_option"]:checked').value;
        const message = deleteOption === 'hard'
            ? 'WARNING: This will PERMANENTLY delete the user and ALL associated data (bookings, orders, messages). This cannot be undone!\n\nAre you absolutely sure?'
            : 'This will deactivate the user account but keep all data for records.\n\nContinue?';

        if (confirm(message)) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection

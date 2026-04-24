@extends('layouts.app')

@section('title', 'Message Details - Admin')

@section('bodyClass', 'admin-page')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <a href="{{ route('admin.contact-messages') }}" class="back-link">← Back to Messages</a>
        <h1>Message Details</h1>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="detail-container">
        <div class="detail-card">
            <div class="detail-row">
                <div class="detail-col">
                    <h3>Sender Information</h3>
                    <p><strong>Name:</strong> {{ $message->first_name }} {{ $message->last_name }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
                    <p><strong>Phone:</strong> {{ $message->phone ?? 'Not provided' }}</p>
                    @if ($message->user)
                    <p><strong>User:</strong> <a href="{{ route('admin.users') }}">View User Profile</a></p>
                    @endif
                </div>

                <div class="detail-col">
                    <h3>Message Metadata</h3>
                    <p>
                        <strong>Type:</strong>
                        <span class="badge badge-{{ $message->inquiry_type }}">{{ ucfirst($message->inquiry_type) }}</span>
                    </p>
                    <p>
                        <strong>Priority:</strong>
                        <span class="priority priority-{{ $message->priority }}">{{ ucfirst($message->priority) }}</span>
                    </p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $message->status }}">{{ ucfirst($message->status) }}</span>
                    </p>
                    <p><strong>Sent:</strong> {{ $message->created_at ? $message->created_at->format('F d, Y \a\t h:i A') : 'Unknown' }}</p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Subject</h3>
                <p class="message-subject">{{ $message->subject }}</p>
            </div>

            <div class="detail-section">
                <h3>Message</h3>
                <div class="message-content">
                    {{ $message->message }}
                </div>
            </div>

            <!-- Conversation Thread -->
            <div class="conversation-section">
                <h3>Conversation</h3>

                @forelse($message->replies as $reply)
                <div class="reply-message {{ $reply->reply_type === 'admin' ? 'admin-reply' : 'user-reply-admin' }}">
                    <div class="reply-header">
                        <strong class="reply-author {{ $reply->reply_type === 'admin' ? 'admin-author' : 'user-author' }}">
                            @if($reply->reply_type === 'admin')
                                @if($reply->admin)
                                {{ $reply->admin->first_name }} {{ $reply->admin->last_name }} (Admin)
                                @else
                                Admin (Deleted)
                                @endif
                            @else
                                @if($reply->user)
                                {{ $reply->user->username }} (Reply)
                                @else
                                User (Deleted) (Reply)
                                @endif
                            @endif
                        </strong>
                        <span class="reply-date">
                            @if($reply->created_at)
                            {{ $reply->created_at->format('M d, Y H:i') }}
                            @else
                            Unknown
                            @endif
                        </span>
                    </div>
                    <div class="reply-body">
                        {{ $reply->reply_message }}
                    </div>
                </div>
                @empty
                <p class="no-replies">No replies yet</p>
                @endforelse

                <!-- Reply Form -->
                <form method="POST" action="{{ route('admin.contact-message.reply', ['contactMessage' => $message->id]) }}" class="reply-form">
                    @csrf

                    <div class="form-group">
                        <label for="reply_message">Your Reply</label>
                        <textarea id="reply_message" name="reply_message" rows="5" placeholder="Type your reply here..." required>{{ old('reply_message') }}</textarea>
                        @error('reply_message')<span class="error">{{ $errors->first('reply_message') }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Mark as</label>
                        <select id="status" name="status" required>
                            <option value="pending" {{ old('status', $message->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="solved" {{ old('status', $message->status) === 'solved' ? 'selected' : '' }}>Solved ✓</option>
                        </select>
                        @error('status')<span class="error">{{ $errors->first('status') }}</span>@enderror
                    </div>

                    <button type="submit" class="btn-submit-reply">Send Reply</button>
                </form>
            </div>

            <div class="detail-actions">
                <form method="POST" action="{{ route('admin.contact-message.delete', ['contactMessage' => $message->id]) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">
                        Delete Message
                    </button>
                </form>
                <a href="{{ route('admin.contact-messages') }}" class="btn-secondary">Back to Messages</a>
            </div>
        </div>
    </div>
</div>
@endsection
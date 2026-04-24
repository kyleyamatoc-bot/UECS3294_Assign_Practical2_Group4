<!-- My Messages Section -->
<div class="account-section">
    <h2 class="section-title">My Support Messages</h2>

    @if($messages->count() > 0)
    <div class="messages-list">
        @foreach($messages as $message)
        <div class="message-card {{ $message->status }}">
            <div class="message-header">
                <h4>{{ $message->subject }}</h4>
                <span class="message-status {{ $message->status }}">
                    {{ ucfirst($message->status) }}
                </span>
            </div>

            <div class="message-meta">
                <span><strong>Type:</strong> {{ ucfirst($message->inquiry_type) }}</span>
                <span><strong>Priority:</strong> {{ ucfirst($message->priority) }}</span>
                <span><strong>Sent:</strong> {{ $message->created_at->format('M d, Y H:i') }}</span>
            </div>

            <div class="message-body">
                {{ $message->message }}
            </div>

            @if($message->replies->count() > 0)
            <div class="message-replies">
                <h5>Admin Responses ({{ $message->replies->count() }})</h5>
                @foreach($message->replies as $reply)
                <div class="reply-item">
                    <div class="reply-admin">
                        <strong>{{ $reply->admin->first_name }} {{ $reply->admin->last_name }}</strong>
                        <span class="reply-time">{{ $reply->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="reply-text">
                        {{ $reply->reply_message }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="no-replies-yet">
                <p>Waiting for admin response...</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if($messages->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $messages->links('pagination::bootstrap-4', ['paginator' => $messages, 'path' => request()->url(), 'query' => ['messages_page' => request('messages_page')]]) }}
    </div>
    @endif
    @else
    <p style="text-align: center; color: #666; padding: 2rem;">
        You haven't sent any support messages yet. <a href="{{ route('contact.create') }}">Contact us now</a>
    </p>
    @endif
</div>

<style>
    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .message-card {
        background: #fff;
        padding: 1.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .message-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Status-based card borders */
    .message-card.solved {
        border-left: 4px solid #28a745;
    }

    .message-card.read {
        border-left: 4px solid #ffc107;
    }

    .message-card.unread {
        border-left: 4px solid #dc3545;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
    }

    .message-header h4 {
        color: #000;
        margin: 0;
        font-size: 1.1rem;
    }

    .message-status {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Status-based badge colors */
    .message-status.solved {
        background: #d4edda;
        color: #155724;
    }

    .message-status.read {
        background: #fff3cd;
        color: #856404;
    }

    .message-status.unread {
        background: #f8d7da;
        color: #721c24;
    }

    .message-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #666;
        flex-wrap: wrap;
    }

    .message-body {
        color: #333;
        line-height: 1.6;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 4px;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .message-replies {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .message-replies h5 {
        color: #dc3545;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .reply-item {
        background: #fff5f5;
        padding: 0.75rem;
        border-radius: 4px;
        margin-bottom: 0.75rem;
        border-left: 3px solid #dc3545;
    }

    .reply-admin {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .reply-admin strong {
        color: #dc3545;
    }

    .reply-time {
        color: #999;
        font-size: 0.85rem;
    }

    .reply-text {
        color: #333;
        line-height: 1.6;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .no-replies-yet {
        color: #999;
        text-align: center;
        padding: 1rem;
        font-style: italic;
        background: #f9f9f9;
        border-radius: 4px;
    }
</style>
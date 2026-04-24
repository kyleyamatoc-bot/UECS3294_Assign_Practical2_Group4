<!-- My Support Messages Section -->
<div class="table-container support-messages-container">
    <div class="support-header">
        <h3>My Support Messages</h3>
        <a href="{{ route('contact.create') }}" class="btn-new-message">+ New Message</a>
    </div>

    @if($messages->count() > 0)
    <div class="messages-list">
        @foreach($messages as $message)
        <div class="message-card message-card-{{ $message->status }}">
            <!-- Message Header -->
            <div class="message-card-header">
                <div class="message-title-section">
                    <h4 class="message-title">{{ $message->subject }}</h4>
                    <span class="message-status badge-{{ $message->status }}">
                        {{ ucfirst($message->status) }}
                    </span>
                </div>
                <div class="message-time">{{ $message->created_at->format('M d, Y') }}</div>
            </div>

            <!-- Message Meta -->
            <div class="message-meta-info">
                <span class="meta-item">
                    <span class="meta-label">Type:</span>
                    <span class="meta-value">{{ ucfirst($message->inquiry_type) }}</span>
                </span>
                <span class="meta-divider">•</span>
                <span class="meta-item">
                    <span class="meta-label">Priority:</span>
                    <span class="priority-badge priority-{{ strtolower($message->priority) }}">{{ ucfirst($message->priority) }}</span>
                </span>
                <span class="meta-divider">•</span>
                <span class="meta-item">
                    <span class="meta-label">Sent:</span>
                    <span class="meta-value">{{ $message->created_at->format('H:i') }}</span>
                </span>
            </div>

            <!-- Conversation Thread -->
            <div class="conversation-thread">
                <!-- User Message -->
                <div class="message-bubble user-message">
                    <div class="bubble-header">
                        <span class="bubble-sender">You</span>
                        <span class="bubble-time">{{ $message->created_at->format('M d, H:i') }}</span>
                    </div>
                    <div class="bubble-content">
                        {{ $message->message }}
                    </div>
                </div>

                <!-- Admin Replies -->
                @if($message->replies->count() > 0)
                    @foreach($message->replies as $reply)
                    <div class="message-bubble {{ $reply->reply_type === 'admin' ? 'admin-message' : 'user-response' }}">
                        <div class="bubble-header">
                            <span class="bubble-sender">
                                @if($reply->reply_type === 'admin')
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1C4.134 1 1 4.134 1 8s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7zm0 3c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-1.7 0-3.2-.8-4.2-2 .5-1.3 1.9-2.2 3.5-2.2s3 .9 3.5 2.2c-1 1.2-2.5 2-4.2 2z" fill="#dc3545"/>
                                    </svg>
                                    {{ $reply->admin->first_name }} {{ $reply->admin->last_name }}
                                @else
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1C4.134 1 1 4.134 1 8s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7zm0 3c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-1.7 0-3.2-.8-4.2-2 .5-1.3 1.9-2.2 3.5-2.2s3 .9 3.5 2.2c-1 1.2-2.5 2-4.2 2z" fill="#0056b3"/>
                                    </svg>
                                    You (Reply)
                                @endif
                            </span>
                            <span class="bubble-time">{{ $reply->created_at->format('M d, H:i') }}</span>
                        </div>
                        <div class="bubble-content">
                            {{ $reply->reply_message }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-replies-yet">
                        <div class="no-replies-icon">⏳</div>
                        <p>Waiting for admin response...</p>
                        <small>We typically respond within 24-48 hours</small>
                    </div>
                @endif

                <!-- Reply Form -->
                @if($message->status !== 'solved')
                <div class="user-reply-form-container">
                    <form action="{{ route('contact.reply', $message->id) }}" method="POST" class="user-reply-form" onsubmit="handleReplySubmit(event)">
                        @csrf
                        <div class="reply-form-group">
                            <label for="reply_{{ $message->id }}">Your Reply</label>
                            <textarea
                                id="reply_{{ $message->id }}"
                                name="reply_message"
                                placeholder="Type your response here..."
                                rows="4"
                                minlength="5"
                            ></textarea>
                            @error('reply_message')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="reply-submit-wrapper">
                            <button type="submit" class="btn-submit-user-reply">Send Reply</button>
                            <div class="reply-success-message" style="display:none;">
                                ✓ Your reply has been sent to the admin. Please be patient and avoid sending multiple replies.
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="message-solved-notice">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 0C4.5 0 0 4.5 0 10s4.5 10 10 10 10-4.5 10-10S15.5 0 10 0zm-2 15l-5-5 1.4-1.4L8 12.2l9.6-9.6L19 4z" fill="#28a745"/>
                    </svg>
                    This conversation has been resolved and is now closed.
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Enhanced Pagination -->
    @if($messages->hasPages())
    <div class="pagination-wrapper-custom">
        {{ $messages->links() }}
    </div>
    @endif
    @else
    <div class="empty-state-messages">
        <div class="empty-icon">📧</div>
        <p>You haven't sent any support messages yet.</p>
        <a href="{{ route('contact.create') }}" class="btn-primary-large">Send a Message Now</a>
    </div>
    @endif
</div>

<style>
    /* Hide top success messages on account page */
    .message.success {
        display: none !important;
    }
    /* Support Messages Container */
    .support-messages-container {
        margin-top: 3rem;
        padding: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .support-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: #fff;
        border-bottom: 2px solid #eee;
    }

    .support-header h3 {
        color: #000;
        font-size: 1.3rem;
        margin: 0;
        font-weight: 600;
    }

    .btn-new-message {
        padding: 0.6rem 1.2rem;
        background: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-new-message:hover {
        background: #a02834;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Messages List */
    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #fff;
    }

    /* Message Card */
    .message-card {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 1.5rem;
        background: #fff;
        transition: all 0.3s ease;
    }

    .message-card:hover {
        border-color: #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
    }

    /* Status-based card styling */
    .message-card-solved {
        border-left: 5px solid #28a745;
    }

    .message-card-read {
        border-left: 5px solid #ffc107;
    }

    .message-card-unread {
        border-left: 5px solid #dc3545;
    }

    /* Card Header */
    .message-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #eee;
    }

    .message-title-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .message-title {
        color: #000;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    /* Status Badges */
    .message-status {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }

    .badge-solved {
        background: #d4edda;
        color: #155724;
    }

    .badge-read {
        background: #fff3cd;
        color: #856404;
    }

    .badge-unread {
        background: #f8d7da;
        color: #721c24;
    }

    .message-time {
        color: #999;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Message Meta Info */
    .message-meta-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: #666;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .meta-label {
        font-weight: 600;
        color: #333;
    }

    .meta-value {
        color: #666;
    }

    .meta-divider {
        color: #ddd;
    }

    /* Priority Badge */
    .priority-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .priority-low {
        background: #c8e6c9;
        color: #1b5e20;
    }

    .priority-medium {
        background: #fff9c4;
        color: #f57f17;
    }

    .priority-high {
        background: #ffcdd2;
        color: #b71c1c;
    }

    /* Conversation Thread */
    .conversation-thread {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* Message Bubbles */
    .message-bubble {
        padding: 1rem;
        border-radius: 8px;
        margin-left: 0;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* User Message */
    .user-message {
        background: #f0f4f8;
        border-left: 4px solid #007bff;
        margin-right: 2rem;
    }

    /* Admin Message - Red Color */
    .admin-message {
        background: #ffebee;
        border-left: 4px solid #dc3545;
        margin-left: 2rem;
    }

    /* User Response Message - Darker Blue */
    .user-response {
        background: #e3f2fd;
        border-left: 4px solid #0056b3;
        margin-left: 2rem;
    }

    /* User Reply Form Container */
    .user-reply-form-container {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #f9fafb;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        animation: slideIn 0.3s ease;
    }

    .user-reply-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .reply-form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .reply-form-group label {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .reply-form-group textarea {
        padding: 0.75rem;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 0.95rem;
        resize: vertical;
        transition: border-color 0.3s ease;
    }

    .reply-form-group textarea:focus {
        outline: none;
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .reply-form-group textarea::placeholder {
        color: #999;
    }

    .reply-form-group textarea.error-border {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .btn-submit-user-reply {
        align-self: flex-start;
        padding: 0.7rem 1.5rem;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit-user-reply:hover {
        background: #a02834;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .btn-submit-user-reply:active {
        transform: translateY(0);
    }

    /* Message Solved Notice */
    .message-solved-notice {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #d4edda;
        border: 2px solid #28a745;
        border-radius: 8px;
        color: #155724;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .message-solved-notice svg {
        flex-shrink: 0;
    }

    /* Reply Submit Wrapper */
    .reply-submit-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-start;
    }

    /* Success Message After Submit */
    .reply-success-message {
        padding: 0.75rem 1rem;
        background: #d4edda;
        color: #155724;
        border: 2px solid #28a745;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    }

    /* Bubble Header */
    .bubble-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        gap: 1rem;
    }

    .bubble-sender {
        font-weight: 700;
        color: #000;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.95rem;
        white-space: nowrap;
    }

    .bubble-time {
        font-size: 0.8rem;
        color: #999;
        white-space: nowrap;
    }

    /* Bubble Content */
    .bubble-content {
        color: #333;
        line-height: 1.6;
        white-space: pre-wrap;
        word-wrap: break-word;
        font-size: 0.95rem;
    }

    /* No Replies Yet */
    .no-replies-yet {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f9f9f9 0%, #f0f0f0 100%);
        border-radius: 8px;
        border: 2px dashed #ddd;
        color: #666;
    }

    .no-replies-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .no-replies-yet p {
        margin: 0.5rem 0;
        font-weight: 600;
        color: #666;
    }

    .no-replies-yet small {
        color: #999;
        font-size: 0.85rem;
        display: block;
        margin-top: 0.5rem;
    }

    /* Empty State */
    .empty-state-messages {
        padding: 3rem 1.5rem;
        text-align: center;
        background: #fff;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-state-messages p {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-primary-large {
        display: inline-block;
        padding: 0.8rem 2rem;
        background: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-large:hover {
        background: #a02834;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Pagination */
    .pagination-wrapper-custom {
        padding: 1.5rem;
        background: #fff;
        display: flex;
        justify-content: center;
        border-top: 2px solid #eee;
    }

    .pagination-wrapper-custom .pagination {
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .support-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-new-message {
            width: 100%;
            text-align: center;
        }

        .user-message {
            margin-right: 0;
        }

        .admin-message,
        .user-response {
            margin-left: 0;
        }

        .message-card-header {
            flex-direction: column;
            gap: 0.5rem;
        }

        .message-time {
            width: 100%;
            text-align: left;
        }

        .message-meta-info {
            flex-wrap: wrap;
        }

        .bubble-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.3rem;
        }

        .messages-list {
            padding: 1rem;
        }

        .message-card {
            padding: 1rem;
        }

        .user-reply-form-container {
            margin-top: 1rem;
            padding: 0.75rem;
        }

        .reply-form-group textarea {
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }

    @media (max-width: 600px) {
        .support-header h3 {
            font-size: 1.1rem;
        }

        .message-title {
            font-size: 1rem;
        }

        .message-card {
            border-left-width: 3px !important;
        }

        .conversation-thread {
            gap: 0.75rem;
        }

        .message-bubble {
            padding: 0.75rem;
        }

        .message-solved-notice {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<script>
    function handleReplySubmit(e) {
        e.preventDefault();
        const form = e.target;
        const textarea = form.querySelector('textarea');
        const successMessage = form.querySelector('.reply-success-message');
        const submitButton = form.querySelector('.btn-submit-user-reply');

        // Validate only this form's textarea
        if (!textarea.value.trim()) {
            textarea.classList.add('error-border');
            const errorSpan = form.querySelector('.error-text') || document.createElement('span');
            if (!form.querySelector('.error-text')) {
                errorSpan.className = 'error-text';
                errorSpan.textContent = 'Reply message is required.';
                textarea.parentElement.appendChild(errorSpan);
            }
            return false;
        }

        // Remove error styling if any
        textarea.classList.remove('error-border');
        const existingError = form.querySelector('.error-text');
        if (existingError && !existingError.textContent.includes('server')) {
            existingError.remove();
        }

        // Show success message
        if (successMessage) {
            successMessage.style.display = 'block';
        }

        // Disable button
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.style.opacity = '0.6';
            submitButton.style.cursor = 'not-allowed';
        }

        // Submit the form after a short delay
        setTimeout(() => {
            form.submit();
        }, 1500);
    }
</script>
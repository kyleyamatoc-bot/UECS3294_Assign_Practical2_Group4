<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.index');
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::create([
            'user_id' => auth()->id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'inquiry_type' => $request->inquiry_type,
            'priority' => $request->priority,
            'message' => $request->message,
        ]);

        return redirect()->route('contact.thankyou')->with('status', 'Thank you, your message has been sent.');
    }

    public function thankYou()
    {
        return view('contact.thank-you');
    }

    public function reply(Request $request, ContactMessage $message)
    {
        // Verify user owns this message
        if ($message->user_id !== auth()->id()) {
            return back()->withErrors(['error' => 'Unauthorized']);
        }

        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        ContactReply::create([
            'contact_message_id' => $message->id,
            'user_id' => auth()->id(),
            'reply_message' => $validated['reply_message'],
            'reply_type' => 'user',
        ]);

        return back()->with('status', 'Your reply has been sent to the admin.');
    }
}

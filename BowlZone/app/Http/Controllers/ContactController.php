<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactMessageRequest;
use App\Models\ContactMessage;

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
            'phone' => $request->phone,
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
}

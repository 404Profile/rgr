<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();

        return Inertia::render('Contact', [
            'contact' => $contact
        ]);
    }

    public function send(ContactRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

//        Mail::to(config('mail.from.address'))->send(new ContactFormMail($request->all()));

        return redirect()->back()->with('success', 'Сообщение успешно отправлено');
    }
}

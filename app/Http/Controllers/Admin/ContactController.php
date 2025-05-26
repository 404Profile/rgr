<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Contacts/Create');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        Contact::create($data);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Контактная информация успешно создана');
    }

    public function edit()
    {
        $contact = Contact::first();

        return Inertia::render('Admin/Contacts/Edit', [
            'contact' => $contact
        ]);
    }

    public function update(UpdateContactRequest $request)
    {
        $data = $request->validated();

        $contact = Contact::first();

        if ($contact) {
            $contact->update($data);
        } else {
            Contact::create($data);
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Контактная информация успешно обновлена');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Контактная информация успешно удалена');
    }

}

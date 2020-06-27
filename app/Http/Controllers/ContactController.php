<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Jobs\SendConfirmSubscriptionEmail;
use App\Models\Contact;
use App\Models\Field;
use App\Models\Lists;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Lists $lists)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Lists $lists)
    {
        return view('contacts.create', ['list' => $lists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactStoreRequest $request, Lists $lists)
    {
        $contactCreationArray = array_merge(
            $request->only(['email']),
            [
                'list_id' => $lists->id,
            ]
        );

        $contact = Contact::create($contactCreationArray);

        if ($request->fields) {
            foreach ($request->fields as $key => $value) {
                if ($value) {
                    $field = Field::find($key);
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }

        if ($request->confirmation_mail) {
            $contact->setAsUnsubscribed();
            SendConfirmSubscriptionEmail::dispatch($contact);
        }

        return redirect()->route('lists.show', $lists->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Lists $lists, Contact $contact)
    {
        return view('contacts.show', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists, Contact $contact)
    {
        return view('contacts.edit', ['list' => $lists, 'contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactUpdateRequest $request, Lists $lists, Contact $contact)
    {
        $contact->fields()->detach();
        if ($request->fields) {
            foreach ($request->fields as $key => $value) {
                if ($value) {
                    $field = Field::find($key);
                    $contact->fields()->attach($field, ['value' => $value]);
                }
            }
        }
        $contact->email = $request->email;
        $contact->save();

        return view('contacts.show', ['list' => $lists, 'contact' => $contact]);
    }

    public function unsubscribe(Lists $lists, Contact $contact)
    {
        $contact->subscribed = 0;
        $contact->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('lists.index');
    }
}

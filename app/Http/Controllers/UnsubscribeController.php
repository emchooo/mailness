<?php

namespace App\Http\Controllers;

use App\Contact;

class UnsubscribeController extends Controller
{
    public function unsubscribe($contact_uuid, $campaign_uuid = null)
    {
        $contact = Contact::where('uuid', $contact_uuid)->firstOrFail();

        $contact->subscribed = 0;
        $contact->unsubscribed_at = now();
        $contact->save();

        return view('lists.unsubscribe');
    }
}

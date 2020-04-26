<?php

namespace App\Http\Controllers;

use App\Contact;

class UnsubscribeController extends Controller
{
    public function unsubscribe($contact_uuid, $campaign_uuid = null)
    {
        $contact = Contact::where('uuid', $contact_uuid)->first();

        $contact->subscribed = 0;
        $contact->unsubscribed_at = now();
        $contact->save();

        // @todo if unsubsribed from campaign

        return view('lists.unsubscribe');
    }
}

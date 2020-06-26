<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignUnsubscribe;
use App\Models\Contact;

class UnsubscribeController extends Controller
{
    public function unsubscribe($contact_uuid, $campaign_uuid = null)
    {
        $contact = Contact::where('uuid', $contact_uuid)->firstOrFail();

        $contact->subscribed = 0;
        $contact->unsubscribed_at = now();
        $contact->unsubscribe_type = 'self';
        $contact->save();

        $campaign = Campaign::where('uuid', $campaign_uuid)->first();
        if ($campaign) {
            CampaignUnsubscribe::create([
                'campaign_id' => $campaign->id,
                'contact_id' => $contact->id,
            ]);
        }

        return view('lists.unsubscribe');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignOpen;
use App\Models\Contact;

class TrackOpenController extends Controller
{
    public function index($campaign_uuid, $contact_uuid)
    {
        $campaign = Campaign::where('uuid', $campaign_uuid)->first();

        $contact = Contact::where('uuid', $contact_uuid)->first();

        CampaignOpen::create([
            'campaign_id'   => $campaign->id,
            'contact_id'    => $contact->id,
        ]);
    }
}

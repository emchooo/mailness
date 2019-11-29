<?php

namespace App\Http\Controllers;

use App\CampaignClickLink;
use App\CampaignLink;
use App\Contact;

class TrackClickController extends Controller
{
    public function index($link_uuid, $contact_uuid)
    {
        // @todo add as Job
        $link = CampaignLink::where('uuid', $link_uuid)->first();

        $contact = Contact::where('uuid', $contact_uuid)->first();

        CampaignClickLink::create([
            'campaign_id'   => $link->campaign_id,
            'link_id'   => $link->id,
            'contact_id'    => $contact->id,
        ]);

        return redirect($link->link);
    }
}

<?php

namespace App\Http\Controllers;

use App\CampaignLink;
use Illuminate\Http\Request;

class TrackClickController extends Controller
{
    public function index($link_uuid, $contact_id = null)
    {
        $link = CampaignLink::where('uuid', $link_uuid)->first();

        // @todo save

    }
}

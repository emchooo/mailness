<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignClickLink;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Campaign::Where('status', 'sent')->orderBy('id','desc')->get();

        return view('reports.index', compact('reports'));
    }

    public function show(Campaign $campaign)
    {
        $unique_clicks = CampaignClickLink::where('campaign_id', $campaign->id)->distinct('contact_id')->count();
        return view('reports.show', compact('campaign', 'unique_clicks'));
    }

    public function opens(Campaign $campaign)
    {
        return view('reports.opens', compact('campaign'));
    }

    public function clicks(Campaign $campaign)
    {
        return view('reports.clicks', compact('campaign'));
    }

    public function unsubscribed(Campaign $campaign)
    {
        return view('reports.unsubscribed', compact('campaign'));
    }

    public function failed(Campaign $campaign)
    {
        return view('reports.failed', compact('campaign'));
    }
}

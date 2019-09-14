<?php

namespace App\Http\Controllers;

use App\Lists;
use App\Campaign;
use App\Jobs\SendCampaign;
use App\Mail\CampaignMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // @todo order and pagination
        $campaigns = Campaign::all();
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // @todo add validation
        $campaign = new Campaign();
        $campaign->status = $request->status ? $request->status : 'draft';
        $campaign->subject = $request->subject;
        $campaign->sending_name = $request->sending_name;
        $campaign->sending_email = $request->sending_email;
        $campaign->content = $request->content;
        $campaign->save();

        return redirect()->route('campaigns.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $lists = Lists::all();
        return view('campaigns.show', compact('campaign', 'lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        // @todo add validation
        $campaign->subject = $request->subject;
        $campaign->sending_name = $request->sending_name;
        $campaign->sending_email = $request->sending_email;
        $campaign->content = $request->content;
        $campaign->save();
    
        return redirect()->route('campaigns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('campaigns.index');
    }

    public function sendTestMail(Request $request, Campaign $campaign)
    {
        // @todo validation
        Mail::to($request->email)->queue(new CampaignMail($campaign));

        return back();
    }

    public function send(Request $request, Campaign $campaign)
    {
        // @todo validation - must have list
        // if campaign is sent
        foreach($request->lists as $key => $value) {
            $list = Lists::find($key);
            SendCampaign::dispatch($campaign, $list);
        }
    }

    public function duplicate(Campaign $campaign)
    {
        $new_campaign = $campaign->replicate();
        $new_campaign->status = 'draft';
        $new_campaign->save();

        return redirect()->route('campaigns.edit', $new_campaign->id);
    }
}

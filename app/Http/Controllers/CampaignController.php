<?php

namespace App\Http\Controllers;

use App\Lists;
use App\Campaign;
use App\Template;
use App\Jobs\SendCampaign;
use App\Mail\CampaignMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CampaignStoreRequest;
use App\Http\Requests\SendCampaignRequest;
use App\Http\Requests\SendTestMailRequest;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::orderBy('id', 'desc')->paginate(10);
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = Template::all();
        return view('campaigns.create', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignStoreRequest $request)
    {
        $content = '';
        if($request->template) {
            $template = Template::find($request->template);
            $content = $template->content;
        }

        $campaign = new Campaign();
        $campaign->status = $request->status ? $request->status : 'draft';
        $campaign->subject = $request->subject;
        $campaign->sending_name = $request->sending_name;
        $campaign->sending_email = $request->sending_email;
        $campaign->content = $content;
        $campaign->save();

        return redirect()->route('campaigns.edit', $campaign->id);
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
        // @todo refactor this
        if($campaign->status != 'draft') {
            return back();
        }
        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignStoreRequest $request, Campaign $campaign)
    {
        // @todo refactor this
        if($campaign->status != 'draft') {
            return back();
        }
        // @todo add validation
        $campaign->subject = $request->subject;
        $campaign->sending_name = $request->sending_name;
        $campaign->sending_email = $request->sending_email;
        $campaign->content = $request->content;
        $campaign->save();
    
        return redirect()->route('campaigns.show', $campaign->id);
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

    public function sendTestMail(SendTestMailRequest $request, Campaign $campaign)
    {
        Mail::to($request->email)->queue(new CampaignMail($campaign));

        return back()->with([ 'success' => 'Test mail sent!' ]);
    }

    public function send(SendCampaignRequest $request, Campaign $campaign)
    {
        // if campaign is sent
        foreach($request->lists as $key => $value) {
            $list = Lists::find($key);
            SendCampaign::dispatch($campaign, $list);
        }

        $campaign->status = 'sending';
        $campaign->save();

        return redirect()->route('campaigns.index');
    }

    public function duplicate(Campaign $campaign)
    {
        $new_campaign = $campaign->replicate();
        $new_campaign->status = 'draft';
        $new_campaign->save();

        return redirect()->route('campaigns.edit', $new_campaign->id);
    }
}

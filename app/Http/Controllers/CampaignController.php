<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\CampaignStoreRequest;
use App\Http\Requests\SendCampaignRequest;
use App\Http\Requests\SendTestMailRequest;
use App\Jobs\SendCampaign;
use App\Models\Lists;
use App\Mail\CampaignMail;
use App\Models\Service;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaigns = Campaign::query()
                        ->latest('id')
                        ->paginate()
                        ->onEachSide(3)
                        //@todo Add the Parameters to Appended
                        //while creating the pagination Url's
                        ->appends($request->only([]));

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = DB::table((new Template)->getTable())
                        ->pluck('name', 'id');

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
        $content = '<html>
        <head>
            <title></title>
        </head>
        <body></body>
        </html>
        ';

        if ($request->template) {
            $template = Template::find($request->template);
            $content = $template->content;
        }

        $creationArray = array_merge(
            $request->only(['subject', 'sending_name', 'sending_email']),
            [
                'content' => $content,
                'track_clicks'  => $request->track_clicks ? 0 : 1,
                'track_opens'   => $request->track_opens ? 0 : 1,
            ]
        );

        $campaign = Campaign::create($creationArray);

        return redirect()->route('campaigns.edit', $campaign->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        $lists = DB::table((new Lists)->getTable())
                        ->pluck('name', 'id');

        if ($campaign->isFinished()) {
            return redirect()->to(route('campaigns.report', $campaign->id));
        }

        return view('campaigns.show', compact('campaign', 'lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        if ($campaign->isNotDraft()) {
            return back();
        }

        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignStoreRequest $request, Campaign $campaign)
    {
        if ($campaign->isNotDraft()) {
            return back();
        }

        $updationArray = array_merge(
            $request->only(['subject', 'sending_name', 'sending_email', 'content']),
            [
                'track_clicks' => $request->track_clicks ? 1 : 0,
                'track_opens' => $request->track_opens ? 1 : 0,
            ]
        );

        $campaign->update($updationArray);

        return redirect()->route('campaigns.show', $campaign->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('campaigns.index');
    }

    public function sendTestMail(SendTestMailRequest $request, Campaign $campaign)
    {
        try {
            $config = Service::first()->getConfig();

            Mail::config($config)->to($request->email)->send(new CampaignMail($campaign->content));

            return back()->with(['success' => 'Test mail sent!']);
        } catch (\Exception $e) {
            return back()->with(['success' =>  $e->getMessage()]);
        }
    }

    public function send(SendCampaignRequest $request, Campaign $campaign)
    {
        if ($campaign->isNotDraft()) {
            return back()->with(['error' => 'Campaign must be in draft mode.']);
        }

        if (! Service::count()) {
            return back()->with(['error' => 'You need to setup sending options in settings first.']);
        }

        foreach ($request->lists as $key => $value) {
            $list = Lists::find($key);
            SendCampaign::dispatch($campaign, $list);
            $campaign->setTotalSentTo($list->contacts->count());
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

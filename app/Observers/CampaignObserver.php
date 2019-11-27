<?php

namespace App\Observers;

use App\Campaign;
use Illuminate\Support\Str;

class CampaignObserver
{
    /**
     * Handle the campaign "created" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function creating(Campaign $campaign)
    {
        $request = request();

        $campaign->status = $request->status ? $request->status : 'draft';
        $campaign->uuid = Str::uuid();
    }
}

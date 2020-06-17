<?php

namespace App\Observers;

use App\Models\Campaign;
use Illuminate\Support\Str;

class CampaignObserver
{
    /**
     * Handle the campaign "created" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function creating(Campaign $campaign)
    {
        $request = request();

        $campaign->status = $request->status ? $request->status : 'draft';
        $campaign->uuid = Str::uuid();
    }
}

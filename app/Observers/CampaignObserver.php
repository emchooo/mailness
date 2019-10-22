<?php

namespace App\Observers;

use App\Campaign;
use App\Template;

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
        $content = '';

        $request = request();
        
        $campaign->status = $request->status ? $request->status : 'draft';

        if($request->template) {
            $template = Template::find($request->template);
            $content = $template->content;
        }
        
        $campaign->content  = $content;
    }
}

<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Lists;
use App\Models\SendingLog;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    protected $list;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Lists $list)
    {
        $this->campaign = $campaign;
        $this->list = $list;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $config = Service::first(); //->getConfig();

        foreach ($this->list->contacts as $contact) {
            $send = SendingLog::create([
                'contact_id' => $contact->id,
                'campaign_id' => $this->campaign->id,
            ]);
            SendEmail::dispatch($send, $config);
        }

        SetCampaignAsSent::dispatch($this->campaign);
    }
}

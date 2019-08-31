<?php

namespace App\Jobs;

use App\Lists;
use App\Campaign;
use App\Jobs\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        // insert all contact to sending log
        foreach($this->list->contacts as $contact) {
            SendEmail::dispatch($contact, $this->campaign);
        }
    }
}

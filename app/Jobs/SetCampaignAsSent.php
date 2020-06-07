<?php

namespace App\Jobs;

use App\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetCampaignAsSent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    public $tries = 60 * 24;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->campaignIsSent()) {
            $this->release(60);

            return;
        }
        $this->campaign->setAsSent();
    }

    protected function campaignIsSent()
    {
        if ($this->campaign->totalSent->count() == $this->campaign->total_sent) {
            return true;
        }

        return false;
    }
}

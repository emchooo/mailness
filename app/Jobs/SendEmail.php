<?php

namespace App\Jobs;

use App\Campaign;
use App\Contact;
use App\Mail\CampaignMail;
use App\SendingLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    protected $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Campaign $campaign)
    {
        $this->campaign = $campaign;
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->contact->email)->send(new CampaignMail($this->campaign));
        // @todo if sent save to SendingLog
        SendingLog::where('contact_id', $this->contact->id)
            ->where('campaign_id', $this->campaign->id)
            ->update(['sent_at' => Carbon::now()]);
    }
}

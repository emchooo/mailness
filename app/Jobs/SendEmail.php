<?php

namespace App\Jobs;

use App\Contact;
use App\Campaign;
use Carbon\Carbon;
use App\SendingLog;
use App\Mail\CampaignMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        SendingLog::where('contact_id', $this->contact->id)
            ->where('campaign_id', $this->campaign->id)
            ->update(['sent_at' => Carbon::now()]);
    }
}

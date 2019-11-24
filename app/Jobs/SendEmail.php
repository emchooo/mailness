<?php

namespace App\Jobs;

use DOMDocument;
use App\Campaign;
use App\Contact;
use App\Mail\CampaignMail;
use App\SendingLog;
use Carbon\Carbon;
use Illuminate\Support\Str;
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
        $mail_content = $this->mailContent();

        Mail::to($this->contact->email)->send(new CampaignMail($mail_content));
        // @todo if sent save to SendingLog
        SendingLog::where('contact_id', $this->contact->id)
            ->where('campaign_id', $this->campaign->id)
            ->update(['sent_at' => Carbon::now()]);
    }

    /**
     * 
     */
    protected function mailContent()
    {
        if($this->campaign->track_clicks) {
            return $this->addContactIdToTrackingLinks();
        }
        return $this->campaign;
    }

    /**
     * 
     */
    protected function addContactIdToTrackingLinks()
    {
        $dom = new DOMDocument();

        $dom->loadHTML($this->campaign->content);

        foreach($dom->getElementsByTagName('body')[0]->getElementsByTagName('a') as $link) {

            $oldLink = $link->getAttribute('href');

            $newLink = $oldLink . '/' . $this->contact->id;

            $link->setAttribute('href',$newLink);
        }
        return $dom->saveHtml();
    }
}

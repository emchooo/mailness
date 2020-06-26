<?php

namespace App\Jobs;

use App\Jobs\Middleware\RateLimited;
use App\Mail\CampaignMail;
use App\Models\SendingLog;
use DOMDocument;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send;

    protected $config;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SendingLog $send, $config)
    {
        $this->send = $send;
        $this->config = $config;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail_content = $this->mailContent();

        try {
            Mail::config($this->config)->to($this->send->contact->email)->send(new CampaignMail($this->send->campaign, $this->send->id));
            $this->send->sent();
        } catch (Exception $exception) {
            $this->send->failed($exception->getMessage());
        }
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new RateLimited];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addDay();
    }

    protected function mailContent()
    {
        if ($this->send->campaign->track_clicks) {
            return $this->addContactIdToTrackingLinks();
        }

        return $this->send->campaign->content;
    }

    protected function addContactIdToTrackingLinks()
    {
        $dom = new DOMDocument();

        $dom->loadHTML($this->send->campaign->content);

        foreach ($dom->getElementsByTagName('body')[0]->getElementsByTagName('a') as $link) {
            $oldLink = $link->getAttribute('href');

            $newLink = $oldLink.'/'.$this->send->contact->uuid;

            $link->setAttribute('href', $newLink);
        }

        return $dom->saveHtml();
    }
}

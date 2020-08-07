<?php

namespace App\Jobs;

use App\Jobs\Middleware\RateLimited;
use App\Mail\CampaignMail;
use App\Models\SendingLog;
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
        try {
            Mail::config($this->config->getConfig())->to($this->send->contact->email)->send(new CampaignMail($this->send, $this->config));
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
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SendingLog;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $send;

    protected $config;

    public $send_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SendingLog $send, $config)
    {
        $this->send = $send;
        $this->config = $config;
        $this->send_id = $send->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->html($this->getMailContent());
    }

    protected function getMailContent() {
        return $this->send->campaign->html_formated;
    }

}

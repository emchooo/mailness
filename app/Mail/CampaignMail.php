<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;

    public $send_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign, $send_id)
    {
        $this->content = $campaign->content;
        $this->send_id = $send_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html($this->content);
    }
}

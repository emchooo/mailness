<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSendingMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // @todo if sending event is SES
        $event->message->getHeaders()->removeAll('X-SES-CONFIGURATION-SET');
        // @todo this mailness is hardcoded, pull from config
        $event->message->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', 'mailness');
    }
}

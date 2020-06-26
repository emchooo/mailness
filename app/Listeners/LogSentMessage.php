<?php

namespace App\Listeners;

use App\SendingLog;

class LogSentMessage
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
        // @todo only if SES
        // $sesMessageId = $event->message->getHeaders()->get('X-SES-Message-ID')->getValue();
        // $send_id = $event->data['send_id'];
        // SendingLog::where('id',$send_id)->update([ 'message_id' => $sesMessageId ]);
    }
}

<?php

namespace App\Http\Controllers\Notifications;

use App\Models\CampaignClickLink;
use App\Http\Controllers\Controller;
use App\Models\SendingLog;
use Aws\Sns\Message;
use Illuminate\Http\Request;

class SESNotificationsController extends Controller
{
    public function index(Request $request)
    {
        $message = Message::fromRawPostData();
        $payload = json_decode($message['Message'], true);

        if ($message['Type'] === 'SubscriptionConfirmation') {
            $this->confirmSubscription($message);

            return;
        }

        // @todo add this as Job

        $messageId = $payload['mail']['messageId'];
        $send = SendingLog::where('message_id', $messageId)->first();

        $this->handleEvent($payload, $send);
    }

    public function confirmSubscription($message)
    {
        file_get_contents($message['SubscribeURL']);
    }

    public function handleEvent($payload, $send)
    {
        $eventType = $payload['eventType'] ?? null;

        if (! $eventType) {
            return;
        }
        if (! $send) {
            return;
        }
        // @todo is this campaign set to track open and clicks ?
        if ($eventType == 'Click') {
            $this->handleClick($payload, $send);
        }
        if ($eventType == 'Open') {
            $this->handleOpen($send);
        }
        if ($eventType == 'Bounce' and $payload['bounce']['bounceType'] == 'Permanent') {
            $this->handleBounce($send);
        }
        if ($eventType == 'Complaint') {
            $this->handleComplaint($send);
        }
    }

    public function handleClick($payload, $send)
    {
        $link = $payload['click']['link'];
        CampaignClickLink::create([
            'campaign_id' => $send->campaign_id,
            'link' => $link,
            'contact_id' => $send->contact_id,
        ]);
    }

    public function handleOpen($send)
    {
        $send->opened();
        $send->campaign->opens()->create([
            'contact_id' => $send->contact_id,
            'campaign_id' => $send->campaign_id,
        ]);
    }

    public function handleBounce($send)
    {
        $send->bounced();
        $send->contact->setAsBounced();
    }

    public function handleComplaint($send)
    {
        $send->complaint();
        $send->contact->setAsComplaint();
    }
}

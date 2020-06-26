<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Lists;
use App\Models\SendingLog;

class DashboardController extends Controller
{
    public function show()
    {
        $contacts = Contact::count();
        $sent = SendingLog::count();
        $campaigns = Campaign::take(3)->orderBy('id', 'desc')->get();
        $lists = Lists::take(3)->orderBy('id', 'desc')->get();
        $complaint = 0;
        $bounced = 0;

        return view('dashboard.index', compact('contacts', 'sent', 'campaigns', 'lists', 'complaint', 'bounced'));
    }
}

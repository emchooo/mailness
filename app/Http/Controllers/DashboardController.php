<?php

namespace App\Http\Controllers;

use App\Contact;
use App\SendingLog;
use App\Campaign;

class DashboardController extends Controller
{
    public function show()
    {
        $contacts = Contact::count();
        $sent = SendingLog::count();
        $campaigns = Campaign::take(3)->get();

        return view('dashboard.index', compact('contacts', 'sent', 'campaigns'));
    }
}

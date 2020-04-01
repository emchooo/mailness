<?php

namespace App\Http\Controllers;
use App\Contact;
use App\SendingLog;

class DashboardController extends Controller
{
    public function show()
    {
        $contacts = Contact::count();
        $sent = SendingLog::count();

        return view('dashboard.index', compact('contacts', 'sent'));
    }
}

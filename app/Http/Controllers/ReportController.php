<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Campaign::Where('status', 'finished')->get();

        return view('reports.index', compact('reports'));
    }

    public function show(Campaign $campaign)
    {
        return view('reports.show', compact('campaign'));
    }
}

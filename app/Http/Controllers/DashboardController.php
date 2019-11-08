<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function show()
    {
        return view('dashboard.index');
    }
}

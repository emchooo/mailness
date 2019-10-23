<?php

namespace App\Http\Controllers;

use App\Lists;

class FormController extends Controller
{
    public function index(Lists $lists)
    {
        return view('forms.index', ['list' => $lists]);
    }

    public function hosted(Lists $lists)
    {
        return view('forms.hosted', ['list' => $lists]);
    }
}

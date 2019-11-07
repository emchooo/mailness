<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        $service = Service::first();

        return view('settings.index', compact('auth', 'service'));
    }

    public function update(SettingsUpdateRequest $request)
    {
        $auth = Auth::user();

        $auth->name = $request->name;
        $auth->email = $request->email;
        $auth->save();

        return back();
    }

    public function updateAWS(Request $request)
    {
        $service = Service::first();

        $service->key = $request->aws_id;
        if(strlen($request->aws_key) > 25) {
            $service->secret = $request->aws_key;
        }
        $service->save();

        return back();
    }
}

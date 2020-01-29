<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Service;
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

    public function sending()
    {
        return view('settings.sending');
    }

    public function aws()
    {
        return view('settings.aws');
    }

    public function smtp()
    {
        return view('settings.smtp');
    }

    public function saveSmtp(Request $request)
    {
        
        $service = new Service();
        $service->service = 'smtp';
        $service->credentials = json_encode([ 
            'host' => $request->host, 
            'port' => $request->port, 
            'username' => $request->username,
            'password' => $request->passsword,
            'encription' => $request->encription
            ]);
        $service->save();
    }

}

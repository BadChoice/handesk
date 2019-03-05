<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Team;

class SettingsController extends Controller
{
    public function edit(Settings $setting)
    {   
        $teams=Team::all();
        return view('settings.edit', ['settings' => $setting,'teams'=>$teams]);
    }

    public function update(Settings $setting)
    {   
        if(request()->slack_webhook_url!='')
            $this->validate(request(), [
            'slack_webhook_url' => 'url',
            ]);
        $setting->update(request()->all());

        return back();
    }
}

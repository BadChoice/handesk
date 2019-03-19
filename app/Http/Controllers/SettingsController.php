<?php

namespace App\Http\Controllers;

use App\Team;
use App\Settings;

class SettingsController extends Controller
{
    public function edit(Settings $setting)
    {
        $teams=Team::all();

        return view('settings.edit', ['settings' => $setting, 'teams'=>$teams]);
    }

    public function update(Settings $setting)
    {
        $this->validate(request(), [
        'slack_webhook_url' => 'nullable|url',
        ]);
        $setting->update(request()->all());

        return back();
    }
}

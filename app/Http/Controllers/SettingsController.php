<?php

namespace App\Http\Controllers;

use App\Settings;

class SettingsController extends Controller
{
    public function edit(Settings $setting)
    {
        return view('settings.edit', ['settings' => $setting]);
    }

    public function update(Settings $setting)
    {
        $this->validate(request(), [
           'slack_webhook_url' => 'url',
        ]);
        $setting->update(request()->all());

        return back();
    }
}

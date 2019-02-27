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
        $val_rule = [];
        if (request('slack_webhook_url')) {
            $val_rule['slack_webhook_url'] = 'url';
        }
        if (request('notification_api_url')) {
            $val_rule['notification_api_url'] = 'url';
        }
        $this->validate(request(), $val_rule);
        $is_notification_enabled = request('notification_api_enabled') ? 1 : 0;
        $requests = request()->all();
        $requests['notification_api_enabled'] = $is_notification_enabled;
        $setting->update($requests);
        return back();
    }
}

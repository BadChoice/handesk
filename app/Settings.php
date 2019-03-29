<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class Settings extends BaseModel
{
    use Notifiable;

    public function routeNotificationForSlack($full = false)
    {
        if ($full) {
            return $this->slack_webhook_url;
        }
        if ($this->slack_webhook_url) {
            return explode('?', $this->slack_webhook_url)[0];
        }

        return null;
    }

    // Return default team id for incoming tickets
    public static function defaultTeamId()
    {
        return Settings::first()->default_team_id ?? null;
    }
}

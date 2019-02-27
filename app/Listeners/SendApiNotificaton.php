<?php

namespace App\Listeners;

use App\Events\ApiNotificationEvent;
use App\Settings;
use GuzzleHttp\Client;

class SendApiNotificaton
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApiNotificationEvent  $event
     * @return void
     */
    public function handle(ApiNotificationEvent $event)
    {

        $this->notificationToolBox($event->data);
    }

    protected function notificationToolBox($data)
    {
        try {
            $client = new Client(['verify' => false]);
            $setting = Settings::first();
            if (!$setting->notification_api_enabled) {
                return false;
            }
            $api_url = $setting->notification_api_url;
            $api_token = $setting->notification_api_token;
            $response = $client->get($api_url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                ],
                'query' => $data,
            ]);
            if (200 == $response->getStatusCode()) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\User;

class AzureService
{
    protected $httpClient;
    protected $client_id;
    protected $client_secret;

    public function __construct()
    {
        $this->client_id = config('services.azure.client_id');
        $this->client_secret = config('services.azure.client_secret');
    }

    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }

    public function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.microsoft.com/v1.0/me/', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }
    public function asyncUserFromAzureAD($arrUser)
    {
        try {
            $user = User::where('azure_id', $arrUser['id'])->first();
            if (isset($user->id)) {
                return $user;
            } else {
                $data = [
                  'azure_id'          => $arrUser['id'],
                  'name'              => $arrUser['displayName'],
                  'username'          => $arrUser['displayName'],
                  'email'             => $arrUser['userPrincipalName'],
                  'displayName'       => $arrUser['displayName'],
                  'givenName'         => $arrUser['givenName'],
                  'jobTitle'          => $arrUser['jobTitle'],
                  'mail'              => $arrUser['mail'],
                  'mobilePhone'       => $arrUser['mobilePhone'],
                  'officeLocation'    => $arrUser['officeLocation'],
                  'surname'           => $arrUser['surname'],
                  'password'           => bcrypt('password'),
                  'userPrincipalName' => $arrUser['userPrincipalName']
                ];
                return User::create($data);
            }
        } catch (\Exception $e) {
            // dd($e);
            return false;
            // \Log::error($e->getMessage());
        }
    }
}
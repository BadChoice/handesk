<?php

namespace App\Services\Bitbucket;

use GuzzleHttp\Client;

class Bitbucket{

    const URL       = "https://api.bitbucket.org/2.0";
    private $token  = "a";

    protected function getClient(){
        return new Client([
                'auth' => [ env('BITBUCKET_USER'), env('BITBUCKET_PASSWORD')]
            ]);
    }

    /**
     * @param $repository string revo-pos/revo-back
     * @param $title string
     * @param $body string
     * @return mixed object Bitbucket Issue object
     */
    function createIssue($repository, $title, $body) {
        $response = $this->getClient()->post(static::URL . "/repositories/{$repository}/issues", [
            "form_params" => [
                "title" => $title,
                "body"  => $body
            ]
        ]);
        $responseJson = json_decode( $response->getBody() );
        return $responseJson;
    }
}
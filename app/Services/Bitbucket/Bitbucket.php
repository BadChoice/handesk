<?php

namespace App\Services\Bitbucket;

use App\Services\IssueCreator;
use GuzzleHttp\Client;

class Bitbucket implements IssueCreator{

    const URL       = "https://api.bitbucket.org/2.0";

    protected function getClient(){
        return new Client([
                'auth' => [ config('issues.credentials.user'), config('issues.credentials.password')]
            ]);
    }

    // https://confluence.atlassian.com/bitbucket/issues-resource-296095191.html
    // Try to fix it!
    /**
     * @param $repository string revo-pos/revo-back
     * @param $title string
     * @param $body string
     * @return mixed object Bitbucket Issue object
     */
    function createIssue($repository, $title, $body) {
        $response = $this->getClient()->post(static::URL . "/repositories/{$repository}/issues", [
            "form_params" => [
                "title"     => $title,
                "content"   => urlencode($body),
                //"content" => "This is a test content"
            ]
        ]);
        $responseJson = json_decode( $response->getBody() );
        return $responseJson;
    }
}
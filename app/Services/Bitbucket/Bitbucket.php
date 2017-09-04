<?php

namespace App\Services\Bitbucket;

use App\Services\IssueCreator;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Bitbucket implements IssueCreator{

    protected function getClient(){
        if( config('issues.credentials.driver') == "basic" )
            return $this->getBasicAuthClient();
        return $this->getOauthClient();
    }

    protected function getBasicAuthClient() {
        return new Client([
            'base_uri' => 'https://api.bitbucket.org/1.0/', //2.0 version gives an error for the content...
            'auth' => [config('issues.credentials.user'), config('issues.credentials.password')],
        ]);
    }

    protected function getOauthClient(){
        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key'    => config('issues.credentials.key'),
            'consumer_secret' => config('issues.credentials.secret'),
            'token'           => '',
            'token_secret'    => ''
        ]);
        $stack->push($middleware);
        return new Client([
            'base_uri' => 'https://api.bitbucket.org/1.0/', //2.0 version gives an error for the content...
            'handler' => $stack,
            'auth' => 'oauth',
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
        $response = $this->getClient()->post("repositories/{$repository}/issues", [
            "form_params" => [
                "title"   => $title,
                "content" =>  $body,
            ],
        ]);
        $responseJson = json_decode($response->getBody());
        return $responseJson;
    }
}
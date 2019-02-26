<?php

namespace App\Services\Bitbucket;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use App\Services\IssueCreator;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Bitbucket implements IssueCreator
{

    protected $auth;
    protected static $oauthParameters;

    public static function setOAuth($parameters)
    {
        static::$oauthParameters = $parameters;
    }

    public function __construct()
    {
        $this->auth = new \Bitbucket\API\Authentication\Basic(config('services.bitbucket.user'), config('services.bitbucket.password'));
    }

    public function createIssue($account, $repoSlug, $title, $content, $extra = [])
    {
        $issue = new \Bitbucket\API\Repositories\Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->create($account, $repoSlug, array_merge([
                'title'     => $title,
                'content'   => $content,
                'kind'      => 'task',
                'priority'  => 'major',
                'status'    => 'new'
            ], $extra))
        );
    }

    public function updateIssue($account, $repoSlug, $id, $fields)
    {
        $issue = new \Bitbucket\API\Repositories\Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->update($account, $repoSlug, $id, $fields)
        );
    }

    public function createComment($account, $repoSlug, $id, $comment)
    {
        $issue = new \Bitbucket\API\Repositories\Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->comments()->create($account, $repoSlug, $id, $comment)
        );
    }

    public function parseResponse($response)
    {
        return json_decode($response->getContent());
    }

    private function setAuth($class)
    {
        //$issue->setCredentials($this->auth);
        $class->getClient()->addListener(
            new \Bitbucket\API\Http\Listener\OAuth2Listener(static::$oauthParameters ?? [
                    'client_id'         => config('services.bitbucket.oauth.key'),
                    'client_secret'     => config('services.bitbucket.oauth.secret'),
                ])
        );
    }
}

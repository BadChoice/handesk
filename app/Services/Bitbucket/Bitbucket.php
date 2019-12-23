<?php

namespace App\Services\Bitbucket;

use App\Services\IssueCreator;
use App\Services\IssueTrackerException;
use Bitbucket\API\Authentication\Basic;
use Bitbucket\API\Http\Listener\OAuth2Listener;
use Bitbucket\API\Repositories\Issues;

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
        $this->auth = new Basic(config('services.bitbucket.user'), config('services.bitbucket.password'));
    }

    public function createIssue($account, $repoSlug, $title, $content, $extra = [])
    {
        $issue = new Issues();
        $this->setAuth($issue);

        return $this->parseResponse(
            $issue->create($account, $repoSlug, array_merge([
                'title'     => $title,
                'content'   => ['raw' => $content],
                'kind'      => 'task',
                'priority'  => 'major',
                'status'    => 'new',
            ], $extra))
        );
    }

    public function updateIssue($account, $repoSlug, $id, $fields)
    {
        $issue = new Issues();
        $this->setAuth($issue);

        return $this->parseResponse(
            $issue->update($account, $repoSlug, $id, $fields)
        );
    }

    public function createComment($account, $repoSlug, $id, $comment)
    {
        $issue = new Issues();
        $this->setAuth($issue);

        return $this->parseResponse(
            $issue->comments()->create($account, $repoSlug, $id, ['raw' => $comment])
        );
    }

    public function parseResponse($response)
    {
        $response = json_decode($response->getContent());
//        dd($response);
        if (isset($response->type) && $response->type == 'error') {
            throw new IssueTrackerException($response->error->message.':'.collect($response->error->fields)->map(function ($value, $key) {
                return $key.' => '.$value;
            })->implode("\n"));
        }

        return $response;
    }

    private function setAuth($class)
    {
        //$issue->setCredentials($this->auth);
        $class->getClient()->setApiVersion('2.0')->addListener(
            new OAuth2Listener(static::$oauthParameters ?? [
                    'client_id'         => config('services.bitbucket.oauth.key'),
                    'client_secret'     => config('services.bitbucket.oauth.secret'),
                ])
        );
    }
}

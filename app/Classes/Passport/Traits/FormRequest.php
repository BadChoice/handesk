<?php

namespace App\Classes\Passport\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

/**
 * Build The Credential
 */
trait FormRequest
{
    /**
     * @param array  $args
     * @param string $grantType
     *
     * @return mixed
     */
    public function buildCredentials(array $args = [], $grantType = 'password')
    {
        $args = collect($args);
        $credentials = $args->except('directive')->toArray();
        $credentials['client_id'] = $args->get('client_id', config('passport.access_client.id'));
        $credentials['client_secret'] = $args->get('client_secret', config('passport.access_client.secret'));
        $credentials['email'] = $args->get('username');
        $credentials['grant_type'] = $grantType;

        return $credentials;
    }

    /**
     * @param array $credentials
     *
     * @throws AuthenticationException
     *
     * @return mixed
     */
    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);

        return $decodedResponse;
    }
}

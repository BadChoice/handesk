<?php namespace App\Classes\Passport\Grants;

use App\Classes\Passport\Helpers\Provider;
use App\User;
use Hash;
use RuntimeException;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\RequestEvent;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class PasswordGrant extends AbstractGrant
{
    private $errorInvalidCode = 400;
    private $errorType = 'invalid_grant';

    /**
     * @param UserRepositoryInterface $userRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    )
    {
        $this->setUserRepository($userRepository);
        $this->setRefreshTokenRepository($refreshTokenRepository);
        $this->refreshTokenTTL = new \DateInterval('P1M');
    }

    /**
     * {@inheritdoc}
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        \DateInterval $accessTokenTTL
    )
    {
        $passportKey = \DB::table('oauth_clients')->where('provider', 'users')->first();

        if(!$passportKey){
            throw new OAuthServerException('Kredensial Passport tidak ditemukan', $this->errorInvalidCode, $this->errorType);
        }

        $clientId = $passportKey->id;

        // Validate request
        $client = $this->getClientEntityOrFail($clientId, $request);
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request));

        // Validate user
        $user = $this->validateUser($request, $client);
        $userId = $user?->id;
        // Finalize the requested scopes
        $scopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client, $userId);

        // Issue and persist new tokens
        $accessToken  = $this->issueAccessToken($accessTokenTTL, $client, $userId, $scopes);
        $this->getEmitter()->emit(new RequestEvent(RequestEvent::ACCESS_TOKEN_ISSUED, $request));
        $responseType->setAccessToken($accessToken);

        // Issue and persist new refresh token if given
        $refreshToken = $this->issueRefreshToken($accessToken);

        if ($refreshToken !== null) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::REFRESH_TOKEN_ISSUED, $request));
            $responseType->setRefreshToken($refreshToken);
        }
        // Inject tokens into response
        $responseType->setAccessToken($accessToken);
        $responseType->setRefreshToken($refreshToken);

        Provider::setProvider($this->getIdentifier(), $userId);

        return $responseType;
    }

    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $username = $this->getRequestParameter('username', $request);
        if (is_null($username)) {
            throw OAuthServerException::invalidRequest('username');
            throw new OAuthServerException('Gunakan username berupa email / no HP yang sesuai', $this->errorInvalidCode, $this->errorType);
        }

        $password = $this->getRequestParameter('password', $request);
        $user = $this->getUserEntityByUserPhone(
            $username,
            $password,
            $this->getIdentifier(),
            $client
        );

        return $user;
    }

    private function getUserEntityByUserPhone($email, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $provider = config('auth.guards.api.provider');

        if (is_null($model = config('auth.providers.'.$provider.'.model'))) {
            throw new RuntimeException('Tidak dapat menentukan model autentikasi dari konfigurasi.');
        }

        $user = (new $model)->where('email', $email)->first();
        
        if ( is_null($user) || !Hash::check($password, $user->password) ) {
            throw new OAuthServerException('Email/Kata Sandi tidak sesuai!', $this->errorInvalidCode, $this->errorType);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return 'password';
    }
}

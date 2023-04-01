<?php namespace App\Classes\Passport\Grants;

use Hash;
use RuntimeException;
use League\OAuth2\Server\RequestEvent;
use App\Classes\Passport\Helpers\Provider;
use Laravel\Passport\Bridge\User;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\Grant\AbstractGrant;
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
        $userId = $user->getIdentifier();
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
        }

        $password = $this->getRequestParameter('password', $request);
        if (is_null($password)) {
            throw OAuthServerException::invalidRequest('password');
        }
        
        $user = $this->getUserEntityByUserEmail($username, $password);

        return $user;
    }

    protected function getUserEntityByUserEmail($email, $password)
    {
        if (is_null($model = config('auth.providers.users.model'))) {
            throw new RuntimeException('Unable to determine user model from configuration.');
        }

        if (method_exists($model, 'findForPassport')) { // if you define the method in that model it will grab it from there other wise use email as key 
            $user = (new $model)->findForPassport($email);
        } else {
            $user = (new $model)->where('email', $email)->first();
        }

        if ( is_null($user) ) {
            throw new OAuthServerException('User belum terdaftar!', $this->errorInvalidCode, $this->errorType);
        }

        if ( !Hash::check($password, $user->password) ) {
            throw new OAuthServerException('Kata Sandi tidak sesuai!', $this->errorInvalidCode, $this->errorType);
        }

        return new User($user->getAuthIdentifier());
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return 'password';
    }
}

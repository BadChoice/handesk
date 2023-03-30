<?php namespace App\Providers;

use App\Classes\Passport\Grants\PasswordGrant;
use Illuminate\Auth\RequestGuard;
use Illuminate\Auth\TokenGuard;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Passport\Bridge\UserRepository;
use League\OAuth2\Server\ResourceServer;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\ClientRepository;

class PassportServiceProvider extends AuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::ignoreMigrations();
        Passport::routes();

        Passport::tokensExpireIn(now()->addYears(1));
        Passport::refreshTokensExpireIn(now()->addYears(1));
        Passport::personalAccessTokensExpireIn(now()->addYears(1));

        app(AuthorizationServer::class)->enableGrantType($this->makeDefaultGuard(), new \DateInterval('P1Y'));
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\RequestGuard
     */
    public function makeDefaultGuard()
    {
        return new PasswordGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );
    }
}

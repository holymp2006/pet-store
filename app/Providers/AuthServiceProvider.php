<?php

declare(strict_types=1);

namespace App\Providers;

use App\Guards\JwtGuard;
use Illuminate\Foundation\Application as App;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->app->singleton(Configuration::class, function (): Configuration {
            return Configuration::forSymmetricSigner(
                new Sha256(),
                InMemory::base64Encoded(base64_encode(config('services.jwt.secret')))
            );
        });
        Auth::provider('jwt_users', function (): JwtUserProvider {
            return new JwtUserProvider();
        });
        Auth::extend('jwt', function (App $app): JwtGuard {
            return new JwtGuard(
                new JwtUserProvider(),
                $app->make('request')
            );
        });
    }
}

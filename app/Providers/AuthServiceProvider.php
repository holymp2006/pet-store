<?php

declare(strict_types=1);

namespace App\Providers;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

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
    }
}

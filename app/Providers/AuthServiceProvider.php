<?php

declare(strict_types=1);

namespace App\Providers;

use App\Guards\JwtGuard;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
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
        Auth::viaRequest('jwt', function (Request $request): ?User {
            return (new JwtGuard($request))->user();
        });
    }
}
